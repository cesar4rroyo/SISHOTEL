@include('utils.errorDiv', ['entidad' => $formData['entidad']])
@include('utils.formCrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<div class="form-group">
    <label for="login">Usuario</label>
    <input class=" form-control" type="text" name="login" id="login" placeholder="Ingrese nombre de usuario"
        value="{{ isset($formData['model']) ? $formData['model']->login : null }}" required>
</div>
<div class="form-group">
    <label for="password">Contraseña</label>
    <input class=" form-control" type="password" name="password" id="password" placeholder="Ingrese Contraseña"
        value="{{ isset($formData['model']) ? "" : "" }}" required>
</div>
<div class="form-group">
    <label for="tipousuario_id">Tipo Usuario</label>
    <select class="form-control" name="tipousuario_id" id="tipousuario_id">
        @foreach ($formData['cboTipoUsuario'] as $key => $value)
        <option value="{{ $key }}"
            {{ isset($formData['model']) ? ($key == $formData['model']->tipousuario_id ? 'selected' : '') : '' }}>
            {{ $value }}
        </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="persona_id">Persona</label>
    <select class="form-control" name="persona_id" id="persona_id">
        @foreach ($formData['cboPersona'] as $key => $value)
        <option value="{{ $key }}"
            {{ isset($formData['model']) ? ($key == $formData['model']->persona_id ? 'selected' : '') : '' }}>
            {{ $value }}
        </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    @include('utils.modalBtns', ['entidad' => $formData['entidad'], 'boton' => $formData['boton']])
</div>

</form>
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('450');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
    });
</script>
