<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
            <div class="card p-0 cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">ventas<br> <span class="str">contratadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end">
                            <label class="selectMini m-0">4 meses <span class="material-icons">show_chart</span></label>
                        </div>
                    </div>
                    <div class="row pl-2 pr-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <p class="mt-1 money" id="totventasContratadas"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="boxMiniCharts d-flex justify-center align-start" id="ventasContratadas">
                                <img src="./dist/img/emptyChart.png" alt="Icono gráfica" class="h-70 w-auto">
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="bottom" title="Más detalle" onclick="chartDetail(this, 'vc')" data-name ="ventas_contratadas">  
                            <i class="fas fa-expand-alt"></i>
                        </button>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
            <div class="card p-0 cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">ventas<br><span class="str">apartadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end">
                            <label class="selectMini m-0">4 meses <span class="material-icons">show_chart</span></label> 
                        </div>
                    </div>
                    <div class="row pl-2 pr-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <p class="mt-1 money" id="totventasApartadas"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="boxMiniCharts d-flex justify-center align-start" id="ventasApartadas">
                                <img src="./dist/img/emptyChart.png" alt="Icono gráfica" class="h-70 w-auto">
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="bottom" title="Más detalle" onclick="chartDetail(this, 'va')" data-name ="ventas_apartadas">  
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
            <div class="card p-0 cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">canceladas<br> <span class="str">contratadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end">
                            <label class="selectMini m-0">4 meses <span class="material-icons">show_chart</span></label> 
                        </div>
                    </div>
                    <div class="row pl-2 pr-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <p class="mt-1 money" id="totcanceladasContratadas"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="boxMiniCharts d-flex justify-center align-start" id="canceladasContratadas">
                                <img src="./dist/img/emptyChart.png" alt="Icono gráfica" class="h-70 w-auto">
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="bottom" title="Más detalle" onclick="chartDetail(this, 'cc')" data-name ="canceladas_contratadas">  
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 col-lg-3">
            <div class="card p-0 cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">canceladas<br> <span class="str">apartadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end">
                            <label class="selectMini m-0">4 meses <span class="material-icons">show_chart</span></label> 
                        </div>
                    </div>
                    <div class="row pl-2 pr-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <p class="mt-1 money" id="totcanceladasApartadas"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="boxMiniCharts d-flex justify-center align-start" id="canceladasApartadas">
                                <img src="./dist/img/emptyChart.png" alt="Icono gráfica" class="h-70 w-auto">
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="bottom" title="Más detalle" onclick="chartDetail(this, 'ca')" data-name ="canceladas_apartadas">  
                            <i class="fas fa-expand-alt"></i>
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- mini charts -->

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 d-flex align-center justify-end mb-1" id="tableFilters">
            <div class="col-12 col-sm-1 col-md-1 col-lg-1 h-100 d-flex justify-center iconHover">
                <i class="fas fa-chart-line chartButton" id="chartButton" ></i>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 h-100 pr-0">
                <div class="form-group d-flex m-0 datesTable">
                    <input type="text" class="form-control datepicker tableDates" id="tableBegin" value="" autocomplete='off'/>
                    <input type="text" class="form-control datepicker tableDates" id="tableEnd" value="" autocomplete='off' />
                    <button class="btn btn-success btn-round btn-fab btn-fab-mini tableSearch" id="searchByDateRangeTable">
                        <span class="material-icons update-dataTable">search</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="boxAccordions">
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url()?>dist/js/controllers/dashboard/reporte/dashboardReport.js"></script>