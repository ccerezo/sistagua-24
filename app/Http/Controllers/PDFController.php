<?php

namespace App\Http\Controllers;

use App\Models\Control;
use App\Models\Domicilio;
use App\Models\Empresa;
use App\Models\Mantenimiento;
use App\Models\ProductosUsado;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function PdfFicha(Mantenimiento $mantenimiento)
    {        
        $image = base64_encode(file_get_contents(public_path('logo.png')));
        //$listaProductos = HojaDomicilioProducto::where('hoja_detalle_domicilio_id', '=', $detalle_id)->get();
        $control = Control::find($mantenimiento->control_id);
        
        if($control->controlable_type == Domicilio::class){
            $domicilio = Domicilio::find($control->controlable_id);
            $nombreCliente = $domicilio->fullname;         
            $codigocliente = $domicilio->codigo;         
        }
        if($control->controlable_type == Empresa::class){
            $empresa = Empresa::find($control->controlable_id);
            $nombreCliente = $empresa->nombre;
            $codigocliente = $empresa->codigo;         
        }

        $listaProductos = ProductosUsado::where('mantenimiento_id','=',$mantenimiento->id)->get();

        return Pdf::loadView('pdf.ficha', compact('mantenimiento','image','nombreCliente','codigocliente','listaProductos'))
            ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->stream('archivo.pdf');

        //return $pdf->stream('archivo.pdf');
    }
}
