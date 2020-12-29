@extends("theme.$theme.layout")

@section('content')
{{-- {{dd($movimiento)}} --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Check Out</div>
            <div class="card-body">
                <a href="{{ route('habitaciones') }}" title="Regresar"><button
                        class="btn btn-outline-secondary btn-sm mb-2"><i class="fa fa-arrow-left"
                            aria-hidden="true"></i>
                        Regresar</button></a>
                <div class="container">
                    <form action="{{route('add_checkout', $movimiento['id'])}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm form-group">
                                <label for="habitacion">{{'Habitacion'}}</label>
                                <input class="form-control" type="text" name="habitacion" readonly
                                    value="{{$habitacion['numero']}}">
                                <input class="form-control" type="number" name="habitacion_id" hidden
                                    value="{{$habitacion['id']}}">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="fechaingreso">{{'Fecha Ingreso'}}</label>
                                <input class="form-control" readonly
                                    value="{{Carbon\Carbon::parse($movimiento["fechaingreso"])->format('Y-m-d\TH:i')}}"
                                    id="fechaingreso" name="fechaingreso" type="datetime-local">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="fechasalida">{{'Fecha Salida'}}</label>
                                <input class="form-control"
                                    value="{{Carbon\Carbon::parse($movimiento["fechasalida"])->format('Y-m-d\TH:i')}}"
                                    id="fechasalida" value="{{$initialDate}}" name="fechasalida" type="datetime-local">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm form-group">
                                <label for="persona">{{'Cliente'}}</label>
                                <input
                                    value="{{$movimiento['persona']['nombres']}}{{" "}}{{$movimiento['persona']['apellidos']}}"
                                    type="text" class="form-control" name="persona" id="persona">

                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="preciohabitacion">{{'Precio Habitacion'}}</label>
                                <input readonly class="form-control" value="{{$habitacion['tipohabitacion']['precio']}}"
                                    type="number" name="preciohabitacion" id="preciohabitacion">
                            </div>
                        </div>
                        @if (count($movimiento['detallemovimiento'])!=0)
                        <div class="container">
                            <label for="movimientos">Movimientos</label>
                            <div id="movimientos" class="table-responsive">
                                <table class="table text-center table-hover" id="tabla-data">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Precio Total</th>
                                            <th>Cantidad</th>
                                            <th>Comentario</th>
                                            <th>Servicio/Producto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0 ?>
                                        @foreach($detalles as $item)
                                        <?php $total += $item['precioventa'] ?>
                                        <tr>
                                            <td>{{$item['fecha']}}</td>
                                            <td>
                                                {{$item['precioventa']}}
                                            </td>
                                            <td>
                                                {{$item['cantidad']}}
                                            </td>
                                            <td>
                                                {{$item['comentario']}}
                                            </td>
                                            <td>
                                                {{isset($item['producto']) ? $item['producto']['nombre'] : $item['servicios']['nombre'] }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-sm form-group">
                                <label class="control-label" for="dias">{{'Dias'}}</label>
                                <input required type="number" class="form-control" name="dias" id="dias">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="total">{{'Total'}}</label>
                                <input class="form-control" readonly value="{{$total}}" type="number" name="total"
                                    id="total">
                            </div>
                        </div>
                        <div class="container text-center">
                            <button type="submit" class="btn btn-outline-success col-sm-6">
                                Check-Out
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
    $("#dias").on('change',function(){
        $('#total').val(parseFloat({{$total}}));        

        var dias =$(this).val();
        var preciohabitacion = $('#preciohabitacion').val();
        console.log(dias);
        var habitaciontotal = dias*preciohabitacion;
        var total = $('#total').val();
        total = parseFloat(habitaciontotal) + parseFloat(total);
        $('#total').val(parseFloat(total));
       
    });
 })
</script>