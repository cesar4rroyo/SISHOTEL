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
        <input class="form-control" type="date" name="fecha" id="fecha" value="{{ $formData['fecha'] }}" {{$formData['opcion'] != 'NEW' ? 'readonly' : null}} required>
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
            <input type="hidden" name="tipo" value={{$formData['selectedTipo']}} >
            <input type="hidden" name="concepto_id" value={{$formData['selectedConcepto']}} >
        @endif
        <select name="tipo" id="tipo" class=" form-control" {{($formData['opcion'] != 'NEW' ? 'disabled' : null)}}>
            @foreach ($formData['cboTipo'] as $key => $value)
                @if ($formData['selectedTipo'] == $key)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm">
        <label for="concepto_id">Concepto:</label>
        <select name="concepto_id" id="concepto_id" class=" form-control" {{($formData['opcion'] != 'NEW' ? 'disabled' : null)}}>
            @foreach ($formData['cboConcepto'] as $key => $value)
                @if ($formData['selectedConcepto'] == $key)
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="total">Monto</label>
    <input class="form-control" type="number" step="0.01" name="total" id="total" value="" required placeholder="Ingrese el monto ...">
</div>
<div class="form-group">
    <label for="comentario">Comentario</label>
    <textarea class="form-control" name="comentario" id="comentario" rows="3" placeholder="Ingrese el comentario ..."></textarea>
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
