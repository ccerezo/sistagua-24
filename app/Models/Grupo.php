<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','periodo','descripcion','color','active'];

    public function meses() {
        return $this->belongsToMany(Mese::class);
    }

    public function domicilios() {
        return $this->hasMany(Domicilio::class);
    }
}
