<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','color','activo'];

    public function domicilios() {
        return $this->hasMany(Domicilio::class);
    }

    public function empresas() {
        return $this->hasMany(Empresa::class);
    }
}
