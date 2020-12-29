@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Caja</div>
            <div class="card-body">
                <div class="btn-gtoup">
                    <a href="{{ route('caja') }}" title="Apertura"><button class="btn btn-primary btn-sm mb-2"><i
                                class="fas fa-plus-square" aria-hidden="true"></i>
                            Apertura</button></a>
                    <a href="{{ route('create_caja') }}" title="Nuevo"><button class="btn btn-secondary btn-sm mb-2"><i
                                class="fas fa-money-bill" aria-hidden="true"></i>
                            Nuevo</button></a>
                    <a href="{{ route('caja') }}" title="Cierre"><button class="btn btn-danger btn-sm mb-2"><i
                                class="fas fa-external-link-alt" aria-hidden="true"></i>
                            Cierre</button></a>
                    <a href="{{ route('caja') }}" title="Imprimir"><button class="btn btn-warning btn-sm mb-2"><i
                                class="fas fa-print" aria-hidden="true"></i>
                            Imprimir</button></a>
                </div>
                <div class="container mt-2">
                    <div class="table-responsive">
                        <table class="table text-center table-hover" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Número</th>
                                    <th>Persona</th>
                                    <th>Total</th>
                                    <th>Concepto</th>
                                    <th>Comentario</th>
                                    <th>Movimiento</th>
                                    <th>Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cajas as $item)
                                <tr>
                                    <td>{{ $item->fecha }}</td>
                                    <td>{{ $item->tipo }}</td>
                                    <td>{{ $item->numero }}</td>
                                    <td>
                                        {{ isset($item->persona) ? $item->persona->nombres : '-'}}
                                    </td>
                                    <td>{{ $item->total }}</td>
                                    <td>{{ $item->concepto->id }}</td>
                                    <td>
                                        {{ isset($item->movimiento ) ? $item->movimiento->id  : '-'}}
                                    </td>
                                    <td>{{ $item->usuario->login }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('show_caja' , $item->id) }}" title="Ver"><button
                                                    class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"
                                                        aria-hidden="true"></i>
                                                </button></a>
                                            <a href="{{ route('edit_caja' , $item->id ) }}" title="Editar"><button
                                                    class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"
                                                        aria-hidden="true"></i>
                                                </button></a>
                                            <form class="form-eliminar" method="POST"
                                                action="{{ route('destroy_caja', $item->id) }}" accept-charset="UTF-8"
                                                style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $cajas->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection