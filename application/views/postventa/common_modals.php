<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<style>
    .modal-backdrop{
        z-index:9;
    }

</style>

<div class="modal fade" id="modalPausar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b id="labelmodal">Pausar solicitud</b></h4>
            </div>
            
            <form id="formPausar" name="formPausar" method="post">
                <div class="modal-body">
                    <textarea class="text-modal scroll-styles" max="255" type="text" name="comentarioPausa" id="comentarioPausa" autofocus="true" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Motivo de la pausa"></textarea>
                    <b id="text-observations" class="text-danger"></b>
                    <input type="hidden" name="id_solicitud" id="id_solicitud">
                    <input type="hidden" name="idCliente" id="idCliente">
                    <input type="hidden" name="idLote" id="idLote">
                    <input type="hidden" name="accion" id="accion">
                    <input type="hidden" name="id_est" id="id_est">
                    <input type="hidden" name="banderaCliente" id="banderaCliente">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="botonPausar" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--------> 

<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b>Avance de estatus</b></h4>
                <p id="actividad_siguiente"></p>

            </div>            
            <form id="approveForm" name="approveForm" method="post">
                <div class="modal-body">
                    <textarea class="text-modal scroll-styles" max="255" type="text" name="observations" id="observations" autofocus="true" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="Escriba aquí su comentario"></textarea>
                    <b id="text-observations" class="text-danger"></b>
                    <input type="hidden" name="id_solicitud" id="id_solicitud">
                    <input type="hidden" name="type" id="type">
                    <input type="hidden" name="status" id="status">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="ApproveF" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="comentariosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-8 offset-md-3">
                            <p id="titulo_comentarios"></p>
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-plain">
                                            <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"    onclick="cleanCommentsAsimilados()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b>Rechazo de estatus</b></h4>
            </div>
            <form id="rejectForm" name="rejectForm" method="post">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                        <div class="col-lg-12 form-group p-0 m-0" id="rechazo">
                                <label class="label-gral">Área de rechazo</label>
                                <select class="selectpicker select-gral m-0" name="area_rechazo" id="area_rechazo" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select>
                                
                                </div>  
                            <div class="col-lg-12 form-group p-0 m-0">
                                <label class="label-gral">Seleccione el motivo de rechazo <b id="area_selected"></b></label>
                                <select class="selectpicker select-gral m-0" name="motivos_rechazo" id="motivos_rechazo" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select>
                                <input type="hidden" name="id_solicitud2" id="id_solicitud2">
                                <input type="hidden" name="estatus" id="estatus">
                            </div>
                            <div class="col-lg-12 form-group p-0 d-flex justify-end">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btn-simple">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="loadPresupuestos" data-keyboard="false" data-backdrop="static" style="z-index: 99;">
    <div class="modal-dialog modal-md boxContent">
        <div class="modal-content">
            <div class="modal-header text-center">
                <i onclick="RecargarTablePresupuestos()" data-toggle="tooltip" title="Cerrar" data-dismiss="modal" class="fas fa-times fl-r"></i>
                <h4 class="modal-title card-title fw-500 ">Carga de presupuestos</h4><br>
            </div>
            <div class="modal-body text-center toolbar m-0 p-0">
                <input type="text" class="hide" id="idNxS">
                <div class="d-flex direction-row  p-1 gg-1" id="body_uploads">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="uploadModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body text-center">
                <h4 class="card-title" id="mainLabelText"></h4>
                <p id="secondaryLabelDetail"></p>
                <div class="file-gph" id="selectFileSection">
                    <input class="d-none" type="file" name="uploadedDocument" id="uploadedDocument">
                    <input class="file-name" id="file-name" type="text" placeholder="No ha seleccionado nada aún" readonly="">
                    <label class="upload-btn m-0" for="uploadedDocument">
                        <span>Seleccionar</span>
                        <i class="fas fa-folder-open"></i>
                    </label>
                </div>
                <div class="input-group hide" id="rejectReasonsSection">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 pr-0">
                        <select class="selectpicker" data-style="btn btn-primary btn-round" title="Seleccione un motivo de rechazo" data-size="7" id="rejectionReasons" data-live-search="true" multiple required></select>
                    </div>
                </div>
                <input type="text" class="hide" id="idSolicitud">
                <input type="text" class="hide" id="idDocumento">
                <input type="text" class="hide" id="documentType">
                <input type="text" class="hide" id="id_estatus">
                <input type="text" class="hide" id="documento_validar">
                <input type="text" class="hide" id="docName">
                <input type="text" class="hide" id="action">
                <input type="text" class="hide" id="details">
                <input type="text" class="hide" id="presupuestoType">
                <input type="text" class="hide" id="idPresupuesto">
                <input type="text" class="hide" id="idNxS">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="presupuestoModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog boxContent">
        <div class="modal-content card">
            <form class="card-content" id="formPresupuesto" name="formPresupuesto" method="post">
            <input type="hidden" name="id_solicitud3" id="id_solicitud3">
                <div class="modal-body text-center toolbar m-0 p-0">
                    <h3 id="mainLabelText"></h3>
                    <h4 id="encabezado"></h4>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 pr-0 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Nombre Completo</label>
                                    <input id="nombrePresupuesto" name="nombrePresupuesto" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-7 pr-0 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0"><span class="isRequired">*</span> Nombre a quien escritura</label>
                                    <input id="nombrePresupuesto2" name="nombrePresupuesto2" class="form-control input-gral" type="text" required>
                                </div>
                            </div>
                            <div class="col-md-1 pr-0 pr-0">
                                <div class="form-group mr-1 justify-center">
                                    <input type="hidden" id="indexCo" name="indexCo" value="0">
                                    <button class="btn-data btn-green" type="button" id="btnCopropietario" data-toggle="tooltip" data-placement="top" title="Agregar copropietario"><i class="fas fa-user-plus"></i></button>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0"><span class="isRequired">*</span>Valor a escriturar</label>
                                    <input id="valor_escri" name="valor_escri" class="form-control input-gral" type="text" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="aligned-row row" id="copropietarios">
                                </div>
                            </div>  

                            <div class="col-md-12 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0"><span class="isRequired">*</span> Tipo de escrituración</label>
                                    <select class="selectpicker m-0" data-style="btn btn-primary btn-round" data-size="7" id="tipoE" name="tipoE" data-live-search="true" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0"><span class="isRequired">*</span> Estatus de pago</label>
                                    <select class="selectpicker m-0" data-style="btn btn-primary btn-round" data-size="7" id="estatusPago" name="estatusPago" data-live-search="true" required><option value ="default" selected disabled>Seleccione una opción</option></select>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Superficie *</label>
                                    <input id="superficie" name="superficie" class="form-control input-gral" value="" min="0" step="any" type="number" required>
                                </div>
                            </div>    
                            <div class="col-md-4 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Fecha de contrato</label>
                                    <input type="text" class="form-control datepicker input-gral"
                                    id="fContrato" name="fContrato" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0"><span class="isRequired">*</span> Clave catastral</label>
                                    <input id="catastral" name="catastral" value="" class="form-control input-gral" type="text" required>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0"><span class="isRequired">*</span> Estatus construcción</label>
                                    <input id="construccionInfo" name="construccionInfo" value="" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0"><span class="isRequired">*</span> ¿Tenemos cliente anterior?</label>
                                    <select class="selectpicker m-0" data-style="btn btn-primary btn-round"
                                            title="¿Tenemos cliente anterior?" data-size="7" id="cliente" name="cliente"
                                            data-live-search="true" required>
                                            <option value ="default" selected disabled>Seleccione una opción</option>
                                            <option value="uno">Sí</option>
                                            <option value="dos">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- estos input solo se muestran si es si el select anterior -->
                        <div class="row ifClient">
                            <div class="col-md-12 pr-0 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Nombre del titular anterior</label>
                                    <input id="nombreT" name="nombreT" class="form-control input-gral" type="text" >
                                </div>
                            </div>
                            <div class="col-md-6 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Fecha de contrato anterior</label>
                                    <input type="text" class="form-control datepicker" id="fechaCA" name="fechaCA" style="background-color: #eaeaea; background-image:none; border-radius: 27px; text-align: center; color: #929292">
                                </div>
                            </div>
                            <div class="col-md-6 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">RFC / Datos personales</label>
                                    <input id="rfcDatos" name="rfcDatos" class="form-control input-gral" type="text">
                                </div>
                            </div>
                        </div>
                        <!--INFORMACIÓN DE NOTARÍA-->
                        <!----------------------------->
                                <div class="row">
                                    <div class="col-md-12 pr-0" >
                                        <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Tipo de Notaría</label>
                                            <select class="selectpicker m-0" data-style="btn btn-round" title="Tipo de notaría" data-size="7" id="tipoNotaria" name="tipoNotaria" data-live-search="true" required !important>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="1">Interna</option>
                                            <option value="2">Externa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="div_notaria" style="display: none;">
                                    <div class="col-md-6 pr-0 pr-0" id="divnombre_notaria">
                                        <div class="form-group text-left m-0">
                                            <label class="control-label label-gral">Número de la Notaría</label>
                                            <input type="text" id="nombre_notaria" name="nombre_notaria" class="form-control input-gral">
                                        </div>
                                    </div>  
                                    <div class="col-md-6 pr-0 pr-0" id="divnombre_notario">
                                        <div class="form-group text-left m-0">
                                            <label class="control-label label-gral">Nombre del notario</label>
                                            <input type="text" id="nombre_notario" name="nombre_notario" class="form-control input-gral">
                                        </div>
                                    </div>
                                    <div class="col-md-12 pr-0 pr-0" id="divdireccion">
                                        <div class="form-group text-left m-0">
                                            <label class="control-label label-gral">Dirección</label>
                                            <input type="text" id="direccion" name="direccion" class="form-control input-gral">
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0 pr-0" id="divcorreo">
                                        <div class="form-group text-left m-0">
                                            <label class="control-label label-gral">Correo</label>
                                            <input type="email" id="correo" name="correo" class="form-control input-gral">
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0 pr-0" id="divtelefono">
                                        <div class="form-group text-left m-0">
                                            <label class="control-label label-gral">Teléfono</label>
                                            <input type="number" id="telefono" name="telefono" class="form-control input-gral">
                                        </div>
                                    </div>
                                </div>
                        <!----------------------------->
                        <div class="row">
                            <div class="col-md-6 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral">Aportaciones</label>
                                    <input id="aportaciones" name="aportaciones" required class="form-control input-gral" type="text">
                                </div>
                            </div>
                            <div class="col-md-6 pr-0">
                                    <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Descuentos</label>
                                    <input id="descuentos" name="descuentos" required class="form-control input-gral" type="text">
                                    </div>
                            </div>
                            <div class="col-md-12 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Motivo</label>
                                    <textarea id="motivo" name="motivo" class="text-modal"></textarea>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-12 d-flex justify-end p-0">
                                <button type="button" class="btn btn-danger btn-simple mt-2" onclick="clearCopropietario();" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="RequestPresupuesto" class="btn btn-primary mt-2">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="checkPresupuestoModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog boxContent">
        <div class="modal-content card">
            <form class="card-content" id="formPresupuesto" name="formPresupuesto" method="post">
            <input type="hidden" name="id_solicitud3" id="id_solicitud3">
                <div class="modal-body text-center toolbar m-0 p-0">
                    <h5 id="mainLabelText"></h5>
                    <h4 id="secondaryLabelDetail">Desarrollo / Condominio / Lote</h4>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 pr-0 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">Nombre Completo</label>
                                    <input id="nombrePresupuesto3" name="nombrePresupuesto3" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 pr-0 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">Nombre a quien escritura</label>
                                    <input id="nombrePresupuesto4" name="nombrePresupuesto4" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 pr-0 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">Valor a escriturar</label>
                                    <input id="valor_escri4" name="valor_escri4" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">Estatus de pago</label>
                                    <input id="estatusPago2" name="estatusPago2" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">Superficie</label>
                                    <input id="superficie2" name="superficie2" class="form-control input-gral" step="any" value="" type="number" disabled>
                                </div>
                            </div>    
                            <div class="col-md-4 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">Fecha de contrato</label>
                                    <input type="text" class="form-control datepicker input-gral"
                                    id="fContrato2" name="fContrato2" disabled/>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">Clave catastral</label>
                                    <input id="catastral2" name="catastral2" value="" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">Estatus construcción</label>
                                    <input id="construccion2" name="construccion2" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label label-gral">¿Tenemos cliente anterior?</label>
                                    <select class="selectpicker" data-style="btn btn-primary btn-round"
                                            title="¿Tenemos cliente anterior?" data-size="7" id="cliente2" name="cliente2"
                                            data-live-search="true" disabled>
                                            <option value ="default" selected disabled>Seleccione una opción</option>
                                            <option value="uno">Sí</option>
                                            <option value="dos">No</option>
                                    </select>
                                </div>
                            </div>
                            <!-- estos input solo se muestran si es si el select anterior -->
                            <div id="ifClient2" style="display:none">
                                <div class="col-md-12 pr-0 pr-0">
                                    <div class="form-group label-floating is-focused">
                                        <label class="control-label label-gral">Nombre del titular anterior</label>
                                        <input id="nombreT2" name="nombreT2" class="form-control input-gral" type="text" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <div class="form-group label-floating is-focused">
                                        <label class="control-label label-gral">Fecha del contrato anterior</label>
                                        <input type="text" class="form-control datepicker"
                                        id="fechaCA2" name="fechaCA2" disabled/>
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <div class="form-group label-floating is-focused">
                                        <label class="control-label label-gral">RFC / Datos personales</label>
                                        <input id="rfcDatos2" name="rfcDatos2" value="N/A" class="form-control input-gral" type="text" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-end p-0">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="documentTree" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body text-center">
                <h5 id="mainLabelText"></h5>
                <p style="font-size: 0.8em"></p>
                
                <div class="input-group" >
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 pr-0">
                        <select class="selectpicker" data-style="btn btn-primary btn-round"
                            title="Seleccione un documento a subir" data-size="7" id="documents"
                            data-live-search="true"></select>
                    </div>
                </div>
                <div class="input-group hide" id="documentsSection">
                    <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            Seleccionar archivo&hellip;<input type="file" name="uploadedDocument2" id="uploadedDocument2" style="display: none;">
                        </span>
                    </label>
                    <input type="text" class="form-control" id="txtexp" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="button" id="sendRequestButton2" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notarias" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
            <h5 class="text-center m-0">Seleccione Notaría/Valuador</h5>
            </div>
            <div class="modal-body ">
                
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6" >
                            <select class="selectpicker" data-style="btn btn-primary btn-round"
                                title="Seleccione una Notaría" data-size="7" id="notaria"
                                data-live-search="true"></select>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6" >
                            <select class="selectpicker" data-style="btn btn-primary btn-round"
                                title="Seleccione un valuador" data-size="7" id="valuador"
                                data-live-search="true"></select>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6"><div id="information"></div></div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6"><div id="information2"></div></div>
                </div>
                <input type="text" class="hide" id="idSolicitud">
                <input type="text" class="hide" id="action">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="button" id="notariaSubmit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dateModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog boxContent">
        <div class="modal-content card">
            <div class="modal-header"></div>
            <div class="modal-body text-center card-content">
                <h5 id="mainLabelText">Fecha para firma de escrituras</h5>
                <div class="toolbar" >
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 pr-0">
                                <input type="text" class="form-control datepicker2 input-gral" id="signDate" value="" />
                                <p>*(fecha sugerida para firma de escrituras)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="text" class="hide" id="idSolicitudFecha">
                <input type="text" class="hide" id="type">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="button" id="dateSubmit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="altaNotario" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 id="mainLabelText">Nueva Notaría</h5></div>
            <div class="modal-body text-center">
               <form id="newNotario" name="newNotario" method="post">
                    <input type="text" class="hide" id="idSolicitud" name="idSolicitud">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 pr-0 pr-0">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Número de la Notaría</label>
                                        <input type="text" id="nombre_notaria" name="nombre_notaria" class="form-control input-gral" required>
                                    </div>
                                </div>
                                <div class="col-md-4 pr-0 pr-0">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Nombre del notario</label>
                                        <input type="text" id="nombre_notario" name="nombre_notario" class="form-control input-gral" required>
                                    </div>
                                </div>
                                <div class="col-md-4 pr-0 pr-0">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Dirección</label>
                                        <input type="text" id="direccion" name="direccion" class="form-control input-gral" required>
                                    </div>
                                </div>
                                <div class="col-md-4 pr-0 pr-0">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Correo</label>
                                        <input type="email" id="correo" name="correo" class="form-control input-gral" required>
                                    </div>
                                </div>
                                <div class="col-md-4 pr-0 pr-0">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Teléfono</label>
                                        <input type="text" id="telefono" name="telefono" class="form-control input-gral" required>
                                    </div>
                                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
<!--<div class="modal fade" id="altaNotario" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b>Asignación de notaría</b></h4>
                <i id="informacion_lote"></i>

            </div>
            <div class="modal-body text-center">
               <form id="asignarNotaria" name="asignarNotaria" method="post">
               <input type="hidden" class="hide" id="id_solicitud" name="id_solicitud">
               <input type="hidden" class="hide" id="tipo_notaria" name="tipo_notaria">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">

                           <div class="col-md-12 pr-0" >
                                    <div class="form-group text-left m-0">
                                    <label class="control-label label-gral">Tipo de Notaría</label>
                                        <select class="selectpicker m-0" data-style="btn btn-round" title="Tipo de notaría" data-size="7" id="tipoNotaria" name="tipoNotaria" data-live-search="true" required !important>
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="1">Interna</option>
                                        <option value="2">Externa</option>
                                        </select>
                                    </div>
                                </div>
 
                                <div class="col-md-6 pr-0 pr-0" id="divnombre_notaria">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Nombre de la Notaría</label>
                                        <input type="text" id="nombre_notaria" name="nombre_notaria" class="form-control input-gral">
                                    </div>
                                </div>  
                                <div class="col-md-6 pr-0 pr-0" id="divnombre_notario">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Nombre del notario</label>
                                        <input type="text" id="nombre_notario" name="nombre_notario" class="form-control input-gral">
                                    </div>
                                </div>
                                <div class="col-md-12 pr-0 pr-0" id="divdireccion">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Dirección</label>
                                        <input type="text" id="direccion" name="direccion" class="form-control input-gral">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0 pr-0" id="divcorreo">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Correo</label>
                                        <input type="email" id="correo" name="correo" class="form-control input-gral">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0 pr-0" id="divtelefono">
                                    <div class="form-group text-left m-0">
                                        <label class="control-label label-gral">Teléfono</label>
                                        <input type="number" id="telefono" name="telefono" class="form-control input-gral">
                                    </div>
                                </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-simple">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div>
                </form> 
            </div>
        </div>
    </div>
</div>-->

<div class="modal fade" id="gestionNotaria" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><h5 id="mainLabelText"><center><b>Información Notaría</b></center></h5></div>
            <div class="modal-body text-center">
               <form method="post" id="rechazar" name="rechazar">
                    <input type="text" class="hide" id="idSolicitud" name="idSolicitud">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label label-gral">Número de la Notaría</label>
                                <input type="text" id="nombreNotaria" name="nombreNotaria" class="form-control input-gral" value="" style="text-align:center" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label label-gral">Nombre del notario</label>
                                <input type="text" id="nombreNotario" name="nombre_notario" class="form-control input-gral" value="" style="text-align:center" disabled>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label label-gral">Correo</label>
                                <input type="text" id="correoN" name="correo" class="form-control input-gral" value="" style="text-align:center" disabled>
                            </div>
                        </div>    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label label-gral">Teléfono</label>
                                <input type="text" id="telefonoN" name="telefono" class="form-control input-gral" value="" style="text-align:center" disabled>
                            </div>
                        </div>      
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label label-gral">Dirección</label>
                                <input type="text" id="direccionN" name="direccion" class="form-control input-gral" value="" style="text-align:center" disabled>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-end p-0">
                        <button type="button" class="btn btn-danger btn-simple mt-2" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                   
                </form> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewObservaciones" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-center m-0">Envío de Observaciones</h5>
            </div>
            <form method="post" name="observacionesForm" id="observacionesForm">
                <input type="text" class="hide" id="idSolicitud" name="idSolicitud">
                <input type="text" class="hide" id="action" name="action">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <select id="pertenece" name="pertenece" class="selectpicker select-gral m-0 pb-1" data-style="btn" data-show-subtext="true" data-live-search="true" title="¿Para quién es la observación?" data-size="7" required>
                                <option value="Postventa">Postventa</option>
                                <option value="Proyectos">Proyectos</option>
                            </select>
                        </div>      
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            <select id="observacionesS" name="observacionesS" class="selectpicker select-gral m-0 pb-2" data-style="btn" data-show-subtext="true" data-live-search="true" title="Observaciones" data-size="7" required>
                                <option value="Corrección Documentos">Corrección documentos</option>
                                <option value="Documentación Correcta">Documentación correcta</option>
                            </select>
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


<!--<div class="modal fade" id="estatusLModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b>Estatus de construcción</b></h4>
                <i id="actividad_siguiente"></i>

            </div>

            
            <form id="approveForm" name="approveForm" method="post">
                <div class="modal-body">
                <div class="col-md-12 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Selecciona un estatus</label>
                                    <select class="form-control m-0" data-style="btn btn-primary btn-round"
                                            title="Estatus construcción" data-size="7" id="construccion" name="construccion"
                                         required>
                                    </select>
                                </div>
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="requestEstatusLote" class="btn btn-success btn-simple">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>--->


<div class="modal fade" id="estatusLModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b>Asignar estatus de Construcción</b></h4>
                <p id="informacion_lote_construccion"></p>
            </div>
            <form id="formEstatusLote" name="formEstatusLote" method="post">
                <input type="hidden" name="id_solicitudEstatus" id="id_solicitudEstatus">
                <div class="modal-body">
                    <select class="form-control select-const select-gral m-0" title="Estatus construcción" id="construccion" name="construccion" required>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="requestEstatusLote" class="btn btn-success btn-simple">Aceptar</button>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="valorOperModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b>Modificar valor de operación de contrato</b></h4>
            </div>
            <form id="formValorOperacion" name="formValorOperacion" method="post">
                <input type="hidden" name="id_solicitudOper" id="id_solicitudOper">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label label-gral">Valor de operación</label>
                        <input type="text" id="valorOper" name="valorOper" class="form-control input-gral">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="requestOper" class="btn btn-success btn-simple">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalInfoClient" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b>Información del cliente</b></h4>
            </div>
                <div class="modal-body" id="modalContent">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                </div>
        </div>
    </div>
</div>


<!-- <div class="modal fade" id="estatusLModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog boxContent">
        <div class="modal-content card">
            <form class="card-content" id="formEstatusLote" name="formEstatusLote" method="post">
                <input type="hidden" name="id_solicitudEstatus" id="id_solicitudEstatus">
                <div class="modal-body text-center toolbar m-0 p-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral m-0">Estatus construcción</label>
                                    <select class="form-control m-0" data-style="btn btn-primary btn-round"
                                            title="Estatus construcción" data-size="7" id="construccion" name="construccion"
                                         required>
                                    </select>
                                </div>ASAS
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-end p-0">
                                <button type="button" class="btn btn-danger btn-simple mt-2" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="requestEstatusLote" class="btn btn-primary mt-2">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> -->

 
<div class="modal fade" id="informacionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title card-title"><b>Información de cliente</b></h4>
                <p id="actividad_siguiente"></p>
            </div>

            <form class="card-content" id="formInformacion" name="formInformacion" method="POST">
                <input type="hidden" name="idSolicitud" id="idSolicitud">
                <div class="modal-body pt-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral">¿Lote liquidado? (<small style="color: red;">*</small>)</label>
                                    <select class="selectpicker select-gral m-0" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" id="liquidado" name="liquidado" data-live-search="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral">Estatus construcción (<small style="color: red;">*</small>)</label>
                                    <input id="construccionI" name="construccionI" class="form-control input-gral" type="text" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 pr-0">
                                <div class="form-group text-left m-0">
                                    <label class="control-label label-gral">¿Tenemos cliente anterior? (<small style="color: red;">*</small>)</label>
                                    <select class="selectpicker select-gral" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" id="clienteI" name="clienteI" data-live-search="true">
                                        <option value="uno">Sí</option>
                                        <option value="dos">No</option>
                                    </select>
                                </div>
                            </div>
                            <!-- estos input solo se muestran si es si el select anterior -->
                            <div id="ifInformacion">
                                <div class="col-md-12 pr-0">
                                    <div class="form-group m-0 m-0">
                                        <label class="control-label label-gral">Tipo contrato anterior (<small style="color: red;">*</small>)</label>
                                        <select class="selectpicker select-gral" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" id="tipoContratoAnt" name="tipoContratoAnt">
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-12 pr-0">
                                    <div class="form-group m-0 m-0">
                                        <label class="control-label label-gral">Nombre del titular anterior (<small style="color: red;">*</small>)</label>
                                        <input id="nombreI" name="nombreI"  class="form-control input-gral" type="text" >
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <div class="form-group m-0">
                                        <label class="control-label label-gral btn-round">Fecha del contrato anterior (<small style="color: red;">*</small>)</label>
                                        <input type="text" class="form-control input-gral datepicker" id="fechaCAI" name="fechaCAI" >
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <div class="form-group m-0">
                                        <label class="control-label label-gral">RFC / Datos personales (<small style="color: red;">*</small>)</label>
                                        <input id="rfcDatosI" name="rfcDatosI" class="form-control input-gral" type="text" onKeyPress="if(this.value.length==13) return false;" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="col-md-6 pr-0">
                                    <div class="form-group m-0 is-focused">
                                        <label class="control-label label-gral">Aportaciones (<small style="color: red;">*</small>)</label>
                                        <input id="aportacionesI" name="aportaciones" data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" required class="form-control input-gral" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-0">
                                      <div class="form-group m-0 is-focused">
                                        <label class="control-label label-gral">Descuentos (<small style="color: red;">*</small>)</label>
                                        <input id="descuentosI" name="descuentos" data-type="currency" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" required class="form-control input-gral" type="text">
                                      </div>
                                </div>
                                <div class="col-md-12 pr-0">
                                    <label class="control-label label-gral">Motivo (<small style="color: red;">*</small>)</label>
                                    <textarea id="motivoI" name="motivo" class="text-modal" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="RequestInformacion" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="loadPresupuestos" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md boxContent">
        <div class="modal-content">
            <div class="modal-header text-center">
                <i data-dismiss="modal" class="fas fa-times fl-r"></i>
                <h4 class="modal-title card-title fw-500 ">CARGA DE PRESUPUESTOS</h4>
            </div>
            <div class="modal-body text-center toolbar m-0 p-0">
                <input type="text" class="hide" id="idNxS">
                <div class="d-flex direction-row  p-1 gg-1" id="body_uploads">
                </div>
            </div>
        </div>
    </div>
</div>

 






<!-- inicio de modal -->

<div class="modal fade" id="documentTreeAr" data-keyboard="false" data-backdrop="static" style="z-index:  99;">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">

                        </div>
                        <div class="modal-body text-center"  id='subir_documento' name='subir_documento'>

                        </div>
                        <div class="modal-footer">
                            <div  class="col-4 col-sm-4 col-md-4 col-lg-4 " id="mandarSolicitud" name="mandarSolicitud" >
                                
                            <button type="button" class="btn btn-blueMaderas  btn-simple" data-dismiss="modal">ENVIAR</button>
                            </div>
                            <button type="button" class="btn btn-danger btn-simple" id="botonCancelarDoc" name="botonCancelarDoc">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
<!-- fin modal -->   
<!-- fin modal -->   
<div class="modal fade" tabindex="-1"  id="documentosRevisar" name="documentosRevisar" data-keyboard="false" data-backdrop="static" style="z-index:  99;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                <h3 class="text-center">Validacion de documentos</h3>
                    
                </div>
                    <div class="modal-body" id='documentos_revisar' name='documentos_revisar'>
                    
                    </div>
                <div class="modal-footer "  id='cerrarModal' name='cerrarModal'>
                <button type="button" id="CancelarRevisarDocs" name="CancelarRevisarDocs" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                      
                </div>
                </div>
            </div>
            </div>     
          
<!-- fin modal -->






