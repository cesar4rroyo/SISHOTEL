@extends("theme.$theme.layout")

@section('content')
{{dd($habitaciones)}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold">Reservas</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('reserva') }}" accept-charset="UTF-8" class="my-2 my-lg-0"
                        role="fecha">
                        <div class="input-group">
                            <input class="form-control" id="fecha" name="fecha" placeholder="Nueva Reserva" type="date">
                        </div>
                        <button class="btn btn-outline-success mt-3 ">Buscar</button>
                    </form>
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Reservar</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="">
                                        @csrf
                                        <div class="form-group">
                                            <label for="txtFecha" class="control-label">{{'Fecha'}}</label>
                                            <input class="form-control" type="date" name="txtFecha" id="txtFecha">
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm">
                                                <label for="persona" class="control-label">{{ 'Cliente' }}</label>
                                                <select name="persona" class="form-control" id="persona">
                                                    <option value="">Seleccione una opcion</option>
                                                    @foreach ($clientes as $cliente)
                                                    <option value="{{$cliente['id']}}">
                                                        {{$cliente['nombres'] }} {{$cliente['apellidos']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm">
                                                <label for="habitacion"
                                                    class="control-label">{{ 'Habitaciones Disponibles' }}</label>
                                                <select name="habitacion" class="form-control" id="habitacion">
                                                    <option value="">Seleccione una opcion</option>
                                                    @foreach ($habitaciones as $habitacion)
                                                    @if (count($habitacion['reserva'])==0)
                                                    <option value="{{$habitacion['id']}}">Habitacion Nro.
                                                        {{$habitacion['numero']}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="observacion" class="control-label">{{ 'Observacion' }}</label>
                                            <textarea name="observacion" class="form-control" id="observacion" cols="30"
                                                rows="5"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" id="btnCerrarModal" class="btn btn-default"
                                        data-dismiss="modal">Cerrar</button>
                                    <button type="button" id="btnAgregar" class="btn btn-primary">Hacer Reserva</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    @include('fullcalendar.index', ['fecha'=>$initialDate])
                </div>

            </div>
        </div>
    </div>
</div>
@endsection