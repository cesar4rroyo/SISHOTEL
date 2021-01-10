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
                <a href="{{ route('check_in_pdf', $movimiento['id'])}}" title="Imprimir"><button
                        class="btn btn-warning btn-sm mb-2"><i class="fas fa-print" aria-hidden="true"></i>
                        Imprimir Check-In</button></a>
                <div class="container">

                    <form action="{{route('add_checkout', $movimiento['id'])}}" id="checkoutForm" method="POST"
                        onsubmit="return confirm('¿Está seguro que desea hacer finalizar el Check-Out?')">

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
                                <span class=" badge badge-info" type="button" data-toggle="modal"
                                    data-target="#descuento">
                                    <i class="fas fa-plus-circle"></i>
                                    Descuento
                                </span>
                                <input type="number" name="txtDsctoForm" id="txtDsctoForm" hidden>
                                <div class="modal fade" id="descuento" tabindex="-1" aria-labelledby="modalDscto"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalDscto">Añadir Descuento</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm form-group">
                                                        <label class="control-label"
                                                            for="preciosugerido">{{'Precio Sugerido'}}</label>
                                                        <input class="form-control" readonly
                                                            value="{{$habitacion['tipohabitacion']['precio']}}"
                                                            type="number" name="preciosugerido" id="preciosugerido">
                                                    </div>
                                                    <div class="col-sm form-group">
                                                        <label class="control-label"
                                                            for="txtDescuento">{{'Descuento'}}</label>
                                                        <input class="form-control" step="0.01" value="{{0}}"
                                                            type="number" name="txtDescuento" id="txtDescuento">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="control-label"
                                                        for="precioFinal">{{'Precio con Descuento'}}</label>
                                                    <input class="form-control" readonly value="{{0}}" type="number"
                                                        name="precioFinal" id="precioFinal">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                                <button type="button" id="btnDscto" class="btn btn-primary">Guardar
                                                    Cambios</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                            <p id="errMessage" class="text-center text-danger">Este campo es obligatorio</p>
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
                <button type="button" id="btnCheckOut" class="btn btn-outline-success col-sm-6">
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
        $('#errMessage').hide();
        const btnCheckOut = document.getElementById('btnCheckOut').onclick=function(event){
            event.preventDefault();
            const data = new FormData(document.getElementById('checkoutForm'));
            var dias = document.getElementById('dias').value;
            var total = document.getElementById('total').value;
            if(dias.trim()!='' && total.trim()!=0){
                swal({
                    title:'¿Está seguro que desea continuar con esta operación?',
                    text:'Está a punto de finalizar el Check-Out.',
                    icon:'warning',
                    buttons: {
                        cancel: "Cancelar",
                        confirm: "Aceptar"
                    },
                }).then(function(){
                    fetch("{{route('add_checkout', $movimiento['id'])}}", {
                        method:'POST',
                        body:data,
                    })
                    .then(res=>res.json())
                    .then(function(data){
                        if(data.respuesta=='ok'){
                            var idComprobante =data.id_comprobante
                            var tipoDoc = data.tipoDoc 
                            if(tipoDoc !="ticket"){
                                if(tipoDoc=="boleta"){
                                    var funcion ='enviarBoleta'
                                }else if(tipoDoc=="factura"){
                                    var funcion ='enviarFactura'
                                }                    
                                $.ajax({
                                    type:'GET',
                                    url:'http://localhost/clifacturacion/controlador/contComprobante.php?funcion='+funcion,
                                    data:"idventa="+idComprobante+"&_token="+ $('input[name=_token]').val(),
                                    success: function(r){
                                        window.location.href = "{{route('caja')}}";
                                        console.log(r);
                                    },
                                    error: function(e){
                                        console.log(e.message);
                                    }
                                });  
                            }else{
                                window.location.href = "{{route('caja')}}";
                            }   
                        }else{
                            swal({
                                title:'Ha ocurrido un error',
                                text:data.mensaje,
                                icon:'error',
                            });
                            // $('#loading').hide();
                        } 
                    })
                    .catch(function(e){
                        swal({
                            title:'Ha ocurrido un error',
                            text:'Oops, el checkout no se ha podido realizar',
                            icon:'error',
                        });
                    });
                    
                });
            }else{
                $('#errMessage').show();
            }            
        }        
       
       
        $('#txtDescuento').on('change', function(){
            var dscto = $(this).val();
            var preciosugerido = $('#preciosugerido').val();
            var precioFinal = $('#precioFinal').val();
            precioFinal = preciosugerido - parseFloat(preciosugerido*dscto/100);
            $('#precioFinal').val(precioFinal);
            console.log(precioFinal); 

        });
        $('#btnDscto').on('click', function(){
            var dscto = $(this).val();
            var precioFinal = $('#precioFinal').val();
            if(dscto.trim()!='0' && precioFinal.trim()!=0){
                $('#preciohabitacion').val(precioFinal);
                $('#txtDsctoForm').val(dscto);
                $('#descuento').modal('toggle');
            }else{
                $('#descuento').modal('toggle');
            }

        })
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