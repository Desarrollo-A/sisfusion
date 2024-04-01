<div class="tab-pane" id="intmex_seguros">
        <div class="encabezadoBox">
            <h3 class="card-title center-align">Comisiones nuevas <b>asimiliados seguros</b></h3>
        </div>
        <div>
            <p class="card-title text-center pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de asimilados seguros)</p>
        </div>
        <div class="toolbar">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Disponible:</h4>
                            <p class="input-tot pl-1" name="totpagarAsimilados_intmexSeguros" id="totpagarAsimilados_intmexSeguros">$0.00</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Autorizar:</h4>
                            <p class="input-tot pl-1" name="totpagarPen_intmexSeguros" id="totpagarPen_intmexSeguros">$0.00</p>
                        </div>
                    </div>
                </div>
                <div class="row aligned-row d-flex align-end">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="puestoAsimilados_intmexSeguros">Puesto</label>
                            <select name="puestoAsimilados_intmexSeguros" id="puestoAsimilados_intmexSeguros" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label class="control-label" for="usuarioAsimilados_intmexSeguros">Usuario</label>
                            <select class="selectpicker select-gral" id="usuarioAsimilados_intmexSeguros" name="usuarioAsimilados_intmexSeguros[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex align-end">
                        <div class="form-group w-100">
                            <button type="button" class="btn-gral-data Pagar">Pagar masivamente</button>
                        </div>
                    </div>
                </div>
                <div class="material-datatables">
                    <div class="form-group">
                        <table class="table-striped table-hover" id="tabla_asimilados_intmexSeguros" name="tabla_asimilados_intmexSeguros">
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
                                    <th>SOLICITADO</th>
                                    <th>IMPUESTO</th>
                                    <th>DESCUENTO</th>
                                    <th>A PAGAR</th>
                                    <th>TIPO DE VENTA</th>
                                    <th>USUARIO</th>
                                    <th>RFC</th>
                                    <th>PUESTO</th>
                                    <th>CÓDIGO POSTAL</th>
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
