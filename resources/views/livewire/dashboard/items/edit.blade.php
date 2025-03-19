<?php

use App\Models\Item;
use App\Models\Style;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title};

new #[Title('Edit Item')] class extends Component {
    public $terrainTypes = ['dungeon', 'room', 'interior', 'nature'];
    public $miniatureTypes = ['character', 'creature', 'vehicle', 'equipment', 'effect', 'marker', 'stand'];
    public $item;
    public $name;
    public $item_type;
    public $item_sub_type;
    public $description;

    public function mount(Item $item)
    {
        $this->item = $item;
        $this->name = $item->name;
        $this->item_type = $item->item_type_id;
        $this->item_sub_type = $item->item_sub_type;
        $this->description = $item->description;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'item_type' => 'required',
            'item_sub_type' => 'required',
        ]);

        $this->item->update([
            'name' => $this->name,
            'slug' => str()->slug($this->name),
            'item_type' => $this->item_type,
            'item_sub_type' => $this->item_sub_type,
            'description' => $this->description,
        ]);

        $this->redirect('/dashboard');
    }
}; ?>

<div>
    <h1>Edit Item: {{ $item->name }}</h1>
    <form wire:submit="update" class="flex flex-col gap-4 bg-gray-800">
        <label>
            Name
            <input type="text" wire:model="name">
        </label>
        <label>
            Terrain
            <input type="radio" wire:model="item_type" value="terrain" wire:change="$refresh">
        </label>
        <label>
            Miniature
            <input type="radio" wire:model="item_type" value="miniature" wire:change="$refresh">
        </label>

        <label>
            Sub Type
            <select wire:model="item_sub_type" class="text-black bg-white">
                @if ($item_type === 'miniature')
                    @foreach ($miniatureTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                @else
                    @foreach ($terrainTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                @endif
            </select>
        </label>
        <label>
            Description
            <textarea wire:model="description"></textarea>
        </label>
        <button type="submit">Update</button>
    </form>
</div>
