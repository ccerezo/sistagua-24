<?php

namespace App\Filament\Resources\TipoProductoResource\Pages;

use App\Filament\Resources\TipoProductoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoProductos extends ListRecords
{
    protected static string $resource = TipoProductoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
