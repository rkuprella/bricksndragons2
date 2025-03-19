@php

    $sections = [
        [
            'subtitle' => 'Terrain',
            'title' => 'Terrain assets for all grid sizes',
            'text' =>
                'Handcrafted dungeon modules for your tabletop RPG. Carefully selected LEGO® bricks to ensure availability and affordability. Minimal usage of rare parts.',
            'link' => [
                'href' => '/terrain',
                'label' => 'Explore Terrain',
            ],
            'image' => 'img-terrain.png',
        ],
        [
            'subtitle' => 'Miniatures',
            'title' => 'Build Heroes and Monsters in Scale',
            'text' =>
                'Your favorite LEGO® minifigs to represent the players characters either on or outside of the battlefield and custom brickbuilt miniatures as playable or non-playable characters.',
            'link' => [
                'href' => '/miniatures',
                'label' => 'Explore Miniatures',
            ],
            'image' => 'img-miniatures.png',
        ],
        [
            'subtitle' => 'Accessories',
            'title' => 'Handouts, Magic Items, and More',
            'text' =>
                'Accessories to enhance your tabletop RPG experience. Because every adventure needs a little extra.',
            'link' => [
                'href' => '/accessories',
                'label' => 'Explore Accessories',
            ],
            'image' => 'img-chest.png',
        ],
        [
            'subtitle' => 'Brickventures',
            'title' => 'Ready-to-Build Adventures with Reusable Terrain',
            'text' =>
                'Brickventures are adventure modules that rely on reusable terrain assets and come with Miniature suggestions and building instructions.',
            'link' => [
                'href' => '/brickventures',
                'label' => 'Explore Brickventures',
            ],
            'image' => 'img-sets.png',
        ],
    ];

@endphp

<section id="explore" class="home-container divide-y divide-foreground/10">
    @foreach ($sections as $section)
        <div
            class="flex flex-col md:flex-row md:items-center md:even:flex-row-reverse not-first:pt-8 not-last:pb-8 lg:not-first:pt-12 lg:not-last:pb-12 px-4 md:gap-8">
            <div class="md:w-1/2">
                <img src="{{ asset('images/' . $section['image']) }}" alt="{{ $section['title'] }}"
                    class="object-cover max-w-full h-60 md:h-80 md:mx-auto" />
            </div>
            <div class="md:w-1/2">
                <x-app-content color="secondary" subtitle="{{ $section['subtitle'] }}" title="{{ $section['title'] }}"
                    text="{{ $section['text'] }}" :link="$section['link']" />
            </div>

        </div>
    @endforeach
</section>
