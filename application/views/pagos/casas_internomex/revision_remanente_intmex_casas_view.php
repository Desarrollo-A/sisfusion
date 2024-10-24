<div class="tab-pane" id="remanenteCasas">
    <div class="card-content" style="justify-content: space-between">
        <div class="text-center">
            <div class="encabezadoBox">
                <h3 class="card-title center-align">Comisiones nuevas <b>remanente casas</b></h3>
            </div>
            <div>
                <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de remanente distribuible casas)</p>
            </div>
        </div>
        <div class="toolbar">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Disponible:</h4>
                            <p class="input-tot pl-1" name="total_remanente_intmex_casas" id="total_remanente_intmex_casas">$0.00</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Autorizar:</h4>
                            <p class="input-tot pl-1" id="total_autorizar_intmex_casas" name="total_autorizar_intmex_casas">$0.00</p>
                        </div>
                    </div>
                </div>
                <div class="row aligned-row d-flex align-end">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="catalogo_remanente_intmex_casas">Puesto</label>
                            <select name="catalogo_remanente_intmex_casas" id="catalogo_remanente_intmex_casas" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="usuario_remanente_intmexCasas">Usuario</label>
                            <select class="selectpicker select-gral m-0" id="usuario_remanente_intmexCasas" name="usuario_remanente_intmexCasas[]" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                        <div class="form-group w-100">
                            <button type="button" class="btn-gral-data pagar_remanente_casas">Pagar masivamente</button>
                        </div>
                    </div>
                </div>
                <div class="material-datatables">
                    <div class="form-group">
                        <table class="table-striped table-hover" id="tabla_remanente_intmex_casas" name="tabla_remanente_intmex_casas">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID PAGO</th>
                                    <th>PROYECTO</th>
                                    <th>CONDOMINIO</th>
                                    <th>LOTE</th>
                                    <th>REFERENCIA</th>
                                    <th>COSTO CONSTRUCCIÓN</th>
                                    <th>EMPRESA</th>
                                    <th>TOTAL COMISIÓN</th>
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
        </div>
    </div>
</div>
