    <div class="tab-pane" id="remanenteOOAM">
        <div class="text-center">
            <h3 class="card-title center-align">Comisiones en revisión <b>remanente OOAM</b></h3>
            <p class="card-title pl-1">Comisiones solicitadas por el área de OOAM para proceder a pago en esquema de remanente.</p>
        </div>

        <div class="toolbar">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Disponible:</h4>
                            <p class="input-tot pl-1" name="disponibleRemanenteOOAM" id="disponibleRemanenteOOAM">$0.00</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Autorizar:</h4>
                            <p class="input-tot pl-1" name="autorizarRemanenteOOAM" id="autorizarRemanenteOOAM">$0.00</p>
                        </div>
                    </div>
                </div>

                <div class="row aligned-row d-flex align-end">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                        <div class="form-group">
                            <label class="control-label" for="proyectoRemanenteOOAM">Proyecto</label>
                            <select name="proyectoRemanenteOOAM" id="proyectoRemanenteOOAM" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                        <div class="form-group">
                            <label class="control-label" for="condominioRemanenteOOAM">Condominio</label>
                            <select class="selectpicker select-gral m-0" id="condominioRemanenteOOAM" name="condominioRemanenteOOAM[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
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
                            <th>TOTAL DE LA COMISIÓN</th>
                            <th>PAGADO POR EL CLIENTE</th>
                            <th>TOTAL A PAGAR</th>
                            <th>TIPO DE VENTA</th>
                            <th>USUARIO</th>
                            <th>PUESTO</th>
                            <th>FECHA DE ENVÍO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
