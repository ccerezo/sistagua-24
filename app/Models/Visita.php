<?php

namespace App\Models;

use Carbon\Carbon;
use Guava\Calendar\Contracts\Eventable;
use Guava\Calendar\ValueObjects\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Visita extends Model implements Eventable
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function visitaable(): MorphTo
    {
        return $this->morphTo();
    }

    public function estadoVisita() {
        return $this->belongsTo(EstadoVisita::class);
    }

    public function proximaVisita(): BelongsTo
    {
        return $this->belongsTo(ProximaVisita::class);
    }

    public function toEvent(): Event|array {
        $fechaStart = Carbon::parse($this->fecha);
        $fechaEnd = Carbon::parse($this->fecha)->addHour(2);
        //dd($this);
        $this->visitaable_type === Domicilio::class ? $titulo = $this->visitaable->fullname : $titulo = $this->visitaable->nombre ;
        $event = Event::make($this)
            ->title($titulo)
            ->start($this->fecha)
            ->end($this->fecha)
            ->display('block');
            //dd($event);
            return $event;
    }
}
