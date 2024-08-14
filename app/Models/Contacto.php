<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $fillable = ['identificacion','apellido1','apellido2','nombre1','nombre2','cumpleanios','telefono','correo','coordinar_visita','tipo_contacto_id'];

    protected $casts = [
        'telefono' => 'array',
        'correo' => 'array',
    ];

    public function contactoable() {
        return $this->morphTo();
    }

    public function tipoContacto() {
        return $this->belongsTo(TipoContacto::class);
    }

    public function fullname(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['apellido1'] . ' ' . $attributes['apellido2']. ' ' . $attributes['nombre1']. ' ' . $attributes['nombre2']
        );
    }
}
