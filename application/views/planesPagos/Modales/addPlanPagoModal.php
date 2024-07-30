<div class="modal fade" id="addPlanPago" >
    <div class="modal-dialog">
        <div class="modal-content" >
            <form class="card-content" id="formPlanPago" name="formPlanPago" method="POST">
                <div class="modal-header">
                    <center><h3 class="modal-title">Añade plan de pago</h3></center>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div id="infoLoad">

                                    <div class="col col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                        <div class="form-group" >
                                            <label class="control-label">Tipo</label>
                                            <select class="selectpicker selectpicker select-gral" data-style="btn" name="tipoPP" id="tipoPP"
                                                    title="Selecciona un tipo" data-size="7" data-live-search="true">
                                            </select>
                                            <input type="hidden" name="tipoPlanTxtPP" id="tipoPlanTxtPP">
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                        <div class="form-group" >
                                            <label class="control-label">Plan pago</label>
                                            <input type="text" class="form-control input-gral" name="planPago" id="planPago"  style="margin-top: 6px" /><!--este input debe de limitarse al numero de planes, apartir de ahí hacer el siguiente-->
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label class="control-label">Descripción:</label>
                                        <textarea class="form-control input-gral" id="descripcionPlanPago" name="descripcionPlanPago"  rows="1"></textarea>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                        <div class="form-group" >
                                            <label class="control-label">Moneda</label>
                                            <select class="selectpicker selectpicker select-gral" data-style="btn"  id="monedaPP" name="monedaPP"
                                                    title="Selecciona un tipo" data-size="7" data-live-search="true"></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group" >
                                            <label class="control-label">Monto</label>
                                            <input class="form-control input-gral" name="montoPP" id="montoPP"
                                                   data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  step="any" type="text"
                                                   value="" style="margin-top: 6px"/>
                                        </div>
                                    </div>

                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group" >
                                            <label class="control-label">T. interés (anual)</label>
                                            <input type="text" class="form-control input-gral" name="tazaInteresPP" id="tazaInteresPP"  value="" style="margin-top: 6px"/>
                                        </div>
                                    </div>

                                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px">
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                            <div class="form-group" >
                                                <label class="control-label">Prioridad del cálculo</label>
                                                <div class="radio_container">
                                                    <input type="radio" name="tipoNc_valor" id="tipoNc_valor1" class="inputRadio" value="1" checked>
                                                    <label for="tipoNc_valor1" id="labelTipoNc_valor1">Por mensualidad</label>
                                                    <input type="radio" name="tipoNc_valor" id="tipoNc_valor2" class="inputRadio" value="2" >
                                                    <label for="tipoNc_valor2" id="labelTipoNc_valor2">Por Periodos</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px">
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group" >
                                                <label class="control-label">No. periodos</label>
                                                <input type="text" class="form-control input-gral" name="noPeriodosPP" id="noPeriodosPP"  value="" style="margin-top: 6px"/>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group" >
                                                <label class="control-label">Periodicidad</label>
                                                <select class="selectpicker selectpicker select-gral" data-style="btn" name="periocidadPP" id="periocidadPP"
                                                        title="Selecciona un tipo" data-size="7"  data-live-search="true"></select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group" >
                                                <label class="control-label">fecha Inicio</label>
                                                <input type="date" name="fechaInicioPP" id="fechaInicioPP" class="form-control input-gral pr-2 " style="margin-top: 6px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;padding-right: 0px">
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="checkbox" id="interesesSSI" name="interesesSSI" value="1"> Calcular Interés S.S.I
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label style="font-size: 0.9em;">
                                                <input type="checkbox" id="ivaPP" name="ivaPP" class="checkBox" onchange="activarIva(this)" value="1"> Aplicar IVA
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 0px;padding-right: 0px">
                                        <div class="form-group" >
                                            <label class="control-label">Mensualidad</label>
                                            <input class="form-control input-gral" name="mensualidadPP"
                                                   data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  step="any" type="text"
                                                   id="mensualidadPP"  style="color: #ff0000" value=""/>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px">
                                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group" >
                                                <label class="control-label">Monto IVA %</label>
                                                <input type="text" class="form-control input-gral disabledInput" name="porcentajeIvaPP"
                                                       id="porcentajeIvaPP"  style="color: #ff0000" value="" disabled="disabled"/>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group" >
                                                <label class="control-label">Cantidad IVA</label>
                                                <input type="text" class="form-control input-gral disabledInput" name="cantidadIvaPP"
                                                       data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  step="any"
                                                       id="cantidadIvaPP"  style="color: #ff0000" value="" disabled="disabled"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="idLotePP" id="idLotePP">
                    <input type="hidden" name="idClientePP" id="idClientePP">
                    <input type="hidden" name="nombreLotePP" id="nombreLotePP">
                    <input type="hidden" name="idPlanPagoModal" id="idPlanPagoModal">
                    <input type="hidden" name="saldoSiguienteModal" id="saldoSiguienteModal">
                    <!--<button type="button" class="btn btn-simple btn-green" onclick="generarPlanPagoFunction()"> Generar plan </button>-->
                    <button type="button" class="btn btn-danger btn-simple" onclick="cerrarModalAddPlan()"> Cancelar </button>
                    <button type="submit" id="RequestInformacion" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>