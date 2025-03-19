<?php

use App\Models\Category;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate};

new #[Title('Create Category')] class extends Component {
    #[Validate('required|string|max:255|unique:categories,name')]
    public $name = '';

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Category created successfully!');

        return redirect()->route('categories');
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Create Category</h1>

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-form-input label="Name" model="name" required />

        <button type="submit"
            class="w-full px-4 py-2 bg-primary text-on-primary font-semibold rounded-md hover:bg-primary-muted transition">
            Create
        </button>
    </form>
</div>
