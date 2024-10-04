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
                    <h4 class="modal-title" data-i18n = "consulta-historial" >Consulta de historial <b id="nomLoteHistorial"></b></h4>
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
                                                        <th>LOTE</th>
                                                        <th>ESTATUS</th>
                                                        <th>DETALLES</th>
                                                        <th>COMENTARIO</th>
                                                        <th>FECHA DE ESTATUS</th>
                                                        <th>USUARIO</th>
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
                                                        <th>LOTE</th>
                                                        <th>PRECIO</th>
                                                        <th>FECHA DE LIBERACIÓN</th>
                                                        <th>COMENTARIO</th>
                                                        <th>USUARIO</th>
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
                                                        <th>ASESOR</th>
                                                        <th>COORDINADOR</th>
                                                        <th>GERENTE</th>
                                                        <th>SUBDIRECTOR</th>
                                                        <th>DIRECTOR REGIONAL</th>
                                                        <th>DIRECTOR REGIONAL 2</th>
                                                        <th>FECHA DE ALTA</th>
                                                        <th>USUARIO</th>
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
                                                    <label class="control-label" for="idResidencial">Proyecto</label>
                                                    <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n  ="selecciona-una-opcion" title="Selecciona una opción"
                                                      data-size="7" size="5" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idCondominioInventario" data-i18n="condominio">Condominio</label>
                                                    <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n  ="selecciona-una-opcion" title="Selecciona una opción"
                                                      data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idEstatus" data-i18n="estatus">Estatus</label>
                                                    <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n  ="selecciona-una-opcion" title="Selecciona una opción"
                                                      data-size="7" data-container="body" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <table class="table-striped table-hover hide" id="tablaInventario" name="tablaInventario">
                                            <thead>
                                            <tr>
                                                <th>proyecto</th>
                                                <th>referencia</th>
                                                <th>msi</th>
                                                <th>asesor</th>
                                                <th>coordinador</th>
                                                <th>gerente</th>
                                                <th>subdirector</th>
                                                <th>director-regional</th>
                                                <th>director-regional2</th>
                                                <th>estatus</th>
                                                <th>estatus-contratacion</th>
                                                <th>apartados</th>
                                                <th>comentario</th>
                                                <th>lugar-prospeccion</th><!--20-->
                                                <th>fecha-validacion-enganche</th>
                                                <th>cantidad-enganche-pagado</th>
                                                <th>estatus-de-la-contratacion</th>
                                                <th>cliente</th>
                                                <th>copropietario (s)</th>
                                                <th>comentario-neodata</th>
                                                <th>fecha-apertura</th>
                                                <th>apartado-de-reubicacion</th>
                                                <th>fecha-alta</th>
                                                <th>venta-compartida</th><!--30-->
                                                <th>ubicacion-de-la-venta</th>
                                                <th>tipo-proceso</th>
                                                <th>sede</th>

                                                <!--solo para popea y el otro sujeto-->
                                                <th>folio</th>
                                                <th>documentación entregada</th>
                                                <th>nom-cliente</th>
                                                <th>telefono-casa</th>
                                                <th>celular</th>
                                                <th>correo</th>
                                                <th>fecha-nacimiento</th>
                                                <th>nacionalidad</th><!--40-->
                                                <th>originario de</th>
                                                <th>estado civil</th>
                                                <th>nombre conyugue</th>
                                                <th>regimen</th>
                                                <th>dom. particular</th>
                                                <th>ocupación</th>
                                                <th>empresa en la que trabaja</th>
                                                <th>puesto</th>
                                                <th>antigüedad</th>
                                                <th>edad</th><!--50-->
                                                <th>dom. empresa</th>
                                                <th>tel. empresa</th>
                                                <th>vive en casa</th>
                                                <th>copropietario</th>
                                                <th>no. referencia pago</th>
                                                <th>costo m2 lista</th>
                                                <th>costo m2 final</th>

                                                <th>en el municipio de</th>
                                                <th>importe de la oferta</th>
                                                <th>importe en letra</th><!--60-->
                                                <th>saldo del depósito</th>
                                                <th>aportación mensual</th>
                                                <th>fecha 1ra aportación</th>
                                                <th>fecha liquidación</th>
                                                <th>fecha 2da liquidación</th>
                                                <th>referencias personales</th>
                                                <th>observaciones</th>

                                                <!--solo para popea y el otro sujeto end-->
                                                <th>porcentaje enganche</th>
                                                <th>acciones</th><!--69-->

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
                                                                data-style="btn" data-show-subtext="true"  data-i18n  ="selecciona-una-opcion" title="SELECCIONA UNA OPCIÓN"
                                                                
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
<script src="<?= base_url() ?>dist/js/controllers/contratacion/datos_lote_contratacion.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="https://unpkg.com/i18next@21.6.10/dist/umd/i18next.min.js"></script>


</body>