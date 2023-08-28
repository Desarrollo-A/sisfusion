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
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align" id="showDate"></h3>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table id="mktdProspectsTable"
                                            class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>RESIDENCIAL</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>SUPERFICIE</th>
                                                    <th>PRECIO POR m<sup>2</sup></th>
                                                    <th>COSTO TOTAL</th>
                                                    <th>REFERENCIA</th>
                                                    <th>ASESOR</th>
                                                    <th>COORDINADOR</th>
                                                    <th>GERENTE</th>
                                                    <th>SUBDIRECTOR</th>
                                                    <th>DIRECTOR REGIONAL</th>
                                                    <th>DIRECTOR REGIONAL 2</th>
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
    <script src="<?= base_url() ?>dist/js/controllers/mktd-1.1.0.js"></script>
    <script src="<?=base_url()?>dist/js/funciones-generales.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/contraloria/generalClientsReport.js"></script>
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
</body>