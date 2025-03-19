<?php

use App\Models\Theme;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new #[Title('Edit Theme')] class extends Component {
    use WithFileUploads;

    public Theme $theme;

    #[Validate('required|string|max:255')]
    public string $name;

    #[Validate('nullable|string')]
    public ?string $description = null;

    #[Validate('nullable|image|max:2048')]
    public $image = null;

    public function mount(Theme $theme)
    {
        $this->theme = $theme;
        $this->name = $theme->name;
        $this->description = $theme->description;
    }

    public function update()
    {
        $this->validate();

        // ✅ Handle Image Upload
        if ($this->image) {
            // Delete old image
            if ($this->theme->image) {
                Storage::disk('public')->delete($this->theme->image);
            }

            // Store new image
            $imagePath = $this->image->store('themes', 'public');
            $this->theme->image = $imagePath;
        }

        // ✅ Update Theme
        $this->theme->update([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->theme->image, // Only update if a new image was uploaded
        ]);

        return redirect()->route('themes')->with('success', 'Theme updated successfully!');
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Edit Theme</h1>

    <form wire:submit="update" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-textarea label="Description" model="description" />

        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium text-foreground-muted">Current Image</label>
            @if ($theme->image)
                <img src="{{ asset('storage/' . $theme->image) }}" class="w-24 h-24 object-cover rounded-md">
                <p class="text-xs text-foreground/70">Uploading a new image will replace the current one.</p>
            @else
                <p class="text-xs text-foreground/70">No image uploaded.</p>
            @endif
        </div>

        <x-form-file-upload label="Upload New Image" model="image" />

        <x-app-button label="Update Theme" type="submit" color="primary" />
    </form>
</div>
