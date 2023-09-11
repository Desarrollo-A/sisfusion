<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title text-center"><label>Registro estatus 7 (Ventas)- <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <label>Comentario</label>
                    <textarea class="text-modal" id="comentario" rows="3"></textarea><br>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save1" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editLoteRev" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title text-center"><label>Registro estatus 7 (Ventas)- <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <label>Comentario</label>
                    <textarea class="text-modal" id="comentario2" rows="3"></textarea><br>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save2" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rechReg" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title text-center"><label>Rechazo estatus 7 (Contraloría)- <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <label>Comentario</label>
                    <textarea class="text-modal" id="comentario3" rows="3"></textarea>
                    <br>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save3" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rechazoAs" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Rechazo estatus 7 (Asesor)- <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <label>Comentario</label>
                    <textarea class="text-modal" id="comentario4" rows="3"></textarea><br>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save4" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rev8" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title text-center"><label>Registro estatus 7 (Ventas) - <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <label>Comentario</label>
                    <textarea class="text-modal" id="comentario5" rows="3"></textarea>
                    <br>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save5" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="barc modal fade" id="codeB" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" style="padding: 40px;background-color: rgba(255,255,255,1);color:  #FFF;">
                <div class="modal-body d-flex justify-center">
                    <img id="imgBar" class="img-responsive">
                </div>
                <div class="modal-footer d-flex justify-center">
                    <br><button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="change_s" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title"><label>Modificación de sede - <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
                            <label id="tvLbl">Sede</label>
                            <select name="ubicacion" id="ubicacion" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="savecs" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="change_u" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title"><label>Reasignación de contrato - <b><span class="userJ"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
                            <label id="tvLbl">Nuevo usuario:</label>
                            <select name="user_re" id="user_re" class="selectpicker select-gral m-0" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7"  data-container="body" required></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple mt-1" data-dismiss="modal">Cancelar
                    <button type="button" id="reassing" class="btn btn-primary mt-1">Reasignar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="return1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title"><label>Rechazo estatus 7 (Contraloría)- <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <label>Comentario</label>
                    <textarea class="text-modal" id="comentario6" rows="3"></textarea><br>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save6" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="return2" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title text-center"><label>Rechazo estatus 7 (Asesor)- <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <label>Comentario</label>
                    <textarea class="text-modal" id="comentario7" rows="3"></textarea>
                    <br>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save7" class="btn btn-primary">Registrar</button>
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
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align" >Registro de Clientes</h3>
                                <p class="card-title pl-1">(7. Contrato elaborado)</p>
                            </div>
                            <div class="toolbar">
                                <div class="row"></div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <table class="table-striped table-hover" id="Jtabla" name="Jtabla">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>TIPO DE VENTA</th>
                                                <th>TIPO DE PROCESO</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>GERENTE</th>
                                                <th>CLIENTE</th>
                                                <th>FECHA DE MODIFICADO</th>
                                                <th>FECHA DE VENCIMIENTO</th>
                                                <th>ASIGNADO A</th>
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
</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/juridico/vista_7_juridico.js"></script>
