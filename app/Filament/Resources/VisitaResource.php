<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitaResource\Pages;
use App\Filament\Resources\VisitaResource\RelationManagers;
use App\Models\Direccion;
use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\Visita;
use Carbon\Carbon;
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
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('numero')
                    ->label('N°')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->dateTime('M j, Y, H:i')
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
                    ->searchable()
                    ->getStateUsing(function (Visita $record): string {
                        if($record->visitaable_type == Domicilio::class){
                            $domicilio = Domicilio::find($record->visitaable_id);
                            return $domicilio->fullname;
                        }
                        if($record->visitaable_type == Empresa::class){
                            $empresa = Empresa::find($record->visitaable_id);
                            return $empresa->nombre;
                        }
                    })
                    ->description(function (Visita $record): string {
                        if($record->visitaable_type == Domicilio::class){
                            $domicilio = Domicilio::find($record->visitaable_id);
                            return $domicilio->codigo;
                        }
                        if($record->visitaable_type == Empresa::class){
                            $empresa = Empresa::find($record->visitaable_id);
                            return $empresa->codigo;
                        }
                    })
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHasMorph(
                            'visitaable', [Domicilio::class, Empresa::class],
                            function ($query, $type) use ($search) {
                                // $column = $type === Domicilio::class ? 'concat_ws(" ", apellido1, apellido2, nombre1, nombre2)' : 'nombre';
                                // $query->whereRaw($column, 'like', '%'.$search.'%');
                                if ($type === Domicilio::class) {
                                    $query->where('nombre1', 'like', '%'.$search.'%')
                                        ->orWhere('apellido1', 'like', '%'.$search.'%');
                                } elseif ($type === Empresa::class) {
                                    $query->where('nombre', 'like', '%'.$search.'%');
                                }
                            }
                        );
                    }),
                Tables\Columns\TextColumn::make('Direccion')
                    ->state(function (Visita $record): string {
                        $direccion = Direccion::where('direccionable_type',$record->visitaable_type)
                                            ->where('direccionable_id',$record->visitaable_id)
                                            ->where('equipos_instalados',true)->first();
                        return $direccion->ciudad->nombre;
                        
                    })
                    ->description(function (Visita $record): string {
                        $direccion = Direccion::where('direccionable_type',$record->visitaable_type)
                                            ->where('direccionable_id',$record->visitaable_id)
                                            ->where('equipos_instalados',true)->first();
                        return $direccion->direccion;
                        
                    }),

                Tables\Columns\IconColumn::make('realizada')
                    ->boolean(),
                Tables\Columns\TextColumn::make('estadoVisita.nombre')
                    ->searchable()
                    
                    ->color(fn (string $state): string => match ($state) {
                        'Agendado' => 'gray',
                        'Terminada' => 'success',
                        'Postergada' => 'pink',
                        'rejected' => 'danger',
                    }),
                
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
                Tables\Filters\SelectFilter::make('visitaable_type')
                    ->options([
                        Domicilio::class => 'Domicilio',
                        Empresa::class => 'Empresa',
                    ]),
                Tables\Filters\SelectFilter::make('estadoVisita')
                    ->relationship('estadoVisita', 'nombre'),
                Tables\Filters\Filter::make('fecha')
                    ->form([
                        Forms\Components\DatePicker::make('fecha_desde'),
                        Forms\Components\DatePicker::make('fecha_hasta')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['fecha_desde'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha', '>=', $date),
                            )
                            ->when(
                                $data['fecha_hasta'],
                                fn (Builder $query, $date): Builder => $query->whereDate('fecha', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['fecha_desde']) {
                            return null;
                        }
                 
                        return 'Desde: ' . Carbon::parse($data['fecha_desde'])->toFormattedDateString() .
                                ' - Hasta: ' . Carbon::parse($data['fecha_hasta'])->toFormattedDateString();
                    })
            ])
            ->filtersTriggerAction(
                fn (Tables\Actions\Action $action) => $action
                    ->button()
                    ->slideOver()
                    ->label('Búsquedad Avanza'),
            )
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
