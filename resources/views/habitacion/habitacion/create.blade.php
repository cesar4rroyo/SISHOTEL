@include('utils.errorDiv', ['entidad' => $formData['entidad']])
@include('utils.formCrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<div class="row">
    <div class="form-group col-sm">
        <label for="numero">Número</label>
        <input class=" form-control" type="number" name="numero" id="numero" placeholder="Ingrese número"
            value="{{ isset($formData['model']) ? $formData['model']->numero : null }}" required>
    </div>
    <div class="form-group col-sm">
        <label for="situacion">Situación</label>
        <input class="form-control" type="text" id="situacion" name="situacion"
            value="{{ isset($formData['model']) ? $formData['model']->situacion : 'Disponible' }}" readonly>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm">
        <label for="piso">Piso</label>
        <select name="piso_id" id="piso" class=" form-control" required>
            @foreach ($formData['cboPisos'] as $key => $value)
                @if (isset($formData['model']) && $formData['model']->piso_id == $key)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm">
        <label for="tipohabitacion">Tipo de Habitación</label>
        <select name="tipohabitacion_id" id="tipohabitacion" class=" form-control" required>
            @foreach ($formData['cboTiposHabitacion'] as $key => $value)
                @if (isset($formData['model']) && $formData['model']->tipohabitacion_id == $key)
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
