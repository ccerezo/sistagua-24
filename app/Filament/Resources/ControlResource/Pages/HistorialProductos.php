<?php

namespace App\Filament\Resources\ControlResource\Pages;

use App\Filament\Resources\ControlResource;
use App\Models\Control;
use App\Models\ProductosUsado;
use Filament\Forms\Components\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\View\Components\Modal;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

class HistorialProductos extends Page implements HasTable
{
    use InteractsWithTable;
    //use InteractsWithRecord;
    
    protected static string $resource = ControlResource::class;

    protected static string $view = 'filament.resources.control-resource.pages.historial-productos';
    
    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->where('active', true);
    // }
    // public function mount(Request $request) {
    //     dd($request);
    // }
    public function mount(): void 
    {
        //dd($this->rec);
    }
    

    public function table(Table $table): Table
    {
        return $table
            ->query(ProductosUsado::query()->where('mantenimiento_id', 2))
            ->columns([
                TextColumn::make('cantidad'),
                TextColumn::make('producto.nombre'),
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

}
