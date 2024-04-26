<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Solicitudes anticipos</h3>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class=" table-striped table-hover" id="tabla_anticipo_revision" name="tabla_anticipo_revision">
                                            <thead>
                                                <tr>
                                                    <th>ID ANTICIPO</th>
                                                    <th>USUARIO</th>
                                                    <th>PUESTO</th>
                                                    <th>MONTO DEL ANTICIPO</th>
                                                    <th>PROCESO</th>
                                                    <th>PRIORIDAD</th>
                                                    <th>MOTIVO</th>
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
    <script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/descuentos/anticipo/solicitudes.js"></script>
</body>