<?php

namespace App\Filament\Resources\ObsequioResource\Pages;

use App\Filament\Resources\ObsequioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListObsequios extends ListRecords
{
    protected static string $resource = ObsequioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
