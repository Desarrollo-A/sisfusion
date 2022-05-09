<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<div class="modal fade" id="modalEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-center mb-1">
                <div class="col-lg-1 form-group m-0 pr-0">
                    <i class="fas fa-circle dotStatusAppointment"></i>
                </div>
                <div class="col-lg-11 form-group m-0 pr-0 d-flex justify-between align-center">
                    <h3 class="modal-title">Detalles de la cita</h3>
                    <?php if ($this->session->userdata('id_rol') != '2' && $this->session->userdata('id_rol') != '3') { ?>
                    <div class="dropdown">
                        <button class="" type="button" id="menuModal" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent; border:none; color: #999"><i class="fas fa-ellipsis-v"></i></button>
                        <ul class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="menuModal">
                            <li><a class="m-0" onclick="finalizarCita()">Finalizar evento</a></li>
                            <li><a class="m-0" onclick="deleteCita()">Eliminar evento</a></li>
                            <li><a class="m-0" data-dismiss="modal" style="border-top: 1px solid #eaeaea;">Cerrar ventana</a></li>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-body pt-0">
                <form id="edit_appointment_form" name="edit_appointment_form" method="post">
                    <div class="container-fluid p-0">
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-font iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Titulo</label>
                            <input id="evtTitle2" name="evtTitle" type="text" class="form-control input-gral">
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-user iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0 overflow-hidden">
                            <label class="label-gral m-0">Prospecto</label>
                            <input id="textProspecto" name="textProspecto" type="text" class="form-control input-gral" disabled>
                            <input id="prospectoE" name="prospectoE" type="text" class="form-control input-gral d-none">
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-pencil-alt iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Tipo de cita</label>
                            <select class="selectpicker select-gral m-0" name="estatus_recordatorio2" id="estatus_recordatorio2" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select>
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                        </div>
                        <div class="col-lg-11 form-group m-0 hide" id="comodinDIV2">
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-clock iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Fecha de cita</label>
                            <div class="d-flex">
                                <input id="dateStart2" name="dateStart" type="datetime-local" class="form-control beginDate w-50 text-left pl-1">
                                <input id="dateEnd2" name="dateEnd" type="datetime-local" class="form-control endDate w-50 pr-1">
                            </div>
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-align-left iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Descripción</label>
                            <textarea class="text-modal" class="form-control" type="text" name="description" id="description2" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>

                        <input type="hidden" name="idAgenda" id="idAgenda2">
                        <input type="hidden" name="idGoogle" id="idGoogle">

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
                            <label class="label-gral m-0">Titulo</label>
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
                    <label class="label-gral">Titulo</label>
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

                <input type="hidden" name="idAgenda" id="idAgenda2">

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary finishS">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
