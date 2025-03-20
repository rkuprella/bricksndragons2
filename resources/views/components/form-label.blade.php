@props(['label', 'for', 'required' => false])

@if ($label)
    <label for="{{ $for }}" class="text-sm text-foreground/80">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
