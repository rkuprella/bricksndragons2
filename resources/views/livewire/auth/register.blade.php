<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($validated);

        Auth::login($user);
        return redirect()->route('home');
    }
}; ?>

<div class="mx-auto max-w-2xl pt-12">
    <form wire:submit.prevent="register">
        Register

        <div class="flex w-full max-w-xs flex-col gap-1 text-black dark:text-neutral-200">
            <label for="name" class="w-fit pl-0.5 text-sm">Name</label>
            <input wire:model="name" id="name" type="text"
                class="w-full rounded-none border border-black bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-500 disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-300 dark:bg-neutral-800/50 dark:focus-visible:outline-violet-400"
                name="name" placeholder="Enter your name" autocomplete="name" value="{{ old('name') }}" />
            @error('name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex w-full max-w-xs flex-col gap-1 text-black dark:text-neutral-200">
            <label for="email" class="w-fit pl-0.5 text-sm">Email</label>
            <input wire:model="email" id="email" type="email"
                class="w-full rounded-none border border-black bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-500 disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-300 dark:bg-neutral-800/50 dark:focus-visible:outline-violet-400"
                name="email" placeholder="Enter your email" autocomplete="email" value="{{ old('email') }}" />
            @error('email')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex w-full max-w-xs flex-col gap-1 text-black dark:text-neutral-200 mt-2">
            <label for="password" class="w-fit pl-0.5 text-sm">Password</label>
            <input wire:model="password" id="password" type="password"
                class="w-full rounded-none border border-black bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-500 disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-300 dark:bg-neutral-800/50 dark:focus-visible:outline-violet-400"
                name="password" placeholder="Enter your password" />
            @error('password')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex w-full max-w-xs flex-col gap-1 text-black dark:text-neutral-200 mt-2">
            <label for="password_confirmation" class="w-fit pl-0.5 text-sm">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password"
                class="w-full rounded-none border border-black bg-neutral-50 px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-500 disabled:cursor-not-allowed disabled:opacity-75 dark:border-neutral-300 dark:bg-neutral-800/50 dark:focus-visible:outline-violet-400"
                name="password_confirmation" placeholder="Confirm your password" />
            @error('password_confirmation')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit"
            class="mt-4 whitespace-nowrap rounded-none bg-violet-500 border border-violet-500 px-4 py-2 text-sm font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-violet-500 active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-violet-400 dark:border-violet-400 dark:text-black dark:focus-visible:outline-violet-400">Sign
            Up</button>
    </form>
</div>
