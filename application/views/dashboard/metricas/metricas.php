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
                                    <select class="selectpicker select-gral m-0 proyecto" id="proyecto" name="proyecto" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required style="height:100%!important"></select>
                                </div>
                                <div class="col-12 col-sm-3 col-md-3 col-lg-3 m-0 overflow-hidden pl-0">
                                    <select class="selectpicker select-gral m-0 condominio" id="condominio" name="condominio" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required style="height:100%!important"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 h-90 p-0">
                            <div id="ventasMetrosChart"></div>
                            <div class="loadChart emptyVentasMetrosChart w-100 h-100">
                                <img src='<?=base_url('dist/img/emptyCharts.png')?>' alt="Icono gráfica" class="h-50 w-auto">
                            </div>
                            <div class="loadChart loadVentasMetrosChart w-100 h-100 d-none">
                                <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="mainRowMetrics">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 flexibleM inactivo">
            <div class="card p-2">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100 pl-0">
                            <div class="d-flex justify-between h-10 actions align-center">
                                <div class="filters w-50 d-flex">
                                    <div class="w-50 overflow-hidden sedes_box">
                                        <select class="selectpicker select-gral m-0 proyecto" id="sedes" name="sedes" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required style="height:100%!important" ></select>
                                    </div>
                                    <div class="w-50 m-0 overflow-hidden pl-0 proyecto_box">
                                        <select class="selectpicker select-gral m-0 proyecto" id="proyecto2" name="proyecto" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required style="height:100%!important"></select>
                                    </div>
                                </div>
                                <div class="w-40 m-0 pl-0 h-100">
                                    <div class="form-group d-flex m-0">
                                        <input type="text" class="form-control datepicker begin_promedioDates" id="tableBegin_promedio" value="" autocomplete='off'/>
                                        <input type="text" class="form-control datepicker end_promedioDates" id="tableEnd_promedio" value="" autocomplete='off' />
                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRangePromedio">
                                            <span class="material-icons">search</span>
                                        </button>
                                    </div>
                                </div>
                                <button class="btn-charts btnModalDetailsMetricas" ><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChartProm" class="h-80 boxChartPromedio" data-value="promedio">
                                <div id="promedioChart"></div>
                                <div class="loadChart loadPromedioChart w-100 h-100">
                                    <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                            <div class="h-10">
                                <h5 class="text-center m-0 fw-400">Precio promedio por metro cuadrado</h5>
                            </div>
                        </div>
                        <div id="promedio" class="col-12 col-sm-12 col-md-12 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 flexibleM inactivo">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <h4 class="text-center m-0 fw-400">Metros cuadrados (todos los proyectos)</h4>
                                <button class="btn-charts" onclick="toggleDatatableMetrics(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChartM" class="h-90 boxChartMetrics" data-value="metros">
                                <div id="metrosChart"></div>
                                <div class="loadChart loadMetrosChart w-100 h-100">
                                    <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <div id="metros" class="col-12 col-sm-12 col-md-12 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 flexibleM inactivo">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <h4 class="text-center m-0 fw-400">Disponibilidad de lotes por proyecto</h4>
                                <button class="btn-charts" onclick="toggleDatatableMetrics(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChartM2" class="h-90 boxChartMetrics" data-value="disponibilidad">
                                <div id="disponibilidadChart"></div>
                                <div class="loadChart loadDisponibilidadChart w-100 h-100">
                                    <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <div id="disponibilidad" class="col-12 col-sm-12 col-md-12 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 flexibleM inactivo">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <h4 class="text-center m-0 fw-400">Lugar de prospección&nbsp;&nbsp;&nbsp;<i class="fas fa-info-circle" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Datos representativos: Los datos reflejados en esta tabla se alimentan de la información proporcionada por el asesor al dar de alta al prospecto en CRM, por lo que pueden variar según la información proporcionada."></i></h4>
                                <button class="btn-charts" onclick="toggleDatatableMetrics(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChartM3" class="h-90 boxChartMetrics" data-value="lugar">
                                <div id="lugarChart"></div>
                                <div class="loadChart loadLugarChart w-100 h-100">
                                    <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <div id="lugar" class="col-12 col-sm-12 col-md-12 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 flexibleM inactivo">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <h4 class="text-center m-0 fw-400">Medio de prospección&nbsp;&nbsp;&nbsp;<i class="fas fa-info-circle" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Datos representativos: Los datos reflejados en esta tabla se alimentan de la información proporcionada por el asesor al dar de alta al prospecto en CRM, por lo que pueden variar según la información proporcionada."></i></h4>
                                <button class="btn-charts" onclick="toggleDatatableMetrics(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChartM4" class="h-90 boxChartMetrics" data-value="medio">
                                <div id="medioChart"></div>
                                <div class="loadChart loadMedioChart w-100 h-100">
                                    <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <div id="medio" class="col-12 col-sm-12 col-md-12 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>