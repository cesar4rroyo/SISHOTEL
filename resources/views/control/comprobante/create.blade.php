@extends("theme.$theme.layout")

@section('content')
{{-- {{dd($movimiento)}} --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Actualizar estado de habitación</div>
            <div class="card-body">
                <div class="container">
                    <form action="{{route('actualizarHabitacion', $habitacion)}}" method="POST">
                        @csrf
                        <input readonly class="form-control" type="number" name="habitacion" value="{{$habitacion}}">
                        <div class="container text-center">
                            <p class="font-weight-bold">Por favor actualizar el estado de la habitación</p>
                            <button type="submit" class="btn btn-outline-success col-sm-6 mt-2">
                                Actualizar estado de habitaciones
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection