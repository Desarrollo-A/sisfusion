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
                                                        <th <span data-i18n="lote">LOTE </span>  </span></th>
                                                        <th <span data-i18n="estatus">ESTATUS </span></th>
                                                        <th <span data-i18n="estatus">DETALLES </span></th>
                                                        <th <span data-i18n="estatus">COMENTARIO </span></th>
                                                        <th <span data-i18n="estatus">FECHA DE ESTATUS </span></th>
                                                        <th <span data-i18n="estatus">USUARIO </span></th>
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
                                                        <th <span data-i18n="lote">LOTE </span></th>
                                                        <th <span data-i18n="estatus">PRECIO </span></th>
                                                        <th <span data-i18n="estatus">FECHA DE LIBERACIÓN </span></th>
                                                        <th <span data-i18n="estatus">COMENTARIO </span></th>
                                                        <th <span data-i18n="estatus">USUARIO </span></th>
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
                                                        <th <span data-i18n="estatus">ASESOR </span></th>
                                                        <th <span data-i18n="estatus">COORDINADOR </span></th>
                                                        <th <span data-i18n="estatus">GERENTE </span></th>
                                                        <th <span data-i18n="estatus">SUBDIRECTOR </span></th>
                                                        <th <span data-i18n="estatus">DIRECTOR REGIONAL </span></th>
                                                        <th <span data-i18n="estatus">DIRECTOR REGIONAL 2 </span></th>
                                                        <th <span data-i18n="estatus">FECHA DE ALTA </span></th>
                                                        <th <span data-i18n="estatus">USUARIO </span></th>
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
                                                <th <span data-i18n="estatus">PROYECTO </span></th>
                                                <th <span data-i18n="estatus">REFERENCIA </span></th>
                                                <th <span data-i18n="estatus">MSI </span></th>
                                                <th <span data-i18n="estatus">ASESOR </span></th>
                                                <th <span data-i18n="estatus">COORDINADOR </span></th>
                                                <th <span data-i18n="estatus">GERENTE </span></th>
                                                <th <span data-i18n="estatus">SUBDIRECTOR </span></th>
                                                <th <span data-i18n="estatus">DIRECTOR REGIONAL </span></th>
                                                <th <span data-i18n="estatus">DIRECTOR REGIONAL 2 </span></th>
                                                <th <span data-i18n="estatus">ESTATUS </span></th>
                                                <th <span data-i18n="estatus">ESTATUS DE CONTRATACIÓN </span></th>
                                                <th <span data-i18n="estatus">APARTADO </span></th>
                                                <th <span data-i18n="estatus">COMENTARIO </span></th>
                                                <th <span data-i18n="estatus">LUGAR DE PROSPECCIÓN </span></th><!--20-->
                                                <th <span data-i18n="estatus">FECHA DE VALIDACIÓN ENGANCHE </span></th>
                                                <th <span data-i18n="estatus">CANTIDAD DE ENGANCHE PAGADO </span></th>
                                                <th <span data-i18n="estatus">ESTATUS DE LA CONTRATACIÓN </span></th>
                                                <th <span data-i18n="estatus">CLIENTE </span></th>
                                                <th <span data-i18n="estatus">COPROPIETARIO (S) </span></th>
                                                <th <span data-i18n="estatus">COMENTARIO DE NEODATA </span></th>
                                                <th <span data-i18n="estatus">FECHA DE APERTURA </span></th>
                                                <th <span data-i18n="estatus">APARTADO DE REUBICACIÓN </span></th>
                                                <th <span data-i18n="estatus">FECHA DE ALTA </span></th>
                                                <th <span data-i18n="estatus">VENTA COMPARTIDA </span></th><!--30-->
                                                <th <span data-i18n="estatus">UBICACIÓN DE LA VENTA </span></th>
                                                <th <span data-i18n="estatus">TIPO DE PROCESO </span></th>
                                                <th <span data-i18n="estatus">SEDE </span></th>

                                                <!--SOLO PARA POPEA Y EL OTRO SUJETO-->
                                                <th <span data-i18n="estatus">FOLIO </span></th>
                                                <th <span data-i18n="estatus">DOCUMENTACION ENTREGADA </span></th>
                                                <th <span data-i18n="estatus">NOMBRE CLIENTE </span></th>
                                                <th <span data-i18n="estatus">TEL. CASA </span></th>
                                                <th <span data-i18n="estatus">CELULAR </span></th>
                                                <th <span data-i18n="estatus">CORREO </span></th>
                                                <th <span data-i18n="estatus">FECHA DE NACIMIENTO </span></th>
                                                <th <span data-i18n="estatus">NACIONALIDAD </span></th><!--40-->
                                                <th <span data-i18n="estatus">ORIGINARIO DE </span></th>
                                                <th <span data-i18n="estatus">ESTADO CIVIL </span></th>
                                                <th <span data-i18n="estatus">NOMBRE CONYUGUE </span></th>
                                                <th <span data-i18n="estatus">REGIMEN </span></th>
                                                <th <span data-i18n="estatus">DOM. PARTICULAR </span></th>
                                                <th <span data-i18n="estatus">OCUPACIÓN </span></th>
                                                <th <span data-i18n="estatus">EMPRESA EN LA QUE TRABAJA </span></th>
                                                <th <span data-i18n="estatus">PUESTO </span></th>
                                                <th <span data-i18n="estatus">ANTIGÜEDAD </span></th>
                                                <th <span data-i18n="estatus">EDAD </span></th><!--50-->
                                                <th <span data-i18n="estatus">DOM. EMPRESA </span></th>
                                                <th <span data-i18n="estatus">TEL. EMPRESA </span></th>
                                                <th <span data-i18n="estatus">VIVE EN CASA </span></th>
                                                <th <span data-i18n="estatus">COPROPIETARIO </span></th>
                                                <th <span data-i18n="estatus">NO. REFERENCIA PAGO </span></th>
                                                <th <span data-i18n="estatus">COSTO M2 LISTA </span></th>
                                                <th <span data-i18n="estatus">COSTO M2 FINAL </span></th>

                                                <th <span data-i18n="estatus">EN EL MUNICIPIO DE </span></th>
                                                <th <span data-i18n="estatus">IMPORTE DE LA OFERTA </span></th>
                                                <th <span data-i18n="estatus">IMPORTE EN LETRA </span></th><!--60-->
                                                <th <span data-i18n="estatus">SALDO DEL DEPÓSITO </span></th>
                                                <th <span data-i18n="estatus">APORTACIÓN MENSUAL </span></th>
                                                <th <span data-i18n="estatus">FECHA 1RA APORTACIÓN </span></th>
                                                <th <span data-i18n="estatus">FECHA LIQUIDACIÓN </span></th>
                                                <th <span data-i18n="estatus">FECHA 2DA LIQUIDACIÓN </span></th>
                                                <th <span data-i18n="estatus">REFERENCIAS PERSONALES </span></th>
                                                <th <span data-i18n="estatus">OBSERVACIONES </span></th>

                                                <!--SOLO PARA POPEA Y EL OTRO SUJETO END-->
                                                <th <span data-i18n="estatus">PORCENTAJE ENGANCHE </span></th>
                                                <th <span data-i18n="estatus">ACCIONES </span></th><!--69-->
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
                                                <th <span data-i18n="estatus">PROYECTO </span></th>
                                                <th <span data-i18n="estatus">CONDOMINIO </span></th>
                                                <th <span data-i18n="estatus">LOTE </span></th>
                                                <th <span data-i18n="estatus">ID LOTE </span></th>
                                                <th <span data-i18n="estatus">SUPERFICIE </span></th>
                                                <th <span data-i18n="estatus">PRECIO DE LISTA </span></th>
                                                <th <span data-i18n="estatus">TOTAL CON DESCUENTOS </span></th>
                                                <th <span data-i18n="estatus">M2 </span></th>
                                                <th <span data-i18n="estatus">REFERENCIA </span></th>
                                                <th <span data-i18n="estatus">MESES SIN INTERESES </span></th>
                                                <th <span data-i18n="estatus">ASESOR </span></th>
                                                <th <span data-i18n="estatus">COORDINADOR </span></th>
                                                <th <span data-i18n="estatus">GERENTE </span></th>
                                                <th <span data-i18n="estatus">SUBDIRECTOR </span></th>
                                                <th <span data-i18n="estatus">DIRECTOR REGIONAL </span></th>
                                                <th <span data-i18n="estatus">DIRECTOR REGIONAL 2 </span></th>
                                                <th <span data-i18n="estatus">ESTATUS </span></th>
                                                <th <span data-i18n="estatus">ESTATUS DE CONTRATACION </span></th>
                                                <th <span data-i18n="estatus">FECHA DE APARTADO </span></th>
                                                <th <span data-i18n="estatus">COMENTARIO </span></th>
                                                <th <span data-i18n="estatus">LUGAR DE PROSPECCIÓN </span></th>
                                                <th <span data-i18n="estatus">FECHA DE VALIDACIÓN DEL ENGANCHE </span></th>
                                                <th <span data-i18n="estatus">FECHA DE APERTURA </span></th>
                                                <th <span data-i18n="estatus">CANTIDAD DEL ENGANCHE PAGADO </span></th>
                                                <th <span data-i18n="estatus">CLIENTE </span></th>
                                                <th <span data-i18n="estatus">COMENTARIO DE NEODATA </span></th>
                                                <th <span data-i18n="estatus">FECHA APERTURA </span></th>
                                                <th <span data-i18n="estatus">APARTADO DE REUBICACIÓN </span></th>
                                                <th <span data-i18n="estatus">FECHA ALTA </span></th>
                                                <th <span data-i18n="estatus">VENTA COMPARTIDA </span></th>
                                                <th <span data-i18n="estatus">UBICACIÓN DE LA VENTA </span></th>
                                                <th <span data-i18n="estatus">TIPO PROCESO </span></th>
                                                <th <span data-i18n="estatus">REUBICACIÓN </span></th>
                                                <th <span data-i18n="estatus">FECHA DE REUBICACIÓN </span></th>
                                                <th <span data-i18n="estatus">SEDE </span></th>
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