@extends("theme.$theme.layout")

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header font-weight-bold">Lista de Productos</div>
            <div class="card-body">
                <form action="" id="formProducto">
                    @csrf
                    <input type="text" value="producto" id="tipo" name="tipo" hidden>
                </form>
                <div class="row d-flex justify-content-center">
                    <button id="btnGenerar" class="btn btn-outline-danger col-4 mr-1">
                        <i class="fas fa-search"></i>
                        Generar Reporte
                    </button>
                </div>
                <div class="row mb-2" id="btnsReport">
                    <div class="table-responsive mt-4">
                        <table class="table text-center table-hover" id="productostable" class="display"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Categoria</th>
                                    <th>Unidad</th>
                                    <th>Cantidad de Ventas</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Categoria</th>
                                    <th>Unidad</th>
                                    <th>Cantidad de Ventas</th>
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
            var value = $('#tipo').val().trim();
            const data = new FormData(document.getElementById('formProducto'));
            if(value!=''){
                fetch("{{route('reportes_productos_pdf')}}", {
                    method:'POST',
                    body:data
                }).then(res=>res.json())
                .then((data)=>{
                    console.log(data);
                    $('#btnsReport').show();
                        $('#productostable').DataTable( {
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
                                { "data": "nombre" },
                                { "data": "preciocompra" },
                                { "data": "precioventa" },
                                { "data": "categoria" },
                                { "data": "unidad" },
                                { "data": "ventas" },
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
            }
            
        });       
    });
</script>