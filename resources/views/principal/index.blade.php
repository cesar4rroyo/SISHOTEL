<div class="container" id="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold">{{ $titulo_admin }}</div>
                <div class="card-body table-responsive px-3">
                    @include('principal.admin', [
                        'action' => $ruta['search'],
                        'method' => 'POST',
                        'idform' => 'formBusqueda' . $entidad,
                        'cboPisos' => $cboPisos,
                        'selected' => $pisoSelected
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
    });
</script>
