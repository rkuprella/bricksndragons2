@props([
    'label' => '', // The label for the group
    'model', // Wire model binding (e.g. item_type)
    'options' => [], // Array of options (ID => Name)
    'change' => '', // Optional wire:change event
])

<div>
    <label class="text-sm font-medium text-foreground">{{ $label }}</label>
    <div class="flex flex-wrap gap-4 mt-2">
        @foreach ($options as $id => $name)
            <label class="flex items-center gap-2 cursor-pointer">
                <div class="relative grid place-items-center">
                    <input type="radio" wire:model="{{ $model }}" value="{{ $id }}"
                        {{ $change ? 'wire:change=' . $change : '' }}
                        class="transition peer size-4 border-2 bg-transparent border-primary rounded-full appearance-none focus:outline-none">
                    <div
                        class="transition opacity-0 peer-checked:opacity-100 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 bg-primary rounded-full size-2">
                    </div>
                </div>
                <span>{{ $name }}</span>
            </label>
        @endforeach
    </div>
</div>
