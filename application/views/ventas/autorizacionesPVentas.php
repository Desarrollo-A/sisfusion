<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        
        <div class="modal fade" id="detailComisionistaModal" tabindex="-1" role="dialog" aria-labelledby="detailComisionistaLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-between">
                        <h5 class="modal-title" id="exampleModalLabel">Detalle total de comisiones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="timelineR p-4 block mb-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Autorizaciones planes de ventas</h3>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-sm-3 col-md-3 col-lg-3 overflow-hidden">
                                                <div class="d-flex justify-between">
                                                    <label class="label-gral">
                                                        <span class="isRequired">*</span>Estatus autorización
                                                    </label>                                                </div>
                                                <select class="selectpicker select-gral m-0" id="estatusAut" name="estatusAut" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body"></select>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-3 col-lg-3 overflow-hidden">
                                                <label class="label-gral"><span class="isRequired">*</span>Año</label>
                                                <select class="selectpicker select-gral m-0" id="anio" name="anio" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body">
                                                    <?php
                                                    setlocale(LC_ALL, 'es_ES');
                                                    for ($i=2023; $i<=2026; $i++) {
                                                        $yearName  = $i;
                                                        echo '<option value="'.$i.'">'.$yearName.'</option>';
                                                    } 
                                                    ?>
                                                    </select>
                                            </div>
                                            <div class="col-12 col-sm-1 col-md-1 col-lg-1">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-md-12 p-r">
                                                            <div class="form-group d-flex">
                                                                <button class="btn btn-dafult btn-round btn-fab" id="searchByEstatus">
                                                                    <span class="material-icons update-dataTable">search</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br> 
                                <div class="material-datatables" id="box-autorizacionesPVentas">
                                    <div class="form-group">
                                            <table class="table-striped table-hover"
                                                id="autorizacionesPVentas" name="autorizacionesPVentas">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>SEDE</th>
                                                        <th>RESIDENCIAL</th>
                                                        <th>FECHA INICIO</th>
                                                        <th>FECHA FIN</th>
                                                        <th>TIPO LOTE</th>
                                                        <th>TIPO DE SUPERFICIE</th>
                                                        <th>ESTATUS AUTORIZACIÓN</th>
                                                        <th>ESTATUS</th>
                                                        <th>FECHA CREACIÓN</th>
                                                        <th>CREADO POR</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                    </div>
                                </div>
                                <?php include 'modalsPVentas.php' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <!-- Sliders Plugin -->
    <script src="<?= base_url() ?>dist/js/nouislider.min.js"></script>
    <!--  Full Calendar Plugin    -->
    <script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/ventas/autorizacionesPVentas.js"></script>
</body>