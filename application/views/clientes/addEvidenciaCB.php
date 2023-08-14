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

        <!-- MODALS -->

        <!-- SUBIR EVIDENCIAS-->
        <div class="modal fade " id="solicitarAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
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
                            <label class="control-label">Sube tu archivo:</label>

                            <!-- <div class="file-gph">
                                <input class="d-none" type="text" id="filename" name="filename"  >
                                <input class="file-name" id="expediente1" name="docArchivo1" accept="image/x-png,image/gif,image/jpeg, image/jpg" type="file" placeholder="No has seleccionada nada aún" />
                                <p id="archivoE" class="m-0 w-80 overflow-text"></p>
                                <label for="expediente1" class="upload-btn  m-0"><i class="fas fa-folder-open"></i> Subir archivo</label>
                            </div> -->


                            <div class="file-gph">
                                <input class="d-none" type="file" id="fileElm">
                                <input class="file-name" id="expediente1" name="docArchivo1" accept="image/x-png,image/gif,image/jpeg, image/jpg" type="file"  placeholder="No has seleccionada nada aún" readonly="">
                                <label class="upload-btn m-0" for="fileElm">
                                    <span>Seleccionar</span>
                                    <i class="fas fa-folder-open"></i>
                                </label>
                            </div>

                            <label class="control-label">Observaciones: </label>
                            <textarea class="text-modal" id="comentario_0" name="comentario_0" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                            <input type="hidden" id="tamanocer" name="tamanocer" value="1" style="color: black">
                            <input type="hidden" name="idCliente" id="idCliente">
                            <input type="hidden" name="idLote" id="idLote">
                            <input type="hidden" name="id_sol" id="id_sol">
                            <input type="hidden" name="nombreLote" id="nombreLote">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" href="#" class="btn btn-primary" onclick="return validateEmptyFields()" id="btnSubmit">Enviar autorización</button>
                            <button type="submit" id="btnSubmitEnviar" class="btn btn-success hide"> Enviar autorización</button>
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
        
        <!-- Rechazar a gerente-->
        <div class="modal fade in" id="preguntaRechazar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md ">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    </div>
                    <div class="modal-body pt-0">
                        <h5 class="mb-0">¿Desea rechazar esta evidencia? </h5>
                        <p style="font-size: 0.8em">Enviarás esta evidencia al gerente para su corrección.</p>
                        <label class="control-label mt-0">Ingresa tu comentario</label>
                        <textarea class="text-modal" id="comentario_envio_gerente" name="comentario_envio_gerente" rows="3" maxlength="1000" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-simple btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btn_confirma_borrado">ACEPTAR</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ENVIAR A CONTRALORÍA Reporte de Evidencias-->
        <div class="modal fade in" id="preguntaEnviarContraloria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    </div>
                    <div class="modal-body ">
                        <h5>¿Estás seguro de hacer este movimiento? </h5>
                        <p style="font-size: 0.8em">Enviarás esta evidencia a Contraloría para su revisión.</p>
                        <div id="img_actual"></div>
                        <div id="comentario_contraloria"></div>
                        <label class="control-label mt-1">Ingresa tu comentario</label>
                        <textarea class="text-modal" id="comentario_envio_contraloria" name="comentario_envio_contraloria" rows="3"  maxlength="1000" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanElement()">Cancelar<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div></div></button>
                        <button type="button" class="btn btn-primary" id="btn_confirma_envio_contraloria" onclick="cleanElement()">ACEPTAR</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ELIMINAR MKTD DE ESTA VENTA-->
        <div class="modal fade in" id="preguntaDeleteMktd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md ">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h5>¿Estás seguro de hacer este movimiento?</h5>
                        <p style="font-size: 0.8em">Eliminarás a MARKETING DIGITAL de esta venta.</p>
                        <textarea class="text-modal" id="comentario_delete_mktd" name="comentario_delete_mktd" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                        <input id="id_cliente_delete" type="hidden">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanComments()">Cancelar <div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 40.9625px; top: 23.8px; background-color: rgb(153, 153, 153); transform: scale(12.7953);"></div></div></button>
                        <button type="button" class="btn btn-primary" id="btn_delete_mktd">ACEPTAR</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Cambiar imagen de evidencias-->
        <div class="modal fade" id="editarAutorizacionEvidencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="subir_evidencia_formE" name="subir_evidencia_formE" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title text-center" id="textoLote"></h4>
                        </div>
                        <div class="modal-body">
                            <div id="img_actual_input"></div>

                            <div class="file-gph">
                                <input class="d-none" type="hidden" id="filename" name="filename">
                                <input class="file-name" id="evidenciaE" name="evidenciaE" accept="image/x-png,image/gif,image/jpeg, image/jpg" type="file"/>
                                <p id="archivoE" class="m-0 w-80 overflow-text"></p>
                                <label for="evidenciaE" class="upload-btn m-0"><i class="fas fa-folder-open"></i> Subir archivo</label>
                            </div>

                            <label class="control-label mt-1">Observaciones : </label>
                            <textarea class="text-modal" id="comentario_E" name="comentario_E" rows="3" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                            <input type="hidden" id="tamanocerE" name="tamanocerE" value="1">
                            <input type="hidden" name="id_evidenciaE" id="id_evidenciaE">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <a href="#" class="btn btn-primary" onclick="return validateEmptyFieldsE()" id="btnSubmitE">Enviar autorización</a>
                            <button type="submit" id="btnSubmitEnviarE" class="btn btn-success hide"> Enviar autorización</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--REGISTRAR CONTROVERSIA-->
        <div class="modal fade " id="modalConfirmRequest" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body" style="padding : 0px !important">
                        <div class="modal-body text-center">
                            <h5 class="mb-0">¿Estás segura de ingresar una controversia para el siguiente lote? </h5>
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
        <!-- END MODALS-->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active"><a href="#solicitar" data-toggle="tab" onclick="javascript:$('#sol_aut').DataTable().ajax.reload();">SOLICITAR</a></li>
                            <li><a href="#aut" data-toggle="tab" onclick="javascript:$('#checkEvidencia').DataTable().ajax.reload();">Reporte de evidencias</a></li>
                            <li><a href="#controversy" data-toggle="tab" onclick="javascript:$('#controversyTable').DataTable().ajax.reload();">Controversias</a></li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <!--Solicitar-->
                                        <div class="active tab-pane" id="solicitar">
                                            <h3 class="card-title center-align">Solicitar</h3>
                                            <table id="sol_aut" class="table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ID LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>TELÉFONO</th>
                                                    <th>LOTE</th>
                                                    <th>PLAZA</th>
                                                    <th>ASESOR</th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>TIPO</th>
                                                    <th>LUGAR PROSPECCIÓN</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <!-- Reporte de evidencias -->
                                        <div class="tab-pane" id="aut">
                                            <h3 class="card-title center-align">Reporte de evidencias</h3>
                                            <table id="checkEvidencia" class="table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID LOTE</th>
                                                        <th>FECHA DE APARTADO</th>
                                                        <th>PLAZA</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>SOLICITANTE</th>
                                                        <th>ESTATUS</th>
                                                        <th>TIPO</th>
                                                        <th>VALIDACIÓN DE GERENTE</th>
                                                        <th>VALIDACIÓN DE COBRANZA</th>
                                                        <th>VALIDACIÓN DE CONTRALORÍA</th>
                                                        <th>RECHAZO DE COBRANZA</th>
                                                        <th>RECHAZO DE CONTRALORÍA</th>
                                                        <th>LUGAR DE PROSPECCIÓN</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <!--Controversias-->
                                        <div class="tab-pane" id="controversy">
                                            <h3 class="card-title center-align">Controversias</h3>
                                            <div class="toolbar">
                                                <form method="POST" name="formControversias" id="formControversias" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 pl-0">
                                                                <div class="form-group select-is-empty">
                                                                    <label class="control-label">Tipo (<span class="isRequired">*</span>)</label>
                                                                    <select id="controversy_type" name="controversy_type" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required>
                                                                        <option value="1">NORMAL</option>
                                                                        <option value="2">PARA DESCUENTO</option>
                                                                        <option value="4">MKTD 2022</option>
                                                                        <option value="5">CARGA MASIVA</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 pl-0">
                                                                <div class="form-group">
                                                                    <label class="control-label label-gral">ID lote (<span class="isRequired">*</span>)</label>
                                                                    <input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-3 col-md-4 col-lg-4 pl-0">
                                                                <div class="form-group">
                                                                    <label class="control-label label-gral">Comentario</label>
                                                                    <textarea class="text-modal" style="height:45px;" id="controversy_comment" name="controversy_comment" rows="3" maxlength="1000" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 pl-0 pt-3 ">
                                                                <div class="form-group">
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
                                                    <table id="controversyTable" class="table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>ID LOTE</th>
                                                                <th>LOTE</th>
                                                                <th>TIPO</th>
                                                                <th>COMENTARIO</th>
                                                                <th>FECHA DE APARTADO</th>
                                                                <th>SEDE</th>
                                                                <th>CLIENTE</th>
                                                                <th>FECHA DE CREACIÓN</th>
                                                                <th>CREADO POR</th>
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
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/evidencias.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/clientes/addEvidenciaCB.js"></script>
</body>