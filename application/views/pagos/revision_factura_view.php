<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        
        <div class="modal fade modal-alertas" id="modalPausarFactura" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="formPausarFactura">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modalPausarFacturaSeguros" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="formPausarFacturaSeguros">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modalPausarFacturaCasas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="formPausarFacturaCasas">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modalPausarFacturaOOAM" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="formPausarFacturaOOAM">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="modalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="modalEnviadasOOAM" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                        <li class="active"><a href="#facturaComercializacion" role="tab" data-toggle="tab">Facturas lotes</a></li>
                        <li><a href="#facturaSeguros" role="tab" data-toggle="tab">Facturas seguros</a></li>
                        <li><a href="#facturaCasas" role="tab" data-toggle="tab">Facturas Casas</a></li>
                    </ul>
            
                    <div class="card no-shadow m-0 border-conntent__tabs">
                        <div class="card-content p-0">
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="tab-pane active" id="facturaComercializacion">
                                        <div class="card-content">
                                            <div class="text-center">
                                                <h3 class="card-title center-align" >Comisiones en revisión <b>factura </b></h3>
                                                <p class="card-title pl-1">Comisiones solicitadas por equipos seguros para proceder a pago en esquema de factura.</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                                <p class="input-tot pl-1" name="disponibleFactura" id="disponibleFactura">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                                <p class="input-tot pl-1" name="autorizarFactura" id="autorizarFactura">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h3 class="card-title center-align">Cambio de modalidad</h3>  
                                                    </div>
                                                    <div class="row aligned-row d-flex align-end pt-3" style="display: flex; justify-content: center"> 
                                                        <div id="selectorModo" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div>
                                                                <div class="radio_container w-100">
                                                                    <input class="d-none generate" type="radio" name="modoSubida" id="condominioM" checked value="1">
                                                                    <label for="condominioM" class="w-50">Reestructura</label>
                                                                    <input class="d-none find-results" type="radio" name="modoSubida" id="loteM" value="0">
                                                                    <label for="loteM" class="w-50">Comercialización</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row aligned-row d-flex align-end">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                            <div class="form-group">
                                                                <label class="control-label" for="proyectoFactura">Proyecto</label>
                                                                <select name="proyectoFactura" id="proyectoFactura" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                                                            <div class="form-group">
                                                                <label class="control-label" for="condominioFactura">Condominio</label>
                                                                <select class="selectpicker select-gral m-0" id="condominioFactura" name="condominioFactura[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="material-datatables">
                                                        <div class="form-group">
                                                            <table class="table-striped table-hover" id="tabla_factura" name="tabla_factura">
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
                                    </div>
                                    <?php $this->load->view('pagos/seguros/revision_factura_seguros_view'); ?>
                                    <?php $this->load->view('pagos/casas/revision_facturas_casas_view'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/revision_factura.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/seguros/revision_factura_seguros.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/casas/revision_factura_casas.js"></script>
</body>