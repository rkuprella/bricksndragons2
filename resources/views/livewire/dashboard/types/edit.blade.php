<?php

use App\Models\ItemType;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};

new #[Title('Edit Item Type')] class extends Component {
    public ItemType $type;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $name_plural = '';

    public function mount(ItemType $type)
    {
        $this->itemType = $type;
        $this->name = $type->name;
        $this->name_plural = $type->name_plural;
    }

    public function save()
    {
        $this->validate();

        $this->type->update([
            'name' => $this->name,
            'name_plural' => $this->name_plural,
        ]);

        return redirect()->route('types')->with('success', 'Item Type updated successfully!');
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Edit Item Type</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-input label="Plural Name" model="name_plural" required />

        <x-app-button label="Update Item Type" type="submit" color="primary" />
    </form>
</div>
