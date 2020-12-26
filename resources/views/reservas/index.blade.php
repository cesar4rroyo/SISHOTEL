@extends("theme.$theme.layout")

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold">Reservas</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('habitaciones') }}" accept-charset="UTF-8" class="my-2 my-lg-0"
                        role="piso">
                        <div class="input-group">
                            <input class="form-control" placeholder="Nueva Reserva" type="date">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection