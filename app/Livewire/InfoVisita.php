<?php

namespace App\Livewire;

use App\Models\Control;
use App\Models\Domicilio;
use App\Models\ProximaVisita;
use App\Models\Visita;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Livewire\Component;

class InfoVisita extends Component implements HasForms, HasActions
{
    use InteractsWithForms; 
    use InteractsWithActions;
    public $visita;
    public ?array $data = [];
    public ProximaVisita $proximaVisita;
    
    public function mount(Control $control)
    {
        if($control->controlable_type == Domicilio::class){
            $domicilio = Domicilio::find($control->controlable_id);
            $this->visita = Visita::where('visitaable_id',$domicilio->id)->latest()->first();
        }
        $data = ProximaVisita::where('visita_id',$this->visita->id)->first();
        if($data)
            $this->form->fill($data->toArray());
        else{
            $data['observacion'] = '';
            $data['visita_id'] = $this->visita->id;
            $this->form->fill($data);
        }
            
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('observacion')
                    ->label('Recordar'),
                Forms\Components\Hidden::make('visita_id')
            ])
            ->statePath('data')
            ->model(ProximaVisita::class);
    }

    public function create(): void
    {
        ProximaVisita::updateOrCreate(
            ['visita_id' => $this->data['visita_id']],
            $this->data
         );
        Notification::make()
            ->title('Recordatorio creado correctamente.')
            ->success()
            ->send();
    }


    public function render()
    {
        return view('livewire.info-visita');
    }
}
