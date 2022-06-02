<link href="<?= base_url() ?>dist/css/inicioDashboard.css" rel="stylesheet"/>

<div class="container-fluid pb-1">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
            <div class="back d-flex">
                <label class="m-0 checkBox" >
                    <input type="checkbox" class="d-none" onClick="" value="1" name="infoMainSelector" id="infoMainSelector1" checked>
                    <span class="mr-1">Propios</span>
                </label>
                <label class="m-0 checkBox" >
                    <input type="checkbox" class="d-none" onClick="" value="2" name="infoMainSelector" id="infoMainSelector2" class="infoMainSelector">
                    <span>Asesores</span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pb-1 first-row">
    <div class="row" style="height: 450px;">
        <div class="col-12 col-sm-9 col-md-9 col-lg-9 h-100">
            <div class="card p-2 h-100 m-0">
                <div class="container-fluid h-100">
                    <div class="row h-10">
                        <div class="col-12 col-sm-8 col-md-8 col-lg-8 p-0">
                            <h4 class="m-0 fw-400">Clientes y prospectos por mes.</h4>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 h-100">
                            <div class="form-group d-flex m-0">
                                <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2022" autocomplete='off'/>
                                <input type="text" class="form-control datepicker" id="endDate" value="28/02/2022" autocomplete='off' />
                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                    <span class="material-icons update-dataTable">search</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row h-90">
                        <div class="col-md-12 pb-0 h-100 d-flex align-end pl-0 pr-0">
                            <div class="col-md-12 pb-0 h-100 pl-0 pr-0">
                                <div id="chartProspClients"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-3 col-md-3 col-lg-3 h-100">
            <div class="container-fluid h-100 p-0">
                <div class="row h-70">
                    <div class="col-md-12 h-100 pb-3">
                        <div class="card p-2 m-0 h-100">
                            <h4 class="text-center m-0 fw-400">Total de ventas</h4>
                            <div id="totalVentasChart"></div>
                        </div>
                    </div>
                </div>
                <div class="row h-30">
                    <div class="col-md-12 h-100">
                        <div class="card p-0 m-0 h-100 cardProspectosVig">
                            <div class="container-fluid h-100">
                                <div class="row h-100">
                                    <div class="col-md-12 h-20 pl-2 pt-2 pr-2">
                                        <p class="m-0">prospectos anuales <span class="">vigentes</span></p>
                                        <div class="d-flex align-center">
                                            <span class="boxIcoProsp"><i class="fas fa-user"></i></span>
                                            <span id="numberGraphic" class="numberGraphic">334
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 h-80 p-0">
                                        <div id="prospectosChart"></div>
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

<div class="container-fluid mt-3">
    <div class="row" style="height: 500px;">
        <div class="col-12 col-sm-12 col-md-9 col-lg-9 h-100">
            <div class="card h-100 m-0 p-2">
                <div class="container-fluid h-100 p-0">
                    <div class="row m-0 h-10">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 p-0">
                            <div class="form-group d-flex m-0">
                                <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2022" autocomplete='off'/>
                                <input type="text" class="form-control datepicker" id="endDate" value="28/02/2022" autocomplete='off'/>
                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                    <span class="material-icons update-dataTable">search</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 p-0 d-flex justify-end">
                            <ul class="nav nav-pills m-0">
                                <li class="active" onclick="weekFilter(this.id)" id="thisWeek">
                                    <a href="#thisWeek" data-toggle="tab" >Esta semana</a>
                                </li>
                                <li onclick="weekFilter(this.id)" id="lastWeek">
                                    <a href="#lastWeek" data-toggle="tab" >Semana pasada</a>
                                </li>
                                <li onclick="weekFilter(this.id)" id="lastMonth">
                                    <a href="#lastMonth" data-toggle="tab" >Último mes</a>
                                </li>
                            </ul> 
                        </div>
                    </div>
                    <div class="row m-0 h-50">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 h-100 p-0">
                            <div id="chartWeekly"></div>
                        </div>
                    </div>
                    <div class="row m-0 h-40">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 pl-0">
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                <p class="m-0">Prospectos totales</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="ct_card" class="subtitle_skeleton numberElement mb-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                <p class="m-0">Nuevos prospectos</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="pcc_card" class="subtitle_skeleton numberElement mb-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                <p class="m-0">Ventas apartados</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="vc_card" class="subtitle_skeleton numberElement mb-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                <p class="m-0">Cancelados apartados</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="cc_card" class="subtitle_skeleton numberElement mb-0"></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 pr-0">
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                <p class="m-0">Prospectos totales</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="pt_card" class="subtitle_skeleton numberElement mb-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                <p class="m-0">Nuevos prospectos</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="np_card" class="subtitle_skeleton numberElement mb-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                <p class="m-0">Ventas apartados</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="va_card" class="subtitle_skeleton numberElement mb-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                <p class="m-0">Cancelados apartados</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="ca_card" class="subtitle_skeleton numberElement mb-0"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-3 col-lg-3 h-100">
            <div class="card p-2 h-100 m-0">
                <div class="container-fluid h-100">
                    <div class="row h-60">
                        <div class="col-md-12 p-0 h-100">
                            <h7 class="m-0 fw-400">Clientes y prospectos por mes</h7>
                            <div id="chartFunnel"></div>
                        </div>
                    </div>
                    <div class="row h-40">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between p-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 dot"></i>
                                <p class="m-0">Alta CRM</p>
                            </div>
                            <h4 id="alta" class="subtitle_skeleton numberElement m-0">0</h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between p-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 dot"></i>
                                <p class="m-0">Corrida financiera</p>
                            </div>
                            <h4 id="cf" class="subtitle_skeleton numberElement m-0">0</h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between p-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 dot"></i>
                                <p class="m-0">Cita</p>
                            </div>
                            <h4 id="cita" class="subtitle_skeleton numberElement m-0">0</h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between p-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 dot"></i>
                                <p class="m-0">Cita seguimiento</p>
                            </div>
                            <h4 id="alta" class="subtitle_skeleton numberElement m-0">0</h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between p-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 dot"></i>
                                <p class="m-0">Apartados</p>
                            </div>
                            <h4 id="cf" class="subtitle_skeleton numberElement m-0">0</h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between p-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 dot"></i>
                                <p class="m-0">No interesado</p>
                            </div>
                            <h4 id="cita" class="subtitle_skeleton numberElement m-0">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>dist/js/controllers/dashboard/inicio/dashboardHome.js"></script>