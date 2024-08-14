<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Domicilio extends Model
{
    use HasFactory;

    protected $fillable = ['codigo','identificacion','apellido1','apellido2','nombre1','nombre2','cumpleanios','coordinar_visita','celular','images','correo','activo','categoria_id','grupo_id','precio_id'];

    protected $casts = [
        'celular' => 'array',
        'images' => 'array',
        'correo' => 'array',
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function grupo() {
        return $this->belongsTo(Grupo::class);
    }

    public function precio() {
        return $this->belongsTo(Precio::class);
    }

    public function direccions(): MorphMany
    {
        return $this->morphMany(Direccion::class, 'direccionable');
    }

    public function contactos(): MorphMany
    {
        return $this->morphMany(Contacto::class, 'contactoable');
    }
}
