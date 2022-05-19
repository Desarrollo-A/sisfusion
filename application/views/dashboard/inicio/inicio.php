<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/dashboardStyles.css" rel="stylesheet"/>
<body class="">
    <div class="wrapper ">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title center-align">Dashboard</h3>
                <div class="container-fluid">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12  d-flex row-reverse boxNavPills">
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
                    <div class="row" style="height: 300px;">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 h-100 box1Inicio1" >
                            <div class="row h-60">
                                <div class="col-md-12 h-100">
                                    <div class="card h-100 m-0">
                                        <div class="h-40 m-0">
                                
                                        </div>
                                        <div class="h-60 m-0">
                                            <div class="col-md-12 pb-0 h-100 p-0">
                                                <div id="chart"></div>
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                            <div class="row h-40" style="padding-top: 15px">
                                <div class="col-md-12 h-100">
                                    <div class="card m-0 h-100">
                                        <div class="h-100  m-0">
                                            <div class="col-md-12 h-100 boxGraphic">
                                                <h4 class="text-left">Total Prospectos</h4>
                                                <h2 class="numberGraphic" id="numberGraphic">--</h2>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 h-100 box1Inicio2 pl-0" >
                            <div class="card h-100 m-0">
                                <div class="row h-20 m-0">
                                    <div class="col-md-3  h-100 boxGraphic">
                                        <h4 class="text-left">Total de ventas</h4>
                                        <h2 class="numberGraphic" id="total_ventas">--</h2>
                                    </div>
                                </div>
                                <div class="row h-80  m-0">
                                    <div class="col-md-12 pb-0  d-flex align-end">
                                        <div class="col-md-12 pb-0 h-50">
                                            <div id="chart2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pdt-50">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12  d-flex row-reverse boxNavPills">
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
                        <div class="col-md-3 box1Inicio3" >
                            <div class="card h-100">
                                <div class="card-header">
                                    <h4 class="card-title">Lorem ipsue
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="row" >
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 infoElementBox">
                                            <h4>Prospectos totales</h4>
                                            <h2 id="pt_card" class="subtitle_skeleton numberElement"></h2>

                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align iconElementBox">
                                            <button class="btn btn-success btn-round btn-fab btn-fab">
                                                <i class="material-icons">person</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 infoElementBox">
                                            <h4>Nuevos prospectos</h4>
                                            <h2 id="np_card" class="subtitle_skeleton numberElement">--</h2>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align iconElementBox">
                                            <button class="btn btn-primary btn-round btn-fab btn-fab">
                                                <i class="material-icons">person_add</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 infoElementBox">
                                            <h4>Ventas apartados</h4>
                                            <h2 id="va_card" class="subtitle_skeleton numberElement">--</h2>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align iconElementBox">
                                            <button class="btn btn-round btn-fab btn-fab">
                                                <i class="material-icons">record_voice_over</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 infoElementBox">
                                            <h4>Cancelados apartados</h4>
                                            <h2 id="ca_card" class="subtitle_skeleton numberElement">--</h2>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align iconElementBox">
                                            <button class="btn btn-round btn-danger  btn-fab btn-fab">
                                                <i class="material-icons">close</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 box1Inicio3" >
                            <div class="card h-100">
                                <div class="card-header">
                                    <h4 class="card-title">Lorem ipsue
                                    </h4>
                                </div>
                                <div class="card-content">
                                    <div class="row" >
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 infoElementBox">
                                            <h4>Cierres totales</h4>
                                            <h2 id="ct_card" class="subtitle_skeleton numberElement">--</h2>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align iconElementBox">
                                            <button class="btn btn-fab btn-fab" style="background-color: orange">
                                                <i class="material-icons">do_not_disturb</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 infoElementBox">
                                            <h4>Prospectos con cita</h4>
                                            <h2 id="pcc_card" class="subtitle_skeleton numberElement">--</h2>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align iconElementBox">
                                            <button class="btn btn-primary btn-round btn-fab btn-fab">
                                                <i class="material-icons">where_to_votes</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 infoElementBox">
                                            <h4>Ventas contratadas</h4>
                                            <h2 id="vc_card" class="subtitle_skeleton numberElement">--</h2>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align iconElementBox">
                                            <button class="btn btn-success btn-round btn-fab btn-fab">
                                                <i class="material-icons">how_to_reg</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 infoElementBox">
                                            <h4>Contratos Cancelados</h4>
                                            <h2 id="cc_card" class="subtitle_skeleton numberElement">--</h2>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 center-align iconElementBox">
                                            <button class="btn btn-round btn-danger  btn-fab btn-fab">
                                                <i class="material-icons">layers_clear</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 box1Inicio4" >
                            <div class="card h-100">
                                <div class="card-header">
                                    <h4 class="card-title">Lorem ipsue</h4>
                                </div>
                                <div class="card-content">
                                    <div class="row" >
                                        <div id="chart4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend'); ?>
</body>
<?php $this->load->view('template/footer');?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="<?=base_url()?>dist/js/controllers/dashboard/inicio/dashboardHome.js"></script>

