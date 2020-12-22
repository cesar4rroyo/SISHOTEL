<div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error' : ''}}">
    <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
    <input class="form-control" name="nombre" type="text" id="nombre"
        value="{{ isset($categoria->nombre) ? $categoria->nombre : ''}}">
    {!! $errors->first('nombre', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group col-sm-6">
    <input class="btn btn-outline-success" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
</div>