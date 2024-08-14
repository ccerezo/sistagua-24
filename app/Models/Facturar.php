<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturar extends Model
{
    use HasFactory;
    protected $fillable = ['identificacion','nombre','direccion','correo','celular','telefono'];

    protected $casts = [
        'telefono' => 'array',
        'correo' => 'array',
        'celular' => 'array',
    ];

    public function facturarable() {
        return $this->morphTo();
    }
}
