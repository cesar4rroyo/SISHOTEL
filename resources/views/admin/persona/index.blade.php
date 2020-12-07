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
                <div class="card-header">Personas</div>
                <div class="card-body">

                    <form method="GET" action="{{ route('persona') }}" accept-charset="UTF-8" class="my-2 my-lg-0"
                        role="search">
                        <div class="input-group">
                            <select class="form-control" name="search" value="{{ request('search') }}">
                                <option value=""><i class="fas fa-filter"></i> Seleccionar Rol</option>
                                @foreach ($rol as $item)
                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <br />
                    <a href="{{ route('create_persona') }}" class="btn btn-success btn-sm" title="Add New persona">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>RUC</th>
                                    <th>DNI</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Observacion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($persona as $item)
                                <tr>
                                    <td>{{ $item->nombres }}</td>
                                    <td>
                                        {{ isset($item->apellidos ) ? $item->apellidos  : '-'}}
                                    </td>
                                    <td>
                                        {{ isset($item->ruc ) ? $item->ruc  : '-'}}
                                    </td>
                                    <td>
                                        {{ isset($item->dni ) ? $item->dni  : '-'}}
                                    </td>
                                    <td>{{ $item->direccion }}</td>
                                    <td>{{ $item->telefono }}</td>
                                    <td>{{ $item->observacion }}</td>
                                    <td>
                                        <a href="{{ route('show_persona' , $item->id) }}" title="View persona"><button
                                                class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                                Más</button></a>
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