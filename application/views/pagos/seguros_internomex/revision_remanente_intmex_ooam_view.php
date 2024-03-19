<div class="tab-pane" id="proceso-1_ooam">
    <div class="text-center">
        <h3 class="card-title center-align">Comisiones nuevas <b>remanente ooam</b></h3>
        <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de remanente distribuible)</p>
    </div>
    <div class="toolbar">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group d-flex justify-center align-center">
                        <h4 class="title-tot center-align m-0">Disponible:</h4>
                        <p class="input-tot pl-1" name="total_remanenteOoam" id="total_remanenteOoam">$0.00</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group d-flex justify-center align-center">
                        <h4 class="title-tot center-align m-0">Autorizar:</h4>
                        <p class="input-tot pl-1" id="total_autorizarOoam" name="total_autorizarOoam">$0.00</p>
                    </div>
                </div>
            </div>
            <div class="row aligned-row d-flex align-end">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="puesto_ooam">Puesto</label>
                        <select name="puesto_ooam" id="puesto_ooam" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="usuario_ooam">Usuario</label>
                        <select class="selectpicker select-gral m-0" id="usuario_ooam" name="usuario_ooam[]" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                    <div class="form-group w-100">
                        <button type="button" class="btn-gral-data PagarOoam">Pagar masivamente</button>
                    </div>
                </div>
            </div>
            <table class="table-striped table-hover" id="tabla_remanente_ooam" name="tabla_remanente_ooam">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID PAGO</th>
                        <th>PROYECTO</th>
                        <th>CONDOMINIO</th>
                        <th>LOTE</th>
                        <th>REFERENCIA</th>
                        <th>PRECIO DEL LOTE</th>
                        <th>EMPRESA</th>
                        <th>TOTAL DE LA COMPRA</th>
                        <th>PAGO DEL CLIENTE</th>
                        <th>TOTAL A PAGAR</th>
                        <th>TIPO DE VENTA</th>
                        <th>USUARIO</th>
                        <th>RFC</th>
                        <th>PUESTO</th>
                        <th>FECHA DE ENVÍO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
