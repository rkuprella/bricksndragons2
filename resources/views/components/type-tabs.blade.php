@props(['tabs', 'currentSubType', 'click' => null])

<div class="flex relative flex-wrap gap-2 lg:border-b border-foreground/10">
    @foreach ($tabs as $tab)
        @php
            $isActive = $tab->name === $currentSubType;
            $isCollection = $tab->collection;
            $iconPath = $tab->icon_path;
        @endphp

        <button type="button" wire:key="{{ $tab->name }}" wire:click="{{ $click }}('{{ $tab->name }}')"
            class="relative cursor-pointer app-ring px-3 py-2 shrink-0 transition rounded-full lg:rounded-xs 
                   {{ $isActive ? 'text-foreground font-bold bg-neutral-strong lg:bg-transparent' : 'text-foreground/60 hover:text-foreground bg-surface-strong lg:bg-transparent' }}">
            <div class="flex items-center gap-2">
                <svg class="size-6 {{ $isCollection ? 'text-primary' : 'text-secondary' }}"
                    xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                    <path fill="currentColor" d="{{ $iconPath }}" />
                </svg>
                <span>{{ $tab->name_plural }}</span>
            </div>
            <div
                class="w-full h-0.5 bg-foreground absolute inset-x-0 bottom-0 {{ $isActive ? 'hidden lg:block' : 'hidden' }}">
            </div>
        </button>
    @endforeach
</div>
