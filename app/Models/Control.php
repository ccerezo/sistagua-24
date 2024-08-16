<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Control extends Model
{
    use HasFactory;

    //protected $fillable = ['tds','ppm','fecha_compra','ultimo_mantenimiento'];
    protected $guarded = [];

    public function controlable(): MorphTo
    {
        return $this->morphTo();
    }
}
