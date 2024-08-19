<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosUsado extends Model
{
    use HasFactory;

    protected $fillable = ['cantidad','descripcion','producto_id','mantenimiento_id'];

    public function mantenimiento() {
        return $this->belongsTo(Mantenimiento::class);
    }
    public function producto() {
        return $this->belongsTo(Producto::class);
    }

}
