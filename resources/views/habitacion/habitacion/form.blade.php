<div class="row">
    <div class="form-group col-sm {{ $errors->has('numero') ? 'has-error' : ''}}">
        <label for="numero" class="control-label">{{ 'Numero' }}</label>
        <input class="form-control" name="numero" type="number" id="numero"
            value="{{ isset($habitacion->numero) ? $habitacion->numero : ''}}">
        {!! $errors->first('numero', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('piso') ? 'has-error' : ''}}">
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
        {!! $errors->first('piso', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('tipohabitacion') ? 'has-error' : ''}}">
        <label for="tipohabitacion_id" class="control-label">{{ 'Tipo Habitación' }}</label>
        <select class="form-control" name="tipohabitacion_id" id="tipohabitacion_id">
            <option value="{{ isset($habitacion->tipohabitacion->nombre) ? $habitacion->tipohabitacion->id : ''}}">
                {{ isset($habitacion->tipohabitacion->nombre) ? $habitacion->tipohabitacion->nombre : 'Seleccione una opcion'}}
            </option>
            @foreach ($tipohabitaciones as $tipo)
            <option value="{{$tipo->id}}">
                {{$tipo->nombre}}
            </option>
            @endforeach
        </select>
        {!! $errors->first('tipohabitacion', '<p class="text-danger">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('situacion') ? 'has-error' : ''}}">
    <label for="situacion" class="control-label">{{ 'Situacion' }}</label>
    <select class="form-control" name="situacion" id="situacion">
        <option value="{{ isset($habitacion->situacion) ? $habitacion->situacion: ''}}">
            {{ isset($habitacion->situacion) ? $habitacion->situacion : 'Seleccione una opcion'}}
        </option>
        <option value="{{"Ocupada"}}">{{'Ocupado'}}</option>
        <option value="{{"Disponible"}}">{{'Disponible'}}</option>
        <option value="{{"Limpieza"}}">{{'En limpieza'}}</option>

    </select>
    {{-- <input class="form-control" name="situacion" type="text" id="situacion"
        value="{{ isset($habitacion->situacion) ? $habitacion->situacion : ''}}"> --}}
    {!! $errors->first('situacion', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group">
    <input class="btn btn-outline-success" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
</div>