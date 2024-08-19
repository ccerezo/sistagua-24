<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $fillable = ['direccion','referencia','latitud','longitud','telefono','equipos_instalados','provincia_id','ciudad_id','parroquia_id'];

    protected $casts = [
        'telefono' => 'array',
    ];

    protected $appends = [
        'ubicacion',
    ];

    public function direccionable() {
        return $this->morphTo();
    }

    public function provincia() {
        return $this->belongsTo(Provincia::class);
    }

    public function ciudad() {
        return $this->belongsTo(Ciudad::class);
    }

    public function parroquia() {
        return $this->belongsTo(Parroquia::class);
    }

    public function getUbicacionAttribute(): array
    {
        return [
            "lat" => (float)$this->latitud,
            "lng" => (float)$this->longitud,
        ];
    }

    public function setUbicacionAttribute(?array $location): void
    {
        if (is_array($location))
        {
            $this->attributes['latitud'] = $location['lat'];
            $this->attributes['longitud'] = $location['lng'];
            unset($this->attributes['ubicacion']);
        }
    }

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitud',
            'lng' => 'longitud',
        ];
    }

    public static function getComputedLocation(): string
    {
        return 'ubicacion';
    }
}
