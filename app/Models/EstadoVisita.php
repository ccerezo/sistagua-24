<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoVisita extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','color','active'];

    public function visitas() {
        return $this->hasMany(Visita::class);
    }
}
