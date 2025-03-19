@props(['model', 'class' => ''])

@php
    $options = [
        'name' => 'Sort by name',
        'created_at' => 'Newest first',
    ];
@endphp

<x-form-select :model="$model" :options="$options" change="setSortBy($event.target.value)" :class="$class"
    {{ $attributes }} />
