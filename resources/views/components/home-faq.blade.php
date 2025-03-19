@php

    $questions = [
        [
            'question' => 'What service does this website provide?',
            'answer' =>
                'Bricks & Dragons is a platform that provides resources for building brick-built dungeons and tabletop terrain. You can use the Dungeon Builder to create your own dungeons, explore our Terrain and Miniatures sections for inspiration, and play through Brickventures with your friends.',
        ],
        [
            'question' => 'Is this website free to use?',
            'answer' =>
                'You can browse the website, access the Dungeon Builder, and download building instructions without any costs. We also offer a premium lifetime subscription that provides access to the XML data export tool and supports the development of the platform.',
        ],
        [
            'question' => 'What are Brickventures?',
            'answer' =>
                'Brickventures are ready-to-build adventures that rely on reusable terrain assets. Each Brickventure includes a unique story, multiple dungeon layouts, miniature suggestions, and building instructions. You can use the Dungeon Builder to recreate the dungeons and play through the adventures with your friends.',
        ],
        [
            'question' => 'How can I get started?',
            'answer' =>
                'If you are new to Bricks & Dragons, we recommend checking out our Starter Guide. It provides an overview of the platform and explains how to use the Dungeon Builder to create your own brick-built dungeons. You can also explore our Terrain and Miniatures sections to find inspiration for your projects.',
        ],
        [
            'question' => 'How can I submit my own creations?',
            'answer' =>
                'If you have built your own brick-built dungeons, custom minifigs, or adventures, you can submit them to Bricks & Dragons. We showcase user-submitted creations on our website and social media channels to inspire other LEGO® enthusiasts. Check out our Submit MOC page for more information.',
        ],
    ];

@endphp

<section class="home-container flex flex-col gap-8">
    <x-app-headline section>FAQ</x-app-headline>
    <div class="max-w-xl w-full mx-auto flex flex-col gap-2">
        @foreach ($questions as $question)
            <details
                class="app-ring-within flex flex-col transition rounded-md bg-neutral hover:bg-neutral-strong hover:text-secondary shadow-xl focus-within:text-secondary">
                <summary class="px-6 py-3 text-lg font-extrabold rounded-md outline-none cursor-pointer">
                    {{ $question['question'] }}
                </summary>
                <x-app-paragraph class="px-6 pt-2 pb-4 text-foreground/80">{{ $question['answer'] }}</x-app-paragraph>
            </details>
        @endforeach
    </div>
    <div class="flex justify-center">
        <x-app-button label="All FAQ's" uppercase color="neutral" variant="outline" href="/blog" size="small" />
    </div>
</section>
