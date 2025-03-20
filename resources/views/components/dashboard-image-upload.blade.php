@props([
    'model',
    'multi' => false, // Default to single image
    'class' => '',
    'label' => '',
    'required' => false,
])

<div x-data="{
    images: [],
    dragOver: false,
    handleFiles(files) {
        [...files].forEach(file => {
            let reader = new FileReader();
            reader.onload = e => {
                this.images.push(e.target.result);
            };
            reader.readAsDataURL(file);
            this.$wire.upload('{{ $model }}', file, () => {}, () => {});
        });
    }
}" class="relative flex flex-col gap-1 {{ $class }}">

    <x-form-label for="{{ $model }}" :label="$label" :required="$required" />

    <!-- Drag & Drop Upload Box -->
    <div class="relative p-4 rounded-md bg-neutral border border-foreground/50 text-foreground cursor-pointer"
        @dragover.prevent="dragOver = true" @dragleave.prevent="dragOver = false"
        @drop.prevent="dragOver = false; handleFiles($event.dataTransfer.files)">

        <input id="{{ $model }}" type="file" x-ref="fileInput" class="hidden" wire:model="{{ $model }}"
            @change="handleFiles($event.target.files)" {{ $multi ? 'multiple' : '' }}>

        <div class="text-center" @click="$refs.fileInput.click()">
            <span class="text-sm text-foreground">Click or drag & drop to upload</span>
        </div>
    </div>

    <!-- Image Previews -->
    <div class="grid grid-cols-4 gap-2 mt-4">
        <!-- Alpine.js Local Preview -->
        <template x-for="(image, index) in images" :key="index">
            <div class="relative">
                <img :src="image" class="w-full h-20 object-cover rounded-md">
                <button type="button" @click="images.splice(index, 1)"
                    class="absolute top-0 right-0 bg-danger text-white px-2 py-1 rounded-md">✖</button>
            </div>
        </template>

        <!-- Livewire Temporary Upload Preview -->
        @if (!empty($$model))
            @foreach ($$model as $index => $image)
                <div class="relative">
                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-20 object-cover rounded-md">
                    <button type="button" wire:click="removeImage({{ $index }})"
                        class="absolute top-0 right-0 bg-danger text-white px-2 py-1 rounded-md">✖</button>
                </div>
            @endforeach
        @endif
    </div>
</div>
