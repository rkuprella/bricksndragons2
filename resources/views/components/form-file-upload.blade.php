@props([
    'label' => '',
    'model',
    'required' => false,
    'accept' => '', // Example: 'image/*' or 'application/pdf'
    'class' => '',
])

<div class="flex flex-col gap-1 {{ $class }}">
    @if ($label)
        <label for="{{ $model }}" class="text-sm font-semibold text-foreground/80">
            {{ $label }} @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <input type="file" id="{{ $model }}" wire:model="{{ $model }}" {{ $required ? 'required' : '' }}
        accept="{{ $accept }}"
        class="px-3 py-2 rounded-md bg-neutral border border-foreground/50 text-foreground app-ring transition file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-primary file:text-white file:cursor-pointer hover:file:bg-primary-strong">

    @error($model)
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>
