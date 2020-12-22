@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Tipo de Habitación {{ $tipohabitacion->id }}</div>
                <div class="card-body">

                    <a href="{{ route('tipohabitacion') }}" title="Regresar"><button
                            class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                    <a href="{{ route('edit_tipohabitacion', $tipohabitacion->id) }}"
                        title="Editar tipohabitacion"><button class="btn btn-outline-primary btn-sm"><i
                                class="fas fa-edit" aria-hidden="true"></i> Editar</button></a>
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