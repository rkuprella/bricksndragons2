@props(['links', 'class' => ''])

<x-menu-drawer class="xl:hidden {{ $class }}">
    <x-slot:header>
        <x-app-logo position="mobile" />
    </x-slot:header>
    <ul class="flex flex-col gap-5 p-1">
        <li>
            <livewire:search />
        </li>
        <li>
            <x-nav-link mobile :href="route('home')" :active="request()->routeIs('home')" :label="'Home'" />
        </li>
        @foreach ($links as $link)
            <li>
                <x-nav-link mobile :href="route($link['route'])" :active="request()->routeIs($link['route'])" :label="$link['name']" />
            </li>
        @endforeach
    </ul>
    <x-slot:footer>
        <div class="flex flex-col gap-2 w-full md:hidden justify-center">
            @guest
                <x-app-button variant="outline" :href="route('register')" label="Sign Up" color="secondary" :active="request()->routeIs('register')"
                    size="small" />
                <x-app-button variant="outline" :href="route('login')" label="Login" color="secondary" :active="request()->routeIs('login')"
                    size="small" />
            @endguest
            @auth

                @role('admin')
                    <x-app-button variant="outline" :href="route('dashboard')" :active="request()->routeIs('dashboard')" label="Dashboard" color="primary"
                        rounded />
                @endrole

            @endauth
        </div>
    </x-slot:footer>
</x-menu-drawer>
