<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
        /*
            $this->nav[] = [
                'route' => 'filament.admin.resources.recipes.index',
                'label' => __('Añadir receta'),
            ];
        */
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation');
    }
}
