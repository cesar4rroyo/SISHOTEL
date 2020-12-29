@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold">Caja</div>
            <div class="card-body">
                <div class="btn-gtoup">
                    <a href="{{ route('apertura_caja') }}" title="Apertura"><button
                            class="btn btn-primary btn-sm mb-2"><i class="fas fa-plus-square" aria-hidden="true"></i>
                            Apertura</button></a>
                    <a href="{{ route('create_caja') }}" title="Nuevo"><button class="btn btn-secondary btn-sm mb-2"><i
                                class="fas fa-money-bill" aria-hidden="true"></i>
                            Nuevo</button></a>
                    <form action="{{ route('cierre_caja') }}" title="Cierre"><button
                            class="btn btn-danger btn-sm mb-2"><i class="fas fa-external-link-alt"
                                aria-hidden="true"></i>
                            <input hidden type="number" id="total" name="total">
                            Cierre</button></form>
                </div>
                <div class="container">
                    <p>Balance: </p>
                    <input readonly type="text" readonly class="form-control" id="total_badge">
                </div>
                <div class="container mt-2">
                    <div class="table-responsive">
                        <table class="table text-center table-hover" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    {{-- <th>Número</th> --}}
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
                                    @if ( ($item->tipo)=='Ingreso' )
                                    <td>
                                        <span class="badge badge-success">
                                            {{ $item->tipo }}
                                        </span>
                                    </td>
                                    @else
                                    <td>
                                        <span class="badge badge-danger">
                                            {{ $item->tipo }}
                                        </span>
                                    </td>
                                    @endif
                                    {{-- <td>{{ $item->numero }}</td> --}}
                                    <td>
                                        @if ($item->persona)
                                        {{ $item->persona->nombres}}{{" "}}{{$item->persona->apellidos}}
                                        @endif
                                    </td>
                                    @if ( ($item->tipo)=='Ingreso' )
                                    <td class="subtotal">
                                        <span class="badge badge-success">
                                            {{ $item->total }}
                                        </span>
                                    </td>
                                    @else
                                    <td class="d-none subtotal">
                                        <span class="badge badge-danger">
                                            {{-$item->total }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">
                                            {{ $item->total }}
                                        </span>
                                    </td>
                                    @endif

                                    <td>
                                        {{ $item->concepto->nombre }}
                                    </td>
                                    <td>
                                        {{ isset($item->comentario ) ? $item->comentario  : '-'}}
                                    </td>
                                    <td>
                                        {{ isset($item->movimiento ) ? $item->movimiento->id  : '-'}}
                                    </td>
                                    <td>{{ $item->usuario->login }}</td>

                                    <td>
                                        @if ( ($item->concepto->id)==1)
                                        @else
                                        @if (($item->concepto->id)==2)
                                        @else
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
                                        @endif
                                        @endif
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
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        var sum=0;
        $('.subtotal').each(function() {  
            sum += parseFloat($(this).text().replace(/,/g, ''), 10);  
        }); 
        console.log(sum);
        $('#total').val(sum.toFixed(2));
        $('#total_badge').val(sum.toFixed(2));
 })
</script>