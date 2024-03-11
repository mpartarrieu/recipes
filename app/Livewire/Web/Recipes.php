<?php

namespace App\Livewire\Web;

use Livewire\Component;

class Recipes extends Component
{
    public function render()
    {
        return view('livewire.web.recipes')
                    ->extends('layouts.app');
    }
}
