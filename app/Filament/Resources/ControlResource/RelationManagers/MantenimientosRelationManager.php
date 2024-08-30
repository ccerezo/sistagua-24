<?php

namespace App\Filament\Resources\ControlResource\RelationManagers;

use App\Mail\Mantenimiento as MailMantenimiento;
use App\Models\Contacto;
use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\FichaTecnica;
use App\Models\Mantenimiento;
use App\Models\ProductosUsado;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use stdClass;

class MantenimientosRelationManager extends RelationManager
{
    protected static string $relationship = 'mantenimientos';
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     dd($data);
    //     $data['persona_matenimiento_id'] = Auth::user()->id;
     
    //     return $data;
    // }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Forms\Components\Select::make('tipo_doc')
                    ->required()
                    ->native(false)
                    ->options([
                        'Factura' => 'Factura',
                        'Recibo' => 'Recibo',
                    ]),
                    Forms\Components\TextInput::make('numero')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('numero_ficha')
                        ->required()
                        ->numeric()
                        ->live()
                        ->afterStateHydrated(function (Set $set) {
                            $ficha = FichaTecnica::latest()->first();
                            if($ficha)
                                $set('numero_ficha', ($ficha->numero)+1);
                        }),
                ])->columns(3)->columnSpan(2),
                Group::make()->schema([
                
                    Forms\Components\TextInput::make('tds')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('ppm')
                        ->required()
                        ->numeric(),
                    Forms\Components\DateTimePicker::make('fecha')
                        ->seconds(false)
                        ->required(),
                ])->columns(3)->columnSpan(2),
                
                Forms\Components\Select::make('autoriza_id')
                    ->required()
                    ->preload()
                    ->native(false)
                    ->relationship(
                        name: 'autoriza',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('apellido1')->orderBy('nombre1'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->identificacion} - {$record->apellido1} {$record->apellido2} {$record->nombre1} {$record->nombre2}")
                    ->searchable(['apellido1', 'nombre1', 'nombre2'])
                    ->createOptionForm([
                        Group::make()->schema([
                            Forms\Components\TextInput::make('identificacion')->columnSpan(2),
                            Forms\Components\TextInput::make('apellido1')
                                ->required(),
                            Forms\Components\TextInput::make('apellido2'),
                            Forms\Components\TextInput::make('nombre1')
                                ->required(),
                            Forms\Components\TextInput::make('nombre2'),
                        ])->columns(2)->columnSpan(2)
                    
                    ]),
                SignaturePad::make('firma')
                        ->clearable(false)
                        ->undoable(false)
                        ->backgroundColor('rgba(0,0,0,0)')  // Background color on light mode
                        ->backgroundColorOnDark('#f0a')     // Background color on dark mode (defaults to backgroundColor)
                        ->penColor('#00f')                  // Pen color on light mode
                        ->penColorOnDark('#fff')            // Pen color on dark mode (defaults to penColor)
                        ->hidden(fn (Get $get): bool => ! $get('firma'))
                        ->columnSpan(2)
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('numero')
            ->columns([
                Tables\Columns\TextColumn::make('N°')
                    ->badge()
                    ->getStateUsing(fn (stdClass $rowLoop): string => $rowLoop->remaining+1),
                Tables\Columns\TextColumn::make('tipo_doc'),
                Tables\Columns\TextColumn::make('numero'),
                Tables\Columns\TextColumn::make('tds'),
                Tables\Columns\TextColumn::make('ppm'),
                Tables\Columns\IconColumn::make('notificado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('autoriza.fullname')
                    ->description(fn (Mantenimiento $record): string => $record->autoriza->identificacion),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Realizado')
                    ->description(fn (Mantenimiento $record): string => $record->user->name),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make('NUEVO')
                    ->label('Agregar Mantenimiento')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['persona_matenimiento_id'] = Auth::user()->id;

                        $recipient = Auth::user();
                        Notification::make()
                            ->title('Mantenimiento guardado correctamente.')
                            ->body('TDS: ' .$data['tds'].' y PPM: '.$data['ppm'])
                            ->sendToDatabase($recipient);
                        return $data;
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('Firmar')
                    ->fillForm(fn (Mantenimiento $record): array => [
                        'firmar' => $record->firma,
                    ])
                    ->form([
                        SignaturePad::make('firmar')
                            ->dotSize(2.0)
                            ->lineMinWidth(0.5)
                            ->lineMaxWidth(2.5)
                            ->throttle(16)
                            ->minDistance(5)
                            ->velocityFilterWeight(0.7)
                            ->backgroundColor('rgba(0,0,0,0)')  // Background color on light mode
                            ->backgroundColorOnDark('#f0a')     // Background color on dark mode (defaults to backgroundColor)
                            ->penColor('#00f')                  // Pen color on light mode
                            ->penColorOnDark('#fff')            // Pen color on dark mode (defaults to penColor)
                    ])
                    ->action(function (array $data, Mantenimiento $record): void {
                        $record->firma = $data['firmar'];
                        $record->save();
                        $recipient = Auth::user();
                        Notification::make()
                            ->title('El Mantenimiento ha sido firmado.')
                            ->sendToDatabase($recipient);
                    }),
                Tables\Actions\Action::make('Productos')
                    ->fillForm(fn (Mantenimiento $record): array => [
                        'productoUsados' => [
                            'producto_id' => $record->producto_id,
                            'cantidad' => $record->cantidad,
                        ]
                    ])
                    ->form([
                        Forms\Components\Repeater::make('productoUsados')
                        ->relationship('productoUsados')
                        ->schema([
                            Group::make()->schema([
                                Forms\Components\Select::make('producto_id')
                                    ->relationship('producto', 'nombre')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\TextInput::make('cantidad')
                                    ->required()
                                    ->default(1)
                                    ->numeric(),
                            ])->columns(2)
                            
                        ]),
                    ])
                    ->action(function (array $data): void {
                        
                        $recipient = Auth::user();
                        Notification::make()
                            ->title('Productos usados en la ficha técnica.')
                            ->sendToDatabase($recipient);
                    }),

                Tables\Actions\Action::make('Enviar Correo')
                    ->fillForm(function (Mantenimiento $record): array {
                        
                        $control = Control::find($record->control_id);
                        $data['dataCorreos'] = [];
                        if($control->controlable_type == Domicilio::class){
                            $domicilio = Domicilio::find($control->controlable_id);
                            if($domicilio->correo){
                                array_push($data['dataCorreos'], 
                                    ['nombreCompleto' => $domicilio->fullname, 'tipoContacto' => 'Cliente', 'correo' =>$domicilio->correo]);
                            }
                            foreach ($domicilio->contactos as $contacto) {
                                if($contacto->correo)
                                    array_push($data['dataCorreos'], 
                                    ['nombreCompleto' => $contacto->fullname, 'tipoContacto' => $contacto->tipoContacto->nombre, 'correo' =>$contacto->correo]);
                            }
                                                        
                        }
                        if($control->controlable_type == Empresa::class){
                            $empresa = Empresa::find($control->controlable_id);
                            if($empresa->correo) {
                                array_push($data['dataCorreos'], 
                                    ['nombreCompleto' => $empresa->nombre, 'tipoContacto' => 'Empresa', 'correo' =>$empresa->correo]);
                            }
                                
                            foreach ($empresa->contactos as $contacto) {
                                if($contacto->correo)
                                    array_push($data['dataCorreos'], 
                                        ['nombreCompleto' => $contacto->fullname, 'tipoContacto' => $contacto->tipoContacto->nombre, 'correo' =>$contacto->correo]);
                            }
                        }
                        
                        return $data;
                    })
                    ->form([
                        Forms\Components\Repeater::make('dataCorreos')
                        ->label('Correos Registrados del Cliente')
                            ->schema([
                                Forms\Components\TextInput::make('nombreCompleto')->required(),
                                Forms\Components\TextInput::make('tipoContacto')->required(),
                                Forms\Components\TextInput::make('correo')->required(),
                            ])->columns(3)
                            ->addActionLabel('Agregar Correo')
                    ])
                    ->action(function (array $data, Mantenimiento $record): void {
                        $record->notificado = true;
                        $record->save();
                        $control = Control::find($record->control_id);
                        $enviar_a = array();
                        if($control->controlable_type == Domicilio::class){
                            $domicilio = Domicilio::find($control->controlable_id);
                            if($domicilio->correo) array_push($enviar_a, $domicilio->correo);
                            foreach ($domicilio->contactos as $contacto) {
                                if($contacto->correo) array_push($enviar_a, $contacto->correo);
                                $body = new MailMantenimiento($control, $domicilio);
                            }
                            $data['correos'] = array_merge(...$enviar_a);
                        }
                        if($control->controlable_type == Empresa::class){
                            $empresa = Empresa::find($control->controlable_id);
                            if($empresa->correo) array_push($enviar_a, $empresa->correo);
                            foreach ($empresa->contactos as $contacto) {
                                if($contacto->correo) array_push($enviar_a, $contacto->correo);
                                $body = new MailMantenimiento($control, $empresa);
                            }
                            $data['correos'] = array_merge(...$enviar_a);
                        }
                                                
                        Mail::to($data['correos'])->send($body);

                        $recipient = Auth::user();
                        Notification::make()
                            ->title('Correo Enviado!.')
                            ->body('Mantenimiento realizado: '. $record->fecha)
                            ->sendToDatabase($recipient);
                        Notification::make()
                            ->title('Notificación enviada por correo.')
                            ->success()
                            ->send();
                                                
                    }),
                Tables\Actions\Action::make('Ficha técnica')
                    ->fillForm(function (array $data, Mantenimiento $record): array {
                        $ficha = $record->fichaTecnica;
                        if($ficha) {
                            $data = $ficha->toArray();
                        }
                        $data['numero'] = $record->numero_ficha;
                        $data['fecha'] = $record->fecha;
                        $data['tds'] = $record->tds;
                        $data['ppm'] = $record->ppm;
                        $data['firma'] = $record->firma;    
                        $data['productoUsados'] = [];
                                                
                       
                        foreach ($record->productoUsados as $item) {
                            array_push($data['productoUsados'], ['producto_id' => $item->producto_id,
                                                                'cantidad' => $item->cantidad]);
                        }
                        $control = Control::find($record->control_id);
                        if($control->controlable_type == Domicilio::class){
                            $domicilio = Domicilio::find($control->controlable_id);
                            $data['cliente'] = $domicilio->fullname.' - '.$domicilio->codigo;
                                                                                    
                        }
                        if($control->controlable_type == Empresa::class){
                            $empresa = Empresa::find($control->controlable_id);
                            $data['cliente'] = $empresa->nombre.' - '.$empresa->codigo;
                        }
                        
                        //$data = array_merge($data, $data_tmp);
                        //dd($data);
                        return $data;
                    })
                    ->form([
                        Forms\Components\Fieldset::make('FICHA TÉCNICA CONTROL DE EQUIPO ÓSMOSIS INVERSA Y FILTROS')
                            
                            ->schema([
                                Forms\Components\TextInput::make('numero')->disabled(),
                                Forms\Components\TextInput::make('cliente')->columnSpan(3),
                                Forms\Components\TextInput::make('fecha')->columnSpan(2),
                            ])->columns(6),

                        Forms\Components\Section::make('MEDICIÓN DE CALIDAD DE AGUA')
                            ->description('CON TDS Y ANALIZADOR DE DUREZA ANTES DEL INGRESO AL ÓSMOSIS INVERSA O FILTROS')
                            ->schema([
                                Forms\Components\Select::make('detalle_tds')
                                    ->required()
                                    ->options([
                                        'BUENO' => 'BUENO',
                                        'NORMAL' => 'NORMAL',
                                        'MALO' => 'MALO',
                                    ]),
                                Forms\Components\TextInput::make('tds'),
                                Forms\Components\TextInput::make('dureza_color_tds'),
                                Forms\Components\TextInput::make('recomendacion_tds')->columnSpan(3)
                            ])->columns(6),
                        Forms\Components\Section::make('MEDICIÓN DE CALIDAD DE AGUA')
                            ->description('CON TDS, PURIFICADA A TRAVÉS DE ÓSMOSIS INVERSA')
                            ->schema([
                                Forms\Components\Select::make('detalle_ppm')
                                    ->required()
                                    ->options([
                                        'BUENO' => 'BUENO',
                                        'NORMAL' => 'NORMAL',
                                        'MALO' => 'MALO',
                                    ]),
                                Forms\Components\TextInput::make('ppm'),
                                Forms\Components\TextInput::make('recomendacion_ppm')->columnSpan(3)
                            ])->columns(5),
                        Forms\Components\Section::make('MANTENIMIENTO PREVENTIVO Y CORRECTIVO DE ACCESORIOS DEL ÓSMOSIS INVERSA Y FILTROS')
                            ->schema([
                                Forms\Components\Repeater::make('productoUsados')
                                    ->relationship('productoUsados')
                                    ->schema([
                                        Forms\Components\Select::make('producto_id')
                                            ->relationship('producto', 'nombre')->disabled()->columnSpan(4),
                                        Forms\Components\TextInput::make('cantidad')
                                            ->label('Cant.'),
                                        ])
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderable(false)
                                    ->columns(5)
                                    ]),
                        Forms\Components\Section::make([        
                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->prefix('$')->columnStart(4),
                        Forms\Components\Section::make('Observación por personal autorizado de SISTAGUA:')
                            ->schema([
                                Forms\Components\Textarea::make('recomendacion_sistagua')                                
                                ]),
                        SignaturePad::make('firma')
                            ->clearable(false)
                            ->undoable(false)
                            ->backgroundColor('rgba(0,0,0,0)')  // Background color on light mode
                            ->backgroundColorOnDark('#f0a')     // Background color on dark mode (defaults to backgroundColor)
                            ->penColor('#00f')                  // Pen color on light mode
                            ->penColorOnDark('#fff')            // Pen color on dark mode (defaults to penColor)
                            ->hidden(fn (Get $get): bool => ! $get('firma'))
                            ->columnSpanFull()
                        ])->columns(4)
                        
                    ])
                    
                    ->extraModalFooterActions([
                        Action::make('Imprimir')
                            ->url(fn (Mantenimiento $record): string => route('pdf.ficha', ['mantenimiento' => $record]))
                            ->color('success')
                            ->extraAttributes([
                                'target' => '_blank',
                            ])
                    ])
                    ->modalSubmitActionLabel('Guardar')
                    ->action(function (array $data,Mantenimiento $record): void {
                        $ficha = $record->fichaTecnica;
                        if(!$ficha) {
                            $ficha = new FichaTecnica(); 
                        }
                        //dd($data);
                        
                        $ficha->numero = $data['numero'];
                        $ficha->detalle_tds = $data['detalle_tds'];
                        $ficha->dureza_color_tds = $data['dureza_color_tds'];
                        $ficha->recomendacion_tds = $data['recomendacion_tds'];
                        $ficha->detalle_ppm = $data['detalle_ppm'];
                        $ficha->recomendacion_ppm = $data['recomendacion_ppm'];
                        $ficha->total = $data['total'];
                        $ficha->recomendacion_sistagua = $data['recomendacion_sistagua'];
                        $ficha->mantenimiento_id = $record->id;
                        $ficha->save();

                        Notification::make()
                            ->title('Ficha técnica creada correctamemte.')
                            ->success()
                            ->send();
                        $recipient = Auth::user();
                        Notification::make()
                            ->title('Ficha técnica creada correctamemte.')
                            ->sendToDatabase($recipient);
                    }),
                    
                                           
                    
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
