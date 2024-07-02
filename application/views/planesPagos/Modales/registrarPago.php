<div class="modal fade" id="verPlanPago" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <center><h3 class="modal-title">Plan Pago <span id="nombrePlanPagotxt"></span></h3></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group" >
                                    <label class="control-label">Plan pago</label>
                                    <input type="text" class="form-control input-gral" name="planPago" id="nombrePlanPago"  style="margin-top: 6px" readonly/><!--este input debe de limitarse al numero de planes, apartir de ahí hacer el siguiente-->
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group" >
                                    <label class="control-label">Cliente</label>
                                    <input type="text" class="form-control input-gral" name="nombreCliente" id="nombreCliente"  style="margin-top: 6px" readonly/><!--este input debe de limitarse al numero de planes, apartir de ahí hacer el siguiente-->
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                <div class="form-group" >
                                    <label class="control-label">Monto</label>
                                    <input type="text" class="form-control input-gral" name="montoPlanPago" id="montoPlanPago"  style="margin-top: 6px" readonly/><!--este input debe de limitarse al numero de planes, apartir de ahí hacer el siguiente-->
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group" >
                                    <label class="control-label">Precio Inicial plan</label>
                                    <input type="text" class="form-control input-gral" name="montoInicialPlan" id="montoInicialPlan"  style="margin-top: 6px" readonly/><!--este input debe de limitarse al numero de planes, apartir de ahí hacer el siguiente-->
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group" >
                                    <label class="control-label">Taza interés (anual)</label>
                                    <input type="text" class="form-control input-gral" name="tazaInteresPlanPago" id="tazaInteresPlanPago"  style="margin-top: 6px" readonly/><!--este input debe de limitarse al numero de planes, apartir de ahí hacer el siguiente-->
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group" >
                                    <label class="control-label">Mensualidad</label>
                                    <input type="text" class="form-control input-gral" name="mensualidadPlanPago" id="mensualidadPlanPago"  style="margin-top: 6px" readonly/><!--este input debe de limitarse al numero de planes, apartir de ahí hacer el siguiente-->
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group" >
                                    <label class="control-label">Periodos</label>
                                    <input type="text" class="form-control input-gral" name="periodosPlanPago" id="periodosPlanPago"  style="margin-top: 6px" readonly/><!--este input debe de limitarse al numero de planes, apartir de ahí hacer el siguiente-->
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <!--tabla plan pago-->
                                <div class="material-datatables">
                                    <table class="table-striped table-hover" id="tabla_plan_pago" name="tabla_plan_pago">
                                        <thead>
                                        <tr>
                                            <th>PAGO</th>
                                            <th>CONCEPTO PAGO</th>
                                            <th>FECHA PACTADA</th>
                                            <th>FECHA PAGO</th>
                                            <th>CAPITAL</th>
                                            <th>SALDO CAPITAL</th>
                                            <th>INTERÉS</th>
                                            <th>SALDO INTERÉS</th>
                                            <th>IVA</th>
                                            <th>SALDO IVA</th>
                                            <th>PAGO</th>
                                            <th>SALDO</th>
                                            <th>REGISTRAR</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!--tabla plan pago -->
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar
                </button>
                <button type="submit" id="RequestInformacion" class="btn btn-primary guardarPlan">Guardar</button>
            </div>

        </div>
    </div>
</div>