@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Generar Reporte de Reservas</div>
            <div class="card-body">
                <form id="formReservas">
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
                        <div class="form-group col-sm">
                            <label for="situacion">Según Situacion</label>
                            <select class="form-control" name="situacion" id="situacion">
                                <option value="">Todos</option>
                                <option value="Reservado">Reserva Pendiente</option>
                                <option value="Usada">Reserva Utilizada</option>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="sexo">Según Sexo</label>
                            <select class="form-control" name="sexo" id="sexo">
                                <option value="">Todos</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="edad">Rango de Edad</label>
                            <select class="form-control" name="edad" id="edad">
                                <option value="">Todos</option>
                                <option value="r1">De 18-30</option>
                                <option value="r2">De 30-40</option>
                                <option value="r3">De 40-50</option>
                                <option value="r4">De 50-60</option>
                                <option value="r5">De 60-mas</option>
                            </select>
                        </div>
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
                        <table class="table text-center table-hover" id="reservastable" class="display"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Fecha Entrada</th>
                                    <th>Fecha Salida</th>
                                    <th>Persona</th>
                                    <th>Edad</th>
                                    <th>Sexo</th>
                                    <th>Ciudad</th>
                                    <th>Habitación Nro</th>
                                    <th>Tipo de Habitacion</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Fecha Entrada</th>
                                    <th>Fecha Salida</th>
                                    <th>Persona</th>
                                    <th>Edad</th>
                                    <th>Sexo</th>
                                    <th>Ciudad</th>
                                    <th>Habitación Nro</th>
                                    <th>Tipo de Habitacion</th>
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
            const data = new FormData(document.getElementById('formReservas'));
            fetch("{{route('reportes_reservas_pdf')}}", {
                method:'POST',
                body:data
            }).then(res=>res.json())
            .then((data)=>{
                $('#btnsReport').show();
                $('#reservastable').DataTable( {
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
                            { "data": "persona" },
                            { "data": "edad" },
                            { "data": "sexo" },
                            { "data": "ciudad" },
                            { "data": "numero" },
                            { "data": "tipohabitacion" },                       
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
        })
    });
</script>