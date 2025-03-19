@php
    $linkGetStarted = [
        'href' => '/about',
        'label' => 'Get started',
    ];
@endphp

<div
    class="relative flex items-center col-span-12 md:col-span-8 overflow-hidden transition rounded-xl bg-primary app-card">
    <x-app-content class="relative col-span-2 p-8 lg:w-3/5" color="primary" inverted subtitle="Get started with"
        title="Bricks & Dragons"
        text="Transform LEGO® bricks into epic dungeons. Learn how to use our modular system to create your own adventures."
        :link="$linkGetStarted" />
    <div class="absolute inset-y-0 h-full right-0 hidden w-2/5 place-items-center lg:grid">
        <img src="{{ asset('images/bg-starter.png') }}" alt="Question Mark"
            class="w-full h-full object-cover object-left" />
    </div>
</div>
