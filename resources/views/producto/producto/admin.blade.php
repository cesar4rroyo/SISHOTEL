<form action="{{ route($action) }}" method="{{ $method }}" onsubmit="return false;" id="{{ $idform }}">
    @csrf
    <div class="row">
        <input type="hidden" name="page" id="page" value="1">
        <input type="hidden" name="accion" id="accion" value="listar">
        <div class="col-4">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Buscar por nombre...">
        </div>
        <div class="col-3">
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria" class="form-control" onchange="buscar('{{ $entidad }}');"> 
                @foreach ($cboCategorias as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <label for="unidades">Unidades:</label>
            <select name="unidad" id="unidad" class="form-control" onchange="buscar('{{ $entidad }}');">
                @foreach ($cboUnidades as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            @include('utils.rangeInput', ['cboRangeFilas' => $cboRangeFilas, 'entidad' => $entidad])
        </div>
    </div>
</form>
