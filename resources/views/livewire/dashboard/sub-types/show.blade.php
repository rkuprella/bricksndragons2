<?php

use App\Models\ItemSubType;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Title, Validate};

new #[Title('Item Sub-Types')] class extends Component {
    use WithPagination;

    public $search = '';

    public function deleteSubType(ItemSubType $subType)
    {
        $subType->delete();
        session()->flash('success', 'SubType deleted successfully.');
    }

    public function with()
    {
        return [
            'subTypes' => ItemSubType::with('itemType')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('name_plural', 'like', '%' . $this->search . '%')
                ->orderBy('priority', 'asc')
                ->paginate(10),
        ];
    }
};
?>

<x-dashboard-wrapper title="Item Sub-Types">
    <div class="flex gap-2">
        <x-form-input type="search" model="search" placeholder="Search sub-types..." class="w-full" />
        <x-app-button href="{{ route('create-sub-type') }}" label="New SubType" color="primary" />
    </div>

    @if (session()->has('success'))
        <div class="bg-success text-foreground p-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <x-table.wrapper>
        <x-table.table wire:key="'sub-type-table-'.md5($search)">
            <x-table.thead>
                <x-table.tr>
                    <x-table.th>Icon</x-table.th>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Item Type</x-table.th>
                    <x-table.th>Priority</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach ($subTypes as $subType)
                    <x-table.tr wire:key="sub-type-row-{{ $subType->id }}">
                        <x-table.td>
                            @if ($subType->icon_path)
                                <svg class="size-10 {{ $subType->collection ? 'text-primary' : 'text-secondary' }}"
                                    xmlns="http://www.w3.org/2000/svg" width="512" height="512"
                                    viewBox="0 0 512 512">
                                    <path fill="currentColor" d="{{ $subType->icon_path }}" />
                                </svg>
                            @else
                                -
                            @endif
                        </x-table.td>
                        <x-table.td>{{ $subType->name }}</x-table.td>
                        <x-table.td>{{ $subType->itemType->name ?? '-' }}</x-table.td>
                        <x-table.td>{{ $subType->priority ?? '-' }}</x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-end gap-2">
                                <x-app-button href="{{ route('edit-sub-type', $subType) }}" label="Edit" />
                                <x-app-button wire:click="deleteSubType({{ $subType->id }})"
                                    wire:confirm="Delete this SubType?" color="danger" label="Delete" />
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table.table>
    </x-table.wrapper>

    <div>
        {{ $subTypes->links() }}
    </div>
</x-dashboard-wrapper>
