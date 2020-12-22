@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Servicio {{ $servicio->id }}</div>
                <div class="card-body">

                    <a href="{{ route('servicios') }}" title="Regresar"><button
                            class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                    <a href="{{ route('edit_servicios' , $servicio->id ) }}" title="Editar servicio"><button
                            class="btn btn-outline-primary btn-sm"><i class="fas fa-edit" aria-hidden="true"></i>
                            Editar</button></a>

                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $servicio->id }}</td>
                                </tr>
                                <tr>
                                    <th> Nombre </th>
                                    <td> {{ $servicio->nombre }} </td>
                                </tr>
                                <tr>
                                    <th> Precio </th>
                                    <td> {{ $servicio->precio }} </td>
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