<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                <li role="presentation" id="tab-proceso">
                                    <a href="#tabHistoriaContratacion" aria-controls="tabHistoriaContratacion" role="tab" data-toggle="tab" id="verProceso">Historial de contratación</a>
                                </li>
                                <li role="presentation" id="tab-preproceso">
                                    <a href="#tabHistoriaContratacion" aria-controls="tabHistoriaContratacion" role="tab" data-toggle="tab" id="verPreproceso" class="btn-historial" data-idLote="" data-flagFusion="">Historial preproceso</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="proceso">
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
                            </div>
                            <div class="tab-content" id="preproceso">
                                <div class="modal-body">
                                    <div role="tabpanel">
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="historialTap">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-plain">
                                                            <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                                <ul class="timeline-3" id="historialLine"></ul>
                                                            </div>
                                                        </div>
                                                    </div>
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

        <div class="modal fade" id="modalRegreso" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="regresoLo">
                        <h4 class="modal-title"><label><span class="titulo_modal">Regresión del lote - </span><b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <textarea class="text-modal scroll-styles" id="comentarioRe" rows="3" placeholder="Comentario"></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="saveRegreso" class="btn btn-primary">ACEPTAR</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalCambio" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="regresoLo">
                        <h4 class="modal-title"><label><span class="titulo_modal_2"></span><b><span class="lote_2"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <textarea class="text-modal scroll-styles" id="comentarioRe" rows="3" placeholder="Comentario"></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="saveRegreso" class="btn btn-primary">ACEPTAR</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="detailPayments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content" style="background-color:#ecedf0">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reporte de ventas</h3>
                                    <p class="card-title pl-1"></p>
                                </div>
                                <div class="material-datatables">
                                    <table id="tablaReporteVentas" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>TIPO DE PROCESO</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>REFERENCIA DESTINO</th>
                                                <th>ID LOTE</th>
                                                <th>SUPERFICIE</th>
                                                <th>LOTE(S) ORIGEN</th>
                                                <th>REFERENCIA ORIGEN</th>
                                                <th>TOTAL NETO ORIGENES</th>
                                                <th>SUPERFICIE DE ORIGEN</th>
                                                <th>PRECIO M2 FINAL</th>
                                                <th>CLIENTE</th>
                                                <th>ASESOR</th>
                                                <th>GERENTE</th>
                                                <th>SUBDIRECTOR</th>
                                                <th>FECHA DE APARTADO</th>
                                                <th>ESTATUS LOTE</th>
                                                <th>ESTATUS CONTRATACIÓN</th>
                                                <th>FECHA ESTATUS 2 (PRE PROCESO)</th>
                                                <th>FECHA ÚLTIMO STATUS</th>
                                                <th>DISPERSIÓN</th>
                                                <th>ACCIONES</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/reestructura/reporteVentas.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/reestructura/historialMovimientos.js"></script>