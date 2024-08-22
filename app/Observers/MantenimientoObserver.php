<?php

namespace App\Observers;

use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Mantenimiento;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class MantenimientoObserver
{
    /**
     * Handle the Mantenimiento "created" event.
     */
    public function created(Mantenimiento $mantenimiento): void
    {
        //
    }

    /**
     * Handle the Mantenimiento "updated" event.
     */
    public function updated(Mantenimiento $mantenimiento): void
    {
        $control = Control::find($mantenimiento->control_id);
        $domicilio = Domicilio::find($control->controlable_id);
        $recipient = Auth::user();
        Notification::make()
            ->title('Correo Enviado a: '. $domicilio->fullname)
            ->body('Mantenimiento realizado: '. $mantenimiento->fecha)
            ->sendToDatabase($recipient);
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
