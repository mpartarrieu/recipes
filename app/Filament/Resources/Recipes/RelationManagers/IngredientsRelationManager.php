<?php

namespace App\Filament\Resources\Recipes\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\AttachAction;
use Filament\Actions\EditAction;
use Filament\Actions\DetachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachBulkAction;
use App\Models\Ingredient;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IngredientsRelationManager extends RelationManager
{
    protected static string $relationship = 'ingredients';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('name')
                    ->required()
                    ->options(Ingredient::all()->pluck('name', 'name'))
                    ->searchable()
                    ->preload(),
                TextInput::make('amount')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('amount'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                ->form(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    TextInput::make('amount')
                        ->required(),
                ]),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
