@php
    $links = [
        ['url' => '/about', 'name' => 'About'],
        ['url' => '/starter-guide', 'name' => 'Starter Guide'],
        ['url' => '/submit-moc', 'name' => 'Submit your MOC'],
        ['url' => '/contact', 'name' => 'Contact'],
        ['url' => '/privacy', 'name' => 'Data & Privacy'],
        ['url' => '/terms', 'name' => 'Terms & Conditions'],
    ];
@endphp

<footer class="app-container relative flex flex-col gap-16 pt-16 lg:pt-24 pb-24 lg:pb-32 lg:gap-24">
    @auth
        <x-discord-button />
    @endauth
    <div class="flex flex-col lg:flex-row gap-8 px-4">
        <div
            class="flex flex-col flex-1 gap-6 pt-16 lg:pt-0 justify-start items-center lg:items-start order-3 lg:order-1">
            <div class="flex flex-col items-center gap-6">

                <x-app-logo position="footer" />
                <small class="italic text-sm">
                    A project by <span class="text-primary font-bold">Quabbe</span>
                </small>
            </div>
        </div>
        <div class="order-1 lg:order-2 flex flex-col gap-6 min-w-60">
            <p class="text-xl font-semibold text-foreground">Links</p>
            <ul class="flex flex-col gap-1">
                @foreach ($links as $link)
                    <li>
                        <x-footer-link :href="url($link['url'])" :label="$link['name']" />
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="order-2 lg:order-3 flex flex-col gap-6">
            <div class="text-xl font-semibold text-foreground">Disclaimer</div>
            <x-app-paragraph>
                Bricks & Dragons is not affiliated with The LEGO Group. LEGO® is a
                trademark of The LEGO Group of companies which does not in anyway
                sponsor, authorize, or endorse this content. All other original logos
                and/or brands used are property of their respective owners.
            </x-app-paragraph>
            <x-social-links class="lg:mt-auto lg:ml-auto" />
        </div>
    </div>
</footer>
