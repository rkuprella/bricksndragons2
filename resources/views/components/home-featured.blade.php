@props(['recentItems', 'activeTab', 'title' => ''])

<section class="home-container flex flex-col gap-8">
    <x-app-headline section>{{ $title }}</x-app-headline>

    <!-- Tabs -->
    <div class="flex items-center justify-center flex-wrap gap-2">
        @foreach ($recentItems as $subType)
            <x-app-button variant="tab" color="neutral" rounded wire:click="setTab('{{ $subType->name }}')"
                :label="$subType->name_plural" :active="$activeTab === $subType->name" />
        @endforeach
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 lg:gap-4">
        @php
            $activeItems = $recentItems->firstWhere('name', $activeTab)?->items ?? collect();
        @endphp

        @forelse ($activeItems as $item)
            <x-item-card :item="$item" featured />
        @empty
            <p class="text-sm text-foreground-muted">No recent items.</p>
        @endforelse
    </div>
</section>
