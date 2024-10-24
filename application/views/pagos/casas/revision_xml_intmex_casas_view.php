<!-- Modals -->
        <div class="modal fade modal-alertas" id="documento_preview_casas" role="dialog">
            <div class="modal-dialog" style= "margin-top:20px;"></div>
        </div>

        <div class="modal fade modal-alertas" id="modal_pagadas_casas" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <form method="post" id="form_pagadas_casas">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModalfactura_casas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsfactura_casas()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsfactura_casas()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_nuevas_casas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_interes_casas">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_documentacion_casas" role="dialog">
            <div class="modal-dialog" style="width:800px; margin-top:20px">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas_casas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="myModalTQro_casas" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

<div class="tab-pane" id="Facturas_Casas">
    <div class="card-content">
        <div class="text-center">
            <h3 class="card-title center-align" >Comisiones nuevas <b>facturas casas</b></h3>
            <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de factura)</p>
        </div>
        <div class="toolbar">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group d-flex justify-center align-center">
                            <h4 class="title-tot center-align m-0">Disponible:</h4>
                            <p class="input-tot pl-1" name="totpagarfactura_casas" id="totpagarfactura_casas">$0.00</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label class="control-label" for="filtro33_casas">Proyecto</label>
                            <select name="filtro33_casas" id="filtro33_casas" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <label class="control-label" for="filtro44_casas">Condominio</label>
                            <select class="selectpicker select-gral" id="filtro44_casas" name="filtro44_casas[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required/></select>
                        </div>
                    </div>
                </div>    
                <div class="material-datatables">
                    <div class="form-group">
                        <table class="table-striped table-hover" id="tabla_factura_casas" name="tabla_factura_casas">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>USUARIO</th>
                                    <th>RFC</th>
                                    <th>MONTO</th>
                                    <th>PROYECTO</th>
                                    <th>EMPRESA</th>
                                    <th>OPINIÓN DE CUMPLIMIENTO</th>
                                    <th>MÁS</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>