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
                                        <label class="form-check-label" for="depositoefectivo">Deposito y Efectivo</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="depositotarjeta" name="modalidadpago" id="depositotarjeta">
                                        <label class="form-check-label" for="depositotarjeta">Depósito y Tarjeta</label>
                                    </div>
                                </div>
                                <div class="col-sm" id="modalidadPago">
                                    <div class="form-group efectivo box">
                                        <label for="txtEfectivo">Efectivo</label>
                                        <input class="form-control" type="number" name="txtEfectivoSolo" id="txtEfectivo">
                                    </div>
                                    <div class="form-group tarjeta box">
                                        <label for="txtTarjeta">Tarjeta Cantidad</label>
                                        <input class="form-control" type="number" name="txtTarjetaSolo" id="txtTarjeta">
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
                                        <label for="txtDeposito">Deposito</label>
                                        <input class="form-control" type="number" name="txtDepositoSolo" id="txtDeposito">
                                    </div>
                                    <div class="depositoefectivo box">
                                        <div class="form-group">
                                            <label for="txtDeposito2">Deposito</label>
                                            <input class="form-control" type="number" name="txtDepositoEfectivo" id="txtDeposito2">
                                        </div>
                                        <div class="form-group">
                                            <label for="txtEfectivo2">Efectivo</label>
                                            <input class="form-control" type="number" name="txtEfectivoDeposito" id="txtEfectivo2">
                                        </div>                                        
                                    </div>
                                    <div class="depositotarjeta box">
                                        <div class="form-group">
                                            <label for="txtDeposito3">Deposito</label>
                                            <input class="form-control" type="number" name="txtDepositoTarjeta" id="txtDeposito3">
                                        </div>
                                        <div class="form-group">
                                            <label for="txtTarjeta2">Tarjeta</label>
                                            <input class="form-control" type="number" name="txtTarjetaDeposito" id="txtTarjeta2">
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
                                            <label for="txtEfectivo3">Efectivo</label>
                                            <input class="form-control" type="number" name="txtEfectivoTarjeta" id="txtEfectivo3">
                                        </div>
                                        <div class="form-group">
                                            <label for="txtTarjeta3">Tarjeta</label>
                                            <input class="form-control" type="number" name="txtTarjetaEfectivo" id="txtTarjeta3">
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