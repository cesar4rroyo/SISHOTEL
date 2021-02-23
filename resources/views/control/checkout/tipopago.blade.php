<hr>
                        <p class=" font-weight-bold text-uppercase">TIPO DE PAGO</p>
                        <hr>
                        <div class="container mb-3">
                            <div class="row">
                                <div class="col-sm">                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="efectivo" name="modalidadpago" id="efectivo">
                                        <label class="form-check-label" for="efectivo">Efectivo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="tarjeta" name="modalidadpago" id="tarjeta">
                                        <label class="form-check-label" for="tarjeta">Tarjeta</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="deposito" name="modalidadpago" id="deposito">
                                        <label class="form-check-label" for="deposito">Depósito</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="efectivotarjeta" name="modalidadpago" id="efectivotarjeta">
                                        <label class="form-check-label" for="efectivotarjeta">Efectivo y Tarjeta</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="depositoefectivo" name="modalidadpago" id="depositoefectivo">
                                        <label class="form-check-label" for="depositoefectivo">Depósito y Efectivo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="depositotarjeta" name="modalidadpago" id="depositotarjeta">
                                        <label class="form-check-label" for="depositotarjeta">Depósito y Tarjeta</label>
                                    </div>
                                </div>
                                <div class="col-sm" id="modalidadPago">
                                    <div class="form-group efectivo box">
                                        <label for="txtEfectivo">Importe en Efectivo</label>
                                        <input class="form-control" type="number" step="0.01" name="txtEfectivoSolo" id="txtEfectivo">
                                    </div>
                                    <div class="form-group tarjeta box">
                                        <label for="txtTarjeta">Importe en Tarjeta</label>
                                        <input class="form-control" type="number" step="0.01" name="txtTarjetaSolo" id="txtTarjeta">
                                        <br>
                                        <label>Tipo Tarjeta</label>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="visa" name="tipotarjetaSolo">
                                            <label class="form-check-label">
                                                <i class="fab fa-cc-visa" style="font-size: 2rem" ></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="master" name="tipotarjetaSolo">
                                            <label class="form-check-label">
                                                <i class="fab fa-cc-mastercard" style="font-size: 2rem"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="otro" name="tipotarjetaSolo">
                                            <label class="form-check-label">Otro</label>
                                        </div>

                                    </div>
                                    <div class="form-group deposito box">
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="txtDeposito">Importe</label>
                                                <input class="form-control" type="number" step="0.01" name="txtDepositoSolo" id="txtDeposito">
                                            </div>
                                            <div class="col-sm">
                                                <label for="txtFechaSoloDeposito">Fecha Depósito</label>
                                                <input class="form-control" type="date" name="txtFechaSoloDeposito" id="txtFechaSoloDeposito">
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="txtNroOperacionSolo">Nro. Operación</label>
                                                <input class="form-control" type="number" name="txtNroOperacionSolo" id="txtNroOperacionSolo">
                                            </div>
                                            <div class="col-sm">
                                                <label for="txtNombreBancoSolo">Nombre Banco</label>
                                                <input class="form-control" type="text" name="txtNombreBancoSolo" id="txtNombreBancoSolo">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="imgDepositoSolo">Imagen Depósito</label>
                                                <input class="form-control"  type="file" name="imgDepositoSolo" id="imgDepositoSolo" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="depositoefectivo box">
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="txtDeposito2">Importe en depósito</label>
                                                <input class="form-control" type="number" step="0.01" name="txtDepositoEfectivo" id="txtDeposito2">
                                            </div>
                                            <div class="col-sm">
                                                <label for="txtFechaDepositoEfectivo">Fecha Depósito</label>
                                                <input class="form-control" type="date" name="txtFechaDepositoEfectivo" id="txtFechaDepositoEfectivo">
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="txtNroOperacionEfectivo">Nro. Operación</label>
                                                <input class="form-control" type="number" name="txtNroOperacionEfectivo" id="txtNroOperacionEfectivo">
                                            </div>
                                            <div class="col-sm">
                                                <label for="txtNombreBancoEfectivo">Nombre Banco</label>
                                                <input class="form-control" type="text" name="txtNombreBancoEfectivo" id="txtNombreBancoEfectivo">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="imgDepositoEfectivo">Imagen Depósito</label>
                                                <input class="form-control"  type="file" name="imgDepositoEfectivo" id="imgDepositoEfectivo" accept="image/*">
                                            </div>
                                        </div>
                                        <hr>                                   
                                        <div class="row">
                                            <div class="cols-m">
                                                <div class="form-group">
                                                    <label for="txtEfectivo2">Importe en Efectivo</label>
                                                    <input class="form-control" type="number" step="0.01" name="txtEfectivoDeposito" id="txtEfectivo2">
                                                </div>  
                                            </div>
                                        </div>                                      
                                    </div>
                                    <div class="depositotarjeta box">
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="txtDeposito3">Importe en depósito</label>
                                                <input class="form-control" type="number" step="0.01" name="txtDepositoTarjeta" id="txtDeposito3">
                                            </div>
                                            <div class="col-sm">
                                                <label for="txtFechaDepositoTarjeta">Fecha Depósito</label>
                                                <input class="form-control" type="date" name="txtFechaDepositoTarjeta" id="txtFechaDepositoTarjeta">
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="txtNroOperacionTarjeta">Nro. Operación</label>
                                                <input class="form-control" type="number" name="txtNroOperacionTarjeta" id="txtNroOperacionTarjeta">
                                            </div>
                                            <div class="col-sm">
                                                <label for="txtNombreBancoTarjeta">Nombre Banco</label>
                                                <input class="form-control" type="text" name="txtNombreBancoTarjeta" id="txtNombreBancoTarjeta">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm">
                                                <label for="imgDepositoTarjeta">Imagen Depósito</label>
                                                <input class="form-control"  type="file" name="imgDepositoTarjeta" id="imgDepositoTarjeta" accept="image/*">
                                            </div>
                                        </div>
                                        <hr>                                       
                                        <div class="form-group">
                                            <label for="txtTarjeta2">Importe en Tarjeta</label>
                                            <input class="form-control" type="number" step="0.01" name="txtTarjetaDeposito" id="txtTarjeta2">
                                        </div>
                                        <br>
                                        <label>Tipo Tarjeta</label>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="visa" name="tipotarjetaDeposito">
                                            <label class="form-check-label">
                                                <i class="fab fa-cc-visa" style="font-size: 2rem" ></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="master" name="tipotarjetaDeposito">
                                            <label class="form-check-label">
                                                <i class="fab fa-cc-mastercard" style="font-size: 2rem"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="otro" name="tipotarjetaDeposito">
                                            <label class="form-check-label">Otro</label>
                                        </div>
                                    </div>
                                    <div class="efectivotarjeta box">
                                        <div class="form-group">
                                            <label for="txtEfectivo3">Importe en Efectivo</label>
                                            <input class="form-control" type="number" step="0.01" name="txtEfectivoTarjeta" id="txtEfectivo3">
                                        </div>
                                        <div class="form-group">
                                            <label for="txtTarjeta3">Importe en Tarjeta</label>
                                            <input class="form-control" type="number" step="0.01" name="txtTarjetaEfectivo" id="txtTarjeta3">
                                        </div>
                                        <br>
                                        <label>Tipo Tarjeta</label>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="visa" name="tipotarjetaEfectivo">
                                            <label class="form-check-label">
                                                <i class="fab fa-cc-visa" style="font-size: 2rem" ></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="master" name="tipotarjetaEfectivo">
                                            <label class="form-check-label">
                                                <i class="fab fa-cc-mastercard" style="font-size: 2rem"></i>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input tarjetatipo" type="radio" value="otro" name="tipotarjetaEfectivo">
                                            <label class="form-check-label">Otro</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function(event) {
                                                        
                            $('#txtEfectivo3').on('change', function(){
                                    var total = $('#total').val();
                                    var efectivo = $('#txtEfectivo3').val();
                                    var tarjeta = total - efectivo;
                                    $('#txtTarjeta3').val(tarjeta);
                            });
                            $('#txtTarjeta3').on('change', function(){
                                    var total = $('#total').val();
                                    var tarjeta = $('#txtTarjeta3').val();
                                    var efectivo = total - tarjeta;
                                    $('#txtEfectivo3').val(efectivo);
                            });
                            $('#txtDeposito2').on('change', function(){
                                    var total = $('#total').val();
                                    var deposito = $('#txtDeposito2').val();
                                    var efectivo = total - deposito;
                                    $('#txtEfectivo2').val(efectivo);
                            });
                            $('#txtEfectivo2').on('change', function(){
                                    var total = $('#total').val();
                                    var efectivo = $('#txtEfectivo2').val();
                                    var deposito = total - efectivo;
                                    $('#txtDeposito2').val(deposito);
                            });
                            $('#txtDeposito3').on('change', function(){
                                    var total = $('#total').val();
                                    var deposito = $('#txtDeposito3').val();
                                    var tarjeta = total - deposito;
                                    $('#txtTarjeta2').val(tarjeta);
                            });
                            $('#txtTarjeta2').on('change', function(){
                                    var total = $('#total').val();
                                    var tarjeta = $('#txtTarjeta2').val();
                                    var deposito = total - tarjeta;
                                    $('#txtDeposito3').val(deposito);
                            });
                             
                         })
                        </script>