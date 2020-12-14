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
                <div class="card-header">Tipos de Habitacion</div>
                <div class="card-body">
                    <a href="{{ route('create_tipohabitacion') }}" class="btn btn-success btn-sm"
                        title="Add New tipohabitacion">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                    </a>

                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tipohabitacion as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->precio }}</td>
                                    <td>
                                        <a href="{{ route('show_tipohabitacion', $item->id) }}"
                                            title="View tipohabitacion"><button class="btn btn-info btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i> Ver</button></a>
                                        <a href="{{ route('edit_tipohabitacion', $item->id ) }}"
                                            title="Edit tipohabitacion"><button class="btn btn-primary btn-sm"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                Editar</button></a>

                                        <form class="form-eliminar" method="POST"
                                            action="{{ route('destroy_tipohabitacion', $item->id)  }}"
                                            accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                title="Delete tipohabitacion"><i class="fa fa-trash-o"
                                                    aria-hidden="true"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $tipohabitacion->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection