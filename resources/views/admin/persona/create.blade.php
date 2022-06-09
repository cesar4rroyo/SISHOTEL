@include('utils.errorDiv', ['entidad' => $formData['entidad']])
@include('utils.formCrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<div class="form-group">
    <label for="documento">Nro. Documento:</label>
    <span onclick="BuscarNroDocumento();" class=" badge badge-warning">
        Buscar <i class="fas fa-search"></i>
    </span>
    <input class=" form-control" type="text" name="documento" id="documento" placeholder="Ingrese Nro. RUC o DNI"
        value="{{ isset($formData['model']) ? $formData['model']->getFullDocumentAllAttribute() : null }}" required>
</div>
<div class="form-group">
    <label for="nombres">Nombres:</label>
    <input class="form-control" type="text" name="nombres" id="nombres" placeholder="Ingrese Nombres o Razon Social"
        value="{{ isset($formData['model']) ? $formData['model']->getFullNameAllAttribute() : null }}" required>
</div>
<div class="form-group">
    <label for="direccion">Dirección:</label>
    <input class="form-control" type="text" name="direccion" id="direccion" placeholder="Ingrese una dirección"
        value="{{ isset($formData['model']) ? $formData['model']->direccion : null }}">
</div>
<div class="row">
    <div class="form-group col-sm">
        <label for="telefono">Nro. Celular:</label>
        <input class="form-control" type="number" name="telefono" id="telefono"
            placeholder="Ingrese un numero de celular"
            value="{{ isset($formData['model']) ? $formData['model']->telefono : null }}" autocomplete="off">
    </div>
    <div class="form-group col-sm">
        <label for="email">Email</label>
        <input class="form-control" type="email" name="email" id="email" placeholder="Ingrese un email"
            value="{{ isset($formData['model']) ? $formData['model']->email : null }}">
    </div>
</div>
<div class="form-group">
    @include('utils.modalBtns', ['entidad' => $formData['entidad'], 'boton' => $formData['boton']])
</div>

</form>
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('600');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
    });
</script>
