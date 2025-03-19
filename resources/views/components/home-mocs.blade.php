@php
    $linksSubmitMoc = [
        [
            'href' => '/submit-moc',
            'label' => 'Submit',
        ],
        [
            'href' => '/terrain',
            'label' => 'Browse MOCs',
        ],
    ];
@endphp

<div
    class="relative col-span-12 flex items-center md:col-span-8 overflow-hidden transition rounded-xl x-shadow bg-neutral app-card">

    <img src="{{ asset('images/bg-moc.jpg') }}" alt=""
        class="absolute hidden dark:block inset-0 object-cover w-full h-full opacity-25 pointer-events-none" />

    <x-app-content class="relative col-span-2 p-8 lg:w-3/5" color="tertiary" subtitle="Submit your own" title="Dungeon MOCs"
        text="Share your own creations with the community. Submit your own dungeon modules, miniatures, or dungeons to be featured on the website."
        :links="$linksSubmitMoc" />

    <div class="relative hidden w-2/5 py-8 px-4 place-items-center lg:grid">
        <img src="{{ asset('images/bg-question.png') }}" alt="Question Mark" class="w-60" />
    </div>

</div>
