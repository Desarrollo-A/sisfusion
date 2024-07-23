<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <?php $this->load->view('descuentos/complementos/estilosPrestamos_comple'); ?>


        

        <div class="modal fade" id="EmpresaModal" tabindex="-1" 
            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" 
            data-backdrop="static" data-keyboard="false">
            
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="post" id="modal_empresa_add">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>  
                        <input type="hidden" id="id_usuario" name="id_usuario" value="">
                        <input type="hidden" id="id_anticipo" name="id_anticipo" value="">

                        <div class="modal-body">
                            <select class="selectpicker select-gral m-0" name="empresaParcia" 
                            id="empresaParcia" data-style="btn" data-show-subtext="true" 
                            title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CERRAR</button>
                            <button type="submit" id="enviarAnticipoParcialidad" class="btn btn-primary">Guardar empresa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                                <input type="hidden" id="bandera_prestamo" name="bandera_prestamo" value="0">
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
                                    <select class="selectpicker select-gral m-0" name="procesoAnt" id="procesoAnt" 
                                    data-style="btn" data-show-subtext="true"  
                                    title="SELECCIONA UNA OPCIÓN" data-size="7" 
                                    data-live-search="true" data-container="body" required>
                                        <option value="7">Aceptar</option>
                                        <option value="0">Rechazar</option>
                                    </select>
                                    <input type="hidden" id="id_usuario_p" name="id_usuario" value="">
                                    <input type="hidden" id="id_anticipo_p" name="id_anticipo" value="">
                                    <input type="hidden" id="proceso" name="proceso" value="">
                                    <input type="hidden" id="monto" name="monto" value="">
                                    <input type="hidden" id="bandera_prestamo" name="bandera_prestamo" value="1">
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
                                        <select class="selectpicker select-gral m-0 input-gral" name="numeroPagos"
                                        id="numeroPagos" data-style="btn" data-show-subtext="true"  
                                        title="SELECCIONA UN NÚMERO" data-size="7" data-live-search="true" data-container="body">
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
                            <h3 class="card-title center-align">Proceso de anticipos</h3>
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="material-datatables">
                                        <div class="form-group">
                                            <table class="table-striped table-hover" id="tabla_anticipos" name="tabla_anticipos">
                                                <thead>
                                                    <tr>
                                                        <th>ID ANTICIPO</th>
                                                        <th>ID SOLICITANTE</th>

                                                        <th>NOMBRE SOLICITANTE</th>
                                                        <th>PROCESO</th>
                                                        
                                                        <th>EMPRESA</th>

                                                        <th>PROCESO NOMBRE</th>
                                                        <th>COMENTARIO</th>
                                                        
                                                        <th>RÉGIMEN</th>
                                                        <th>SOLICITADO</th>

                                                        <th>TOTAL IMPUESTO</th>
                                                        <th>DESCUENTO</th>

                                                        <th>PRIORIDAD</th>                                                        
                                                        <th>SEDE</th>

                                                        
                                                        <th>Monto parcial</th>
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
    <!-- <script src="<?= base_url() ?>dist/js/funciones-generales.js"></script> -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/anticipos/anticipos.js"></script>
    <script type="text/javascript">
		Shadowbox.init();
	</script>
</body>
