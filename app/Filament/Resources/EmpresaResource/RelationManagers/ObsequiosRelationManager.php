<?php

namespace App\Filament\Resources\EmpresaResource\RelationManagers;

use App\Models\Contacto;
use App\Models\Empresa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

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
                Forms\Components\TextInput::make('cantidad')->required(),
                Forms\Components\Select::make('contacto_id')
                            ->label('Entregado a')
                            ->options(fn(Get $get): Collection => Contacto::query()
                                ->where('contactoable_type','=',Empresa::class)
                                ->get()->pluck('fullname','id'))
                            ->preload()
                            ->native(false)
                            ->live(),
                            
                Forms\Components\TextInput::make('observacion'),
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
                Tables\Columns\SelectColumn::make('contacto_id')
                    ->label('Entregado a')
                    ->options(Contacto::where('contactoable_type','=',Empresa::class)->get()->pluck('fullname', 'id'))
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('observacion')
                    ->toggleable(isToggledHiddenByDefault: false),
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
                            ->options(Contacto::where('contactoable_type','=',Empresa::class)->get()->pluck('fullname', 'id')),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
