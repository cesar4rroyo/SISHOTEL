<style>
    .tr_hover{
        color:red;
    }
    .form-group{
        margin-bottom: 8px !important;
    }
    
    </style>
    <div id="divMensajeError{!! $entidad !!}"></div>
    {!! Form::model($venta, $formData) !!}	
        {!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
        {!! Form::hidden('listDetalles', null, array('id' => 'listDetalles')) !!}
    
        <div class="row">
            <div class="col-lg-5 col-md-5">
                <!--DATOS VENTA -->
                <div class="row ">
                    <div class="col-md-6 col-lg-6 ">
                        <div class="form-group">
                            {!! Form::label('fecha', 'Fecha', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {!! Form::date('fecha',date('Y-m-d'), array('class' => 'form-control input-xs', 'id' => 'fecha', 'readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 ">
                        <div class="form-group">
                            {!! Form::label('lblnumeronota', 'Numero', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {!! Form::text('numeronota', $numero, array('class' => 'form-control input-xs', 'id' => 'numeronota', 'readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row   py-2 px-1 my-2">                   
                    <div class="col-md-12 col-lg-12 ">
                        <div class="form-group">
                            {!! Form::label('lblmotivo', 'Motivo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {!! Form::text('motivo', null, array('class' => 'form-control input-xs', 'id' => 'motivo')) !!}
                            </div>
                        </div>
                    </div>
                </div>
               
                <!--DATOS VENTA -->
                
              
                <!--TIPO DE PAGO -->
            </div>
            <div class="col-lg-7 col-md-7 ">
                <!--DATOS PRODUCTO -->
                <!--DATOS CLIENTE -->
                <div class="row   px-1  py-2">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="form-group ">
                            {!! Form::label('lbldocref', 'Documento referencia', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                                <div class="col-lg-12 col-md-12 col-sm-12 input-group">
                                    {!! Form::hidden('documento_id', 0, array('id' => 'documento_id')) !!}
                                    <div class="col-lg-12 col-sm-12 col-md-12 pr-0">
                                        {!! Form::select('documento',null,null, array('class' => 'form-control input-xs', 'id' => 'documento')) !!}
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row   px-1 my-2">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="form-group ">
                            {!! Form::label('persona', 'Cliente', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                                <div class="col-lg-12 col-md-12 col-sm-12 input-group">
                                    {!! Form::hidden('persona_id', 0, array('id' => 'persona_id')) !!}
                                    <div class="col-lg-12 col-sm-12 col-md-12 pr-0">
                                        {!! Form::text('persona', null, array('class' => 'form-control input-xs', 'id' => 'persona', 'readonly' => true)) !!}
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
                <!--DATOS CLIENTE -->
            </div>            
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                {!! Form::label('lblcomentario', 'Comentario', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                <div class="col-lg-12 col-md-12 col-sm-12">
                    {!! Form::textarea('comentario',null, array('class' => 'form-control input-xs ', 'id' => 'comentario', 'rows'=>'2' ,'style'=>'resize:none;')) !!}
                </div>
            </div>
        </div>

        <div class="row py-2 px-1 my-2">
            <table class="table table-sm table-condensed table-striped" id="tbDetalle">
                <thead class="bg-navy">
                    <th class="text-center">Cant.</th>
                    <th class="text-center">Producto/Servicio</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center">Quitar</th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-right"><b>TOTAL NOTA CREDITO</b></td>
                        <td class="text-center"><input type="text" class="text-center" id="totalnotacredito" name="totalnotacredito"></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-right"><b>TOTAL DOC. REF</b></td>
                        <td class="text-center"><input type="text" class="text-center" readonly='true' id="total" name="total" ></td>
                    </tr>

                </tfoot>
            </table>
        </div>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                {!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-primary btn-sm', 'id' => 'btnGuardar', 'onclick' => '$(\'#listDetalles\').val(carro);guardarPago(\''.$entidad.'\', this);')) !!}
                {!! Form::button('<i class="fa fa-undo fa-lg"></i> Cancelar', array('class' => 'btn btn-default btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
            </div>
        </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function() {
            configurarAnchoModal('1200');
            init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
            $('#documento').select2({
                dropdownParent: $("#modal"+(contadorModal-1)),
                minimumInputLenght: 2,
                ajax: {
                    url: "notacredito/documentoautocompletar",
                    dataType: 'json',
                    delay: 250,
                    data: function(params){
                        return{
                            q: $.trim(params.term),
                        };
                    },
                    processResults: function(data){
                        return{
                            results: data
                        };
                    }
                    
                }
            });
        }); 
        
		 $('#documento').on('change',function(){
             let idmovimiento = $('#documento').val();
            $.ajax({
                url: "notacredito/obtenerCliente",
                type: 'GET',
                data: {idmovimiento : idmovimiento},
                success: function (respuesta) {
                    // console.log(respuesta);
                    $('#documento_id').val(respuesta.id);
                    $('#persona').val(respuesta.cliente);
                    $('#total').val(parseFloat(respuesta.total).toFixed(2));
                    $('#totalnotacredito').val(parseFloat(respuesta.total).toFixed(2));
                    $('#numeronota').val(respuesta.numero);
                    agregarDetalles(respuesta.detalles);
                    console.log(respuesta.detalles);
                    cantidadDetallesVenta = respuesta.detalles.length;
                    // $nro_doc = respuesta[0]['nro_doc'];
                    // $direccion = respuesta[0]['direccion'];
                    // $correo = respuesta[0]['correo'];
                    // $telefono = respuesta[0]['telefono'];
                    
                    //     $('input#doccliente').val($nro_doc).attr('readonly',true);
                    //     $('input#direccioncliente').val($direccion).attr('readonly',true);
                    //     $('input#telefono').val($telefono).attr('readonly',true);
                    //     $('input#email').val($correo).attr('readonly',true);
                },
                error:function(e){
                    console.log(e);
                }
            });
		});
        var carro = new Array();
        var cantidadDetallesVenta = 0;
        function agregarDetalles(detalles){
            carro = new Array();
            //Eliminar los detalles de posible venta seleccionada anteriormente
            $("#tbDetalle tbody tr").each(function () {
                $(this).remove();
            });
            //Agregar detalles de venta seleccionada en este momento
            detalles.forEach(detalle => {
                let subtotal = (detalle['preciocompra']*detalle['cantidad']).toFixed(2);
                console.log(detalle);
                if(detalle['producto_id']!=null){
                    var bien = detalle['producto']['nombre'];
                    console.log(detalle['producto']['nombre']);
                }else{
                    var bien = detalle['servicios']['nombre'];
                    console.log(bien);
                }
                let fila = `<tr id='filaDetalle${detalle['id']}'>
                            <td class='text-center'>${detalle['cantidad']}</td>
                            <td class='text-center'>${bien}</td>
                            <td class='text-center'>${detalle['preciocompra']}</td>
                            <td class='text-center'>${[subtotal]}</td>
                            <td class='text-center'><a onclick="quitar(${detalle['id']} , ${subtotal} )"><i class='fa fa-minus-circle' title='Quitar' width='20px' height='20px'></i></a></td>
                        </tr>`;
                $('#tbDetalle').append(fila);
                carro.push(detalle['id']);
            });
            console.log(carro);
        }
        function quitar(id , subtotal){
            //Eliminar del carrito
            let pos = carro.indexOf(id);
            carro.splice(pos,1);
            //Eliminar de la tabla
            $('#filaDetalle'+id).remove();
            //Restar monto eliminado del total
            let totalnotac = $('#totalnotacredito').val();
            let total =( parseFloat(totalnotac) - subtotal ).toFixed(2);
            $('#totalnotacredito').val(total);
            console.log(carro);
        }
    var contador=0;
    function guardarPago (entidad, idboton) {
        var band=true;
        var msg="";
    
        // if(carro.length == cantidadDetallesVenta){
        if(carro.length == 0){
            msg += " *La nota de credito no tiene detalles \n";   
            band = false;
        }
        
        // if($("#motivo").val() == '' || $("#motivo").val() == 0  ){
        //     band = false;
        //     msg += " *Seleccione el motivo\n";
        // }
        // if($("#comentario").val() == ''){
        //     band = false;
        //     msg += " *Es necesario ingresar un comentario\n";
        // }
        if(band && contador==0){
            contador=1;
            var idformulario = IDFORMMANTENIMIENTO + entidad;
            var data         = submitForm(idformulario);
            var respuesta    = '';
            var error = '';
            var btn = $(idboton);
            btn.button('loading');
            data.done(function(msg) {
                respuesta = msg;
            }).fail(function(xhr, textStatus, errorThrown) {
                respuesta = 'ERROR';
                contador=0;
            }).always(function() {
                btn.button('reset');
                contador=0;
                if(respuesta === 'ERROR'){
                    console.log(error);
                }else{
                  //alert(respuesta);
                    var dat = JSON.parse(respuesta);
                    if(dat[0]!==undefined){
                        resp=dat[0].respuesta;    
                    }else{
                        resp='VALIDACION';
                    }
                    
                    if (resp === 'OK') {
                        console.log('bien');
                        if(dat[0].tipodocumento_id!="5"){
                            console.log('DECLARAR');
                            var funcion='enviarNotaCredito';
                            var id_venta = dat[0].venta_id;                            
                            $.ajax({
                                        type:'GET',
                                        url:'http://localhost:81/clifacturacion/controlador/contComprobante.php?funcion='+funcion,
                                        //url:'http://localhost/clifacturacion/controlador/contComprobante.php?funcion='+funcion,
                                        data:"idventa="+id_venta+ "&id_serie="+"4"+"&_token="+ $('input[name=_token]').val(),
                                        success: function(r){
                                            //window.open('http://192.168.0.200:81/hotel/public/admin/movimiento/pdf/nota'+'/'+id_venta, "_blank"); 
                                            window.open('http://localhost:81/hotel/public/admin/movimiento/pdf/nota'+'/'+id_venta, "_blank"); 
                                           // location.reload();
                                            console.log(r);
                                        },
                                        error: function(e){
                                            console.log(e.message);
                                            //window.open('http://192.168.0.200:81/hotel/public/admin/movimiento/pdf/nota'+'/'+id_venta, "_blank"); 
                                            window.open('http://localhost:81/hotel/public/admin/movimiento/pdf/nota'+'/'+id_venta, "_blank"); 
                                          //  location.reload();
                                        }
                                    });  
                            
                        }
                        cerrarModal();
                        buscarCompaginado('', 'Accion realizada correctamente', entidad, 'OK');
                        //window.open('/juanpablo/ticket/pdfComprobante3?ticket_id='+dat[0].ticket_id,'_blank')
                    } else if(resp === 'ERROR') {
                        toastr.error(dat[0].msg , 'Error');
                    } else {
                        mostrarErrores(respuesta, idformulario, entidad);
                    }
                }
            });
        }else{
            toastr.error(msg , "Corrige los siguientes errores");
        }
    }
    </script> 