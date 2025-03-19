@php

    $posts = [
        [
            'title' => 'Top 10 LEGO® sets for dungeon builders',
            'excerpt' =>
                'LEGO® offers a wide range of sets that are perfect for building dungeons and tabletop terrain. In this article, we highlight the top 10 LEGO® sets that every dungeon builder should have in their collection.',
            'image' => 'temple.png',
            'date' => 'May, 2023',
        ],
        [
            'title' => 'How to create custom minifigs for your dungeon',
            'excerpt' =>
                'Custom minifigs are a great way to add personality and character to your brick-built dungeons. In this article, we provide a guide on how to design and create custom minifigs that are tailored to your dungeon theme.',
            'image' => 'tarrasque.jpg',
            'date' => 'Jun, 2023',
        ],
        [
            'title' => 'The best LEGO® pieces for dungeon building',
            'excerpt' =>
                'LEGO® offers a vast selection of pieces that are perfect for building dungeons and tabletop terrain. In this article, we highlight the best LEGO® pieces for dungeon building and provide tips on how to use them effectively.',
            'image' => 'bg-stoneweaver.webp',
            'date' => 'Jan, 2024',
        ],
    ];

@endphp

<section class="home-container flex flex-col gap-8">
    <x-app-headline section>Blog</x-app-headline>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 max-w-xl md:max-w-max mx-auto w-full">
        @foreach ($posts as $post)
            <a href="#"
                class="flex flex-col overflow-hidden transition group app-ring rounded-xl bg-neutral hover:bg-neutral-strong app-card">

                <img src="{{ asset('images/' . $post['image']) }}" alt="{{ $post['title'] }}"
                    class="object-cover object-center w-full h-56 transition opacity-90 group-hover:opacity-100" />

                <div class="p-6">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 15 15"
                                class="w-5 h-5">
                                <path fill="currentColor"
                                    d="M12 2h1.5A1.5 1.5 0 0 1 15 3.5v10a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 0 13.5v-10A1.5 1.5 0 0 1 1.5 2H3V0h1v2h7V0h1z" />
                            </svg>
                            <div
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[calc(50%-1px)] text-surface font-extrabold text-xs">
                                13</div>
                        </div>
                        <p class="text-xs text-foreground/80">{{ $post['date'] }}</p>
                    </div>
                    <h3 class="text-xl font-extrabold">{{ $post['title'] }}</h3>
                </div>
            </a>
        @endforeach
    </div>
    <div class="flex justify-center">
        <x-app-button label="All blog posts" uppercase color="neutral" variant="outline" href="/blog"
            size="small" />
    </div>
</section>
