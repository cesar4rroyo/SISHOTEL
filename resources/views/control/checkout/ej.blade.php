<!DOCTYPE html>
<html lang="en">

<head>

    <title>Document</title>
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">

</head>

<body>
    <div>
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $persona->id }}</td>
                </tr>
                <tr>
                    <th> Nombres </th>
                    <td> {{ $persona->nombres }} </td>
                </tr>
                <tr>
                    <th> Apellidos </th>
                    <td> {{ $persona->apellidos }} </td>
                </tr>

                <tr>
                    <th> Ruc </th>
                    <td> {{ $persona->ruc }} </td>
                </tr>
                <tr>
                    <th> DNI </th>
                    <td> {{ $persona->dni }} </td>
                </tr>
                <tr>
                    <th> Dirección </th>
                    <td> {{ $persona->direccion }} </td>
                </tr>
                <tr>
                    <th> Fecha de nacimiento </th>
                    <td> {{ $persona->fechanacimiento }} </td>
                </tr>
                <tr>
                    <th> Teléfono </th>
                    <td> {{ $persona->telefono }} </td>
                </tr>
                <tr>
                    <th> Observación </th>
                    <td> {{ $persona->observacion }} </td>
                </tr>
                <tr>
                    <th> Nacionalidad </th>
                    <td> {{ $persona->nacionalidad->nombre }} </td>
                </tr>
            </tbody>
        </table>
    </div>


</body>

</html>