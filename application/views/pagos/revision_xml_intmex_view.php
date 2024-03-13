<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="documento_vistaprevia" role="dialog">
            <div class="modal-dialog" style= "margin-top:20px;"></div>
        </div>

        <div class="modal fade" id="consultar_informacion_factura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsfactura()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content" style="justify-content: space-between">
                                <div class="text-center">
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align pt-3" >Comisiones nuevas <b>facturas</b></h3>
                                    </div>
                                    <div>
                                        <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de factura)</p>
                                    </div>
                                </div>

                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                    <p class="input-tot pl-1" name="total_facturas" id="total_facturas">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="catalgo_facturas">Proyecto</label>
                                                    <select name="catalgo_facturas" id="catalgo_facturas" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                <div class="form-group">
                                                    <label class="control-label" for="condominio_facturas">Condominio</label>
                                                    <select class="selectpicker select-gral" id="condominio_facturas" name="condominio_facturas[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required/></select>
                                                </div>
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_factura" name="tabla_factura">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>USUARIO</th>
                                                    <th>RFC</th>
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
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/pagos/revision_xml_intmex.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script type="text/javascript"> Shadowbox.init();</script>
</body>