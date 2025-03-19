<?php

use App\Models\Item;
use App\Models\ItemSubType;
use Livewire\Volt\Component;
use Livewire\Attributes\{Title};

new #[Title('Bricks & Dragons')] class extends Component {
    public $activeTab = 'Dungeon Map';

    public function getRecentItems()
    {
        return ItemSubType::whereIn('name', ['Dungeon Map', 'Prop', 'Character', 'Monster', 'Equipment'])
            ->with([
                'items' => function ($query) {
                    $query->latest()->limit(6);
                },
            ])
            ->orderBy('priority', 'asc')
            ->get();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function with(): array
    {
        return [
            'recentItems' => $this->getRecentItems(),
            'activeTab' => $this->activeTab,
            'stats' => [
                'terrainCount' => Item::whereHas('itemType', fn($q) => $q->where('name', 'Terrain'))->count(),
                'terrainNew' => Item::whereHas('itemType', fn($q) => $q->where('name', 'Terrain'))
                    ->where('created_at', '>=', now()->subMonth())
                    ->count(),
                'miniatureCount' => Item::whereHas('itemType', fn($q) => $q->where('name', 'Miniature'))->count(),
                'miniatureNew' => Item::whereHas('itemType', fn($q) => $q->where('name', 'Miniature'))
                    ->where('created_at', '>=', now()->subMonth())
                    ->count(),
                'themeCount' => \App\Models\Theme::count(),
                'themeNew' => \App\Models\Theme::where('created_at', '>=', now()->subMonth())->count(),
                'styleCount' => \App\Models\Style::whereHas('itemType', fn($q) => $q->where('name', 'Terrain'))->count(),
                'styleNew' => \App\Models\Style::whereHas('itemType', fn($q) => $q->where('name', 'Terrain'))
                    ->where('created_at', '>=', now()->subMonth())
                    ->count(),
            ],
        ];
    }
}; ?>

<div class="flex flex-col gap-16 lg:gap-24">
    <div>
        <x-home-hero />
        <x-home-quickies />
    </div>
    <x-grid-wrapper>
        <x-home-stats :stats="$stats" />
        <x-home-about />
    </x-grid-wrapper>
    <x-home-featured title="Our latest builds" :recentItems="$recentItems" :activeTab="$activeTab" />
    <x-grid-wrapper>
        <x-home-mocs />
        <x-home-themes />
    </x-grid-wrapper>
    <x-home-faq />
    <x-home-blog />
</div>
