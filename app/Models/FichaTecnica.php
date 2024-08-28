<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTecnica extends Model
{
    use HasFactory;

    protected $fillable = ['numero','detalle_tds','dureza_color_tds','recomendacion_tds','detalle_ppm','recomendacion_ppm','subtotal',
                            'iva','descuento','total','recomendacion_sistagua','mantenimiento_id'];

    public function mantenimiento() {
        return $this->belongsTo(Mantenimiento::class);
    }
}
