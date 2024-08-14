<?php

namespace App\Filament\Resources\TipoContactoResource\Pages;

use App\Filament\Resources\TipoContactoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoContacto extends EditRecord
{
    protected static string $resource = TipoContactoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
