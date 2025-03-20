<?php

use Illuminate\View\View;
use Livewire\Volt\Component;
use App\Models\Item;

new class extends Component {
    public Item $item;

    public function with(): array
    {
        return [
            'item' => $this->item->load('categories'),
        ];
    }

    public function rendering(View $view): void
    {
        $view->title($this->item->name);
    }
}; ?>

<div class="home-container py-4 flex flex-col gap-6">
    <x-page-breadcrumbs :links="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => $item->itemType->name_plural, 'url' => route(strtolower($item->itemType->name_plural))],
        ['label' => $item->name],
    ]" />
    <div class="flex gap-4">
        <div class="flex-1">

        </div>
        <div class="bg-surface-strong rounded-lg shadow-2xl p-4">
            <h1 class="text-3xl font-bold text-foreground">{{ $item->name }}</h1>
            <p class="text-foreground-muted mt-1">Type: {{ $item->itemType->name }}</p>
            <!-- Use relation instead of ID -->

            @if ($item->categories->isNotEmpty())
                <h3 class="mt-4 text-xl font-semibold text-foreground">Categories:</h3>
                <ul class="mt-2 flex flex-wrap gap-2">
                    @foreach ($item->categories as $category)
                        <li class="bg-secondary-muted text-on-secondary px-3 py-1 text-sm rounded-full">
                            {{ $category->name }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-foreground-muted mt-2">No categories assigned.</p>
            @endif

            <!-- ✅ Display Images -->
            @if (!empty($item->images) && is_array($item->images))
                <h3 class="mt-6 text-xl font-semibold text-foreground">Images:</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mt-2">
                    @foreach ($item->images as $image)
                        <img src="{{ asset('storage/' . $image) }}"
                            class="w-full h-40 object-cover rounded-lg shadow-md">
                    @endforeach
                </div>
            @else
                <p class="text-foreground-muted mt-2">No images available.</p>
            @endif

            @if ($item->modules->isNotEmpty())
                <h3 class="text-lg font-bold mt-4">Includes Modules:</h3>
                <ul>
                    @foreach ($item->modules as $module)
                        <li>{{ $module->name }} (x{{ $module->pivot->amount }})</li>
                    @endforeach
                </ul>
            @endif

            <h3>{{ $item->user->name }}</h3>
        </div>
    </div>
</div>
