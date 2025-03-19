<?php

use Livewire\Volt\Component;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $email = '';
    public $password = '';

    public function login()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($validated)) {
            session()->regenerate();
            return redirect()->route('home');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Incorrect credentials.',
        ]);
    }
}; ?>

<div class="mx-auto max-w-2xl pt-12">
    <form wire:submit.prevent="login">
        Login
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
                name="password" placeholder="Enter your password" autocomplete="name" />
            @error('password')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        @error('credentials')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <x-app-button label="Login" type="submit" variant="solid" color="secondary" />

    </form>
</div>
