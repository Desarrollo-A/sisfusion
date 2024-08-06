<link href="<?= base_url() ?>dist/css/depositoSeriedad.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .radio_container input[type="radio"] {
        appearance: none;
        display: none;
    }
    .radio_container label {
        width: 100%;
        transition: linear 0.3s;
        font-weight: 100;
    }
    .disabledClassRadio{
        background-color: #103f7545 !important;
        color: #fff !important;
        transition: 0.3s !important;
        cursor:not-allowed !important;
    }
</style>
<body>
<?php
/*if(in_array($this->session->userdata('id_rol'), array( 17, 70, 71, 73))) {
    $statusInput = '';
    $classAllowed = '';
    $classWidth = 'w-50';
}else{
    $statusInput = 'disabled';
    $classAllowed = 'notAllowedClass';
    $classWidth = 'w-100';
}*/
?>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>
    <?php include 'Modales/addPlanPagoModal.php' ?>
    <?php include 'Modales/verPlanPagoModal.php' ?>
    <?php include 'Modales/confirmarEnvioPlanModal.php' ?>
    <?php include 'Modales/confirmarEnvioPlanModal2.php' ?>
    <?php include 'Modales/avisoModal.php' ?>
    <?php include 'Modales/confirmarCancelaPlan.php' ?>
    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="toolbar hide">
                                <div class="row">
                                    <div class=" col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="selectorModo">
                                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 pb-3 pt-3">
                                            <div class="radio_container w-100">
                                                <input class="d-none generate" type="radio" name="tipoVista"
                                                       id="condominioM" checked value="1">
                                                <label for="condominioM" class="w-50">Inventario Lotes</label>
                                                <input class="d-none find-results" type="radio" name="tipoVista"
                                                       id="loteM" value="0">
                                                <label for="loteM" class="w-50">Descargar inventario sede</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="card1">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h3 class="card-title center-align">Planes de pago</h3>
                                    <div class="toolbar">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idResidencial">Proyecto</label>
                                                    <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idCondominioInventario">Condominio</label>
                                                    <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idEstatus">Lote</label>
                                                    <select name="idLote" id="idLote" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label class="control-label">Cliente</label>
                                                <input id="nombreCliente" name="nombreCliente"
                                                       class="form-control input-gral " readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <table class="table-striped table-hover hide" id="tablaPlanPagos" name="tablaPlanPagos">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>PLAN DE PAGO</th>
                                                <th>PLAZO</th>
                                                <th>ESTATUS</th>
                                                <th>ACCIONES</th><!--68-->
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="row hide" id="card2">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="encabezadoBox">
                                        <h3 class="card-title center-align">Descargar inventario de lotes por sede</h3>
                                        <p class="card-title pl-1"></p>
                                    </div>
                                    <div  class="toolbar">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="col-md-4 form-group">
                                                    <div class="form-group select-is-empty">
                                                        <label class="control-label">Sedes por proyecto</label>
                                                        <select name="sedes" id="sedes" class="selectpicker select-gral m-0"
                                                                data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN"
                                                                data-size="7" data-live-search="true" required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <table id="tabla_inventario_contraloria" name="tabla_inventario_contraloria" class="table-striped table-hover hide">
                                            <thead>
                                            <tr>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>ID LOTE</th>
                                                <th>SUPERFICIE</th>
                                                <th>PRECIO DE LISTA</th>
                                                <th>TOTAL CON DESCUENTOS</th>
                                                <th>M2</th>
                                                <th>REFERENCIA</th>
                                                <th>MESES SIN INTERESES</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>DIRECTOR REGIONAL</th>
                                                <th>DIRECTOR REGIONAL 2</th>
                                                <th>ESTATUS</th>
                                                <th>ESTATUS DE CONTRATACION</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>COMENTARIO</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>FECHA DE VALIDACIÓN DEL ENGANCHE</th>
                                                <th>FECHA DE APERTURA</th>
                                                <th>CANTIDAD DEL ENGANCHE PAGADO</th>
                                                <th>CLIENTE</th>
                                                <th>COMENTARIO DE NEODATA</th>
                                                <th>FECHA APERTURA</th>
                                                <th>APARTADO DE REUBICACIÓN</th>
                                                <th>FECHA ALTA</th>
                                                <th>VENTA COMPARTIDA</th>
                                                <th>UBICACIÓN DE LA VENTA</th>
                                                <th>TIPO PROCESO</th>
                                                <th>REUBICACIÓN</th>
                                                <th>FECHA DE REUBICACIÓN</th>
                                                <th>SEDE</th>
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
    </div>
    <?php $this->load->view('template/footer_legend');?>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/planesPagos/planes_pagos.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/planesPagos/generaPlanPago.js"></script>

</body>