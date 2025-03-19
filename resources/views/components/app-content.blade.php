@props([
    'title' => null,
    'subtitle' => null,
    'text' => null,
    'color' => 'neutral',
    'link' => null,
    'links' => null,
    'inverted' => false,
    'class' => null,
])

@php
    $mainColor = [
        'primary' => 'text-primary',
        'secondary' => 'text-secondary',
        'tertiary' => 'text-tertiary',
        'neutral' => 'text-foreground',
    ];
    $textColor = $inverted ? 'text-surface' : 'text-foreground/80';
    $titleColor = $inverted ? 'text-surface-strong' : 'text-foreground';
@endphp

<div class="flex flex-col items-start {{ $class }} max-w-[65ch]">
    @if ($subtitle)
        <small
            class="mb-1 text-lg font-semibold {{ $inverted ? $textColor : $mainColor[$color] }}">{{ $subtitle }}</small>
    @endif
    @if ($title)
        <x-app-headline class="{{ $titleColor }}">{{ $title }}</x-app-headline>
    @endif
    @if ($text)
        <x-app-paragraph class="mb-4 mt-2 {{ $textColor }}">{{ $text }}</x-app-paragraph>
    @endif
    @if ($link && !$links)
        <x-app-button class="mt-auto" uppercase :href="url($link['href'])" :label="$link['label']" :color="$inverted ? 'surface' : $color" />
    @endif
    @if ($links)
        <div class="flex flex-wrap gap-2 mt-auto">
            @foreach ($links as $link)
                <x-app-button :href="url($link['href'])" uppercase :label="$link['label']" :color="$inverted ? 'surface' : $color" :variant="$loop->iteration > 1 ? 'outline' : 'solid'" />
            @endforeach
        </div>
    @endif
</div>
