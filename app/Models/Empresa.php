<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['codigo','identificacion','nombre','celular','images','correo','active','categoria_id','grupo_id','precio_id'];

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

    public function facturars(): MorphMany
    {
        return $this->morphMany(Facturar::class, 'facturarable');
    }

    public function productos(): MorphToMany
    {
        return $this->morphToMany(Producto::class, 'productoable')->withPivot(['cantidad'])->withTimestamps();
    }
    
    public function obsequios(): MorphToMany
    {
        return $this->morphToMany(Obsequio::class, 'entregadoable')->withPivot(['cantidad','observacion','contacto_id'])->withTimestamps();
    }
    public function control(): MorphOne
    {
        return $this->MorphOne(Control::class, 'controlable');
    }
}
