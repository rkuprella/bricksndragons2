<?php

use App\Models\ItemSubType;
use App\Models\ItemType;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new #[Title('Edit SubType')] class extends Component {
    use WithFileUploads;

    public ItemSubType $subType;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $name_plural = '';

    #[Validate('required|exists:item_types,id')]
    public ?int $item_type_id = null;

    #[Validate('required|integer|min:1|max:100')]
    public int $priority = 1;

    #[Validate('boolean')]
    public $collection;

    #[Validate('string')]
    public $icon_path = '';

    public function mount(ItemSubType $subType)
    {
        $this->subType = $subType;
        $this->name = $subType->name;
        $this->name_plural = $subType->name_plural;
        $this->item_type_id = $subType->item_type_id;
        $this->priority = $subType->priority;
        $this->collection = (bool) $subType->collection;
        $this->icon_path = $subType->icon_path;
    }

    public function save()
    {
        $this->validate();

        $this->subType->update([
            'name' => $this->name,
            'name_plural' => $this->name_plural,
            'item_type_id' => $this->item_type_id,
            'priority' => $this->priority,
            'collection' => (bool) $this->collection,
            'icon_path' => $this->icon_path,
        ]);

        return redirect()->route('sub-types')->with('success', 'SubType updated successfully!');
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
    <h1 class="text-2xl font-bold text-foreground mb-4">Edit SubType</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-input label="Plural Name" model="name_plural" required />
        <x-form-select label="Item Type" model="item_type_id" :options="$itemTypes" required />
        <x-form-input label="Priority" model="priority" type="number" required />
        <x-form-checkbox label="Collection" model="collection" />
        <x-form-textarea label="Icon" model="icon_path" description="D path from game icons (iconify.design)" />

        <x-app-button label="Update SubType" type="submit" color="primary" />
    </form>
</div>
