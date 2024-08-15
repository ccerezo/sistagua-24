<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','codigo','descripcion','precio','activo','tipo_producto_id'];

    public function tipoProducto() {
        return $this->belongsTo(TipoProducto::class);
    }

    public function domicilios(): MorphToMany
    {
        return $this->morphedByMany(Domicilio::class, 'productoable')->withPivot(['cantidad'])->withTimestamps();
    }

    public function empresas(): MorphToMany
    {
        return $this->morphedByMany(Empresa::class, 'productoable')->withPivot(['cantidad'])->withTimestamps();
    }
    
}
