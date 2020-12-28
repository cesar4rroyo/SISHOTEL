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
                <div class="container">
                    <form method="POST" action="{{route('store_movimiento')}}">
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
                            {{-- <div class="col-sm form-group">
                                <label class="control-label" for="fechasalida">{{'Fecha Salida'}}</label>
                            <input class="form-control" id="fechasalida" name="fechasalida" type="datetime-local">
                        </div> --}}
                </div>
                <div class="row">
                    <div class="col-sm form-group">
                        <label class="control-label" for="persona">{{'Cliente'}}</label>
                        <select class="form-control" name="persona" id="persona">
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