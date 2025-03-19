@props(['categories', 'title', 'model'])

@if ($categories)
    <div class="flex flex-col gap-3 text-foreground">
        <h2 class="text-xs text-foreground/50 font-semibold">{{ $title }}</h2>
        @foreach ($categories as $category)
            <x-form-checkbox :label="$category" :model="$model" :value="$category" color="secondary" />
        @endforeach
    </div>
@endif
