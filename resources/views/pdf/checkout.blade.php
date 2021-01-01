<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Check - Out Nro: {{$movimiento->id}}</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">

</head>
<style>
    .td-25 {
        width: 25%;
    }

    .td-50 {
        width: 50%;
    }

    .td-100 {
        width: 100%;
    }

    .row {
        display: inline-flex;
    }
</style>

<body>
    @foreach ($movimiento->pasajero as $persona)

    <div class="text-center justify-content-center">
        <p class="font-weight-bold">Ficha de Registro Nro.{{$loop->index}}</p>
    </div>
    {{-- <p>Información principal</p> --}}
    <tbody>
        <thead>Información principal</thead>
        <tr>
            <th>Nombres</th>
            <td>{{ $persona->nombres }}</td>
        </tr>
        <tr>
            <th> Apellidos </th>
            <td> {{ $persona->apellidos  }} </td>
        </tr>
    </tbody>
    <div class="row">
        <div class="form-group td-50">
            <label for="nombres" class="control-label">{{ 'Nombres' }}</label>
            <input class="form-control" name="nombres" type="text" id="nombres" value="{{ $persona->nombres }}">
        </div>
        <div class="form-group td-50">
            <label for="apellidos" class="control-label">{{ 'Apellidos' }}</label>
            <input class="form-control" name="apellidos" type="text" id="apellidos" value="{{ $persona->apellidos }}">
        </div>
    </div>
    <div class="row">
        <div class="form-group td-50">
            <label for="empresa" class="control-label">{{ 'Empresa' }}</label>
            <input class="form-control" name="empresa" type="text" id="empresa" value="">
        </div>
        <div class="form-group td-50">
            <label for="ruc" class="control-label">{{ 'RUC' }}</label>
            <input class="form-control" name="ruc" type="text" id="ruc" value="{{ $persona->ruc }}">
        </div>
    </div>
    <div class="row">
        <div class="form-group td-50">
            <label for="pasaporte" class="control-label">{{ 'Nro. Pasaporte' }}</label>
            <input class="form-control" name="pasaporte" type="text" id="pasaporte" value="">
        </div>
        <div class="form-group td-50">
            <label for="nacionalidad" class="control-label">{{ 'Nacionalidad' }}</label>
            <input class="form-control" name="nacionalidad" type="text" id="nacionalidad"
                value="{{ $persona->nacionalidad }}">
        </div>
    </div>
    <div class="form-group">
        <label for="direccion" class="control-label">{{ 'Dirección' }}</label>
        <input class="form-control" name="direccion" type="text" id="direccion" value="{{ $persona->direccion}}">
    </div>
    <div class="row">
        <div class="form-group td-50">
            <label for="ciudad" class="control-label">{{ 'Ciudad' }}</label>
            <input class="form-control" name="ciudad" type="text" id="ciudad" value="{{'Chiclayo'}}">
        </div>
        <div class="form-group td-50">
            <label for="edad" class="control-label">{{ 'Edad' }}</label>
            <input class="form-control" name="edad" type="number" id="edad" value="">
        </div>
    </div>
    <div class="row">
        <div class="form-group td-50">
            <label for="telefono" class="control-label">{{ 'Telefono' }}</label>
            <input class="form-control" name="telefono" type="text" id="telefono" value="{{ $persona->telefono}}">
        </div>
        <div class="form-group td-50">
            <label for="fechanacimiento" class="control-label">{{ 'Fecha de Nacimiento' }}</label>
            <input class="form-control" name="fechanacimiento" type="date" id="fechanacimiento"
                value="{{ $persona->fechanacimiento }}">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="control-label">{{ 'Email' }}</label>
        <input class="form-control" name="email" type="text" id="email" value="">
    </div>
    <p>Información de la habitación</p>
    <p>{{$movimiento->habitacion->numero .' - ' . $movimiento->habitacion->tipohabitacion->nombre}}</p>
    <p>Información de llegada y salida</p>
    <div class="row">
        <div class="form-group td-50">
            <label for="fechaingreso" class="control-label">{{ 'Check-In' }}</label>
            <input class="form-control" name="fechaingreso" type="date" id="fechaingreso"
                value="{{ $movimiento->fechaingreso}}">
        </div>
        <div class="form-group td-50">
            <label for="fechasalida" class="control-label">{{ 'Check-Out' }}</label>
            <input class="form-control" name="fechasalida" type="date" id="fechasalida"
                value="{{ $movimiento->fechasalida }}">
        </div>
    </div>
    @endforeach
</body>

</html>