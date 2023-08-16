<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i></button>
                </div>
                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav" role="tablist">
                            <div id="nameLote"></div>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()">Cerrar</button>
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
                            <i class="fas fa-dollar fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Seguimiento <b>comisiones por gerencia</b></h3>
                            </div>
                            <div class="toolbar">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 overflow-hidden">
                                            <div class="form-group">
                                                <label class="m-0" for="puestos">Puesto(<span class="text-danger">*</span>)</label>
                                                <select class="selectpicker select-gral" name="puestos" id="puestos" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 overflow-hidden">
                                            <div class="form-group">
                                                <label class="m-0" for="usuarios">Usuarios(<span class="text-danger">*</span>)</label>
                                                <select class="selectpicker select-gral" name="usuarios" id="usuarios" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 overflow-hidden">
                                            <div class="form-group">
                                                <label class="m-0" for="proyectos">Proyecto</label>
                                                <select class="selectpicker select-gral" name="proyectos" id="proyectos" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body"></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 overflow-hidden">
                                            <div class="form-group">
                                                <label class="m-0" for="estatus">Estatus</label>
                                                <select class="selectpicker select-gral" name="estatus" id="estatus" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="div-tabla" class="material-datatables">
                                <table class="table-striped table-hover" id="tabla-historial">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>REFERENCIA</th>
                                            <th>PRECIO LOTE</th>
                                            <th>TOTAL COMISION</th>
                                            <th>PAGO CLIENTE</th>
                                            <th>DISPERSADO</th>
                                            <th>PAGADO</th>
                                            <th>PENDIENTE</th>
                                            <th>USUARIO</th>
                                            <th>PUESTO</th>
                                            <th>DETALLE</th>
                                            <th>ESTATUS</th>
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
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/ventas/seguimiento_comisiones_asistente.js"></script>