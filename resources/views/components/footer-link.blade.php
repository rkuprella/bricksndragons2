@props(['href', 'label'])

<a wire:navigate href="{{ $href }}"
    class="inline-block px-3 py-1.5 font-semibold transition rounded-md app-ring text-foreground/80 hover:text-foreground visited:text-foreground/90 bg-neutral hover:bg-neutral-strong">
    {{ $label }}
</a>
