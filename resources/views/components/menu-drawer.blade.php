@props([
    'side' => 'left',
    'buttonLabel' => null,
    'header' => null,
    'buttonIcon' => null,
    'footer' => null,
    'iconBadge' => null,
])

@php
    $sideClasses = [
        'left' => 'left-0',
        'right' => 'right-0',
    ];
    $sideTransitionClasses = [
        'left' => '-translate-x-full',
        'right' => 'translate-x-full',
    ];
@endphp
<div x-data="{
    open: false,
    startX: 0,
    endX: 0,
    handleTouchStart(event) {
        this.startX = event.touches[0].clientX;
    },
    handleTouchEnd(event) {
        this.endX = event.changedTouches[0].clientX;
        let swipeDistance = this.startX - this.endX;

        if ('{{ $side }}' === 'right' && swipeDistance < -50) {
            this.open = false; // Swiping RIGHT closes the LEFT drawer
        }
        if ('{{ $side }}' === 'left' && swipeDistance > 50) {
            this.open = false; // Swiping LEFT closes the RIGHT drawer
        }
    }
}" @touchstart.window="handleTouchStart" @touchend.window="handleTouchEnd"
    @keydown.escape.window="open = false" {{ $attributes }}>
    <x-app-button @click="open = true" x-cloak variant="{{ $buttonLabel ? 'solid' : 'ghost' }}" label="{{ $buttonLabel }}"
        :badge="$iconBadge">
        @if ($buttonIcon)
            {{ $buttonIcon }}
        @else
            <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5">
                </path>
            </svg>
        @endif
    </x-app-button>
    <!-- Background Overlay -->
    <div x-show="open" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 transition bg-black/60">
    </div>
    <!-- Drawer -->
    <aside x-show="open" x-cloak x-transition:enter="ease-out duration-300"
        x-transition:enter-start="{{ $sideTransitionClasses[$side] }}" x-transition:enter-end="translate-x-0"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="{{ $sideTransitionClasses[$side] }}"
        class="fixed inset-y-0 w-72 transition {{ $sideClasses[$side] }} bg-surface-strong shadow-lg p-4 z-50 flex flex-col gap-4"
        @click.outside="open = false">
        <header class="flex items-center gap-2">
            {{ $header }}
            <x-app-button @click="open = false" variant="ghost" class="ml-auto">
                <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                </svg>
            </x-app-button>
        </header>

        <div class="flex-1 flex flex-col gap-2 py-2 overflow-y-auto">
            {{ $slot }}
        </div>

        <footer>
            {{ $footer }}
        </footer>
    </aside>
</div>
