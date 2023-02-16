@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Check In</div>
            <div class="card-body">
                <a href="{{ route('habitaciones') }}" title="Regresar"><button
                        class="btn btn-outline-secondary btn-sm mb-2"><i class="fa fa-arrow-left"
                            aria-hidden="true"></i>
                        Regresar</button></a>
                <div class="modal fade" id="modal-pasajero" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('store_persona_checkin') }}" accept-charset="UTF-8"
                                    class="form-horizontal" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @include ('control.checkin.form', ['formMode' => 'create'])
                                    <input type="text" name="habitacion" hidden value="{{$habitacion['id']}}">
                                    <input type="text" name="reserva" hidden
                                        value="{{isset($id_reserva) ? $id_reserva : null}}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <form method="POST" action="{{route('store_movimiento', isset($id_reserva) ? $id_reserva : null)}}">
                        @csrf
                        <div class="row">
                            <div class="col-sm form-group">
                                <label for="habitacion">{{'Habitacion'}}</label>
                                <input class="form-control" type="text" name="habitacion" hidden
                                    value="{{$habitacion['id']}}">
                                <input class="form-control" type="text" readonly value="{{$habitacion['numero']}}">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="fechaingreso">{{'Fecha Ingreso'}}</label>
                                <input class="form-control" id="fechaingreso" name="fechaingreso" type="datetime-local"
                                    value="{{$initialDate}}">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="fechasalida">{{'Fecha Salida'}}</label>
                                <input class="form-control" id="fechasalida" name="fechasalida" required
                                    type="datetime-local">
                            </div>
                            @isset($id_reserva)
                            <div class="col-sm form-group">
                                <label class="control-label" for="reserva">{{'Reserva Nro.'}}</label>
                                <input readonly class="form-control" value="{{$id_reserva}}" type="number"
                                    name="reserva" id="reserva">
                            </div>
                            @endisset
                        </div>
                        <div class="row">
                            <div class="col-sm form-group">
                                <label class="control-label" for="preciohabitacion">{{'Precio Habitacion'}}</label>
                                <input class="form-control" readonly value="{{$habitacion['tipohabitacion']['precio']}}"
                                    type="number" name="preciohabitacion" id="preciohabitacion">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="capacidad">{{'Capacidad Habitacion'}}</label>
                                <input class="form-control" readonly
                                    value="{{$habitacion['tipohabitacion']['capacidad']}}" type="number"
                                    name="capacidad" id="capacidad">
                            </div>
                            {{-- <div class="col-sm form-group">
                                <label class="control-label" for="descuento">{{'Descuento'}}</label>
                            <input class="form-control" type="number" name="descuento" id="descuento">
                        </div> --}}
                        {{-- <div class="col-sm form-group">
                            <label class="control-label" for="total">{{'Total'}}</label>
                        <input class="form-control" readonly type="number" name="total" id="total">
                </div> --}}
            </div>
            <div class="form-group">
                <label class="control-label" for="persona">{{'Pasajero Principal'}}</label>
                <a type="button" data-toggle="modal" data-target="#modal-pasajero">
                    <span class="badge badge-success">
                        <i class="fas fa-plus-circle"></i>
                        {{'Agregar Nuevo Cliente'}}</span>
                </a>
                <select class="form-control clientes-select2" name="persona_principal" id="persona_principal" required>
                    <option value="">Seleccione Uno</option>
                    @foreach ($personas as $persona)
                    <option value="{{$persona['id']}}">
                        {{$persona['nombres']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="persona">{{'Acompañantes'}}</label>
                <a type="button" data-toggle="modal" data-target="#modal-pasajero">
                    <span class="badge badge-success">
                        <i class="fas fa-plus-circle"></i>
                        {{'Agregar Nuevo Cliente'}}</span>
                </a>
                <select class="form-control clientes-select2" multiple='multiple' name="persona[]" id="persona">
                    <option value="">Seleccione Uno</option>
                    @foreach ($personas as $persona)
                    <option value="{{$persona['id']}}">
                        {{$persona['nombres']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <label for="comentario">{{'Comentario'}}</label>
                <textarea class="form-control" name="comentario" id="comentario" cols="5" rows="5">
                    @if (isset($reserva))
                        {{$reserva->observacion}}
                    @endif
                </textarea>
            </div>
            <p class="font-weight-bold mt-4">Datos de Tarjeta</p>
            <hr>
            <div class="form-group">
                <label class="control-label" for="tipo">{{'Tipo de Tarjeta'}}</label>
                <select class="form-control" name="tipo" id="tipo">
                    <option value="">Seleccione Uno</option>
                    <option value="Amex">{{'American Express'}}</option>
                    <option value="Visa">{{'Visa'}}</option>
                    <option value="Mastercard">{{'Master Card'}}</option>
                    <option value="Diners">{{'Diners'}}</option>
                </select>
            </div>
            <div class="row">
                <div class="col-sm form-group">
                    <label for="numero">{{'Número de Tarjeta'}}</label>
                    <input autocomplete="false" class="form-control" id="numero" type="text" name="numero">
                </div>
                <div class="col-sm form-group">
                    <label for="fechavencimiento">{{'Fecha de Vencimiento(ej.: 01/21)'}}</label>
                    <input autocomplete="false" class="form-control" id="fechavencimiento" type="text"
                        name="fechavencimiento">
                </div>
            </div>
            <div class="form-group">
                <label for="titular">{{'Nombre del Titular'}}</label>
                <input autocomplete="false" class="form-control" id="titular" type="text" name="titular">
            </div>
            <div class="container text-center">
                <button type="submit" class="btn btn-outline-success col-sm-6">
                    Check-In
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
        $("#btnBuscarRuc").on('click', function(){
        var ruc = $('#ruc').val();
        if(ruc.length!=11){
            alert('El RUC debe tener 11 dígitos');
            $('#ruc').val('');
            return;
        }
        $.ajax({
            type:'GET',
            url: 'http://157.245.85.164/facturacion/buscaCliente/BuscaClienteRuc.php?fe=N',
            data:"&token=qusEj_w7aHEpX"+"&ruc="+ruc,
            success:function(r){
                var data = JSON.parse(r);
                if(data.code == 0){
                    $('#razonsocial').val(data.RazonSocial);
                    $('#direccion').val(data.Direccion);
                    $('#nombres').val('-');
                    $('#apellidos').val('-');
                    $('#nombres').prop('readonly', true);
                    $('#apellidos').prop('readonly', true);
                }
            }

        })
    });

    $('#modal-pasajero').on('hidden.bs.modal', function (e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
        $('#nombres').prop('readonly', false);
        $('#apellidos').prop('readonly', false);
    });
   
    $('#dni').change(function(){
        var dni = $('#dni').val();
        if(dni.length!=8){
            alert('El DNI debe tener 8 dígitos');
            $('#dni').val('');
            return false;
        }
        if(typeof dni == 'undefined' || dni == null || dni == ''){
            alert('El DNI debe tener 8 dígitos');
            $('#dni').val('');
            return false;
        }
        $.ajax({
            type:'GET',
            url: 'http://facturae-garzasoft.com/facturacion/buscaCliente/BuscaCliente2.php?' + 'dni=' + dni + '&fe=N&token=qusEj_w7aHEpX',
            success:function(r){
                var data = JSON.parse(r);
                console.log(data);
                if(data.code == 0){
                    $('#nombres').val(data.nombres + ' ' + data.apepat + ' ' + data.apemat);
                    $('#razonsocial').val('-');
                    $('#ruc').val('-');
                    $('#razonsocial').prop('readonly', true);
                    $('#ruc').prop('readonly', true);
                }
            },
            error:function(r){
                alert('DNI Incorrecto');
            }
        })

    });
    
    
 })


</script>