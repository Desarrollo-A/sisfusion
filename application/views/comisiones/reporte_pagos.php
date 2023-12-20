<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Reporte de pagos</h3>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="proyecto"  class="control-label">PUESTO (<span class="isRequired">*</span>)</label>
                                            <select name="puesto_reporte" id="puesto_reporte" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                <option value="3">GERENTE</option>
                                                <option value="9">COORDINADOR</option> 
                                                <option value="7">ASESOR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label class="control-label">NOMBRE (<span class="isRequired">*</span>)</label>
                                            <select class="selectpicker select-gral" id="nombre_reporte" name="nombre_reporte[]" data-style="btn " data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover" id="tabla_historialGral" name="tabla_historialGral">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>REFEFERENCIA</th>
                                                <th>PRECIO DEL LOTE</th>
                                                <th>TOTAL DE LA COMPRA</th>
                                                <th>PAGO POR EL CLIENTE</th>
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
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
</div>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/comisiones/reportePagos.js"></script>
</body>