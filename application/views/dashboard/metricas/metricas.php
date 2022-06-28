<link href="<?= base_url() ?>dist/css/metricasDashboard.css" rel="stylesheet"/>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="card p-2">
                <div class="container-fluid h-100 p-0">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100 pb-3">
                            <h4 class="text-left m-0 fw-400 pb-1">Ventas por metro cuadrado</h4>
                            <div id="ventasMetrosChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            <div class="card p-2">
                <div class="container-fluid h-100 p-0">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100 pb-3">
                            <h4 class="text-left m-0 fw-400 pb-1">Ventas por tipo de descuento aplicado</h4>
                            <div id="descuentosChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <div class="row" id="mainRow">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 flexible inactivo">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <h4 class="text-center m-0 fw-400">Metros cuadrados</h4>
                                <button class="btn-charts" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChart" class="h-90 boxChart">
                                <div id="metrosChart"></div>
                            </div>
                        </div>
                        <div id="metros" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 flexible inactivo">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <h4 class="text-center m-0 fw-400">Disponibilidad por proyecto</h4>
                                <button class="btn-charts" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChart" class="h-90 boxChart">
                                <div id="disponibilidadChart"></div>
                            </div>
                        </div>
                        <div id="disponibilidad" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 flexible inactivo">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <h4 class="text-center m-0 fw-400">Lugar de prospección</h4>
                                <button class="btn-charts" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChart" class="h-90 boxChart">
                                <div id="lugarChart"></div>
                            </div>
                        </div>
                        <div id="lugar" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 h-100 flexible inactivo">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <h4 class="text-center m-0 fw-400">Medio de prospección</h4>
                                <button class="btn-charts" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChart" class="h-90 boxChart">
                                <div id="medioChart"></div>
                            </div>
                        </div>
                        <div id="medio" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url()?>dist/js/controllers/dashboard/metricas/dashboardMetrics.js"></script>