<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                        <div class="center-align" style="padding-top:20px; margin-bottom:2px; " >
                            <i class="fas fa-file-invoice-dollar fa-3x" style=" color: #0067d4;"></i>
                        <!--<i class="fas fa-dollar fa-2x " style=" color: #0067d4;" ></i> -->
                        </div>
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Seguimiento <b style=" color: #0067d4;" >comisiones por gerencia</b></h3>
                                <i class=""></i>
                            </div>
                           
                            <div class="toolbar">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group overflow-hidden">
                                                <label class="m-0" for="puestos">Puesto(<span class="text-danger">*</span>)</label>
                                                <select class="selectpicker select-gral" name="puestos" id="puestos" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group overflow-hidden">
                                                <label class="m-0" for="usuarios">Usuarios(<span class="text-danger">*</span>)</label>
                                                <select class="selectpicker select-gral" name="usuarios" id="usuarios" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group overflow-hidden">
                                                <label class="m-0" for="proyectos">Proyecto</label>
                                                <select class="selectpicker select-gral" name="proyectos" id="proyectos" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body"></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group overflow-hidden">
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
                                            <th>PRECIO DEL LOTE</th>
                                            <th>TOTAL DE LA COMISIÓN</th>
                                            <th>PAGO DEL CLIENTE</th>
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
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
<script src="<?=base_url()?>dist/js/controllers/comisiones/reportes/asistente_gerencia.js"></script>