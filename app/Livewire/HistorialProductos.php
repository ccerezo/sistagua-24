<?php

namespace App\Livewire;

use App\Models\Control;
use App\Models\Mantenimiento;
use App\Models\ProductosUsado;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class HistorialProductos extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    public $control;
    public $mantenimientos;
    
    public function mount($record)
    {
        $this->mantenimientos = Mantenimiento::select('id')->where('control_id',$record)->get()->toArray();
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(ProductosUsado::query()->whereIn('mantenimiento_id', $this->mantenimientos))
            ->columns([
                TextColumn::make('producto.nombre')->searchable(),
                TextColumn::make('cantidad'),
                TextColumn::make('mantenimiento.fecha')->searchable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render(): View
    {
        return view('livewire.historial-productos');
    }
}
