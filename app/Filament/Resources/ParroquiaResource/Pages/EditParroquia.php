<?php

namespace App\Filament\Resources\ParroquiaResource\Pages;

use App\Filament\Resources\ParroquiaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParroquia extends EditRecord
{
    protected static string $resource = ParroquiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
