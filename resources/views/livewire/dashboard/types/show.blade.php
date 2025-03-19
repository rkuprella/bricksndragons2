<?php

use App\Models\ItemType;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Title};

new #[Title('Item Types')] class extends Component {
    use WithPagination;

    public $search = '';

    public function deleteItemType(ItemType $type)
    {
        $type->delete();
        session()->flash('success', 'Item Type deleted successfully.');
    }

    public function with()
    {
        return [
            'itemTypes' => ItemType::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name')
                ->paginate(10),
        ];
    }
};
?>

<x-dashboard-wrapper title="Item Types">
    <div class="flex gap-2">
        <x-form-input type="search" model="search" placeholder="Search types..." class="w-full" />
        <x-app-button href="{{ route('create-type') }}" label="New Type" color="primary" />
    </div>

    @if (session()->has('success'))
        <div class="bg-success text-white p-2 mb-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <x-table.wrapper>
        <x-table.table wire:key="'item-types-table-'.md5($search)">
            <x-table.thead>
                <x-table.tr>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach ($itemTypes as $type)
                    <x-table.tr wire:key="item-type-row-{{ $type->id }}">
                        <x-table.td>{{ $type->name }}</x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-end gap-2">
                                <x-app-button href="{{ route('edit-type', $type) }}" label="Edit" />
                                <x-app-button wire:click="deleteItemType({{ $type->id }})"
                                    wire:confirm="Delete this item type?" color="danger" label="Delete" />
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table.table>
    </x-table.wrapper>

    <div>
        {{ $itemTypes->links() }}
    </div>
</x-dashboard-wrapper>
