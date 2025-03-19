<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="scroll-smooth selection:bg-link selection:text-foreground-strong">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- firefox hack to show fonts while developing --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Mulish:wght@400;600;800&display=swap"
        rel="stylesheet">
    {{-- end hack --}}

    <title>{{ $title ?? 'Fallback Title' }}</title>
</head>

<body class="relative bg-surface text-foreground flex flex-col min-h-screen antialiased">
    <img src="{{ asset('images/bg-footer.png') }}" alt=""
        class="absolute hidden dark:block inset-x-0 bottom-0 w-full pointer-events-none" />
    <x-header />
    <main class="relative flex-1 w-full">
        {{ $slot }}
    </main>
    <x-footer />
</body>

</html>
