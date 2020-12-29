@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Caja</div>
            <div class="card-body">
                <div class="btn-gtoup">
                    <a href="{{ route('habitaciones') }}" title="Regresar"><button
                            class="btn btn-primary btn-sm mb-2"><i class="fas fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                </div>
                <div class="container mt-2">
                    <form method="POST" action="{{ route('checkout', $id)}}" accept-charset="UTF-8"
                        class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input hidden type="number" name="habitacion" value="{{$habitacion}}">
                        <div class="row">
                            <div class="form-group col-sm">
                                <label class="control-label" for="fecha">Fecha</label>
                                <input type="date" id="fecha" class="form-control" name="fecha" value="{{$today}}">
                            </div>
                            <div class="col-sm form-group">
                                <?php 
                                    function zero_fill ($valor, $long = 0)
                                        {
                                            return str_pad($valor, $long, '0', STR_PAD_LEFT);
                                        }
                                    $numero = zero_fill(1000 . $id, 8);
                                    ?>
                                <label class="control-label" for="numero">Número</label>
                                <input type="number" readonly class="form-control" name="numero" id="numero"
                                    value="{{$numero}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm {{ $errors->has('concepto') ? 'has-error' : ''}}">
                                <label for="concepto" class="control-label">{{ 'Concepto' }}</label>
                                <select class="form-control" required name="concepto" id="concepto">
                                    <option value="">
                                        {{'Seleccione una opcion'}}
                                    </option>
                                    @foreach ($conceptos as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('concepto', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group col-sm {{ $errors->has('tipo') ? 'has-error' : ''}}">
                                <label for="tipo" class="control-label">{{ 'Tipo' }}</label>
                                <select required class="form-control" name="tipo" id="tipo">
                                    <option value="Ingreso">
                                        {{ 'Ingreso'}}
                                    </option>
                                    <option value="Egreso">Egreso</option>
                                </select>
                                {!! $errors->first('tipo', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group col-sm">
                                <label class="control-label" for="movimiento">Movimiento Nro:</label>
                                <input type="number" readonly class="form-control" name="movimiento" id="movimiento"
                                    value="{{$id}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm {{ $errors->has('persona') ? 'has-error' : ''}}">
                                <label for="persona" class="control-label">{{ 'Personas' }}</label>
                                {{-- <input type="text" id="persona"> --}}
                                <select class="form-control" required name="persona" id="persona_select">
                                    <option value="">{{'Seleccione una opcion'}}</option>
                                    @foreach ($personas as $item)
                                    <option value="{{$item->id}}">
                                        {{$item->nombres}} {{" "}}{{$item->apellidos}}
                                    </option>
                                    @endforeach
                                    @inclue('control.buscador')
                                </select>
                                {!! $errors->first('persona', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="col-sm form-group">
                                <label for="persona" class="control-label">{{ 'Total' }}</label>
                                <input type="number" readonly class="form-control" name="total" id="total"
                                    value="{{ isset($total) ? $total : ''}}">
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('comentario') ? 'has-error' : ''}}">
                            <label for="comentario" class="control-label">{{ 'Comentario' }}</label>
                            <input class="form-control" name="comentario" type="text" id="comentario" value="">
                            {!! $errors->first('comentario', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="container text-center">
                            <button type="submit" class="btn btn-outline-success col-sm-6">
                                Registrar Movimiento
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
{{-- <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
    $("#dias").on('change',function(){
        
       
    });
    document.getElementById("persona").addEventListener("keyup", () => {
            if((document.getElementById("persona").value.length)>=1)
                fetch(`/admin/nombres/buscador?search=${document.getElementById("persona").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("persona_select").innerHTML = html  })
            else
                document.getElementById("persona_select").innerHTML = ""
        })
 })
</script> --}}