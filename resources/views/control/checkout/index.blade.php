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
                <a href="{{ route('check_in_pdf', $movimiento['id'] ) }}" title="Imprimir"><button
                        class="btn btn-warning btn-sm mb-2"><i class="fas fa-print" aria-hidden="true"></i>
                        Imprimir Check-In</button></a>
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
                                <label class="control-label" for="capacidad">{{'Capacidad Habitacion'}}</label>
                                <input class="form-control" readonly
                                    value="{{$habitacion['tipohabitacion']['capacidad']}}" type="number"
                                    name="capacidad" id="capacidad">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="fechaingreso">{{'Fecha Ingreso'}}</label>
                                <input class="form-control" readonly
                                    value="{{Carbon\Carbon::parse($movimiento["fechaingreso"])->format('Y-m-d\TH:i')}}"
                                    id="fechaingreso" name="fechaingreso" type="datetime-local">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="fechasalida">{{'Fecha Salida'}}</label>
                                <input class="form-control" required
                                    value="{{Carbon\Carbon::parse($movimiento["fechasalida"])->format('Y-m-d\TH:i')}}"
                                    id="fechasalida" name="fechasalida" type="datetime-local">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm form-group">
                                <label class="control-label" for="preciohabitacion">{{'Precio Habitacion'}}</label>
                                <input class="form-control" readonly value="{{$habitacion['tipohabitacion']['precio']}}"
                                    type="number" name="preciohabitacion" id="preciohabitacion">
                            </div>
                            {{-- <div class="col-sm form-group">
                                <label class="control-label" for="descuento">{{'Descuento'}}</label>
                            <input class="form-control" type="number"
                                value="{{is_null($movimiento['descuento']?$movimiento['descuento']:0)}}"
                                name="descuento" id="descuento">
                        </div> --}}
                        <div class="col-sm form-group">
                            <label class="control-label" for="dias">{{'Dias'}}</label>
                            <input required type="number" class="form-control" step="0.01" name="dias" id="dias">
                        </div>
                        <div class="col-sm form-group">
                            <label class="control-label" for="total">{{'Total'}}</label>
                            <input class="form-control" readonly value="{{isset($total) ? $total : 0}}" type="number"
                                name="total" id="total">
                        </div>
                        {{-- @isset($reserva)
                        <div class="col-sm form-group">
                            <label class="control-label" for="reserva">{{'Reserva Nro.'}}</label>
                        <input readonly class="form-control" value="{{$reserva}}" type="number" name="reserva"
                            id="reserva">
                </div>
                @endisset --}}
            </div>
            @if (count($movimiento['detallemovimiento'])!=0)
            <div class="container">
                <label for="movimientos" class=" text-uppercase font-weight-bold">Movimientos</label>
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
            <p class=" font-weight-bold text-uppercase">Datos del documento</p>
            <hr>
            <div class="row">
                <div class="col-sm form-group">
                    <label for="tipodocumento" class="control-label">{{ 'Tipo Documento' }}</label>
                    <select class="form-control" name="tipodocumento" id="tipodocumento">
                        {{-- <option value="">Seleccione una opción</option> --}}
                        <option selected value="boleta">Boleta</option>
                        <option value="factura">Factura</option>
                        <option value="ticket">Ticket</option>
                    </select>
                </div>
                <div class="col-sm form-group">
                    <label class="control-label" for="numero">Número de Comprobante</label>
                    <input type="text" readonly class="form-control" name="numero_comprobante" id="numero"
                        value="{{$numero}}">
                </div>
            </div>
            <div class="form-group col-sm {{ $errors->has('persona') ? 'has-error' : ''}}">
                <label for="persona" class="control-label">{{ 'Persona' }}</label>
                {{-- <input type="text" id="persona"> --}}
                <select class="form-control" required name="persona" id="persona_select">
                    <option value="{{$pasajeros[0]['persona']['id']}}">
                        {{$pasajeros[0]['persona']['nombres'] . ' ' . $pasajeros[0]['persona']['apellidos']}}
                    </option>
                    @foreach ($pasajeros as $item)
                    @if ($item['persona']['id']!=$pasajeros[0]['persona']['id'])
                    <option value="{{$item['persona']['id']}}">
                        {{$item['persona']['nombres']}} {{" "}}{{$item['persona']['apellidos']}}
                    </option>
                    @endif
                    @endforeach
                </select>
                {!! $errors->first('persona', '<p class="text-danger">:message</p>') !!}
            </div>
            <div class="row">
                <label for="movimientos" class=" font-weight-bold text-uppercase">{{'Húespedes'}}</label>
                <div id="personas" class="table-responsive">
                    <table class="table text-center table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>DNI / RUC</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pasajeros as $item)
                            <tr>
                                <td>
                                    {{isset($item['persona']['nombres'])? $item['persona']['nombres'] . " " . $item['persona']['apellidos'] : $item['persona']['nombres']}}
                                </td>
                                <td>
                                    {{isset($item['persona']['ruc'])?$item['persona']['ruc']:$item['persona']['dni']}}
                                </td>
                                <td>
                                    {{$item['persona']['telefono']}}
                                </td>
                                <td>
                                    {{$item['persona']['direccion']}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="form-group">
                <label for="comentario" class="control-label">{{'Comentario'}}</label>
                <textarea class="form-control" name="comentario" id="comentario" cols="5" rows="5"></textarea>
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
        $(document.body).on('change',"#tipodocumento",function (e) {
           var optVal= $("#tipodocumento option:selected").val();
           $.ajax({
               url:"{{url('admin/ventas')}}" + "/" + optVal,
               success:function(r){
                   $('#numero').val(r);
               },
               error:function(e){
                   console.log(e);
               }
           })
    });
    $("#dias").on('change',function(){
        $('#total').val(parseFloat({{isset($total) ? $total : 0}}));        

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