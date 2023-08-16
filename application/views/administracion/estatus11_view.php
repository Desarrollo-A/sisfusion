<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />

<style>
    .form-group {
        margin: 0;
    }
</style>

<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="modal_registrar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><b>Validación</b> de enganche.</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class=""></h5>
                    </div>
                    <form id="my-edit-form" name="my-edit-form" method="post">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_cancelar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><b>Rechazar</b> estatus.</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="my-edit-form" name="my-edit-form" method="post">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title"><label>Registro estatus 11 - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <label>Comentario</label>
                            <textarea class="text-modal" id="comentario" rows="3"></textarea>
                            <br>
                        </div>
                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-1">
                            <label id="tvLbl">Total a validar</label>
                            <input class="form-control input-gral" name="totalNeto" id="totalNeto" oncopy="return false" onpaste="return false" readonly type="tel" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency">
                        </div>
                        <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6 mt-1">
                            <label id="tvLbl">Total validado</label>
                            <input type="tel" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" class="form-control input-gral" name="totalValidado" id="totalValidado" oncopy="return false" onpaste="return false" onkeypress="return SoloNumeros(event)">
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar</button>
                        <button type="button" id="save1" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rechReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                        <h4 class="modal-title">Rechazo estatus 11 - <b><span class="lote"></span></b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12 overflow-hidden">
                                        <label id="tvLbl">Comentario</label>
                                        <select name="comentario3" id="comentario3" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                            <option value="Transferencia no reflejada en Banco">Transferencia no reflejada en Banco</option>
                                            <option value="Cheque rebotado">Cheque rebotado</option>
                                            <option value="Rechazo por falta de dinero">Rechazo por falta de dinero</option>
                                            <option value="Pago American Express">Pago American Express</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                        <div id="valida_otro">
                                            <br>
                                            <label>Observaciones</label>
                                            <textarea class="form-control input-gral" id="observaciones" rows="3" style="text-align:center"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save3" class="btn btn-primary">Aceptar</button>
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
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Registro estatus 11</h3>
                                    <p class="card-title pl-1">(Validación de enganche)</p>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_ingresar_11" name="tabla_ingresar_11">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>TIPO DE VENTA</th>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>GERENTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>TOTAL NETO</th>
                                                    <th>FECHA REALIZADO</th>
                                                    <th>FECHA DE VENCIMIENTO</th>
                                                    <th>DÍAS TRANSCURRIDOS</th>
                                                    <th>ESTATUS ACTUAL</th>
                                                    <th>UBICACIÓN</th>
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
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/administracion/estatus11.js"></script>
</body>