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
                                <input class="form-control" type="datetime-local" name="fecha" id="fecha"
                                    value="{{Carbon\Carbon::now()->format('Y-m-d\TH:i')}}">
                            </div>
                            <div class="col-sm form-group">
                                <input type="text" name="tipo" hidden value="{{'Ingreso'}}">
                                <label for="numero">{{'Número'}}</label>
                                <input readonly class="form-control" type="number" value="{{$numero}}" name="numero"
                                    id="numero">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm form-group">
                                <label for="concepto">{{'Concepto'}}</label>
                                <input type="text" hidden name="concepto" id="concepto" value="{{'1'}}">
                                <input readonly class="form-control" type="text" name="concepto_nombre" id="concepto"
                                    value="{{'Apertura de Caja'}}">
                            </div>
                            <div class="col-sm form-group">
                                <label for="total">{{'Total'}}</label>
                                <input required class="form-control" type="number" name="total" id="total">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" id="comentario" cols="5"
                                rows="5"></textarea>
                        </div>
                        <div class="container">
                            <button class="btn btn-outline-success">Apertura Caja</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection