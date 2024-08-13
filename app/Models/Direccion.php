<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $fillable = ['direccion','referencia','ubicacion','latitud','longitud','equipos_instalados','ciudad_id','parroquia_id'];

    public function direccionable() {
        return $this->morphTo();
    }

    public function ciudad() {
        return $this->belongsTo(Ciudad::class);
    }

    public function parroquia() {
        return $this->belongsTo(Parroquia::class);
    }
}
