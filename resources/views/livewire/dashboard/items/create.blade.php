<?php

use App\Models\Item;
use App\Models\ItemType;
use App\Models\ItemSubType;
use App\Models\Category;
use App\Models\Style;
use App\Models\Theme;
use App\Models\User;
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title};

new #[Title('Create Item')] class extends Component {
    use WithFileUploads;

    public $name;
    public $item_type;
    public $item_sub_type;
    public $body;
    public $part_number;
    public $has_rare_parts = false;
    public $images = [];
    public array $imagePaths = [];

    public $csv_file;
    public array $parsedParts = [];
    public $searchCategory = '';
    public $searchStyle = '';
    public $searchTheme = '';

    public string $searchType = 'category';

    public array $selectedCategories = [];
    public array $selectedThemes = [];
    public array $selectedStyles = [];
    public array $selectedModules = [];
    public $selectedUserId;

    public function mount()
    {
        $queryType = request()->query('type', '');
        $querySubType = request()->query('subType', '');
        $queryStyle = request()->query('style', '');

        $this->item_type = ItemType::where('name', $queryType)->first()?->id ?? ItemType::first()?->id;

        $this->item_sub_type = ItemSubType::where('item_type_id', $this->item_type)->where('name', $querySubType)->first()?->id ?? ItemSubType::where('item_type_id', $this->item_type)->first()?->id;

        $style = Style::where('name', $queryStyle)->where('item_type_id', $this->item_type)->first();
        if ($style) {
            $this->selectedStyles[] = ['id' => $style->id, 'name' => $style->name];
        }

        $this->selectedUserId = Auth::id();
    }

    public function updateItemSubTypes()
    {
        $this->item_sub_type = ItemSubType::where('item_type_id', $this->item_type)->first()?->id;
    }

    public function updatedCsvFile()
    {
        $this->validate([
            'csv_file' => 'file|mimes:csv,txt|max:2048',
        ]);

        $this->processCsvFile();
    }

    public function addModule()
    {
        $this->selectedModules[] = ['id' => null, 'amount' => 1]; // Default empty module selection
    }

    public function removeModule($index)
    {
        unset($this->selectedModules[$index]);
        $this->selectedModules = array_values($this->selectedModules); // Reindex array
    }

    public function processCsvFile()
    {
        if (!$this->csv_file) {
            return;
        }

        // ✅ Read the CSV file
        $path = $this->csv_file->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // ✅ Use first row as headers

        $records = Statement::create()->process($csv);

        $this->parsedParts = [];

        foreach ($records as $record) {
            $this->parsedParts[] = [
                'part_number' => $record['Part Number'] ?? null,
                'quantity' => $record['Quantity'] ?? null,
            ];
        }

        // ✅ Save CSV to Storage
        $csvPath = 'csv/' . Str::random(10) . '.csv';
        Storage::disk('public')->put($csvPath, file_get_contents($path));

        // ✅ Store file path in database
        $this->csv_file = $csvPath;
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:items,name',
            'item_type' => 'required|exists:item_types,id',
            'item_sub_type' => 'required|exists:item_sub_types,id',
            'body' => 'nullable|string',
            'csv_file' => 'nullable|string',
            'images.*' => 'image|max:2048',
            'selectedCategories' => 'array',
            'selectedStyles' => 'array',
            'selectedThemes' => 'array',
            'selectedModules' => 'array',
            'selectedModules.*.id' => 'required|exists:items,id',
            'selectedModules.*.amount' => 'required|integer|min:1|max:255',
        ]);

        // ✅ Generate a unique slug
        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $count = 1;

        while (Item::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // ✅ Save images
        foreach ($this->images as $image) {
            $path = $image->store('items', 'public'); // Store images in storage/app/public/items
            $this->imagePaths[] = $path;
        }

        $item = Item::create([
            'name' => $this->name,
            'slug' => $slug,
            'item_type_id' => $this->item_type,
            'item_sub_type_id' => $this->item_sub_type,
            'user_id' => $this->selectedUserId,
            'csv_file' => $this->csv_file,
            'body' => $this->body,
            'images' => $this->imagePaths,
            'has_rare_parts' => $this->has_rare_parts,
            'part_number' => $this->part_number,
        ]);

        // ✅ Attach relationships
        $item->categories()->attach(collect($this->selectedCategories)->pluck('id')->toArray());
        $item->themes()->attach(collect($this->selectedThemes)->pluck('id')->toArray());
        $item->styles()->attach(collect($this->selectedStyles)->pluck('id')->toArray());

        // ✅ Attach Modules
        if (!empty($this->selectedModules)) {
            $syncData = [];
            foreach ($this->selectedModules as $module) {
                if (!empty($module['id'])) {
                    $syncData[$module['id']] = ['amount' => $module['amount']];
                }
            }
            $item->modules()->sync($syncData);
        }

        $this->reset(['name', 'body', 'part_number', 'has_rare_parts', 'images', 'imagePaths', 'selectedModules']);
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function removeItem($type, $id)
    {
        if ($type === 'category') {
            $this->selectedCategories = array_filter($this->selectedCategories, fn($c) => $c['id'] != $id);
        } elseif ($type === 'theme') {
            $this->selectedThemes = array_filter($this->selectedThemes, fn($c) => $c['id'] != $id);
        } elseif ($type === 'style') {
            $this->selectedStyles = array_filter($this->selectedStyles, fn($s) => $s['id'] != $id);
        }
    }

    public function selectItem($type, $id)
    {
        if ($type === 'category') {
            $category = Category::find($id);
            if ($category && !collect($this->selectedCategories)->contains('id', $category->id)) {
                $this->selectedCategories[] = ['id' => $category->id, 'name' => $category->name];
            }
        } elseif ($type === 'theme') {
            $theme = Theme::find($id);
            if ($theme && !collect($this->selectedThemes)->contains('id', $theme->id)) {
                $this->selectedThemes[] = ['id' => $theme->id, 'name' => $theme->name];
            }
        } elseif ($type === 'style') {
            $style = Style::where('id', $id)->where('item_type_id', $this->item_type)->first();
            if ($style && !collect($this->selectedStyles)->contains('id', $style->id)) {
                $this->selectedStyles[] = ['id' => $style->id, 'name' => $style->name];
            }
        }

        $this->searchCategory = '';
        $this->searchStyle = '';
        $this->searchTheme = '';
    }

    public function createCategory()
    {
        // Check if the category already exists
        $category = Category::where('name', ucfirst($this->searchCategory))->first();

        if ($category) {
            // If category exists but is NOT selected, re-add it
            if (!collect($this->selectedCategories)->contains('id', $category->id)) {
                $this->selectedCategories[] = ['id' => $category->id, 'name' => $category->name];
            }

            // ✅ Set an error message
            $this->addError('searchCategory', 'This category already exists.');

            // Clear search input
            $this->searchCategory = '';
            return;
        }

        // Create new category
        $category = Category::create([
            'name' => ucfirst($this->searchCategory),
        ]);

        // Add it to the selected list
        $this->selectedCategories[] = ['id' => $category->id, 'name' => $category->name];

        // Clear any previous errors
        $this->resetErrorBag('searchCategory');

        // Clear search input
        $this->searchCategory = '';
    }

    public function createTheme()
    {
        // Prevent duplicate names
        if (Theme::where('name', $this->searchTheme)->exists()) {
            return;
        }

        $theme = Theme::create([
            'name' => ucfirst($this->searchTheme),
        ]);

        // Add the new theme to the selected list
        $this->selectedThemes[] = ['id' => $theme->id, 'name' => $theme->name];

        // Clear search input
        $this->searchTheme = '';
    }

    public function createAndExit()
    {
        $this->create();
        return redirect()->route(strtolower(ItemType::find($this->item_type)?->name_plural), [
            'style' => collect($this->selectedStyles)->pluck('name')->implode(','),
            'sub-type' => ItemSubType::find($this->item_sub_type)?->name,
        ]);
    }

    public function createAndContinue()
    {
        $this->create();
        return redirect()->route('create-item', [
            'style' => collect($this->selectedStyles)->pluck('name')->implode(','),
            'type' => ItemType::find($this->item_type)?->name,
            'sub-type' => ItemSubType::find($this->item_sub_type)?->name,
        ]);
    }

    public function with(): array
    {
        $categoryResults =
            strlen($this->searchCategory) > 0
                ? Category::where('name', 'like', "{$this->searchCategory}%")
                    ->whereNotIn('id', collect($this->selectedCategories)->pluck('id'))
                    ->limit(10)
                    ->get(['id', 'name'])
                : collect();

        $themeResults =
            strlen($this->searchTheme) > 0
                ? Theme::where('name', 'like', "{$this->searchTheme}%")
                    ->whereNotIn('id', collect($this->selectedThemes)->pluck('id'))
                    ->limit(10)
                    ->get(['id', 'name'])
                : collect();
        return [
            'itemTypes' => ItemType::pluck('name', 'id'),
            'itemSubTypes' => ItemSubType::where('item_type_id', $this->item_type)->pluck('name', 'id'),
            'categoryResults' => $categoryResults,
            'availableCategories' => Category::whereHas('items', function ($query) {
                $query->where('item_sub_type_id', $this->item_sub_type);
            })
                ->whereNotIn('id', collect($this->selectedCategories)->pluck('id'))
                ->orderBy('name', 'asc')
                ->limit(30)
                ->get(['id', 'name']),
            'themeResults' => $themeResults,
            'availableThemes' => Theme::whereHas('items', function ($query) {
                $query->where('item_sub_type_id', $this->item_sub_type);
            })
                ->whereNotIn('id', collect($this->selectedThemes)->pluck('id'))
                ->orderBy('name', 'asc')
                ->limit(30)
                ->get(['id', 'name']),
            'styleResults' =>
                strlen($this->searchStyle) > 0
                    ? Style::where('name', 'like', "{$this->searchStyle}%")
                        ->where('item_type_id', $this->item_type) // ✅ Filter by item_type
                        ->whereNotIn('id', collect($this->selectedStyles)->pluck('id'))
                        ->limit(10)
                        ->get(['id', 'name'])
                    : collect(),
            'availableStyles' => Style::orderBy('name', 'asc')
                ->where('item_type_id', $this->item_type)
                ->whereNotIn('id', collect($this->selectedStyles)->pluck('id'))
                ->limit(30)
                ->get(['id', 'name']),
            'canCreateCategory' => strlen($this->searchCategory) > 1 && $categoryResults->isEmpty(),
            'canCreateTheme' => strlen($this->searchTheme) > 1 && $themeResults->isEmpty(),
            'availableModules' => Item::all()->pluck('name', 'id'),
            'users' => User::pluck('name', 'id')->toArray(),
        ];
    }
}; ?>

<div class="app-container bg-neutral p-6 rounded-lg shadow-2xl mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Create Item</h1>
    <form wire:submit="create" class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- categories --}}
        <section class="flex flex-col gap-4">
            <x-multi-select label="Categories" model="selectedCategories" searchString="searchCategory"
                searchType="category" :items="$categoryResults" :selected="$selectedCategories" :available="$availableCategories" :canCreate="$canCreateCategory"
                createMethod="createCategory" />
            @error('selectedCategories')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <x-multi-select label="Themes" model="selectedThemes" searchString="searchTheme" searchType="theme"
                :items="$themeResults" :selected="$selectedThemes" :available="$availableThemes" :canCreate="$canCreateTheme" createMethod="createTheme" />

            <x-multi-select label="Styles" model="selectedStyles" searchString="searchStyle" searchType="style"
                :items="$styleResults" :selected="$selectedStyles" :available="$availableStyles" />

            @error('selectedStyles')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
        </section>

        {{-- main content --}}
        <section class="flex flex-col gap-4">
            <x-form-input label="Name" model="name" required />

            <x-form-radio label="Item Type" model="item_type" :options="$itemTypes" change="updateItemSubTypes" />

            <x-form-select label="Item Sub Type" model="item_sub_type" :options="$itemSubTypes" />

            <x-form-checkbox model="has_rare_parts" label="Has rare parts?" />

            <x-dashboard-module-selector :selectedModules="$selectedModules" :availableModules="$availableModules" />

            <x-form-textarea label="Body" model="body" />

            <div class="grid grid-cols-2 gap-2">
                <x-app-button type="submit" wire:click.prevent="createAndExit" label="Create & Exit" color="primary" />
                <x-app-button type="submit" wire:click.prevent="createAndContinue" label="Create & Add Another"
                    variant="outline" color="primary" />
            </div>
        </section>

        {{-- uploads  --}}
        <section class="flex flex-col gap-4">
            <x-dashboard-image-upload label="Upload Images (multiple)" model="images" multi="true" />

            <x-dashboard-csv-upload :csv_file="$csv_file" />

            <x-form-input label="Part Number" model="part_number" />
            <x-form-input label="CSV File" model="csv_file" type="file" />



            <x-form-select label="Assign to User" model="selectedUserId" :options="$users" class="w-full" />

        </section>
    </form>
</div>
