<?php

namespace App\Filament\Resources\EmpresaResource\RelationManagers;

use App\Models\Contacto;
use App\Models\Empresa;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactosRelationManager extends RelationManager
{
    protected static string $relationship = 'contactos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('buscar_contacto')
                    ->preload()
                    ->options(Contacto::where('contactoable_type','=',Empresa::class)->get()->pluck('fullname', 'id'))
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function (Get $get,Set $set) {
                        $contacto = Contacto::find($get('buscar_contacto'));
                        if($contacto) {
                            $set('identificacion',$contacto->identificacion);
                            $set('tipo_contacto_id',$contacto->tipo_contacto_id);
                            $set('apellido1',$contacto->apellido1);
                            $set('apellido2',$contacto->apellido2);
                            $set('nombre1',$contacto->nombre1);
                            $set('nombre2',$contacto->nombre2);
                            $set('telefono',$contacto->telefono);
                            $set('correo',$contacto->correo);
                            $set('cumpleanios',$contacto->cumpleanios);
                        }
                    })->columnSpanFull(),
                Forms\Components\TextInput::make('identificacion'),
                Forms\Components\Select::make('tipo_contacto_id')
                    ->relationship('tipoContacto', 'nombre',
                        modifyQueryUsing: fn (Builder $query) => $query->where('tipo', '=', 'Empresa'),    
                    )
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Group::make()->schema([
                    Forms\Components\TextInput::make('apellido1')->autocapitalize('apellido1'),
                    Forms\Components\TextInput::make('apellido2'),
                    Forms\Components\TextInput::make('nombre1'),
                    Forms\Components\TextInput::make('nombre2'),
                ])->columns(4)->columnSpan(2),

                Group::make()->schema([
                    Forms\Components\TagsInput::make('telefono'),
                    Forms\Components\TagsInput::make('correo'),
                    Forms\Components\DatePicker::make('cumpleanios'),
                ])->columns(3)->columnSpan(2),
                
                
                Forms\Components\Toggle::make('coordinar_visita')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tipoContacto.nombre')
            ->columns([
                Tables\Columns\TextColumn::make('tipoContacto.nombre'),
                Tables\Columns\TextColumn::make('fullname'),
                Tables\Columns\TextColumn::make('telefono')->badge(),
                Tables\Columns\TextColumn::make('cumpleanios')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('coordinar_visita')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
