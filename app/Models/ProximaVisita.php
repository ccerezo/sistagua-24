<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProximaVisita extends Model
{
    use HasFactory;

    protected $fillable = ['observacion'];

    public function visita() {
        return $this->hasOne(Visita::class);
    }
}
