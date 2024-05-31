<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="anticipoModalInternomexFinal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="modal_anticipos_internomex_form_final">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="card-title center-align">Continuar - Estatus</h3>
                            <h4 id="montoTituloFinal" class="center-align"></h4>

                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group m-0 overflow-hidden">
                                    <label class="control-label" for="proyecto">Proceso - Continuar Estatus</label>
                                    <select class="selectpicker select-gral m-0" name="procesoAntInternomexFinal" id="procesoAntInternomexFinal" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                        <option value="1">Continuar Proceso</option>
                                        <option value="0">Rechazar Proceso</option>
                                    </select>
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                    <input type="hidden" id="id_anticipo" name="id_anticipo" value="">
                                    <input type="hidden" id="proceso" name="proceso" value="">
                                    <input type="hidden" id="montoP" name="montoP" value="">
                                    <input type="hidden" id="numero_mensualidades" name="numero_mensualidades" value="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
                            <button type="submit" id="enviarAnticipoFinal" class="btn btn-primary">ENVIAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="anticipoModalInternomex" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="modal_anticipos_internomex_form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="card-title center-align">Pagar - Anticipos</h3>
                            <h4 id="montoTitulo" class="center-align"></h4>

                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group m-0 overflow-hidden">
                                    <label class="control-label" for="proyecto">Proceso</label>
                                    <select class="selectpicker select-gral m-0" name="procesoAntInternomex" id="procesoAntInternomex" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                        <option value="1">Pagar</option>
                                        <option value="0">Rechazar</option>
                                    </select>
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                    <input type="hidden" id="id_anticipo" name="id_anticipo" value="">
                                    <input type="hidden" id="proceso" name="proceso" value="">
                                    <input type="hidden" id="montoP" name="montoP" value="">
                                    <input type="hidden" id="numero_mensualidades" name="numero_mensualidades" value="">
                                </div>
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
                            <h3 class="card-title center-align">Reporte de anticipos Internomex</h3>
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <table class="table-striped table-hover" id="tabla_anticipos_internomex" name="tabla_anticipos_internomex">
                                                <thead>
                                                    <tr>
                                                        <th>ID ANTICIPO</th>
                                                        <th>ID USUARIO</th>
                                                        <th>NOMBRE</th>
                                                        <th>PROCESO</th>
                                                        <th>COMENTARIO</th>
                                                        <th>PRIORIDAD</th>
                                                        <th>IMPUESTO</th>
                                                        <th>SEDE</th>
                                                        <th>ESQUEMA</th>
                                                        <th>MONTO</th>
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
    <script src="<?= base_url() ?>dist/js/controllers/anticipos/anticipos_internomex.js"></script>
    <script type="text/javascript">
		Shadowbox.init();
	</script>
</body>
