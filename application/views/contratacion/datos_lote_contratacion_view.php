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
                    <h4 class="modal-title"><span data-i18n="consultar-historial"> Consulta de historial </span> <b id="nomLoteHistorial"></b></h4>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                            <li role="presentation" class="active">
                                <a href="#tabHistoriaContratacion" aria-controls="tabHistoriaContratacion" role="tab" data-toggle="tab" data-i18n="historial-contratacion">Historial de contratación</a>
                            </li>
                            <li role="presentation">
                                <a href="#tabHistoriaLiberacion" aria-controls="tabHistoriaLiberacion" role="tab" data-toggle="tab" data-i18n="historial-liberacion">Historial de liberación</a>
                            </li>
                            <li role="presentation">
                                <a href="#tabVentasCompartidas" aria-controls="tabVentasCompartidas" role="tab" data-toggle="tab" data-i18n="ventas-compartidas">Ventas compartidas</a>
                            </li>
                            <li role="presentation" id="divTabHistorialEstatus">
                                <a href="#tabHistorialEstatus" aria-controls="tabHistorialEstatus" role="tab" data-toggle="tab" data-i18n="historial-estatus">Historial Estatus</a>
                            </li>
                            <li role="presentation" id="divTabClausulas">
                                <a href="#tabClausulas" aria-controls="tabClausulas" role="tab" data-toggle="tab" data-i18n="clausulas">Cláusulas</a>

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
                                                        <th>lote</th>
                                                        <th>estatus</th>
                                                        <th>detalles</th>
                                                        <th>comentario</th>
                                                        <th>fecha-estatus</th>
                                                        <th>usuario</th>
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
                                                        <th>lote</th>
                                                        <th>precio</th>
                                                        <th>fecha-liberacion</th>
                                                        <th>comentario</th>
                                                        <th>usuario</th>
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
                                                        <th>asesor</th>
                                                        <th>coordinador</th>
                                                        <th>gerente</th>
                                                        <th>subdirector</th>
                                                        <th>director-regional</th>
                                                        <th>director-regional2</th>
                                                        <th>fecha-alta</th>
                                                        <th>usuario</th>
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
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" data-i18n="cerrar"> CERRAR </button>
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
                                                    <select id="idResidencial" name="idResidencial" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    data-size="7" size="5" data-container="body" required title="SELECCIONA UNA OPCIÓN" data-i18n-label="select-predeterminado"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idCondominioInventario" data-i18n="condominio">Condominio</label>
                                                    <select name="idCondominioInventario" id="idCondominioInventario" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true"
                                                     data-size="7" data-container="body" required data-i18n-label="select-predeterminado" title="SELECCIONA UNA OPCIÓN"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label" for="idEstatus" data-i18n="estatus">Estatus</label>
                                                    <select name="idEstatus" id="idEstatus" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    data-size="7" data-container="body" data-i18n-label="select-predeterminado" title="SELECCIONA UNA OPCIÓN" required></select>
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
                                                <th>meses-sin-intereses</th>
                                                <th>asesor</th>
                                                <th>coordinador</th>
                                                <th>gerente</th>
                                                <th>subdirector</th>
                                                <th>director-regional</th>
                                                <th>director-regional2</th>
                                                <th>estatus</th>
                                                <th>estatus-contratacion</th>
                                                <th>apartado</th>
                                                <th>comentario</th>
                                                <th>lugar-prospeccion</th>
                                                <th>fecha-de-validacion-del-enganche</th>
                                                <th>cantidad-enganche-pagado</th>
                                                <th>estatus-contratacion</th>
                                                <th>cliente</th>
                                                <th>coopropietarios</th>
                                                <th>comentario-neodata</th>
                                                <th>fecha-apertura</th>
                                                <th>apartado-de-reubicacion</th>
                                                <th>fecha-alta</th>
                                                <th>venta-compartida</th>
                                                <th>ubicacion</th>
                                                <th>tipo-proceso</th>
                                                <th>sede</th>
                                                <!--solo para popea y el otro sujeto-->
                                                <th>folio</th>
                                                <th>documentacion-entregada</th>
                                                <th>nom-cliente</th>
                                                <th>telefono</th>
                                                <th>celular</th>
                                                <th>correo</th>
                                                <th>fecha-nacimiento</th>
                                                <th>nacionalidad</th><!--40-->
                                                <th>originario-de</th>
                                                <th>estado-civil</th>
                                                <th>nombre-conyugue</th>
                                                <th>regimen</th>
                                                <th>domicilio-particular</th>
                                                <th>ocupacion</th>
                                                <th>empresa-en-la-que-trabaja</th>
                                                <th>puesto</th>
                                                <th>antuiguedad</th>
                                                <th>edad</th><!--50-->
                                                <th>domicilio-empresa</th>
                                                <th>telefono-empresa</th>
                                                <th>vive-en-casa</th>
                                                <th>copropietario</th>
                                                <th>referencia-pago</th>
                                                <th>costo-m2-lista</th>
                                                <th>costo-m2-final</th>
                                                <th>en-el-municipio-de</th>
                                                <th>importe-de-la-oferta</th>
                                                <th>importe-en-letra</th><!--60-->
                                                <th>saldo-del-posito</th>
                                                <th>aportacion-mensual</th>
                                                <th>fecha-1-aportacion</th>
                                                <th>fecha-liquidacion</th>
                                                <th>fecha-2da-liquidacion</th>
                                                <th>referencias-personales</th>
                                                <th>observaciones-2</th>
                                                <!--solo para popea y el otro sujeto end-->
                                                <th>porcentaje-enganche</th>
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
                                        <h3 class="card-title center-align" data-i18n="descarga-inventario-lotes-sede">Descargar inventario de lotes por sede</h3>
                                        <p class="card-title pl-1"></p>
                                    </div>
                                    <div  class="toolbar">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="col-md-4 form-group">
                                                    <div class="form-group select-is-empty">
                                                        <label class="control-label" data-i18n="sedes-por-proyectos">Sedes por proyecto</label>
                                                        <select name="sedes" id="sedes" class="selectpicker select-gral m-0"
                                                                data-style="btn" data-show-subtext="true"  data-i18n-label="selecciona-una-opcion" title="SELECCIONA UNA OPCIÓN"                                                                
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
                                                <th>proyecto</th>
                                                <th>condominio</th>
                                                <th>lote</th>
                                                <th>id-lote</th>
                                                <th>superficie</th>
                                                <th>precio-lista</th>
                                                <th>total-con-descuentos</th>
                                                <th>M2</th>
                                                <th>referencia</th>
                                                <th>meses-sin-intereses</th>
                                                <th>asesor</th>
                                                <th>coordinador</th>
                                                <th>gerente</th>
                                                <th>subdirector</th>
                                                <th>director-regional</th>
                                                <th>director-regional2</th>
                                                <th>estatus</th>
                                                <th>estatus-contratacion</th>
                                                <th>fecha-apartado</th>
                                                <th>comentario</th>
                                                <th>lugar-prospeccion</th>
                                                <th>fecha-de-validacion-del-enganche</th>
                                                <th>fecha-apertura</th>
                                                <th>CANTIDAD DEL ENGANCHE PAGADO</th>
                                                <th>cliente</th>
                                                <th>cpmentario-neodata</th>
                                                <th>fecha-apertura</th>
                                                <th>apartado-de-reubicacion</th>
                                                <th>fecha-alta</th>
                                                <th>venta-compartida</th>
                                                <th>ubicacion-de-la-venta</th>
                                                <th>tipo-proceso</th>
                                                <th>reubicacion</th>
                                                <th>fecha-de-reubicacion</th>
                                                <th>sede</th>
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