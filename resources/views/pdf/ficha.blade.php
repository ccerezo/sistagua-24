<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ficha Técnica</title>
    <style>
        body{ font-size: 0.8rem }
        .w-10{ width: 10%;display:inline-block;float:left }
        .w-20{ width: 20%;display:inline-block;float:left }
        .w-25{ width: 25%;display:inline-block;float:left }
        .w-40{ width: 40%;display:inline-block;float:left }
        .w-50{ width: 50%;display:inline-block;float:left }
        .w-60{ width: 60%;display:inline-block;float:left }
        .w-75{ width: 75%;display:inline-block;float:left }
        .w-80{ width: 80%;display:inline-block;float:left }
        .w-full{ width: 100%;display:inline-block;float:left }
        .text-right{ text-align: right;}
        .text-center{ text-align: center;}
        .text-white{ color: #ffffff; }
        .text-blue-600{ color: #1f82c8;}
        .text-red-600{ color: #c81f6e;}
        .text-bold{ font-weight: bold }
        .text-xs{ font-size: 0.75 rem }
        .text-justify { text-align: justify }
        .text-capitalize { text-transform: capitalize; }
        .uppercase{ text-transform: uppercase;}
        .border-blue{border: 1px solid #1f82c8;}
        .border-t-blue{border-top: 1px solid #1f82c8;}
        .relative { position: relative; }
        .absolute { position: absolute; }
        .t-150 { top: 150px; }
        .m-0{ margin: 0}
        .ml-10{ margin-left: 10px}
        .mt-20{ margin-top: 20px}
        .px-5{ padding-left: 5px; padding-right: 5px;}
        .pl-10{ padding-left: 10px}
        .px-10{ padding-left: 10px; padding-right: 10px;}
        .py-10{ padding-top: 10px; padding-bottom: 10px;}
        .clear{ clear: both; margin: 0 }
        .table{ border-collapse: collapse; }
        .page-break { page-break-after: always; }
        #footer, #footer-1{ position:fixed; right: 0; bottom: 0;text-align: right; border-top: 0.1pt solid #aaa;}
        .page{ counter-reset: page; }
        .page-number:after {content: "Pág " counter(page)}
    </style>
</head>
<body>
    <div class="">
        <div class="py-10 w-75 border-blue">
            <p class="m-0 text-center text-blue-600 uppercase text-bold">
                FICHA TÉCNICA DE CONTROL Y MANTENIMIENTO DE EQUIPO ÓSMOSIS INVERSA Y FILTROS
            </p> <br>
            <p class="m-0 text-center text-blue-600">
                Cdla. El Maestro Calle Juan Arévalo y Gabriel Flores Palomino
            </p>
            <p class="m-0 text-center text-blue-600">
                Pasaje - El Oro
            </p>
            <p class="m-0 text-center text-blue-600">
                Cel. 0995253665 - 0997653175 - Tlfn. 072798062
            </p>
        </div>
        <div class="text-center w-25">
            <img src="data:image/png;base64,{{ $image }}" width="150px" class="m-0">
        </div>
    </div>
    <div class="clear">
        <div class="w-60">
            <p class="px-10 py-10 m-0">
                Ficha Técnica Nº <span class="ml-10 text-red-600 text-bold">{{$mantenimiento->numero_ficha}}</span>
                Factura Nº <span class="ml-10 text-red-600 text-bold">{{$mantenimiento->numero}}</span>
            </p>
        </div>
        <div class="w-40">
            <p class="py-10 m-0 text-right">
                Fecha: {{\Carbon\Carbon::parse($mantenimiento->fecha)->locale('es_ES')->isoFormat('dddd, D MMMM YYYY')}}
            </p>
        </div>
    </div>
    <div class="clear">
        <div class="w-75">
            <p class="px-10 py-10 m-0 border-blue">
                <span class="ml-10 text-blue-600 text-bold">Cliente:</span>
                {{$nombreCliente}}
            </p>
        </div>
        <div class="w-25">
            <p class="px-10 py-10 m-0 border-blue">
                <span class="ml-10 text-blue-600 text-bold">Código:</span>
                {{$codigocliente}}
            </p>
        </div>
    </div>
    <div class="clear">
        <div class="w-100">
            <p class="text-center text-blue-600">
                MEDICIÓN DE CALIDAD DE AGUA CON TDS Y ANALIZADOR DE DUREZA ANTES DEL INGRESO AL ÓSMOSIS INVERSA  O FILTROS
            </p>
        </div>
    </div>

    <div class="clear">
        <div class="w-10">
            <p class="px-10 py-10 m-0 text-center text-blue-600 border-blue">Detalle</p>
            <p class="px-10 py-10 m-0 text-center border-blue">{{$mantenimiento->fichaTecnica->detalle_tds}}</p>
        </div>
        <div class="w-10">
            <p class="px-10 py-10 m-0 text-center text-blue-600 border-blue">TDS</p>
            <p class="px-10 py-10 m-0 text-center border-blue">{{$mantenimiento->tds}}</p>
        </div>
        <div class="w-20">
            <p class="px-10 py-10 m-0 text-center text-blue-600 border-blue">Dureza/Color</p>
            <p class="px-10 py-10 m-0 text-center border-blue">
                @if ($mantenimiento->fichaTecnica->dureza_color_tds)
                    {{ $mantenimiento->fichaTecnica->dureza_color_tds }}
                @else
                    -
                @endif
            </p>
        </div>
        <div class="w-60">
            <p class="px-10 py-10 m-0 text-center text-blue-600 border-blue">Recomendación</p>
            <p class="px-10 py-10 m-0 text-center border-blue uppercase">
                @if ($mantenimiento->fichaTecnica->recomendacion_tds)
                    {{ $mantenimiento->fichaTecnica->recomendacion_tds }}
                @else
                    -
                @endif
            </p>
        </div>
    </div>
    <div class="clear">
        <div class="w-100">
            <p class="text-center text-blue-600">
                MEDICIÓN DE CALIDAD DE AGUA CON TDS, PURIFICADA A TRAVÉS DE ÓSMOSIS INVERSA
            </p>
        </div>
    </div>
    <div class="clear">
        <div class="w-10">
            <p class="px-10 py-10 m-0 text-center text-blue-600 border-blue">Detalle</p>
            <p class="px-10 py-10 m-0 text-center border-blue">{{$mantenimiento->fichaTecnica->detalle_ppm}}</p>
        </div>
        <div class="w-10">
            <p class="px-10 py-10 m-0 text-center text-blue-600 border-blue">PPM</p>
            <p class="px-10 py-10 m-0 text-center border-blue">{{$mantenimiento->ppm}}</p>
        </div>
        <div class="w-80">
            <p class="px-10 py-10 m-0 text-center text-blue-600 border-blue">Recomendación</p>
            <p class="px-10 py-10 m-0 text-center border-blue">
                @if ($mantenimiento->fichaTecnica->recomendacion_ppm)
                    {{ $mantenimiento->fichaTecnica->recomendacion_ppm }}
                @else
                    -
                @endif
            </p>
        </div>
    </div>
    <div class="clear">
        <div class="w-100">
            <p class="text-center text-blue-600">
                MANTENIMIENTO PREVENTIVO Y CORRECTIVO DE ACCESORIOS DEL ÓSMOSIS INVERSA Y FILTROS
            </p>
        </div>
    </div>
    <table class="table" style="width:100%">
        <thead class="">
        <tr>
            <th scope="col" class="py-10 text-blue-600 border-blue">Producto</th>
            <th scope="col" class="px-10 py-10 text-blue-600 border-blue">Cantidad</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($listaProductos as $item)
            <tr>
                <td class="pl-10 border-blue">
                    {{$item->producto->nombre}}
                    {{-- <p class="m-0 text-xs text-capitalize">{{$item->descripcion}}</p> --}}
                </td>
                <td class="pl-10 text-center border-blue">
                    {{$item->cantidad}}
                </td>
            </tr>
        @endforeach
        @if (count($listaProductos) > 0 && count($listaProductos) < 15)
            @for ($i = 0; $i < 15 - count($listaProductos); $i++)
            <tr>
                <td class="pl-10 text-white border-blue">-
                </td>
                <td class="pl-10 text-white border-blue">-
                </td>
            </tr>
            @endfor
        @endif
        </tbody>
        <tfoot>
            <tr>
                <td class="px-10 py-10 text-right text-blue-600 border-blue text-bold">TOTAL</td>
                <td class="px-5 py-10 text-center border-blue text-bold">$ {{$mantenimiento->fichaTecnica->total}}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <div class="clear">
        <div class="w-full">
            <p class="px-10 py-10 m-0 text-blue-600 border-blue">
                Observación por personal autorizado de SISTAGUA:
            </p>
            <p class="px-10 py-10 m-0 text-xs border-blue uppercase">
                @if ($mantenimiento->fichaTecnica->recomendacion_sistagua)
                    {{ $mantenimiento->fichaTecnica->recomendacion_sistagua }}
                @else
                    -
                @endif
            </p>
        </div>
    </div>
    <div id="footer-1">
        <div class="page-number"></div>
    </div>
    <div class="page-break"></div>
    <div class="clear">
        <div class="w-full">
            <p class="px-10 py-10 text-sm text-justify text-blue-600">
                <b>SISTAGUA</b> garantiza todos y cada uno de sus productos y servicios. <br>
                Cuando, el cliente (comprador) brinde un lugar (caseta o cubierta) seco, fresco y donde se encuentren protegidos de la intemperie para la instalación y
                permanencia de los mismos y las peticiones solicitadas para la instalación e implantación, de plantas y equipos de tratamiento del agua de consumo
                humano utilizada en la industria, el comercio y en los hogares, utilizando los más altos estándares de calidad e higiene, en la prevención, salud y
                bienestar con la más avanzada tecnología en la implementación de los procesos de Ósmosis Inversa, luz ultravioleta, desionización, ablandadores,
                prefiltros, etc. Todas las partes defectuosas serán reemplazadas dentro de los <b>5 años</b>, siempre y cuando sean por defectos de fabricación.
                Partes eléctricas y electrónicas <b>1 año</b>. <br><br>
                La garantía no será válida bajo las siguientes condiciones: <br><br>
                Daños ocasionados por condiciones de fenómenos naturales. Mantenimientos no autorizados por el cliente de acuerdo al registro de mantenimiento.
                Saturación de elementos de filtración por mala calidad de agua. Haya sido mal tratado o usado de manera distinta a lo especificado en el manual del
                producto o especificaciones técnicas por parte del personal autorizado. <br><br>
                Para nosotros, en SISTAGUA, su satisfacción es nuestra prioridad. Infórmenos si todos y cada uno de sus requerimientos fueron bien atendidos a
                nuestro correo electrónico <b>tratamiento_de_agua@sistagua.com.ec</b> <br><br>
                <small><i>“Declaro que los datos consignados en el presente formulario son verídicos y autorizo en forma expresa al ING. VICENTE GABRIEL MEDINA PATIÑO representante legal de la
                empresa SISTAGUA a solicitar confirmación de los mismos, en cualquier fuente de información, incluidos los Burós de Crédito. De igual forma autorizo a referir y/o publicar
                información crediticia a mi nombre o el de mi Representada en los Buros de Crédito legalmente autorizados por la Súper Intendencia de Bancos.”</i></small>
            </p>
        </div>
    </div>
    <div class="clear">
        <div class="relative w-full text-center">
            @if ($mantenimiento->firma)
                <img src="{{$mantenimiento->firma}}" alt="" class="mt-20" height="150px">
                <p class="">
                    Autorizado por <br>
                    {{$mantenimiento->autoriza->fullname}} <br>
                    C.I. {{$mantenimiento->autoriza->identificacion}}
                </p>
            @else
                <p class="mt-20">
                    Autorizado por <br>
                    {{$mantenimiento->autoriza->fullname}} <br>
                    C.I. {{$mantenimiento->autoriza->identificacion}}
                </p>
            @endif

        </div>
    </div>
</body>
</html>