<form action="{{ route($action) }}" method="{{ $method }}" onsubmit="return false;" id="{{ $idform }}">
    @csrf
    <div class="row">
        <input type="hidden" name="page" id="page" value="1">
        <input type="hidden" name="accion" id="accion" value="listar">
        <div class="col-6">
            <label for="nombre">Username:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Buscar por nombre...">
        </div>
        <div class="col-3">
            <label for="grupomenu">Tipo de Usuario</label>
            <select class="form-control" name="grupomenu" id="grupomenu" onchange="buscar('{{ $entidad }}');">
                @foreach ($cboTipoUsuario as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            @include('utils.rangeInput', ['cboRangeFilas' => $cboRangeFilas, 'entidad' => $entidad])
        </div>
    </div>
</form>
