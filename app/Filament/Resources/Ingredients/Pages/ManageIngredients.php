<?php

namespace App\Filament\Resources\Ingredients\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Ingredients\Ingredients\IngredientResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageIngredients extends ManageRecords
{
    protected static string $resource = IngredientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
