<div class="tab-pane" id="remanenteSeguros">
    <div class="card-content" style="justify-content: space-between">
        <div class="text-center">
            <div class="encabezadoBox">
                <h3 class="card-title center-align">Comisiones nuevas <b>remanente seguros</b></h3>
            </div>
            <div>
                <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de remanente distribuible)</p>
            </div>
        </div>
        <div class="toolbar">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Disponible:</h4>
                            <p class="input-tot pl-1" name="total_remanente_intmexSeguros" id="total_remanente_intmexSeguros">$0.00</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Autorizar:</h4>
                            <p class="input-tot pl-1" id="total_autorizar_intmexSeguros" name="total_autorizar_intmexSeguros">$0.00</p>
                        </div>
                    </div>
                </div>
                <div class="row aligned-row d-flex align-end">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="catalogo_remanente_intmexSeguros">Puesto</label>
                            <select name="catalogo_remanente_intmexSeguros" id="catalogo_remanente_intmexSeguros" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="usuario_remanente_intmexSeguros">Usuario</label>
                            <select class="selectpicker select-gral m-0" id="usuario_remanente_intmexSeguros" name="usuario_remanente_intmexSeguros[]" data-style="btn " data-show-subtext="true" data-container="body" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                        <div class="form-group w-100">
                            <button type="button" class="btn-gral-data pagar_remanente">Pagar masivamente</button>
                        </div>
                    </div>
                </div>
                <div class="material-datatables">
                    <div class="form-group">
                        <table class="table-striped table-hover" id="tabla_remanente_intmexSeguros" name="tabla_remanente_intmexSeguros">
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
