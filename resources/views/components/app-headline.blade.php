@props(['class' => '', 'section' => false])

<h2
    class="font-display text-balance {{ $section ? 'text-center text-3xl sm:text-4xl lg:text-5xl ' : 'text-4xl sm:text-5xl lg:text-6xl ' }} {{ $class }}">
    {{ $slot }}
</h2>
