<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitaResource\Pages;
use App\Filament\Resources\VisitaResource\RelationManagers;
use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\Visita;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitaResource extends Resource
{
    protected static ?string $model = Visita::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema([
                        Group::make()->schema([
                            Forms\Components\TextInput::make('numero')
                                ->required()
                                ->numeric(),
                            Forms\Components\DateTimePicker::make('fecha')
                                ->required(),
                        ])->columns(2),
                    
                    Forms\Components\MorphToSelect::make('visitaable')
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
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make()->schema([
                        Forms\Components\Select::make('estado_visita_id')
                        ->required()
                        ->preload()
                        ->native(false)
                            ->relationship(
                                name: 'estadoVisita',
                            )
                            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nombre}")
                            ->searchable()
                            ->createOptionForm([
                                Group::make()->schema([
                                    
                                    Forms\Components\TextInput::make('nombre')
                                        ->required(),
                                    Forms\Components\ColorPicker::make('color'),
                                ])
                            
                            ]),

                        Forms\Components\ToggleButtons::make('realizada')
                            ->label('Visita realizada?')
                            ->boolean()
                            ->inline(),
                        
                        Forms\Components\Textarea::make('observacion')
                            ->columnSpanFull(),
                    ])->columns(2)
                ])->columnSpan(2),
                
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('visitaable_type')
                ->label('Tipo')
                ->badge()
                ->state(function (Visita $record): string {
                    if($record->visitaable_type == Domicilio::class) return 'Domicilio';
                    if($record->visitaable_type == Empresa::class) return 'Empresa';
                })
                ->color(fn (string $state): string => match ($state) {
                    'Domicilio' => 'primary',
                    'Empresa' => 'success',
                })
                ->searchable(),
                Tables\Columns\TextColumn::make('visitaable_id')
                    ->label('Cliente')
                    ->state(function (Visita $record): string {
                        if($record->visitaable_type == Domicilio::class){
                            $domicilio = Domicilio::find($record->visitaable_id);
                            return $domicilio->fullname;
                        }
                        if($record->visitaable_type == Empresa::class){
                            $empresa = Empresa::find($record->visitaable_id);
                            return $empresa->nombre;
                        }
                    }),
                Tables\Columns\IconColumn::make('realizada')
                    ->boolean(),
                Tables\Columns\TextColumn::make('estadoVisita.nombre')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListVisitas::route('/'),
            'create' => Pages\CreateVisita::route('/create'),
            'edit' => Pages\EditVisita::route('/{record}/edit'),
        ];
    }
}
