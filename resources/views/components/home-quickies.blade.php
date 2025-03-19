@php

    $quickies = [
        [
            'title' => 'Dungeons',
            'href' => '/terrain?subType=Dungeon+Map',
            'image' => 'img-item.png',
        ],
        [
            'title' => 'Walls',
            'href' => '/terrain?subType=Wall',
            'image' => 'img-monster.png',
        ],
        [
            'title' => 'Floors',
            'href' => '/terrain?subType=Floor',
            'image' => 'img-theme.png',
        ],
        [
            'title' => 'Furniture',
            'href' => '/miniatures?subType=Furniture',
            'image' => 'img-floor.png',
        ],
        [
            'title' => 'Nature',
            'href' => '/terrain?subType=Nature',
            'image' => 'img-hero.png',
        ],
        [
            'title' => 'Characters',
            'href' => '/miniatures?subType=Character',
            'image' => 'img-monster.png',
        ],
        [
            'title' => 'Monsters',
            'href' => '/miniatures?subType=Monster',
            'image' => 'img-theme.png',
        ],
        [
            'title' => 'Equipment',
            'href' => '/accessories?subType=Equipment',
            'image' => 'img-floor.png',
        ],
        [
            'title' => 'Potions',
            'href' => '/accessories?subType=Potion',
            'image' => 'img-hero.png',
        ],
    ];

@endphp

<section
    class="relative flex px-2 gap-2 py-4 xl:py-0 app-ring scroll-px-2 overflow-x-auto xl:overflow-x-visible transition snap-x snap-mandatory scroll-smooth xl:max-w-6xl xl:mx-auto">
    @foreach ($quickies as $quicky)
        <a href="{{ $quicky['href'] }}"
            class="flex flex-col snap-start app-ring group rounded-md items-center gap-2 flex-[0_0_clamp(90px,20%,120px)] xl:flex-1 xl:shrink-0">
            <div
                class="rounded-full shadow-xl transition aspect-square bg-neutral group-hover:bg-neutral-strong grid place-items-center">
                <img src="{{ asset('images/' . $quicky['image']) }}" alt="{{ $quicky['title'] }}"
                    class="w-full transition pointer-events-none group-hover:scale-115" />
            </div>

            <div class="transition font-semibold text-sm sm:text-base text-foreground/70 group-hover:text-foreground">
                {{ $quicky['title'] }}
            </div>
        </a>
    @endforeach
</section>
