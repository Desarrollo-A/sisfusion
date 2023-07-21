<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
<div class="wrapper ">
    <?php
    $this->load->view('template/sidebar');
    $this->load->view('template/controversy_modals');
    ?>
    <style>
        .zoom {
            transition: 1.5s ease;
            -moz-transition: 1.5s ease; /* Firefox */
            -webkit-transition: 1.5s ease; /* Chrome - Safari */
            -o-transition: 1.5s ease; /* Opera */
        }

        .zoom:hover {
            transform: scale(1.5);
            -moz-transform: scale(1.5); /* Firefox */
            -webkit-transform: scale(1.5); /* Chrome - Safari */
            -o-transform: scale(1.5); /* Opera */
            -ms-transform: scale(1.5); /* IE9 */
        }

        .btn-cm {
            background-color: #103f75;
            color: white;
            border-radius: 6px;
        }
    </style>
    <div class="modal fade" id="solicitarAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="subir_evidencia_form" name="subir_evidencia_form" method="post">
                    <div class="modal-header">
                        <div class="card-header d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="mx-3">
                                    <h4 class="modal-title">Subir evidencia</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <label>Sube tu archivo:</label><br>
                        <div class="input-group"><label class="input-group-btn">
                            <span class="btn btn-primary btn-file">Seleccionar archivo&hellip;
                                <input type="file" name="docArchivo1" id="expediente1" style="visibility: hidden" accept="image/x-png,image/gif,image/jpeg, image/jpg">
                            </span></label><input type="text" class="form-control" id="txtexp1" readonly></div>
                        <label>Observaciones : </label>
                        <textarea class="form-control" id="comentario_0" name="comentario_0" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                        <input type="hidden" id="tamanocer" name="tamanocer" value="1" style="color: black">
                        <input type="hidden" name="idCliente" id="idCliente">
                        <input type="hidden" name="idLote" id="idLote">
                        <input type="hidden" name="id_sol" id="id_sol">
                        <input type="hidden" name="nombreLote" id="nombreLote">
                        <br>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-primary" onclick="return validateEmptyFields()" id="btnSubmit">Enviar autorización</a>
                        <button type="submit" id="btnSubmitEnviar" class="btn btn-success hide"> Enviar autorización
                        </button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="evidenciaModalRev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" name="sendRespFromCB" id="sendRespFromCB">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title text-center" id="myModalLabel"><b>Autorizar evidencia</b></h3>
                        <h4 class="modal-title text-center" id="modal-mktd-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div id="loadAuts"></div>
                        <input type="hidden" name="nombreLote" id="nombreLote" value="">
                        <input type="hidden" name="idCliente" id="idCliente" value="">
                        <input type="hidden" name="idLote" id="idLote" value="">
                        <input type="hidden" name="id_evidencia" id="id_evidencia" value="">
                        <input type="hidden" name="evidencia_file" id="evidencia_file" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="button_enviar">Enviar autorización</button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade in" id="preguntaRechazar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                </div>
                <div class="modal-body text-center">
                    <h5>¿Desea rechazar esta evidencia? </h5>
                    <p style="font-size: 0.8em">Enviarás esta evidencia al gerente para su corrección.</p>
                    <textarea class="form-control" id="comentario_envio_gerente" name="comentario_envio_gerente" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-simple" data-dismiss="modal">Cancelar<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div></div></button>
                    <button type="button" class="btn btn-success btn-simple" id="btn_confirma_borrado">Sí</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade in" id="preguntaEnviarContraloria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                </div>
                <div class="modal-body text-center">
                    <h5>¿Estás seguro de hacer este movimiento? </h5>
                    <p style="font-size: 0.8em">Enviarás esta evidencia a Contraloría para su revisión.</p>
                    <div id="img_actual"></div>
                    <div id="comentario_contraloria"></div>
                    <textarea class="form-control" id="comentario_envio_contraloria" name="comentario_envio_contraloria" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="1000" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-simple" data-dismiss="modal" onclick="cleanElement()">Cancelar<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div></div></button>
                    <button type="button" class="btn btn-success btn-simple" id="btn_confirma_envio_contraloria" onclick="cleanElement()">Sí</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="preguntaDeleteMktd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cleanComments()"><i class="material-icons">clear</i></button>
                </div>
                <div class="modal-body text-center">
                    <h5>¿Estás seguro de hacer este movimiento?</h5>
                    <p style="font-size: 0.8em">Eliminarás a MARKETING DIGITAL de esta venta.</p>
                    <textarea class="form-control" id="comentario_delete_mktd" name="comentario_delete_mktd" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                    <input id="id_cliente_delete" type="hidden">
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-simple" data-dismiss="modal" onclick="cleanComments()">Cancelar <div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div></div></button>
                    <button type="button" class="btn btn-success btn-simple" id="btn_delete_mktd">Sí</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editarAutorizacionEvidencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="subir_evidencia_formE" name="subir_evidencia_formE" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="textoLote"></h4>
                    </div>
                    <div class="modal-body">
                        <div id="img_actual_input"></div>
                        <label>Sube tu archivo:</label><br>
                        <div class="input-group"><label class="input-group-btn">
                            <span class="btn btn-primary btn-file">Seleccionar archivo&hellip;
                                <input type="file" name="evidenciaE" id="evidenciaE" style="visibility: hidden" accept="image/x-png,image/gif,image/jpeg, image/jpg">
                            </span></label><input type="text" class="form-control" readonly>
                        </div>
                        <label>Observaciones : </label>
                        <textarea class="form-control w-100" id="comentario_E" name="comentario_E" rows="3" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                        <input type="hidden" id="tamanocerE" name="tamanocerE" value="1">
                        <input type="hidden" name="id_evidenciaE" id="id_evidenciaE">
                        <br>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-primary" onclick="return validateEmptyFieldsE()" id="btnSubmitE">Enviar autorización</a>
                        <button type="submit" id="btnSubmitEnviarE" class="btn btn-success hide"> Enviar autorización</button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="nav nav-tabs nav-tabs-cm">
                        <li class="active"><a href="#solicitar" data-toggle="tab" onclick="javascript:$('#sol_aut').DataTable().ajax.reload();">SOLICITAR</a></li>
                        <li><a href="#aut" data-toggle="tab" onclick="javascript:$('#checkEvidencia').DataTable().ajax.reload();">Reporte evidencias</a></li>
                        <li><a href="#controversy" data-toggle="tab" onclick="javascript:$('#controversyTable').DataTable().ajax.reload();">Controversias</a></li>
                    </ul>
                    <div class="card no-shadow m-0">
                        <div class="card-content p-0">
                            <div class="nav-tabs-custom">
                                <div class="tab-content p-2">
                                    <div class="active tab-pane" id="solicitar">
                                        <h3 class="card-title center-align">Solicitar</h3>
                                        <div class="table-responsive">
                                            <table id="sol_aut" class="table-striped table-hover" style="text-align:center;width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>ID LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>TELÉFONO</th>
                                                    <th>LOTE</th>
                                                    <th>PLAZA</th>
                                                    <th>ASESOR</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>TIPO</th>
                                                    <th>LUGAR PROSPECCIÓN</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="aut">
                                        <h3 class="card-title center-align">Reporte de evidencias</h3>
                                        <div class="table-responsive">
                                            <table id="checkEvidencia" class="table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th data-toggle="tooltip" datitle="ID lote">ID LOTE</th>
                                                    <th data-toggle="tooltip" title="Fecha apartado">FECHA APARTADO</th>
                                                    <th data-toggle="tooltip" title="Plaza">PLAZA</th>
                                                    <th data-toggle="tooltip" title="Lote">LOTE</th>
                                                    <th data-toggle="tooltip" title="Cliente">CLIENTE</th>
                                                    <th data-toggle="tooltip" title="Solicitante">SOLICITANTE</th>
                                                    <th data-toggle="tooltip" title="Estatus">ESTATUS</th>
                                                    <th data-toggle="tooltip" title="Tipo">TIPO</th>
                                                    <th data-toggle="tooltip" title="Validación gerente">VALIDACIÓN GERENTE</th>
                                                    <th data-toggle="tooltip" title="Validación cobranza">VALIDACIÓN COBRANZA/th>
                                                    <th data-toggle="tooltip" title="Validación contraloría">VALIDACIÓN CONTRALORIA</th>
                                                    <th data-toggle="tooltip" title="Rechazo cobranza">RECHAZO COBRANZA</th>
                                                    <th data-toggle="tooltip" title="Rechazo contraloría">RECHAZO CONTRALORÍA</th>
                                                    <th data-toggle="tooltip" title="Lugar prospección">LUGAR PROSPECCIÓN</th>
                                                    <th data-toggle="tooltip" title="Acciones">ACCIONES</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="controversy">
                                        <h3 class="card-title center-align">Controversias</h3>
                                        <div class="toolbar">
                                            <form method="POST" name="formControversias" id="formControversias" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-2 pl-0">
                                                            <div class="form-group label-floating select-is-empty">
                                                                <label class="control-label">Tipo</label>
                                                                <select id="controversy_type" name="controversy_type" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="Selecciona el tipo" data-size="7" required>
                                                                    <option value="1">Normal</option>
                                                                    <option value="2">Para descuento</option>
                                                                    <option value="4">MKTD 2022</option>
                                                                    <option value="5">Carga masiva</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 pl-0">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label label-gral">ID lote</label>
                                                                <input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 pl-0">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label label-gral">Comentario</label>
                                                                <textarea class="form-control scrollG-styles text-gral" id="controversy_comment" name="controversy_comment" rows="3" maxlength="1000" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 pl-0">
                                                            <div class="form-group label-floating">
                                                                <button type="submit" class="btn-gral-data">Agregar
                                                                </button>
                                                                <input id="handlerIdCliente" type="hidden" name="handlerIdCliente">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="table-responsive">
                                                    <table id="controversyTable" class="table-striped table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>ID LOTE</th>
                                                            <th>LOTE</th>
                                                            <th>TIPO</th>
                                                            <th>COMENTARIO</th>
                                                            <th>FECHA APARTADO</th>
                                                            <th>SEDE</th>
                                                            <th>CLIENTE</th>
                                                            <th>FECHA CREACIÓN</th>
                                                            <th>CREADO POR</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="nuevas">
                                        <h3 class="card-title center-align">Nuevas evidencias</h3>
                                        <div class="table-responsive">
                                            <table id="sol_aut" class="table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ID LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>TELÉFONO</th>
                                                    <th>LOTE</th>
                                                    <th>ASESOR</th>
                                                    <th>PLAZA</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>TIPO</th>
                                                    <th>LUGAR PROSPECCIÓN</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
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
    <div class="modal fade in" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
        <div class="modal-dialog modal-small ">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>¡Se ha añadido controversia exitosamente!</h5>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-cm" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade in" id="error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-small ">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5>¡Se ha añadido controversia exitosamente!</h5>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-cm" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="modalConfirmRequest" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-body text-center">
                        <h5>¿Estás segura de ingresar una controversia para el siguiente lote? </h5>
                        <h5 id="loteName"></h5>
                        <p style="font-size: 0.8em">El cambio no podrá ser revertido.</p>
                    </div>
                    <input id="idLote" class="hide">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple cancel_operation_addc" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary acept_operation_addc" id="sendRequest">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer_legend'); ?>
</div>
</div><!--main-panel close-->

<?php $this->load->view('template/footer'); ?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>dist/js/evidencias.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/addEvidenciaCB.js"></script>
</body>