<div class="tab-pane" id="remanenteSeguros">
        <div class="text-center">
            <h3 class="card-title center-align">Comisiones en revisión <b>remanente seguros</b></h3>
            <p class="card-title pl-1">Comisiones solicitadas por el área comercial para proceder a pago en esquema de remanente seguros.</p>
        </div>

        <div class="toolbar">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Disponible:</h4>
                            <p class="input-tot pl-1" name="disponibleRemanente_seguros" id="disponibleRemanente_seguros">$0.00</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Autorizar:</h4>
                            <p class="input-tot pl-1" name="autorizarRemanente_seguros" id="autorizarRemanente_seguros">$0.00</p>
                        </div>
                    </div>
                </div>

                <div class="row aligned-row d-flex align-end">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                        <div class="form-group">
                            <label class="control-label" for="proyectoRemanente_seguros">Proyecto</label>
                            <select name="proyectoRemanente_seguros" id="proyectoRemanente_seguros" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                        <div class="form-group">
                            <label class="control-label" for="condominioRemanente_seguros">Condominio</label>
                            <select class="selectpicker select-gral m-0" id="condominioRemanente_seguros" name="condominioRemanente[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                </div>

                <div class="material-datatables">
                    <div class="form-group">
                        <table class="table-striped table-hover" id="tabla_remanente_seguros" name="tabla_remanente_seguros">
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
                                    <th>TOTAL DE LA COMISIÓN</th>
                                    <th>PAGADO POR EL CLIENTE</th>
                                    <th>SOLICITADO</th>
                                    <th>IMPUESTO</th>
                                    <th>DESCUENTO</th>
                                    <th>TOTAL A PAGAR</th>
                                    <th>TIPO DE VENTA</th>
                                    <th>PLAN DE VENTA</th>
                                    <th>PORCENTAJE</th>
                                    <th>FECHA APARTADO</th>
                                    <th>SEDE</th>
                                    <th>USUARIO</th>
                                    <th>ESTATUS</th>
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
