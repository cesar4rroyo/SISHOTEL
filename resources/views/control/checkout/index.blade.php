@extends("theme.$theme.layout")

@section('content')
<style>
    #btnBuscarRuc:hover {
        cursor: pointer;
    }
</style>
<div class="row">
    @include ('control.checkout.modalHuesped')
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
                        <input type="hidden" id="nro_movimiento" name="nro_movimiento" value="{{$movimiento['id']}}">
                        @csrf
                        <div class="row">
                            <div class="col-sm form-group">
                                <label for="habitacion">Habitacion</label>
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
                            <div class="col-sm form-group">
                                <label class="control-label" for="dias">{{'Dias'}}</label>
                                <input required type="number" class="form-control" step="0.01" name="dias" id="dias">
                                <p id="errMessage" class="text-center text-danger">Este campo es obligatorio</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm form-group">
                                <label class="control-label" for="early_checkin">{{'Early Check In'}}</label>
                                <input class="form-control" step="0.01" type="number" name="early_checkin"
                                    id="early_checkin">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="late_checkout">{{'Late Check Out'}}</label>
                                <input class="form-control" step="0.01" type="number" name="late_checkout"
                                    id="late_checkout">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="day_use">{{'Day Use'}}</label>
                                <input class="form-control" step="0.01" type="number" name="day_use" id="day_use">
                            </div>
                        </div>
                        <div class="container mb-3">
                            <button type="button" id="calcularTotal" class="btn btn-success float-right">Calcular
                                Total</button>
                        </div>
                        <div class="row">
                            <div class="col-sm form-group" id="totalContainer">
                                <label class="control-label" for="total">{{'Total'}}</label>
                                <input class="form-control" readonly value="{{isset($total) ? $total : 0}}"
                                    type="number" name="total" id="total">
                            </div>
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
                            <span class=" badge badge-info" id="btnAddRuc" type="button" data-toggle="modal"
                                data-target="#rucModal">
                                <i class="fas fa-plus-circle"></i>
                                Agregar Cliente RUC
                            </span>
                            {{-- <input type="text" id="persona"> --}}
                            <select class="form-control" required name="persona" id="persona_select">
                                <option value="{{$pasajerosSelect[0]['id']}}">
                                    {{$pasajerosSelect[0]['nombres']}}
                                </option>
                                @foreach ($personas as $item)
                                @if ($item['id']!=$pasajerosSelect[0]['id'])
                                <option value="{{$item['id']}}">
                                    {{$item['nombres']}}
                                </option>
                                @endif
                                @endforeach
                            </select>
                            {!! $errors->first('persona', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <label for="movimientos" class=" font-weight-bold text-uppercase">{{'Húespedes'}}</label>
                            <span type="button" class="badge badge-secondary ml-2 pb-0" id="btnAgregarHuesped">
                                <i class="fas fa-plus-circle"></i>
                                {{'Agregar huésped'}}
                            </span>
                            <div id="personas" class="table-responsive">
                                <table class="table text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th>Accion</th>
                                            <th>Nombre</th>
                                            <th>DNI / RUC</th>
                                            <th>Teléfono</th>
                                            <th>Dirección</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pasajerosSelect as $item)
                                        <tr>
                                            @if (count($pasajerosSelect)!=1)
                                                <td>
                                                    <button type="submit" data-id="{{$item['id_pasajero']}}" class="btn btn-outline-danger btn-sm btnELiminarHuesped"
                                                            title="Eliminar persona"><i class="fa fa-trash"
                                                                aria-hidden="true"></i>
                                                    </button>
                                                </td> 
                                            @else
                                            <td>
                                                
                                            </td> 
                                            @endif                                           
                                            <td>
                                                {{isset($item['nombres'])? $item['nombres'] : '-'}}
                                            </td>
                                            <td>
                                                {{isset($item['ruc']) ? $item['ruc'] : $item['dni']}}
                                            </td>
                                            <td>
                                                {{$item['telefono']}}
                                            </td>
                                            <td>
                                                {{$item['direccion']}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comentario" class="control-label">{{'Comentario'}}</label>
                            <textarea class="form-control" name="comentario" id="comentario" rows="5">
                            </textarea>
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
<div class="modal fade" id="rucModal" tabindex="-1" aria-labelledby="rucModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rucModal">Añadir Cliente RUC</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm form-group">
                        <label class="control-label" for="ruc">{{'RUC'}}</label>
                        <span class="badge badge-primary" id="btnBuscarRuc">
                            <i class="fas fa-search"></i>
                            {{'Buscar'}}</span>
                        <input class="form-control" type="number" name="ruc" id="ruc">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm form-group">
                        <label class="control-label" for="razonsocial">{{'Razon Social'}}</label>
                        <input class="form-control" readonly type="text" name="razonsocial" id="razonsocial">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm form-group">
                        <label class="control-label" for="direccion">{{'Direccion'}}</label>
                        <input class="form-control" readonly type="text" name="direccion" id="direccion">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnGuardarCliente" class="btn btn-primary">Guardar
                    Cambios</button>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        $('#errMessage').hide();
        $('#calcularTotal').hide();
        $('#totalContainer').hide();
        $('#btnAddRuc').hide();

        $('#btnAgregarHuesped').on('click', function(){
            $('#modalHuesped').modal('toggle');
        });

        $('.btnELiminarHuesped').on('click', function(e){
            e.preventDefault();
            var id = $(this).attr('data-id');
            var data = {
                id: id,
                _token: $('input[name=_token]').val(),
            }
            swal({
                title: '¿ Está seguro que desea eliminar el huesped ?',
                text: "Si lo elimina ahora ya no lo podrá usar despues!",
                icon: 'warning',
                buttons: {
                    cancel: "Cancelar",
                    confirm: "Aceptar"
                },
            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: "{{route('destroy_pasajero')}}",
                        type: 'POST',
                        data: data,
                        success: function (respuesta) {
                            if (respuesta.mensaje == "ok") {
                                Hotel.notificaciones('El registro fue eliminado correctamente', 'Hotel', 'success');
                                if (data.type != 'error') {
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                }

                            } else {
                                Hotel.notificaciones('El registro no pudo ser eliminado, hay recursos usandolo', 'Hotel', 'error');
                            }
                        },
                        error: function (e) {
                            console.log('Error: ', e);
                        }
                    });
                }
            });
        });

        
        $('#huespedForm').on('submit', function(e){
            e.preventDefault();
            //const formData = new FormData(document.getElementById('huespedForm'));
            var formData = $('#huespedForm').serialize();
            var dni = $('#dniH').val();
            var isDisabled = $('#dniH').prop('disabled');
            var id_movimiento = $('#nro_movimiento').val();
            
            if(isDisabled){
                var id = $('#idHuesped').val();
                var data = {
                    id:id,
                    id_movimiento: id_movimiento,
                    _token: $('input[name=_token]').val(),
                }
                $.ajax({
                    type:'POST',
                    url:"{{route('add_huesped_habitacion')}}",
                    data: data,
                    success:function(r){
                        Hotel.notificaciones(r.message, 'SISTEMA HOTEL', r.type);
                        if (data.type != 'error') {
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(e){
                        console.log(e);                      
                    }
                });
            }else {
                $.ajax({
                    type:'POST',
                    url: "{{route('store_persona_checkout')}}",
                    data : formData,
                    success: function(data){
                        Hotel.notificaciones(data.message, 'SISTEMA', data.type);
                        if (data.type != 'error') {
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                        $('#modalHuesped').modal('toggle');
                    },
                    error: function(e){
                        Hotel.notificaciones(e.message, 'Error!', e.type);
                    }
                });               
            }
           
        });

        $('#btnBuscarDni').on('click', function(){
            var dni = $('#dniH').val();
            var data = {
                dni:dni,
            }
            $.ajax({
                type:'GET',
                url:"{{route('getPersonaDni')}}",
                data: data,
                success: function(r){
                    var persona = r.persona;
                    $.each(persona, function(nombre, data){
                        var input = $(document).find('[name="' +
                                        nombre +
                                        'H"]');
                        input.val(data);                       
                    });
                    $('.selectRolHuesped').val(r.roles).trigger('change');
                    $('#idHuesped').val(persona.id);
                    console.log(persona.id);
                    $('#modalHuesped')
                        .find("input,textarea,select")
                        .prop('disabled', true)
                        .end()
                        .find("input[type=checkbox], input[type=radio]")
                        .prop("disabled", true)
                        .end();  
                },
                error: function(e){
                    console.log(e);
                }
            })
        });
        $("#btnBuscarRuc").on('click', function(){
            var ruc = $('#ruc').val();
            $.ajax({
                type:'GET',
                url: 'http://157.245.85.164/facturacion/buscaCliente/BuscaClienteRuc.php?fe=N',
                data:"&token=qusEj_w7aHEpX"+"&ruc="+ruc,
                success:function(r){
                    var data = JSON.parse(r);
                    if(data.code == 0){
                        $('#razonsocial').val(data.RazonSocial);
                        $('#direccion').val(data.Direccion);                    
                    }
                }
            });
        });

        $("#btnBuscarRucHuesped").on('click', function(){
            var ruc = $('#rucH').val();
            $.ajax({
                type:'GET',
                url: 'http://157.245.85.164/facturacion/buscaCliente/BuscaClienteRuc.php?fe=N',
                data:"&token=qusEj_w7aHEpX"+"&ruc="+ruc,
                success:function(r){
                    var data = JSON.parse(r);
                    if(data.code == 0){
                        $('#razonsocialH').val(data.RazonSocial);
                        $('#direccion').val(data.Direccion);
                        $('#nombresH').val('-').prop('disabled', true);
                        $('#apellidosH').val('-').prop('disabled', true);                    
                    }
                }
            });
        });

        $('#btnGuardarCliente').on('click', function(){
            var ruc = $('#ruc').val();
            var razonsocial = $('#razonsocial').val();
            var direccion = $('#direccion').val();
            var select = $('#persona_select');
            if(ruc.trim()=='' || razonsocial.trim()=='' || direccion.trim()==''){
                alert('Uno o más campos están vacios');
            }else{
                $.ajax({
                    type:'POST',
                    url:"{{route('storeClienteRuc')}}",
                    data:{
                        "ruc":ruc,
                        "razonsocial":razonsocial,
                        "direccion":direccion,
                        "_token": $('input[name=_token]').val(),
                    },
                    success: function(r){
                        if(r.mensaje=='ok'){                            
                            $.ajax({
                                type:'GET',
                                url:"{{route('getClientesRuc')}}",
                                success:function(res){
                                    select.find('option').remove();
                                    $.each(res.data, function(key,value){
                                        select.append("<option value='" + value.id + "'>" + value.nombre + "</option>");
                                    });
                                    $('#rucModal').modal('hide');
                                    Hotel.notificaciones('Se agrego correctamente', 'Hotel', 'success');
                                },
                                error:function(e){
                                    console.log(e);
                                    $('#rucModal').modal('hide');
                                    Hotel.notificaciones('Ha ocurrido un error', 'Hotel', 'error');   
                                }
                            });                            
                        }
                        console.log(r);
                    },
                    error: function(e){
                        console.log(e);
                        $('#rucModal').modal('hide');
                        Hotel.notificaciones('Ha ocurrido un error', 'Hotel', 'error');                            
                    }
                })
            }
        });

        $('#rucModal').on('hidden.bs.modal', function (e) {
            $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();        
        });

        $('#modalHuesped').on('hidden.bs.modal', function (e) {
            $(this)
                .find("input,textarea,select")
                .val('')
                .prop('disabled', false)
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();  
            $(".selectRolHuesped").val([]).trigger("change");      
        });

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
                            // window.location.href = "{{route('caja')}}";
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
                                    url:'http://192.168.0.200:81/clifacturacion/controlador/contComprobante.php?funcion='+funcion,
                                    //url:'http://localhost/clifacturacion/controlador/contComprobante.php?funcion='+funcion,
                                    data:"idventa="+idComprobante+"&_token="+ $('input[name=_token]').val(),
                                    success: function(r){
                                        window.open('http://192.168.0.200:81/hotel/public/admin/comprobantes/pdf'+'/'+idComprobante, "_blank");
                                        //window.open('http://localhost/test/public/admin/comprobantes/pdf'+'/'+idComprobante, "_blank");         
                                        window.location.href = "{{route('caja')}}";
                                        console.log(r);
                                    },
                                    error: function(e){
                                        console.log(e.message);
                                    }
                                });  
                            }else{
                                window.open('http://192.168.0.200:81/hotel/public/admin/comprobantes/pdf'+'/'+idComprobante, "_blank"); 
                                //window.open('http://localhost/test/public/admin/comprobantes/pdf'+'/'+idComprobante, "_blank");         
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
        var select = $('#persona_select');
        if(optVal=='factura'){
            $('#btnAddRuc').show();
        }else{
            $('#btnAddRuc').hide();
        }
            $.ajax({
                url:"{{url('admin/ventas')}}" + "/" + optVal,
                success:function(r){
                    $('#numero').val(r);
                    if(optVal=='factura'){
                        $.ajax({
                            type:'GET',
                            url: "{{route('getClientesRuc')}}",
                            success:function(res){
                                select.find('option').remove();
                                $.each(res.data, function(key,value){
                                    select.append("<option value='" + value.id + "'>" + value.nombre + "</option>");
                                });
                            }
                        });
                    }else{
                        $.ajax({
                            type:'GET',
                            url: "{{route('getTodosClientes')}}",
                            success:function(res){
                                select.find('option').remove();
                                $.each(res.data, function(key,value){
                                    select.append("<option value='" + value.id + "'>" + value.nombre + "</option>");
                                });
                            }
                        }); 
                    }
                },
                error:function(e){
                    console.log(e);
                }
            });
        });
    $("#dias").on('change',function(){
        if($(this).val().trim()==''){
            $('#calcularTotal').hide();
            $('#totalContainer').hide();
        }else{
            $('#calcularTotal').show();
        }
        // $('#total').val(parseFloat({{isset($total) ? $total : 0}}));        

        // var dias =$(this).val();
        // var preciohabitacion = $('#preciohabitacion').val();
        // console.log(dias);
        // var habitaciontotal = dias*preciohabitacion;
        // var total = $('#total').val();
        // total = parseFloat(habitaciontotal) + parseFloat(total);
        // $('#total').val(parseFloat(total));       
    });
    $('#calcularTotal').on('click', function(){
        var early = ($('#early_checkin').val().trim());
        var late = $('#late_checkout').val().trim();
        var use =$('#day_use').val().trim();
        var dias = $('#dias').val().trim();
        $('#total').val(parseFloat({{isset($total) ? $total : 0}}));        
        early = (early=='' || early==undefined || early==0) ? 0 : parseFloat(early);
        late = (late=='' || late==undefined || late==0) ? 0 : parseFloat(late);
        use = (use=='' || use==undefined || use==0) ? 0 : parseFloat(use);
        var preciohabitacion = $('#preciohabitacion').val();
        var habitaciontotal = dias*preciohabitacion;
        var total = $('#total').val();
        total = early + late + use + parseFloat(habitaciontotal) + parseFloat(total);
        $('#total').val(parseFloat(total));
        $('#totalContainer').show();



    });
     
 })
</script>