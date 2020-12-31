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
                                <form method="POST" action="{{ route('store_persona_checkin_reserva', $reserva) }}"
                                    accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    @include ('control.checkin.form', ['formMode' => 'create'])
                                    <input type="text" name="habitacion" hidden value="{{$habitacion['id']}}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <form method="POST" action="{{route('store_movimiento', isset($reserva) ? $reserva : 'no')}}">
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
                            @isset($reserva)
                            <div class="col-sm form-group">
                                <label class="control-label" for="reserva">{{'Reserva Nro.'}}</label>
                                <input readonly class="form-control" value="{{$reserva}}" type="number" name="reserva"
                                    id="reserva">
                            </div>
                            @endisset
                        </div>
                        <div class="row">
                            <div class="col-sm form-group">
                                <label class="control-label" for="persona">{{'Pasajeros'}}</label>
                                <a type="button" data-toggle="modal" data-target="#modal-pasajero">
                                    <span class="badge badge-success">
                                        <i class="fas fa-plus-circle"></i>
                                        {{'Agregar Nuevo Cliente'}}</span>
                                </a>
                                <select class="form-control clientes-select2" multiple='multiple' name="persona[]"
                                    id="persona" required>
                                    <option value="">Seleccione Uno</option>
                                    @foreach ($personas as $persona)
                                    <option value="{{$persona['id']}}">
                                        {{$persona['nombres']}}{{" "}}{{$persona['apellidos']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="preciohabitacion">{{'Precio Habitacion'}}</label>
                                <input class="form-control" readonly value="{{$habitacion['tipohabitacion']['precio']}}"
                                    type="number" name="preciohabitacion" id="preciohabitacion">
                            </div>
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