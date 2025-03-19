<?php

use App\Models\Theme;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new #[Title('Create Theme')] class extends Component {
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string')]
    public ?string $description = null; // 2MB max size

    #[Validate('nullable|image|max:2048')]
    public $image = null;

    public function save()
    {
        $this->validate();

        // ✅ Handle Image Upload
        $imagePath = $this->image ? $this->image->store('themes', 'public') : null;

        Theme::create([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('themes')->with('success', 'Theme created successfully!');
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Create Theme</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-textarea label="Description" model="description" />

        <x-form-file-upload label="Upload Image" model="image" />

        <x-app-button label="Create Theme" type="submit" color="primary" />
    </form>
</div>
