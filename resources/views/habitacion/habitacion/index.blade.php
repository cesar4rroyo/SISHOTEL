@extends("theme.$theme.layout")

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Habitacion</div>
                <div class="card-body">
                    <a href="{{ route('create_habitacion') }}" class="btn btn-success btn-sm"
                        title="Add New habitacion">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Numero</th>
                                    <th>Situacion</th>
                                    <th>Piso</th>
                                    <th>Tipo Habitacion</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($habitacion as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->numero }}</td>
                                    <td>{{ $item->situacion }}</td>
                                    <td>{{ $item->piso->nombre }}</td>
                                    <td>{{ $item->tipohabitacion->nombre }}</td>
                                    <td>
                                        <a href="{{ route('show_habitacion' , $item->id) }}"
                                            title="View habitacion"><button class="btn btn-info btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i>
                                                Ver</button></a>
                                        <a href="{{ route('edit_habitacion' , $item->id) }}"
                                            title="Edit habitacion"><button class="btn btn-primary btn-sm"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                Editar</button></a>

                                        <form method="POST" action="{{ route('destroy_habitacion' , $item->id) }}"
                                            accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                title="Delete habitacion"
                                                onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="pagination-wrapper"> {!! $habitacion->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection