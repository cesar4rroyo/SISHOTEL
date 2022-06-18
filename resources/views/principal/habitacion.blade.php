<div class="col-md-4 mb-3">
    <div
        class="position-relative {{ $habitacion->situacion === 'Disponible' ? 'bg-success' : ($habitacion->situacion === 'Ocupada' || $habitacion->situacion === 'YA PAGO' ? 'bg-danger' : 'bg-info') }}">
        <div class="ribbon-wrapper">
            <div class="ribbon bg-white font-weight-bold">
                {{ $habitacion->situacion == 'Ocupada' ? 'NO PAGO' : $habitacion->situacion }}</div>
        </div>
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fas fa-h-square"></i></span>
                        <div class="info-box-content">
                            <span
                                class="info-box-text text-dark font-weight-bold">{{ 'Habitación:' . $habitacion->numero }}</span><span
                                class="info-box-number">
                                <span class="badge bg-primary">
                                    {{ $habitacion->tipohabitacion->nombre }}
                                </span>
                                <span class="badge bg-warning mt-2">
                                    S/.{{ $habitacion->tipohabitacion->precio }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <div class="btn-group">
                @switch($habitacion->situacion)
                    @case('Disponible')
                        <a href="#"
                            class="btn btn-app bg-success text-decoration-none" onclick="modal('{{URL::route($ruta['create'], array('id'=>$habitacion->id, 'listar'=>'SI'))}}', 'Check-In', this);">
                            <i class="fas fa-check-circle"></i>
                            Check-In
                        </a>
                    @break

                    @case('Ocupada')
                        <a href="#"
                            class="btn btn-app bg-danger text-decoration-none" onclick="modal('{{URL::route($ruta['edit'], array('id'=>$habitacion->id, 'listar'=>'SI'))}}', 'Check-Out', this);">
                            <i class="fas fa-check-circle"></i>
                            Check-Out
                        </a>
                        <a href="#"
                            class="btn btn-app bg-primary text-decoration-none" onclick="modal('{{URL::route($ruta['addmovimiento'], array('id'=> $habitacion->id, 'listar'=>'SI', 'movimiento'=>'producto'))}}', 'Agregar Productos', this);">
                            <i class="fas fa-gifts"></i>
                            Productos
                        </a>
                        <a href="#"
                            class="btn btn-app bg-secondary text-decoration-none" onclick="modal('{{URL::route($ruta['addmovimiento'], array('id'=> $habitacion->id, 'listar'=>'SI', 'movimiento'=>'servicio'))}}', 'Agregar Servicios', this);">
                            <i class="fa fas fa-concierge-bell"></i>
                            Servicios
                        </a>
                    @break

                    @case('YA PAGO')
                        <a href="#"
                            class="btn btn-app bg-danger text-decoration-none" onclick="modal('{{URL::route($ruta['edit'], array('id'=> $habitacion->id, 'listar'=>'SI'))}}', 'Check-Out', this);">
                            <i class="fas fa-check-circle"></i>
                            Terminar
                        </a>
                    @break

                    @default
                        <a href="#"
                            class="btn btn-app bg-success text-decoration-none disabled" onclick="modal('{{URL::route($ruta['create'], array('id'=>$habitacion->id, 'listar'=>'SI'))}}', 'Check-In', this);">
                            <i class="fas fa-check-circle"></i>
                            Check-In
                        </a>
                        <a href="#"
                            class="btn btn-app bg-warning text-decoration-none" onclick="modal('{{URL::route($ruta['edit'], array('id'=> $habitacion->id, 'listar'=>'SI'))}}', 'Actualizar Habitación', this);">
                            <i class="fas fa-check-circle"></i>
                            Actualizar Habitación
                        </a>
                @endswitch

            </div>
        </div>
        <div style="height: 20px"></div>
    </div>
</div>
