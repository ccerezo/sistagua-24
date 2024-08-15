<?php

namespace App\Filament\Resources\DomicilioResource\RelationManagers;

use App\Models\Contacto;
use App\Models\Domicilio;
use App\Models\Empresa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObsequiosRelationManager extends RelationManager
{
    protected static string $relationship = 'obsequios';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->allowDuplicates()
            ->columns([
                Tables\Columns\TextColumn::make('nombre'),
                Tables\Columns\TextColumn::make('cantidad'),
                Tables\Columns\TextColumn::make('contacto.fullname'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('cantidad')
                            ->numeric(),
                        Forms\Components\Select::make('contacto_id')
                            ->preload()
                            ->native(false)
                            ->options(Contacto::where('contactoable_type','=',Domicilio::class)->get()->pluck('fullname', 'id')),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
