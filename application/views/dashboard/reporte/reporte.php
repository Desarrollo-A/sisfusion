<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>

<div class="row">
    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card p-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-7 col-md-7 col-lg-7 p-0 info">
                        <p class="m-0">Ventas<br>contratadas</p>
                    </div>
                    <div class="col-12 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end">
                        <label class="selectMini m-0">3 meses <span class="material-icons">show_chart</span></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                        <p class="mt-1 money">$454,590</p>
                    </div>
                </div>
                <div class="row">
                    <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="boxMiniCharts" id="ventasContratadas"></div>
                        <button type="btn" id="" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="bottom" title="Más detalle">  
                            <i class="fas fa-expand-alt"></i>
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card p-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-7 col-md-7 col-lg-7 p-0 info">
                        <p class="m-0">Ventas<br>apartadas</p>
                    </div>
                    <div class="col-12 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end">
                        <label class="selectMini m-0">3 meses <span class="material-icons">show_chart</span></label> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                        <p class="mt-1 money">$134,590</p>
                    </div>
                </div>
                <div class="row">
                    <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="boxMiniCharts" id="ventasApartadas"></div>
                        <button type="btn" id="" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="bottom" title="Más detalle">  
                            <i class="fas fa-expand-alt"></i>
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card p-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-7 col-md-7 col-lg-7 p-0 info">
                        <p class="m-0">Canceladas<br>contratadas</p>
                    </div>
                    <div class="col-12 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end">
                        <label class="selectMini m-0">3 meses <span class="material-icons">show_chart</span></label> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                        <p class="mt-1 money">$134,590</p>
                    </div>
                </div>
                <div class="row">
                    <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="boxMiniCharts" id="canceladasContratadas"></div>
                        <button type="btn" id="" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="bottom" title="Más detalle">  
                            <i class="fas fa-expand-alt"></i>
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 col-lg-3">
        <div class="card p-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-7 col-md-7 col-lg-7 p-0 info">
                        <p class="m-0">Canceladas<br>apartadas</p>
                    </div>
                    <div class="col-12 col-sm-5 col-md-5 col-lg-5 p-0 d-flex align-center justify-end">
                        <label class="selectMini m-0">3 meses <span class="material-icons">show_chart</span></label> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                        <p class="mt-1 money">$134,590</p>
                    </div>
                </div>
                <div class="row">
                    <div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="boxMiniCharts" id="canceladasApartadas"></div>
                        <button type="btn" id="" class="moreMiniChart d-flex justify-center align-center" data-toggle="tooltip" data-placement="bottom" title="Más detalle">  
                            <i class="fas fa-expand-alt"></i>
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- mini charts -->

<!-- <div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-6 d-flex justify-end">
        <div class="form-group d-flex">
            <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2022" />
            <input type="text" class="form-control datepicker" id="endDate" value="01/01/2022" />
            <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                <span class="material-icons update-dataTable">search</span>
            </button>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-md-12">
        <div class="boxAccordions">
        </div>
    </div>
</div>

<script src="<?=base_url()?>dist/js/controllers/dashboard/reporte/dashboardReport.js"></script>