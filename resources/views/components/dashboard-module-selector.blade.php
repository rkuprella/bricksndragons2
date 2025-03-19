@props(['selectedModules', 'availableModules'])

@foreach ($selectedModules as $index => $module)
    <div class="flex gap-2 items-center">
        <select wire:model="selectedModules.{{ $index }}.id">
            <option value="">-- Select Module --</option>
            @foreach ($availableModules as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        @error("selectedModules.$index.id")
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror

        <input type="number" wire:model="selectedModules.{{ $index }}.amount" min="1" placeholder="Amount">
        @error("selectedModules.$index.amount")
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror

        <button type="button" wire:click="removeModule({{ $index }})"
            class="bg-red-500 text-white px-2 py-1 rounded-md">✖</button>
    </div>
@endforeach

<button type="button" wire:click="addModule" class="bg-primary text-white px-3 py-1 rounded-md">+ Add
    Module</button>

@error('selectedModules')
    <span class="text-danger text-sm">{{ $message }}</span>
@enderror
