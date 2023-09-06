<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    table thead tr th {
        padding: 0px !important;
        color:#fff;
        font-weight: lighter;
        font-size: 0.8em;
    }
    tfoot tr{
        background: #143860;
    }
    table tfoot tr th{
        padding: 0px !important;
        color:#fff;
        font-weight: lighter;
        font-size: 1.3em;
        text-align: center;
    }
</style>
<body>
<div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal" tabindex="-1" role="dialog" id="notificacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="p-0 text-center">Tienes que seleccionar al menos un valor para el campo <i><b>Empresa</b></i>.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                            <i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align">Reporte por lotes (NeoData)</h3>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 overflow-hidden">
                                        <div class="form-group select-is-empty">
                                            <label class="control-label">Empresa</label>
                                            <select id="empresas" name="empresas" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 overflow-hidden">
                                        <div class="form-group select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select id="proyectos" name="proyectos" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 overflow-hidden">
                                        <div class="form-group select-is-empty">
                                            <label class="control-label">Cliente</label>
                                            <select id="clientes" name="clientes" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group" style="margin-top: 50px;">
                                            <button class="btn-gral-data mb-3" id="searchInfo">Buscar</button>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group m-0">
                                            <label class="m-0 check-style">
                                                <input type="checkbox" id="dates" onClick="toggleSelect2()">
                                                <span><i class="fas fa-calendar-alt fa-lg m-1"></i>Filtro por fecha</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <div class="form-group d-flex m-0">
                                            <input  type="text" class="form-control datepicker hide" id="beginDate"/>
                                            <input  type="text" class="form-control datepicker hide" id="endDate" style="border-radius: 0 27px 27px 0!important;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table id="tableLotificacionNeodata" name="tableLotificacionNeodata" class="table-striped table-hover hide">
                                <thead>
                                    <tr>
                                        <th>CÓDIGO CLIENTE</th>
                                        <th>CUENTA 2170</th>
                                        <th>CUENTA 1150</th>
                                        <th>VIVIENDA</th>
                                        <th>CONTRATO</th>
                                        <th>CLIENTE</th>
                                        <th>SUPERFICIE CONTRATO</th>
                                        <th>PRECIO DE VENTA</th>
                                        <th>FECHA DE CONTRATO</th>
                                        <th>FECHA DE RECONOCIMIENTO</th>
                                        <th>FOLIO FISCAL</th>
                                        <th>INTERMEDIARIO</th>
                                        <th>PAGO A CAPITAL 2170</th>
                                        <th>PAGO A CAPITAL 1150</th>
                                        <th>BONIFICACIÓN</th>
                                        <th>ESCRITURA INDIVIDUAL</th>
                                        <th>FECHA ESCRITURA</th>
                                        <th>SIN INTERESES</th>
                                        <th>CON INTERESES</th>
                                        <th>MONTO CAPITAL</th>
                                        <th>INTERESES MORATORIOS</th>
                                        <th>INTERESES ORDINARIOS</th>
                                        <th>TOTAL DE VENTA</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url()?>dist/js/funciones-generales.js"></script>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>dist/js/controllers/contabilidad/neodataInformation.js"></script>
</body>