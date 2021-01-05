<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Check-Out</title>
</head>
<style>
    .title {
        background-color: rgb(226, 194, 9);
        color: white;
        font-weight: bold;
        padding: 4px;
        text-align: center;
        margin-bottom: 10px;
        margin-top: 10px;

    }
    .head-title {
        text-align: center;
        font-weight: bold;
        font-size: 20px;
        margin-top: 20px;
    }

    .col {
        width: 50%;
        margin: 10px;
    }

    .content {
        display: flex;
        text-align: center;
    }
    .group {
        display: flex;
    }

    .label {
        text-transform: uppercase;

    }

    .col-3 {
        width: 33%;
    }

    .col-100 {
        width: 100%;
    }

    .input {
        border: 1px solid black;
        padding: 2px;
        border-radius: 5px;
        width: 100%;
    }

    .main {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .img-container {
        position: absolute;
        top: 1;
        left: 1;
    }

    .page-break {
        page-break-after: always;
    }

    .table tbody tr {
        margin-top: 4px;
    }
</style>
<body>
    @foreach ($movimiento['pasajero'] as $persona)
    {{-- <div class="img-container">
        <img src="{{asset("assets/$theme/dist/img/logo.jpeg")}}" width="80px" alt="">
    </div> --}}
    <div class="head-title">
        Ficha de Registro Nro. {{($loop->index)+1}}
    </div>
    <div class="title">Información del Húesped</div>
    <table class="table table-hover text-center">
        <tbody>
            <tr>
                <th> Nombres </th>
                <td class="input"> {{ $persona['persona']['nombres'] }} </td>
                <th> Apellidos </th>
                <td class="input"> {{ $persona['persona']['apellidos'] }} </td>
            </tr>
            <tr>
                <th> Empresa </th>
                <td class="input"> {{ isset($persona['persona']['empresa']) ? $persona['persona']['empresa'] :' - ' }}
                </td>
                <th> RUC </th>
                <td class="input"> {{ isset($persona['persona']['ruc']) ? $persona['persona']['ruc'] : ' - ' }} </td>
            </tr>
            <tr>
                <th> DNI / Nro. Pasaporte </th>
                <td class="input">
                    {{ isset($persona['persona']['dni']) ? $persona['persona']['dni'] : $persona['persona']['pasaporte'] }}
                </td>
                <th> Fecha de nacimiento </th>
                <td class="input"> {{ $persona['persona']['fechanacimiento'] }} </td>
            </tr>
            <tr>
                <th> Dirección </th>
                <td class="input"> {{ $persona['persona']['direccion'] }} </td>
            </tr>
            <tr>
                <th> Ciudad </th>
                <td class="input"> {{ isset($persona['persona']['ciudad'])?$persona['persona']['ciudad']:'-' }} </td>
                <th> Edad </th>
                <td class="input"> {{ isset($persona['persona']['edad'])?$persona['persona']['edad']:'-' }} </td>
            </tr>
            <tr>
                <th> Teléfono </th>
                <td class="input"> {{ $persona['persona']['telefono'] }} </td>
                <th> Nacionalidad </th>
                <td class="input"> {{ $persona['persona']['nacionalidad']['nombre'] }} </td>
            </tr>
            <tr>
                <th> Email </th>
                <td class="input"> {{ isset($persona['persona']['email'])?$persona['persona']['email']:'-' }} </td>
            </tr>
        </tbody>
    </table>
    <div class="title">Información de la Habitación</div>
    <table class="table table-hover text-center">
        <tbody>
            <tr>
                <th> Número de Habitación </th>
                <td class="input"> {{$movimiento['habitacion']['numero']}} </td>
                <th> Tipo de Habitación </th>
                <td class="input"> {{$movimiento['habitacion']['tipohabitacion']['nombre']}}</td>
            </tr>
        </tbody>
    </table>
    <div class="title">Información de llegada y salida</div>
    <table class="table table-hover text-center">
        <tbody>
            <tr>
                <th>Check-In</th>
                <td class="input">{{$movimiento['fechaingreso']}}</td>
                <th>Check-Out</th>
                <td class="input">{{$movimiento['fechasalida']}}</td>
                <th>Días</th>
                <td class="input">{{$movimiento['dias']}}</td>
            </tr>
        </tbody>
    </table>
    <div class="page-break"></div>
    @endforeach
</body>
</html>