<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar');   ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-bookmark fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Listado general de clienteeeeees</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate"/>
                                                            <input type="text" class="form-control datepicker" id="endDate"/>
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
                                <div class="material-datatables" id="box-masterCobranzaTable">
                                    <div class="form-group">
                                        <table id="clients_report_datatable" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>ID lote</th>
                                                    <th>CLIENTE</th>
                                                    <th>MEDIO</th>
                                                    <th>PLAZA</th>
                                                    <th>ASESOR</th>
                                                    <th>COORDINADOR</th>
                                                    <th>GERENTE</th>
                                                    <th>TOTAL</th>
                                                    <th>ENGANCHE</th>
                                                    <th>PLAN ENGANCHE</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>FECHA ESTATUS 9</th>
                                                </tr>
                                            </thead>
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
    </div><!--main-panel close-->
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
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?=base_url()?>dist/js/funciones-generales.js"></script>

<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/clientsReportVentas.js"></script>