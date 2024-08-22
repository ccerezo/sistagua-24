<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mantenimiento</title>
    <style>
        body{ font-size: 0.85 rem }
        .w-10{ width: 10%;display:inline-block;float:left }
        .w-20{ width: 20%;display:inline-block;float:left }
        .w-25{ width: 25%;display:inline-block;float:left }
        .w-50{ width: 50%;display:inline-block;float:left }
        .w-60{ width: 60%;display:inline-block;float:left }
        .w-75{ width: 75%;display:inline-block;float:left }
        .w-80{ width: 80%;display:inline-block;float:left }
        .w-full{ width: 100%;display:inline-block;float:left }
        .text-right{ text-align: right;}
        .text-center{ text-align: center;}
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
        .pl-10{ padding-left: 10px}
        .px-10{ padding-left: 10px; padding-right: 10px;}
        .py-10{ padding-top: 10px; padding-bottom: 10px;}
        .clear{ clear: both; margin: 0 }
        .table{ border-collapse: collapse; }
    </style>
</head>
<body>
    <div class="clear">
        <p class="py-10 m-0">ESTIMADO CLIENTE,
            
        </p>
        <p class="py-10 m-0">
            RECIBA UN CORDIAL SALUDO POR PARTE DE LA EMPRESA SISTAGUA TECNOLOGÍA EN TRATAMIENTOS DE AGUA, DESEANDOLE QUE SE ENCUENTRE BIEN DE SALUD USTED Y TODA SU FAMILIA.
        </p>
        <p class="py-10 m-0">
            MEDIANTE EL PRESENTE TENGO EL GRATO DE COMUNICARLE EL REGISTRO DE LA VISITA DE MANTENIMIENTO CORRECTIVO Y PREVENTIVO. PARA MAYOR INFORMACIÓN PUEDE INGRESAR AL SIGUIENTE ENLACE
        </p>
        <br>
        <div style="width:100%;text-align:center">
            <a href="http://app.sistagua.ec/consultas/mantenimientos/domicilio/1"
                style="background-color: #007DC4; padding: 15px 10px; color:#ffffff;text-decoration:none">
                CONSULTAS DE MANTENIMIENTO
            </a>
        </div>


        <p>GRACIAS POR PREFERIRNOS.</p>
        <br><br>
        <p style="font-size: 15px;color:#007dc4"><b>Ing. Vicente Medina</b><br><b>Ejecutivo de Marketing</b></p>
        <div>
            {{-- <img src="{{ assets('storage/firma-correo.png') }}" alt="" class="mx-auto w-36"> --}}
            {{-- <img src="{{ $message->embed(public_path() . '/images/firma.png') }}" height="200px"> --}}
        </div>
        <p>
            Cdla. El Maestro Calle Juan Arévalo y Gabriel Flores Palomino <br>
            Pasaje - El Oro <br>
            Cel. 0998253665 - 0997653175 - Tlfn. 072798062
        </p>
        <p><a style="color:#007dc4;text-decoration:none" href="https://sistagua.ec/" target="_blank" rel="noopener noreferrer">www.sistagua.ec</a></p>
        <p>
            <a style="background-color: #007DC4; padding: 5px 10px; margin-right: 10px; color:#ffffff;text-decoration:none" href="https://www.facebook.com/Sistagua-105007665045323" target="_blank" rel="noopener noreferrer">Facebook</a>
            <a style="background-color: #C13584; padding: 5px 10px; color:#ffffff;text-decoration:none" href="https://www.instagram.com/sistagua.ec/" target="_blank" rel="noopener noreferrer">Instagram</a>
        </p>

    </div>

</body>
</html>