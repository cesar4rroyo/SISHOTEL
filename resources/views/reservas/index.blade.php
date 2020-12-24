@extends("theme.$theme.layout")

@section('content')
{{-- {{dd($pisos)}} --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Reservas</div>
                <div class="card-body">
                    @foreach ($pisos as $piso)
                    @if (count($piso['habitacion'])!=0)
                    <div class="card alert alert-info">
                        <div class="card-header text-uppercase font-weight-bold">{{$piso['nombre']}}</div>
                        <div class="card-body card-group">
                            @foreach ($piso['habitacion'] as $habitacion)
                            <div class="col-md-4 mb-3">
                                <div class="position-relative bg-yellow">
                                    <div class="ribbon-wrapper">
                                        <div
                                            class="ribbon {{$habitacion['situacion']==='Disponible' ? 'bg-success' : ($habitacion['situacion']==='Ocupada' ? 'bg-danger' : 'bg-info')}}">
                                            {{$habitacion['situacion']}}</div>
                                    </div>
                                    <p class="text-center font-weight-bold">
                                        {{'Habitacion:'. $habitacion['numero']}}
                                    </p>
                                    <div style="height: 100px"></div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection