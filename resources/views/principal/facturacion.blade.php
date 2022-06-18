<div id="divFacturacion">
    <hr>
    <div class="row">
        <div class="form-group col-3">
            <label for="tipo">Tipo de Documento</label>
            @include('utils.cboGeneral', ['cbo' => $cboDocumentos, 'selected' => null, 'class' => 'form-control', 'name' => 'tipo', 'id' => 'tipo', 'disabled' => false, 'required' => true, 'onchange' => "handleChangeTipoDocumento('tipo','" . URL::route($ruta) . "', 'numero');" ])
        </div>
        <div class="form-group col-3">
            <label for="numero">Número</label>
            <input type="text" value="{{"0000"}}" name="numero" id="numero" class="form-control" readonly>
        </div>
        <div class="form-group col-sm">
            <label for="persona">Persona o Razon Social</label>
            @include('utils.select2General', ['name'=>'persona_id_comprobante' , 'cbo'=>$cboPersona])
        </div>
    </div>
</div>
