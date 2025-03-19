@props([
    'label' => '',
    'model',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'class' => '',
])

<div class="relative flex flex-col gap-1 {{ $class }}" x-data="{ value: @entangle($model).live }">
    @if ($label)
        <label for="{{ $model }}" class="text-sm font-semibold text-foreground/80">
            {{ $label }} @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <input type="{{ $type }}" id="{{ $model }}" wire:model.live.debounce="{{ $model }}"
        placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
        class="py-2 rounded-md bg-neutral border border-foreground/50 text-foreground app-ring transition {{ $type === 'search' ? 'pl-4 pr-10' : 'px-4' }}" />
    @if ($type === 'search')
        <div class="absolute right-1 bottom-1/2 translate-y-1/2" x-show="value.length > 0" x-cloak>
            <x-app-button variant="ghost" @click="$wire.set('{{ $model }}', '')">
                <svg class="size-5" data-slot="icon" aria-hidden="true" fill="none" stroke-width="1.5"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </x-app-button>
        </div>
    @endif


    @error($model)
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>
