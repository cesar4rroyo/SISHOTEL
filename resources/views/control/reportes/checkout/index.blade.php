@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Generar Reportes de Check-Out</div>
            <div class="card-body">
                <form id="formMovimientos">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="from">Inicio</label>
                            <input class="form-control" value="{{$today}}" type="date" name="from" id="from">
                        </div>
                        <div class="form-group col-sm">
                            <label for="to">Fin</label>
                            <input class="form-control" value="{{$today}}" type="date" name="to" id="to">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="habitacion">Habitación</label>
                            <select class="form-control" name="habitacion" id="habitacion">
                                <option value="">Todas</option>
                                @foreach ($habitaciones as $item)
                                <option value="{{$item['id']}}">
                                    {{$item['numero'] . " - " . $item['tipohabitacion']['nombre']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="servicio">Según Servicios</label>
                            <select class="form-control" name="servicio" id="servicio">
                                <option value="">Todos</option>
                                <option value="early_checkin">Early Check-In</option>
                                <option value="late_checkout">Late Check-Out</option>
                                <option value="day_use">Day Use</option>
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="descuento">Según el Descuento</label>
                            <select class="form-control" name="descuento" id="descuento">
                                <option value="">Todos</option>
                                <option value="si">Con Descuento</option>
                                <option value="no">Sin Descuento</option>
                            </select>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <button id="btnGenerar" class="btn btn-outline-danger col-4 mr-1">
                            <i class="fas fa-search"></i>
                            Generar Reporte
                        </button>
                    </div>
                </form>
                <div class="row mb-2" id="btnsReport">
                    <div class="table-responsive mt-4">
                        <table class="table text-center table-hover" id="checkouttable" class="display"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Fecha Entrada</th>
                                    <th>Fecha Salida</th>
                                    <th>Habitación Nro</th>
                                    <th>Tipo de Habitacion</th>
                                    <th>Total</th>
                                    <th>Early Check In</th>
                                    <th>Late Check Out</th>
                                    <th>Day Use</th>
                                    <th>Húespedes</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Fecha Entrada</th>
                                    <th>Fecha Salida</th>
                                    <th>Habitación Nro</th>
                                    <th>Tipo de Habitacion</th>
                                    <th>Total</th>
                                    <th>Early Check In</th>
                                    <th>Late Check Out</th>
                                    <th>Day Use</th>
                                    <th>Húespedes</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        $('#btnsReport').hide();
        $('#btnGenerar').on('click', function(e){
            e.preventDefault();
            const data = new FormData(document.getElementById('formMovimientos'));
            fetch("{{route('reportes_checkout_pdf')}}", {
                method:'POST',
                body:data
            }).then(res=>res.json())
            .then((data)=>{
                $('#btnsReport').show();
                $('#checkouttable').DataTable( {
                        "language": {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                            "buttons":{
                                'excel':'Exportar a Excel',
                                'pdf':'Exportart a PDF',
                                'print':'Imprimir'
                            }
                        },
                        "processing": true,
                        'data': data.data,
                        "columns": [
                            { "data": "fechaingreso" },
                            { "data": "fechasalida" },
                            { "data": "numero" },
                            { "data": "tipohabitacion" },
                            { "data": "total" },
                            { "data": "early_checkin" },
                            { "data": "late_checkout" },
                            { "data": "day_use" },
                            { "data": "pasajeros" },         
                        ],
                        dom: 'lBfrtip',
                        buttons: [
                            'excel', 'pdf', 'print'
                        ],
                        "lengthMenu": [5,10,25,50,100],
                        "bDestroy": true
                    });
            })
            .catch(e=>console.log(e));
        });       
    });
</script>