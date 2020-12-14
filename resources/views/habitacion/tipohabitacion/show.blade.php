@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">tipohabitacion {{ $tipohabitacion->id }}</div>
                <div class="card-body">

                    <a href="{{ route('tipohabitacion') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button></a>
                    <a href="{{ route('edit_tipohabitacion', $tipohabitacion->id) }}"
                        title="Edit tipohabitacion"><button class="btn btn-primary btn-sm"><i
                                class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>
                    <br />
                    <br />

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $tipohabitacion->id }}</td>
                                </tr>
                                <tr>
                                    <th> Nombre </th>
                                    <td> {{ $tipohabitacion->nombre }} </td>
                                </tr>
                                <tr>
                                    <th> Precio </th>
                                    <td> {{ $tipohabitacion->precio }} </td>
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