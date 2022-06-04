<div class="container" id="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold">{{ $titulo_admin }}</div>
                <div class="card-body table-responsive px-3">
                    @include('control.caja2.admin', [
                        'action' => $ruta['search'],
                        'method' => 'POST',
                        'idform' => 'formBusqueda' . $entidad,
                        'cboRangeFilas' => $cboRangeFilas,
                        'cboTipos' => $cboTipo,
                    ])
                    <div class="mt-5" id="listado{{ $entidad }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        buscar('{{ $entidad }}');
        init(IDFORMBUSQUEDA + '{{ $entidad }}', 'B', '{{ $entidad }}');
        $(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="nombre"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
    });
</script>
