<?php

namespace App\Observers;

use App\Mail\Mantenimiento as MailMantenimiento;
use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\FichaTecnica;
use App\Models\Mantenimiento;
use App\Models\Visita;
use Carbon\Carbon;
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
        /* CREO LA FICHA TECNICA*/
        $ficha = new FichaTecnica();
        $ficha->numero = $mantenimiento->numero_ficha;
        $ficha->mantenimiento_id = $mantenimiento->id;
        $ficha->save();

        /* CREO EL REGISTRO DE LA PROXIMA VISITA*/
        $control = $mantenimiento->control;
        $fecha = Carbon::now();
        $latestVisita = Visita::latest()->first();
        $latestVisita ? $numero = $latestVisita->numero+1 : $numero = 1;
        if($control->controlable_type == Domicilio::class){
            $domicilio = Domicilio::find($control->controlable_id);
            $periodo = $domicilio->grupo->periodo;
            (strcmp($periodo, 'Trimestral') == 0) ? $fecha = $fecha->addMonths(3) : ((strcmp($periodo, 'Semestral') == 0) ? $fecha = $fecha->addMonths(6) : '');
            $domicilio->visitas()->create([
                'fecha' => $fecha,
                'realizada' => false,
                'numero' => $numero,
                'estado_visita_id' => 1
            ]);
            
        }
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
        $ficha = FichaTecnica::where('mantenimiento_id', $mantenimiento->id);
        $ficha->delete();
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
