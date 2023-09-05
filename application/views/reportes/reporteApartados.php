<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php  $this->load->view('template/sidebar'); ?>
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">list</i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Reporte de lotes con ingreso de contrato</h3>
                                <div class="row">
                                    <div class="toolbar">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4 p-r">
                                            <div class="form-group d-flex">
                                                <input type="text" class="form-control datepicker beginDate" id="beginDate"/>
                                                <input type="text" class="form-control datepicker endDate" id="endDate"/>
                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                    <span class="material-icons update-dataTable">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table class="table-striped table-hover" id="lotesApartados"name="lotesApartados">
                                        <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>PRECIO FINAL</th>
                                                <th>REFERENCIA</th>
                                                <th>ASESOR</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>SEDE</th>
                                                <th>TIPO DE VENTA</th>
                                                <th>FECHA DE CONTRATACIÓN</th>
                                                <th>ESTATUS DE LA VENTA</th>
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
        <?php $this->load->view('template/footer_legend');
        ?>
    </div>

    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/contraloria/reporteApartado.js"></script>
</body>