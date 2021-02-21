@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Generar Reporte de Caja</div>
            <div class="card-body">
                <form id="formCaja">
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
                            <label for="tipo">Según Tipo</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="">Todos</option>
                                <option value="ingreso">Ingreso</option>
                                <option value="egreso">Egreso</option>
                            </select>
                        </div>
                        <div class="form-group col-sm">
                            <label for="user">Usuario</label>
                            <select class="form-control" name="usuario" id="user">
                                <option value="">Todos</option>
                                @foreach ($usuarios as $item)
                                <option value="{{$item['id']}}">{{$item['login']}}</option>
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
                    {{--  <button id="btnPDF" class="btn btn-info mr-2">
                        <i class="fas fa-file-pdf"></i>
                        Exportar a PDF
                    </button>
                    <button id="btnExcel" class="btn btn-success">
                        <i class="fas fa-file-excel"></i>
                        Exportar a Excel</button>
                    <p id="loading" class="font-weight-bold text-info">Espere ...</p> --}}
                    <div class="table-responsive mt-4">
                        <table class="table text-center table-hover" id="cajatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Numero</th>
                                    <th>Tipo</th>
                                    <th>Persona</th>
                                    <th>Total</th>
                                    <th>Modalidad</th>
                                    <th>Concepto</th>
                                    <th>Comentario</th>
                                    <th>Movimiento</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Numero</th>
                                    <th>Tipo</th>
                                    <th>Persona</th>
                                    <th>Total</th>
                                    <th>Modalidad</th>
                                    <th>Concepto</th>
                                    <th>Comentario</th>
                                    <th>Movimiento</th>
                                    <th>Usuario</th>
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
        $('#loading').hide();
        $('#btnGenerar').on('click', function(e){
            $('#dataDiv').html("");
            e.preventDefault();
            const data = new FormData(document.getElementById('formCaja'));
            fetch("{{route('reportes_caja_pdf')}}", {
                method:'POST',
                body:data
            }).then(res=>res.json())
            .then((data)=>{
                $('#btnsReport').show();
                $('#cajatable').DataTable( {
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
                            { "data": "fecha" },
                            { "data": "numero" },
                            { "data": "tipo" },
                            { "data": "persona" },
                            { "data": "total" },
                            { "data": "modalidad" },
                            { "data": "concepto" },
                            { "data": "comentario" },
                            { "data": "movimiento" },
                            { "data": "usuario" },         
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