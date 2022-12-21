<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>

<div class="container-fluid">
    <div class="row pdt-40">
        <div class="col-12 col-sm-5 col-md-6 col-lg-6">
            <div class="back d-flex">
                <label class="m-0 checkBox" >
                    <input type="checkbox" class="d-none infoMainSelector" value="1" name="infoMainSelector" id="typeSale1" checked>
                    <span class="mr-1">Con enganche</span>
                </label>
                <label class="m-0 checkBox" >
                    <input type="checkbox" class="d-none infoMainSelector" value="2" name="infoMainSelector" id="typeSale2">
                    <span>Sin enganche</span>
                </label>
            </div>
            <div class="back d-flex">
                <label class="m-0 checkBox" >
                    <input type="checkbox" class="d-none infoMainSelector" value="1" name="infoMainSelector" id="typeSale1" checked>
                    <span class="mr-1">Comerciales</span>
                </label>
                <label class="m-0 checkBox" >
                    <input type="checkbox" class="d-none infoMainSelector" value="2" name="infoMainSelector" id="typeSale2">
                    <span>Habitacionales</span>
                </label>
            </div>
        </div>
        <div class="col-12 col-sm-7 col-md-6 col-lg-6 d-flex align-center justify-end" id="tableFilters">
            <div class="col-12 col-sm-1 col-md-1 col-lg-1 h-100 d-flex justify-center iconHover">
                <i class="fas fa-chart-line chartButton" id="chartButton" ></i>
            </div>
            <div class="col-12 col-sm-11 col-md-11 col-lg-4 h-100 pr-0">
                <div class="form-group d-flex m-0 datesTable">
                    <input type="text" class="form-control datepicker tableDates" id="tableBegin" value="" autocomplete='off'/>
                    <input type="text" class="form-control datepicker tableDates" id="tableEnd" value="" autocomplete='off' />
                    <button class="btn btn-success btn-round btn-fab btn-fab-mini tableSearch" id="searchByDateRangeTable">
                        <span class="material-icons">search</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row w-100 m-auto rowCarousel">
        <div class="w-100 scrollCharts">
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">Ventas<br> <span class="str">totales</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end appliedFilter">
                            <label class="selectMini m-0 overflow-text">Año en curso <span class="material-icons">show_chart</span></label>
                        </div>
                    </div>
                    <div class="row pl-2 pr-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <p class="mt-1 money" id="totventasTotales"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="boxMiniCharts d-flex justify-center align-start" id="ventasTotales">
                                <img src= '<?=base_url('dist/img/emptyCharts.png')?>' alt="Icono gráfica" class="h-70 w-auto">
                                <div class="loadChartMini w-100 h-100">
                                    <img src='<?=base_url('dist/img/miniChartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="left" title="Más detalle" onclick="chartDetail(this, 'vt')" data-name ="ventas_totales">
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">Ventas<br> <span class="str">contratadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end appliedFilter" >
                            <label class="selectMini m-0 overflow-text">Año en curso <span class="material-icons">show_chart</span></label>
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
                                <img src= '<?=base_url('dist/img/emptyCharts.png')?>' alt="Icono gráfica" class="h-70 w-auto">
                                <div class="loadChartMini w-100 h-100">
                                    <img src='<?=base_url('dist/img/miniChartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="left" title="Más detalle" onclick="chartDetail(this, 'vc')" data-name ="ventas_contratadas">
                            <i class="fas fa-expand-alt"></i>
                        </button>

                    </div>
                </div>
            </div>
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">Ventas<br> <span class="str">apartadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end appliedFilter">
                            <label class="selectMini m-0 overflow-text">Año en curso <span class="material-icons">show_chart</span></label>
                        </div>
                    </div>
                    <div class="row pl-2 pr-2">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                            <p class="mt-1 money" id="totventasApartadas"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="boxMiniCharts d-flex justify-center align-start" id="ventasApartadas" >
                                <img src= '<?=base_url('dist/img/emptyCharts.png')?>' alt="Icono gráfica" class="h-70 w-auto">
                                <div class="loadChartMini w-100 h-100">
                                    <img src='<?=base_url('dist/img/miniChartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="left" title="Más detalle" onclick="chartDetail(this, 'va')" data-name ="ventas_apartadas">
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">Canceladas<br> <span class="str">contratadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end appliedFilter">
                            <label class="selectMini m-0 overflow-text">Año en curso <span class="material-icons">show_chart</span></label>
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
                                <img src= '<?=base_url('dist/img/emptyCharts.png')?>' alt="Icono gráfica" class="h-70 w-auto">
                                <div class="loadChartMini w-100 h-100">
                                    <img src='<?=base_url('dist/img/miniChartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="left" title="Más detalle" onclick="chartDetail(this, 'cc')" data-name ="canceladas_contratadas">
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0">Canceladas<br> <span class="str">apartadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end appliedFilter ">
                            <label class="selectMini m-0 overflow-text numberGraphic">Año en curso <span class="material-icons">show_chart</span></label>
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
                                <img src= '<?=base_url('dist/img/emptyCharts.png')?>' alt="Icono gráfica" class="h-70 w-auto">
                                <div class="loadChartMini w-100 h-100">
                                    <img src='<?=base_url('dist/img/miniChartLoading.gif')?>' alt="Icono gráfica" class="h-100 w-auto">
                                </div>
                            </div>
                        </div>
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="left" title="Más detalle" onclick="chartDetail(this, 'ca')" data-name ="canceladas_apartadas">
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="gradientLeft d-none"></div>
        <div class="gradientRight"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="boxAccordions">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>