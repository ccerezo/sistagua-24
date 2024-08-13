<?php

namespace App\Filament\Resources\DomicilioResource\Pages;

use App\Filament\Resources\DomicilioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDomicilios extends ListRecords
{
    protected static string $resource = DomicilioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
