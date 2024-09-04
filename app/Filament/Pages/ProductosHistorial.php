<?php

namespace App\Filament\Pages;

use App\Models\ProductosUsado;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Http\Client\Request;

class ProductosHistorial extends Page implements HasTable
{
    //use InteractsWithForms;
    use InteractsWithTable;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.actions.productos-historial';

    public function mount($record) {
        dd($record);
    }
    // public function table(Table $table): Table
    // {
    //     return $table
    //         ->query(ProductosUsado::query()->where('mantenimiento_id', 2))
    //         ->columns([
    //             TextColumn::make('producto.nombre'),
    //             TextColumn::make('cantidad'),
    //         ])
    //         ->filters([
    //             // ...
    //         ])
    //         ->actions([
    //             // ...
    //         ])
    //         ->bulkActions([
    //             // ...
    //         ]);
    // }
}
