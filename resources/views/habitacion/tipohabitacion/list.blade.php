@if(count($lista) == 0)
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
			<td>{{ $contador }}</td>
			<td>{{ $value->nombre }}</td>
			<td>{{ $value->capacidad }}</td>
			<td>{{ $value->precio }}</td>
			<td class="text-center">
				<div class="btn-group">
					@include('utils.baseButtons', ['ruta' => $ruta, 'id' => $value->id, 'titulo_modificar' => $titulo_modificar, 'titulo_eliminar' => $titulo_eliminar])
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
{!! $paginacion!!}
@endif