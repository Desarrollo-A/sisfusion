<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

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
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align" data-i18n="listado-prospectos">Listado general de prospectos</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label" data-i18n="subdirector">Subdirector</label>
                                                <select name="subDir" id="subDir" class="selectpicker select-gral m-0" data-show-subtext="true" data-live-search="true" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n-label="selecciona-subdirector" title="Selecciona subdirector" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label" data-i18n="gerente">Gerente</label>
                                                <select name="gerente" id="gerente" class="selectpicker select-gral m-0" data-show-subtext="true" data-live-search="true" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n-label="selecciona-gerente" title="Selecciona gerente" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label" data-i18n="coordinador">Coordinador</label>
                                                <select name="coordinador" id="coordinador" class="selectpicker select-gral m-0" data-show-subtext="true" data-live-search="true" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n-label="selecciona-coordinador" title="Selecciona coordiniador" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label" data-i18n="asesor">Asesor</label>
                                                <select name="asesores" id="asesores" class="selectpicker select-gral m-0" data-show-subtext="true" data-live-search="true" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n-label="selecciona-asesor" title="Selecciona asesor" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-8 hide" id="filter_date">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" />
                                                            <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" />
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                                <span class="material-icons update-dataTable" data-i18n="buscar">Buscar</span>
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
                                        <div class="table-responsive">
                                            <table id="prospects-datatable_dir" class="table-striped table-hover" style="text-align:center;">
                                                <thead>
                                                    <tr>
                                                        <th>estado</th>
                                                        <th>etapa</th>
                                                        <th>tipo</th>
                                                        <th>prospecto</th>
                                                        <th>asesor</th>
                                                        <th>coordinador</th>
                                                        <th>gerente</th>
                                                        <th>lugar-prospeccion</th>
                                                        <th>creacion</th>
                                                        <th>fecha-vencimiento</th>
                                                        <th>correo</th>
                                                        <th>telefono</th>
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
        </div>

        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <!--main-panel close-->
</body>

<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>

<script>
    userType = <?= $this->session->userdata('id_rol') ?>;
    typeTransaction = 1;
</script>

<!-- MODAL WIZARD -->
<script src="<?= base_url() ?>dist/js/modal-steps.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/consulta_prospectos_director.js"></script>
<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>

</html>