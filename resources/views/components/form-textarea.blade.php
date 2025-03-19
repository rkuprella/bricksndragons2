@props([
    'label' => '',
    'model',
    'placeholder' => '',
    'rows' => 4,
    'required' => false,
    'class' => '',
    'description' => '',
])

<div class="flex flex-col gap-1 {{ $class }}">
    @if ($label)
        <label for="{{ $model }}" class="text-sm font-semibold text-foreground/80">
            {{ $label }} @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    @if ($description)
        <span class="text-foreground/60 text-xs">{{ $description }}</span>
    @endif

    <textarea id="{{ $model }}" wire:model.live="{{ $model }}" rows="{{ $rows }}"
        placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
        class="px-3 py-2 rounded-md bg-neutral border border-foreground/50 text-foreground app-ring transition resize-none"></textarea>


    @error($model)
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>
