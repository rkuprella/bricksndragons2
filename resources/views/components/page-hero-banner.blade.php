@props(['title', 'image' => '/images/microfig2.jpg', 'x' => '50%', 'y' => '70%'])

<div
    class="w-full relative py-4 px-2 text-secondary flex flex-col justify-center items-center rounded-lg overflow-hidden">
    <div class="absolute inset-0 w-full h-full">
        {{-- <img src="{{ asset('storage/' . $image) }}" alt="Hero Image"
            class="w-full h-full object-cover mix-blend-multiply object-bottom opacity-25"
            style="object-position: {{ $x }} {{ $y }}"> --}}
    </div>
    <h1 class="text-4xl lg:text-5xl font-display">
        {{ $title }}
    </h1>
</div>
