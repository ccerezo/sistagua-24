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
        $fechaCarbon = Carbon::parse($this->fecha);
        $fecha = Event::make($this)
            ->title($this->numero)
            ->start($fechaCarbon)
            ->end($fechaCarbon->addHour(1));

            //dd($fecha);
            return $fecha;
    }
}
