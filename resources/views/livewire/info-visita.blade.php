<div>
    <div class="bg-primary-600 text-white rounded-xl shadow w-32 h-32 mx-auto text-center mb-2">
        <div class="text-3xl pt-4">
            <div>{{\Carbon\Carbon::parse($visita->fecha)->locale('es_ES')->isoFormat('D')}}</div>
        </div>
        <div class="text-xl">
            {{\Carbon\Carbon::parse($visita->fecha)->locale('es_ES')->isoFormat('MMMM')}} 
        </div>
        <div class="text-xl">
            {{\Carbon\Carbon::parse($visita->fecha)->locale('es_ES')->isoFormat('YYYY')}} 
        </div>
    </div>
    <div class="text-sm text-center italic text-gray-700 mb-5">Fecha tentativa agendada para la próxima visita.</div>
    <x-filament::section icon="heroicon-o-calendar" class="mt-2">
        <x-slot name="heading">
            Recordatorio para siguiente Visita
        </x-slot>
    
        
            {{ $this->form }}
            
            <x-filament::button wire:click="create" class="mt-2">
                Guardar
            </x-filament::button>
        
        
    </x-filament::section>
    
    
    
</div>
