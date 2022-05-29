<button class="btn btn-success float-right" id="btnNuevo"
    onclick="modal('{{ URL::route($ruta, ['listar' => 'SI']) }}', '{{ $titulo }}', this);">
    Agregar <i class="fa fa-plus fa-fw"></i>
</button>
