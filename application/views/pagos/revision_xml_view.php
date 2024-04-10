<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="modalAbrirFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAbrirFacturaSeguros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAbrirFacturaOOAM" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModalPDF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form id="EditarPerfilForm" name="EditarPerfilForm" method="post">
                        <div class="modal-body" id="pdfbody"></div>
                        <div class="modal-footer" id="pdffooter"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="seeInformationModalPDFSeguros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form id="EditarPerfilForm" name="EditarPerfilForm" method="post">
                        <div class="modal-body" id="pdfbody"></div>
                        <div class="modal-footer" id="pdffooter"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active"><a href="#xmlComercializacion" role="tab" data-toggle="tab">Xml lotes</a></li>
                            <!-- <li><a href="#xmlOOAM" role="tab" data-toggle="tab">Xml ooam</a></li> -->
                            <li><a href="#xmlComercializacionSeguros" role="tab" data-toggle="tab">Xml lotes seguros</a></li>
                        </ul>
                        <div class="card no-shadow m-0 border-conntent__tabs">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="xmlComercializacion">
                                            <div class="card-content">
                                                <div class="text-center">
                                                    <h3 class="card-title center-align" >Comisiones en revisión <b>xml </b></h3>
                                                    <p class="card-title pl-1">Concentrado de facturas solicitadas por el área comercial.</p>
                                                </div>
                                                <div class="toolbar">
                                                    <div class="container-fluid p-0">
                                                        <div class="row" style="display: flex; justify-content: space-between;">
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                <div class="form-group d-flex justify-center align-center">
                                                                    <h4 class="title-tot center-align m-0">Total:</h4>
                                                                    <p class="input-tot pl-1" name="disponibleXml" id="disponibleXml">$0.00</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="display: flex; justify-content: space-between;">
                                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">          
                                                                <div class="form-group">
                                                                    <label class="control-label" for="proyectoXml">Proyecto</label>
                                                                    <select name="proyectoXml" id="proyectoXml" class="selectpicker select-gral m-0" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="material-datatables">
                                                            <div class="form-group">
                                                                <table class="table-striped table-hover" id="tabla_xml" name="tabla_xml">
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
                                        <?php $this->load->view('pagos/seguros/revision_factura_xml_seguros_view'); ?>
                                    </div>
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
    <script src="<?= base_url() ?>dist/js/controllers/pagos/revision_xml.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/seguros/revision_factura_xml_seguros.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script type="text/javascript"> Shadowbox.init();</script>
</body>
