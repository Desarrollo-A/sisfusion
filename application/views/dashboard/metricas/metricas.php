<link href="<?= base_url() ?>dist/css/metricasDashboard.css" rel="stylesheet"/>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card p-2">
                <div class="container-fluid h-100 p-0">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 h-10">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <h4 class="text-left m-0 fw-400">Ventas por metro cuadrado</h4>
                                </div>
                                <div class="col-12 col-sm-3 col-md-3 col-lg-3 m-0 overflow-hidden">
                                    <!-- <label class="control-label">proyecto</label> -->
                                    <select class="selectpicker select-gral m-0 proyecto" id="proyecto" name="proyecto" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un proyecto" data-size="7" data-container="body" required style="height:100%!important"></select>
                                </div>
                                <div class="col-12 col-sm-3 col-md-3 col-lg-3 m-0 overflow-hidden pl-0">
                                    <!-- <label class="control-label">condominio</label> -->
                                    <select class="selectpicker select-gral m-0 condominio" id="condominio" name="condominio" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un proyecto" data-size="7" data-container="body" required style="height:100%!important"></select>
                                </div>
                                <!-- <div class="col-12 col-sm-8 col-md-8 col-lg-8 d-flex"> -->
                                    <!-- <div class="form-group label-floating select-is-empty overflow-hidden">
                                        <label class="control-label">proyecto</label>
                                        <select id="proyecto" name="proyecto" class="form-control proyecto col-sm-12 col-md-6 col-lg-6"></select>
                                    </div> -->
                                    <!-- <div class="form-group label-floating select-is-empty">
                                        <label class="control-label">condominio</label>
                                        <select id="condominio" name="condominio" class="form-control condominio col-sm-12 col-md-6 col-lg-6"></select>
                                    </div> -->
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 h-90">
                            <div id="ventasMetrosChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <div id="boxChart" class="h-90 boxChart" data-value="metros">
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
                            <div id="boxChart2" class="h-90 boxChart" data-value="disponibilidad">
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
                            <div id="boxChart3" class="h-90 boxChart" data-value="lugar">
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
                            <div id="boxChart4" class="h-90 boxChart" data-value="medio">
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