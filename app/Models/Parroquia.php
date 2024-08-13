<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','codigo','active','ciudad_id'];

    public function ciudad() {
        return $this->belongsTo(Ciudad::class);
    }
}
