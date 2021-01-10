@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="modal-header">
                <a href="{{route('comprobantes')}}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Regresar</button>
                </a>
                <h5 class="modal-title" id="exampleModalLabel">Comprobante Nro: {{$comprobante['numero']}} </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm form-group">
                        <label for="fecha">Fecha Emisión</label>
                        <input class="form-control" type="date" readonly id="fecha" name="fecha"
                            value="{{$comprobante['fecha']}}">
                    </div>
                    <div class="col-sm form-group">
                        <label for="tipo">Tipo Doc.</label>
                        <input class="form-control text-capitalize" value="{{$comprobante['tipodocumento']}}"
                            type="text" readonly id="tipo" name="tipo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm form-group">
                        <label for="total">Total</label>
                        <input class="form-control" type="number" value="{{$comprobante['total']}}" readonly id="total"
                            name="total">
                    </div>
                    <div class="col-sm form-group">
                        <label for="igv">IGV</label>
                        <input class="form-control" type="number" value="{{$comprobante['igv']}}" readonly id="igv"
                            name="igv">
                    </div>
                    <div class="col-sm form-group">
                        <label for="subtotal">Subtotal</label>
                        <input class="form-control" type="number" value="{{$comprobante['subtotal']}}" readonly
                            id="subtotal" name="subtotal">
                    </div>
                </div>
                <div class="form-group">
                    <label for="comentario">{{'Comentario'}}</label>
                    <textarea readonly class="form-control" name="" id="comentario" cols="3"
                        rows="3">{{$comprobante['comentario']}}</textarea>
                </div>
                <hr>
                <p class="font-weight-bold">Datos de la Persona</p>
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="nombres">Nombres</label>
                        <input class="form-control" type="text"
                            value="{{!is_null($comprobante['persona'])?$comprobante['persona']['nombres']:'Varios'}}"
                            readonly id="nombres" name="nombres">
                    </div>
                    <div class="form-group col-sm">
                        <label for="apellidos">Apellidos</label>
                        <input class="form-control" type="text"
                            value="{{!is_null($comprobante['persona']['apellidos'])?$comprobante['persona']['apellidos']:'-'}}"
                            readonly id="apellidos" name="apellidos">
                    </div>
                    <div class="form-group col-sm">
                        <label for="dni">DNI</label>
                        <input class="form-control" type="text"
                            value="{{!is_null($comprobante['persona']['dni'])?$comprobante['persona']['dni']:'-'}}"
                            readonly id="dni" name="dni">
                    </div>
                    <div class="form-group col-sm">
                        <label for="dni">RUC</label>
                        <input class="form-control" type="text"
                            value="{{!is_null($comprobante['persona']['ruc'])?$comprobante['persona']['ruc']:'-'}}"
                            readonly id="dni" name="dni">
                    </div>
                </div>
                <hr>
                <p class="font-weight-bold">Detalle Movimientos</p>
                <div class="row">
                    <div class="container">
                        <table class="table text-center table-hover" id="table-content">
                            <thead>
                                <tr>
                                    <th>Producto/Servicio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{dd($detalles)}} --}}
                                @foreach ($detalles as $item)
                                <tr>
                                    @if (!is_null($item['producto_id']))
                                    <td>{{$item['producto']['nombre']}}</td>
                                    @else
                                    <td>{{$item['servicios']['nombre']}}</td>
                                    @endif
                                    <td>{{$item['cantidad']}}</td>
                                    <td>{{$item['precioventa']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="">
                    <button type="button" class="btn btn-primary">Imprimir</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection