<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>
    <style>
        .label-inf {
            color: #333;
        }
        select:invalid {
            border: 2px dashed red;
        }
        .textoshead::placeholder {
            color: white;
        }
    </style>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-save fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div  class="toolbar">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <select name="subDir" id="subDir" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona subdirector" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <select name="gerente" id="gerente" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona gerente" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <select name="coordinador" id="coordinador" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona coordinador" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group label-floating select-is-empty">
                                            <select name="asesor" id="asesor" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona asesor" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group label-floating select-is-empty">
                                            <select name="lugar_p" id="lugar_p" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona lugar prospección" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-12 p-r">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker" id="beginDate"/>
                                                        <input type="text" class="form-control datepicker" id="endDate"/>
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange"><span class="material-icons update-dataTable">search</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <table  id="prospects-datatable_dir" name="prospects-datatable_dir" class="table-striped table-hover hide" style="text-align:center;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NOMBRE</th>
                                            <th>APELLIDO PATERNO</th>
                                            <th>APELLIDO MATERNO</th>
                                            <th>CORREO</th>
                                            <th>TELEFONO</th>
                                            <th>LUGAR PROSPECCIÓN</th>
                                            <th>ASESOR</th>
                                            <th>COORDINADOR</th>
                                            <th>GERENTE</th>
                                            <th>SUBDIRECTOR</th>
                                            <th>DIRECTOR REGIONAL</th>
                                            <th>DIRECTOR REGIONAL 2</th>
                                            <th>CREACIÓN</th>
                                        </tr>
                                    </thead>
                                </table>
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
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/consulta_prospectos_mktd_all.js"></script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
</html>
