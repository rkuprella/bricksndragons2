@props(['links' => []])

<nav aria-label="breadcrumb">
    <ol class="flex items-center gap-2">
        @foreach ($links as $index => $link)
            @if ($index !== array_key_last($links))
                <li class="flex items-center gap-2">
                    <a wire:navigate href="{{ $link['url'] }}"
                        class="text-foreground/80 hover:text-foreground transition hover:underline">{{ $link['label'] }}</a>
                    <svg class="size-4 text-foreground/50" data-slot="icon" aria-hidden="true" fill="none"
                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="m8.25 4.5 7.5 7.5-7.5 7.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </li>
            @else
                <li class="text-primary font-semibold">{{ $link['label'] }}</li>
            @endif
        @endforeach
    </ol>
</nav>
