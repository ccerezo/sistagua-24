<?php

namespace App\Livewire;

use App\Models\Control;
use App\Models\ProductosUsado;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class HistorialProductos extends Component 
{
    
    
    public function mount($record)
    {
        dd($record);
    }
    // public function table(Table $table): Table
    // {
    //     return $table
    //         ->query(ProductosUsado::where('mantenimiento_id', 2))
    //         ->columns([
    //             TextColumn::make('producto.nombre'),
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

    public function render(): View
    {
        return view('livewire.historial-productos');
    }
}
