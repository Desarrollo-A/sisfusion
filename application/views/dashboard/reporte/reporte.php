<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row pdt-40">
        <div class="col-12 col-sm-12 col-md-12 col-lg-9 d-flex">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-filter"></i> Filtros de búsqueda
            </button>
            <button class="btn btn-primary" type="button" id="filterAction">
                Aplicar filtros
            </button>
            <div class="col-12 col-sm-1 col-md-1 col-lg-1 h-100 d-flex justify-center iconHover">
                <i class="fas fa-chart-line chartButton" id="chartButton" ></i>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md12 col-lg-12">
            <div class="collapse" id="collapseExample">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="back d-flex">
                                <label class="m-0 checkBox">
                                    <input type="checkbox" class="d-none conSinEnganche" value="1" name="conSinEnganche" id="typeSale1" checked>
                                    <span class="spnLeft">Con enganche</span>
                                </label>
                                <label class="m-0 checkBox">
                                    <input type="checkbox" class="d-none conSinEnganche" value="2" name="conSinEnganche" id="typeSale2">
                                    <span class="spnRight">Sin enganche</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="back d-flex">
                                <label class="m-0 checkBox" >
                                    <input type="checkbox" class="d-none typeLote" value="0" name="typeLote" id="typeLote1" checked>
                                    <span class="spnLeft">Habitacionales</span>
                                </label>
                                <label class="m-0 checkBox">
                                    <input type="checkbox" class="d-none typeLote" value="1" name="typeLote" id="typeLote2">
                                    <span class="spnRight">Comerciales</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="back d-flex">
                                <label class="m-0 checkBox" >
                                    <input type="checkbox" class="d-none typeConstruccion" value="0" name="typeConstruccion" id="typeBuild1" checked>
                                    <span class="spnLeft">Sin casa</span>
                                </label>
                                <label class="m-0 checkBox">
                                    <input type="checkbox" class="d-none typeConstruccion" value="1" name="typeConstruccion" id="typeBuild2">
                                    <span class="spnRight">Con casa</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                            <label>Estatus</label>
                            <select id="condominios" name="condominios" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" data-actions-box="true" title="Selecciona un condominio" data-size="7" required multiple>
                                <option value="639">CDMSLP-ROBLE-HABITACIONAL</option> 
                                <option value="639">CDMSLP-ROBLE-HABITACIONAL</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 d-flex align-center justify-end" id="tableFilters">
                            <div class="form-group d-flex m-0 datesTable">
                                <input type="text" class="form-control datepicker tableDates" id="tableBegin" value="" autocomplete='off'/>
                                <input type="text" class="form-control datepicker tableDates" id="tableEnd" value="" autocomplete='off' />
                            </div>
                        </div>
                    </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>