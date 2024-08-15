<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmpresaResource\Pages;
use App\Filament\Resources\EmpresaResource\RelationManagers;
use App\Models\Empresa;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmpresaResource extends Resource
{
    protected static ?string $model = Empresa::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Cliente Domicilio')->schema([
                        Forms\Components\TextInput::make('codigo')
                            ->required()
                            ->maxLength(15),
                        Forms\Components\TextInput::make('identificacion')
                            ->maxLength(13)
                            ->default(null),
                        Group::make()->schema([
                            Forms\Components\TextInput::make('nombre')
                                ->required()
                                ->maxLength(100),
                        ])->columns(1)->columnSpan(2),
                        
                        Group::make()->schema([
                            Forms\Components\Select::make('grupo_id')
                                ->required()
                                ->preload()
                                ->native(false)
                                ->relationship('grupo','nombre',
                                    modifyQueryUsing: fn (Builder $query) => $query->where('descripcion','=','E')),
                            Forms\Components\Select::make('precio_id')
                                ->required()
                                ->preload()
                                ->native(false)
                                ->relationship('precio','nombre'),
                            Forms\Components\Select::make('categoria_id')
                                ->required()
                                ->preload()
                                ->native(false)
                                ->relationship('categoria','nombre'),
                        ])->columns(3)->columnSpan(2),

                        Group::make()->schema([
                            Forms\Components\TagsInput::make('celular'),
                            Forms\Components\TagsInput::make('correo'),
                        ])->columns(2)->columnSpan(2),

                        Forms\Components\Toggle::make('active')
                            ->required(),
                        Forms\Components\Toggle::make('facturar')
                            ->label('Mismos datos para la factura?')
                            ->required(),
                    ])->columns(2)
                ])->columnSpan(2),
                Group::make()->schema([

                    Section::make('Equipos Instalados')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->image()
                            ->imageEditor()
                            ->panelLayout('grid')
                            ->directory('domicilio')
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->multiple()->columnSpanFull()
                            ->reorderable()
                            ->openable()
                            ->appendFiles(),
                        
                    ]),
                ])->columnSpan(1),
                
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('identificacion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('celular')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grupo.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('precio.nombre')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DireccionsRelationManager::class,
            RelationManagers\ContactosRelationManager::class,
            RelationManagers\FacturarsRelationManager::class,
            RelationManagers\ProductosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmpresas::route('/'),
            'create' => Pages\CreateEmpresa::route('/create'),
            'edit' => Pages\EditEmpresa::route('/{record}/edit'),
        ];
    }
}
