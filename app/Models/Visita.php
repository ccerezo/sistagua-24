<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Visita extends Model
{
    use HasFactory;

    //protected $fillable = ['numero','fecha','observacion','realizada','estado_visita_id'];

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

}
