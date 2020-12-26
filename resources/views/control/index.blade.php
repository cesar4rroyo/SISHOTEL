@extends("theme.$theme.layout")

@section('content')
{{-- {{dd($pisos)}} --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header font-weight-bold">Habitaciones</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('habitaciones') }}" accept-charset="UTF-8" class="my-2 my-lg-0"
                        role="piso">
                        <div class="input-group">
                            <select class="form-control" name="piso" value="{{ request('piso') }}">
                                <option value=""><i class="fas fa-filter"></i> Seleccionar Piso</option>
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
                                                        </span>
                                                        <span
                                                            class="info-box-text text-dark font-weight-bold">Precio:</span><span
                                                            class="info-box-number">
                                                            <span class="badge bg-danger">
                                                                {{$item['tipohabitacion']['precio']}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            @switch($item['situacion'])
                                            @case('Disponible')
                                            <button class="btn btn-app bg-success">
                                                <i class="fas fa-check-circle"></i>
                                                Check-In
                                            </button>
                                            @break
                                            @case('Ocupada')
                                            <button class="btn btn-app bg-danger">
                                                <i class="fas fa-check-circle"></i>
                                                Check-Out
                                            </button>
                                            @break
                                            @default
                                            <button class="btn btn-app bg-success disabled">
                                                <i class="fas fa-check-circle"></i>
                                                Check-In
                                            </button>
                                            @endswitch
                                            <button class="btn btn-app bg-primary">
                                                <i class="fas fa-gifts"></i>
                                                Productos
                                            </button>
                                            <button class="btn btn-app bg-secondary">
                                                <i class="fa fas fa-concierge-bell"></i>
                                                Servicios
                                            </button>
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