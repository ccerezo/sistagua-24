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

class ProductosHistorial extends Page //implements HasTable
{
    //use InteractsWithForms;
    //use InteractsWithTable;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.actions.productos-historial';

    protected static bool $shouldRegisterNavigation = false;
}
