<?php

namespace App\Filament\Resources\VisitaResource\Widgets;

use App\Models\Visita;
use Carbon\Carbon;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Guava\Calendar\Actions\CreateAction;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\Event;
use Guava\Calendar\Widgets\CalendarWidget;
use Illuminate\Support\Collection;

class VisitasWidget extends CalendarWidget
{
    //protected static string $view = 'filament.resources.visita-resource.widgets.visitas-widget';
    protected bool $eventClickEnabled = true;

    protected bool $eventDragEnabled = true;

    protected bool $eventResizeEnabled = true;
    protected ?string $defaultEventClickAction = 'edit';

    
    public function getEvents(array $fetchInfo = []): Collection | array
    {
        // $visitas = Visita::all();
        //return $visitas->map(function (Visita $visita) {
        //     return $visita->toEvent();
        // })->toArray();
        
        return collect()->push(...Visita::query()->get());
        
    }
    public function getEventContent(): null | string | array
    {
        return [
            Visita::class => view('filament.resources.visita-resource.widgets.visitas-calendar'),
        ];
    }
    public function getHeaderActions(): array
    {
        return [
                CreateAction::make('createMeeting')
                    ->model(Visita::class),
            ];
    }

    public function getEventClickContextMenuActions(): array
    {
        return [
            $this->editAction(),
            $this->deleteAction(),
        ];
    }


    public function onEventDrop(array $info = []): bool
    {
        // Don't forget to call the parent method to resolve the event record
        parent::onEventDrop($info);
        $record = $this->getEventRecord();

        if ($delta = data_get($info, 'delta')) {
            $startsAt = $record->fecha;
            $startsAt->addSeconds(data_get($delta, 'seconds'));
            $record->update([
                'fecha' => $startsAt,
            ]);

            Notification::make()
                ->title('Visita fue actualizada!')
                ->success()
                ->send()
            ;
            return true;
        }

        return false;
        
    }

    public function getSchema(?string $model = null): ?array
    {
        return match ($model) {
            Visita::class => [
                
                Group::make([
                    DateTimePicker::make('fecha')
                        ->native(false)
                        ->seconds(false)
                        ->required(),
                    DateTimePicker::make('ends_at')
                        ->native(false)
                        ->seconds(false)
                        ->required(),
                ])->columns(),
            ]
        };
    }

    public function getDateClickContextMenuActions(): array
    {
        return [
            CreateAction::make('VISITAAAAS')
                ->model(Visita::class)
                ->mountUsing(function (Form $form, array $arguments) {
                    $date = data_get($arguments, 'dateStr');

                    if ($date) {
                        $form->fill([
                            'starts_at' => Carbon::make($date)->setHour(12),
                            'ends_at' => Carbon::make($date)->setHour(13),
                        ]);
                    }
                }),
        ];
    }

}
