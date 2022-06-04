<div class="container text-center mt-5">
    <div class="row btn-group">
        <button class="btn btn-outline-success btn-sm" {{ $status === 0 ? 'disabled' : null }} id="btnGuardar"
            onclick="modal('{{ URL::route($ruta['create'], ['option' =>'NEW', 'listar' => 'SI']) }}', 'Nuevo Movimiento', this);">
            Nuevo Movimiento <i class="fas fa-plus"></i>
        </button>
        <button class="btn btn-outline-primary btn-sm" {{ $status === 1 ? 'disabled' : null }} id="btnGuardar"
            onclick="modal('{{ URL::route($ruta['create'], ['option' => 'APERTURA', 'listar' => 'SI']) }}', 'Apertura de Caja', this);">
            Apertura <i class="fas fa-money-bill"></i>
        </button>
        <button class="btn btn-danger btn-sm" {{ $status === 0 ? 'disabled' : null }} id="btnGuardar"
            onclick="modal('{{ URL::route($ruta['create'], ['option' => 'CIERRE', 'listar' => 'SI']) }}', 'Cierre de Caja', this);">
            Cierre <i class="fas fa-external-link-alt"></i>
        </button>
        <a href="#">
            <button class="btn btn-outline-warning btn-sm">
                Imprimir A4 <i class="fas fa-print"></i>
            </button>
        </a>
        <a href="#">
            <button class="btn btn-outline-secondary btn-sm">
                Imprimir Ticket <i class="fas fa-ticket-alt"></i>
            </button>
        </a>
    </div>
</div>
