<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <div class = "row">
                                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                            <h3 class="card-title center-align" >Comisiones nuevas <b>factura extranjero</b></h3>
                                            <p class="card-title pl-1">(Comisiones nuevas, solicitadas para proceder a pago en esquema de factura)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group d-flex justify-center align-center">
                                                <h4 class="title-tot center-align m-0">Disponible:</h4>
                                                <p class="input-tot pl-1" name="totpagarfactura" id="totpagarfactura">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group d-flex justify-center align-center">
                                                <h4 class="title-tot center-align m-0">Autorizar:</h4>
                                                <p class="input-tot pl-1" name="totpagarPen" id="totpagarPen">$0.00</p>
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
                                                    <th>ID PAGO</th>
                                                    <th>REFERENCIA</th>
                                                    <th>NOMBRE</th>
                                                    <th>SEDE</th>
                                                    <th>TOTAL DE COMISIÓN</th>
                                                    <th>IMPUESTO</th>
                                                    <th>PORCENTAJE COMISIÓN</th>
                                                    <th>ESTATUS</th>
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
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/suma/revisionFacturaExtranjero.js"></script>
</body>