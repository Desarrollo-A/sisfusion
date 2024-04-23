<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="reportesClientesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Consulta de historial de lotes por Cliente <b id="nomLoteHistorial"></b></h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                <li role="presentation" class="active">
                                    <a href="#tabClientesTotal" aria-controls="tabClientesTotal" role="tab" data-toggle="tab">Historial de lotes por cliente</a>
                                </li>
                            </ul>
                            <div class="card no-shadow m-0 border-conntent__tabs">
                                <div class="card-content p-0">
                                    <div class="nav-tabs-custom">
                                        <div class="tab-content p-2">
                                            <div class="tab-pane active" id="tabClientesTotal">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-plain">
                                                            <div class="card-content">
                                                                <div class="material-datatables">
                                                                    <div class="form-group">
                                                                        <table id="tablaHistorialLotes" class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>ID CLIENTE</th>
                                                                                    <th>ID LOTE</th>
                                                                                    <th>PROYECTO</th>
                                                                                    <th>DESCRIPCION</th>
                                                                                    <th>NOMBRE CONDOMINIO</th>
                                                                                    <th>NOMBRE LOTE</th>
                                                                                    <th>CLIENTE</th>
                                                                                    <th>FECHA DE APARTADO</th>
                                                                                    <th>COPROPIETARIO(S)</th>
                                                                                    <th>REFERENCIA</th>
                                                                                    <th>ASESOR</th>
                                                                                    <th>COORDINADOR</th>
                                                                                    <th>GERENTE</th>
                                                                                    <th>ESTATUS</th>
                                                                                    <th>ESTATUS DE CONTRATACION ACTUAL</th>
                                                                                    <th>SEDE</th>
                                                                                    <th>TIPO PROCESO</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                        <li class="active"><a href="#tabClientesTotal2" role="tab" data-toggle="tab">INDIVIDUAL</a></li>
                        <li><a href="#tabLotesCompletos" role="tab" data-toggle="tab">LOTES COMPLETOS</a></li>
                    </ul>
                    <div class="card no-shadow m-0 border-conntent__tabs">
                        <div class="card-content p-0">
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="tab-pane active" id="tabClientesTotal2">
                                        <div class="card">
                                            <div class="card-content">
                                                <h3 class="card-title center-align">Reporte de lote por cliente individual</h3>
                                                <div class="material-datatables">
                                                    <div class="material-datatables">
                                                        <div class="form-group">
                                                            <table class="table-striped table-hover" id="lotesClientesIndividual" name="lotesClientesIndividual">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID CLIENTE</th>
                                                                        <th>NOMBRE CLIENTE</th>
                                                                        <th>NOMBRE COPROPIETARIO</th>
                                                                        <th>NUMERO LOTES</th>
                                                                        <th>ACCIONES</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $this->load->view('reportes/reporteInfoCompleta_view'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/reportes/reporteVentasLotes.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/reportes/reporteInfoCompleta.js"></script>
</body>
