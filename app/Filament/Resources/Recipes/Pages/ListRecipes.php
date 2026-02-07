<?php

namespace App\Filament\Resources\Recipes\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Recipes\Recipes\RecipeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecipes extends ListRecords
{
    protected static string $resource = RecipeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
