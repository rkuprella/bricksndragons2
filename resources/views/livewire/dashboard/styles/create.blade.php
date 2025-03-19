<?php

use App\Models\Style;
use App\Models\ItemType;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new #[Title('Create Style')] class extends Component {
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    #[Validate('required|exists:item_types,id')]
    public ?int $item_type_id = null;

    #[Validate('nullable|string')]
    public ?string $tags = null;

    #[Validate('nullable|image|max:2048')]
    public $image = null;

    #[Validate('nullable|string')]
    public ?string $scale = null;

    public function save()
    {
        $this->validate();

        // Handle Image Upload
        $imagePath = $this->image ? $this->image->store('styles', 'public') : null;

        Style::create([
            'name' => $this->name,
            'description' => $this->description,
            'item_type_id' => $this->item_type_id,
            'tags' => $this->tags ? explode(',', $this->tags) : [],
            'image' => $imagePath,
            'scale' => $this->scale,
        ]);

        return redirect()->route('styles')->with('success', 'Style created successfully!');
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
    <h1 class="text-2xl font-bold text-foreground mb-4">Create Style</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-textarea label="Description" model="description" />

        <x-form-select label="Item Type" model="item_type_id" :options="$itemTypes" required />

        <x-form-input label="Tags (comma-separated)" model="tags" placeholder="Example: medieval, dungeon" />

        <x-form-select label="Scale" model="scale" :options="['microfig' => 'Microfig', 'minifig' => 'Minifig']" />

        <x-form-file-upload label="Upload Image" model="image" />

        <x-app-button label="Create Style" type="submit" color="primary" />
    </form>
</div>
