<div class="form-group {{ $errors->has('login') ? 'has-error' : ''}}">
    <label for="login" class="control-label">{{ 'Login' }}</label>
    <input class="form-control" name="login" type="text" id="login"
        value="{{ isset($usuario->login) ? $usuario->login : ''}}">
    {!! $errors->first('login', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password" class="control-label">{{ 'Password' }}</label>
    <input class="form-control" name="password" type="text" id="password"
        value="{{ isset($usuario->password) ? $usuario->password : ''}}">
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('tipousuario_id') ? 'has-error' : ''}}">
    <label for="tipousuario_id" class="control-label">{{ 'Tipousuario Id' }}</label>
    <input class="form-control" name="tipousuario_id" type="number" id="tipousuario_id"
        value="{{ isset($usuario->tipousuario_id) ? $usuario->tipousuario_id : ''}}">
    {!! $errors->first('tipousuario_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('persona_id') ? 'has-error' : ''}}">
    <label for="persona_id" class="control-label">{{ 'Persona Id' }}</label>
    <input class="form-control" name="persona_id" type="number" id="persona_id"
        value="{{ isset($usuario->persona_id) ? $usuario->persona_id : ''}}">
    {!! $errors->first('persona_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Agregar' }}">
</div>