<?php

use App\Models\Item;
use Livewire\Volt\Component;

new class extends Component {
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        if (strlen($this->query) > 1) {
            $this->results = Item::with(['itemType', 'categories'])
                ->where('name', 'like', '%' . $this->query . '%')
                ->orWhereHas('categories', function ($query) {
                    $query->where('name', 'like', '%' . $this->query . '%');
                })
                ->limit(10)
                ->get(['id', 'name', 'slug', 'images', 'item_type_id']);
        } else {
            $this->results = [];
        }
    }

    public function with()
    {
        return [
            'query' => $this->query,
            'results' => $this->results,
        ];
    }
}; ?>

<div x-data="{ open: false }" class="relative w-full max-w-md">
    <!-- Search Input -->
    <div class="relative w-full">
        <input type="search" wire:model.live.debounce.500ms="query" @focus="open = true"
            @click.outside="open = false; $wire.set('query', '')" placeholder="Search ..."
            class="py-2 pl-4 pr-8 transition rounded-full w-full placeholder:italic text-foreground bg-foreground/5 hover:bg-foreground/10 placeholder:text-foreground/50 focus:bg-foreground/10 app-ring">

        <svg data-slot="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true" class="absolute -translate-y-1/2 right-3 size-6 top-1/2 text-foreground/50">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z">
            </path>
        </svg>
    </div>

    <!-- Search Results Dropdown -->
    <div x-show="open && $wire.query.length > 1" x-cloak
        class="absolute mt-2 w-full bg-surface-strong rounded-md shadow-lg z-10 divide-y divide-foreground/10">

        @forelse ($results as $result)
            <a href="/{{ strtolower($result->itemType?->name_plural) }}/{{ $result->slug }}"
                class="flex group gap-2 px-4 py-2 items-center text-sm hover:bg-neutral-strong first:rounded-t-md last:rounded-b-md hover:text-foreground transition app-ring">
                @if (!empty($result->images) && is_array($result->images) && count($result->images) > 0)
                    <img src="{{ asset('storage/' . $result->images[0]) }}" alt="{{ $result->name }}"
                        class="size-12 transition group-hover:scale-150 object-cover rounded-md">
                @else
                    <img src="{{ asset('images/img-chest.png') }}" alt="No Image"
                        class="size-12 transition group-hover:scale-150 object-cover rounded-md">
                @endif
                <div class="flex flex-col gap-1">
                    <div class="font-semibold">{{ $result->name }}</div>
                    @if ($result->categories->count())
                        <div class="text-xs text-foreground/60">
                            {{ $result->categories->pluck('name')->implode(', ') }}
                        </div>
                    @endif
                </div>
            </a>
        @empty
            <div class="px-2 py-2 text-sm text-foreground/60">No results found.</div>
        @endforelse
    </div>
</div>
