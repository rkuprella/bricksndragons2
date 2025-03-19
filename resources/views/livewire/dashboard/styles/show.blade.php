<?php

use App\Models\Style;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate, Pagination};
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

new #[Title('Styles')] class extends Component {
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    public function deleteStyle(Style $style)
    {
        if ($style->image) {
            Storage::disk('public')->delete($style->image);
        }

        $style->delete();

        session()->flash('success', 'Style deleted successfully!');
    }

    public function with()
    {
        return [
            'styles' => Style::with('itemType')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->paginate($this->perPage),
        ];
    }
};
?>

<x-dashboard-wrapper title="Styles">
    <div class="flex gap-2">
        <x-form-input type="search" model="search" placeholder="Search styles..." class="w-full" />
        <x-app-button href="{{ route('create-style') }}" label="New Style" color="primary" />
    </div>

    @if (session()->has('success'))
        <div class="bg-success text-foreground p-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <x-table.wrapper>
        <x-table.table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Type</x-table.th>
                    <x-table.th>Tags</x-table.th>
                    <x-table.th>Image</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach ($styles as $style)
                    <x-table.tr wire:key="style-row-{{ $style->id }}">
                        <x-table.td>{{ $style->name }}</x-table.td>
                        <x-table.td>{{ $style->itemType?->name ?? '-' }}</x-table.td>
                        <x-table.td>
                            <div class="flex gap-2">
                                @foreach ($style->tags ?? [] as $tag)
                                    <span class="bg-primary text-white px-2 py-1 rounded-full text-xs">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </x-table.td>
                        <x-table.td>
                            @if ($style->image)
                                <img src="{{ asset('storage/' . $style->image) }}" alt="{{ $style->name }}"
                                    class="w-10 h-10 rounded-md object-cover">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-end gap-2">
                                <x-app-button href="{{ route('edit-style', $style) }}" label="Edit" />
                                <x-app-button wire:click="deleteStyle({{ $style->id }})" wire:confirm="Delete style?"
                                    color="danger" label="Delete" />
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table.table>
    </x-table.wrapper>

    <div>
        {{ $styles->links() }}
    </div>

</x-dashboard-wrapper>
