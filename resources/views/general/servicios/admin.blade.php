<form action="{{ route($action) }}" method="{{ $method }}" onsubmit="return false;" id="{{ $idform }}">
    @csrf
    <div class="row">
        <input type="hidden" name="page" id="page" value="1">
        <input type="hidden" name="accion" id="accion" value="listar">
        <div class="col-9">
            <label for="nombre">Nombre del Servicio:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Buscar por nombre...">
        </div>
        <div class="col-3">
            @include('utils.rangeInput', ['cboRangeFilas' => $cboRangeFilas, 'entidad' => $entidad])
        </div>
    </div>
</form>
