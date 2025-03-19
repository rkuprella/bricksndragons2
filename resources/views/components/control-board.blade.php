@props([
    'items',
    'categories',
    'themes',
    'tabs',
    'currentSubType' => '',
    'styles',
    'currentStyle',
    'styleFunction' => null,
    'tabFunction' => null,
    'currentRoute',
    'currentRoutePlural',
    'orderList',
    'sortModel',
])

<div class="flex flex-col gap-24 py-4">
    <div class="flex flex-col gap-4 app-container">
        <x-style-tabs :styles="$styles" :currentStyle="$currentStyle" :currentRoute="$currentRoute" :currentRoutePlural="$currentRoutePlural" :click="$styleFunction" />
        <x-type-tabs :tabs="$tabs" :currentSubType="$currentSubType" :click="$tabFunction" />
        <div class="flex gap-2">
            <aside class="hidden lg:flex flex-col gap-8 w-48 pt-16 pb-4">
                <x-control-checklist :categories="$themes" model="selectedThemes" title="Themes" />
                <x-control-checklist :categories="$categories" model="selectedCategories" title="Categories" />
            </aside>
            <div class="flex-1 flex flex-col gap-4">
                <div class="flex justify-between items-center gap-2">
                    <x-menu-filters :themes="$themes" :categories="$categories" :currentRoutePlural="$currentRoutePlural" :currentSubType="$currentSubType" />
                    <x-control-admin-bar :currentStyle="$currentStyle" :currentRoute="$currentRoute" :currentSubType="$currentSubType" />
                    <x-control-sort :model="$sortModel" class="ml-auto" />
                </div>
                <x-item-list :items="$items" :orderList="$orderList" />
            </div>
        </div>
    </div>
    <div class="home-container p-6">
        More ...
    </div>
</div>
