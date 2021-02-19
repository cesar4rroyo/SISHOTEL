<style>
    #btnBuscarRuc:hover {
        cursor: pointer;
    }
    #btnBuscarDni:hover{
        cursor: pointer;
    }
</style>
<div class="modal fade" id="modalHuesped" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Húesped</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="huespedForm">
            @csrf
            <div class="modal-body">
                    <input type="hidden" id="nro_movimientoH" name="nro_movimientoH" value="{{$movimiento['id']}}">
                    <input type="hidden" id="idHuesped" name="idHuesped">
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="nombresH" class="control-label">{{ 'Nombres' }}</label>
                            <input class="form-control" required name="nombresH" type="text" id="nombresH">
                        </div>
                        <div class="form-group col-sm">
                            <label for="apellidosH" class="control-label">{{ 'Apellidos' }}</label>
                            <input class="form-control" required name="apellidosH" type="text" id="apellidosH">
                        </div>
                        <div class="form-group col-sm">
                            <label for="rol_idH" class="control-label">{{ 'Roles' }}</label>
                            <select class="form-control select2 selectRolHuesped" required id="rol_idH" name="rol_idH[]" multiple="multiple"
                                data-placeholder="Seleccionar rol" style="width: 100%;">
                                @foreach ($roles as $id => $nombre)
                                <option value="{{$id}}"
                                    {{is_array(old('rol_id')) ? (in_array($id, old('rol_id')) ? 'selected' : '')  : (isset($persona) ? ($persona->roles->firstWhere('id', $id) ? 'selected' : '') : '')}}>
                                    {{$nombre}}</option>
                                @endforeach
                            </select>                      
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="rucH" class="control-label">{{ 'RUC' }}</label>
                            <span class="badge badge-primary" id="btnBuscarRucHuesped">
                                <i class="fas fa-search"></i>
                                {{'Buscar'}}</span>
                            <input class="form-control" name="rucH" type="number" id="rucH">
                        </div>
                        <div class="form-group col-sm">
                            <label for="razonsocialH" class="control-label">{{ 'Razón Social (Solo RUC)' }}</label>
                            <input class="form-control" name="razonsocialH" type="text" id="razonsocialH">
                        </div> 
                        <div class="form-group col-sm">
                            <label for="dniH" class="control-label">{{ 'DNI' }}</label>
                            <span class="badge badge-primary" id="btnBuscarDni">
                                <i class="fas fa-search"></i>
                                {{'Buscar (Si ya esta registrado)'}}</span>
                            <input class="form-control" name="dniH" type="text" id="dniH">
                        </div>                   
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="sexoH" class="control-label">{{ 'Sexo' }}</label>
                            <select name="sexoH" class="form-control" id="sexoH">
                                <option value="">Seleccione una opcion</option>
                                <option value="femenino">Femenino</option>
                                <option value="masculino">Masculino</option>
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="fechanacimientoH" class="control-label">{{ 'Fecha de nacimiento' }}</label>
                            <input class="form-control" name="fechanacimientoH" type="date" id="fechanacimientoH">
                        </div>
                        <div class="form-group col-sm">
                            <label for="edadH" class="control-label">{{ 'Edad' }}</label>
                            <input class="form-control" name="edadH" type="number" id="edadH">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="telefonoH" class="control-label">{{ 'Teléfono' }}</label>
                            <input class="form-control" name="telefonoH" type="text" id="telefonoH">
                        </div>
                        <div class="form-group col-sm">
                            <label for="emailH" class="control-label">{{ 'Email' }}</label>
                            <input class="form-control" name="emailH" type="text" id="emailH">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="nacionalidad_idH" class="control-label">{{ 'Nacionalidad' }}</label>
                            <select name="nacionalidad_idH" class="form-control" id="nacionalidad_idH">
                                <option
                                    value="{{ isset($persona->nacionalidad->nombre) ? $persona->nacionalidad->id : ''}}">
                                    {{ isset($persona->nacionalidad->nombre) ? $persona->nacionalidad->nombre : 'Seleccione una opcion'}}
                                </option>
                                @foreach ($nacionalidades as $item)
                                <option value="{{$item->id}}">
                                    {{$item->nombre}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="ciudadH" class="control-label">{{ 'Ciudad' }}</label>
                            <input class="form-control" name="ciudadH" type="text" id="ciudadH">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="direccionH" class="control-label">{{ 'Dirección' }}</label>
                            <input class="form-control" name="direccionH" type="text" id="direccionH">
                        </div>
                        <div class="form-group col-sm">
                            <label for="observacionH" class="control-label">{{ 'Observacion' }}</label>
                            <input class="form-control" name="observacionH" type="text" id="observacionH">
                        </div>   
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btnAgregarToHabitacion" class="btn btn-primary">Agregar a la habitación</button>
            </div>
            </form>                            

        </div>
    </div>
</div>