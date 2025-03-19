<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};
use Illuminate\Support\Facades\Hash;

new #[Title('Edit User')] class extends Component {
    public User $user;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('nullable|string|min:8')]
    public ?string $password = null;

    #[Validate('required|in:admin,editor,user')]
    public string $role = 'user';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function save()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => $this->password ? Hash::make($this->password) : $this->user->password,
        ]);

        return redirect()->route('users')->with('success', 'User updated successfully!');
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Edit User</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-input label="Email" model="email" type="email" required />
        <x-form-input label="New Password (optional)" model="password" type="password"
            placeholder="Leave empty to keep the current password" />

        <x-form-select label="Role" model="role" :options="['admin' => 'Admin', 'editor' => 'Editor', 'user' => 'User']" required />

        <x-app-button label="Update User" type="submit" color="primary" />
    </form>
</div>
