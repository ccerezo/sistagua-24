<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ControlResource\Pages;
use App\Filament\Resources\ControlResource\RelationManagers;
use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ControlResource extends Resource
{
    protected static ?string $model = Control::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MorphToSelect::make('controlable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(Domicilio::class)
                            ->getOptionLabelFromRecordUsing(fn (Domicilio $record): string => "{$record->apellido1} {$record->apellido1} {$record->nombre1} {$record->nombre2}"),
                        Forms\Components\MorphToSelect\Type::make(Empresa::class)
                            ->titleAttribute('nombre')
                    ])
                    ->searchable()
                    ->preload()
                    ->columnSpan(3),

                Forms\Components\TextInput::make('tds')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ppm')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('fecha_compra')
                    
                
                // Forms\Components\TextInput::make('controlable_type')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('controlable_id')
                //     ->required()
                //     ->numeric(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->groups([
            //     'controlable_type',
            // ])
            ->columns([
                Tables\Columns\TextColumn::make('tds')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ppm')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_compra')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                // Tables\Columns\TextColumn::make('contacto')
                //     ->badge()
                //     ->state(function (Control $record): string {
                //         if($record->controlable_type == Domicilio::class){
                //             $domicilio = Domicilio::find($record->controlable_id);
                //             foreach ($domicilio->contactos as $contacto) {
                //                 return $contacto->nombre1;
                //             }
                //             //return $domicilio->contactos;
                //         }
                //         return false;
                //     }),
                Tables\Columns\TextColumn::make('ultimo_mantenimiento')
                    ->label('Último Mant.')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('controlable.identificacion')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('controlable.codigo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('controlable_type')
                    ->label('Tipo')
                    ->badge()
                    ->state(function (Control $record): string {
                        if($record->controlable_type == Domicilio::class){
                            return 'Domicilio';
                        }
                        if($record->controlable_type == Empresa::class){
                            return 'Empresa';
                        }
                        return '';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Domicilio' => 'primary',
                        'Empresa' => 'success',
                    })
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('controlable_id')
                    ->label('Nombre Cliente')
                    ->state(function (Control $record): string {
                        if($record->controlable_type == Domicilio::class){
                            $domicilio = Domicilio::find($record->controlable_id);
                            return $domicilio->fullname;
                        }
                        if($record->controlable_type == Empresa::class){
                            $empresa = Empresa::find($record->controlable_id);
                            return $empresa->nombre;
                        }
                        return '';
                    })
                    ->searchable(),
                    // ->description(function (Control $record): string {
                    //     if($record->controlable_type == Domicilio::class){
                    //         $domicilio = Domicilio::find($record->controlable_id);
                    //         $parentescos = '';
                    //         foreach ($domicilio->contactos as $contacto) {
                    //             $parentescos.=$contacto->fullname."-";
                    //         }
                    //         return $parentescos;
                    //     }
                    //     return false;
                    // }),
                    
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
                Tables\Filters\SelectFilter::make('controlable_type')
                    ->options([
                        Domicilio::class => 'Domicilio',
                        Empresa::class => 'Empresa',
                    ]),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListControls::route('/'),
            'create' => Pages\CreateControl::route('/create'),
            'edit' => Pages\EditControl::route('/{record}/edit'),
        ];
    }
}
