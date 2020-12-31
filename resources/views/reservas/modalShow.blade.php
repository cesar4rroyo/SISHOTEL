<div class="modal fade" id="modal-show">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="txtTitulo" class="modal-title">Reserva</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='PUT' id="reservaForm" action="">
                    @csrf
                    <input class="form-control" hidden type="text" name="txtId" id="txtId">
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="txtFechaShow" class="control-label">{{'Fecha'}}</label>
                            <input class="form-control" type="date" name="txtFecha" id="txtFechaShow" required>
                        </div>
                        <div class="form-group col-sm">
                            <label for="situacion" class="control-label">{{'Situacion'}}</label>
                            <input readonly class="form-control" type="text" name="situacion" id="situacion" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="personaShow" class="control-label">{{ 'Cliente' }}</label>
                            <select name="persona" class="form-control" id="personaShow" required>
                                <option value="">Seleccione una opcion</option>
                                @foreach ($clientes as $cliente)
                                <option value="{{$cliente['id']}}">
                                    {{$cliente['nombres']}} {{$cliente['apellidos']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="selectHabitacionShow"
                                class="control-label selectHabitacionShow">{{ 'Habitaciones Disponibles' }}</label>
                            <select name="habitacion" class="form-control" id="selectHabitacionShow">
                                <option value="{{$initialDate}}">Seleccione una opcion</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="observacionShow" class="control-label">{{ 'Observacion' }}</label>
                        <textarea name="observacion" class="form-control" id="observacionShow" cols="30"
                            rows="5"></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" id="btnCerrarModal" class="btn btn-secondary"
                            data-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnActualizar" class="btn btn-outline-primary">Actualizar
                            Reserva</button>
                        <button type="button" id="btnEliminar" class="btn btn-outline-danger">
                            Cancelar Reserva</button>
                    </div>
                </form>
                {{-- <div class="container">
                    <button id="btnCheckIn" class="btn btn-outline-success col-12">
                        Check In
                    </button>
                </div> --}}
            </div>

        </div>
    </div>
</div>