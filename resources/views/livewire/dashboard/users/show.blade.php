<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Title};

new #[Title('Users')] class extends Component {
    use WithPagination;

    public $search = '';

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'User deleted successfully.');
    }

    public function with()
    {
        return [
            'users' => User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('role', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->paginate(10),
        ];
    }
};
?>

<x-dashboard-wrapper title="Users">
    <div class="flex gap-2">
        <x-form-input type="search" model="search" placeholder="Search users..." class="w-full" />
        <x-app-button href="{{ route('create-user') }}" label="New User" color="primary" />
    </div>

    <x-table.wrapper>
        <x-table.table>
            <x-table.thead>
                <x-table.tr>
                    <x-table.th>Name</x-table.th>
                    <x-table.th>Email</x-table.th>
                    <x-table.th>Role</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach ($users as $user)
                    <x-table.tr wire:key="user-row-{{ $user->id }}">
                        <x-table.td>{{ $user->name }}</x-table.td>
                        <x-table.td>{{ $user->email }}</x-table.td>
                        <x-table.td>
                            <span
                                class="px-2 py-1 rounded-md text-xs font-bold 
                                {{ $user->role === 'admin' ? 'bg-danger text-surface' : ($user->role === 'editor' ? 'bg-primary text-surface' : 'bg-secondary text-surface') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </x-table.td>
                        <x-table.td>
                            <div class="flex items-center justify-end gap-2">
                                <x-app-button href="{{ route('edit-user', $user) }}" label="Edit" />
                                <x-app-button wire:click="deleteUser({{ $user->id }})"
                                    wire:confirm="Are you sure you want to delete this user?" color="danger"
                                    label="Delete" />
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.tbody>
        </x-table.table>
    </x-table.wrapper>

    <div>
        {{ $users->links() }}
    </div>
</x-dashboard-wrapper>
