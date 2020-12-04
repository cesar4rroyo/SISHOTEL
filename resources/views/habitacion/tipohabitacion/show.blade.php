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

                    <form method="POST" action="{{ route('destroy_tipohabitacion' , $tipohabitacion->id) }}"
                        accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete tipohabitacion"
                            onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o"
                                aria-hidden="true"></i> Eliminar</button>
                    </form>
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