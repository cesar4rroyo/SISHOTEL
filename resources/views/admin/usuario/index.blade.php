<div class="container" id="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Usuario</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <a href="{{ route('create_usuario') }}" class="btn btn-outline-success"
                                title="Agregar nuevo usuario">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                            </a>
                        </div>
                        <div class="col">
                            <form method="GET" action="{{ route('usuario') }}" accept-charset="UTF-8"
                                class="my-2 my-lg-0" role="search">
                                <div class="input-group">
                                    <input placeholder="Buscar..." class="form-control" name="search"
                                        value="{{ request('search') }}" />
                                    <span class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center table-hover" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usuario Nombre</th>
                                    <th>Tipousuario</th>
                                    <th>Persona</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuario as $item)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $item->login}}</td>
                                    <td>{{ $item->tipousuario->nombre}}</td>
                                    <td>{{ $item->persona->nombres ?? '-'}}</td>
                                    <td>
                                        <a href="{{ route('show_usuario' , $item->id) }}" title="Ver usuario"><button
                                                class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"
                                                    aria-hidden="true"></i>
                                            </button></a>
                                        <a href="{{ route('edit_usuario' , $item->id ) }}"
                                            title="Editar usuario"><button class="btn btn-outline-primary btn-sm"><i
                                                    class="fas fa-edit" aria-hidden="true"></i>
                                            </button></a>

                                        <form class="form-eliminar" method="POST"
                                            action="{{ route('destroy_usuario' , $item->id) }}" accept-charset="UTF-8"
                                            style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Eliminar usuario"><i class="fas fa-trash-alt"
                                                    aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $usuario->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>