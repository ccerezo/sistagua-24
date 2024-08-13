<?php

namespace App\Filament\Resources\ParroquiaResource\Pages;

use App\Filament\Resources\ParroquiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParroquias extends ListRecords
{
    protected static string $resource = ParroquiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
