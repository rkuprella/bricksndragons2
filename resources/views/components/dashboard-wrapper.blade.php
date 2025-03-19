@props(['title' => ''])
<div class="app-container flex flex-col lg:flex-row gap-4 py-4 flex-1">
    <x-dashboard-nav />
    <div class="relative flex-1 flex flex-col gap-4">
        @if ($title)
            <h1 class="text-3xl lg:text-4xl font-semibold text-foreground-strong">
                {{ $title }}
            </h1>
        @endif
        {{ $slot }}
    </div>
</div>
