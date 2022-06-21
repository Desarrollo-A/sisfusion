<link href="<?= base_url() ?>dist/css/rankingDashboard.css" rel="stylesheet"/>

<div class="container-fluid p-0">
    <div class="row" id="mainRow">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <label class="selectMini m-0">Sedes</label>
                                <div class="form-group d-flex m-0 p-0">
                                    <input type="text" class="form-control datepicker text-center pl-1" id="beginDate" value="21/06/2022"/>
                                    <input type="text" class="form-control datepicker text-center " id="endDate" value="21/06/2022"/>
                                    <button class="btn-search" id="searchByDateRange">
                                        <span class="material-icons update-dataTable">search</span>
                                    </button>
                                </div>
                                <button class="btn-charts" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div class="h-80">
                                <div id="chart"></div>
                            </div>
                            <div class="h-10">
                                <h5 class="m-0 text-center">Ventas de apartados</h5>
                            </div>
                        </div>
                        <div id="Apartados" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden h-100 p-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <label class="selectMini m-0">Sedes</label>     
                                <div class="form-group d-flex m-0 p-0">
                                    <input type="text" class="form-control datepicker text-center pl-1" id="beginDate" value="21/06/2022"/>
                                    <input type="text" class="form-control datepicker text-center " id="endDate" value="21/06/2022"/>
                                    <button class="btn-search" id="searchByDateRange">
                                        <span class="material-icons update-dataTable">search</span>
                                    </button>
                                </div>
                                <button class="btn-charts" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div class="h-80">
                                <div id="chart2"></div>
                            </div>
                            <div class="h-10">
                                <h5 class="m-0 text-center">Ventas con contrato</h5>
                            </div>
                        </div>
                        <div id="Contratados" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <label class="selectMini m-0">Sedes</label>     
                                <div class="form-group d-flex m-0 p-0">
                                    <input type="text" class="form-control datepicker text-center pl-1" id="beginDate" value="21/06/2022"/>
                                    <input type="text" class="form-control datepicker text-center " id="endDate" value="21/06/2022"/>
                                    <button class="btn-search" id="searchByDateRange">
                                        <span class="material-icons update-dataTable">search</span>
                                    </button>
                                </div>
                                <button class="btn-charts" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div class="h-80">
                                <div id="chart3"></div>
                            </div>
                            <div class="h-10">
                                <h5 class="m-0 text-center">Ventas con enganche</h5>
                            </div>
                        </div>
                        <div id="ConEnganche" class="col-12 col-sm-6 col-md-6 col-lg-6 col-datatable hidden">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 inactivo flexible">
            <div class="card">
                <div class="container-fluid h-100">
                    <div class="row h-100">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-chart h-100">
                            <div class="d-flex justify-between h-10 actions">
                                <label class="selectMini m-0">Sedes</label>
                                <div class="form-group d-flex m-0 p-0">
                                    <input type="text" class="form-control datepicker text-center pl-1" id="beginDate" value="21/06/2022"/>
                                    <input type="text" class="form-control datepicker text-center " id="endDate" value="21/06/2022"/>
                                    <button class="btn-search" id="searchByDateRange">
                                        <span class="material-icons update-dataTable">search</span>
                                    </button>
                                </div>
                                <button class="btn-charts" onclick="toggleDatatable(this)"><i class="far fa-list-alt"></i></button>
                            </div>
                            <div class="h-80">
                                <div id="chart4"></div>
                            </div>
                            <div class="h-10">
                                <h5 class="m-0 text-center">Ventas sin enganche</h5>
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
<script src="<?=base_url()?>dist/js/controllers/dashboard/ranking/dashboardRanking.js"></script>