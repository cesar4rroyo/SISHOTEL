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
                <div class="card-header">Persona</div>
                <div class="card-body">
                    <a href="{{ route('create_persona') }}" class="btn btn-success btn-sm" title="Add New persona">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Razon Social</th>
                                    <th>RUC</th>
                                    <th>DNI</th>
                                    <th>Sexo</th>
                                    <th>Direccion</th>
                                    <th>Fecha Nacimiento</th>
                                    <th>Telefono</th>
                                    <th>Observacion</th>
                                    <th>Nacionalidad</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($persona as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombres }}</td>
                                    <td>{{ $item->apellidos }}</td>
                                    <td>{{ $item->razonsocial }}</td>
                                    <td>{{ $item->ruc }}</td>
                                    <td>{{ $item->dni }}</td>
                                    <td>{{ $item->sexo }}</td>
                                    <td>{{ $item->direccion }}</td>
                                    <td>{{ $item->fechanacimiento}}</td>
                                    <td>{{ $item->telefono }}</td>
                                    <td>{{ $item->observacion }}</td>
                                    <td>{{ $item->nacionalidad->nombre }}</td>
                                    <td>
                                        <a href="{{ route('view_persona' , $item->id) }}" title="View persona"><button
                                                class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                                Ver</button></a>
                                        <a href="{{ route('edit_persona' , $item->id ) }}" title="Edit persona"><button
                                                class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                    aria-hidden="true"></i>
                                                Editar</button></a>
                                        <form method="POST" action="{{ route('destroy_persona', $item->id) }}"
                                            accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete persona"
                                                onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $persona->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection