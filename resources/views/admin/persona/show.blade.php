@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Persona {{ $persona->id }}</div>
                <div class="card-body">
                    <a href="{{ route('persona') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button></a>
                    <a href="{{ route('edit_persona' , $persona->id ) }}" title="Edit persona"><button
                            class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            Editar</button>
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
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
                                    <th> Razon Social </th>
                                    <td> {{ $persona->razonsocial }} </td>
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
                                    <th> Obersvación </th>
                                    <td> {{ $persona->obersvacion }} </td>
                                </tr>
                                <tr>
                                    <th> Nacionalidad </th>
                                    <td> {{ $persona->nacionalidad->nombre }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection