<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reportes Caja</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">
</head>
<style>
    .table {
        width: 100%;
    }
</style>

<body>
    <div>
        <p class="font-weight-bold">Registro de Check-Ins</p>
        <p class=" float-right">Fecha: {{\Carbon\Carbon::now()}}</p>
        <table class="table text-center mt-5">
            <thead>
                <tr>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th>Habitación Nro</th>
                    <th>Tipo de Habitacion</th>
                    <th>Reserva</th>
                    <th>Comentario</th>
                    <th>Húespedes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movimiento as $item)
                <tr>
                    <td>{{ $item['fechaingreso'] }}</td>
                    <td>{{ $item['fechasalida'] }}</td>
                    <td>
                        {{ $item['habitacion']['numero'] }}
                    </td>
                    <td>
                        {{ $item['habitacion']['tipohabitacion']['nombre'] }}
                    </td>
                    <td>
                        {{ !is_null($item['reserva_id'] ) ? 'Reserva Nro. ' . $item['reserva_id']  : 'No'}}
                    </td>
                    <td>
                        {{ !is_null($item['comentario'] ) ? $item['comentario'] : '-'}}
                    </td>
                    <td>
                        @foreach ($item['pasajero'] as $pasajero)
                        {{$loop->last ? $pasajero['persona']['nombres'] . ' ' .$pasajero['persona']['apellidos'] : $pasajero['persona']['nombres'] . ' ' .$pasajero['persona']['apellidos'] . ',' }}
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>