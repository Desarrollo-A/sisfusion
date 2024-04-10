<div class="tab-pane" id="factura_seguros">
    <div class="text-center">
        <div class="encabezadoBox">
            <h3 class="card-title center-align">Comisiones nuevas <b>factura seguros</b></h3>
        </div>
        <div>
            <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de facturación seguros)</p>
        </div>
    </div>
    <div class="toolbar">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group d-flex justify-center align-center">
                        <h4 class="title-tot center-align m-0">Disponible:</h4>
                        <p class="input-tot pl-1" name="total_factura_intmex_seguros" id="total_factura_intmex_seguros">$0.00</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group d-flex justify-center align-center">
                        <h4 class="title-tot center-align m-0">Autorizar:</h4>
                        <p class="input-tot pl-1" id="autorizar_factura_intmex_seguros" name="autorizar_factura_intmex_seguros">$0.00</p>
                    </div>
                </div>
            </div>
            <div class="row aligned-row d-flex align-end">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="catalogo_factura_intmex_seguros">Puesto</label>
                        <select name="catalogo_factura_intmex_seguros" id="catalogo_factura_intmex_seguros" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="usuario_factura_intmex_seguros">Usuario</label>
                        <select class="selectpicker select-gral" id="usuario_factura_intmex_seguros" name="usuario_factura[]_intmex_seguros" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                    <div class="form-group w-100">
                        <button type="button" class="btn-gral-data PagarSeguros">Pagar masivamente</button>
                    </div>
                </div>
            </div>
            <div class="material-datatables">
                <div class="form-group">
                    <table class="table-striped table-hover" id="tabla_remanente_intmex_seguros" name="tabla_remanente_intmex_seguros">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>PROYECTO</th>
                                <th>CONDOMINIO</th>
                                <th>LOTE</th>
                                <th>REFERENCIA</th>
                                <th>PRECIO DEL LOTE</th>
                                <th>EMPRESA</th>
                                <th>TOTAL COMISIÓN</th>
                                <th>PAGO DEL CLIENTE</th>
                                <th>A PAGAR</th>
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
