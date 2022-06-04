@include('control.caja2.btnsCaja', [
    'status' => $status,
    'entidad' => $entidad,
    'route' => $ruta,
])
@if (count($lista) == 0)
    @include('utils.noresult')
@else
    {!! $paginacion !!}
    <table id="example1" class="table table-bordered table-striped table-condensed table-hover">
        @include('utils.theader', ['cabecera' => $cabecera])
        <tbody>
            <?php
            $contador = $inicio + 1;
            ?>
            @foreach ($lista as $key => $value)
                <tr>
                    <td>{{ date('d-M-Y H:i:s', strtotime($value->fecha)) }}</td>
                    <td>
                        <span class=" badge badge-{{ $value->tipo === 'Ingreso' ? 'success' : 'danger' }}">
                            {{ $value->tipo }}
                        </span>
                    </td>
                    <td>{{ isset($value->persona) ? $value->persona->nombres : '-' }}</td>
                    <td>{{ $value->total }}</td>
                    <td>{{ $value->concepto->nombre }}</td>
                    <td>{{ $value->comentario }}</td>
                    <td>{{ isset($value->movimiento) ? $value->movimiento->id : '-' }}</td>
                    <td>{{ $value->usuario->login }}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            {{-- @include('utils.baseButtons', ['ruta' => $ruta, 'id' => $value->id, 'titulo_modificar' => $titulo_modificar, 'titulo_eliminar' => $titulo_eliminar]) --}}
                        </div>
                    </td>
                </tr>
                <?php
                $contador = $contador + 1;
                ?>
            @endforeach
        </tbody>
        @include('utils.tfooter', ['cabecera' => $cabecera])
    </table>
    {!! $paginacion !!}
	@include('control.caja2.totales', ['totales', $totales])
@endif
