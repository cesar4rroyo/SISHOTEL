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
        <p class="font-weight-bold">Registro de Movimientos de caja</p>
        <p class=" float-right">Fecha: {{\Carbon\Carbon::now()}}</p>
        <table class="table text-center mt-5">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Numero</th>
                    <th>Tipo</th>
                    <th>Persona</th>
                    <th>Total</th>
                    <th>Concepto</th>
                    <th>Comentario</th>
                    <th>Movimiento</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($caja as $item)
                <tr>
                    <td>{{ $item['fecha'] }}</td>
                    <td>{{ $item['numero'] }}</td>
                    @if ( ($item['tipo'])=='Ingreso' )
                    <td>
                        <span class="badge badge-success">
                            {{ $item['tipo'] }}
                        </span>
                    </td>
                    @else
                    <td>
                        <span class="badge badge-danger">
                            {{ $item['tipo'] }}
                        </span>
                    </td>
                    @endif
                    <td>
                        {{ !is_null($item['persona']) ? $item['persona']['nombres'] . ' ' . $item['persona']['apellidos']  : '-'}}
                    </td>
                    <td>
                        <span class="badge badge-success">
                            {{ $item['total'] }}
                        </span>
                    </td>

                    <td>
                        {{ $item['concepto']['nombre'] }}
                    </td>
                    <td>
                        {{ !is_null($item['comentario'] ) ? $item['comentario']  : '-'}}
                    </td>
                    <td>
                        {{ !is_null($item['movimiento'] ) ? 'Pago Servicio Hotel Nro. ' . $item['movimiento']['id']  : '-'}}
                    </td>
                    <td>{{ $item['usuario']['login']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>