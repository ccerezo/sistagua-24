<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Obsequio extends Model
{
    use HasFactory;
    
    protected $fillable = ['nombre','observacion','costo','ingresos','salidas','active'];

    public function domicilios(): MorphToMany
    {
        return $this->morphedByMany(Domicilio::class, 'entregadoable')->withPivot(['cantidad','observacion','contacto_id'])->withTimestamps();
    }

    public function empresas(): MorphToMany
    {
        return $this->morphedByMany(Empresa::class, 'entregadoable')->withPivot(['cantidad','observacion','contacto_id'])->withTimestamps();
    }
}
