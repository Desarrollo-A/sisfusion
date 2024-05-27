<div class=" hide cartSolicitar_aticipo" id="cartSolicitar_aticipo" name="cartSolicitar_aticipo">
    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- <div class="card"> -->
        <div class="card-content">
        </div>
        <div class="card-content">
            <div class="encabezadoBox">
                <h3 class="card-title center-align">Formulario para alta de adelanto</h3>
                <p class="card-title pl-1">
                    (Información necesaria para el adelanto de pagos)
                </p>
            </div>
            <div class="toolbar">
                <div class="container-fluid p-0">
                    <form method="post" id="anticipo_nomina">
                        <div class="row form-group">
                            <div class="col-md-6 form-group m-0">
                                <label class="control-label">Monto </label>
                                <input type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" id="montoSolicitado"  name="montoSolicitado"  class="form-control input-gral"

                                data-type="currency" maxlength="10" 
                                oncopy="return false" 
                                onpaste="return false"
                                oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                                onkeypress="return onlyNumbers(event)"
                                required>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6  form-group m-0">
                            <label class="control-label">Descripción del motivo</label>
                                <select class="selectpicker select-gral m-0" name="procesoTipo" id="procesoTipo" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body">
                                    <option value="1">Préstamo</option>
                                    <option value="0">Apoyo</option>
                                </select>
                            </div>
                            
                            <div id="n_parcialidades" name="n_parcialidades" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group overflow-hidden">
                                        <label class="control-label" for="proyecto">Número de Pagos Parcialidad </label>
                                        <select class="selectpicker select-gral m-0 input-gral" name="numeroPagosParcialidad" id="numeroPagosParcialidad" data-style="btn" data-show-subtext="true"  title="SELECCIONA UN NÚMERO" data-size="7" data-live-search="true" data-container="body" >
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                        </select>
                                    </div> 
                            </div>
                            <div id="monto_pago_parcialidades" name ="monto_pago_parcialidades" 
                                class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group overflow-hidden">
                                    <label class="control-label" for="proyecto">Monto Pago Parcialidad</label>
                                    <input class="form-control m-0 input-gral" name="montoPrestadoParcialidad" id="montoPrestadoParcialidad" readonly>
                                </div>
                            </div>    
                            <div class="col-xs-6 col-sm-6 col-md-6 form-group m-0">
                                <label class="control-label">Descripción del motivo</label>
                                <textarea class="text-modal" type="text" name="descripcionMotivo" id="descripcionMotivo" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                            </div>
                            <div class="col-lg-6 form-group m-0"></div>
                            <br>
                            <div class="col-lg-12 form-group m-0">

                                <button type="submit" class="btn btn-primary btn_alta" id="btn_alta" name="btn_alta">Enviar solicitud</button>
                            </div>
                    </form>
                        </div>
                </div>
            </div>
        <!-- </div> -->
        </div>
    </div>
</div>