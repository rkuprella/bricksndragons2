<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Item;
use Livewire\Attributes\{Title};

new #[Title('Items')] class extends Component {
    use WithPagination;
    public $search = '';
    public $perPage = 10;

    public function deleteItem($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        session()->flash('message', 'Item deleted successfully.');
    }

    public function with()
    {
        return [
            'items' => Item::with(['itemType', 'itemSubType', 'styles'])
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderByRaw('COALESCE(item_type_id, 9999), COALESCE(item_sub_type_id, 9999), (SELECT MIN(styles.name) FROM styles JOIN item_style ON styles.id = item_style.style_id WHERE item_style.item_id = items.id) ASC, name ASC')
                ->paginate($this->perPage),
        ];
    }
}; ?>


<x-dashboard-wrapper title="Items">
    <div class="flex gap-2">
        <x-form-input type="search" model="search" placeholder="Search items..." class="w-full" />
        <x-app-button href="{{ route('create-item') }}" label="New Item" color="primary" />
    </div>

    @if (session()->has('message'))
        <div class="bg-success text-foreground p-2 mb-4">
            {{ session('message') }}
        </div>
    @endif

    <x-table.wrapper>
        <x-table.table wire:key="'items-table-'.md5($search.$items->currentPage())">
            <x-table.thead>
                <x-table.tr>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Type</x-table.th>
                    <x-table.th>SubType</x-table.th>
                    <x-table.th>Styles</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach ($items as $item)
                    <x-table.tr wire:key="item-row-{{ $item->id }}">
                        <x-table.td><a wire:navigate
                                href="/{{ strtolower($item->itemType?->name_plural) }}/{{ $item->slug }}"
                                class="app-ring py-1 rounded-md px-1 underline transition hover:text-secondary">{{ $item->name }}</a></x-table.td>
                        <x-table.td>{{ $item->itemType?->name ?? '-' }}</x-table.td>
                        <x-table.td>{{ $item->itemSubType?->name ?? '-' }}</x-table.td>
                        <x-table.td>
                            {{ $item->styles->pluck('name')->implode(', ') ?: '-' }}
                        </x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-end gap-2">
                                <x-app-button href="{{ route('edit-item', $item) }}" label="Edit" />
                                <x-app-button wire:click="deleteItem({{ $item->id }})" wire:confirm="Delete item?"
                                    color="danger" label="Delete" />
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table.table>
    </x-table.wrapper>

    <div>
        {{ $items->links() }}
    </div>
</x-dashboard-wrapper>
