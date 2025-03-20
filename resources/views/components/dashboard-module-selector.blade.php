@props(['selectedModules', 'availableModules'])

<div class="flex flex-col gap-2">
    @foreach ($selectedModules as $index => $module)
        <div class="flex gap-2 items-center">

            <x-form-select model="selectedModules.{{ $index }}.id" :options="$availableModules" />

            <x-form-input type="number" model="selectedModules.{{ $index }}.amount" min="1"
                placeholder="Amount" />

            <x-app-button wire:click="removeModule({{ $index }})" color="danger" variant="ghost">✖</x-app-button>
        </div>
    @endforeach

    <x-app-button wire:click="addModule" color="primary" label="+ Add Module" />
    @error('selectedModules')
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>
