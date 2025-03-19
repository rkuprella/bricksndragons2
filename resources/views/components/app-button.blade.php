@props([
    'href' => null,
    'external' => false,
    'type' => 'button',
    'variant' => 'solid',
    'color' => 'neutral',
    'size' => 'medium',
    'active' => false,
    'id' => null,
    'label' => null,
    'rounded' => false,
    'title' => null,
    'class' => null,
    'badge' => null,
    'uppercase' => false,
    'center' => false,
])

@php
    $sizeLabelClasses = [
        'small' => 'px-2.5 py-1 text-sm font-semibold ',
        'medium' => 'px-3 py-1.5 text-base font-semibold ',
        'large' => 'px-6 py-2.5 text-lg font-bold ',
    ];

    $baseClasses =
        'group shrink-0 cursor-pointer relative transition flex items-center gap-2 app-ring active:translate-y-px ' .
        ($label ? $sizeLabelClasses[$size] : 'p-1.5 aspect-square ') .
        ($rounded ? 'rounded-full ' : 'rounded-md ') .
        ($uppercase ? 'uppercase ' : '') .
        ($center ? 'justify-center ' : 'justify-start ');

    $colorClasses = [
        'primary' => [
            'solid' =>
                'text-surface bg-primary hover:bg-primary-strong border-2 border-primary hover:border-primary-strong active:border-primary active:bg-primary dark:hover:shadow-lg dark:hover:shadow-primary/25',
            'ghost' =>
                'text-primary hover:text-primary-strong hover:bg-foreground-strong/10 active:bg-foreground-strong/5',
            'outline' =>
                'border-2 border-primary ' .
                ($active
                    ? 'bg-primary text-surface'
                    : 'text-primary hover:bg-primary/20 active:bg-primary/10 dark:hover:shadow-lg dark:hover:shadow-primary/25'),
            'tab' => $active ? 'bg-primary text-surface' : 'bg-surface-strong text-primary/60 hover:text-primary',
        ],
        'secondary' => [
            'solid' =>
                'text-surface bg-secondary border-2 border-secondary hover:border-secondary-strong active:border-secondary hover:bg-secondary-strong active:bg-secondary dark:hover:shadow-lg dark:hover:shadow-secondary/25 ',
            'ghost' =>
                'text-secondary hover:text-secondary-strong hover:bg-foreground-strong/10 active:bg-foreground-strong/5',
            'outline' =>
                'border-2 border-secondary ' .
                ($active
                    ? 'bg-secondary text-surface'
                    : 'text-secondary hover:bg-secondary/20 active:bg-secondary/10 dark:hover:shadow-lg dark:hover:shadow-secondary/25'),
            'tab' => $active ? 'bg-secondary text-surface' : 'bg-surface-strong text-secondary/60 hover:text-secondary',
        ],
        'tertiary' => [
            'solid' =>
                'text-surface bg-tertiary border-2 border-tertiary hover:border-tertiary-strong active:border-tertiary hover:bg-tertiary-strong active:bg-tertiary dark:hover:shadow-lg dark:hover:shadow-tertiary/25 ',
            'ghost' =>
                'text-tertiary hover:text-tertiary-strong hover:bg-foreground-strong/10 active:bg-foreground-strong/5',
            'outline' =>
                'border-2 border-tertiary ' .
                ($active
                    ? 'bg-tertiary text-surface'
                    : 'text-tertiary hover:bg-tertiary/20 active:bg-tertiary/10 dark:hover:shadow-lg dark:hover:shadow-tertiary/25'),
            'tab' => $active ? 'bg-tertiary text-surface' : 'bg-surface-strong text-tertiary/60 hover:text-tertiary',
        ],
        'neutral' => [
            'solid' =>
                'text-foreground bg-neutral border-2 border-neutral hover:border-neutral-strong active:border-neutral hover:bg-neutral-strong active:bg-neutral',
            'ghost' =>
                'text-foreground hover:text-foreground-strong hover:bg-foreground-strong/10 active:bg-foreground-strong/5',
            'outline' =>
                'border-2 border-foreground ' .
                ($active
                    ? 'bg-foreground text-surface'
                    : 'text-foreground hover:bg-foreground/10 active:bg-foreground/5'),
            'tab' => $active
                ? 'bg-foreground text-surface-strong'
                : 'bg-surface-strong text-foreground/60 hover:text-foreground',
        ],

        'surface' => [
            'solid' =>
                'text-foreground bg-surface border-2 border-surface hover:border-surface-strong active:border-surface hover:bg-surface-strong active:bg-surface',
            'ghost' =>
                'text-surface hover:text-surface-strong hover:bg-foreground-strong/10 active:bg-foreground-strong/5',
            'outline' =>
                'border-2 border-surface ' .
                ($active ? 'bg-surface text-foreground' : 'text-surface hover:bg-surface/10 active:bg-surface/5'),
            'tab' => $active
                ? 'bg-surface text-foreground'
                : 'bg-surface-strong text-foreground/60 hover:text-foreground',
        ],
        'link' => [
            'solid' =>
                'text-foreground/80 bg-link border-2 border-link hover:border-link-strong hover:text-foreground active:border-link hover:bg-link-strong active:bg-link dark:hover:shadow-lg dark:hover:shadow-link-strong/25',
            'ghost' =>
                'text-foreground hover:text-foreground-strong hover:bg-foreground-strong/10 active:bg-foreground-strong/5',
            'outline' =>
                'border-2 border-foreground ' .
                ($active
                    ? 'bg-foreground text-surface'
                    : 'text-foreground hover:bg-foreground/10 active:bg-foreground/5 dark:hover:shadow-lg dark:hover:shadow-foreground/15'),
            'tab' => $active
                ? 'bg-foreground text-surface'
                : 'bg-surface-strong text-foreground/60 hover:text-foreground',
        ],
        'danger' => [
            'solid' =>
                'text-surface bg-danger border-2 border-danger hover:border-danger-strong active:border-danger hover:bg-danger-strong active:bg-danger dark:hover:shadow-lg dark:hover:shadow-danger-strong/25',
            'ghost' =>
                'text-danger hover:text-danger-strong hover:bg-foreground-strong/10 active:bg-foreground-strong/5',
            'outline' =>
                'border-2 border-danger ' .
                ($active
                    ? 'bg-danger text-surface'
                    : 'text-danger hover:bg-danger/20 active:bg-danger/10 dark:hover:shadow-lg dark:hover:shadow-danger/25'),
            'tab' => $active ? 'bg-danger text-surface' : 'bg-surface-strong text-danger/60 hover:text-danger',
        ],
        'warning' => [
            'solid' =>
                'text-surface bg-warning border-2 border-warning hover:border-warning-strong active:border-warning hover:bg-warning-strong active:bg-warning dark:hover:shadow-lg dark:hover:shadow-warning-strong/25',
            'ghost' =>
                'text-warning hover:text-warning-strong hover:bg-foreground-strong/10 active:bg-foreground-strong/5',
            'outline' =>
                'border-2 border-warning ' .
                ($active
                    ? 'bg-warning text-surface'
                    : 'text-warning hover:bg-warning/10 active:bg-warning/5 dark:hover:shadow-lg dark:hover:shadow-warning/25'),
            'tab' => $active ? 'bg-warning text-surface' : 'bg-surface-strong text-warning/60 hover:text-warning',
        ],
    ];

    $classes = $baseClasses . ' ' . $colorClasses[$color][$variant] . ' ' . $class;
@endphp

@if ($href)
    <a @if (!$external) wire:navigate @endif href="{{ url($href) }}" class="{{ $classes }}"
        {{ $id ? "id=$id" : '' }} {{ $title ? "title=$title" : '' }} {{ $attributes }}>
        {{ $slot }}
        @if ($label)
            <span>{{ $label }}</span>
        @endif
        @if ($badge)
            <x-app-badge :number="$badge" />
        @endif
    </a>
@else
    <button type="{{ $type }}" class="{{ $classes }}" {{ $id ? "id=$id" : '' }}
        {{ $title ? "title=$title" : '' }} {{ $attributes }}>
        {{ $slot }}
        @if ($label)
            <span>{{ $label }}</span>
        @endif
        @if ($badge)
            <x-app-badge :number="$badge" />
        @endif
    </button>
@endif
