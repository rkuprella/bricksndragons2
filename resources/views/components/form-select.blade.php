@props([
    'label' => '',
    'model',
    'options' => [],
    'change' => '',
    'inline' => false,
    'class' => '',
    'size' => 'medium',
    'color' => 'neutral',
    'required' => false,
])

@php
    $sizeTextClasses = [
        'small' => 'pl-2.5 pr-8 py-1 text-sm font-semibold ',
        'medium' => 'pl-3 pr-8 py-1.5 text-base font-semibold ',
        'large' => 'pl-4 pr-10 py-2.5 text-lg font-semibold ',
    ];
    $sizeIconClasses = [
        'small' => 'right-1 bottom-2 size-6',
        'medium' => 'right-1.5 bottom-2 size-5',
        'large' => 'right-2 bottom-3 size-6',
    ];
    $colorTextClasses = [
        'neutral' => 'text-foreground bg-neutral border border-foreground/50',
        'primary' => 'text-surface bg-primary',
        'secondary' => 'text-surface bg-secondar',
        'tertiary' => 'text-surface bg-tertiary',
    ];
    $colorIconClasses = [
        'neutral' => 'text-foreground',
        'primary' => 'text-surface',
        'secondary' => 'text-surface',
        'tertiary' => 'text-surface',
    ];
@endphp

<div class="relative max-w-xs {{ $class }} {{ $inline ? 'flex items-center gap-2' : 'flex flex-col gap-2' }}"
    {{ $attributes }}>
    <x-form-label for="{{ $model }}" :label="$label" :required="$required" />
    <select id="{{ $model }}" wire:model.fill="{{ $model }}" {{ $change ? 'wire:change=' . $change : '' }}
        class="app-ring cursor-pointer transition {{ $colorTextClasses[$color] }} rounded-md {{ $sizeTextClasses[$size] }} appearance-none">
        @foreach ($options as $id => $name)
            <option value="{{ $id }}">
                {{ $name }}
            </option>
        @endforeach
    </select>
    <svg class="absolute {{ $sizeIconClasses[$size] }} {{ $colorIconClasses[$color] }} pointer-events-none"
        data-slot="icon" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z">
        </path>
    </svg>
</div>
