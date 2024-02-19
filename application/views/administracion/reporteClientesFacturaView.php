<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-file fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Clientes con factura</h3>
                                </div>
                                <br>
                                <div class="material-datatables" id="box-clientesFacturaTabla">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="clientesFacturaTabla" name="clientesFacturaTabla">
                                            <thead>
                                                <tr>
                                                    <th>TIPO DE VENTA</th>
                                                    <th>TIPO DE PROCESO</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>RFC</th>
                                                    <th>CÓDIGO POSTAL</th>
                                                    <th>RÉGIMEN FISCAL</th>
                                                    <th>UBICACIÓN</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/administracion/reporteClientesFactura.js"></script>
</body>