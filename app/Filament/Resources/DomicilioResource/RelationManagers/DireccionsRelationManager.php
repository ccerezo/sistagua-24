<?php

namespace App\Filament\Resources\DomicilioResource\RelationManagers;

use App\Models\Provincia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DireccionsRelationManager extends RelationManager
{
    protected static string $relationship = 'direccions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provincia_id')
                    ->preload()
                    ->native(false)
                    ->live()
                    ->options(Provincia::all()->pluck('nombre', 'id'))
                    ->searchable(),

                Forms\Components\Select::make('ciudad_id')
                    ->required()
                    ->preload()
                    ->native(false)
                    ->searchable()
                    ->live()
                    ->relationship('ciudad','nombre',
                        modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('provincia_id','=',$get('provincia_id')))
                    ->afterStateUpdated(fn (Set $set) => $set('ciudad_id', null)),

                Forms\Components\Select::make('parroquia_id')
                    ->preload()
                    ->native(false)
                    ->searchable()
                    ->live()
                    ->relationship('parroquia','nombre',
                        modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('ciudad_id',$get('ciudad_id'))),

                Forms\Components\TextInput::make('direccion')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('referencia')
                    ->maxLength(255),
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('direccion')
            ->columns([
                Tables\Columns\TextColumn::make('direccion'),
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
