<?php

namespace App\Filament\Resources\PrecioResource\Pages;

use App\Filament\Resources\PrecioResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditPrecio extends EditRecord
{
    protected static string $resource = PrecioResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        //dd($data);
        $record->update($data);
        $recipient = Auth::user();
        Notification::make()
            ->title('Precios')
            ->body('Se ha egistrado una modificacion')
            ->sendToDatabase($recipient);
            
        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
}
