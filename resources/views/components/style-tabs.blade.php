@props(['styles', 'currentStyle', 'currentRoute', 'currentRoutePlural', 'click' => null])

<div class="flex flex-wrap items-center gap-2">
    @forelse ($styles as $style)
        <div class="relative group flex-1">
            <button type="button" wire:key="{{ $style->name }}" wire:click="{{ $click }}('{{ $style->name }}')"
                class="app-ring transition rounded-lg h-18 sm:h-24 lg:h-28 px-2 w-full border cursor-pointer {{ $style->name === $currentStyle ? 'bg-secondary border-secondary shadow-xl' : 'border-foreground/10' }}">
                <div
                    class="rounded-lg transition flex flex-col items-center justify-center relative {{ $style->name === $currentStyle ? 'text-surface-strong' : 'text-secondary opacity-50 group-hover:opacity-75' }}">
                    @if ($style->tags)
                        <div class="font-sans font-semibold italic text-sm">Style
                            {{ $loop->iteration }}</div>
                    @endif
                    <div class="px-2 text-2xl sm:text-4xl lg:text-5xl font-display">{{ $style->name }}</div>
                </div>
            </button>
        </div>
    @empty
        <x-page-hero-banner :title="$currentRoutePlural" />
    @endforelse
</div>
