<?php

namespace App\Filament\Resources\EmpresaResource\Pages;

use App\Filament\Resources\EmpresaResource;
use App\Models\Empresa;
use App\Models\Facturar;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmpresa extends CreateRecord
{
    protected static string $resource = EmpresaResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     if($data['facturar']){

    //         $facturar = new Facturar();
    //         $facturar->identificacion = $data['identificacion'];
    //         $facturar->nombre =  $data['nombre'];
    //         $facturar->direccion =  '';
    //         $facturar->telefono =  '';
    //         $facturar->correo =  $data['correo'];
    //         $facturar->celular =  $data['celular'];
    //         $facturar->facturarable = Empresa::class;
    //         $facturar->save();
    //     }
    
    //     return $data;
    // }

    protected function afterCreate(): void
    {

        $this->record->facturars()->create([
            'identificacion' => $this->record->identificacion,
            'nombre' => $this->record->nombre,
            'correo' => $this->record->correo,
            'celular' => $this->record->celular,
        ]);

    }
}
