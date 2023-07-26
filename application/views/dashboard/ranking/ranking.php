<link href="<?= base_url() ?>dist/css/rankingDashboard.css" rel="stylesheet"/>

<div class="container-fluid p-0">
    <div class="row" id="mainRowRanking">
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 inactivo flexibleR">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <div id="boxSede1" class="boxSedes w-30 " ></div>
                                <div class="form-group d-flex m-0 p-0 w-50">
                                    <input type="text" class="form-control datepicker text-center pl-1 beginDate" id="beginDateApartados"/>
                                    <input type="text" class="form-control datepicker text-center endDate" id="endDateApartados"/>
                                    <button class="btn-search" id="searchByDateRangeRanking" onclick="getRankings(false, 'Apartados')">
                                        <span class="material-icons">search</span>
                                    </button>
                                </div>
                                <button class="btn-charts" onclick="toggleDatatable(this)" rel="tooltip" data-placement="bottom" title="Mostrar tabla"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChart" class="h-80 boxChartRanking">
                                <div id="chart" class="chart h-100"></div>
                            </div>
                            <div class="h-10">
                                <h5 class="m-0 text-center titles">Ventas de apartados</h5>
                            </div>
                        </div>
                        <div id="Apartados" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 inactivo flexibleR">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <div id="boxSede2" class="boxSedes w-30"></div>
                                <div class="form-group d-flex m-0 p-0 w-50">
                                    <input type="text" class="form-control datepicker text-center pl-1 beginDate" id="beginDateContratados"/>
                                    <input type="text" class="form-control datepicker text-center endDate" id="endDateContratados"/>
                                    <button class="btn-search" id="searchByDateRangeRanking" onclick="getRankings(false, 'Contratados')">
                                        <span class="material-icons">search</span>
                                    </button>
                                </div>
                                <button class="btn-charts" onclick="toggleDatatable(this)" rel="tooltip" data-placement="bottom" title="Mostrar tabla"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChart2" class="h-80 boxChartRanking">
                                <div id="chart2" class="chart"></div>
                            </div>
                            <div class="h-10">
                                <h5 class="m-0 text-center titles">Ventas con contrato</h5>
                            </div>
                        </div>
                        <div id="Contratados" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 inactivo flexibleR">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <div id="boxSede3" class="boxSedes w-30"></div>
                                <div class="form-group d-flex m-0 p-0 w-50">
                                    <input type="text" class="form-control datepicker text-center pl-1 beginDate" id="beginDateConEnganche"/>
                                    <input type="text" class="form-control datepicker text-center endDate" id="endDateConEnganche"/>
                                    <button class="btn-search" id="searchByDateRangeRanking" onclick="getRankings(false, 'ConEnganche')">
                                        <span class="material-icons">search</span>
                                    </button>
                                </div>
                                <button class="btn-charts" onclick="toggleDatatable(this)" rel="tooltip" data-placement="bottom" title="Mostrar tabla"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChart3" class="h-80 boxChartRanking">
                                <div id="chart3" class="chart"></div>
                            </div>
                            <div class="h-10">
                                <h5 class="m-0 text-center titles">Ventas con enganche</h5>
                            </div>
                        </div>
                        <div id="ConEnganche" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 inactivo flexibleR">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <div id="boxSede4" class="boxSedes w-30"></div>
                                <div class="form-group d-flex m-0 p-0 w-50">
                                    <input type="text" class="form-control datepicker text-center pl-1 beginDate" id="beginDateSinEnganche"/>
                                    <input type="text" class="form-control datepicker text-center endDate" id="endDateSinEnganche"/>
                                    <button class="btn-search" id="searchByDateRangeRanking" onclick="getRankings(false, 'SinEnganche')">
                                        <span class="material-icons">search</span>
                                    </button>
                                </div>
                                <button type="btn" class="btn-charts"  rel="tooltip" data-placement="bottom" title="Mostrar tabla" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div id="boxChart4" class="h-80 boxChartRanking">
                                <div id="chart4" class="chart"></div>
                            </div>
                            <div class="h-10">
                                <h5 class="m-0 text-center titles">Ventas sin enganche</h5>
                            </div>
                        </div>
                        <div id="sinEnganche" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>