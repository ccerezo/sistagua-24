<?php

namespace App\Observers;

use App\Mail\Mantenimiento as MailMantenimiento;
use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
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
        //
    }

    /**
     * Handle the Mantenimiento "updated" event.
     */
    public function updated(Mantenimiento $mantenimiento): void
    {
        if(!$mantenimiento->notificado) {
            $control = Control::find($mantenimiento->control_id);
            $enviar_a = array();
            if($control->controlable_type == Domicilio::class){
                $domicilio = Domicilio::find($control->controlable_id);
                if($domicilio->correo) array_push($enviar_a, $domicilio->correo);
                foreach ($domicilio->contactos as $contacto) {
                    if($contacto->correo) array_push($enviar_a, $contacto->correo);
                }
                $data['correos'] = array_merge(...$enviar_a);
            }
            if($control->controlable_type == Empresa::class){
                $empresa = Empresa::find($control->controlable_id);
                if($empresa->correo) array_push($enviar_a, $empresa->correo);
                foreach ($empresa->contactos as $contacto) {
                    if($contacto->correo) array_push($enviar_a, $contacto->correo);
                }
                $data['correos'] = array_merge(...$enviar_a);
            }
            
            $body = new MailMantenimiento($control, $domicilio);
            Mail::to($data['correos'])->send($body);

            $recipient = Auth::user();
            Notification::make()
                ->title('Correo Enviado a: '. $domicilio->fullname)
                ->body('Mantenimiento realizado: '. $mantenimiento->fecha)
                ->sendToDatabase($recipient);
        }
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
