<?php

namespace App\Filament\Resources\DomicilioResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactosRelationManager extends RelationManager
{
    protected static string $relationship = 'contactos';
    //protected static ?string $title = 'contactos de Empresa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('identificacion'),
                Forms\Components\Select::make('tipo_contacto_id')
                    ->relationship('tipoContacto', 'nombre',
                        modifyQueryUsing: fn (Builder $query) => $query->where('tipo', '=', 'Domicilio'),    
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
            ->heading('Contactos de Domiclio')
            ->recordTitleAttribute('tipo_contacto_id')
            ->columns([
                Tables\Columns\TextColumn::make('tipoContacto.nombre'),
                Tables\Columns\TextColumn::make('fullname'),
                Tables\Columns\TextColumn::make('telefono')->badge(),
                Tables\Columns\TextColumn::make('correo'),
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
