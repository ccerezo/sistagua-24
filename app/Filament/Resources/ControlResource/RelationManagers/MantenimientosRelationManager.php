<?php

namespace App\Filament\Resources\ControlResource\RelationManagers;

use App\Mail\Mantenimiento as MailMantenimiento;
use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\Mantenimiento;
use App\Models\ProductosUsado;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
                        ->required(),
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
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->apellido1} {$record->apellido2} {$record->nombre1} {$record->nombre2}")
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
                Tables\Columns\TextColumn::make('tipo_doc'),
                Tables\Columns\TextColumn::make('numero'),
                Tables\Columns\TextColumn::make('tds'),
                Tables\Columns\TextColumn::make('ppm'),
                Tables\Columns\TextColumn::make('descripcion')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('autoriza.fullname')
                    ->description(fn (Mantenimiento $record): string => $record->autoriza->identificacion),
                Tables\Columns\TextColumn::make('fecha')
                    ->label('Realizado')
                    ->description(fn (Mantenimiento $record): string => $record->user->name),
            ])
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
                    
                    ->action(function (Mantenimiento $record): void {
                        
                        $control = Control::find($record->control_id);

                        if($control->controlable_type == Domicilio::class){
                            $domicilio = Domicilio::find($control->controlable_id);
                            // $correo = new MailMantenimiento($this->hojaDetalleDomicilio);
                            // //$para = $this->hojaDetalleDomicilio->hojaControlDomicilio->clienteDomicilio->correo1;
                            // //Mail::to('ccerezo90@gmail.com')->send($correo);
                            // Mail::to($enviar_a)->send($correo);
                        }
                        if($control->controlable_type == Empresa::class){
                            //
                        }
                        
                        $recipient = Auth::user();
                        Notification::make()
                            ->title('Correo de Mantenimiento Enviado')
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
