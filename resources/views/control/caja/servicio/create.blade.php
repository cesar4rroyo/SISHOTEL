@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Caja</div>
            <div class="card-body">
                <div class="btn-gtoup">
                    <a href="{{ route('caja') }}" title="Regresar"><button class="btn btn-primary btn-sm mb-2"><i
                                class="fas fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                </div>
                <div class="container mt-2">
                    <form method="POST" action="{{ route('store_caja_servicio') }}" accept-charset="UTF-8"
                        class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-sm">
                                <label class="control-label" for="fecha">Fecha</label>
                                <input type="datetime-local" id="fecha" class="form-control" name="fecha"
                                    value="{{Carbon\Carbon::now()->format('Y-m-d\TH:i')}}">
                            </div>
                            <div class="form-group col-sm">
                                <label class="control-label" for="numero">Número</label>
                                <input type="number" readonly class="form-control" name="numero" id="numero"
                                    value="{{$numero}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm {{ $errors->has('tipo') ? 'has-error' : ''}}">
                                <label for="tipo" class="control-label">{{ 'Tipo' }}</label>
                                <select required class="form-control" name="tipo" id="tipo">
                                    <option value="">
                                        {{ 'Seleccione una opcion'}}
                                    </option>
                                    <option value="Ingreso">Ingreso</option>
                                    <option value="Egreso">Egreso</option>
                                </select>
                                {!! $errors->first('concepto', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group col-sm {{ $errors->has('concepto') ? 'has-error' : ''}}">
                                <label for="concepto" class="control-label">{{ 'Concepto' }}</label>
                                <select class="form-control" required name="concepto" id="concepto">
                                    <option value="">
                                        {{'Seleccione una opcion'}}
                                    </option>
                                    @foreach ($conceptos as $item)
                                    @if (($item->id)!=1 && ($item->id)!=2)
                                    <option value="{{$item->id}}">
                                        {{$item->nombre}}
                                    </option>
                                    @else
                                    <option hidden value="{{$item->id}}">
                                        {{$item->nombre}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                {!! $errors->first('concepto', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group col-sm">
                                <label class="control-label" for="movimiento">Movimiento Nro:</label>
                                <input type="number" readonly class="form-control" name="movimiento" id="movimiento"
                                    value="{{$id}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm {{ $errors->has('persona') ? 'has-error' : ''}}">
                                <label for="persona" class="control-label">{{ 'Personas' }}</label>
                                <select class="form-control clientes-select2" required name="persona" id="persona">
                                    <option value="">{{'Seleccione una opcion'}}</option>
                                    @foreach ($personas as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->nombres}} {{" "}}{{$item->apellidos}}
                                    </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('persona', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="col-sm form-group">
                                <label for="persona" class="control-label">{{ 'Total' }}</label>
                                <input type="number" readonly class="form-control" name="total" id="total"
                                    value="{{ isset($total) ? $total : ''}}">
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('comentario') ? 'has-error' : ''}}">
                            <label for="comentario" class="control-label">{{ 'Comentario' }}</label>
                            <input class="form-control" name="comentario" type="text" id="comentario" value="">
                            {!! $errors->first('comentario', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="container text-center">
                            <button class="btn btn-outline-success col-sm-6">
                                Registrar Movimiento
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