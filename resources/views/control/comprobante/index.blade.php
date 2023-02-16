@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Comprobantes</div>
            <div class="card-body">
                <div class="container">
                    <form method="GET" action="{{ route('comprobantes') }}" accept-charset="UTF-8" class="my-2 my-lg-0"
                        role="tipo">
                        <div class="input-group">
                            <select class="form-control" name="tipo" value="{{ request('tipo') }}">
                                <option value=""><i class="fas fa-filter"></i> Filtrar por Tipos de Documento</option>
                                <option value="boleta">{{'Boleta'}}</option>
                                <option value="factura">{{'Factura'}}</option>
                                <option value="ticket">{{'Ticket'}}</option>
                            </select>
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <br>
                    <div class="table-responsive">
                        <table class="table text-center table-hover" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>Fecha Emisión</th>
                                    <th>Tipo</th>
                                    <th>Número</th>
                                    <th>Total</th>
                                    <th>Persona</th>
                                    <th>Comentario</th>
                                    {{-- <th>Usuario</th> --}}
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comprobantes as $item)
                                <tr>
                                    <td>{{  \Carbon\Carbon::parse($item->fecha)->formatLocalized('%d %B %Y %H:%M:00') }}
                                    </td>
                                    <td class="text-capitalize">{{ $item->tipodocumento }}</td>
                                    <td>
                                        {{ $item->numero }}
                                    </td>
                                    <td>
                                        {{ $item->total }}
                                    </td>
                                    <td>
                                        @if ($item->persona)
                                        {{(isset($item->persona->razonsocial) && trim($item->persona->razonsocial)!="") ? $item->persona->razonsocial : $item->persona->nombres .' ' . $item->persona->apellidos}}
                                        @else
                                        {{'VARIOS'}}
                                        @endif
                                    </td>
                                    <td>{{ isset($item->comentario) ? $item->comentario : '-'  }}</td>
                                    {{-- <td>
                                        {{$item->usuario->login}}
                                    </td> --}}
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('show_comprobante', $item->id)}}">
                                                <button data-id="{{$item->id}}" type="button"
                                                    class="btn btn-secondary btn-sm btnShowComprobante"><i
                                                        class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            {{-- href="{{ route('show_comprobante' , $item->id) }}" --}}
                                            <a href="{{ route('comprobante_pdf' , $item->id ) }}"
                                                title="Impirmir"><button class="btn btn-warning btn-sm"><i
                                                        class="fas fa-print" aria-hidden="true"></i>
                                                </button></a>
                                            <a class="btn btn-error" 
                                            onclick="declarar3(<?php echo $item->id;?>,'<?php echo substr($item->tipodocumento,0,1);?>')" 
                                            style="display:;">Declarar </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $comprobantes->appends(['tipo' =>
                            Request::get('tipo')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function declarar3(idventa,idtipodocumento){
        if(idtipodocumento=='b'){
            var funcion="enviarBoleta";
        }else{
            var funcion="enviarFactura";
        }
        $.ajax({
            type: "GET",
            url: "http://localhost:81/clifacturacion/controlador/contComprobante.php?funcion="+funcion,
            data: "idventa="+idventa+"&_token="+$('input[name="_token"]').val(),
            success: function(a) {
                console.log(a);
            }
        }); 
    }
</script>
@endsection