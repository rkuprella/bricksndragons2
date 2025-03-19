<?php

use App\Models\User;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};

new #[Title('Create User')] class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:8')]
    public string $password = '';

    #[Validate('required|in:admin,editor,user')]
    public string $role = 'user';

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role,
        ]);

        return redirect()->route('users')->with('success', 'User created successfully!');
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Create User</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />
        <x-form-input label="Email" model="email" type="email" required />
        <x-form-input label="Password" model="password" type="password" required />
        <x-form-select label="Role" model="role" :options="['admin' => 'Admin', 'editor' => 'Editor', 'user' => 'User']" required />

        <x-app-button label="Create User" type="submit" color="primary" />
    </form>
</div>
