@include('utils.errorDiv', ['entidad' => $formData['entidad']])
@include('utils.formCrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input class=" form-control" type="text" name="nombre" id="nombre" placeholder="Ingrese nombre"
        value="{{ isset($formData['model']) ? $formData['model']->nombre : null }}" required>
</div>
<div class="row">
    <div class="col-sm form-group">
        <label for="capacidad">Capacidad</label>
        <input class=" form-control" type="number" name="capacidad" id="capacidad" placeholder="Ingrese capacidad"
            value="{{ isset($formData['model']) ? $formData['model']->capacidad : null }}">
    </div>
    <div class="col-sm form-group">
        <label for="precio">Precio</label>
        <input class=" form-control" type="number" step="0.01" name="precio" id="precio" placeholder="Ingrese precio"
            value="{{ isset($formData['model']) ? $formData['model']->precio : null }}" required>
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
