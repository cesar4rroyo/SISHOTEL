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
                    <form action="{{route('checkout', $movimiento['id'])}}" method="POST">
                        @csrf
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

                            </div>
                            <div class="col-sm form-group">
                                <label class="control-label" for="preciohabitacion">{{'Precio Habitacion'}}</label>
                                <input readonly class="form-control" value="{{$habitacion['tipohabitacion']['precio']}}"
                                    type="number" name="preciohabitacion" id="preciohabitacion">
                            </div>
                        </div>
                        {{-- {{dd($movimiento['detallemovimiento'])}} --}}
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
                                        <?php $total = $habitacion['tipohabitacion']['precio'] ?>
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
                                <input type="number" class="form-control" name="dias" id="dias">
                            </div>
                            <div class="col-sm form-group">

                                <label class="control-label" for="total">{{'Total'}}</label>
                                <input class="form-control" readonly value="{{$total}}" type="number" name="total"
                                    id="total">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label class="control-label" for="numero">Número</label>
                                <input type="number" class="form-control" name="numero" id="numero" value="">
                            </div>
                            <div class="form-group col-sm {{ $errors->has('concepto') ? 'has-error' : ''}}">
                                <label for="concepto" class="control-label">{{ 'Concepto' }}</label>
                                <select class="form-control" required name="concepto" id="concepto">
                                    <option value="">
                                        {{'Seleccione una opcion'}}
                                    </option>
                                    @foreach ($conceptos as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('concepto', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group col-sm {{ $errors->has('tipo') ? 'has-error' : ''}}">
                                <label for="tipo" class="control-label">{{ 'Tipo' }}</label>
                                <select required class="form-control" name="tipo" id="tipo">
                                    <option value="">
                                        {{ 'Seleccione una opcion'}}
                                    </option>
                                    <option value="Ingreso">Ingreso</option>
                                    <option value="Egreso">Egreso</option>
                                </select>
                                {!! $errors->first('tipo', '<p class="text-danger">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('comentario') ? 'has-error' : ''}}">
                            <label for="comentario" class="control-label">{{ 'Comentario' }}</label>
                            <input class="form-control" name="comentario" type="text" id="comentario" value="">
                            {!! $errors->first('comentario', '<p class="text-danger">:message</p>') !!}
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