@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold">Caja</div>
            <div class="card-body">
                <div class="btn-gtoup">
                    <button class="btn btn-primary btn-sm mb-2" {{($btnApertura)?'':'disabled'}}>
                        <i class="fas fa-plus-square" aria-hidden="true"></i>
                        <a href="{{ route('apertura_caja') }}" class="text-decoration-none text-white" title="Apertura">
                            Apertura
                        </a>
                    </button>
                    <button class="btn btn-secondary btn-sm mb-2" {{($btnNuevo)?'':'disabled'}}>
                        <i class="fas fa-money-bill" aria-hidden="true"></i>
                        <a href="{{ route('create_caja') }}" class="text-decoration-none text-white" title="Nuevo">
                            Nuevo
                        </a>
                    </button>
                    <form action="{{ route('cierre_caja') }}" class="d-inline" novalidate title="Cierre"><button
                            class="btn btn-danger btn-sm mb-2" {{($btnCerrar)?'':'disabled'}}><i
                                class="fas fa-external-link-alt" aria-hidden="true"></i>
                            <input hidden type="number" id="total" name="total">
                            Cierre</button></form>
                    <a href="{{route('caja_pdf')}}">
                        <button class="btn btn-warning btn-sm mb-2 {{(!$disabled)?'disabled':''}}"><i
                                class="fas fa-print" aria-hidden="true"></i>
                            Imprimir</button>
                    </a>
                </div>
                {{-- {{dd( $disabled)}} --}}
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
                                @if (($item->tipo)!='Configuración Inicial Caja')
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->fecha)->formatLocalized('%d %B %Y %H:%M:00') }}
                                    </td>
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
                                    <td class="subtotal sumaIngreso">
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
                                        <span class="badge badge-danger sumaEgreso">
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
                                        {{ isset($item->movimiento ) ? 'Pago Servicio de Hotel Nro. : 000'.$item->movimiento->id  : '-'}}
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
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $cajas->appends(['search' =>
                            Request::get('search')])->render() !!} </div>
                    </div>
                    <div class="container mr-auto">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3 id="ingresos">0</h3>
                                        <p>Ingresos</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3 id="egresos">0</h3>
                                        <p>Egresos</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3 id="balance">0</h3>
                                        <p>Balance</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        var sumIngreso=0;
        $('.sumaIngreso').each(function(){
            sumIngreso += parseFloat($(this).text().replace(/,/g, ''), 10);
        });
        console.log(sumIngreso);
        var sumaEgreso=0;
        $('.sumaEgreso').each(function(){
            sumaEgreso += parseFloat($(this).text().replace(/,/g, ''), 10);
        });
        console.log(sum);
        $('#total').val(sum.toFixed(2));
        $('#total_badge').val(sum.toFixed(2));

        $('#balance').text(sum.toFixed(2));
        $('#ingresos').text(sumIngreso.toFixed(2));
        $('#egresos').text(sumaEgreso.toFixed(2));


    $("#generar").on('click', function(ev){
        ev.preventDefault();
        tipo="enviarBoleta";
        idVenta=5;
        $.ajax({
            type:'GET',
            url:'http://localhost/clifacturacion/controlador/contComprobante.php?funcion='+tipo,
            data:"idventa="+idVenta+"&_token="+ $('input[name=_token]').val(),
            success: function(r){
                console.log(r);
            },
            error: function(e){
                console.log(e.message);
            }
        });
    });


 });




</script>