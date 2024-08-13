<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','porcentaje','color','calculo_automatico','active'];

    public function domicilios() {
        return $this->hasMany(Domicilio::class);
    }
}
