@extends("theme.$theme.layout")

@section('content')
{{-- {{dd($movimiento)}} --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Check Out Realizados por Clientes</div>
            <div class="card-body">
                <a href="{{ route('habitaciones') }}" title="Regresar"><button
                        class="btn btn-outline-secondary btn-sm mb-2"><i class="fa fa-arrow-left"
                            aria-hidden="true"></i>
                        Regresar</button></a>
                {{-- <a href="{{route('caja_pdf')}}">
                <button class="btn btn-warning btn-sm mb-2"><i class="fas fa-print" aria-hidden="true"></i>
                    Imprimir</button>
                </a> --}}
                <div class="container">
                    <div class="table-responsive">
                        <table class="table text-center table-hover" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>Fecha Inreso</th>
                                    <th>Fecha Salida</th>
                                    <th>Días</th>
                                    <th>Habitacion</th>
                                    {{-- <th>Reserva</th> --}}
                                    <th>Total</th>
                                    <th>Huéspedes</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            {{-- {{dd($movimientos)}} --}}
                            <tbody>
                                @foreach ($movimientos as $item)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($item->fechaingreso)->formatLocalized('%d %B %Y %H:%M:00')}}
                                    </td>
                                    <td>{{\Carbon\Carbon::parse($item->fechasalida)->formatLocalized('%d %B %Y %H:%M:00')}}
                                    </td>
                                    <td>
                                        {{ $item->dias}}
                                    </td>
                                    <td>
                                        {{$item->habitacion->numero .' - ' . $item->habitacion->tipohabitacion->nombre}}
                                    </td>
                                    {{-- <td>
                                          {{$reserva}}
                                    </td> --}}
                                    <td>{{ $item->total }}</td>

                                    <td>
                                        @foreach ($item->pasajero as $pasajero)
                                        {{$loop->last ? $pasajero->persona->nombres : $pasajero->persona->nombres . ', '}}
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('check_out_pdf', $item->id)}}">
                                                <button class="btn btn-warning btn-sm mb-2"><i class="fas fa-print"
                                                        aria-hidden="true"></i>
                                                    Imprimir</button>
                                            </a>
                                            <form class="form-eliminar" method="POST"
                                                action="{{ route('eliminar_checkout_lista', $item->id) }}" accept-charset="UTF-8"
                                                style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i>Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection