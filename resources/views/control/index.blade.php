@extends("theme.$theme.layout")

@section('content')
{{-- {{dd($habitacion)}} --}}
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    @if ($message = Session::get('error'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold">Habitaciones</div>
                <div class="card-body">
                    <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg"
                        class="btn btn-outline-info mb-2 mt-1 float-right">
                        <i class="fas fa-chart-bar"></i>
                        Estado General
                    </button>
                    @include('control.modal')
                    <form method="GET" action="{{ route('habitaciones') }}" accept-charset="UTF-8" class="my-2 my-lg-0"
                        role="piso">
                        <div class="input-group">
                            <select class="form-control" name="piso" value="{{ request('piso') }}">
                                <option value=""><i class="fas fa-filter"></i>
                                    {{'Seleccionar Piso'}}</option>
                                @foreach ($pisos as $item)
                                <option value="{{$item['id']}}">{{$item['nombre']}}</option>
                                @endforeach
                            </select>
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>

                    @if (count($piso['habitacion'])==0)
                    <div class="card-header text-uppercase font-weight-bold">
                        No se encontraron habitaciones
                    </div>
                    @else
                    <div class="card alert alert-warning mt-4">
                        <div class="card-header text-uppercase font-weight-bold">{{$piso['nombre']}}</div>
                        <div class="card-body card-group">
                            @foreach ($habitacion as $item)
                            <div class="col-md-4 mb-3">
                                <div
                                    class="position-relative {{$item['situacion']==='Disponible' ? 'bg-success' : ($item['situacion']==='Ocupada' ? 'bg-danger' : 'bg-info')}}">
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon bg-white font-weight-bold">
                                            {{$item['situacion']}}</div>
                                    </div>
                                    <div class="container pt-5">
                                        <div class="row">
                                            <div class="col">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-info"><i
                                                            class="fa fas fa-h-square"></i></span>
                                                    <div class="info-box-content">
                                                        <span
                                                            class="info-box-text text-dark font-weight-bold">{{'Habitación:'. $item['numero']}}</span><span
                                                            class="info-box-number">
                                                            <span class="badge bg-primary">
                                                                {{$item['tipohabitacion']['nombre']}}
                                                            </span>
                                                            <span class="badge bg-warning mt-2">
                                                                S/.{{$item['tipohabitacion']['precio']}}
                                                            </span>
                                                        </span>
                                                        <a href="{{route('show_habitaciones', $item['id'])}}" class="">
                                                            <span class="mt-2 badge bg-secondary">
                                                                Consultar Reservas
                                                                <i class="fas fa-search"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            @switch($item['situacion'])
                                            @case('Disponible')
                                            <a href="{{route('edit_movimiento', $item['id'])}}"
                                                class="btn btn-app bg-success text-decoration-none">
                                                <i class="fas fa-check-circle"></i>
                                                Check-In
                                            </a>
                                            @break
                                            @case('Ocupada')
                                            <a href="{{route('edit_movimiento', $item['id'])}}"
                                                class="btn btn-app bg-danger text-decoration-none">
                                                <i class="fas fa-check-circle"></i>
                                                Check-Out
                                            </a>
                                            <a href="{{route('add_movimieto', ['id'=>$item['id']])}}"
                                                class="btn btn-app bg-primary text-decoration-none">
                                                <i class="fas fa-gifts"></i>
                                                Productos
                                            </a>
                                            <a href="{{route('add_movimieto', ['id'=>$item['id'], 'movimiento'=>'servicio'])}}"
                                                class="btn btn-app bg-secondary text-decoration-none">
                                                <i class="fa fas fa-concierge-bell"></i>
                                                Servicios
                                            </a>
                                            @break
                                            @default
                                            <a href="{{route('edit_movimiento', $item['id'])}}"
                                                class="btn btn-app bg-success disabled text-decoration-none">
                                                <i class="fas fa-check-circle"></i>
                                                Check-In
                                            </a>
                                            <a href="{{route('actualizarHabitacion' , $item['id'])}}"
                                                class="btn btn-app bg-warning text-decoration-none">
                                                <i class="fas fa-check-circle"></i>
                                                Actualizar Habitación
                                            </a>
                                            @endswitch

                                        </div>
                                    </div>
                                    <div style="height: 20px"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection