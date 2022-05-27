<div class="container" id="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Servicios</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <a href="{{ route('create_servicios') }}" class="btn btn-outline-success"
                                title="Agregar nuevo servicio">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                            </a>
                        </div>
                        <div class="col">
                            <form method="GET" action="{{ route('servicios') }}" accept-charset="UTF-8"
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
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicios as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->precio }}</td>
                                    @if (($item->id)!=1 && ($item->id)!=2 && ($item->id)!=3 && ($item->id)!=4 && ($item->id)!=6)
                                    <td>
                                        <a href="{{ route('show_servicios', $item->id) }}" title="Ver servicio"><button
                                                class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"
                                                    aria-hidden="true"></i>
                                            </button></a>
                                        <a href="{{ route('edit_servicios', $item->id ) }}"
                                            title="Editar servicio"><button class="btn btn-outline-primary btn-sm"><i
                                                    class="fas fa-edit" aria-hidden="true"></i>
                                            </button></a>

                                        <form class="form-eliminar" method="POST"
                                            action="{{ route('destroy_servicios' , $item->id) }}" accept-charset="UTF-8"
                                            style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Eliminar servicio"><i class="fas fa-trash-alt"
                                                    aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $servicios->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>