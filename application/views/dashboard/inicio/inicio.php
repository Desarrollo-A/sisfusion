<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/dashboardStyles.css" rel="stylesheet"/>
<div class="">
    <div class="card-content pt-2">
        <div class="container-fluid">
            <div class="col-md-12 d-flex row-reverse boxNavPills">
                <div class="ck-button">
                    <label>
                        <input type="checkbox" value="2" name="infoMainSelector" id="infoMainSelector2" class="infoMainSelector"><span>Asesores </span>
                    </label>
                </div>
                <div class="ck-button">
                    <label>
                        <input type="checkbox" value="1" name="infoMainSelector" id="infoMainSelector1" class="infoMainSelector" checked><span>Propios </span>
                    </label>
                </div>

            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2" style="height: 400px;">
                <div class=" col-md-3 h-100 box1Inicio1" >
                    <div class="row h-70">
                        <div class="col-md-12 h-100">
                            <div class="card pt-1 h-100 m-0">
                                <div class="h-100 m-0">
                                    <div class="col-md-12 pb-0 h-100 p-0 d-flex align-center">
                                        <div id="totalVentasChart"></div>
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>
                    <div class="row h-30" style="padding-top: 15px">
                        <div class="col-md-12 h-100">
                            <div class="card m-0 h-100">
                                <div class="h-100  m-0">
                                    <div class="col-md-12 h-100 boxGraphic">
                                        <div class="row h-20">
                                            <div class="f-bolder">
                                                Total prospectos anuales
                                            </div>
                                        </div>
                                        <div class="row h-80">
                                            <div class="col-md-4 h-100">
                                                <div id="numberGraphic" class="h-60 d-flex justify-center align-center numberGraphic">
                                                    --
                                                </div>
                                                <div class="h-20 f-bolder d-flex justify-center">
                                                    Vigentes
                                                </div>
                                            </div>
                                            <div class="col-md-8 h-100 pl-0 pr-0">
                                                <div id="prospectosChart" class="h-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="col-md-9 h-100 box1Inicio2 pl-0" >
                    <div class="card h-100 m-0">
                        <div class="row h-20 m-0">
                            <div class="col-md-8 text-left">
                                <h3>Clientes y prospectos por mes.</h3>
                            </div>
                            <div class="col-md-4">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-md-12 p-r">
                                            <div class="form-group d-flex">
                                                <input type="text" class="form-control datepicker"
                                                    id="beginDate" value="01/01/2022" autocomplete='off'/>
                                                <input type="text" class="form-control datepicker"
                                                    id="endDate" value="28/02/2022" autocomplete='off' />
                                                <button
                                                    class="btn btn-success btn-round btn-fab btn-fab-mini"
                                                    id="searchByDateRange">
                                                    <span
                                                        class="material-icons update-dataTable">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row h-80 m-0">
                            <div class="col-md-12 pb-0 h-100 d-flex align-end pl-0 pr-0">
                                <div class="col-md-12 pb-0 h-100 pl-0 pr-0">
                                    <div id="chartProspClients"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="height: 500px;">
                <div class="col-md-8 h-100 box1Inicio1" >
                    <div class="card h-100 m-0">
                        <div class="row h-60 m-0">
                            <div class="col-md-4 h-20 d-flex align-center">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-md-12 p-r">
                                            <div class="form-group d-flex">
                                                <input type="text" class="form-control datepicker"
                                                    id="beginDate" value="01/01/2022" autocomplete='off'/>
                                                <input type="text" class="form-control datepicker"
                                                    id="endDate" value="28/02/2022" autocomplete='off' />
                                                <button
                                                    class="btn btn-success btn-round btn-fab btn-fab-mini"
                                                    id="searchByDateRange">
                                                    <span
                                                        class="material-icons update-dataTable">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 h-20 d-flex justify-end">
                                <ul class="nav nav-pills">
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
                            <div class="col-md-12 pb-0 h-80 p-0">
                                <div id="chartWeekly"></div>
                            </div>
                        </div>
                        <div class="row h-40 m-0 pb-1 pt-1">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6 pb-0 h-100 m-0">
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
                                    <div class="col-md-6 pb-0 h-100 m-0">
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
                </div>
                <div class="col-md-4 h-100 box1Inicio2 pl-0" >
                    <div class="card pt-1 h-100 m-0">
                        <div class="row h-60 m-0">
                            <div class="col-md-12 p-0 h-100">
                                <div id="chartFunnel"></div>
                            </div>
                        </div>
                        <div class="row h-40  m-0" style="font-size: 1.1rem;">
                            <div class="col-md-12 pb-0 h-50 m-0">
                                <div class="d-flex col-sm-4" >
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-center">
                                            <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                        </div>  
                                        <div class="col-md-12 d-flex justify-center">
                                            <p class="m-0">Alta CRM</p>
                                        </div>    
                                        <div class="col-md-12 d-flex justify-center">
                                            <h4 id="alta" class="subtitle_skeleton numberElement mb-0">0</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-sm-4" >
                                    <div class="row">
                                        <div class="col-sm-12 d-flex justify-center">
                                            <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-center text-center">
                                            <p class="m-0">Corrida financiera</p>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-center">
                                            <h4 id="cf" class="subtitle_skeleton numberElement mb-0">0</h4>
                                        </div>    
                                    </div>
                                </div>
                                <div class="d-flex col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12 d-flex justify-center">
                                            <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-center">
                                            <p class="m-0">Cita</p>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-center">
                                            <h4 id="cita" class="subtitle_skeleton numberElement mb-0">0</h4>
                                        </div>    
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-12 pb-0 h-50 m-0">
                                <div class="d-flex col-sm-4" >
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-center">
                                            <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                        </div>  
                                        <div class="col-md-12 d-flex justify-center">
                                            <p class="m-0">Cita seguimiento</p>
                                        </div>    
                                        <div class="col-md-12 d-flex justify-center">
                                            <h4 id="alta" class="subtitle_skeleton numberElement mb-0">0</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex col-sm-4" >
                                    <div class="row">
                                        <div class="col-sm-12 d-flex justify-center">
                                            <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-center text-center">
                                            <p class="m-0">Apartados</p>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-center">
                                            <h4 id="cf" class="subtitle_skeleton numberElement mb-0">0</h4>
                                        </div>    
                                    </div>
                                </div>
                                <div class="d-flex col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12 d-flex justify-center">
                                            <i class="fas fa-circle pr-2 pl-2 dot"></i>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-center">
                                            <p class="m-0">No interesado</p>
                                        </div>
                                        <div class="col-sm-12 d-flex justify-center">
                                            <h4 id="cita" class="subtitle_skeleton numberElement mb-0">0</h4>
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
<script src="<?=base_url()?>dist/js/controllers/dashboard/inicio/dashboardHome.js"></script>

