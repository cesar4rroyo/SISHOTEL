@include('utils.errorDiv', ['entidad' => $formData['entidad']])
@include('utils.formCrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<div class="row">
    <div class="form-group col-3">
        <label for="fechaingreso">Fecha de Entrada</label>
        <input class="form-control" type="datetime-local" name="fechaingreso" id="fechaingreso"
            value="{{ isset($formData['model']) ? $formData['model']->fechaingreso : date('Y-m-d\TH:i', strtotime($formData['startDate'])) }}"
            readonly required>
    </div>
    <div class="form-group col-3">
        <label for="fechasalida">Fecha de Posible Salida</label>
        <input class="form-control" type="datetime-local" name="fechasalida" id="fechasalida"
            value="{{ isset($formData['model']) ? $formData['model']->fechasalida : date('Y-m-d\TH:i', strtotime($formData['endDate'])) }}"
            required>
    </div>
    <div class="form-group col-sm">
        <label for="nombre">Huésped Principal</label>
        <span class="badge badge-secondary"
            onclick="modal('{{ URL::route($formData['addPersona'], ['from' => 'MODAL']) }}', 'Agregar Huesped', this);">
            <i class=" fas fa-plus-circle"></i> Agregar
        </span>
        @include('utils.select2General', ['name'=>'persona_id' , 'cbo'=>$formData['cboPersona']])
    </div>
</div>
<div class="custom-control custom-checkbox form-group">
    <input type="checkbox" class="custom-control-input" id="cobroAdelantado"
        onchange="toggleDivCheckBox('cobroAdelantado', 'divFacturacion');">
    <label class="custom-control-label" for="cobroAdelantado">Cobrar adelantado</label>
</div>

@include('principal.facturacion', [
    'cboDocumentos' => $formData['cboDocumentos'],
    'ruta' => $formData['rutaTipoDoc'],
    'cboPersona' => $formData['cboPersona'],
])

<div class="form-group">
    @include('utils.modalBtns', ['entidad' => $formData['entidad'], 'boton' => $formData['boton']])
</div>

</form>
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('800');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
        toggleDivCheckBox('cobroAdelantado', 'divFacturacion');
        handleChangeTipoDocumento('tipo', '{{ URL::route($formData['rutaTipoDoc']) }}', 'numero');
    });
    $('#persona_id').change(function(){
        var value = $(this).val();
        sameValueInput(value, 'persona_id_comprobante');
    });
</script>
