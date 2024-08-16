<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ObsequioResource\Pages;
use App\Filament\Resources\ObsequioResource\RelationManagers;
use App\Models\Obsequio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObsequioResource extends Resource
{
    protected static ?string $model = Obsequio::class;
    protected static ?string $navigationGroup = 'Configuraciones';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('costo')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('observacion')
                    ->maxLength(250)
                    ->default(null)->columnSpanFull(),
                Forms\Components\TextInput::make('ingresos')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('salidas')
                    ->numeric()
                    ->default(null),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('observacion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('costo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ingresos')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('salidas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListObsequios::route('/'),
            'create' => Pages\CreateObsequio::route('/create'),
            'edit' => Pages\EditObsequio::route('/{record}/edit'),
        ];
    }
}
