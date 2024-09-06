<?php

use App\Http\Controllers\PDFController;
use App\Livewire\HistorialProductos;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('reporte/ficha-tecnica/{mantenimiento}', [PDFController::class, 'PdfFicha'])->name('pdf.ficha');