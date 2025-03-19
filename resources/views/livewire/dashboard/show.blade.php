<?php

use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Theme;
use App\Models\Style;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;

new #[Title('Dashboard Overview')] class extends Component {
    public function with()
    {
        return [
            'recentUsers' => User::latest()->limit(10)->get(),
            'recentItems' => Item::latest()->limit(5)->get(),
            'recentCategories' => Category::latest()->limit(5)->get(),
            'recentThemes' => Theme::latest()->limit(5)->get(),
            'recentStyles' => Style::latest()->limit(5)->get(),
        ];
    }
};
?>

<x-dashboard-wrapper title="Welcome, {{ auth()->user()->name }}">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <x-dashboard-card title="Recent Users" :items="$recentUsers" route="edit-user" createRoute="create-user"
            listRoute="users" createText="New User" class="row-span-2" />
        <x-dashboard-card title="Recent Items" :items="$recentItems" route="edit-item" createRoute="create-item"
            listRoute="items" createText="New Item" />
        <x-dashboard-card title="Recent Categories" :items="$recentCategories" route="edit-category"
            createRoute="create-category" listRoute="categories" createText="New Category" />
        <x-dashboard-card title="Recent Themes" :items="$recentThemes" route="edit-theme" createRoute="create-theme"
            listRoute="themes" createText="New Theme" />
        <x-dashboard-card title="Recent Styles" :items="$recentStyles" route="edit-style" createRoute="create-style"
            listRoute="styles" createText="New Style" />
    </div>
</x-dashboard-wrapper>
