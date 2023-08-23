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
                            <h3 class="card-title center-align">Listado general de prospectos</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div id="filterContainer" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div id="calendario" class="col-md-12 p-r hide">
                                                    <div class="form-group d-flex ">
                                                        <input type="text" class="form-control datepicker beginDate" id="beginDate" />
                                                        <input type="text" class="form-control datepicker endDate" id="endDate" />
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                            <span class="material-icons update-dataTable">search</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table id="prospects-datatable_dir"  class="table-striped table-hover hide">
                                        <thead>
                                            <tr>
                                                <th>ESTADO</th>
                                                <th>ETAPA</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>CREACIÓN</th>
                                                <th>VENCIMIENTO</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <?php include 'common_modals.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php $this->load->view('template/footer_legend');?>
</div>
<?php $this->load->view('template/footer');?>


<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?=base_url()?>dist/js/moment.min.js"></script>
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<?php if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5){?>
    <script src="<?=base_url()?>dist/js/controllers/consultaProspectos.js"></script>
<?php } ?>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/consulta_prospecto_sbdir.js"></script>
</body>