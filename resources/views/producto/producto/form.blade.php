<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
    <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
    <input class="form-control" name="nombre" type="text" id="nombre" value="{{ isset($producto->nombre) ? $producto->nombre : ''}}" >
    {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('precioventa') ? 'has-error' : ''}}">
    <label for="precioventa" class="control-label">{{ 'Precioventa' }}</label>
    <input class="form-control" name="precioventa" type="number" id="precioventa" value="{{ isset($producto->precioventa) ? $producto->precioventa : ''}}" >
    {!! $errors->first('precioventa', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('preciocompra') ? 'has-error' : ''}}">
    <label for="preciocompra" class="control-label">{{ 'Preciocompra' }}</label>
    <input class="form-control" name="preciocompra" type="number" id="preciocompra" value="{{ isset($producto->preciocompra) ? $producto->preciocompra : ''}}" >
    {!! $errors->first('preciocompra', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('categoria') ? 'has-error' : ''}}">
    <label for="categoria" class="control-label">{{ 'Categoria' }}</label>
    <input class="form-control" name="categoria" type="number" id="categoria" value="{{ isset($producto->categoria) ? $producto->categoria : ''}}" >
    {!! $errors->first('categoria', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('unidad') ? 'has-error' : ''}}">
    <label for="unidad" class="control-label">{{ 'Unidad' }}</label>
    <input class="form-control" name="unidad" type="number" id="unidad" value="{{ isset($producto->unidad) ? $producto->unidad : ''}}" >
    {!! $errors->first('unidad', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
