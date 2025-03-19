<section class="relative w-full mx-auto max-w-6xl lg:min-h-96">
    <img src="{{ asset('images/img-sets.png') }}" alt="Hero"
        class="hidden md:block dark:md:hidden inset-y-0 right-0 w-1/2 absolute m-auto" />
    <img src="{{ asset('images/bg-hero.png') }}" alt="Hero"
        class="hidden dark:md:block absolute inset-y-0 left-0 right-0 lg:left-auto w-full lg:w-4/5 h-80 md:h-full object-cover object-[80%_50%] md:object-center" />
    <img src="{{ asset('images/bg-hero-mobile.png') }}" alt="Hero"
        class="absolute inset-0 object-cover w-full h-full hidden dark:block dark:md:hidden" />
    <div class="absolute inset-x-0 w-full overflow-hidden pointer-events-none h-96 md:hidden">
        <img src="{{ asset('images/img-dragon-black.png') }}" alt="Black Dragon"
            class="absolute right-0 z-20 translate-x-60 w-96 -top-8 animate-dragon" />
    </div>
    <div
        class="absolute hidden dark:block inset-x-0 bottom-0 h-16 pointer-events-none bg-gradient-to-t from-surface to-transparent">
    </div>
    <div class="home-container">
        <div class="relative flex flex-col items-start group py-8 md:py-16 px-4">
            <h1 class="mb-2 text-5xl md:text-7xl xl:text-8xl font-display">
                <span class="block text-3xl text-primary md:text-4xl xl:text-5xl">Build your own</span>
                <span>
                    Brick Dungeon <br />
                    Adventures
                </span>
            </h1>

            <x-app-paragraph class="mb-6 font-semibold text-balance md:text-lg text-foreground/80">
                Instructions and parts lists for modular terrain and tabletop miniatures, built with common LEGO®
                bricks.
            </x-app-paragraph>

            <div class="flex items-center gap-3">
                {{-- <x-app-button label="Explore" color="primary" href="#explore" size="large" uppercase /> --}}
                <livewire:style-switcher />
            </div>
        </div>
    </div>
</section>
