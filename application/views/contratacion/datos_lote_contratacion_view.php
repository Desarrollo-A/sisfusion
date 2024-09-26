<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .open{
        max-width: -webkit-fill-available;
    }
</style>
<body>
<?php
if(in_array($this->session->userdata('id_rol'), array( 17, 70, 71, 73))) {
    $statusInput = '';
    $classAllowed = '';
    $classWidth = 'w-50';
}else{
    $statusInput = 'disabled';
    $classAllowed = 'notAllowedClass';
    $classWidth = 'w-100';
}
?>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <!-- Modals -->
    <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                            <li role="presentation" class="active">
                                <a href="#tabHistoriaContratacion" aria-controls="tabHistoriaContratacion" role="tab" data-toggle="tab">Historial de contratación</a>
                            </li>
                            <li role="presentation">
                                <a href="#tabHistoriaLiberacion" aria-controls="tabHistoriaLiberacion" role="tab" data-toggle="tab">Historial de liberación</a>
                            </li>
                            <li role="presentation">
                                <a href="#tabVentasCompartidas" aria-controls="tabVentasCompartidas" role="tab" data-toggle="tab">Ventas compartidas</a>
                            </li>
                            <li role="presentation" id="divTabHistorialEstatus">
                                <a href="#tabHistorialEstatus" aria-controls="tabHistorialEstatus" role="tab" data-toggle="tab">Historial Estatus</a>
                            </li>
                            <li role="presentation" id="divTabClausulas">
                                <a href="#tabClausulas" aria-controls="tabClausulas" role="tab" data-toggle="tab">Cláusulas</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tabHistoriaContratacion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <table id="tablaHistorialContratacion">
                                                    <thead>
                                                    <tr>
                                                        <th data-i18n="proyecto">LOTE</th>
                                                        <th data-i18n="proyecto">ESTATUS</th>
                                                        <th data-i18n="proyecto">DETALLES</th>
                                                        <th data-i18n="proyecto">COMENTARIO</th>
                                                        <th data-i18n="proyecto">FECHA DE ESTATUS</th>
                                                        <th data-i18n="proyecto">USUARIO</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tabHistoriaLiberacion">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <table id="tablaHistoriaLiberacion">
                                                    <thead>
                                                    <tr>
                                                        <th data-i18n="proyecto">LOTE</th>
                                                        <th data-i18n="proyecto">PRECIO</th>
                                                        <th data-i18n="proyecto">FECHA DE LIBERACIÓN</th>
                                                        <th data-i18n="proyecto">COMENTARIO</th>
                                                        <th data-i18n="proyecto">USUARIO</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tabVentasCompartidas">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <table id="tablaVentasCompartidas">
                                                    <thead>
                                                    <tr>
                                                        <th data-i18n="proyecto">ASESOR</th>
                                                        <th data-i18n="proyecto">COORDINADOR</th>
                                                        <th data-i18n="proyecto">GERENTE</th>
                                                        <th data-i18n="proyecto">SUBDIRECTOR</th>
                                                        <th data-i18n="proyecto">DIRECTOR REGIONAL</th>
                                                        <th data-i18n="proyecto">DIRECTOR REGIONAL 2</th>
                                                        <th data-i18n="proyecto">FECHA DE ALTA</th>
                                                        <th data-i18n="proyecto">USUARIO</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tabHistorialEstatus">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                <ul class="timeline-3" id="HistorialEstatus"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tabClausulas">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content">
                                                <h6 id="clauses_content"></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modals -->

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon fa-2x" data-background-color="goldMaderas">
                            <?php
                            if(in_array($this->session->userdata('id_rol'), array(7, 9, 3, 2, 1, 6, 5, 4))) {
                                ?>
                                <a href="https://youtu.be/JPlj1Zy_qDs" class="align-center justify-center u2be" target="_blank">
                                    <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                </a>
                                <?php
                            } else {
                                ?>
                                <i class="fas fa-box"></i>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <div class="row">
                                    <div class=" col col-xs-12 col-sm-12 col-md-12 col-lg-12" id="selectorModo">
                                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 pb-3 pt-3">
                                            <div class="radio_container w-100">
                                                <input class="d-none generate" type="radio" name="tipoVista"
                                                       id="condominioM" checked value="1">
                                                <label for="condominioM" class="w-50" data-i18n="inventario-lotes">Inventario Lotes</label>
                                                <input class="d-none find-results" type="radio" name="tipoVista"
                                                       id="loteM" value="0">
                                                <label for="loteM" class="w-50" data-i18n="descargar-inventario-sede">Descargar inventario sede</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="card1">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h3 class="card-title center-align" data-i18n="inventario-lotes">Inventario lotes</h3>
                                    <div class="toolbar">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idResidencial" data-i18n="proyecto">Proyecto</label>
                                                    <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción"
                                                     data-i18n="select-prederteminado" data-size="7" size="5" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idCondominioInventario" data-i18n="condominio">Condominio</label>
                                                    <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción"
                                                     data-i18n="select-prederteminado" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idEstatus" data-i18n="estatus">Estatus</label>
                                                    <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción"
                                                     data-i18n="select-prederteminado" data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <table class="table-striped table-hover hide" id="tablaInventario" name="tablaInventario">
                                            <thead>
                                            <tr>
                                                <th data-i18n="proyecto">PROYECTO</th>
                                                <th data-i18n="condominio">CONDOMINIO</th>
                                                <th data-i18n="lote">LOTE</th>
                                                <th data-i18n="id-lote">ID LOTE</th>
                                                <th data-i18n="superficie">SUPERFICIE</th>
                                                <th data-i18n="precio-lista">PRECIO DE LISTA</th>
                                                <th data-i18n="total-con-descuentos">TOTAL CON DESCUENTOS</th>
                                                <th data-i18n="m2">M2</th>
                                                <th data-i18n="proyecto">REFERENCIA</th>
                                                <th data-i18n="proyecto">MSI</th>
                                                <th data-i18n="proyecto">ASESOR</th>
                                                <th data-i18n="proyecto">COORDINADOR</th>
                                                <th data-i18n="proyecto">GERENTE</th>
                                                <th data-i18n="proyecto">SUBDIRECTOR</th>
                                                <th data-i18n="proyecto">DIRECTOR REGIONAL</th>
                                                <th data-i18n="proyecto">DIRECTOR REGIONAL 2</th>
                                                <th data-i18n="proyecto">ESTATUS</th>
                                                <th data-i18n="proyecto">ESTATUS DE CONTRATACIÓN</th>
                                                <th data-i18n="proyecto">APARTADO</th>
                                                <th data-i18n="proyecto">COMENTARIO</th>
                                                <th data-i18n="proyecto">LUGAR DE PROSPECCIÓN</th><!--20-->
                                                <th data-i18n="proyecto">FECHA DE VALIDACIÓN ENGANCHE</th>
                                                <th data-i18n="proyecto">CANTIDAD DE ENGANCHE PAGADO</th>
                                                <th data-i18n="proyecto">ESTATUS DE LA CONTRATACIÓN</th>
                                                <th data-i18n="proyecto">CLIENTE</th>
                                                <th data-i18n="proyecto">COPROPIETARIO (S)</th>
                                                <th data-i18n="proyecto">COMENTARIO DE NEODATA</th>
                                                <th data-i18n="proyecto">FECHA DE APERTURA</th>
                                                <th data-i18n="proyecto">APARTADO DE REUBICACIÓN</th>
                                                <th data-i18n="proyecto">FECHA DE ALTA</th>
                                                <th data-i18n="proyecto">VENTA COMPARTIDA</th><!--30-->
                                                <th data-i18n="proyecto">UBICACIÓN DE LA VENTA</th>
                                                <th data-i18n="proyecto">TIPO DE PROCESO</th>
                                                <th data-i18n="proyecto">SEDE</th>

                                                <!--SOLO PARA POPEA Y EL OTRO SUJETO-->
                                                <th data-i18n="proyecto">FOLIO</th>
                                                <th data-i18n="proyecto">DOCUMENTACION ENTREGADA</th>
                                                <th data-i18n="proyecto">NOMBRE CLIENTE</th>
                                                <th data-i18n="proyecto">TEL. CASA</th>
                                                <th data-i18n="proyecto">CELULAR</th>
                                                <th data-i18n="proyecto">CORREO</th>
                                                <th data-i18n="proyecto">FECHA DE NACIMIENTO</th>
                                                <th data-i18n="proyecto">NACIONALIDAD</th><!--40-->
                                                <th data-i18n="proyecto">ORIGINARIO DE</th>
                                                <th data-i18n="proyecto">ESTADO CIVIL</th>
                                                <th data-i18n="proyecto">NOMBRE CONYUGUE</th>
                                                <th data-i18n="proyecto">REGIMEN</th>
                                                <th data-i18n="proyecto">DOM. PARTICULAR</th>
                                                <th data-i18n="proyecto">OCUPACIÓN</th>
                                                <th data-i18n="proyecto">EMPRESA EN LA QUE TRABAJA</th>
                                                <th data-i18n="proyecto">PUESTO</th>
                                                <th data-i18n="proyecto">ANTIGÜEDAD</th>
                                                <th data-i18n="proyecto">EDAD</th><!--50-->
                                                <th data-i18n="proyecto">DOM. EMPRESA</th>
                                                <th data-i18n="proyecto">TEL. EMPRESA</th>
                                                <th data-i18n="proyecto">VIVE EN CASA</th>
                                                <th data-i18n="proyecto">COPROPIETARIO</th>
                                                <th data-i18n="proyecto">NO. REFERENCIA PAGO</th>
                                                <th data-i18n="proyecto">COSTO M2 LISTA</th>
                                                <th data-i18n="proyecto">COSTO M2 FINAL</th>

                                                <th data-i18n="proyecto">EN EL MUNICIPIO DE</th>
                                                <th data-i18n="proyecto">IMPORTE DE LA OFERTA</th>
                                                <th data-i18n="proyecto">IMPORTE EN LETRA</th><!--60-->
                                                <th data-i18n="proyecto">SALDO DEL DEPÓSITO</th>
                                                <th data-i18n="proyecto">APORTACIÓN MENSUAL</th>
                                                <th data-i18n="proyecto">FECHA 1RA APORTACIÓN</th>
                                                <th data-i18n="proyecto">FECHA LIQUIDACIÓN</th>
                                                <th data-i18n="proyecto">FECHA 2DA LIQUIDACIÓN</th>
                                                <th data-i18n="proyecto">REFERENCIAS PERSONALES</th>
                                                <th data-i18n="proyecto">OBSERVACIONES</th>

                                                <!--SOLO PARA POPEA Y EL OTRO SUJETO END-->
                                                <th data-i18n="proyecto">PORCENTAJE ENGANCHE</th>
                                                <th data-i18n="proyecto">ACCIONES</th><!--69-->
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
                                                <th data-i18n="proyecto">PROYECTO</th>
                                                <th data-i18n="proyecto">CONDOMINIO</th>
                                                <th data-i18n="proyecto">LOTE</th>
                                                <th data-i18n="proyecto">ID LOTE</th>
                                                <th data-i18n="proyecto">SUPERFICIE</th>
                                                <th data-i18n="proyecto">PRECIO DE LISTA</th>
                                                <th data-i18n="proyecto">TOTAL CON DESCUENTOS</th>
                                                <th data-i18n="proyecto">M2</th>
                                                <th data-i18n="proyecto">REFERENCIA</th>
                                                <th data-i18n="proyecto">MESES SIN INTERESES</th>
                                                <th data-i18n="proyecto">ASESOR</th>
                                                <th data-i18n="proyecto">COORDINADOR</th>
                                                <th data-i18n="proyecto">GERENTE</th>
                                                <th data-i18n="proyecto">SUBDIRECTOR</th>
                                                <th data-i18n="proyecto">DIRECTOR REGIONAL</th>
                                                <th data-i18n="proyecto">DIRECTOR REGIONAL 2</th>
                                                <th data-i18n="proyecto">ESTATUS</th>
                                                <th data-i18n="proyecto">ESTATUS DE CONTRATACION</th>
                                                <th data-i18n="proyecto">FECHA DE APARTADO</th>
                                                <th data-i18n="proyecto">COMENTARIO</th>
                                                <th data-i18n="proyecto">LUGAR DE PROSPECCIÓN</th>
                                                <th data-i18n="proyecto">FECHA DE VALIDACIÓN DEL ENGANCHE</th>
                                                <th data-i18n="proyecto">FECHA DE APERTURA</th>
                                                <th data-i18n="proyecto">CANTIDAD DEL ENGANCHE PAGADO</th>
                                                <th data-i18n="proyecto">CLIENTE</th>
                                                <th data-i18n="proyecto">COMENTARIO DE NEODATA</th>
                                                <th data-i18n="proyecto">FECHA APERTURA</th>
                                                <th data-i18n="proyecto">APARTADO DE REUBICACIÓN</th>
                                                <th data-i18n="proyecto">FECHA ALTA</th>
                                                <th data-i18n="proyecto">VENTA COMPARTIDA</th>
                                                <th data-i18n="proyecto">UBICACIÓN DE LA VENTA</th>
                                                <th data-i18n="proyecto">TIPO PROCESO</th>
                                                <th data-i18n="proyecto">REUBICACIÓN</th>
                                                <th data-i18n="proyecto">FECHA DE REUBICACIÓN</th>
                                                <th data-i18n="proyecto">SEDE</th>
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
<script src="<?= base_url() ?>dist/js/controllers/contratacion/datos_lote_contratacion.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="https://unpkg.com/i18next@21.6.10/dist/umd/i18next.min.js"></script>


</body>