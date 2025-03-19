@props(['number'])

<span
    class="bg-secondary text-surface-strong transition absolute top-0 right-0 -mt-0.5 -mr-0.5 text-xs font-semibold px-1 rounded-full">
    {{ $number > 99 ? '99+' : $number }}
</span>
