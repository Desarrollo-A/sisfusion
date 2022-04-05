<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />

<body>
    <div class="wrapper">
        <?php //include 'sidebarParams_prospectsList.php'
            /*-------------------------------------------------------*/
            $datos = array();
            $datos = $datos4;
            $datos = $datos2;
            $datos = $datos3;  
            $this->load->view('template/sidebar', $datos);
            /*--------------------------------------------------------*/
        ?>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">list</i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Listado General de Solicitudes de Escrituración.</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6"></div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker"
                                                                id="beginDate" value="01/01/2022" autocomplete='off'/>
                                                            <input type="text" class="form-control datepicker"
                                                                id="endDate" value="28/02/2022" autocomplete='off' />
                                                            <button
                                                                class="btn btn-success btn-round btn-fab btn-fab-mini"
                                                                id="searchByDateRange">
                                                                <span
                                                                    class="material-icons update-dataTable">search</span>
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
                                            <table class="table-striped table-hover" id="prospects-datatable"
                                                name="prospects-datatable">
                                                <thead>
                                                    <tr>
                                                        <th>ID SOLICITUD</th>
                                                        <th>PROYECTO</th>
                                                        <th>CONDOMINIO</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>FECHA DE CREACIÓN</th>
                                                        <th>COMENTARIOS</th>
                                                        <th>ESTATUS</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
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
    <!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<!--<script src="--><?php //base_url()?>
<!--dist/js/jquery.validate.js"></script>-->

<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    idUser = <?= $this->session->userdata('id_usuario') ?> ;
    typeTransaction = 1;
    console.log(idUser);
	Shadowbox.init();
    base_url = "<?=base_url()?>";
</script>

<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!-- <script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script> -->
<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>
<script src="<?=base_url()?>dist/js/controllers/general/main_services.js"></script>
<script src="<?=base_url()?>dist/js/controllers/postventa/solicitudes_escrituracion.js"></script>

</html>