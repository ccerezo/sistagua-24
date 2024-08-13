<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','codigo','descripcion','precio','activo','tipo_producto_id'];

    public function tipoProducto() {
        return $this->belongsTo(TipoProducto::class);
    }
}
