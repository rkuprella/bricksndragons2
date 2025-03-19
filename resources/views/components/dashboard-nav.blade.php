@php
    $links = [
        ['name' => 'Dashboard', 'route' => 'dashboard'],
        ['name' => 'Users', 'route' => 'users'],
        ['name' => 'Items', 'route' => 'items'],
        ['name' => 'Categories', 'route' => 'categories'],
        ['name' => 'Themes', 'route' => 'themes'],
        ['name' => 'Styles', 'route' => 'styles'],
        ['name' => 'Types', 'route' => 'types'],
        ['name' => 'SubTypes', 'route' => 'sub-types'],
        ['name' => 'Posts', 'route' => 'posts'],
    ];
@endphp

<nav class="flex flex-wrap lg:flex-col gap-2 lg:w-48 lg:pt-16 lg:pb-4">
    @foreach ($links as $link)
        <x-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'])" :label="$link['name']" />
    @endforeach
</nav>
