<?php

namespace App\Http\Controllers;


use App\Models\Mantenimiento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function PdfFicha(Mantenimiento $mantenimiento)
    {
        //dd($mantenimiento);
        //$hojaDetalleDomicilio = HojaDetalleDomicilio::find($detalle_id);
        $ficha = $mantenimiento->fichatecnica();
        $image = base64_encode(file_get_contents(public_path('/images/logo.png')));
        //$listaProductos = HojaDomicilioProducto::where('hoja_detalle_domicilio_id', '=', $detalle_id)->get();

        return Pdf::loadView('pdf.ficha', compact('ficha','image'))
            ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->stream('archivo.pdf');

        //return $pdf->stream('archivo.pdf');
    }
}
