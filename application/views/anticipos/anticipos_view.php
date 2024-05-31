<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <?php $this->load->view('descuentos/complementos/estilosPrestamos_comple'); ?>

        <div class="modal fade" id="parcialidadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="post" id="modal_parcialidad_form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 id="modalTitle" class="modal-title text-center" id="myModalLabel">Estatus - Mensualidades Parcialidades</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label" for="procesoParcialidad">Proceso</label>
                                <select class="selectpicker select-gral m-0" name="procesoParcialidad" id="procesoParcialidad" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                    <option value="1">Aceptar</option>
                                    <option value="0">Rechazar</option>
                                </select>
                                <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                <input type="hidden" id="id_anticipo" name="id_anticipo" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CERRAR</button>
                            <button type="submit" id="enviarAnticipoParcialidad" class="btn btn-primary">ENVIAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" id="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>

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
                                        <option value="0">Rechazar</option>
                                    </select>
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                    <input type="hidden" id="id_anticipo" name="id_anticipo" value="">
                                    <input type="hidden" id="proceso" name="proceso" value="">
                                    <input type="hidden" id="monto" name="monto" value="">
                                </div>
                            </div>

                            <div class="row aligned-row d-flex align-end pt-3" style="display: flex; justify-content: center">
                                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    <div class="form-group m-0 overflow-hidden">
                                        <label class="control-label" for="proyecto">Tipo:</label>
                                        <select class="selectpicker select-gral m-0" name="procesoTipo" id="procesoTipo" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body">
                                            <option value="1">Préstamo</option>
                                            <option value="0">Apoyo</option>
                                        </select>
                                    </div>
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
                                        <select class="selectpicker select-gral m-0 input-gral" name="numeroPagos" id="numeroPagos" data-style="btn" data-show-subtext="true"  title="SELECCIONA UN NÚMERO" data-size="7" data-live-search="true" data-container="body">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
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

                            <div class="row" id="prueba2">
                                <h2 class="text-center" id="tituloParcialidades">Parcialidades de Pagos</h2>

                                <div class="row aligned-row d-flex align-end pt-3" style="display: flex; justify-content: center">
                                    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                        <div class="form-group m-0 overflow-hidden">
                                            <label class="control-label" for="proyecto">Monto Pago:</label>
                                            <select name="tipo_pago_anticipo" id="tipo_pago_anticipo" class="selectpicker select-gral m-0 rl" data-default-value="opciones" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" ></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group overflow-hidden">
                                        <label class="control-label" for="proyecto">Número de Pagos Parcialidad </label>
                                        <select class="selectpicker select-gral m-0 input-gral" name="numeroPagosParcialidad" id="numeroPagosParcialidad" data-style="btn" data-show-subtext="true"  title="SELECCIONA UN NÚMERO" data-size="7" data-live-search="true" data-container="body" >
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group overflow-hidden">
                                        <label class="control-label" for="proyecto">Monto Pago Parcialidad</label>
                                        <input class="form-control m-0 input-gral" name="montoPrestadoParcialidad" id="montoPrestadoParcialidad" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label class="switch">
                                        <input class="nombreSwitch" id="nombreSwitch" name="nombreSwitch" type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                <div id="textoSwitch" name="textoSwitch" class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding-top:15px;">
                                    <span class="small text-gray textDescripcion hide" style="font-style: italic;" id="siTextoDescripcion" name="siTextoDescripcion">
                                        Presiona el botón para Mostrar Parcialidades
                                    </span>
                                    <span class="small text-gray textDescripcion" style="font-style: italic;" id="noTextoDescripcion" name="noTextoDescripcion">
                                        Presiona el botón para Ocultar Parcialidades
                                    </span>
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
    <script src="<?= base_url() ?>dist/js/controllers/anticipos/anticipos.js"></script>
    <script type="text/javascript">
		Shadowbox.init();
	</script>
</body>
