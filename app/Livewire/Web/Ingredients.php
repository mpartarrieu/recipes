<?php

namespace App\Livewire\Web;

use Livewire\Component;

class Ingredients extends Component
{
    public function render()
    {
        return view('livewire.web.ingredients')
                    ->extends('layouts.app');
    }
}
