<?php

namespace App\Livewire\Web;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public array $filters = [
        'search' => null,
        'ingredients' => [],
    ];

    protected $queryString = ['filters'];

    public array $ingredients = [];

    public function mount(Request $request): void
    {
        $this->ingredients = Ingredient::select('id', 'name as label')->orderBy('name')->get()->toArray();
    }

    public function render(): View
    {
        $query = Recipe::with('ingredients')->orderBy('name');

        if ($search = Arr::get($this->filters, 'search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($ingredients = Arr::get($this->filters, 'ingredients')) {
            foreach ($ingredients as $ingredientId) {
                $query->whereHas('ingredients', function (Builder $query) use ($ingredientId) {
                    $query->where('ingredients.id', $ingredientId);
                });
            }
        }

        return view('livewire.web.home')
                    ->extends('layouts.app')
                    ->with([
                        'recipes' => $query->paginate(12),
                        'selectedIngredients' => collect($this->ingredients)->whereIn('id', Arr::get($this->filters, 'ingredients', []))->values(),
                    ]);
    }

    public function updated(string $field, mixed $value)
    {
        $this->resetPage();
    }

    public function toggleIngredient(int $ingredientId)
    {
        $ingredients = $this->filters['ingredients'];

        if (($key = array_search($ingredientId, $ingredients)) !== false) {
            unset($ingredients[$key]);
        } else {
            $ingredients[] = $ingredientId;
        }

        $this->filters['ingredients'] = array_values($ingredients);

        $this->resetPage();
    }
}
