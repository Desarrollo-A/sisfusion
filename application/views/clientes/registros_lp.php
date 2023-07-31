<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-address-book fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Registro desde landing page</h3>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table id="registros-datatable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID REGISTRO</th>
                                                    <th>SEDE</th>
                                                    <th>NOMBRE</th>
                                                    <th>CORREO</th>
                                                    <th>TELÉFONO</th>
                                                    <th>ORIGEN</th>
                                                    <th>FECHA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
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
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url()?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?=base_url()?>dist/js/controllers/report_prospects.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/registros_lp.js"></script>
</body>