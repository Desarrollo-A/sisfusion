<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/autorizaciones-ds.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
<div class="wrapper">
    <?php  $this->load->view('template/sidebar'); ?>
    
    <div class="modal fade" id="modal_pregunta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"data-backdrop="static" data-keyboard="false" style="z-index: 1600;" >
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                <h4 class="modal-title">¿Realmente desea asignar este prospecto al cliente?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" id="cancelar" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="asignar_prospecto" data-dismiss="modal">ASIGNAR<div class="ripple-container"></div></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_aut_ds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Solicitar</b> autorización.</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="my-edit-form" name="my-edit-form" method="post">
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="asignar_prospecto_a_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Asignar</b> prospecto al cliente
                    <b><span id="nom_cliente" style="text-transform: uppercase"></span></b>.</h4>
                    <a type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;top: 2%;right: 5%;"><span class="material-icons">close</span></a>
                    <h5 class=""></h5>
                    <input type="hidden" id="id_cliente_asignar" name="id_cliente_asignar">
                    <div class="modal-body">
                        <div class="material-datatables">
                            <table class=" table-striped table-hover" id="table_prospectos">
                                <thead>
                                    <th>NOMBRE</th>
                                    <th>CORREO</th>
                                    <th>TELÉFONO</th>
                                    <th>OBSERVACIÓN</th>
                                    <th>LUGAR DE PROSPECCIÓN </th>
                                    <th>PLAZA DE VENTA</th>
                                    <th>NACIONALIDAD</th>
                                    <th>ASIGNAR</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_loader_assign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Asignando prospecto al cliente</h4>
                    <div class="modal-body" style="text-align: center">
                        <img src="<?=base_url()?>static/images/asignando.gif" width="100%">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar
                            <div class="ripple-container"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="integracionEx">
                    <h4 class="modal-title"><label>Integración de Expediente - <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <textarea class="text-modal scroll-styles" id="comentario" rows="3" placeholder="Comentario"></textarea>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save1" class="btn btn-primary">ACEPTAR</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="enviarNuevamenteEstatus3PV" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title"><label>Enviar nuevamente a postventa (despúes de un rechazo de postventa) - <b><span class="lote"></span></b></label></h4>
                </div>
                <div class="modal-body">
                    <label>Comentario:</label>
                    <textarea class="text-modal scroll-styles" id="comentarioST3PV2" rows="3" placeholder="Comentario"></textarea>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="guardar_re3pv" class="btn btn-primary"> Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="autorizaciones-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title">Envío de verificaciones al cliente</h4>
                </div>
                <form id="autorizacion-form">
                    <div class="modal-body">
                        <div class="row pt-1 pb-1 checkAut">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <h4 class="label-on-left m-0">MÉTODOS DE ENVÍO (<small style="color: red;">*</small>)</h4>
                                <div class="container boxChecks p-0">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0" id="chk-correo-aut-div">
                                        <label class="m-0 checkstyleAut">
                                            <input type="checkbox" name="chkCorreoAut" id="chkCorreoAut" onchange="chkCorreoAutOnChange()" checked>
                                            <span>CORREO ELECTRÓNICO</span>
                                        </label>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0" id="chk-sms-aut-div">
                                        <label class="m-0 checkstyleAut">
                                            <input type="checkbox" name="chkSmsAut" id="chkSmsAut" onchange="chkSmsAutOnChange()"checked>
                                            <span>MENSAJE DE TEXTO SMS</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1" id="correo-aut-div">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group m-0">
                                    <label class="label-on-left m-0">
                                        CORREO ELECTRÓNICO (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="correoAut" id="correoAut" type="email" placeholder="Ej. ejemplo@gmail.com" required/>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1" id="sms-aut-div">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group m-0">
                                    <h4 class="label-on-left m-0">LADA (<small style="color: red;">*</small>)</h4>
                                    <select name="ladaAut" title="SELECCIONA UNA OPCIÓN" id="ladaAut" class="selectpicker m-0 select-gral" data-live-search="true" data-container="body" data-width="100%" required>
                                        <option value="52">+52</option>
                                        <option value="1">+1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                <div class="form-group m-0">
                                    <label class="label-on-left m-0">
                                        CELULAR (<small style="color: red;">*</small>)
                                    </label>
                                    <input class="form-control input-gral" name="smsAut" id="smsAut" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" placeholder="Ej. 4422010101" required/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-sm-12 col-md-12 col-lg-12 mt-1">
                                <p>Nota: El mensaje SMS tarda de 2 a 3 minutos en llegar al teléfono del cliente.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="guardar-autorizacion" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reenvio-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Reenvío de verificaciones al cliente
                    </h4>
                </div>
                <form id="reenvio-form">
                    <div class="modal-body">
                        <div class="row pt-1 pb-1 checkAut">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <h4 class="label-on-left m-0">MÉTODOS DE ENVÍO (<small style="color: red;">*</small>)</h4>
                                <div class="container boxChecks p-0">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0" id="chk-correo-reenvio-div">
                                        <label class="m-0 checkstyleAut">
                                            <input type="checkbox" name="chkCorreoReenvio" id="chkCorreoReenvio" checked>
                                            <span>CORREO ELECTRÓNICO</span>
                                        </label>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0" id="chk-sms-reenvio-div">
                                        <label class="m-0 checkstyleAut">
                                            <input type="checkbox" name="chkSmsReenvio" id="chkSmsReenvio" checked>
                                            <span>MENSAJE DE TEXTO SMS</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                                <p>Nota: El mensaje SMS tarda de 2 a 3 minutos en llegar al teléfono del cliente.</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Reenviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="solicitar-modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Solicitar edición de verificación
                    </h4>
                </div>
                <form id="solicitar-form">
                    <div class="modal-body">
                        <div class="row pt-1 pb-1 checkAut">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <h4 class="label-on-left m-0">MÉTODOS DE ENVÍO (<small style="color: red;">*</small>)</h4>
                                <div class="container boxChecks p-0">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0" id="chk-correo-sol-div">
                                        <label class="m-0 checkstyleAut">
                                            <input type="checkbox" name="chkCorreoSol" id="chkCorreoSol" checked>
                                            <span>CORREO ELECTRÓNICO</span>
                                        </label>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0" id="chk-sms-sol-div">
                                        <label class="m-0 checkstyleAut">
                                            <input type="checkbox" name="chkSmsSol" id="chkSmsSol" checked>
                                            <span>MENSAJE DE TEXTO SMS</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
                                <div class="form-group label-floating select-is-empty overflow-hidden">
                                    <label class="control-label">Subdirector (<small style="color: red;">*</small>)</label>
                                    <select id="subdirector" name="subdirector" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un subdirector" data-size="7" data-container="body" required></select>
                                </div>
                            </div>
                            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                                <label>Comentario adicional (<small style="color: red;">*</small>)</label>
                                <textarea class="text-modal scroll-styles" name="comentario" id="comentarioSol" rows="3" placeholder="Comentario" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content hide">
        <!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->
        <div class="modal fade" id="modal2" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                            <textarea class="text-modal scroll-styles" name="comentario2" id="comentario2" rows="3" placeholder="Comentario" required></textarea>
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

        <!-- modal  ENVIA A CONTRALORIA 5 por rechazo 1-->
        <div class="modal fade" id="modal3" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Integración de expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="text-modal scroll-styles" name="comentario3" id="comentario3" rows="3" placeholder="Comentario" required></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save3" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- modal  ENVIA A CONTRALORIA 6 por rechazo 1-->
        <div class="modal fade" id="modal4" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Integración de Expediente (Rechazo estatus 6 Contraloría) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="text-modal scroll-styles" name="comentario4" id="comentario4" rows="3" placeholder="Comentario" required></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save4" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- modal  ENVIA A VENTAS 8 por rechazo 1-->
        <div class="modal fade" id="modal5" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Integración de Expediente (Rechazo estatus 8 Ventas) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="text-modal scroll-styles" name="comentario5" id="comentario5" rows="3" placeholder="Comentario" required></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save5" class="btn btn-primary"> Registrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="modal6" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Integración de Expediente (Rechazo estatus 7 Jurídico) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="text-modal scroll-styles" name="comentario6" id="comentario6" rows="3" placeholder="Comentario" required></textarea>
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

        <!-- modal  ENVIA A JURIDICO por rechazo 1-->
        <div class="modal fade" id="modal7" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title"><label>Integración de Expediente (Rechazo estatus 5 Contraloría) - <b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="text-modal scroll-styles" name="comentario7" id="comentario7" rows="3" placeholder="Comentario" required></textarea>
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

        <!-- modal  ENVIA A JURIDICO por rechazo 2-->
        <div class="modal fade" id="modal_return1" data-backdrop="static" data-keyboard="false" >
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title text-center"><label>Integración de Expediente (Rechazo estatus 7 Jurídico) -<b><span class="lote"></span></b></label></h4>
                    </div>
                    <div class="modal-body">
                        <label>Comentario:</label>
                        <textarea class="text-modal scroll-styles" name="comentario8" id="comentario8" rows="3" placeholder="Comentario" required></textarea>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="b_return1" class="btn btn-primary">Registrar</button>
                    </div>
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
                            <a href="https://youtu.be/1zcshxE2nP4" class="align-center justify-center u2be" target="_blank">
                                <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <?php if ($this->session->userdata('id_rol') != 6) { ?>
                                    <h3 class="card-title center-align">Tus ventas</h3>
                                <?php } else { ?>
                                    <h3 class="card-title center-align">Ventas</h3>
                                <?php } ?>

                                <p class="card-title pl-1"></p>
                            </div>
                            <?php
                            if($this->session->userdata('id_usuario') == 9651) {
                            ?>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Proyecto</label>
                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" required></select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Condominio</label>
                                                    <select name="condominio" id="condominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="material-datatables">
                                <table id="tabla_deposito_seriedad" name="tabla_deposito_seriedad" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>TIPO DE PROCESO</th>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>CLIENTE</th>
                                            <th>COORDINADOR</th>
                                            <th>GERENTE</th>
                                            <th>SUBDIRECTOR</th>
                                            <th>DIRECTOR REGIONAL</th>
                                            <th>DIRECTOR REGIONAL 2</th>
                                            <th>FECHA DE APARTADO</th>
                                            <th>FECHA DE VENCIMIENTO</th>
                                            <th>COMENTARIO</th>
                                            <th>PROSPECTO</th>
                                            <th>VERIFICACIÓN DE CORREO</th>
                                            <th>VERIFICACIÓN DE SMS</th>
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
</div>
</body>
<?php $this->load->view('template/footer');?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
<script src="<?=base_url()?>dist/js/controllers/asesores/depositoSeriedad.js"></script>
