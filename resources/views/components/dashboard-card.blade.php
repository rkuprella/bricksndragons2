@props(['title', 'items', 'route', 'listRoute', 'createRoute', 'createText', 'class' => ''])

<div class="bg-neutral flex flex-col gap-4 p-4 rounded-md shadow-lg {{ $class }}">
    <div class="flex justify-between items-center">

        <h2 class="text-xl lg:text-2xl font-semibold text-foreground">
            <a href="{{ route($listRoute) }}" class="hover:underline">
                {{ $title }}
            </a>
        </h2>
        <x-app-button :href="route($createRoute)" label="{{ $createText }}" color="primary" variant="outline" size="small" />
    </div>

    @if ($items->isEmpty())
        <p class="text-sm text-foreground/70">No recent updates.</p>
    @else
        <ul class="divide-y divide-foreground/10">
            @foreach ($items as $item)
                <li
                    class="group flex justify-between items-center text-sm py-1.5 transition text-foreground/80 hover:text-foreground-strong">
                    <div>
                        <span class="truncate">{{ $item->name }}</span>
                        <span class="text-xs text-foreground/50 group-hover:text-foreground/70 transition block">
                            Created {{ $item->created_at->diffForHumans() }}
                            @if ($item->user)
                                by <strong>{{ $item->user->name }}</strong>
                            @endif
                        </span>
                    </div>
                    <x-app-button href="{{ route($route, $item) }}" label="Edit" size="small" />
                </li>
            @endforeach
        </ul>
    @endif
</div>
