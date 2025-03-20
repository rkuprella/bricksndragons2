@props([
    'label',
    'model',
    'searchString',
    'searchType',
    'items' => [],
    'selected' => [],
    'available' => [],
    'canCreate' => false,
    'createMethod' => '',
    'required' => false,
])

<div class="relative flex flex-col gap-1">

    <x-form-label for="{{ $model }}" :label="$label" :required="$required" />
    <!-- Search Input -->
    <input id="{{ $model }}" type="text" wire:model.live.debounce.300ms="{{ $searchString }}"
        wire:keydown.enter.prevent="selectItem('{{ $searchType }}', '{{ $items->first()?->id }}')"
        placeholder="Search {{ ucfirst($searchType) }}..."
        class="py-2 px-3 rounded-full bg-neutral border border-foreground/50 text-foreground app-ring transition"
        autocomplete="off">

    <!-- Search Results Dropdown -->
    @if (!empty($searchString) && $items->isNotEmpty())
        <div class="relative z-10 bg-white text-black border rounded-md shadow-md mt-1 p-2 max-h-40 overflow-y-auto">
            @foreach ($items as $item)
                <div class="cursor-pointer p-2 hover:bg-gray-200"
                    wire:click="selectItem('{{ $searchType }}', {{ $item->id }})">
                    {{ $item->name }}
                </div>
            @endforeach
        </div>
    @endif

    <!-- Create New Category Button -->
    @if ($canCreate && $createMethod)
        <x-app-button wire:click="{{ $createMethod }}" color="primary"
            label="+ {{ ucfirst($this->{$searchString}) }}" />
    @endif
</div>

<!-- ✅ Quick Add: Available Categories/Styles (Click to Add) -->
@if ($available->isNotEmpty())
    <div class="flex flex-wrap gap-2 mt-2">
        @foreach ($available as $item)
            <button type="button" wire:click="selectItem('{{ $searchType }}', {{ $item->id }})"
                class="bg-gray-200 text-black px-3 py-1 rounded-full text-sm hover:bg-gray-300 transition">
                + {{ $item->name }}
            </button>
        @endforeach
    </div>
@endif

<!-- ✅ Selected Items (Pill Format) -->
@if (!empty($selected))
    <div class="flex flex-wrap gap-2 mt-2">
        @foreach ($selected as $selection)
            <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm flex items-center">
                {{ $selection['name'] }}
                <button type="button" wire:click="removeItem('{{ $searchType }}', {{ $selection['id'] }})"
                    class="ml-2 text-white hover:text-gray-300">
                    ✖
                </button>
            </span>
        @endforeach
    </div>
@endif

@error($searchString)
    <span class="text-danger text-sm">{{ $message }}</span>
@enderror

@error($model)
    <span class="text-danger text-sm">{{ $message }}</span>
@enderror
