<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reservar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' id="reservaForm" action="{{route('store_reserva')}}">
                    @csrf
                    <div class="form-group">
                        <label for="txtFecha" class="control-label">{{'Fecha'}}</label>
                        <input class="form-control" type="date" name="txtFecha" id="txtFecha" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="persona" class="control-label">{{ 'Cliente' }}</label>
                            <a href="{{route("create_persona")}}">
                                <span class="badge badge-success">
                                    <i class="fas fa-plus-circle"></i>
                                    {{'Agregar Nuevo'}}</span>
                            </a>
                            <select name="persona" class="form-control" id="persona" required>
                                <option value="">Seleccione una opcion</option>
                                @foreach ($clientes as $cliente)
                                <option value="{{$cliente['id']}}">
                                    {{$cliente['nombres']}} {{$cliente['apellidos']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectHabitacion"
                            class="control-label selectHabitacion">{{ 'Habitaciones Disponibles' }}</label>
                        <select name="habitacion" class="form-control" id="selectHabitacion">
                            <option value="{{$initialDate}}">Seleccione una opcion</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="observacion" class="control-label">{{ 'Observacion' }}</label>
                        <textarea name="observacion" class="form-control" id="observacion" cols="30"
                            rows="5"></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" id="btnCerrarModal" class="btn btn-secondary"
                            data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btnAgregar" class="btn btn-primary">Hacer
                            Reserva</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>