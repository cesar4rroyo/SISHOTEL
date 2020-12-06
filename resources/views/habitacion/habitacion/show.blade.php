@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Habitacion {{ $habitacion->id }}</div>
                <div class="card-body">

                    <a href="{{ route('habitacion') }}" title="Back"><button class="btn btn-warning btn-sm"><i
                                class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</button></a>
                    <a href="{{ route('edit_habitacion' , $habitacion->id) }}" title="Edit habitacion"><button
                            class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            Editar</button></a>

                    <form method="POST" action="{{ route('habitacion' , $habitacion->id) }}" accept-charset="UTF-8"
                        style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete habitacion"
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
                                    <td>{{ $habitacion->id }}</td>
                                </tr>
                                <tr>
                                    <th> Numero </th>
                                    <td> {{ $habitacion->numero }} </td>
                                </tr>
                                <tr>
                                    <th> Situacion </th>
                                    <td> {{ $habitacion->situacion }} </td>
                                </tr>
                                <tr>
                                    <th> Piso </th>
                                    <td> {{ $habitacion->piso->nombre }} </td>
                                </tr>
                                <tr>
                                    <th> Tipo Habitacio </th>
                                    <td> {{ $habitacion->tipohabitacion->nombre }} </td>
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