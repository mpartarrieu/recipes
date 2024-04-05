<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Recipe;

class RecipesController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe, string $slug)
    {
        return view('web.recipes.show', ['recipe' => $recipe]);
    }
}
