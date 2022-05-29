<div class="col-sm text-right">
    <button class="btn btn-success btn-sm" id="btnGuardar" onclick="guardar('{{$entidad}}', this);">
        <i class="far fa-save"></i>
        {{$boton}}
    </button>
    <button class="btn btn-warning btn-sm" id="btnCancelar{{$entidad}}" onclick="cerrarModal();">
        <i class=" fas fa-exclamation"></i>
        Cancelar
    </button>
</div>