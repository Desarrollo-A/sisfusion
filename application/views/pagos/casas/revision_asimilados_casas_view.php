<div class="tab-pane" id="asimiladosCasas">
   <div class="text-center">
        <h3 class="card-title center-align">Comisiones en revisión <b>asimilados CASAS</b></h3>
        <i class="fas fa-house-user  "
            style="color:#000000;  font-size: 30px;"
        ></i>
        <p class="card-title pl-1">Comisiones solicitadas por el área comercial para proceder a pago en esquema de asimilados CASAS.</p>
    </div>

    <div class="toolbar">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group d-flex justify-center align-center">
                        <h4 class="title-tot center-align m-0">Disponible:</h4>
                        <p class="input-tot pl-1" name="disponibleAsimilados_casas" id="disponibleAsimilados_casas">$0.00</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group d-flex justify-center align-center">
                        <h4 class="title-tot center-align m-0">Autorizar:</h4>
                        <p class="input-tot pl-1" name="autorizarAsimilados_casas" id="autorizarAsimilados_casas">$0.00</p>
                    </div>
                </div>
            </div>
            
            <div class="row aligned-row d-flex align-end">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                    <div class="form-group">
                        <label class="control-label" for="proyectoAsimilados_casas">Proyecto</label>
                        <select name="proyectoAsimilados_casas" id="proyectoAsimilados_casas" 
                                class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" 
                                data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" 
                                data-size="7" required></select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                    <div class="form-group">
                        <label class="control-label" for="condominioAsimilados_casas">Condominio</label>
                        <select class="selectpicker select-gral m-0" id="condominioAsimilados_casas" 
                                name="condominioAsimilados_casas[]" data-style="btn " data-show-subtext="true" data-live-search="true" 
                                data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                    </div>
                </div>
            </div>

            <div class="material-datatables">
                <div class="form-group">
                    <table class="table-striped table-hover" id="tabla_asimilados_casas" name="tabla_asimilados_casas">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID PAGO</th>
                                <th>PROYECTO</th>
                                <th>CONDOMINIO</th>
                                <th>LOTE</th>
                                <th>REFERENCIA</th>
                                <th>PRECIO DEL SEGURO</th>
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


