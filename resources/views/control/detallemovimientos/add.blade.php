@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Agregar Movimiento</div>
            <div class="card-body">
                <a href="{{ route('habitaciones') }}" title="Regresar"><button
                        class="btn btn-outline-secondary btn-sm mb-2"><i class="fa fa-arrow-left"
                            aria-hidden="true"></i>
                        Regresar</button></a>
                <div class="container">
                    <form action="{{'store_detallemovimiento'}}">
                        <input hidden name="movimiento" value="{{$movimientos['id']}}" type="text">
                        <p class="font-weight-bold ">Nuevo Movimiento Producto</p>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="producto">{{'Producto'}}</label>
                                <select class="form-control" name="producto" id="producto">
                                    <option value="">Seleccionar</option>
                                    @foreach ($productos as $item)
                                    <option value="{{$item['id']}}">{{$item['nombre']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm">
                                <label for="cantidad">{{'Cantidad'}}</label>
                                <input class="form-control" type="number" name="cantidad" id="cantidad">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <label for="preciocompra">{{'Precio Compra'}}</label>
                                <input class="form-control" type="number" name="preciocompra" id="preciocompra">
                            </div>
                            <div class="form-group col-sm">
                                <label for="precioventa">{{'Precio Venta'}}</label>
                                <input class="form-control" type="number" name="precioventa" id="precioventa">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comentario">{{'Comentario'}}</label>
                            <textarea class="form-control" name="comentario" id="comentario" cols="10"
                                rows="5"></textarea>
                        </div>
                        <div class="container text-center">
                            <button class="btn btn-outline-success col-6">
                                Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection