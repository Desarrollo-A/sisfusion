<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>
        <!-- modal para revision status 5 100% -->
        <div class="modal fade " id="envARevCE" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center">
                            Registro estatus 5 - <b><span class="lote"></span></b>
                        </h4>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label class="control-label">Comentario (<span class="isRequired">*</span>)</label>
                                <textarea type="text" class="text-modal" name="comentario" id="comentarioenvARevCE"></textarea>
                            </div>
                            <input type="hidden" name="idLote" id="idLoteenvARevCE" >
                            <input type="hidden" name="idCliente" id="idClienteenvARevCE" >
                            <input type="hidden" name="idCondominio" id="idCondominioenvARevCE" >
                            <input type="hidden" name="fechaVenc" id="fechaVencenvARevCE" >
                            <input type="hidden" name="nombreLote" id="nombreLoteenvARevCE"  >
                            <input type="hidden" name="movimientoLote" id="movimientoLote"  >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="enviarenvARevCE" onClick="preguntaenvARevCE()" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade " id="backToStatus6" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Registro estatus 6 - <b><span class="lote"></span></b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <labe class="control-label">Comentario (<span class="isRequired">*</span>)</label>
                                <textarea type="text" class="text-modal" name="comentario" id="comentarioDirSt6"></textarea>
                            </div>
                            <input type="hidden" name="idLote" id="idLoteDirSt6" >
                            <input type="hidden" name="idCliente" id="idClienteDirSt6" >
                            <input type="hidden" name="idCondominio" id="idCondominioDirSt6" >
                            <input type="hidden" name="fechaVenc" id="fechaVencDirSt6" >
                            <input type="hidden" name="nombreLote" id="nombreLoteDirSt6"  >
                            <input type="hidden" name="movimientoLote" id="movimientoLoteDirSt6"  >
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="enviarAStatus6CE" onClick="enviarAStatus6CE()" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade " id="backToStatus7" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Registro estatus 7 - <b><span class="lote"></span></b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label class="control-label">Comentario (<span class="isRequired">*</span>)</label>
                                <textarea type="text" class="text-modal" name="comentario" id="comentarioDirSt7" autocomplete="off"></textarea>
                            </div>
                            <input type="hidden" name="idLote" id="idLoteDirSt7" >
                            <input type="hidden" name="idCliente" id="idClienteDirSt7" >
                            <input type="hidden" name="idCondominio" id="idCondominioDirSt7" >
                            <input type="hidden" name="fechaVenc" id="fechaVencDirSt7" >
                            <input type="hidden" name="nombreLote" id="nombreLoteDirSt7"  >
                            <input type="hidden" name="movimientoLote" id="movimientoLoteDirSt7"  >
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="enviarAStatus7CE" onClick="enviarAStatus7CE()" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal para rechazar estatus-->
        <div class="modal fade" id="rechazarStatus" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Rechazo estatus 1 - <b><span class="lote"></span></b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label class="control-label">Comentario (<span class="isRequired">*</span>)</label>
                            <textarea class="text-modal" id="motivoRechazo" rows="3"></textarea>
                            <input type="hidden" name="idCliente" id="idClienterechCor" >
                            <input type="hidden" name="idCondominio" id="idCondominiorechCor" >
                            <input type="hidden" name="idStatusContratacion" id="idStatusContratacion" >
                            <input type="hidden" name="idMovimiento" id="idMovimiento" >
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="guardar" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  ENVIA A ASESOR por rechazo 2-->
        <div class="modal fade" id="rechazarStatus_2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Rechazo estatus 5 - <b><span class="lote"></span></b></h4>
                    </div>
                    <div class="modal-body">
                        <label class="control-label">Comentario (<span class="isRequired">*</span>)</label>
                        <textarea class="text-modal" id="comentario2" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save2" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="envARev2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Registro estatus 5 - <b><span class="lote"></span></b></h4>
                    </div>
                    <div class="modal-body">
                        <label class="control-label">Comentario (<span class="isRequired">*</span>)</label>
                        <textarea class="text-modal" id="comentario1" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save1" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-expand fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Estatus 3 Revisión </h3>
                                    <p class="card-title pl-1">(Ventas particulares)</p>
                                </div>
                                <div  class="toolbar">
                                    <div class="row">
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table  id="tabla_estatus3" name="tabla_estatus3" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>MOVIMIENTO</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>REFERENCIA</th>
                                                <th>GERENTE</th>
                                                <th>CLIENTE</th>
                                                <th>FECHA DE MODIFICACIÓN</th>
                                                <th>FECHA DE VENCIMIENTO</th>
                                                <th>UC</th>
                                                <th>SEDE</th>
                                                <th>COMENTARIO</th>
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

</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/postventa/vista_3_postventa.js"></script>

