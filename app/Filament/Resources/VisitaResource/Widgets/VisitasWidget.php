<?php

namespace App\Filament\Resources\VisitaResource\Widgets;

use App\Models\Visita;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\Event;
use Guava\Calendar\Widgets\CalendarWidget;
use Illuminate\Database\Eloquent\Collection;

class VisitasWidget extends CalendarWidget
{
    //protected static string $view = 'filament.resources.visita-resource.widgets.visitas-widget';
    protected ?string $locale = 'es';
    //protected ?string $timeZone = 'America/Guayaquil';
    protected string $calendarView = 'dayGridMonth';
    protected bool $eventDragEnabled = true;

    
    public function getEvents(array $fetchInfo = []): Collection | array
    {
        $visitas = Visita::all();
        return $visitas->map(function (Visita $visita) {
            return $visita->toEvent();
        })->toArray();
        // return [
             
        //     //Eloquent model implementing the `Eventable` interface
            
        //     Visita::all()->toArray()
        // ];
    }
    public function onEventDrop(array $info = []): bool
    {
        // Don't forget to call the parent method to resolve the event record
        parent::onEventDrop($info);
    
        dd($info);
        // Validate the data
        // Update the record ($this->getEventRecord())
        //dd($this->getEventRecord());

        // $info contains the event data:
        // $info['event'] - the event object
        // $info['oldEvent'] - the event object before resizing
        // $info['oldResource'] - the old resource object
        // $info['newResource'] - the new resource object
        // $info['delta'] - the duration object representing the amount of time the event was moved by
        // $info['view'] - the view object
        if($info['oldEvent']['start'] == $info['event']['start']) return false;
        //dd($info['event']['start']);
        dd(Carbon::parse($info['event']['start'], 'America/Guayaquil'));
        $this->getEventRecord()->fecha = Carbon::parse($info['event']['start'], 'America/Guayaquil');
        $this->getEventRecord()->save();
        return true;
        // Return true if the event was moved successfully
        // Return false if the event was not moved and should be reverted on the client-side
    }
}
