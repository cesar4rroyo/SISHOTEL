<div class="container" id="container">
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <div class="card">
                <div class="card-header font-weight-bold">Reservas</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('reserva') }}" accept-charset="UTF-8" class="my-2 my-lg-0"
                        role="fecha">
                        <div class="input-group">
                            <input class="form-control" value="{{$initialDate}}" id="fecha" name="fecha"
                                placeholder="Nueva Reserva" type="date">
                        </div>
                        <button class="btn btn-outline-success mt-3 ">Buscar</button>
                    </form>
                    @include('reservas.modalShow', ['clientes'=>$clientes, 'initialDate'=>$initialDate])
                    @include('reservas.modalAdd', ['clientes'=>$clientes, 'initialDate'=>$initialDate])
                    @include('fullcalendar.index', ['fecha'=>$initialDate])
                </div>

            </div>
        </div>
    </div>
</div>