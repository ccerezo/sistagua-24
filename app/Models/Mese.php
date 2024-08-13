<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mese extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','numero','color'];

    public function grupos() {
        return $this->belongsToMany(Grupo::class);
    }
}
