<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','codigo','codigo_telefono','active'];

    public function ciudads() {
        return $this->hasMany(Ciudad::class);
    }
}
