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
                <div class="row">
                    <div class="col-sm">
                        <form method="GET" action="{{ route('caja_lista') }}" accept-charset="UTF-8"
                            class="my-2 my-lg-0" role="tipo">
                            <div class="input-group">
                                <select class="form-control" name="tipo" value="{{ request('tipo') }}">
                                    <option value=""><i class="fas fa-filter"></i> Filtrar por Tipo</option>
                                    <option value="Ingreso">Ingreso</option>
                                    <option value="Egreso">Egreso</option>
                                </select>
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm">
                        <form method="GET" action="{{ route('caja_lista') }}" accept-charset="UTF-8"
                            class="my-2 my-lg-0" role="concepto">
                            <div class="input-group">
                                <select class="form-control" name="concepto" value="{{ request('concepto') }}">
                                    <option value=""><i class="fas fa-filter"></i> Filtrar por Conceptos</option>
                                    @foreach ($concepto as $item)
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
                    </div>
                </div>
                <br>
                {{-- <form method="GET" action="{{ route('caja_lista') }}" accept-charset="UTF-8" class="my-2 my-lg-0"
                role="search">
                <div class="input-group">
                    <input placeholder="Buscar..." class="form-control" name="search" value="{{ request('search') }}" />
                    <span class="input-group-append">
                        <button class="btn btn-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                </form>
                <br> --}}
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
                                    <th>Numero</th>
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
                                        {{ isset($item->movimiento ) ? $item->movimiento->id  : '-'}}
                                    </td>
                                    <td>{{ $item->usuario->login }}</td>
                                    <td>{{ $item->numero }}</td>
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