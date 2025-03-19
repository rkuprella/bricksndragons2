<?php

use App\Models\Theme;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};
use Livewire\WithPagination;

new #[Title('Themes')] class extends Component {
    use WithPagination;

    public string $search = '';

    public function deleteTheme(Theme $theme)
    {
        $theme->delete();
        session()->flash('success', 'Theme deleted successfully!');
    }

    public function with()
    {
        return [
            'themes' => Theme::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->paginate(10),
        ];
    }
};
?>

<x-dashboard-wrapper title="Themes">
    <div class="flex gap-2">
        <x-form-input type="search" model="search" placeholder="Search themes..." class="w-full" />
        <x-app-button href="{{ route('create-theme') }}" label="New Theme" color="primary" />
    </div>

    <x-table.wrapper>
        <x-table.table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Description</x-table.th>
                    <x-table.th>Image</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach ($themes as $theme)
                    <x-table.tr>
                        <x-table.td>{{ $theme->name }}</x-table.td>
                        <x-table.td>{{ $theme->description ?? '-' }}</x-table.td>
                        <x-table.td>
                            @if ($theme->image)
                                <img src="{{ asset('storage/' . $theme->image) }}"
                                    class="w-12 h-12 object-cover rounded-md">
                            @else
                                <span class="text-foreground/50">No Image</span>
                            @endif
                        </x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-end gap-2">
                                <x-app-button href="{{ route('edit-theme', $theme) }}" label="Edit" />
                                <x-app-button wire:click="deleteTheme({{ $theme->id }})"
                                    wire:confirm="Are you sure you want to delete this theme?" color="danger"
                                    label="Delete" />
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table.table>
    </x-table.wrapper>

    <div>
        {{ $themes->links() }}
    </div>
</x-dashboard-wrapper>
