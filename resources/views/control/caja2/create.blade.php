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
        <label for="fecha">Fecha:</label>
        <input class="form-control" type="datetime" name="fecha" id="fecha" value="{{ date('Y-m-d H:i:s') }}"
            {{ $formData['opcion'] != 'NEW' ? 'readonly' : null }} required>
    </div>
    <div class="form-group col-sm">
        <label for="numero">Número:</label>
        <input class=" form-control" type="text" name="numero" id="numero" value="{{ $formData['numero'] }}" required
            readonly>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm">
        <label for="tipo">Tipo:</label>
        @if ($formData['opcion'] != 'NEW')
            <input type="hidden" name="tipo" value={{ $formData['selectedTipo'] }}>
            <input type="hidden" name="concepto_id" value={{ $formData['selectedConcepto'] }}>
        @endif
        <select name="tipo" id="tipo_select" class=" form-control"
            {{ $formData['opcion'] != 'NEW' ? 'disabled' : null }}>
            @foreach ($formData['cboTipo'] as $key => $value)
                @if ($formData['selectedTipo'] == $key)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
    @if ($formData['opcion'] == 'NEW')
        <input type="hidden" name="concepto_id" id="concepto_id">
    @endif
    <div class="form-group col-sm">
        <label for="selectConcepto">Concepto:</label>
        <select id="selectConcepto" class="form-control" disabled>
            @foreach ($formData['cboConcepto'] as $key => $value)
                @if ($formData['selectedConcepto'] == $key)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
        <select id="selectIngresos" class="form-control" style="display: none">
            @foreach ($formData['cboConceptoIngreso'] as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <select id="selectEgresos" class="form-control" style="display: none">
            @foreach ($formData['cboConceptoEgreso'] as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
@if ($formData['opcion'] == 'CIERRE')
    <div class="row">
        <div class="form-group col-sm">
            <label for="total">Monto cierre</label>
            <input class="form-control" type="number" step="0.01" name="total_cierre" id="total_cierre"
                value="{{ $formData['montocierre'] }}" disabled placeholder="Ingrese el monto ...">
        </div>
        <div class="form-group col-sm">
            <label for="total">Monto</label>
            <input class="form-control" type="number" step="0.01" name="total" id="total" value="" required
                placeholder="Ingrese el monto ...">
        </div>
    </div>
@else
    <div class="form-group">
        <label for="total">Monto</label>
        <input class="form-control" type="number" step="0.01" name="total" id="total" value="" required
            placeholder="Ingrese el monto ...">
    </div>
@endif
@if ($formData['opcion'] == 'NEW')
    <div class="form-group">
        <label for="persona_id">Persona</label>
        @include('utils.select2General', ['name'=>'persona_id' , 'cbo'=>$formData['cboPersona']])
    </div>
@endif
<div class="form-group">
    <label for="comentario">Comentario</label>
    <textarea class="form-control" name="comentario" id="comentario" rows="3"
        placeholder="Ingrese el comentario ..."></textarea>
</div>

<div class="form-group">
    <div class="col-sm text-right">
        @if ($formData['opcion'] == 'CIERRE')
            <button class="btn btn-success btn-sm" id="btnGuardar"
                onclick="validarCaja();guardar('{{ $formData['entidad'] }}', this);">
                <i class="far fa-save"></i>
                {{ $formData['boton'] }}
            </button>
        @else
            <button class="btn btn-success btn-sm" id="btnGuardar"
                onclick="guardar('{{ $formData['entidad'] }}', this);">
                <i class="far fa-save"></i>
                {{ $formData['boton'] }}
            </button>
        @endif
        <button class="btn btn-warning btn-sm" id="btnCancelar{{ $formData['entidad'] }}" onclick="cerrarModal();">
            <i class=" fas fa-exclamation"></i>
            Cancelar
        </button>
    </div>
</div>

</form>
<script type="text/javascript">
    $(document).ready(function() {
        configurarAnchoModal('500');
        init(IDFORMMANTENIMIENTO + '{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
    });
    $('#tipo_select').on('change', function() {
        var value = this.value;
        if (value == 'INGRESO') {
            $('#selectConcepto').hide();
            $('#selectIngresos').show();
            $('#selectEgresos').hide();
        } else if (value == 'EGRESO') {
            $('#selectConcepto').hide();
            $('#selectIngresos').hide();
            $('#selectEgresos').show();
        } else {
            $('#selectConcepto').show();
            $('#selectIngresos').hide();
            $('#selectEgresos').hide();
        }
    });
    $('#selectConcepto').on('change', function() {
        var value = this.value;
        $('#concepto_id').val(value);
    });
    $('#selectIngresos').on('change', function() {
        var value = this.value;
        $('#concepto_id').val(value);
    });
    $('#selectEgresos').on('change', function() {
        var value = this.value;
        $('#concepto_id').val(value);
    });

</script>
