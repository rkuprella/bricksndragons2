<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\StudioFileController;

Volt::route('/', 'home')->name('home');
Volt::route('/about', 'about')->name('about');
Volt::route('/blog', 'home')->name('blog');
Volt::route('/terrain', 'items')->name('terrain');
Volt::route('/terrain/{item}', 'item')->name('terrain-item');
Volt::route('/miniatures', 'items')->name('miniatures');
Volt::route('/miniatures/{item}', 'item')->name('miniature');
Volt::route('/accessories', 'items')->name('accessories');
Volt::route('/accessories/{item}', 'item')->name('accessory');
Volt::route('/brickventures', 'items')->name('brickventures');
Volt::route('/brickventures/{item}', 'item')->name('brickventure');
Volt::route('/order-list', 'order-list')->name('order-list');
Volt::route('/inventory', 'inventory')->name('inventory');

Route::middleware(['auth', 'role:editor'])->group(function () {
    Volt::route('/dashboard', 'dashboard.show')->name('dashboard');
    Volt::route('/dashboard/items', 'dashboard.items.show')->name('items');
    Volt::route('/dashboard/items/new', 'dashboard.items.create')->name('create-item');
    Volt::route('/dashboard/items/{item}/edit', 'dashboard.items.edit')->name('edit-item');
    Volt::route('/dashboard/styles', 'dashboard.styles.show')->name('styles');
    Volt::route('/dashboard/styles/new', 'dashboard.styles.create')->name('create-style');
    Volt::route('/dashboard/styles/{style}/edit', 'dashboard.styles.edit')->name('edit-style');
    Volt::route('/dashboard/themes', 'dashboard.themes.show')->name('themes');
    Volt::route('/dashboard/themes/new', 'dashboard.themes.create')->name('create-theme');
    Volt::route('/dashboard/themes/{theme}/edit', 'dashboard.themes.edit')->name('edit-theme');
    Volt::route('/dashboard/types', 'dashboard.types.show')->name('types');
    Volt::route('/dashboard/types/new', 'dashboard.types.create')->name('create-type');
    Volt::route('/dashboard/types/{type}/edit', 'dashboard.types.edit')->name('edit-type');
    Volt::route('/dashboard/sub-types', 'dashboard.sub-types.show')->name('sub-types');
    Volt::route('/dashboard/sub-types/new', 'dashboard.sub-types.create')->name('create-sub-type');
    Volt::route('/dashboard/sub-types/{subType}/edit', 'dashboard.sub-types.edit')->name('edit-sub-type');
    Volt::route('/dashboard/categories', 'dashboard.categories.show')->name('categories');
    Volt::route('/dashboard/categories/new', 'dashboard.categories.create')->name('create-category');
    Volt::route('/dashboard/categories/{category}/edit', 'dashboard.categories.edit')->name('edit-category');
    Volt::route('/dashboard/posts', 'dashboard.posts.show')->name('posts');
    Volt::route('/dashboard/posts/new', 'dashboard.posts.create')->name('create-post');
    Volt::route('/dashboard/posts/{post}/edit', 'dashboard.posts.edit')->name('edit-post');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Volt::route('/dashboard/users', 'dashboard.users.show')->name('users');
    Volt::route('/dashboard/users/new', 'dashboard.users.create')->name('create-user');
    Volt::route('/dashboard/users/{user}/edit', 'dashboard.users.edit')->name('edit-user');
});

Route::middleware('auth')->group(function () {
    Volt::route('/logout', 'auth.logout')->name('logout');
    
    // Studio file routes
    Route::post('/items/{item}/studio-file', [StudioFileController::class, 'upload'])->name('items.studio-file.upload');
    Route::get('/items/{item}/studio-file/download', [StudioFileController::class, 'download'])->name('items.studio-file.download');
});

Route::middleware('guest')->group(function () {
    Volt::route('/register', 'auth.register')->name('register');
    Volt::route('/login', 'auth.login')->name('login');
});