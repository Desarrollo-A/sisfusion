<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="timeLineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                <li role="presentation" class="active" id="tab-venta">
                                    <a href="#tabHistorial" aria-controls="tabHistorial" role="tab" data-toggle="tab" id="verVenta">Historial actual</a>
                                </li>
                                <li role="presentation" id="tab-proceso">
                                    <a href="#tabHistorial" aria-controls="tabHistorial" role="tab" data-toggle="tab" id="verProceso" class="btn-historial" data-idLote="" data-flagFusion="">Hitorial general</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="venta">
                                <div role="tabpanel" class="tab-pane active" id="tabHistorial">

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="historialTap">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-plain">
                                                        <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                            <ul class="timeline-3" id="historialActual"></ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content hide" id="proceso">
                                <div class="modal-body">
                                    <div role="tabpanel">
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="historialTap">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-plain">
                                                            <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                                <ul class="timeline-3" id="historialGeneral"></ul>
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
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#reporteCasas" role="tab" data-toggle="tab" onclick="dataFunction(1)">Reporte proceso de banco</a>
                            </li>
                            <li>
                                <a href="#reporteCredito" role="tab" data-toggle="tab" onclick="dataFunction(2)">Reporte proceso crédito directo</a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">

                                        <div class="tab-pane active" id="reporteCasas">
                                            <div class="card-content">
                                                <div class="toolbar">
                                                    <h3 class="card-title center-align">Proceso banco</h3>
                                                    <div id="table-filters" class="row mb-1"></div>
                                                </div>

                                                <table id="tableDoct" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID LOTE</th>
                                                            <th>LOTE</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>PROYECTO</th>
                                                            <th>NOMBRE CLIENTE</th>
                                                            <th>ASESOR</th>
                                                            <th>GERENTE</th>
                                                            <th>PROCESO</th>
                                                            <th>FECHA INICIO</th>
                                                            <th>FECHA MOVIMIENTO</th>
                                                            <th>TIEMPO</th>
                                                            <th>MOVIMIENTO</th>
                                                            <th>ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="reporteCredito">
                                            <div class="card-content">
                                                <div class="toolbar">
                                                    <h3 class="card-title center-align">Proceso banco</h3>
                                                    <div id="table-filters-directo" class="row mb-1"></div>
                                                </div>

                                                <table id="tableCredito" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID LOTE</th>
                                                            <th>LOTE</th>
                                                            <th>CONDOMINIO</th>
                                                            <th>PROYECTO</th>
                                                            <th>CLIENTE</th>
                                                            <th>ASESOR</th>
                                                            <th>GERENTE</th>
                                                            <th>PROCESO</th>
                                                            <th>FECHA DE INICIO</th>
                                                            <th>ÚLTIMO MOVIMIENTO</th>
                                                            <th>TIEMPO EN PROCESO</th>
                                                            <th>MOVIMIENTO</th>
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
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <?php $this->load->view('template/modals'); ?>

    <script src="<?= base_url() ?>dist/js/controllers/casas/reporte_casas.js"></script>
</body>