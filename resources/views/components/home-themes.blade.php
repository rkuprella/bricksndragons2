@php
    $linkGetStarted = [
        'href' => '/about',
        'label' => 'Get started',
    ];
@endphp

<div
    class="relative flex flex-col justify-center col-span-12 md:col-span-4 overflow-hidden transition rounded-xl x-shadow bg-tertiary app-card">
    <x-app-content class="relative px-8 py-8 lg:py-12" color="tertiary" inverted subtitle="Submit your own"
        title="Dungeon MOCs"
        text="Share your own creations with the community. Submit your own dungeon modules, miniatures, or dungeons to be featured on the website."
        :link="$linkGetStarted" />
</div>
