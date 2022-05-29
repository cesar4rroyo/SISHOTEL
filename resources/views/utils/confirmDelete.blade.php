@include('utils.errorDiv', ['entidad' => $formData['entidad']])
@include('utils.formCrud', [
    'entidad' => $formData['entidad'],
    'formData' => $formData,
    'method' => $formData['method'],
    'route' => $formData['route'],
    'model' => isset($formData['model']) ? $formData['model'] : null,
])
<div class="callout callout-danger">
	<p class="text-danger">¿Esta seguro de eliminar el registro?</p>
</div>
<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		<button class="btn btn-danger btn-sm" id="btnGuardar" onclick="guardar('{{$formData['entidad']}}', this);">
			<i class="fa fa-trash"></i>
			<span>{{$formData['boton']}}</span>
		</button>
		<button class="btn btn-default btn-sm" id="btnCancelar{{$formData['entidad']}}" onclick="cerrarModal((contadorModal - 1));">
			<i class="fa fa-undo"></i>
			<span>Cancelar</span>
		</button>
	</div>
</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		init(IDFORMMANTENIMIENTO+'{!! $formData['entidad'] !!}', 'M', '{!! $formData['entidad'] !!}');
		configurarAnchoModal('400');
	}); 
</script>