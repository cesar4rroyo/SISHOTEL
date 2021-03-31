<style>
    .tr_hover{
        color:red;
    }
    .form-group{
        margin-bottom: 8px !important;
    }
    
    </style>
    <div id="divMensajeError{!! $entidad !!}"></div>
    {!! Form::model($notacredito, $formData) !!}	
        {!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
        <div class="row">
            <div class="col-lg-5 col-md-5">
                <!--DATOS VENTA -->
                <div class="row ">
                    <div class="col-md-6 col-lg-6 ">
                        <div class="form-group">
                            {!! Form::label('fecha', 'Fecha', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {!! Form::datetime('fecha', $notacredito->fecha, array('class' => 'form-control input-xs', 'id' => 'fecha', 'readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 ">
                        <div class="form-group">
                            {!! Form::label('lblnumeronota', 'Numero', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {!! Form::text('numeronota', $notacredito->numero, array('class' => 'form-control input-xs', 'id' => 'numeronota', 'readonly' => 'true')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row   py-2 px-1 my-2">
                    <div class="col-md-12 col-lg-12 ">
                        <div class="form-group">
                            {!! Form::label('lblmotivo', 'Motivo', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {!! Form::text('motivo', $notacredito->motivo, array('class' => 'form-control input-xs ', 'id' => 'motivo' , 'readonly'=>true)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 col-lg-12 col-sm-12">
                        {!! Form::label('lblcomentario', 'Comentario', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            {!! Form::textarea('comentario' , $notacredito->comentario, array('class' => 'form-control input-xs ', 'id' => 'comentario', 'rows'=>'2' ,'style'=>'resize:none;' ,'readonly'=> true)) !!}
                        </div>
                    </div>
                </div>
                <!--DATOS VENTA -->
                
                <!--TIPO DE PAGO -->
                <!--TIPO DE PAGO -->
            </div>
            <div class="col-lg-7 col-md-7 ">
                <!--DATOS PRODUCTO -->
                <!--DATOS CLIENTE -->
                <div class="row   px-1  py-1">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="form-group ">
                            {!! Form::label('lbldocref', 'Documento referencia', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
                                <div class="col-lg-12 col-md-12 col-sm-12 input-group">
                                    <div class="col-lg-12 col-sm-12 col-md-12 pr-0">
                                        {!! Form::text('documento',$notacredito->comprobante->numero, array('class' => 'form-control input-xs', 'id' => 'documento' , 'readonly'=>true)) !!}
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
                                        {!! Form::text('persona', $cliente, array('class' => 'form-control input-xs', 'id' => 'persona', 'readonly' => true)) !!}
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
                <!--DATOS CLIENTE -->
            </div>
        </div>
            <div class="row   py-2 px-1 my-2">
                <table class="table table-sm table-condensed table-striped" id="tbDetalle">
                    <thead class="bg-navy">
                        <th class="text-center">Cant.</th>
                        <th class="text-center">Producto/Servicio</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Subtotal</th>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td class="text-center">{{$detalle->cantidad}}</td>
                                @if (!is_null($detalle->producto))
                                    <td class="text-center">{{$detalle->producto->nombre}}</td>
                                @else
                                    <td class="text-center">{{$detalle->servicio->nombre}}</td>
                                @endif
                                <td class="text-center">{{$detalle->precioventa}}</td>
                                <td class="text-center">{{round($detalle->precioventa*$detalle->cantidad, 2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            
                            <td colspan="2"></td>
                            <td class="text-right"><b>TOTAL NOTA CREDITO</b></td>
                            <td class="text-center"><input type="text" class="text-center" readonly='true' id="totalnotacredito" name="totalnotacredito"value="{{number_format($notacredito->total,2)}}"></td>
                        </tr>
                        <tr>
                           
                            <td colspan="2"></td>
                            <td class="text-right"><b>TOTAL DOC. REF</b></td>
                        <td class="text-center"><input type="text" class="text-center" readonly='true' id="total" name="total" value="{{(number_format($notacredito->comprobante->total,2))}}" ></td>
                        </tr>
                        
                    </tfoot>
                </table>
            </div>
            <div class="form-group">
                <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                    {!! Form::button('<i class="fa fa-undo fa-lg"></i> Cancelar', array('class' => 'btn btn-default btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
                </div>
            </div>
      
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function() {
            configurarAnchoModal('1200');
            init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
        }); 
    </script>
