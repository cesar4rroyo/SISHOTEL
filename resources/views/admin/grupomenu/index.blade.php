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
                <div class="card-header">Grupo Menu</div>
                <div class="card-body">
                    <a href="{{ url('admin/grupomenu/create') }}" class="btn btn-success btn-sm"
                        title="Add New grupomenu">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Icono</th>
                                    <th>Orden</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grupomenu as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->icono }}</td>
                                    <td>{{ $item->orden }}</td>
                                    <td>
                                        <a href="{{ route('show_grupomenu', $item->id) }}"
                                            title="View grupomenu"><button class="btn btn-info btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i>
                                                Ver</button></a>
                                        <a href="{{ route('edit_grupomenu', $item->id ) }}"
                                            title="Edit grupomenu"><button class="btn btn-primary btn-sm"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                Editar</button></a>

                                        <form method="POST" action="{{ route('destroy_grupomenu', $item->id) }}"
                                            accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete grupomenu"
                                                onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $grupomenu->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection