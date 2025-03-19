@props(['href', 'label', 'active' => false, 'color' => 'neutral', 'mobile' => false])

@php
    $colorClasses = [
        'primary' => 'text-primary hover:bg-foreground/5 hover:text-primary-strong',
        'secondary' => 'text-secondary hover:bg-foreground/5 hover:text-secondary-strong',
        'tertiary' => 'text-tertiary hover:bg-foreground/5 hover:text-tertiary-strong',
        'neutral' => 'text-foreground hover:bg-foreground/5 hover:text-foreground-strong',
    ];

    $colorActiveClasses = [
        'primary' => 'text-surface-strong bg-primary',
        'secondary' => 'text-surface-strong bg-secondary',
        'tertiary' => 'text-surface-strong bg-tertiary',
        'neutral' => 'text-surface-strong bg-foreground',
    ];

    $baseClasses = $mobile ? '' : '';
@endphp

<a wire:navigate href="{{ $href }}"
    class="{{ $active ? $colorActiveClasses[$color] : $colorClasses[$color] }} transition px-4 app-ring rounded-full py-2 font-semibold {{ $baseClasses }}">
    {{ $label }}
</a>
