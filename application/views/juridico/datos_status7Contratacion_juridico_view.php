<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>

    <style type="text/css">
        .textoshead::placeholder { color: white; }
    </style>

    <!--MAIN CONTENT-->
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
                                <div class="row">
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover" id="Jtabla" name="Jtabla">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>TIPO DE VENTA</th>
                                                <th>PROYECTO</th>
                                                <th>CONDOMINIO</th>
                                                <th>LOTE</th>
                                                <th>GERENTE</th>
                                                <th>CLIENTE</th>
                                                <th>F.MODIFICADO</th>
                                                <th>F.VENCIMIENTO</th>
                                                <th>ASIGANADO A</th>
                                                <th>UBICACIÓN</th>
                                                <th></th>
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

    <!-- modal  ENVIA A CONTRALORIA 7-->
    <div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 7 (Ventas)- <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save1" class="btn btn-primary">Registrar</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!-- modal  ENVIA A CONTRALORIA 7-->
    <div class="modal fade" id="editLoteRev" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 7 (Ventas)- <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario2" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save2" class="btn btn-primary">Registrar</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!-- modal  rechazar A CONTRALORIA 7-->
    <div class="modal fade" id="rechReg" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Rechazo estatus 7 (Contraloría)- <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario3" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save3" class="btn btn-primary">Registrar</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!-- modal  rechazar A asesor 7-->
    <div class="modal fade" id="rechazoAs" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Rechazo estatus 7 (Asesor)- <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario4" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save4" class="btn btn-primary">Registrar</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!-- modal  ENVIA A CONTRALORIA 7-->
    <div class="modal fade" id="rev8" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Registro estatus 7 (Ventas) - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario5" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save5" class="btn btn-primary">Registrar</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!--modal del codigo de barras-->
    <div class="barc modal fade" id="codeB" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" style="padding: 40px;background-color: rgba(255,255,255,1);color:  #FFF;">
                <div class="modal-body">
                    <center>
                        <img id="imgBar" class="img-responsive">
                    </center>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <br>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal change sede-->
    <div class="modal fade" id="change_s" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Modificación de sede - <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                

                            <div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <label id="tvLbl">Sede</label>
                                <select required="required" name="ubicacion" id="ubicacion"
                                        class="selectpicker" data-style="btn" title="SELECCIONA UBICACIÓN" data-size="7">
                                </select>
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
    <!-- modal -->

    <!-- modal reasignacion -->
    <div class="modal fade" id="change_u" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <center><h4 class="modal-title"><label>Reasignación de contrato - <b><span class="userJ"></span></b></label></h4></center>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label id="tvLbl">Nuevo usuario:</label>
                            <select required="required" name="user_re" id="user_re"
                                    class="selectpicker select-gral m-0" data-style="btn" data-live-search="true" title="Selecciona un usuario" data-size="7">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple mt-1" data-dismiss="modal">Cancelar
                    <button type="button" id="reassing" class="btn btn-primary mt-1">Reasignar</button>
                    <!--<button type="button" id="reassing" class="btn btn-success"><span class="material-icons" >send</span> </i> Reasignar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>-->
                </div>
            </div>
        </div>
    </div>
    <!-- fin modal reas -->

    <!-- modal  rechazar A asesor contra-->
    <div class="modal fade" id="return1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Rechazo estatus 7 (Contraloría)- <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario6" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save6" class="btn btn-primary">Registrar</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!-- modal  rechazar A asesor-->
    <div class="modal fade" id="return2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <center><h4 class="modal-title"><label>Rechazo estatus 7 (Asesor)- <b><span class="lote"></span></b></label></h4></center>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="form-control" id="comentario7" rows="3"></textarea>
                        <br>              
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save7" class="btn btn-primary">Registrar</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/juridico/vista_7_juridico.js"></script>
