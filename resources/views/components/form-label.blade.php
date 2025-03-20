@props(['label', 'for', 'required' => false])

@if ($label)
    <label for="{{ $for }}" class="text-sm font-medium text-foreground-muted bg-red-800">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
