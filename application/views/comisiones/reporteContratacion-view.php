<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">        
            #modal_nuevas{
                z-index: 1041!important;
            }
            #modal_vc{
                z-index: 1041!important;
            }
        </style>

    <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-chart-pie fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reporte Contración</h3>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row aligned-row">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row aligned-row d-flex align-end">
                                        <div class=" form-group d-flex col-xs-12 col-sm-6 col-md-6 col-lg-6 align-center box-table">
                                            <input type="text" class="form-control datepicker text-center pl-1 beginDate box-table" id="beginDate"/>
                                            <input type="text" class="form-control datepicker text-center pl-1 endDate box-table" id="endDate" />
                                        </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="control-label" for="asesorContratacion">Asesor</label>
                                            <select class="selectpicker select-gral m-0" id="asesorContratacion" name="asesorContratacion[]" data-style="btn " data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-round btn-fab btn-fab-mini searchByDateRange box-table" name="searchByDateRange" id="searchByDateRange"><span class="material-icons update-dataTable">search</span></button>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_comisiones_contratacion" name="tabla_comisiones_contratacion">
                                            <thead>
                                                <tr>
                                                    <th>ID LOTE</th>
                                                    <th>NOMBRE LOTE</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>PLAN COMISION</th>
                                                    <th>NOMBRE CLIENTE</th>
                                                    <th>ASESOR</th>
                                                    <th>GERENTE</th>
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


    <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/jwt/hmac-sha256.js"></script>
    <script src="<?= base_url() ?>dist/js/jwt/enc-base64-min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/reporteContratacion.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
</body>