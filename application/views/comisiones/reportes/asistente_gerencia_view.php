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
                                <h3 class="card-title center-align"><span data-i18n="seguimiento">Seguimiento</span> <b style=" color: #0067d4;" ><span data-i18n="comision-x-gerencia">comisiones por gerencia</span></b></h3>
                                <i class=""></i>
                            </div>
                           
                            <div class="toolbar">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group overflow-hidden">
                                                <label class="m-0" for="puestos"><span data-i18n="puesto">Puesto</span>(<span class="text-danger">*</span>)</label>
                                                <select class="selectpicker select-gral" name="puestos" id="puestos" data-style="btn" data-show-subtext="true" data-i18n-label="selecciona-una-opcion" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group overflow-hidden">
                                                <label class="m-0" for="usuarios"><span data-i18n="usuarios">Usuarios</span>(<span class="text-danger">*</span>)</label>
                                                <select class="selectpicker select-gral" name="usuarios" id="usuarios" data-style="btn" data-show-subtext="true" data-i18n-label="selecciona-una-opcion" data-size="7" data-live-search="true" data-container="body" required></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group overflow-hidden">
                                                <label class="m-0" for="proyectos"><span data-i18n="proyecto">Proyecto</span></label>
                                                <select class="selectpicker select-gral" name="proyectos" id="proyectos" data-style="btn" data-show-subtext="true" data-i18n-label="selecciona-una-opcion" data-size="7" data-live-search="true" data-container="body"></select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group overflow-hidden">
                                                <label class="m-0" for="estatus"><span data-i18n="estatus">Estatus</span></label>
                                                <select class="selectpicker select-gral" name="estatus" id="estatus" data-style="btn" data-show-subtext="true" data-i18n-label="selecciona-una-opcion" data-size="7" data-live-search="true" data-container="body"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="div-tabla" class="material-datatables">
                                <table class="table-striped table-hover" id="tabla-historial">
                                    <thead>
                                        <tr>
                                            <th>id-lote</th>
                                            <th>proyecto</th>
                                            <th>condominio</th>
                                            <th>lote</th>
                                            <th>ferencia</th>
                                            <th>precio-del-lote</th>
                                            <th>total-comision</th>
                                            <th>pago-cliente</th>
                                            <th>dispersado</th>
                                            <th>pagado</th>
                                            <th>pendiente</th>
                                            <th>usuario</th>
                                            <th>puesto</th>
                                            <th>detalle</th>
                                            <th>estatus</th>
                                            <th>acciones</th>
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