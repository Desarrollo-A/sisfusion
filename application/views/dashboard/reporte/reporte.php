<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css">

<style>
    .btn-group, .btn-group-vertical {
        margin: 0!important;
    }
    .select-gral button{
        background-color: #929292 !important;
    }
</style>

<div class="container-fluid">
    <div class="row pdt-40" id="tableFilters">
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 pb-1 overflow-hidden">
            <select class="selectpicker select-gral m-0" name="estatusContratacion" id="estatusContratacion" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
            </select>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-4 pb-1">
            <div class="form-group d-flex m-0 datesTable">
                <input type="text" class="form-control datepicker tableDates" id="tableBegin" value="" autocomplete='off'/>
                <input type="text" class="form-control datepicker tableDates" id="tableEnd" value="" autocomplete='off' />
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-2 pb-1">
            <div class='c-filter'>
                <button class='c-filter__toggle'><span data-i18n="mas-filtros">Más filtros</span></button>
                <ul class='c-filter__ul'>
                    <li class='c-filter__item'>
                        <input type="checkbox" class="d-none" value="1" name="conSinEnganche" id="typeSale1" checked>
                        <label tabindex='-1' for='typeSale1' data-i18n="con-enganche">Con enganche</label>
                    </li>
                    <li class='c-filter__item'>
                        <input type="checkbox" class="d-none" value="2" name="conSinEnganche" id="typeSale2" checked>
                        <label tabindex='-1' for='typeSale2' data-i18n="sin-enganche">Sin enganche</label>
                    </li>
                    <li class='c-filter__item'>
                        <input type="checkbox" class="d-none" value="0" name="typeLote" id="typeLote1" checked>
                        <label tabindex='-1' for='typeLote1' data-i18n="habitacionales">Habitacionales</label>
                    </li>
                    <li class='c-filter__item'>
                        <input type="checkbox" class="d-none" value="1" name="typeLote" id="typeLote2" checked>
                        <label tabindex='-1' for='typeLote2' data-i18n="comerciales">Comerciales</label>
                    </li>
                    <li class='c-filter__item'>
                        <input type="checkbox" class="d-none" value="1" name="typeConstruccion" id="typeBuild2" checked>
                        <label tabindex='-1' for='typeBuild2' data-i18n="con-casa">Con casa</label>
                    </li>
                    <li class='c-filter__item'>
                        <input type="checkbox" class="d-none" value="0" name="typeConstruccion" id="typeBuild1" checked>
                        <label tabindex='-1' for='typeBuild1' data-i18n="sin-casa">Sin casa</label>
                    </li>
                </ul>
            </div>
            
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-2">
            <button class="btn-filter" type="button" id="filterAction">
                <span data-i18n="aplicar-filtros">Aplicar filtros</span>
            </button>
        </div>
    </div>
    <div class="row w-100 m-auto rowCarousel">
        <div class="w-100 scrollCharts">
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0"><span data-i18n="ventas">Ventas</span><br> <span data-i18n="totales" class="str">totales</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end appliedFilter">
                            <label class="selectMini m-0 overflow-text"><span data-i18n="año-en-curso">Año en curso</span><span class="material-icons">show_chart</span></label>
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
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="left" title="MÁS DETALLE" onclick="chartDetail(this, 'vt')" data-name ="ventas_totales">
                            <i class="fas fa-expand-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0"><span data-i18n="ventas">Ventas</span><br> <span data-i18n="contratadas" class="str">contratadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end appliedFilter" >
                            <label class="selectMini m-0 overflow-text"><span data-i18n="año-en-curso">Año en curso</span> <span class="material-icons">show_chart</span></label>
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
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="left" title="MÁS DETALLE" onclick="chartDetail(this, 'vc')" data-name ="ventas_contratadas">
                            <i class="fas fa-expand-alt"></i>
                        </button>

                    </div>
                </div>
            </div>
            <div class="card p-0 cardMiniChart" id="cardMiniChart">
                <div class="container-fluid">
                    <div class="row pl-2 pt-2 pr-2">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
                            <p class="m-0"><span data-i18n="ventas">Ventas</span><br> <span data-i18n="apartadas" class="str">apartadas</span></p>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end appliedFilter">
                            <label class="selectMini m-0 overflow-text"><span data-i18n="año-en-curso">Año en curso</span> <span class="material-icons">show_chart</span></label>
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
                        <button type="btn" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="left" title="MÁS DETALLE" onclick="chartDetail(this, 'va')" data-name ="ventas_apartadas">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>