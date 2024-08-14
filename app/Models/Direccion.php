<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $fillable = ['direccion','referencia','ubicacion','latitud','longitud','telefono','equipos_instalados','provincia_id','ciudad_id','parroquia_id'];

    protected $casts = [
        'telefono' => 'array',
    ];

    public function direccionable() {
        return $this->morphTo();
    }

    public function provincia() {
        return $this->belongsTo(Provincia::class);
    }

    public function ciudad() {
        return $this->belongsTo(Ciudad::class);
    }

    public function parroquia() {
        return $this->belongsTo(Parroquia::class);
    }
}
