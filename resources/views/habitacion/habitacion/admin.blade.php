<form action="{{ route($action) }}" method="{{ $method }}" onsubmit="return false;" id="{{ $idform }}">
    @csrf
    <div class="row">
        <input type="hidden" name="page" id="page" value="1">
        <input type="hidden" name="accion" id="accion" value="listar">
        <div class="col-4">
            <label for="numero">Número de la Habitación:</label>
            <input type="text" class="form-control" name="numero" id="numero" placeholder="Buscar por número...">
        </div>
        <div class="col-3">
            <label for="piso">Piso:</label>
            <select name="piso" id="piso" class="form-control" onchange="buscar('{{ $entidad }}');"> 
                @foreach ($cboPisos as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="tipohabitacion">Tipo de Habitación:</label>
            <select name="tipohabitacion" id="tipohabitacion" class="form-control" onchange="buscar('{{ $entidad }}');">
                @foreach ($cboTiposHabitacion as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            @include('utils.rangeInput', ['cboRangeFilas' => $cboRangeFilas, 'entidad' => $entidad])
        </div>
    </div>
</form>
