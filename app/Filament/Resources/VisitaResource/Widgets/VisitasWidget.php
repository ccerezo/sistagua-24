<?php

namespace App\Filament\Resources\VisitaResource\Widgets;

use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\Visita;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

class VisitasWidget extends FullCalendarWidget
{
    public Model | string | null $model = Visita::class;
    public ?string $selecttrack = null;

    public function fetchEvents(array $fetchInfo): array
    {
        return Visita::query()
            ->get()
            ->map(
                fn (Visita $event) => EventData::make() 
                    ->id($event->id)
                    ->title($event->visitaable->fullname)
                    ->backgroundColor($event->estadoVisita->color)
                    ->start($event->fecha)
                    ->end($event->fecha)
            )
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            
            Group::make()->schema([
                
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
                            ->getOptionLabelFromRecordUsing(fn (Domicilio $record): string => "{$record->apellido1} {$record->apellido2} {$record->nombre1} {$record->nombre2} - {$record->codigo}"),
                        Forms\Components\MorphToSelect\Type::make(Empresa::class)
                            ->titleAttribute('nombre')                            
                        
                    ])->columnSpanFull()
                    ->searchable()
                    ->preload(),
                
            ])->columnSpan(2)->model($this->model),

            Group::make()->schema([
                
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
                
            ])->columns(2),
        ];
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->model(Visita::class)
                ->mountUsing(
                    function (Forms\Form $form, array $arguments) {
                    $latestVisita = Visita::latest()->first();
                        $form->fill([
                            'numero' => $latestVisita->numero+1 ?? 1
                        ]);
                    }
                )
                ->action(function (array $data): void {
                    //dd($data);
                    $visita = new Visita($data);
                    $visita->save();
                    // $record->author()->associate($data['authorId']);
                    // $record->save();
                    
                }),
        ];
    }
    
    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mountUsing(
                    function (Visita $record, Forms\Form $form, array $arguments) {
                        //dd($record);
                        $form->fill([
                            'fecha' => $arguments['event']['start'] ?? $record->fecha,
                            'visitaable_type' => $record->visitaable_type,
                            'visitaable_id' => $record->visitaable_id,
                            'realizada' => $record->realizada,
                            'numero' => $record->numero,
                        ]);
                }
            ),
            Actions\DeleteAction::make(),
        ];
    }
}
