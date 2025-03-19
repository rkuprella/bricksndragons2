@props(['stats'])

<div class="relative flex flex-col col-span-12 md:col-span-4 overflow-hidden transition rounded-xl bg-neutral app-card">
    <div class="relative flex flex-col flex-1">
        <img src="{{ asset('images/bg-info.png') }}" alt=""
            class="absolute hidden dark:block inset-0 object-cover w-full h-full pointer-events-none" />
        <div class="relative p-8 grid grid-cols-2 text-foreground/80 md:flex gap-4 md:flex-wrap md:flex-col w-full">
            @foreach ([
        'terrainCount' => 'Terrain Items',
        'miniatureCount' => 'Miniatures',
        'themeCount' => 'Themes',
        'styleCount' => 'Styles',
    ] as $key => $label)
                @php
                    $newKey = str_replace('Count', 'New', $key);
                    $newCount = $stats[$newKey] ?? 0;
                @endphp
                <div class="">
                    <div class="flex items-center gap-4">
                        <div class="text-4xl lg:text-4xl font-bold text-foreground">{{ $stats[$key] }}</div>
                        @if ($newCount > 0)
                            <div
                                class="px-2 py-1 text-xs lg:text-sm font-bold text-surface uppercase bg-primary rounded-full">
                                {{ $newCount > 99 ? '99+' : $newCount }} new
                            </div>
                        @endif
                    </div>
                    <div class="text-sm lg:text-base">{{ $label }}</div>
                </div>
            @endforeach
        </div>
        {{-- <small class="relative px-8 pb-8 gap-2 flex items-center">
            <div class="px-1 py-0.5 text-[8px] font-bold text-surface uppercase bg-primary rounded-full">
                new
            </div>
            = added in the last 30 days
        </small> --}}
    </div>
</div>
