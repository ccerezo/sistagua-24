<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Autoriza extends Model
{
    use HasFactory;

    protected $fillable = ['identificacion','apellido1','apellido2','nombre1','nombre2','firma'];

    public function fullname(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['apellido1'] . ' ' . $attributes['apellido2']. ' ' . $attributes['nombre1']. ' ' . $attributes['nombre2']
        );
    }

    public function mantenimientos() {
        return $this->hasMany(Mantenimiento::class);
    }

}
