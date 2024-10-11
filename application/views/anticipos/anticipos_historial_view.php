<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="anticipoModalInternomex" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="modal_anticipos_internomex_form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="card-title center-align"> <span data-i18n="pagar-anticipos">Pagar - Anticipos</span></h3>
                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group m-0 overflow-hidden">
                                    <label class="control-label" for="proyecto"><span data-i18n="proceso">Proceso</span></label>
                                    <select class="selectpicker select-gral m-0" name="procesoAntInternomex" id="procesoAntInternomex" data-style="btn" data-show-subtext="true" data-size="7" data-live-search="true" data-container="body" required>
                                    <option value="" disabled selected data-i18n="select-predeterminado">Selecciona una opción</option>    
                                        <option value="8"data-i18n="pagar">Pagar</option>
                                        <option value="0"data-i18n="rechazar">Rechazar</option>
                                    </select>
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                    <input type="hidden" id="id_anticipo" name="id_anticipo" value="">
                                    <input type="hidden" id="proceso" name="proceso" value="">
                                    <input type="hidden" id="monto" name="monto" value="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> <span data-i18n="cerrar">CERRAR</span></button>
                            <button type="submit" id="enviarAnticipo" class="btn btn-primary"><span data-i18n="enviar">ENVIAR</span></button>
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
                        </div>
                        <div class="card-content">
                        <h3 class="card-title center-align"> <span data-i18n="reporte-anticipos">Reporte de anticipos</span></h3>
                        <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <table class="table-striped table-hover" id="historial_general" name="historial_general">
                                                <thead>
                                                    <tr>                                                        
                                                        <th>id-anticipo</th>
                                                        <th>nombre</th>
                                                        <th>puesto</th>
                                                        <th>sede</th>
                                                        <th>monto</th>
                                                        <th>comentario</th>
                                                        <th>comentario</th>
                                                        <th>fecha-contraloria</th>
                                                        <th>proceso-actual</th>
                                                        <th>prioridad</th>
                                                        <th>esquema</th>
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
            </div>
        </div>

    </div>
    <?php $this->load->view('template/footer');?>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/generales/mucho_texto.js "></script>
    <script src="<?= base_url() ?>dist/js/controllers/descuentos/anticipo/historial_anticipos.js"></script>
    <script type="text/javascript">
		Shadowbox.init();
	</script>
</body>
