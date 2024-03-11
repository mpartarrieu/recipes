<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navigation extends Component
{
    /**
     * The component navigation.
     */
    public array $nav = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->nav[] = [
            'route' => 'recipes',
            'label' => __('Recetas'),
        ];

        $this->nav[] = [
            'route' => 'ingredients',
            'label' => __('Ingredientes'),
        ];

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation');
    }
}
