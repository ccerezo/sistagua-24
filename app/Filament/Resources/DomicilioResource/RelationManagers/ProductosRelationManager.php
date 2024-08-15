<?php

namespace App\Filament\Resources\DomicilioResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductosRelationManager extends RelationManager
{
    protected static string $relationship = 'productos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cantidad')->required(),
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                Tables\Columns\TextColumn::make('nombre'),
                Tables\Columns\TextInputColumn::make('cantidad')->type('number'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->multiple()      
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
