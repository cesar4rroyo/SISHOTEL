<div class="container" id="container">
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
                    <a href="{{ route('create_grupomenu') }}" class="btn btn-outline-success" title="Agregar nuevo">
                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar Nuevo
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="tabla-data">
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
                                    <td>
                                        <span>
                                            <i style="color: rgb(14, 0, 0);font-size:20px"
                                                class="{{ $item->icono}}"></i>
                                        </span></td>
                                    <td>{{ $item->orden }}</td>
                                    <td>
                                        <a href="{{ route('show_grupomenu', $item->id) }}" title="Ver grupomenu"><button
                                                class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"
                                                    aria-hidden="true"></i>
                                            </button></a>
                                        <a href="{{ route('edit_grupomenu', $item->id ) }}"
                                            title="Editar grupomenu"><button class="btn btn-outline-primary btn-sm"><i
                                                    class="fas fa-edit" aria-hidden="true"></i>
                                            </button></a>

                                        <form class="form-eliminar" method="POST"
                                            action="{{ route('destroy_grupomenu', $item->id) }}" accept-charset="UTF-8"
                                            style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Eliminar grupomenu"><i class="fas fa-trash-alt"
                                                    aria-hidden="true"></i> </button>
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