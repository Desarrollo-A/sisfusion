<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="anticipoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="modal_anticipos_form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="card-title center-align">Estatus - Anticipos</h3>
                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group m-0 overflow-hidden">
                                    <label class="control-label" for="proyecto">Proceso</label>
                                    <select class="selectpicker select-gral m-0" name="procesoAnt" id="procesoAnt" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                        <option value="7">Aceptar</option>
                                        <option value="6">Rechazar</option>
                                    </select>
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                    <input type="hidden" id="id_anticipo" name="id_anticipo" value="">
                                    <input type="hidden" id="proceso" name="proceso" value="">
                                    <input type="hidden" id="monto" name="monto" value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group overflow-hidden">
                                        <label class="control-label" for="proyecto">Monto prestado</label>
                                        <input class="form-control m-0 input-gral" name="montoPrestado" id="montoPrestado" readonly>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group overflow-hidden">
                                        <label class="control-label" for="proyecto">Número de pagos</label>
                                        <select class="selectpicker select-gral m-0 input-gral" name="numeroPagos" id="numeroPagos" data-style="btn" data-show-subtext="true"  title="SELECCIONA UN NÚMERO" data-size="7" data-live-search="true" data-container="body" required>
                                            <?php
                                                for ($i = 1; $i <= 11; $i++) {
                                                    echo "<option value='$i'>$i</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group overflow-hidden">
                                        <label class="control-label" for="proyecto">Pago</label>
                                        <input class="form-control m-0 input-gral" name="pago" id="pago" readonly>
                                    </div>
                                </div>
                            </div>
                                        
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label class="control-label">Comentario</label>
                                <textarea class="text-modal" id="comentario" name="comentario" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
                            <button type="submit" id="enviarAnticipo" class="btn btn-primary">ENVIAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Reporte de anticipos</h3>
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <table class="table-striped table-hover" id="tabla_anticipos" name="tabla_anticipos">
                                                <thead>
                                                    <tr>
                                                        <th>ID USUARIO</th>
                                                        <th>NOMBRE</th>
                                                        <th>PROCESO</th>
                                                        <th>COMENTARIO</th>
                                                        <th>PRIORIDAD</th>
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
        </div>

    </div>
    <?php $this->load->view('template/footer');?>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/anticipos/anticipos.js"></script>
    <script type="text/javascript">
		Shadowbox.init();
	</script>
</body>
