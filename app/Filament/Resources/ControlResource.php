<?php

namespace App\Filament\Resources;

use App\Filament\Pages as GeneralPages;
use App\Filament\Resources\ControlResource\Pages;
use App\Filament\Resources\ControlResource\RelationManagers;
use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\Mantenimiento;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
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
                Group::make()->schema([
                    Section::make()->schema([
                    Forms\Components\MorphToSelect::make('controlable')
                        ->label('Cliente')
                        ->types([
                            
                        Forms\Components\MorphToSelect\Type::make(Domicilio::class)
                            ->getOptionLabelFromRecordUsing(fn (Domicilio $record): string => "{$record->apellido1} {$record->apellido1} {$record->nombre1} {$record->nombre2} - {$record->codigo}"),
                        Forms\Components\MorphToSelect\Type::make(Empresa::class)
                            ->titleAttribute('nombre')                            
                            
                        ])->columnSpanFull()
                        ->searchable()
                        ->preload(),
                    ])
                ])->columnSpan(3),
                
                
                Group::make()->schema([
                    Section::make()->schema([
                        Forms\Components\TextInput::make('tds')
                        ->required()
                        ->numeric(),
                        Forms\Components\TextInput::make('ppm')
                        ->required()
                        ->numeric(),
                        Forms\Components\DatePicker::make('fecha_compra')
                        ->columnSpanFull(),
                    ])->columns(2)
                ])->columnSpan(2)
                
            ])->columns(5);
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
                    ->sortable()
                    ->state(function (Control $record): string {
                        $ultimoMant = Mantenimiento::where('control_id',$record->id)
                                ->latest()->first();
                        return $ultimoMant->fecha;
                    }),
                Tables\Columns\TextColumn::make('controlable.identificacion')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('controlable.codigo')
                    ->label('Código')
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
                    ->label('Cliente')
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
            RelationManagers\MantenimientosRelationManager::class,
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

    // public static function getRecordSubNavigation(Page $page): array
    // {
    //     return $page->generateNavigationItems([
    //         // ...
    //         Pages\HistorialProductos::class,
    //     ]);
    // }

}
