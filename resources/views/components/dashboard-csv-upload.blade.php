@props(['csv_file', 'class' => ''])

<div class="relative flex flex-col gap-1 {{ $class }}">
    <x-form-label for="csv_file" label="Upload Parts List (CSV)" />
    <input id="csv_file" type="file" wire:model="csv_file"
        class="p-4 rounded-md bg-neutral border border-foreground/50 text-foreground cursor-pointer">
    @error('csv_file')
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>

<x-parts-list :csvPath="$csv_file" />
