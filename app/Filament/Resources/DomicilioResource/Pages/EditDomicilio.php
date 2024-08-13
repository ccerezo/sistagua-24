<?php

namespace App\Filament\Resources\DomicilioResource\Pages;

use App\Filament\Resources\DomicilioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDomicilio extends EditRecord
{
    protected static string $resource = DomicilioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
