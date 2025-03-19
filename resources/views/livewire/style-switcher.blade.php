<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Style;

new class extends Component {
    public string $selectedStyle;

    public function updatedSelectedStyle($value)
    {
        session(['selectedStyle' => $value]); // Save globally
        $this->dispatch('styleUpdated', $value); // Notify other components
    }

    public function with()
    {
        return [
            'styles' => Style::whereHas('itemType', function ($query) {
                $query->where('name', 'Terrain');
            })
                ->pluck('name', 'id')
                ->toArray(),
            'selectedStyle' => session('selectedStyle', Style::first()?->id ?? ''),
        ];
    }
};
?>

<x-form-select label="Pick your style:" model="selectedStyle" color="primary" size="large" :options="$styles" />
