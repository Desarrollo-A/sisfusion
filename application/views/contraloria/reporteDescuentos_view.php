<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">

<style>
    .modal-backdrop{
        z-index:9;
    }
</style>

<body>
    <div class="wrapper">
            <?php $this->load->view('template/sidebar'); ?>
            <div class="content boxContent">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                    <i class="material-icons">dashboard</i>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title center-align">Reporte descuentos</h3>
                                    <div class="toolbar">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 m-0">
                                                        <div class="form-group">
                                                            <label  class="control-label" for="sede">Sede</label>
                                                            <select name="sede" id="sede" class="selectpicker select-gral" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 m-0">
                                                        <div class="form-group">
                                                            <label  class="control-label" for="empresa">Empresa</label>
                                                            <select name="empresa" id="empresa" class="selectpicker select-gral" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 m-0">
                                                        <div class="form-group">
                                                            <label  class="control-label" for="puesto">Puesto</label>
                                                            <select name="puesto" id="puesto" class="selectpicker select-gral" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 m-0">
                                                        <div class="form-group">
                                                            <label  class="control-label" for="usuarios">Usuario</label>
                                                            <select name="usuarios" id="usuarios" class="selectpicker select-gral" data-container="body" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <?php $this->load->view('descuentos/complementos/rangoFechas'); ?>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 m-0">
                                                    <div class="form-group d-flex justify-center align-center">
                                                        <h4 class="title-tot center-align m-0">Total préstamos:</h4>
                                                        <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <table class="table-striped table-hover" id="tabla_prestamos" name="tabla_prestamos">
                                                <thead>
                                                    <tr>
                                                        <th>ID PRÉSTAMO</th>
                                                        <th>ID PAGO</th>
                                                        <th>ID LOTE</th>
                                                        <th>ID EMPLEADO</th>
                                                        <th>NOMBRE</th>
                                                        <th>MONTO TOTAL</th>
                                                        <th># PARCIALIDADES</th>
                                                        <th>PARCIALIDAD ACTUAL</th>
                                                        <th>ESTATUS</th>
                                                        <th>TIPO DE DESCUENTO</th>
                                                        <th>FECHA SOLICITUD</th>
                                                        <th>FECHA DE APLICACIÓN</th>
                                                        <th>PLAZA</th>
                                                        <th>EMPRESA</th>
                                                        <th>EVIDENCIA</th>
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
</div>
	<?php $this->load->view('template/footer');?>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/general/funcionesGeneralesComisiones.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/contraloria/reporteDescuentos.js"></script>
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script type="text/javascript">
		Shadowbox.init();
	</script>
</body>