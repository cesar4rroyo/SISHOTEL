<div class="row">
    <div class="form-group col-sm {{ $errors->has('nombre') ? 'has-error' : ''}}">
        <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
        <input class="form-control" name="nombre" type="text" id="nombre"
            value="{{ isset($concepto->nombre) ? $concepto->nombre : ''}}">
        {!! $errors->first('nombre', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('tipo') ? 'has-error' : ''}}">
        <label for="tipo" class="control-label">{{ 'Tipo' }}</label>
        <select class="form-control" name="tipo" type="text" id="tipo">
            <option value="{{ isset($concepto->tipo) ? $concepto->tipo : ''}}">
                {{ isset($concepto->tipo) ? $concepto->tipo : 'Seleccione una opcion'}}
            </option>
            @if (isset($concepto->tipo) && $concepto->tipo='Ingreso')
            <option value="{{"Egreso"}}">{{'Egreso'}}</option>
            @else
            <option value="{{"Ingreso"}}">{{'Ingreso'}}</option>
            <option value="{{"Egreso"}}">{{'Egreso'}}</option>
            @endif

        </select>
        {!! $errors->first('tipo', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <input class="btn btn-outline-success" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
</div>