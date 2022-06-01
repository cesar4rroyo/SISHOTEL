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
        <label for="icono">Icono</label>
        <input class=" form-control" type="text" name="icono" id="icono" placeholder="Ingrese icono"
            value="{{ isset($formData['model']) ? $formData['model']->icono : 'fas fa-list-ol' }}">
   </div>
   <div class="col-sm form-group">
    <label for="orden">Orden</label>
    <input class=" form-control" type="text" name="orden" id="orden" placeholder="Ingrese orden"
        value="{{ isset($formData['model']) ? $formData['model']->orden : 1 }}">
   </div>
        
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
