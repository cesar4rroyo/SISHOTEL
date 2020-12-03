<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
    <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
    <input class="form-control" name="nombre" type="text" id="nombre"
        value="{{ isset($grupomenu->nombre) ? $grupomenu->nombre : ''}}">
    {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('icono') ? 'has-error' : ''}}">
    <label for="icono" class="control-label">{{ 'Icono' }}</label>
    <input class="form-control" name="icono" type="text" id="icono"
        value="{{ isset($grupomenu->icono) ? $grupomenu->icono : ''}}">
    {!! $errors->first('icono', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('orden') ? 'has-error' : ''}}">
    <label for="orden" class="control-label">{{ 'Orden' }}</label>
    <input class="form-control" name="orden" type="number" id="orden"
        value="{{ isset($grupomenu->orden) ? $grupomenu->orden : ''}}">
    {!! $errors->first('orden', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>