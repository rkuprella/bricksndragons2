@props(['items', 'orderList'])

@php
    $isCollection = $items->isNotEmpty() && optional($items->first()->itemSubType)->collection;
@endphp

<div class="flex flex-col gap-4" id="item-list">
    <ul
        class="grid {{ $isCollection ? 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-3' : 'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-6' }} gap-1">
        @forelse ($items as $item)
            <li wire:key="{{ $item->id }}" class="flex flex-col">
                <x-item-card :item="$item" :orderList="$orderList" />
            </li>
        @empty
            <p class="text-foreground-muted">No items found.</p>
        @endforelse
    </ul>
    <div>{{ $items->links('vendor.pagination.tailwind') }}</div>
</div>
