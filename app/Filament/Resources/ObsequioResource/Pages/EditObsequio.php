<?php

namespace App\Filament\Resources\ObsequioResource\Pages;

use App\Filament\Resources\ObsequioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObsequio extends EditRecord
{
    protected static string $resource = ObsequioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
