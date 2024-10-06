<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <a href="https://youtu.be/pj80dBMw6y4" class="align-center justify-center u2be" target="_blank">
                                    <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                </a>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align" data-i18n="listado-prospectos">Listado general de prospectos</h3>
                                <div class="toolbar" style="display:none">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6"></div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker"
                                                                id="beginDate" value="01/01/2021"/>
                                                            <input type="text" class="form-control datepicker" id="endDate"
                                                                value="01/01/2021"/>
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini"
                                                                    id="searchByDateRange">
                                                                <span class="material-icons update-dataTable" data-i18n="buscar">search</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table id="prospects-datatable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>etapa</th>
                                                <th>prospecto</th>
                                                <th>asesor</th>
                                                <th>coordinador</th>
                                                <th>gerente</th>
                                                <th>subdirector</th>
                                                <th>director-regional</th>
                                                <th>director-regional2</th>
                                                <th>lugar-prospeccion</th>
                                                <th>creacion</th>
                                                <th>correo</th>
                                                <th>telefono</th>
                                                <th>acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <?php include 'common_modals.php' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');
        ?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
    <script src="<?=base_url()?>dist/js/moment.min.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/consultaProspectos.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/global_functions.js"></script>
</body>