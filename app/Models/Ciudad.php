<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','codigo','active','provincia_id'];

    public function provincia() {
        return $this->belongsTo(Provincia::class);
    }

    public function parroquias() {
        return $this->hasMany(Parroquia::class);
    }

}
