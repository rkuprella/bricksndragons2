<?php

use App\Models\ItemType;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};

new #[Title('Create Item Type')] class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $name_plural = '';

    public function save()
    {
        $this->validate();

        ItemType::create([
            'name' => $this->name,
            'name_plural' => $this->name_plural,
        ]);

        return redirect()->route('types')->with('success', 'Item Type created successfully!');
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Create Item Type</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-input label="Plural Name" model="name_plural" required />

        <x-app-button label="Create Item Type" type="submit" color="primary" />
    </form>
</div>
