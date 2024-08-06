<div class="modal fade" id="cancelarPlanPago" >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header hide">
                <center><h3 class="modal-title">Plan Pago <span id="nombrePlanPagoCancelatxt2"></span></h3></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 center-align">
                            <h3>¿Deseas cancelar el plan de pago "<span id="nombrePlanPagoCancelatxt"></span>"?</h3>
                            <p>Se cancelará el plan de pago en NeoData</p>
                            <input type="hidden" id="idLoteCancelado"/>
                            <input type="hidden" id="nombreLoteCancelado"/>
                            <input type="hidden" id="numeroPlanLoteCancelado"/>
                            <input type="hidden" id="idPlanPagoCancelado"/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar
                </button>
                <button type="submit" id="cancelarPP" class="btn btn-primary">Aceptar</button>
            </div>

        </div>
    </div>
</div>