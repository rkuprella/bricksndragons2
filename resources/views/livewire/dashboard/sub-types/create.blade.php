<?php

use App\Models\ItemSubType;
use App\Models\ItemType;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new #[Title('Create SubType')] class extends Component {
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $name_plural = '';

    #[Validate('required|exists:item_types,id')]
    public ?int $item_type_id = null;

    #[Validate('nullable|integer|min:0|max:100')]
    public ?int $priority = null;

    #[Validate('boolean')]
    public $collection = false;

    #[Validate('string')]
    public $icon_path = null;

    public function save()
    {
        $this->validate();

        ItemSubType::create([
            'name' => $this->name,
            'name_plural' => $this->name_plural,
            'item_type_id' => $this->item_type_id,
            'priority' => $this->priority,
            'collection' => $this->collection,
            'icon_path' => $this->icon_path,
        ]);

        return redirect()->route('sub-types')->with('success', 'SubType created successfully!');
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
    <h1 class="text-2xl font-bold text-foreground mb-4">Create SubType</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-input label="Plural Name" model="name_plural" required />
        <x-form-select label="Item Type" model="item_type_id" :options="$itemTypes" required />
        <x-form-input label="Priority (Optional)" model="priority" type="number" min="0" max="100" />
        <x-form-checkbox label="Collection" model="collection" value="collection" />
        <x-form-input label="Icon" model="icon_path" />

        <x-app-button label="Create SubType" type="submit" color="primary" />
    </form>
</div>
