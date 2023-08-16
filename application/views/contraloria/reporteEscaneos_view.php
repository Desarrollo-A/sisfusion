<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper ">
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
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reporte de escaneos cargados al sistema</h3>
                                </div>
                                <div  class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-md-12 p-r">
                                                        <div class="form-group d-flex">
                                                            <input type="text" class="form-control datepicker" id="beginDate"  />
                                                            <input type="text" class="form-control datepicker" id="endDate"  />
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
                                    <table  id="tablaReporteEscaneos" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>REFERENCIA</th>
                                                <th>NOMBRE DEL USUARIO</th>
                                                <th>NOMBRE DEL CLIENTE</th>
                                                <th>SEDE</th>
                                                <th>FECHA DE CARGA DEL CONTRATO</th>
                                                <th>ESTATUS DEL CONTRATO</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/es.js"></script>
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/reporteEscaneos.js"></script>
