<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Estadísticas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <p class="text-center font-weight-bold">Habitaciones Ocupadas</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Número</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Húespedes</th>
                                        <th scope="col">Capacidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0 ?>
                                    @foreach ($ocupadas as $item)
                                    <?php $total += count($item['pasajero'])?>
                                    <tr>
                                        <th scope="row">{{$item['habitacion']['numero']}}</th>
                                        <td>{{$item['habitacion']['tipohabitacion']['nombre']}}</td>
                                        <td>{{count($item['pasajero'])}}</td>
                                        <td>{{$item['habitacion']['tipohabitacion']['capacidad']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p class="font-weight-bold">Total de Húespedes: {{$total}}</p>

                        </div>
                    </div>
                    <div class="col-sm">
                        <p class="text-center font-weight-bold">Habitaciones Disponibles</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Número</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Capacidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($disponibles as $item)
                                    <tr>
                                        <th scope="row">{{$item['numero']}}</th>
                                        <td>{{$item['tipohabitacion']['nombre']}}</td>
                                        <td>{{$item['tipohabitacion']['precio']}}</td>
                                        <td>{{$item['tipohabitacion']['capacidad']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>