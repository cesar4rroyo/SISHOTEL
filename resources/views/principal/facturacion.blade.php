<div id="divFacturacion">
    <hr>
    <div class="row">
        <div class="form-group col-sm">
            <label for="tipo">Tipo de Documento</label>
            <select class="form-control" name="tipo" id="tipo" required onchange="handleChangeTipoDocumento('tipo', '{{URL::route($ruta)}}', 'numero');">
                @foreach ($cboDocumentos as $item => $value)
                    <option value="{{ $item }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm">
            <label for="numero">Número</label>
            <input type="text" value="{{"0000"}}" name="numero" id="numero" class="form-control" readonly>
        </div>
        <div class="form-group col-sm">
            <label for="persona">Persona o Razon Social</label>
            <input class=" form-control" type="text" name="nombre" id="nombre" placeholder="Ingrese nombre"
                value="{{ isset($formData['model']) ? $formData['model']->nombre : null }}" required>
        </div>
    </div>
</div>
