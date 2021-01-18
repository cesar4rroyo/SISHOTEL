@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Generar Reportes de Check-In</div>
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
                        <div class="form-group col-sm" id="filterReserva">
                            <label for="reserva">Según Reserva</label>
                            <select class="form-control" name="reserva" id="reserva">
                                <option value="">Todas</option>
                                <option value="si">Con Reserva</option>
                                <option value="no">Sin Reserva</option>
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
                    {{-- <button id="btnPDF" class="btn btn-info mr-2">
                        <i class="fas fa-file-pdf"></i>
                        Exportar a PDF
                    </button>
                    <button id="btnExcel" class="btn btn-success">
                        <i class="fas fa-file-excel"></i>
                        Exportar a Excel</button>
                    <p id="loading" class="font-weight-bold text-info">Espere ...</p> --}}
                    <div class="table-responsive mt-4">
                        <table class="table text-center table-hover" id="checkintable" class="display"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Fecha Entrada</th>
                                    <th>Fecha Salida</th>
                                    <th>Habitación Nro</th>
                                    <th>Tipo de Habitacion</th>
                                    <th>Reserva</th>
                                    <th>Comentario</th>
                                    <th>Húespedes</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Fecha Entrada</th>
                                    <th>Fecha Salida</th>
                                    <th>Habitación Nro</th>
                                    <th>Tipo de Habitacion</th>
                                    <th>Reserva</th>
                                    <th>Comentario</th>
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
            $.ajax({
                url: "{{route('reportes_checkin_pdf')}}",
                method:'POST',
                enctype: 'multipart/form-data',
                data:data,
                processData: false,
                contentType: false,
                success: function(response){
                    $('#btnsReport').show();                   
                    $('#checkintable').DataTable( {
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
                        'data': response.data,
                        "columns": [
                            { "data": "fechaingreso" },
                            { "data": "fechasalida" },
                            { "data": "numero" },
                            { "data": "tipohabitacion" },
                            { "data": "reserva" },
                            { "data": "comentario" },
                            { "data": "pasajeros[, ]" },            
                        ],
                        dom: 'lBfrtip',
                        buttons: [
                            'excel', 'pdf', 'print'
                        ],
                        "lengthMenu": [5,10,25,50,100],
                        "bDestroy": true
                    });
                },
                error: function(e){
                    console.log(e);
                }   
            });           
        });
       /*  $('#btnPDF').on('click', function(e){
            e.preventDefault();
            const data = new FormData(document.getElementById('formMovimientos'));
            $.ajax({
                url: "{{route('reportes_checkin_pdf', 'pdf')}}",
                type:'POST',
                enctype: 'multipart/form-data',
                data:data,
                processData: false,
                contentType: false,   
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend:function(){
                    $('#loading').show();
                },
                error: function(e){
                    console.log(e);
                },
                success: function (response, status, xhr) {
                    var filename = "";                   
                    var disposition = xhr.getResponseHeader('Content-Disposition');
                    if (disposition) {
                        var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                        var matches = filenameRegex.exec(disposition);
                        if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                    } 
                    var linkelem = document.createElement('a');
                    try {
                        var blob = new Blob([response], { type: 'application/octet-stream' });                       
                        if (typeof window.navigator.msSaveBlob !== 'undefined') {
                            window.navigator.msSaveBlob(blob, filename);
                        } else {
                            var URL = window.URL || window.webkitURL;
                            var downloadUrl = URL.createObjectURL(blob);

                            if (filename) { 
                                var a = document.createElement("a");
                                if (typeof a.download === 'undefined') {
                                    window.location = downloadUrl;
                                } else {
                                    a.href = downloadUrl;
                                    a.download = filename;
                                    document.body.appendChild(a);
                                    a.target = "_blank";
                                    a.click();
                                }
                            } else {
                                window.location = downloadUrl;
                            }
                        }  
                    } catch (ex) {
                        console.log(ex);
                    } 
                },
                complete:function(){
                    $('#loading').hide();
                }                          
            });            
        });
        
        $('#btnExcel').on('click', function(e){
            e.preventDefault();
            const data = new FormData(document.getElementById('formMovimientos'));
            fetch("{{route('reportes_checkin_pdf', 'excel')}}", {
                method:'POST',
                body:data
            }).then(res=>res.json())
            .catch(e=>console.log(e));
        });   */     
    });
</script>