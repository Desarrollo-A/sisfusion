<link href="<?= base_url() ?>dist/css/inicioDashboard.css" rel="stylesheet"/>

<div class="container-fluid" >
    <div class="row" id="buttonsCoord">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end">
            <div class="back d-flex">
                <label class="m-0 checkBox" >
                    <input type="checkbox" class="d-none infoMainSelector" onClick="" value="1" name="infoMainSelector" id="infoMainSelector1" checked>
                    <span class="mr-1">Propios</span>
                </label>
                <label class="m-0 checkBox" >
                    <input type="checkbox" class="d-none infoMainSelector" onClick="" value="2" name="infoMainSelector" id="infoMainSelector2">
                    <span>Asesores</span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-9">
            <div class="card p-2">
                <div class="container-fluid h-100">
                    <div class="row h-10">
                        <div class="col-12 col-sm-6 col-md-8 col-lg-7 p-0">
                            <h4 class="m-0 fw-400 leyendapadre">Clientes y prospectos por mes</h4>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-5 h-100">
                            <div class="form-group d-flex m-0">
                                <input type="text" class="form-control datepicker beginDates" id="beginDate" value="" autocomplete='off'/>
                                <input type="text" class="form-control datepicker endDates" id="endDate" value="" autocomplete='off' />
                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRangeCP">
                                    <span class="material-icons">search</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row h-90">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 pb-0 h-100 pl-0 pr-0">
                            <div id="chartProspClients"></div>
                            <div class="loadChart loadChartProspClients w-100 h-100 d-none">
                                <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-6 col-sm-6 col-md-6 col-lg-12 pb-3 col-total">
                        <div class="card p-2 h-100">
                            <div class="row h-10">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <h4 class="text-center m-0 fw-400">Total de ventas</h4>
                                </div>
                            </div>
                            <div class="row h-90">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 h-100 p-0">
                                    <div id="totalVentasChart"></div>
                                    <div class="loadChart loadTotalVentasChart w-100 h-100 d-none">
                                        <img src='<?=base_url('dist/img/emptyCharts.png')?>' alt="Icono gráfica" class="h-70 w-auto d-none">
                                        <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-12 col-prospectos">
                        <div class="card p-0 h-100 cardProspectosVig">
                            <div class="container-fluid h-100">
                                <div class="row h-100">
                                    <div class="col-md-12 h-30 pl-2 pt-2 pr-2 d-flex justify-between align-center cursor-point"
                                         onClick="prospectsTable()" data-toggle="tooltip" data-placement="top" title="MÁS DETALLE">
                                        <div class="w-40 d-flex align-center" >
                                            <span class="boxIcoProsp"><i class="fas fa-user"></i></span>
                                            <p class="m-0 overflow-text numberGraphic" id="numberGraphic" rel="tooltip" data-placement="left" title="">
                                            </p>
                                        </div>
                                        <div class="w-60 leyend">
                                            <p class="m-0">prospectos anuales <span>vigentes</span></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 h-70 p-0">
                                        <div id="prospectosChart"></div>
                                        <div class="loadChart loadProspectosChart w-100 h-100 d-none">
                                            <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
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

<div class="container-fluid" id="prospects-section">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="container-fluid h-100 p-0">
                <div class="table-dinamic">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="estadisticas" class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-9 col-lg-9">
            <div class="card p-2">
                <div class="container-fluid h-100 p-0">
                    <div class="row m-0 h-10">
                        <h4 class="text-left m-0 fw-400 pb-1">Estadísticas generales</h4>
                        <div class="col-12 col-sm-5 col-md-4 col-lg-4 p-0">
                            <div class="form-group d-flex m-0">
                                <input type="text" class="form-control datepicker beginDates" id="beginDate2" value="" autocomplete='off'/>
                                <input type="text" class="form-control datepicker endDates" id="endDate2" value="" autocomplete='off'/>
                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange2">
                                    <span class="material-icons">search</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-7 col-md-8 col-lg-8 p-0 d-flex justify-end">
                            <ul class="nav nav-pills m-0">
                                <li class="active week" id="thisWeek">
                                    <a href="#thisWeek" data-toggle="tab" >Esta semana</a>
                                </li>
                                <li class="week" id="lastWeek">
                                    <a href="#lastWeek" data-toggle="tab" >Semana pasada</a>
                                </li>
                                <li class="week" id="lastMonth">
                                    <a href="#lastMonth" data-toggle="tab" >Último mes</a>
                                </li>
                            </ul> 
                        </div>
                    </div>
                    <div class="row m-0 h-50">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 h-100 p-0">
                            <div id="chartWeekly"></div>
                            <div class="loadChart loadChartWeekly w-100 h-100 d-none">
                                <img src= '<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 h-40">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 pl-0">
                            <div class="d-flex" >
                                <div class="w-60 d-flex align-center">
                                <font color="#103F75"><i class="fas fa-circle pr-2 pl-2"></i></font>
                                <p class="m-0 labelTitle">Prospectos totales</p>
                                </div>
                                <div class="w-40">
                                    <h4 id="pt_card" class="numberElement m-0 overflow-text text-center"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-60 d-flex align-center">
                                <font color="#006A9D"><i class="fas fa-circle pr-2 pl-2"></i></font>
                                <p class="m-0 labelTitle">Nuevos prospectos</p>
                                </div>
                                <div class="w-40">
                                    <h4 id="np_card" class="numberElement m-0 overflow-text text-center"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-60 d-flex align-center">
                                <font color="#0089B7"><i class="fas fa-circle pr-2 pl-2"></i></font>
                                <p class="m-0 labelTitle">Prospectos con cita</p>
                                </div>
                                <div class="w-40">
                                    <h4 id="pcc_card" class="numberElement m-0 overflow-text text-center"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-60 d-flex align-center">
                                <font color="#039590"><i class="fas fa-circle pr-2 pl-2"></i></font>
                                <p class="m-0 labelTitle">Cierres totales</p>
                                </div>
                                <div class="w-40">
                                    <h4 id="ct_card" class="numberElement m-0 overflow-text text-center"></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 pr-0">
                            <div class="d-flex" >
                                <div class="w-60 d-flex align-center">
                                <font color="#008EAB"><i class="fas fa-circle pr-2 pl-2"></i></font>
                                <p class="m-0 labelTitle">Ventas contratadas</p>
                                </div>
                                <div class="w-40">
                                    <h4 id="vc_card" class="numberElement m-0 overflow-text text-center"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-60 d-flex align-center">
                                <font color="#00ACB8"><i class="fas fa-circle pr-2 pl-2"></i></font>
                                <p class="m-0 labelTitle">Ventas apartados</p>
                                </div>
                                <div class="w-40">
                                    <h4 id="va_card" class="numberElement m-0 overflow-text text-center"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-60 d-flex align-center">
                                <font color="#16C0B4"><i class="fas fa-circle pr-2 pl-2"></i></font>
                                <p class="m-0 labelTitle">Cancelados contratados</p>
                                </div>
                                <div class="w-40">
                                    <h4 id="cc_card" class="numberElement m-0 overflow-text text-center"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-60 d-flex align-center">
                                <font color="#4BBC8E"><i class="fas fa-circle pr-2 pl-2"></i></font>
                                <p class="m-0 labelTitle">Cancelados apartados</p>
                                </div>
                                <div class="w-40">
                                    <h4 id="ca_card" class="numberElement m-0 overflow-text text-center"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
            <div class="card p-2">
                <div class="container-fluid h-100">
                    <div class="row h-50" id="rowEmbudoChart">
                        <div class="col-md-12 p-0 h-10">
                            <h4 class="text-center m-0 fw-400">Embudo de ventas</h4>
                        </div>
                        <div class="col-md-12 p-0 h-90">
                            <div id="chartFunnel"></div>
                            <div class="loadChart loadChartFunnel w-100 h-100 d-none">
                                <img src='<?=base_url('dist/img/chartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                            </div>
                        </div>
                    </div>
                    <div class="row h-50" id="rowEmbudoData">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0">
                            <div class="d-flex">
                                <font color="#103F75"><i class="fas fa-circle pr-1 pl-2"></i></font>
                                <p class="m-0 labelTitle">Prospectos</p>
                            </div>
                            <h4 id="ac" class="numberElement m-0"></h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0 mt-1">
                            <div class="d-flex">
                                <font color="#006A9D"><i class="fas fa-circle pr-1 pl-2"></i></font>
                                <p class="m-0 labelTitle">Cita</p>
                            </div>
                            <h4 id="cita" class="numberElement m-0"></h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0 mt-1">
                            <div class="d-flex">
                                <font color="#0089B7"><i class="fas fa-circle pr-1 pl-2"></i></font>
                                <p class="m-0 labelTitle">Cita seguimiento</p>
                            </div>
                            <h4 id="cs" class="numberElement m-0"></h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0 mt-1">
                            <div class="d-flex">
                                <font color="#039590"><i class="fas fa-circle pr-1 pl-2"></i></font>
                                <p class="m-0 labelTitle">No interesado</p>
                            </div>
                            <h4 id="ni" class="numberElement m-0"></h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0 mt-1">
                            <div class="d-flex">
                                <font color="#008EAB"><i class="fas fa-circle pr-1 pl-2"></i></font>
                                <p class="m-0 labelTitle">Apartados</p>
                            </div>
                            <h4 id="ap" class="numberElement m-0"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>