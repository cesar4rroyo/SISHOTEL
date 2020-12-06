<div class="form-group {{ $errors->has('numero') ? 'has-error' : ''}}">
    <label for="numero" class="control-label">{{ 'Numero' }}</label>
    <input class="form-control" name="numero" type="number" id="numero"
        value="{{ isset($habitacion->numero) ? $habitacion->numero : ''}}">
    {!! $errors->first('numero', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('situacion') ? 'has-error' : ''}}">
    <label for="situacion" class="control-label">{{ 'Situacion' }}</label>
    <input class="form-control" name="situacion" type="text" id="situacion"
        value="{{ isset($habitacion->situacion) ? $habitacion->situacion : ''}}">
    {!! $errors->first('situacion', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('piso') ? 'has-error' : ''}}">
    <label for="piso_id" class="control-label">{{ 'Piso' }}</label>
    <select class="form-control" name="piso_id" id="piso_id">
        <option value="{{ isset($habitacion->piso->nombre) ? $habitacion->piso->id : ''}}">
            {{ isset($habitacion->piso->nombre) ? $habitacion->piso->nombre : 'Seleccione una opcion'}}
        </option>
        @foreach ($pisos as $item)
        <option value="{{$item->id}}">
            {{$item->nombre}}
        </option>
        @endforeach
    </select>
    {{-- <input class="form-control" name="piso" type="number" id="piso"
        value="{{ isset($habitacion->piso) ? $habitacion->piso : ''}}"> --}}
    {!! $errors->first('piso', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('tipohabitacion') ? 'has-error' : ''}}">
    <label for="tipohabitacion_id" class="control-label">{{ 'Tipohabitacion' }}</label>
    <select class="form-control" name="tipohabitacion_id" id="tipohabitacion_id">
        <option value="{{ isset($habitacion->tipohabitacion->nombre) ? $habitacion->tipohabitacion->id : ''}}">
            {{ isset($habitacion->tipohabitacion->nombre) ? $habitacion->tipohabitacion->nombre : 'Seleccione una opcion'}}
        </option>
        @foreach ($tipohabitaciones as $item)
        <option value="{{$item->id}}">
            {{$item->nombre}}
        </option>
        @endforeach
    </select>
    {{-- <input class="form-control" name="tipohabitacion" type="number" id="tipohabitacion"
        value="{{ isset($habitacion->tipohabitacion) ? $habitacion->tipohabitacion->nombre : ''}}"> --}}
    {!! $errors->first('tipohabitacion', '<p class="text-danger">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
</div>