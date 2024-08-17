<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $fillable = ['control_id','tipo_doc','numero','numero_ficha','fecha','descripcion','tds','ppm','firma','notificado','autoriza_id','persona_matenimiento_id'];

    public function autoriza() {
        return $this->belongsTo(Autoriza::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'persona_matenimiento_id');
    }

    public function control() {
        return $this->belongsTo(Control::class);
    }
}
