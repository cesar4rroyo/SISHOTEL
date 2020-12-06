<div class="form-group {{ $errors->has('nombres') ? 'has-error' : ''}}">
    <label for="nombres" class="control-label">{{ 'Nombres' }}</label>
    <input class="form-control" name="nombres" type="text" id="nombres"
        value="{{ isset($persona->nombres) ? $persona->nombres : ''}}">
    {!! $errors->first('nombres', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('apellidos') ? 'has-error' : ''}}">
    <label for="apellidos" class="control-label">{{ 'Apellidos' }}</label>
    <input class="form-control" name="apellidos" type="text" id="apellidos"
        value="{{ isset($persona->apellidos) ? $persona->apellidos : ''}}">
    {!! $errors->first('apellidos', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('razonsocial') ? 'has-error' : ''}}">
    <label for="razonsocial" class="control-label">{{ 'Razonsocial' }}</label>
    <input class="form-control" name="razonsocial" type="text" id="razonsocial"
        value="{{ isset($persona->razonsocial) ? $persona->razonsocial : ''}}">
    {!! $errors->first('razonsocial', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('ruc') ? 'has-error' : ''}}">
    <label for="ruc" class="control-label">{{ 'Ruc' }}</label>
    <input class="form-control" name="ruc" type="text" id="ruc" value="{{ isset($persona->ruc) ? $persona->ruc : ''}}">
    {!! $errors->first('ruc', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('dni') ? 'has-error' : ''}}">
    <label for="dni" class="control-label">{{ 'Dni' }}</label>
    <input class="form-control" name="dni" type="text" id="dni" value="{{ isset($persona->dni) ? $persona->dni : ''}}">
    {!! $errors->first('dni', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('direccion') ? 'has-error' : ''}}">
    <label for="direccion" class="control-label">{{ 'Direccion' }}</label>
    <input class="form-control" name="direccion" type="text" id="direccion"
        value="{{ isset($persona->direccion) ? $persona->direccion : ''}}">
    {!! $errors->first('direccion', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('sexo') ? 'has-error' : ''}}">
    <label for="sexo" class="control-label">{{ 'Sexo' }}</label>
    <select name="sexo" class="form-control" id="sexo">
        @foreach (json_decode('{femenino:Femenino,masculino:Masculino}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($persona->sexo) && $persona->sexo == $optionKey) ? 'selected' : ''}}>
            {{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('sexo', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('fechanacimiento') ? 'has-error' : ''}}">
    <label for="fechanacimiento" class="control-label">{{ 'Fechanacimiento' }}</label>
    <input class="form-control" name="fechanacimiento" type="date" id="fechanacimiento"
        value="{{ isset($persona->fechanacimiento) ? $persona->fechanacimiento : ''}}">
    {!! $errors->first('fechanacimiento', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('telefono') ? 'has-error' : ''}}">
    <label for="telefono" class="control-label">{{ 'Telefono' }}</label>
    <input class="form-control" name="telefono" type="number" id="telefono"
        value="{{ isset($persona->telefono) ? $persona->telefono : ''}}">
    {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('observacion') ? 'has-error' : ''}}">
    <label for="observacion" class="control-label">{{ 'Observacion' }}</label>
    <input class="form-control" name="observacion" type="text" id="observacion"
        value="{{ isset($persona->observacion) ? $persona->observacion : ''}}">
    {!! $errors->first('observacion', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('nacionalidad_id') ? 'has-error' : ''}}">
    <label for="nacionalidad_id" class="control-label">{{ 'Nacionalidad Id' }}</label>
    <select name="nacionalidad_id" class="form-control" id="nacionalidad_id">
        @foreach (json_decode('option={1:1}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}"
            {{ (isset($persona->nacionalidad_id) && $persona->nacionalidad_id == $optionKey) ? 'selected' : ''}}>
            {{ $optionValue }}</option>
        @endforeach
    </select>
    {!! $errors->first('nacionalidad_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>