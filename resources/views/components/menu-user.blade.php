@props(['side' => 'left', 'class' => ''])

<x-menu-drawer :side="$side" :class="$class">
    <x-slot:buttonIcon>
        <svg data-slot="icon" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
            class="size-6">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0Zm-5-2a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM8 9c-1.825 0-3.422.977-4.295 2.437A5.49 5.49 0 0 0 8 13.5a5.49 5.49 0 0 0 4.294-2.063A4.997 4.997 0 0 0 8 9Z">
            </path>
        </svg>
    </x-slot:buttonIcon>
    <x-slot:header>
        <div class="flex items-center gap-2">
            <svg data-slot="icon" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true" class="size-6">
                <path clip-rule="evenodd" fill-rule="evenodd"
                    d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0Zm-5-2a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM8 9c-1.825 0-3.422.977-4.295 2.437A5.49 5.49 0 0 0 8 13.5a5.49 5.49 0 0 0 4.294-2.063A4.997 4.997 0 0 0 8 9Z">
                </path>
            </svg>
            <div class="text-lg font-semibold"> {{ Auth::user()->name }}</div>
        </div>
    </x-slot:header>

    <x-slot:footer>
        <livewire:auth.logout />
    </x-slot:footer>
</x-menu-drawer>
