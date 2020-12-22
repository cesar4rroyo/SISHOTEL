<div class="row">
    <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error' : ''}}">
        <label for="nombre" class="control-label">{{ 'Nombre' }}</label>
        <input class="form-control" name="nombre" type="text" id="nombre"
            value="{{ isset($opcionmenu->nombre) ? $opcionmenu->nombre : ''}}">
        {!! $errors->first('nombre', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm-6 {{ $errors->has('link') ? 'has-error' : ''}}">
        <label for="link" class="control-label">{{ 'Link' }}</label>
        <input class="form-control" name="link" type="text" id="link"
            value="{{ isset($opcionmenu->link) ? $opcionmenu->link : ''}}">
        {!! $errors->first('link', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4 {{ $errors->has('icono') ? 'has-error' : ''}}">
        <label for="icono" class="control-label">{{ 'Icono' }}</label>
        <input class="form-control" name="icono" type="text" id="icono"
            value="{{ isset($opcionmenu->icono) ? $opcionmenu->icono : ''}}">
        {!! $errors->first('icono', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm-4 {{ $errors->has('orden') ? 'has-error' : ''}}">
        <label for="orden" class="control-label">{{ 'Orden' }}</label>
        <input class="form-control" name="orden" type="number" id="orden"
            value="{{ isset($opcionmenu->orden) ? $opcionmenu->orden : ''}}">
        {!! $errors->first('orden', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm-4 {{ $errors->has('grupomenu_id') ? 'has-error' : ''}}">
        <label for="grupomenu_id" class="control-label">{{ 'Grupo Menu' }}</label>
        <select class="form-control" name="grupomenu_id" id="grupomenu_id">
            <option value="{{ isset($opcionmenu->grupomenu) ? $opcionmenu->grupomenu->id : ''}}">
                {{ isset($opcionmenu->grupomenu->nombre) ? $opcionmenu->grupomenu->nombre : 'Seleccione una opcion'}}
            </option>
            @foreach ($grupomenu as $item)
            <option value="{{$item->id}}">
                {{$item->nombre}}
            </option>
            @endforeach
        </select>
        {!! $errors->first('grupomenu_id', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <input class="btn btn-outline-success" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
</div>