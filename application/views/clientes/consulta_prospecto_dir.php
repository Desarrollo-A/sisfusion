<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-address-book fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 overflow-hidden">
                                        <div class="form-group select-is-empty">
                                            <label class="control-label">Subdirector(<b><span style="color: red;">*</span></b>):</label>
                                            <select name="subDir" id="subDir" class="selectpicker select-gral m-0" data-container="body" data-show-subtext="true" data-live-search="true" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 overflow-hidden">
                                        <div class="form-group select-is-empty">
                                            <label class="control-label">Gerente(<b><span style="color: red;">*</span></b>):</label>
                                            <select name="gerente" id="gerente" class="selectpicker select-gral m-0" data-container="body" data-show-subtext="true" data-live-search="true" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 overflow-hidden">
                                        <div class="form-group select-is-empty">
                                            <label class="control-label">Coordinador</label>
                                            <select name="coordinador" id="coordinador" class="selectpicker select-gral m-0" data-container="body" data-show-subtext="true" data-live-search="true" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 overflow-hidden">
                                        <div class="form-group select-is-empty">
                                            <label class="control-label">Asesor</label>
                                            <select name="asesores" id="asesores" class="selectpicker select-gral m-0" data-container="body" data-show-subtext="true" data-live-search="true" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-8 hide" id="filter_date">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-11 m-3">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker" id="beginDate" value="01/07/2022" />
                                                        <input type="text" class="form-control datepicker" id="endDate" value="<?php echo date('d/m/Y')?>" />
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange"><span class="material-icons update-dataTable">search</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table id="prospects-datatable_dir" class="table-striped table-hover hide">
                                        <thead>
                                            <tr>
                                                <th>ESTADO</th>
                                                <th>ETAPA</th>
                                                <th>TIPO</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>CREACIÓN</th>
                                                <th>VENCIMIENTO</th>
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
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
</div>
</body>

<?php $this->load->view('template/footer');?>

<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/consulta_prospecto_dir.js"></script>
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
</html>
