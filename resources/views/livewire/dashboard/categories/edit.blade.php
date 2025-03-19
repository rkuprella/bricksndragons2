<?php

use App\Models\Category;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title, Validate, Layout};

new #[Title('Edit Category')] class extends Component {
    public Category $category;

    #[Validate('required|string|max:255|unique:categories,name,{{ $category->id }}')]
    public $name;

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
    }

    public function update()
    {
        $this->validate();

        $this->category->update([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Category updated successfully!');

        return redirect()->route('categories'); // Redirect to category list
    }
};
?>

<div class="bg-neutral p-6 rounded-lg shadow-lg w-full max-w-3xl mx-auto mt-4">
    <h1 class="text-2xl font-bold text-foreground mb-4">Edit Category</h1>

    <form wire:submit="update" class="flex flex-col gap-4">
        <div>
            <label class="text-sm font-medium text-foreground-muted">Category Name</label>
            <input wire:model="name" type="text" placeholder="Enter category name"
                class="w-full px-3 py-2 rounded-md bg-foreground text-surface border border-border focus:ring-2 focus:ring-primary">
            @error('name')
                <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
            class="w-full px-4 py-2 bg-primary text-on-primary font-semibold rounded-md hover:bg-primary-muted transition">
            Update
        </button>
    </form>
</div>
