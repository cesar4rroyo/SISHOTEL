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
                    <form action="">
                        <div class="row">
                            <div class="col-sm form-group">
                                <label for="habitacion">{{'Habitacion'}}</label>
                                <input class="form-control" type="text" name="habitacion" disabled
                                    value="{{$habitacion['numero']}}">
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
                                {{-- <select class="form-control" name="persona" id="persona">
                                    <option value="">Seleccione Uno</option>
                                    @foreach ($personas as $persona)
                                    <option value="{{$persona['id']}}">
                                {{$persona['nombres']}}{{" "}}{{$persona['apellidos']}}</option>
                                @endforeach
                                </select> --}}
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="preciohabitacion">{{'Precio Habitacion'}}</label>
                                <input class="form-control" value="{{$habitacion['tipohabitacion']['precio']}}"
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
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Comentario</th>
                                            <th>Servicio/Producto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($reservas as $item) --}}
                                        <tr>
                                            <td>{{'09-29-12 '}}</td>
                                            <td>
                                                {{'S/. 15.00' }}
                                            </td>
                                            <td>
                                                {{ '1' }}
                                            </td>
                                            <td>
                                                {{'-'}}
                                            </td>
                                            <td>
                                                {{ 'Gaseosa'}}
                                            </td>
                                        </tr>
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-sm form-group">
                                <label class="control-label" for="dias">{{'Dias'}}</label>
                                <input type="number" class="form-control" name="dias" id="dias">
                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="total">{{'Total'}}</label>
                                <input class="form-control" type="number" name="total" id="total">
                            </div>
                        </div>
                        <div class="container text-center">
                            <button class="btn btn-outline-success col-sm-6">
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