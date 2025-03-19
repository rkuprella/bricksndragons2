@props(['csv_file'])

<div>
    <label class="text-sm font-medium text-foreground-muted">Upload Parts List (CSV)</label>
    <input type="file" wire:model="csv_file"
        class="w-full px-3 py-2 rounded-md bg-foreground text-surface border border-border focus:ring-2 focus:ring-primary">
    @error('csv_file')
        <span class="text-danger text-sm">{{ $message }}</span>
    @enderror
</div>

<x-parts-list :csvPath="$csv_file" />
