<?php

use App\Models\Category;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Title};

new #[Title('Categories')] class extends Component {
    use WithPagination;

    public $search = '';

    public function deleteCategory(Category $category)
    {
        $category->delete();

        session()->flash('success', 'Category deleted successfully!');
    }

    public function with()
    {
        return [
            'categories' => Category::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->paginate(10),
        ];
    }
};
?>

<x-dashboard-wrapper title="Categories">
    <div class="flex gap-2">
        <x-form-input type="search" model="search" placeholder="Search categories..." class="w-full" />
        <x-app-button href="{{ route('create-category') }}" label="New Category" color="primary" />
    </div>

    @if (session()->has('success'))
        <div class="bg-success text-foreground p-2 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <x-table.wrapper>
        <x-table.table wire:key="'categories-table-' . md5($search)">
            <x-table.thead>
                <x-table.tr>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach ($categories as $category)
                    <x-table.tr wire:key="category-row-{{ $category->id }}">
                        <x-table.td>{{ $category->name }}</x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-end gap-2">
                                <x-app-button href="{{ route('edit-category', $category) }}" label="Edit" />
                                <x-app-button wire:click="deleteCategory({{ $category->id }})"
                                    wire:confirm="Delete category?" color="danger" label="Delete" />
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table.table>
    </x-table.wrapper>

    <div>
        {{ $categories->links() }}
    </div>
</x-dashboard-wrapper>
