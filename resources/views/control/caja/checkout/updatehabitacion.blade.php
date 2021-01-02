@extends("theme.$theme.layout")

@section('content')
{{-- {{dd($movimiento)}} --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Generación de Comprobante</div>
            <div class="card-body">
                <div class="container">
                    <form action="{{route('actualizarHabitacion', $habitacion)}}" method="POST">
                        @csrf
                        {{-- <input readonly class="form-control" type="number" name="habitacion" value="{{$habitacion}}">
                        --}}
                        <div class="container text-center">
                            <div class="row">
                                <div class="col-sm form-group">
                                    <label for="tipodocumento" class="control-label">{{ 'Tipo Documento' }}</label>
                                    <select class="form-control" name="tipodocumento" id="tipodocumento">
                                        <option value="">Seleccione una opción</option>
                                        <option value="boleta">Boleta</option>
                                        <option value="factura">Factura</option>
                                        <option value="ticket">Ticket</option>
                                    </select>
                                </div>
                                <div class="col-sm form-group">
                                    <label for="fecha" class="control-label">{{ 'Fecha' }}</label>
                                    <input readonly class="form-control" name="fecha" type="datetime-local" id="fecha"
                                        value="{{Carbon\Carbon::now()->format('Y-m-d\TH:i')}}">
                                </div>
                                <div class="col-sm form-group">
                                    <label for="numero" class="control-label">{{ 'Número' }}</label>
                                    <input readonly class="form-control" name="numero" type="number" id="numero"
                                        value="{{$numero}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm form-group">
                                    <label for="total" class="control-label">{{ 'Total' }}</label>
                                    <input readonly class="form-control" name="total" type="number" id="total"
                                        value="{{$total}}">
                                </div>
                                <div class="col-sm form-group">
                                    <label for="igv" class="control-label">{{ 'IGV' }}</label>
                                    <input readonly class="form-control" name="igv" type="number" id="igv"
                                        value="{{$igv}}">
                                </div>
                                <div class="col-sm form-group">
                                    <label for="subtotal" class="control-label">{{ 'Sub Total' }}</label>
                                    <input readonly class="form-control" name="subtotal" type="number" id="subtotal"
                                        value="{{$subtotal}}">
                                </div>
                                <input type="text" name="movimiento" hidden value="{{$id}}">
                            </div>
                            <div class="form-group">
                                <label for="comentario" class="control-label">{{'Comentario'}}</label>
                                <textarea class="form-control" name="comentario" id="comentario" cols="5"
                                    rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-success col-sm-6 mt-2">
                                Generar Comprobante
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