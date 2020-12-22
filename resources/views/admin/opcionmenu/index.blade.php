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
                <div class="card-header">Opciones de Menu</div>
                <div class="card-body">

                    <a href="{{ route('create_opcionmenu') }}" class="btn btn-outline-success"
                        title="Add New opcionmenu">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                    </a>
                    <form method="GET" action="{{ route('opcionmenu') }}" accept-charset="UTF-8"
                        class="form-inline my-2 my-lg-0 float-right" role="search">
                        <div class="input-group">
                            <select class="form-control" name="search" value="{{ request('search') }}">
                                <option value=""><i class="fas fa-filter"></i> Filtrar Grupos Menú</option>
                                @foreach ($grupomenu as $item)
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
                    <br />
                    <div class="table-responsive">
                        <table class="table text-center table-hover" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Link</th>
                                    <th>Icono</th>
                                    <th>Orden</th>
                                    <th>Grupo Menu</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($opcionmenu as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->link }}</td>
                                    <td>
                                        <span>
                                            <i style="color: rgb(14, 0, 0);font-size:20px"
                                                class="{{ $item->icono}}"></i>
                                        </span>
                                    </td>
                                    <td>{{ $item->orden }}</td>
                                    <td>{{ $item->grupomenu->nombre }}</td>
                                    <td>
                                        <a href="{{ route('show_opcionmenu' , $item->id) }}"
                                            title="Ver opcionmenu"><button class="btn btn-outline-secondary btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i>
                                            </button></a>
                                        <a href="{{ route('edit_opcionmenu' , $item->id) }}"
                                            title="Editar opcionmenu"><button class="btn btn-outline-primary btn-sm"><i
                                                    class="fas fa-edit" aria-hidden="true"></i>
                                            </button></a>
                                        <form class="form-eliminar" method="POST"
                                            action="{{ route('destroy_opcionmenu' , $item->id) }}"
                                            accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Eliminar opcionmenu"><i class="fas fa-trash-alt"
                                                    aria-hidden="true"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $opcionmenu->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection