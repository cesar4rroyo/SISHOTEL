@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Caja</div>
            <div class="card-body">
                <div class="btn-gtoup">
                    <a href="{{ route('caja') }}" title="Regresar"><button class="btn btn-primary btn-sm mb-2"><i
                                class="fas fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                </div>
                <div class="container mt-2">
                    <form method="POST" action="{{ route('store_caja') }}" accept-charset="UTF-8"
                        class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm form-group">
                                <label for="fecha">{{'Fecha'}}</label>
                                <input class="form-control" type="date" name="fecha" id="fecha" value="{{$today}}">
                            </div>
                            <div class="col-sm form-group">
                                <label for="numero">{{'Número'}}</label>
                                <input class="form-control" type="number" readonly required value="{{$numero}}"
                                    name="numero" id="numero">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm form-group">
                                <input hidden name="tipo" value="{{"Egreso"}}" type="text">
                                <label for="concepto">{{'Concepto'}}</label>
                                <input class="form-control" hidden type="text" name="concepto" id="concepto"
                                    value="{{2}}">
                                <input class="form-control" readonly type="text" name="concepto_nombre" id="concepto"
                                    value="{{'Cierre de Caja'}}">
                            </div>
                            <div class="col-sm form-group">
                                <label for="total">{{'Total'}}</label>
                                <input class="form-control" readonly type="number" name="total" value="{{$total}}"
                                    id="total">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" id="comentario" cols="5"
                                rows="5"></textarea>
                        </div>
                        <div class="container">
                            <button class="btn btn-outline-success">Cerrar Caja</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection