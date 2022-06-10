<form action="{{ route($action) }}" method="{{ $method }}" onsubmit="return false;" id="{{ $idform }}">
    @csrf
    <div class="row">
        <input type="hidden" name="page" id="page" value="1">
        <input type="hidden" name="accion" id="accion" value="listar">
        <div class="col-12">
            <select name="piso" id="piso" class="form-control" onchange="buscar('{{ $entidad }}');"> 
                @foreach ($cboPisos as $key => $value)
                    @if ($key == $selected)
                        <option value="{{ $key }}" selected>{{ $value }}</option>
                    @else
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</form>
