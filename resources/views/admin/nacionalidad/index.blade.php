<div class="container" id="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Nacionalidad</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <a href="{{ route('create_nacionalidad') }}" class="btn btn-outline-success"
                                title="Agregar nueva Nacionalidad">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo
                            </a>
                        </div>
                        <div class="col">
                            <form method="GET" action="{{ route('nacionalidad') }}" accept-charset="UTF-8"
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
                        <table class="table table-hover text-center" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nacionalidad as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>
                                        <a href="{{ route('show_nacionalidad', $item->id)  }}"
                                            title="Ver nacionalidad"><button class="btn btn-outline-secondary btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i>
                                            </button></a>
                                        <a href="{{ route('edit_nacionalidad', $item->id ) }}"
                                            title="Editar nacionalidad"><button
                                                class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"
                                                    aria-hidden="true"></i>
                                            </button></a>

                                        <form class="form-eliminar" method="POST"
                                            action="{{route('destroy_nacionalidad', $item->id)}}" accept-charset="UTF-8"
                                            style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Eliminar nacionalidad"><i class="fas fa-trash-alt"
                                                    aria-hidden="true"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $nacionalidad->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>