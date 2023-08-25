<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>

<div class="modal fade" id="modalEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-center mb-1">
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 form-group m-0 pr-0">
                    <i class="fas fa-circle dotStatusAppointment"></i>
                </div>
                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0 pr-0 d-flex justify-between align-center">
                    <h3 class="modal-title">Detalles de la cita</h3>
                    <?php if ($this->session->userdata('id_rol') != '2' && $this->session->userdata('id_rol') != '3') { ?>
                    <div class="dropdown">
                        <button class="" type="button" id="menuModal" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent; border:none; color: #999"><i class="fas fa-ellipsis-v"></i></button>
                        <ul class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="menuModal">
                            <li><a class="m-0" onclick="finalizarCita()">Finalizar evento</a></li>
                            <li><a class="m-0" onclick="confirmDelete()">Eliminar evento</a></li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-body pt-0">
                <form id="edit_appointment_form" name="edit_appointment_form" method="post">
                    <div class="container-fluid p-0">
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-font iconMod fa-lg"></i>
                        </div>
                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Título</label>
                            <input id="evtTitle2" name="evtTitle" type="text" class="form-control input-gral">
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-user iconMod fa-lg"></i>
                        </div>
                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0 overflow-hidden">
                            <label class="label-gral m-0">Prospecto</label>
                            <input id="textProspecto" name="textProspecto" type="text" class="form-control input-gral" disabled>
                            <input id="prospectoE" name="prospectoE" type="text" class="form-control input-gral d-none">
                        </div>
                        <div id="organizadorDiv">
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 form-group m-0 pr-0">
                                <i class="fas fa-user iconMod fa-lg"></i>
                            </div>
                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0 overflow-hidden">
                                <label class="label-gral m-0">Organizador</label>
                                <input id="organizador" name="organizador" type="text" class="form-control input-gral" disabled>
                            </div>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-pencil-alt iconMod fa-lg"></i>
                        </div>
                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Tipo de cita</label>
                            <select class="selectpicker select-gral m-0" name="estatus_recordatorio2" id="estatus_recordatorio2" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 form-group m-0 pr-0">
                        </div>
                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0 hide" id="comodinDIV2">
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-clock iconMod fa-lg"></i>
                        </div>
                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Fecha de cita</label>
                            <div class="d-flex">
                                <input id="dateStart2" name="dateStart" type="datetime-local" class="form-control beginDate w-50 text-left pl-1">
                                <input id="dateEnd2" name="dateEnd" type="datetime-local" class="form-control endDate w-50 pr-1">
                            </div>
                        </div>
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-align-left iconMod fa-lg"></i>
                        </div>
                        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Descripción</label>
                            <textarea class="text-modal" class="form-control" type="text" name="description" id="description2" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>

                        <input type="hidden" name="idAgenda" class="idAgenda2">
                        <input type="hidden" name="idGoogle" class="idGoogle">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary finishS">Guardar</button>
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade scroll-styles" id="agendaInsert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center">Detalles de la cita</h3>
            </div>
            <div class="modal-body">
                <form id="insert_appointment_form" name="estatus_recordatorio_form" method="post">
                    <div class="container-fluid p-0">
                        <div class="col-lg-12 form-group m-0">
                            <label class="label-gral m-0">Título</label>
                            <input id="evtTitle" name="evtTitle" type="text" class="form-control input-gral" required>
                        </div>
                        <div class="col-lg-12 form-group m-0 overflow-hidden">
                            <label class="label-gral m-0">Prospectos</label>
                            <select class="selectpicker select-gral m-0" name="prospecto" id="prospecto" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un prospecto" data-size="7" data-container="body" required></select>
                        </div>
                        <div class="col-lg-12 form-group m-0 d-none" id="select_recordatorio">
                            <label class="label-gral m-0">Tipo de cita</label>
                            <select class="selectpicker select-gral m-0 " name="estatus_recordatorio" id="estatus_recordatorio" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select>
                        </div>
                        <div class="col-lg-12 form-group m-0 hide" id="comodinDIV"></div>
                        
                        <div class="col-lg-12 form-group m-0">
                            <label class="label-gral m-0">Fecha de cita</label>
                            <div class="d-flex">
                                <input id="dateStart" name="dateStart" type="datetime-local" class="form-control beginDate w-50 text-left pl-1">
                                <input id="dateEnd" name="dateEnd" type="datetime-local" class="form-control endDate w-50 pr-1">
                            </div>
                        </div>
                        <div class="col-lg-12 form-group m-0">
                            <label class="label-gral m-0">Descripción</label>
                            <textarea class="text-modal" type="text" name="description" id="description" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary finishS">Aceptar</button>
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sidebarView" tabindex="-1" role="dialog" aria-labelldby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-header mb-1 d-flex justify-between">
            <h3 class="modal-title">Detalles de la cita</h3>
        </div>
        <div class="modal-body">
            <div class="container-fluid p-0">
                <div class="col-lg-1 form-group m-0 pr-0">
                    <i class="fas fa-font iconMod fa-lg"></i>
                </div>
                <div class="col-lg-11 form-group m-0">
                    <label class="label-gral">Título</label>
                    <input id="evtTitle2" name="evtTitle" type="text" class="form-control input-gral" disabled>
                </div>
                <div class="col-lg-1 form-group m-0 pr-0">
                    <i class="fas fa-user iconMod fa-lg"></i>
                </div>
                <div class="col-lg-11 form-group m-0 overflow-hidden">
                    <label class="label-gral">Prospectos</label>
                    <select class="selectpicker select-gral m-0" id="prospectoE" name="prospectoE" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un prospecto" data-size="7" data-container="body" disabled></select>
                </div>
                <div class="col-lg-1 form-group m-0 pr-0">
                    <i class="fas fa-pencil-alt iconMod fa-lg"></i>
                </div>
                <div class="col-lg-11 form-group m-0">
                    <label class="label-gral">Tipo de cita</label>
                    <select class="selectpicker select-gral m-0" id="prospectoE" name="prospectoE" data-style="btn" data-show-subtext="true" data-live-search="true" tutle="Seleccione una opción" data-size="7" disabled></select>
                </div>
                <div class="col-lg-1 form-group m-0 pr-0">
                </div>
                <div class="col-lg-11 form-group m-0 comodinDIV2 hide"></div>
                <div class="col-lg-1 form-group m-0 pr-0">
                    <i class="fas fa-clock iconMod fa-lg"></i>
                </div>
                <div class="col-lg-11 form-group m-0">
                    <label class="label-gral">Fecha de cita</label>
                    <div class="d-flex">
                        <input id="dateStart2" name="dateStart" type="datetime-local" class="form-control beginData w-50 text-left pl-1" disabled>
                        <input id="dateEnd2" name="dateEnd" type="datetime-local" class="form-control endData w-50 pl-1" disabled>
                    </div>
                </div>
                <div class="col-lg-1 form-group m-0 pr-0">
                    <i class="fas fa-align-left iconMod fa-lg"></i>
                </div>
                <div class="col-lg-11 form-group m-0">
                    <label class="label-gral">Descripción</label>
                    <textarea class="text-modal" class="form-control" type="text" name="description" id="description2" onkeyup="javascript:this.value=this.value.toUpperCase();" disables></textarea>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary finishS">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form id="feedback_form" name="feedback_form" method="post">
                <div class="modal-content">                    
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title text-center"><b>Evalúa este evento</b></h3>
                        <p class="text-center">¿Cómo valorarías este evento?</p>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="radio-with-Icon pl-1 pr-1 pb-3 pt-3 d-flex justify-between">
                            <p class="radioOption-Item">
                                <input type="radio" name="rate" id="rateBad" value="2" class="d-none" aria-invalid="false">
                                <label for="rateBad" class="cursor-point">
                                    <i class="far fa-thumbs-down fa-3x"></i>
                                </label>
                            </p>
                            <p class="radioOption-Item">
                                <input type="radio" name="rate" id="rateGood" value="1" class="d-none" aria-invalid="false" checked>
                                <label for="rateGood" class="cursor-point">
                                    <i class="far fa-thumbs-up fa-3x"></i>
                                </label>
                            </p>
                            <p class="radioOption-Item">
                                <input type="radio" name="rate" id="rateCancel" value="3" class="d-none" aria-invalid="false">
                                <label for="rateCancel" class="cursor-point">
                                    <i class="fas fa-ban fa-3x"></i>
                                </label>
                            </p>
                        </div>
                        <p class="text-center">Agrega tus comentarios u observaciones adicionales a este evento.</p>
                        <textarea class="text-modal" class="form-control" type="text" name="observaciones" id="observaciones" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                        <div class="d-flex justify-end">
                            <button type="button" class="btn btn-danger btn-simple" onclick="backToEvent()" style="background-color:white;">Regresar</button>
                            <button type="submit" class="btn btn-primary no-shadow rounded-circle finishS">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="allAppointmentsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">                    
                <div class="modal-header pb-2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <div class="material-datatables">
                        <form name="appointmentsForm" id="appointmentsForm" method="post">
                            <table id="appointments-datatable" class="table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Evento</th>
                                        <th>Nombre</th>
                                        <th class="text-center">Estatus&nbsp;&nbsp;&nbsp;<i class="fas fa-info-circle" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Positivo.<br/>Se identifica como estatus positivo a: la cita, llamada o recorrido con un prospecto, el cual sigue interesado y se encuentra más cerca del cierre de la venta.<br/><br/>Negativo.<br/>Se identifica como estatus negativo a: la cita, llamada o recorrido con un prospecto, el cual NO sigue interesado y No desea seguimiento para concretar la compra."></i></th>
                                        <th class="text-center">Comentarios</th>
                                        <th class="text-center">Fecha de cita</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="d-flex justify-end">
                                <button type="submit" class="btn btn-primary no-shadow rounded-circle finishS">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteEvt" tabindex="-1" role="dialog" aria-labelldby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body pt-2">
                    <div class="material-datatables">
                        <form name="" id="" method="post">
                            <div>
                                <h3 class="m-0 text-center">Eliminar evento</h3>
                                <p class="text-center">Estás a punto de remover el evento seleccionado ¿Deseas continuar?</p>
                                <input type="hidden" name="idAgenda" class="idAgenda2">
                                <input type="hidden" name="idGoogle" class="idGoogle">
                            </div>
                            <div class="d-flex justify-end">
                                <button type="button" class="btn btn-danger btn-simple" onclick="backFromDelete()" style="background-color:white;">Regresar</button>
                                <button type="button" class="btn btn-primary no-shadow rounded-circle" onclick="deleteCita()">Confirmar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="signInGoogleModal" tabindex="-1" role="dialog" aria-labelledby="signInGoogleModal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body pt-2">
                <div class="material-datatables">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="m-0 text-center">Iniciar sesión con Google</h3>
                            <p class="text-center mt-2">
                                Para que el calendario se sincronice con Google Calendar, es necesario iniciar sesión con su cuenta de Google
                            </p>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex justify-end">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="signInGoogleButton" class="btn btn-primary">Iniciar sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
