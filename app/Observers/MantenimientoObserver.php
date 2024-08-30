<?php

namespace App\Observers;

use App\Mail\Mantenimiento as MailMantenimiento;
use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\FichaTecnica;
use App\Models\Mantenimiento;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MantenimientoObserver
{
    /**
     * Handle the Mantenimiento "created" event.
     */
    public function created(Mantenimiento $mantenimiento): void
    {
        $ficha = new FichaTecnica();
        $ficha->numero = $mantenimiento->numero_ficha;
        $ficha->mantenimiento_id = $mantenimiento->id;
        $ficha->save();
    }

    /**
     * Handle the Mantenimiento "updated" event.
     */
    public function updated(Mantenimiento $mantenimiento): void
    {
        
    }

    /**
     * Handle the Mantenimiento "deleted" event.
     */
    public function deleted(Mantenimiento $mantenimiento): void
    {
        //
    }

    /**
     * Handle the Mantenimiento "restored" event.
     */
    public function restored(Mantenimiento $mantenimiento): void
    {
        //
    }

    /**
     * Handle the Mantenimiento "force deleted" event.
     */
    public function forceDeleted(Mantenimiento $mantenimiento): void
    {
        //
    }
}
