<div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
    <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
    <input class="form-control" name="nombre" type="text" id="nombre"
        value="{{ isset($producto->nombre) ? $producto->nombre : ''}}">
    {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('precioventa') ? 'has-error' : ''}}">
    <label for="precioventa" class="control-label">{{ 'Precio Venta' }}</label>
    <input class="form-control" name="precioventa" type="number" id="precioventa"
        value="{{ isset($producto->precioventa) ? $producto->precioventa : ''}}">
    {!! $errors->first('precioventa', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('preciocompra') ? 'has-error' : ''}}">
    <label for="preciocompra" class="control-label">{{ 'Precio Compra' }}</label>
    <input class="form-control" name="preciocompra" type="number" id="preciocompra"
        value="{{ isset($producto->preciocompra) ? $producto->preciocompra : ''}}">
    {!! $errors->first('preciocompra', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('categoria') ? 'has-error' : ''}}">
    <label for="categoria_id" class="control-label">{{ 'Categoria' }}</label>
    <select class="form-control" name="categoria_id" id="categoria_id">
        <option value="{{ isset($producto->categoria->nombre) ? $producto->categoria->id : ''}}">
            {{ isset($producto->categoria->nombre) ? $producto->categoria->nombre : 'Seleccione una opcion'}}
        </option>
        @foreach ($categorias as $item)
        <option value="{{$item->id}}">
            {{$item->nombre}}
        </option>
        @endforeach
    </select>
    {{-- <label for="categoria" class="control-label">{{ 'Categoria' }}</label>
    <input class="form-control" name="categoria" type="number" id="categoria"
        value="{{ isset($producto->categoria) ? $producto->categoria : ''}}"> --}}
    {!! $errors->first('categoria', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('unidad') ? 'has-error' : ''}}">
    <label for="unidad_id" class="control-label">{{ 'Unidad' }}</label>
    <select class="form-control" name="unidad_id" id="unidad_id">
        <option value="{{ isset($producto->unidad->nombre) ? $producto->unidad->id : ''}}">
            {{ isset($producto->unidad->nombre) ? $producto->unidad->nombre : 'Seleccione una opcion'}}
        </option>
        @foreach ($unidades as $item)
        <option value="{{$item->id}}">
            {{$item->nombre}}
        </option>
        @endforeach
    </select>
    {{-- <label for="unidad" class="control-label">{{ 'Unidad' }}</label>
    <input class="form-control" name="unidad" type="number" id="unidad"
        value="{{ isset($producto->unidad) ? $producto->unidad : ''}}"> --}}
    {!! $errors->first('unidad', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
</div>