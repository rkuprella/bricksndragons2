@php
    $links = [
        ['route' => 'terrain', 'name' => 'Terrain', 'color' => 'secondary'],
        ['route' => 'miniatures', 'name' => 'Miniatures', 'color' => 'secondary'],
        ['route' => 'accessories', 'name' => 'Accessories', 'color' => 'secondary'],
        ['route' => 'brickventures', 'name' => 'Brickventures', 'color' => 'secondary'],
        ['route' => 'about', 'name' => 'About', 'color' => 'secondary'],
        ['route' => 'blog', 'name' => 'Blog', 'color' => 'secondary'],
    ];
@endphp

<header class="border-b border-foreground/10 z-40">
    <nav class="relative flex gap-2 items-center justify-between app-container h-18">
        <x-menu-mobile :links="$links" />
        <x-app-logo />
        <ul class="items-center gap-2 hidden xl:flex">
            @foreach ($links as $link)
                <li>
                    <x-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'])" :label="$link['name']" :color="$link['color']" />
                </li>
            @endforeach
        </ul>
        <div class="items-center gap-2 ml-auto hidden md:flex">
            <livewire:search />
            @auth
                @role('admin')
                    <x-app-button variant="outline" :href="route('dashboard')" :active="request()->routeIs('dashboard')" label="Dashboard" color="primary" />
                @endrole
            @endauth
            @guest
                <x-app-button variant="outline" :href="route('register')" label="Sign Up" color="secondary" :active="request()->routeIs('register')"
                    size="small" />
                <x-app-button variant="outline" :href="route('login')" label="Login" color="secondary" :active="request()->routeIs('login')"
                    size="small" />
            @endguest
        </div>

        @auth
            <x-menu-user side="right" class="ml-auto md:ml-0" />
        @endauth
        <livewire:order-list />
    </nav>
</header>
