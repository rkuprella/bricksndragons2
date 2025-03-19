@props(['images'])

<div>
    <label class="text-sm font-medium text-foreground-muted">Upload Images</label>
    <input type="file" wire:model="images" multiple
        class="w-full px-3 py-2 rounded-md bg-foreground text-surface border border-border focus:ring-2 focus:ring-primary">
</div>

@if (!empty($images))
    <div class="grid grid-cols-4 gap-2">
        @foreach ($images as $index => $image)
            <div class="relative">
                <img src="{{ $image->temporaryUrl() }}" class="w-full h-20 object-cover rounded-md">
                <button type="button" wire:click="removeImage({{ $index }})"
                    class="absolute top-0 right-0 bg-danger text-white px-2 py-1 rounded-md">✖</button>
            </div>
        @endforeach
    </div>
@endif
