<?php

namespace App\Filament\Resources\EmpresaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacturarsRelationManager extends RelationManager
{
    protected static string $relationship = 'facturars';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('identificacion'),
                Forms\Components\TextInput::make('nombre'),
                Forms\Components\TextInput::make('direccion'),
                
                Forms\Components\TagsInput::make('telefono'),
                Forms\Components\TagsInput::make('correo'),
                Forms\Components\TagsInput::make('celular'),
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                Tables\Columns\TextColumn::make('identificacion'),
                Tables\Columns\TextColumn::make('nombre'),
                Tables\Columns\TextColumn::make('telefono')->badge(),
                Tables\Columns\TextColumn::make('correo')->badge(),
                Tables\Columns\TextColumn::make('celular')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
