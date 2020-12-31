<div class="row">
    <div class="form-group col-sm {{ $errors->has('nombres') ? 'has-error' : ''}}">
        <label for="nombres" class="control-label">{{ 'Nombres' }}</label>
        <input class="form-control" required name="nombres" type="text" id="nombres"
            value="{{ isset($persona->nombres) ? $persona->nombres : ''}}">
        {!! $errors->first('nombres', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('apellidos') ? 'has-error' : ''}}">
        <label for="apellidos" class="control-label">{{ 'Apellidos' }}</label>
        <input class="form-control" required name="apellidos" type="text" id="apellidos"
            value="{{ isset($persona->apellidos) ? $persona->apellidos : ''}}">
        {!! $errors->first('apellidos', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('rol') ? 'has-er ror' : ''}}">
        <label for="rol_id[]" class="control-label">{{ 'Roles' }}</label>
        <select class="form-control select2" required id="rol_id[]" name="rol_id[]" multiple="multiple"
            data-placeholder="Seleccionar rol" style="width: 100%;">
            @foreach ($roles as $id => $nombre)
            <option value="{{$id}}"
                {{is_array(old('rol_id')) ? (in_array($id, old('rol_id')) ? 'selected' : '')  : (isset($persona) ? ($persona->roles->firstWhere('id', $id) ? 'selected' : '') : '')}}>
                {{$nombre}}</option>
            @endforeach
        </select>
        {{-- <input class="form-control" name="rol" type="text" id="rol"
            value="{{ isset($persona->rol) ? $persona->rol->nombre : ''}}"> --}}
        {!! $errors->first('apellidos', '<p class="text-danger">:message</p>') !!}
    </div>

</div>
<div class="row">
    <div class="form-group col-sm {{ $errors->has('razonsocial') ? 'has-error' : ''}}">
        <label for="razonsocial" class="control-label">{{ 'Razón Social' }}</label>
        <input class="form-control" name="razonsocial" type="text" id="razonsocial"
            value="{{ isset($persona->razonsocial) ? $persona->razonsocial : ''}}">
        {!! $errors->first('razonsocial', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('ruc') ? 'has-error' : ''}}">
        <label for="ruc" class="control-label">{{ 'RUC' }}</label>
        <input class="form-control" name="ruc" type="text" id="ruc"
            value="{{ isset($persona->ruc) ? $persona->ruc : ''}}">
        {!! $errors->first('ruc', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('dni') ? 'has-error' : ''}}">
        <label for="dni" class="control-label">{{ 'DNI' }}</label>
        <input class="form-control" name="dni" type="text" id="dni"
            value="{{ isset($persona->dni) ? $persona->dni : ''}}">
        {!! $errors->first('dni', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm {{ $errors->has('sexo') ? 'has-error' : ''}}">
        <label for="sexo" class="control-label">{{ 'Sexo' }}</label>
        <select name="sexo" required class="form-control" id="sexo">
            <option value="">Seleccione una opcion</option>
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
        </select>
        {!! $errors->first('sexo', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('fechanacimiento') ? 'has-error' : ''}}">
        <label for="fechanacimiento" class="control-label">{{ 'Fecha de nacimiento' }}</label>
        <input class="form-control" required name="fechanacimiento" type="date" id="fechanacimiento"
            value="{{ isset($persona->fechanacimiento) ? $persona->fechanacimiento : ''}}">
        {!! $errors->first('fechanacimiento', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('telefono') ? 'has-error' : ''}}">
        <label for="telefono" class="control-label">{{ 'Teléfono' }}</label>
        <input class="form-control" name="telefono" type="text" id="telefono"
            value="{{ isset($persona->telefono) ? $persona->telefono : ''}}">
        {!! $errors->first('telefono', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm {{ $errors->has('nacionalidad_id') ? 'has-error' : ''}}">
        <label for="nacionalidad_id" class="control-label">{{ 'Nacionalidad' }}</label>
        <select name="nacionalidad_id" class="form-control" id="nacionalidad_id">
            <option value="{{ isset($persona->nacionalidad->nombre) ? $persona->nacionalidad->id : ''}}">
                {{ isset($persona->nacionalidad->nombre) ? $persona->nacionalidad->nombre : 'Seleccione una opcion'}}
            </option>
            @foreach ($nacionalidades as $item)
            <option value="{{$item->id}}">
                {{$item->nombre}}
            </option>
            @endforeach
        </select>
        {!! $errors->first('nacionalidad_id', '<p class="text-danger">:message</p>') !!}
    </div>
    <div class="form-group col-sm {{ $errors->has('direccion') ? 'has-error' : ''}}">
        <label for="direccion" class="control-label">{{ 'Dirección' }}</label>
        <input class="form-control" name="direccion" type="text" id="direccion"
            value="{{ isset($persona->direccion) ? $persona->direccion : ''}}">
        {!! $errors->first('direccion', '<p class="text-danger">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('observacion') ? 'has-error' : ''}}">
    <label for="observacion" class="control-label">{{ 'Observacion' }}</label>
    <input class="form-control" name="observacion" type="text" id="observacion"
        value="{{ isset($persona->observacion) ? $persona->observacion : ''}}">
    {!! $errors->first('observacion', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-outline-success" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>