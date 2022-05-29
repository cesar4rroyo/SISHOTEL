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
    <div class="form-group col-sm">
        <label for="precioventa">Precio Venta</label>
        <input class="form-control" type="number" step="0.01" id="precioventa" name="precioventa"
            value="{{ isset($formData['model']) ? $formData['model']->precioventa : null }}" required>
    </div>
    <div class="form-group col-sm">
        <label for="preciocompra">Precio Compra</label>
        <input class="form-control" type="number" step="0.01" id="preciocompra" name="preciocompra"
            value="{{ isset($formData['model']) ? $formData['model']->preciocompra : null }}">
    </div>
</div>
<div class="row">
    <div class="form-group col-sm">
        <label for="categoria">Categoría</label>
        <select name="categoria_id" id="categoria" class=" form-control" required>
            @foreach ($formData['cboCategorias'] as $key => $value)
                @if (isset($formData['model']) && $formData['model']->categoria_id == $key)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm">
        <label for="unidad">Unidad</label>
        <select name="unidad_id" id="unidad" class=" form-control">
            @foreach ($formData['cboUnidades'] as $key => $value)
                @if (isset($formData['model']) && $formData['model']->unidad_id == $key)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
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
