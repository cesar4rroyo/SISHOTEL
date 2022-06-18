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
        <label for="fechaingreso">Fecha de Entrada</label>
        <input class="form-control" type="datetime-local" name="fechaingreso" id="fechaingreso"
            value="{{ isset($formData['model']) ? $formData['model']->fechaingreso : date('Y-m-d\TH:i', strtotime($formData['startDate'])) }}"
            readonly required>
    </div>
    <div class="form-group col-sm">
        <label for="fechasalida">Fecha de Posible Salida</label>
        <input class="form-control" type="datetime-local" name="fechasalida" id="fechasalida"
            value="{{ isset($formData['model']) ? $formData['model']->fechasalida : date('Y-m-d\TH:i', strtotime($formData['endDate'])) }}"
            required>
    </div>
</div>
<div class="form-group">
    <label for="nombre">Huésped Principal</label>
    <input class=" form-control" type="text" name="nombre" id="nombre" placeholder="Ingrese nombre"
        value="{{ isset($formData['model']) ? $formData['model']->nombre : null }}" required>
</div>
<div class="custom-control custom-checkbox form-group">
    <input type="checkbox" class="custom-control-input" id="cobroAdelantado" onchange="toggleDivCheckBox('cobroAdelantado', 'divFacturacion');">
    <label class="custom-control-label" for="cobroAdelantado">Cobrar adelantado</label>
</div>

@include('principal.facturacion', ['cboDocumentos' => $formData['cboDocumentos'], 'ruta' => $formData['rutaTipoDoc']])

<div class="form-group">
    @include('utils.modalBtns', ['entidad' => $formData['entidad'], 'boton' => $formData['boton']])
</div>

</form>
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('900');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
        toggleDivCheckBox('cobroAdelantado', 'divFacturacion');
        handleChangeTipoDocumento('tipo', '{{URL::route($formData['rutaTipoDoc'])}}', 'numero');
    });
</script>
