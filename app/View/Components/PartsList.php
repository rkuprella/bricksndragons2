<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PartsList extends Component
{
    public string|null $csvPath;

    /**
     * Create a new component instance.
     */
    public function __construct(string|null $csvPath = null)
    {
        $this->csvPath = $csvPath;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.parts-list');
    }
}