<link href="<?= base_url() ?>dist/css/metricasDashboard.css" rel="stylesheet"/>


<div class="container-fluid first-row pb-1 ">
    <div class="row" style="height: 450px;">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 h-100">
            <div class="container-fluid h-100 p-0">
                <div class="row h-100">
                    <div class="col-md-12 h-100 pb-3">
                        <div class="card p-2 m-0 h-100">
                        <h4 class="text-left m-0 fw-400 pb-1">Ventas por metro cuadrado</h4>
                            <div id="ventasMetrosChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 h-100">
            <div class="container-fluid h-100 p-0">
                <div class="row h-100">
                    <div class="col-md-12 h-100 pb-3">
                        <div class="card p-2 m-0 h-100">
                        <h4 class="text-left m-0 fw-400 pb-1">Ventas por tipo de descuento aplicado</h4>
                            <div id="descuentosChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid  mt-2">
    <div class="row" style="height: 450px;">
        <div class="col-12 col-sm-4 col-md-4 col-lg-4 h-100">
            <div class="container-fluid h-100 p-0">
                <div class="row h-100">
                    <div class="col-md-12 h-100 pb-3">
                        <div class="card p-2 m-0 h-100">
                            <h4 class="text-center m-0 fw-400">Metros cuadrados</h4>
                            <div id="metrosChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 col-md-8 col-lg-8 h-100">
            <div class="container-fluid h-100 p-0">
                <div class="row h-100">
                    <div class="col-md-12 h-100 pb-3">
                        <div class="card p-2 m-0 h-100">
                            <h4 class="text-center m-0 fw-400">Disponibilidad por proyecto</h4>
                            <div class="h-90" id="disponibilidadChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 h-100">
            <div class="container-fluid h-100 p-0">
                <div class="row h-100">
                    <div class="col-md-12 h-100 pb-3">
                        <div class="card p-2 m-0 h-100">
                            <h4 class="text-center m-0 fw-400">Lugar de prospección</h4>
                            <div id="lugarChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 h-100">
            <div class="container-fluid h-100 p-0">
                <div class="row h-100">
                    <div class="col-md-12 h-100 pb-3">
                        <div class="card p-2 m-0 h-100">
                            <h4 class="text-center m-0 fw-400">Medio de prospección</h4>
                            <div id="medioChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?=base_url()?>dist/js/controllers/dashboard/metricas/dashboardMetrics.js"></script>