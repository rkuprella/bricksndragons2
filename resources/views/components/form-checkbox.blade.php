@props(['model', 'label' => '', 'value' => null, 'color' => 'neutral'])

@php
    $colorClasses = [
        'primary' => 'checked:bg-primary border-primary',
        'secondary' => 'checked:bg-secondary border-secondary',
        'tertiary' => 'checked:bg-tertiary border-tertiary',
        'neutral' => 'checked:bg-foreground border-foreground',
        'danger' => 'checked:bg-danger border-danger',
    ];

@endphp

<label
    class="flex text-sm transition text-foreground/80 hover:text-foreground gap-2 items-center cursor-pointer rounded-xs">
    <div class="relative grid place-items-center">
        <input type="checkbox" wire:model.live="{{ $model }}"
            @if ($value) value="{{ $value }}" @endif
            class="transition peer size-5 lg:size-4 app-ring border-2 bg-transparent rounded-sm appearance-none {{ $colorClasses[$color] }}">
        <svg class="transition opacity-0 peer-checked:opacity-100 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 text-surface size-2.5"
            data-slot="icon" fill="none" stroke-width="4" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"></path>
        </svg>
    </div>
    <div>{{ $label }}</div>
</label>
