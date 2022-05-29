<label for="filas">Filas a Mostrar:</label>
<select name="filas" id="filas" class="form-control" onchange="buscar('{{ $entidad }}');">
    @foreach ($cboRangeFilas as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>
