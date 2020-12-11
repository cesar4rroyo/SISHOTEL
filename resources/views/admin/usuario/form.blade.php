<div class="form-group {{ $errors->has('login') ? 'has-error' : ''}}">
    <label for="login" class="control-label">{{ 'Login' }}</label>
    <input class="form-control" name="login" type="text" id="login"
        value="{{ isset($usuario->login) ? $usuario->login : ''}}">
    {!! $errors->first('login', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password" class="control-label">{{ 'Password' }}</label>
    <input class="form-control" name="password" type="password" id="password"
        value="{{ isset($usuario->password) ? $usuario->password : ''}}">
    {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('tipousuario') ? 'has-error' : ''}}">
    <label for="tipousuario" class="control-label">{{ 'Tipo Usuario' }}</label>
    <select class="form-control" name="tipousuario" id="tipousuario">
        <option value="{{ isset($usuario->tipousuario->nombre) ? $usuario->tipousuario->id : ''}}">
            {{ isset($usuario->tipousuario->nombre) ? $usuario->tipousuario->nombre : 'Seleccione una opcion'}}
        </option>
        @foreach ($tipousuarios as $item)
        <option value="{{$item->id}}">
            {{$item->nombre}}
        </option>
        @endforeach
    </select>
    {{-- <input class="form-control" name="tipousuario_id" type="number" id="tipousuario_id"
        value="{{ isset($usuario->tipousuario_id) ? $usuario->tipousuario_id : ''}}"> --}}
    {!! $errors->first('tipousuario', '<p class="text-danger">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('persona') ? 'has-error' : ''}}">
    <label for="persona" class="control-label">{{ 'Persona' }}</label>
    <select class="form-control" name="persona" id="persona">
        <option value="{{ isset($usuario->persona->nombre) ? $usuario->persona->id : ''}}">
            {{ isset($usuario->persona->nombres) ? $usuario->persona->nombres : 'Seleccione una opcion'}}
        </option>
        @foreach ($personas as $item)
        <option value="{{$item->id}}">
            {{$item->nombres}}
        </option>
        @endforeach
    </select>
    {{-- <input class="form-control" name="persona" type="number" id="persona"
        value="{{ isset($usuario->persona) ? $usuario->persona : ''}}"> --}}
    {!! $errors->first('persona', '<p class="text-danger">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
</div>