<?php

use App\Models\Style;
use App\Models\ItemType;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new #[Title('Edit Style')] class extends Component {
    use WithFileUploads;

    public Style $style;

    #[Validate('required|string|max:255')]
    public string $name;

    #[Validate('nullable|string')]
    public ?string $description = null;

    #[Validate('required|exists:item_types,id')]
    public ?int $item_type_id;

    #[Validate('nullable|string')]
    public ?string $tags = null;

    #[Validate('nullable|image|max:2048')]
    public $image = null;

    #[Validate('nullable|string')]
    public ?string $scale = null;

    public function mount(Style $style)
    {
        $this->style = $style;
        $this->name = $style->name;
        $this->description = $style->description;
        $this->item_type_id = $style->item_type_id;
        $this->tags = is_array($style->tags) ? implode(',', $style->tags) : '';
        $this->scale = $style->scale;
    }

    public function save()
    {
        $this->validate();

        // Handle Image Upload
        if ($this->image) {
            // Delete old image if exists
            if ($this->style->image) {
                Storage::disk('public')->delete($this->style->image);
            }
            $imagePath = $this->image->store('styles', 'public');
        } else {
            $imagePath = $this->style->image;
        }

        // Update the style
        $this->style->update([
            'name' => $this->name,
            'description' => $this->description,
            'item_type_id' => $this->item_type_id,
            'tags' => $this->tags ? explode(',', $this->tags) : [],
            'image' => $imagePath,
            'scale' => $this->scale,
        ]);

        return redirect()->route('styles')->with('success', 'Style updated successfully!');
    }

    public function with()
    {
        return [
            'itemTypes' => ItemType::pluck('name', 'id'),
        ];
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Edit Style</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-textarea label="Description" model="description" />

        <x-form-select label="Item Type" model="item_type_id" :options="$itemTypes" required />

        <x-form-input label="Tags (comma-separated)" model="tags" placeholder="Example: medieval, dungeon" />

        <x-form-select label="Scale" model="scale" :options="['microfig' => 'Microfig', 'minifig' => 'Minifig']" />

        <x-form-file-upload label="Upload New Image (optional)" model="image" />

        @if ($style->image)
            <div class="mt-2">
                <p class="text-sm text-foreground">Current Image:</p>
                <img src="{{ asset('storage/' . $style->image) }}" alt="Current Image"
                    class="mt-1 w-32 h-32 object-cover rounded-md">
            </div>
        @endif

        <x-app-button label="Update Style" type="submit" color="primary" />
    </form>
</div>
