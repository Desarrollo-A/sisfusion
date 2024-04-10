<div class="tab-pane" id="xmlComercializacionSeguros">
    <div class="card-content">
        <div class="text-center">
            <h3 class="card-title center-align" >Comisiones en revisión <b>xml seguros</b></h3>
            <p class="card-title pl-1">Concentrado de facturas solicitadas por el área comercial.</p>
        </div>
        <div class="toolbar">
            <div class="container-fluid p-0">
                <div class="row" style="display: flex; justify-content: space-between;">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Total:</h4>
                            <p class="input-tot pl-1" name="disponibleXmlSeguro" id="disponibleXmlSeguro">$0.00</p>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex; justify-content: space-between;">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                        <div class="form-group">
                            <label class="control-label" for="proyectoXmlSeguros">Proyecto</label>
                            <select name="proyectoXmlSeguros" id="proyectoXmlSeguros" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                    </div>
                </div>
                <div class="material-datatables">
                    <div class="form-group">
                        <table class="table-striped table-hover" id="tabla_xml_seguros" name="tabla_xml_seguros">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>USUARIO</th>
                                    <th>MONTO</th>
                                    <th>PROYECTO</th>
                                    <th>EMPRESA</th>
                                    <th>OPINIÓN DE CUMPLIMIENTO</th>
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
