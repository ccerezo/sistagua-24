<?php

namespace App\Filament\Resources\ControlResource\Pages;

use App\Filament\Resources\ControlResource;
use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
//use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class ListControls extends ListRecords
{
    protected static string $resource = ControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
            Actions\Action::make('Domicilio')
                    ->form([
                        Forms\Components\TextInput::make('tds')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('ppm')
                            ->required()
                            ->numeric(),
                        Forms\Components\DatePicker::make('fecha_compra'),
                        Forms\Components\Select::make('controlable_id')
                            ->label('Cliente Domicilio')
                            ->preload()
                            ->searchable()
                            ->options(Domicilio::all()->pluck('fullname', 'id')),
                        //SignaturePad::make('signature')
                        
                    ])
                    ->action(function (array $data) {
                        $not_unique = Control::where([
                                ['controlable_id','=', $data['controlable_id']], 
                                ['controlable_type', '=', Domicilio::class]
                            ])->exists();
                    
                            if ($not_unique) {
                                Notification::make()
                                    ->title('El Cliente ya tiene Registrada una hoja de control')
                                    ->danger()
                                    ->send();
                                    throw ValidationException::withMessages(['Cliente combination is not unique']);
                            }

                        $domicilio = Domicilio::find($data['controlable_id']);
                        $domicilio->control()->create([
                                'tds' => $data['tds'],
                                'ppm' => $data['ppm'],
                                'fecha_compra' => $data['fecha_compra'],
                            ]);
                    }),

            Actions\Action::make('Empresa')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('tds')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('ppm')
                            ->required()
                            ->numeric(),
                        Forms\Components\DatePicker::make('fecha_compra'),
                        Forms\Components\Select::make('controlable_id')
                            ->label('Cliente Empresarial')
                            ->preload()
                            ->searchable()
                            ->options(Empresa::all()->pluck('nombre', 'id'))
                        
                    ])
                    ->action(function (array $data) {
                        $not_unique = Control::where([
                            ['controlable_id','=', $data['controlable_id']], 
                            ['controlable_type', '=', Empresa::class]
                        ])->exists();
                
                        if ($not_unique) {
                            Notification::make()
                                ->title('El Cliente ya tiene Registrada una hoja de control, seleccione otro.')
                                ->danger()
                                ->send();
                                throw ValidationException::withMessages(['student and year combination is not unique']);
                        }

                        $empresa = Empresa::find($data['controlable_id']);
                        $empresa->control()->create([
                                'tds' => $data['tds'],
                                'ppm' => $data['ppm'],
                                'fecha_compra' => $data['fecha_compra'],
                            ]);
                    })
        ];
    }
}
