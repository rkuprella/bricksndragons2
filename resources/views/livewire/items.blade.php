<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Item;
use App\Models\Style;
use App\Models\Theme;
use App\Models\ItemSubType;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{On, Title};

new #[Title('NEEDS DYNAMIC TITLE!!!')] class extends Component {
    use WithPagination;

    public $search = '';
    public $subType = '';
    public $style = '';
    public array $selectedCategories = [];
    public array $selectedThemes = [];
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $routeType = 'Terrain';
    public $routeTypePlural = 'Terrain';
    public $route = 'terrain';
    public array $orderList = [];
    public $categories = '';
    public $themes = '';

    public $perPage = 12;
    public $perPageAmount = 12;

    protected $queryString = [
        'style' => ['except' => ''],
        'subType' => ['except' => '', 'as' => 'sub-type'],
        'categories' => ['except' => ''],
        'themes' => ['except' => ''],
        // 'selectedCategories' => ['except' => [], 'as' => 'categories'],
        // 'selectedThemes' => ['except' => [], 'as' => 'themes'],
    ];

    public function mount()
    {
        $routeDefaults = [
            'terrain' => ['routeType' => 'Terrain', 'plural' => 'Terrain', 'route' => 'terrain'],
            'miniatures' => ['routeType' => 'Miniature', 'plural' => 'Miniatures', 'route' => 'miniatures'],
            'accessories' => ['routeType' => 'Accessory', 'plural' => 'Accessories', 'route' => 'accessories'],
            'brickventures' => ['routeType' => 'Brickventure', 'plural' => 'Brickventures', 'route' => 'brickventures'],
        ];

        foreach ($routeDefaults as $routeName => $defaults) {
            if (request()->routeIs($routeName)) {
                $this->routeType = $defaults['routeType'];
                $this->routeTypePlural = $defaults['plural'];
                $this->route = $defaults['route'];
                break;
            }
        }

        $this->orderList = session()->get('orderList', []);

        $categories = request()->query('categories');
        $themes = request()->query('themes');

        $this->selectedCategories = $categories ? explode(',', $categories) : [];
        $this->selectedThemes = $themes ? explode(',', $themes) : [];

        $this->resetStyleFilters(true);
        $this->resetSubTypeFilters(true);
    }

    public function loadMore()
    {
        $this->perPage += $this->perPageAmount;
    }

    public function updatedSubType()
    {
        $this->resetFilters();
    }

    public function updatedStyle()
    {
        $this->resetFilters();
    }

    public function updatedSelectedCategories()
    {
        $this->categories = implode(',', $this->selectedCategories);
        $this->resetPage();
    }

    public function updatedSelectedThemes()
    {
        $this->themes = implode(',', $this->selectedThemes);
        $this->resetPage();
    }

    public function deleteItem(Item $item)
    {
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'editor')) {
            $item->delete();
            $this->resetStyleFilters();
            $this->resetSubTypeFilters();
        } else {
            session()->flash('error', 'You do not have permission to delete items.');
        }
    }

    public function setSortBy($sortOption)
    {
        $this->sortBy = $sortOption;
        if ($sortOption === 'created_at') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function setSubType($subType)
    {
        $this->subType = $subType;
        $this->resetSubTypeFilters();
    }

    // order items

    public function addItem($itemId, $name, $image, $modules = [])
    {
        if (!isset($this->orderList[$itemId])) {
            $this->orderList[$itemId] = [
                'id' => $itemId,
                'name' => $name,
                'image' => $image,
                'quantity' => 1,
            ];
        } else {
            $this->orderList[$itemId]['quantity']++;
        }

        $this->updateOrderList();
    }

    public function decreaseItem($itemId)
    {
        if (isset($this->orderList[$itemId])) {
            $this->orderList[$itemId]['quantity']--;

            if ($this->orderList[$itemId]['quantity'] <= 0) {
                unset($this->orderList[$itemId]);
            }
        }

        $this->updateOrderList();
    }

    private function updateOrderList()
    {
        session()->put('orderList', $this->orderList);
        $this->dispatch('$refresh');
        $this->dispatch('order-list-updated');
    }

    #[On('orderListUpdated')]
    public function refreshOrderList()
    {
        $this->orderList = session()->get('orderList', []);
    }

    public function updateItemQuantity($itemId, $quantity)
    {
        $quantity = max(0, (int) $quantity);

        if (isset($this->orderList[$itemId])) {
            $this->orderList[$itemId]['quantity'] = $quantity;
        }

        if ($this->orderList[$itemId]['quantity'] <= 0) {
            unset($this->orderList[$itemId]);
        }

        $this->updateOrderList();
    }

    // end order items

    public function resetStyleFilters($mounted = false)
    {
        // Check if the current item type has styles
        $hasStyles = Style::whereHas('itemType', function ($query) {
            $query->where('name', $this->routeType);
        })->exists();

        // If the type has styles, ensure a valid style is selected
        if ($hasStyles) {
            if (!Style::where('name', $this->style)->exists()) {
                $this->style =
                    Style::whereHas('itemType', function ($query) {
                        $query->where('name', $this->routeType);
                    })
                        ->pluck('name')
                        ->first() ?? '';
            }
        } else {
            // If no styles exist for this type, reset style selection
            $this->style = '';
        }

        // Get valid subTypes based on the existence of styles
        $validSubTypes = ItemSubType::whereHas('items', function ($query) use ($hasStyles) {
            $query->whereHas('itemType', function ($q) {
                $q->where('name', $this->routeType);
            });

            // If the type has styles, filter by the selected style
            if ($hasStyles) {
                $query->whereHas('styles', function ($q) {
                    $q->where('name', $this->style);
                });
            }
        })
            ->pluck('name')
            ->toArray();

        // Ensure the selected subType is valid
        if (!in_array($this->subType, $validSubTypes)) {
            $this->subType = $validSubTypes[0] ?? '';
        }

        if (!$mounted) {
            $this->resetFilters();
        }
    }

    public function resetSubTypeFilters($mounted = false)
    {
        // Check if the current item type has styles
        $hasStyles = Style::whereHas('itemType', function ($query) {
            $query->where('name', $this->routeType);
        })->exists();

        // Ensure the selected subType is valid
        if (!ItemSubType::where('name', $this->subType)->exists()) {
            $this->subType =
                ItemSubType::whereHas('items', function ($query) use ($hasStyles) {
                    $query->whereHas('itemType', function ($q) {
                        $q->where('name', $this->routeType);
                    });

                    // If the type has styles, filter by the selected style
                    if ($hasStyles) {
                        $query->whereHas('styles', function ($q) {
                            $q->where('name', $this->style);
                        });
                    }
                })
                    ->pluck('name')
                    ->first() ?? '';
        }

        if (!$mounted) {
            $this->resetFilters();
        }
    }

    public function resetFilters()
    {
        $this->selectedCategories = [];
        $this->selectedThemes = [];
        $this->categories = '';
        $this->themes = '';

        $this->resetPage();
        $this->dispatch('$refresh');
    }

    public function setStyle($style)
    {
        $this->style = $style;
        $this->resetStyleFilters();
    }

    public function getFilteredItems()
    {
        return Item::with('categories', 'themes', 'styles')
            ->whereHas('itemType', function ($query) {
                $query->where('name', $this->routeType);
            })
            ->whereHas('itemSubType', function ($query) {
                $query->where('name', $this->subType);
            })
            ->when($this->style, function ($query) {
                $query->whereHas('styles', function ($query) {
                    $query->where('name', $this->style);
                });
            })
            ->when($this->selectedCategories, function ($query) {
                $query->whereHas('categories', function ($query) {
                    $query->whereIn('name', $this->selectedCategories);
                });
            })
            ->when($this->selectedThemes, function ($query) {
                $query->whereHas('themes', function ($query) {
                    $query->whereIn('name', $this->selectedThemes);
                });
            })
            ->when($this->sortBy, function ($query) {
                $query->orderBy($this->sortBy, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    public function getFilteredCategories()
    {
        return Category::whereHas('items', function ($query) {
            $query
                ->whereHas('itemType', function ($query) {
                    $query->where('name', $this->routeType);
                })
                ->whereHas('itemSubType', function ($query) {
                    $query->where('name', $this->subType);
                })
                ->when($this->style, function ($q) {
                    $q->whereHas('styles', function ($q) {
                        $q->where('name', $this->style);
                    });
                });
        })
            ->pluck('name')
            ->toArray();
    }

    public function getFilteredThemes()
    {
        return Theme::whereHas('items', function ($query) {
            $query
                ->whereHas('itemType', function ($query) {
                    $query->where('name', $this->routeType);
                })
                ->whereHas('itemSubType', function ($query) {
                    $query->where('name', $this->subType);
                })
                ->when($this->style, function ($q) {
                    $q->whereHas('styles', function ($q) {
                        $q->where('name', $this->style);
                    });
                });
        })
            ->pluck('name')
            ->toArray();
    }

    public function with(): array
    {
        return [
            'filteredItems' => $this->getFilteredItems(),
            'filteredCategories' => $this->getFilteredCategories(),
            'filteredThemes' => $this->getFilteredThemes(),
            'styles' => Style::select('name', 'id', 'item_type_id', 'tags', 'image', 'description', 'scale')
                ->whereHas('itemType', function ($query) {
                    $query->where('name', $this->routeType);
                })
                ->distinct()
                ->get(),
            'subTypes' => ItemSubType::orderBy('priority', 'asc')
                ->whereHas('items', function ($query) {
                    $query
                        ->whereHas('itemType', function ($q) {
                            $q->where('name', $this->routeType);
                        })
                        ->when($this->style, function ($q) {
                            $q->whereHas('styles', function ($q) {
                                $q->where('name', $this->style);
                            });
                        });
                })
                ->select('name', 'id', 'name_plural', 'collection', 'icon_path')
                ->get(),
            'orderList' => $this->orderList,
        ];
    }
}; ?>

<x-control-board :items="$filteredItems" :categories="$filteredCategories" :themes="$filteredThemes" :tabs="$subTypes" :currentSubType="$subType"
    tabFunction="setSubType" :styles="$styles" :currentStyle="$style" styleFunction="setStyle" :route="$route"
    :currentRoute="$routeType" :currentRoutePlural="$routeTypePlural" :orderList="$orderList" :sortModel="$sortBy" />
