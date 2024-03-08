<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="seeInformationModalDescuentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <h6 id="nameLote"></h6>
                            <div class="container-fluid" id="changelogTab">
                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                    <ul class="timeline-3" id="comments-list-descuentos"></ul>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade modal-alertas" id="documento_preview" role="dialog">
            <div class="modal-dialog" style= "margin-top:20px;"></div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">money_off</i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <div>
                                        <h3 class="card-title center-align" >Historial descuentos</h3>
                                        <!-- <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de factura)</p> -->
                                    </div>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Total descontado:</h4>
                                                    <i class="fas fa-file-invoice-dollar fa-2x"  style=" color: #0067d4; padding-top:20px;"></i>
                                                    <p class="input-tot pl-1"  style=" padding-top:20px;" name="total_pagar_descuento" id="total_pagar_descuento">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0" for="catalogo_descuento">Proyecto</label>
                                                    <select name="catalogo_descuento" id="catalogo_descuento" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="m-0" for="condominio_descuento">Condominio</label>
                                                    <select class="selectpicker select-gral" id="condominio_descuento" name="condominio_descuento[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_descuento_historial" name="tabla_descuento_historial">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>                                
                                                    <th>USUARIO</th>
                                                    <th>$ DESCUENTO</th>
                                                    <th>LOTE</th>
                                                    <th>MOTIVO</th>
                                                    <th>MOTIVO</th>
                                                    <th>ESTATUS</th>
                                                    <th>CREADO POR</th>
                                                    <th>FECHA CAPTURA</th>
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
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/descuentos/descuentos_historial.js"></script>
</body>