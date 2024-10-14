<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <style>
        .box_cash h6{
            line-height: 19px;
            font-size: 10px;
            font-weight: 100;
            color: #999;
        }
        .box_cash span{
            font-size: 25px;
            font-weight: 600;
            color: #4e4e4e;
        }
        .timelineR {
            position: relative;
            border-color: rgba(160, 175, 185, .15);
            padding: 0;
            margin: 0
        }

        .tl-item {
            border-radius: 3px;
            position: relative;
            display: -ms-flexbox;
            display: flex
        }

        .tl-item>* {
            padding: 10px
        }

        .tl-dot {
            position: relative;
            border-color: rgba(160, 175, 185, .15)
        }

        .tl-dot:after,
        .tl-dot:before {
            content: '';
            position: absolute;
            border-color: inherit;
            border-width: 2px;
            border-style: solid;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            top: 15px;
            left: 50%;
            transform: translateX(-50%)
        }

        .tl-dot:after {
            width: 0;
            height: auto;
            top: 25px;
            bottom: -15px;
            border-right-width: 0;
            border-top-width: 0;
            border-bottom-width: 0;
            border-radius: 0
        }

        .tl-date {
            font-size: .85em;
            margin-top: 2px;
            min-width: 100px;
            max-width: 100%
        }

        .b-warning {
            border-color: #243D7C!important;
        }
        
        #rowTotales label{
            font-size: 12px;
        }

        #detailComisionistaBtn{
            background-color: #14386026; 
            color: #143860; 
            padding: 2px 10px 3px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 700; 
            cursor: pointer;
        }
    </style>

    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="detailComisionistaModal" tabindex="-1" role="dialog" aria-labelledby="detailComisionistaLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-between">
                        <h5 class="modal-title" id="exampleModalLabel" data-i18n="detalle-total-comisiones">Detalle total de comisiones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="timelineR p-4 block mb-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <a href="https://youtu.be/6tDiInpg2Ao" class="align-center justify-center u2be" target="_blank">
                                    <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                </a>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align" data-i18n="reporte-lotes-comisionista">Reporte de lotes por comisionista</h3>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden">
                                                <div class="d-flex justify-between">
                                                    <label class="label-gral">
                                                        <span data-i18n="comisionista">Comisionista</span> 
                                                        <span class="lblEstatus"></span> 
                                                        <span class="lblRolActual"></span>
                                                        <span class="isRequired">*</span>
                                                    </label>
                                                    <label>
                                                        <span id="detailComisionistaBtn"><i class="fas fa-info"></i></span>
                                                    </label>
                                                </div>
                                                <select class="selectpicker select-gral m-0" id="comisionista" data-i18n-label="selecciona-una-opcion" name="comisionista" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body"></select>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-3 col-lg-3 overflow-hidden">
                                                <label class="label-gral m-0">
                                                    <span data-i18n="tipo-usuario">Tipo de usuario </span>(<span class="isRequired">*</span>)
                                                </label>
                                                <select class="selectpicker select-gral m-0" id="tipoUsuario" data-i18n-label="selecciona-una-opcion" name="tipoUsuario" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body"></select>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-3 col-lg-3">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-md-12 p-r">
                                                            <div class="form-group d-flex">
                                                                <input type="text" class="form-control datepicker" id="beginDate" />
                                                                <input type="text" class="form-control datepicker" id="endDate"/>
                                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini"id="searchByDateRange">
                                                                    <span class="material-icons update-dataTable">search</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1 d-none" id="rowTotales">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-center">
                                                <div class="box_cash">
                                                    <h6 data-i18n="total-comision">TOTAL COMISIÓN</h6><span id="txt_totalComision" class="cash">$0.00</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-center">
                                                <div class="box_cash">
                                                    <h6 data-i18n="total-abonado">TOTAL ABONADO</h6><span id="txt_totalAbonado" class="cash">$0.00</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-center">
                                                <div class="box_cash">
                                                    <h6 data-i18n="total-pagado">TOTAL PAGADO</h6><span id="txt_totalPagado" class="cash">$0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="material-datatables hide ml-2" id="box-reporteLotesPorComisionista">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="reporteLotesPorComisionista" name="reporteLotesPorComisionista">
                                                <thead>
                                                    <tr>
                                                        <th>proyecto</th>
                                                        <th>condominio</th>
                                                        <th>lote</th>
                                                        <th>id-lote</th>
                                                        <th>cliente</th>
                                                        <th>fecha-apartado</th>
                                                        <th>sede</th>
                                                        <th>asesor</th>
                                                        <th>coordinador</th>
                                                        <th>gerente</th>
                                                        <th>subdirector</th>
                                                        <th>director-regional</th>
                                                        <th>estatus-contratacion</th>
                                                        <th>estatus-ventas</th>
                                                        <th>estatus-comision</th>
                                                        <th>precio-final</th>
                                                        <th>porc-comision</th>
                                                        <th>pago-cliente</th>
                                                        <th>total-comision</th>
                                                        <th>total-abonado</th>
                                                        <th>total-pagado</th>
                                                        <th>lugar-prospeccion</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>

    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/nouislider.min.js"></script>
    <script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/reporteLotesPorComisionista.js"></script>
</body>