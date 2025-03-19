@props(['item', 'orderList' => []])

@php
    $image = $item->images[0] ?? '';
@endphp

@if (isset($orderList[$item->id]))
    <div class="flex items-center justify-between gap-2 w-full bg-secondary rounded-full text-surface">
        <x-app-button wire:click="decreaseItem({{ $item->id }})" variant="ghost" rounded color="surface">
            <svg class="size-5" data-slot="icon" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z"></path>
            </svg>
        </x-app-button>
        <input type="number" min="0" wire:model.live.debounce="orderList.{{ $item->id }}.quantity"
            wire:change="updateItemQuantity({{ $item->id }}, $event.target.value)"
            x-on:focus="$event.target.select()" x-on:keydown.enter="$event.target.blur()"
            class="py-1 w-full font-semibold hover:bg-foreground-strong/10 rounded-full text-center text-surface focus:outline-none">
        <x-app-button wire:click="addItem({{ $item->id }}, '{{ $item->name }}', '{{ $image }}')"
            variant="ghost" rounded color="surface">
            <svg class="size-5" data-slot="icon" fill="currentColor" viewBox="0 0 16 16"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path
                    d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z">
                </path>
            </svg>
        </x-app-button>
    </div>
@else
    <x-app-button wire:click="addItem({{ $item->id }}, '{{ $item->name }}', '{{ $image }}')"
        label="Add to order list" rounded color="link" size="small" center />
@endif
