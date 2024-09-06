<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Visita extends Model
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
}
