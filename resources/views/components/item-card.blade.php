@props(['item', 'orderList', 'featured' => false])

@php
    $route = match ($item->itemType->name) {
        'Terrain' => 'terrain',
        'Miniature' => 'miniatures',
        'Accessory' => 'accessories',
        'Brickventure' => 'brickventures',
        default => 'terrain',
    };

    $orderList = $orderList ?? [];
@endphp

<div
    class="relative group flex flex-col py-2 gap-3 rounded-xl transition flex-1 focus-within:z-50 {{ $featured ? '' : ' shadow-xl bg-neutral hover:bg-neutral-strong' }}">
    @if (!$featured)
        @role('editor')
            <ul
                class="hidden group-hover:flex gap-1 items-center justify-end absolute top-1 left-1 bg-surface-strong rounded-lg z-30 p-1">
                <li>
                    <x-app-button href="/dashboard/items/{{ $item->slug }}/edit" variant="ghost" small>
                        <svg data-slot="icon" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true" class="size-3">
                            <path
                                d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z">
                            </path>
                            <path
                                d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z">
                            </path>
                        </svg>
                    </x-app-button>
                </li>
                <li>
                    <x-app-button wire:click="deleteItem('{{ $item->slug }}')" wire:confirm="Delete item?" variant="ghost"
                        color="danger" small>
                        <svg data-slot="icon" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true" class="size-3">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z">
                            </path>
                        </svg>
                    </x-app-button>
                </li>
            </ul>
        @endrole
    @endif
    <div class="relative px-2 group-hover:scale-110 transition pointer-events-none">
        @if (!empty($item->images) && is_array($item->images) && count($item->images) > 0)
            <img src="{{ asset('storage/' . $item->images[0]) }}"
                class="w-full rounded-md object-cover {{ $item->itemSubType->collection || $featured ? '' : 'h-32' }}" />
        @else
            <img src="{{ asset('images/img-chest.png') }}"
                class="w-full rounded-md object-cover {{ $item->itemSubType->collection || $featured ? '' : 'h-32' }}" />
        @endif
    </div>
    <header class="flex flex-col gap-2 px-4 {{ $featured ? 'justify-start' : 'justify-end' }} flex-1">
        <div>
            @if (!$featured && $item->categories->isNotEmpty())
                <p class="text-xs text-foreground/80 italic">
                    {{ $item->categories->pluck('name')->implode(', ') }}
                </p>
            @endif
            <a wire:navigate href="/{{ $route }}/{{ $item->slug }}"
                class="block text-foreground rounded-md hover:text-foreground-strong app-ring hover:underline focus:outline-none {{ $featured ? 'text-lg md:text-xl lg:text-2xl text-center font-bold text-balance' : 'text-sm md:text-base lg:text-lg font-semibold' }}">{{ $item->name }}</a>
        </div>
        @if ($featured)
            <ul class="flex flex-wrap gap-2 justify-center">
                @foreach ($item->styles as $style)
                    <li class="px-2 py-0.5 bg-primary text-surface text-sm rounded-full">
                        {{ $style->name }}
                    </li>
                @endforeach
            </ul>
            <small class="text-center">{{ $item->created_at->diffForHumans() }}</small>
        @endif
    </header>
    @if (!$item->itemSubType->collection && !$featured)
        <footer class="mt-auto px-4 pb-2 flex flex-col gap-2">
            <x-item-order-button :item="$item" :orderList="$orderList" />
        </footer>
    @endif
</div>
