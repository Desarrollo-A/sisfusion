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
                        <div class="col-12 col-sm-8 col-md-8 col-lg-8 p-0">
                            <h4 class="m-0 fw-400">Clientes y prospectos por mes</h4>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 h-100">
                            <div class="form-group d-flex m-0">
                                <input type="text" class="form-control datepicker beginDates" id="beginDate" value="" autocomplete='off'/>
                                <input type="text" class="form-control datepicker endDates" id="endDate" value="" autocomplete='off' />
                                <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRangeCP">
                                    <span class="material-icons update-dataTable">search</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row h-90">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 pb-0 h-100 pl-0 pr-0">
                            <div id="chartProspClients"></div>
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
                            <h4 class="text-center m-0 fw-400">Total de ventas</h4>
                            <div id="totalVentasChart"></div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-12 col-prospectos">
                        <div class="card p-0 h-100 cardProspectosVig">
                            <div class="container-fluid h-100">
                                <div class="row h-100">
                                    <div class="col-md-12 h-30 pl-2 pt-2 pr-2 d-flex justify-between align-center">
                                        <div class="d-flex align-center">
                                            <span class="boxIcoProsp"><i class="fas fa-user"></i></span>
                                            <span id="numberGraphic" class="numberGraphic">
                                            </span>
                                        </div>
                                        <p class="m-0">prospectos anuales <span class="">vigentes</span></p>
                                        
                                    </div>
                                    <div class="col-md-12 h-70 p-0">
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
                                    <span class="material-icons update-dataTable">search</span>
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
                        </div>
                    </div>
                    <div class="row m-0 h-40">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 pl-0">
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 txt-lapisLazuli"></i>
                                <p class="m-0">Prospectos totales</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="pt_card" class="subtitle_skeleton numberElement m-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 txt-blueNCS"></i>
                                <p class="m-0">Nuevos prospectos</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="np_card" class="subtitle_skeleton numberElement m-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 txt-viridianGreen"></i>
                                <p class="m-0">Prospectos con cita</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="pcc_card" class="subtitle_skeleton numberElement m-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 txt-tiffanyBlue"></i>
                                <p class="m-0">Cierres totales</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="ct_card" class="subtitle_skeleton numberElement m-0"></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 pr-0">
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 txt-oceanGreen"></i>
                                <p class="m-0">Ventas contratadas</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="vc_card" class="subtitle_skeleton numberElement m-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 txt-caribbeanGreen"></i>
                                <p class="m-0">Ventas apartados</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="va_card" class="subtitle_skeleton numberElement m-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 txt-lightGreen"></i>
                                <p class="m-0">Cancelados contratados</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="cc_card" class="subtitle_skeleton numberElement m-0"></h4>
                                </div>
                            </div>
                            <div class="d-flex" >
                                <div class="w-80 d-flex align-center">
                                <i class="fas fa-circle pr-2 pl-2 txt-sunny"></i>
                                <p class="m-0">Cancelados apartados</p>
                                </div>
                                <div class="w-20">
                                    <h4 id="ca_card" class="subtitle_skeleton numberElement m-0"></h4>
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
                    <div class="row h-50">
                        <div class="col-md-12 p-0 h-100">
                            <h4 class="text-center m-0 fw-400">Embudo de ventas</h4>
                            <div id="chartFunnel"></div>
                        </div>
                    </div>
                    <div class="row h-50">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 pl-2 txt-lapisLazuli"></i>
                                <p class="m-0">Prospectos</p>
                            </div>
                            <h4 id="ac" class="subtitle_skeleton numberElement2 m-0"></h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 pl-2 txt-viridianGreen"></i>
                                <p class="m-0">Cita</p>
                            </div>
                            <h4 id="cita" class="subtitle_skeleton numberElement2 m-0"></h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 pl-2 txt-tiffanyBlue"></i>
                                <p class="m-0">Cita seguimiento</p>
                            </div>
                            <h4 id="cs" class="subtitle_skeleton numberElement2 m-0"></h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 pl-2 txt-caribbeanGreen"></i>
                                <p class="m-0">No interesado</p>
                            </div>
                            <h4 id="ni" class="subtitle_skeleton numberElement2 m-0"></h4>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-between pt-1 pl-0">
                            <div class="d-flex">
                                <i class="fas fa-circle pr-2 pl-2 txt-oceanGreen"></i>
                                <p class="m-0">Apartados</p>
                            </div>
                            <h4 id="ap" class="subtitle_skeleton numberElement2 m-0"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    rol = <?= $this->session->userdata('id_rol') ?> ;
</script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/inicio/dashboardHome.js"></script>