<link href="<?= base_url() ?>dist/css/sideCalendar.css" rel="stylesheet"/>

<div id="sideCalendar" class="t-0 r-0 l-auto h-100 z-1030 side-calendar scroll-styles" data-active-color="blue" data-background-color="white" data-image="<?=base_url()?>/dist/img/sidebar-1.jpg" style="display:none;">
    <div class="d-flex justify-end">
        <a id="minimizeSidecalendar" class="closeCalendar">
            <i class="fas fa-times"></i>
        </a>
    </div>
      <div class="container-fluid p-0">	<div id="side-calendar"></div>
</div>
</div>

<div class="modal fade" id="modalEventConsulta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-center mb-1">
                <div class="col-lg-1 form-group m-0 pr-0">
                    <i class="fas fa-circle dotStatusAppointment"></i>
                </div>
                <div class="col-lg-11 form-group m-0 pr-0 d-flex justify-between align-center">
                    <h3 class="modal-title">Detalles de la cita</h3>
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
                            <input id="evtTitle3" name="evtTitle" type="text" class="form-control input-gral" disabled>
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-user iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0 overflow-hidden">
                            <label class="label-gral m-0">Prospectos</label>
                            <select class="selectpicker select-gral m-0" id="prospectoE2" name="prospectoE" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un prospecto" data-size="7" data-container="body" disabled></select>
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-pencil-alt iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Tipo de cita</label>
                            <select class="selectpicker select-gral m-0" id="estatus_recordatorio3" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required disabled></select>
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                        </div>
                        <div class="col-lg-11 form-group m-0 hide" id="comodinDIV3" disabled></div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-clock iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Fecha de cita</label>
                            <div class="d-flex">
                                <input id="dateStart3" name="dateStart" type="datetime-local" class="form-control beginDate w-50 text-left pl-1" disabled>
                                <input id="dateEnd3" name="dateEnd" type="datetime-local" class="form-control endDate w-50 pr-1" disabled>
                            </div>
                        </div>
                        <div class="col-lg-1 form-group m-0 pr-0">
                            <i class="fas fa-align-left iconMod fa-lg"></i>
                        </div>
                        <div class="col-lg-11 form-group m-0">
                            <label class="label-gral m-0">Descripción</label>
                            <textarea class="text-modal" class="form-control" type="text" name="description" id="description3" onkeyup="javascript:this.value=this.value.toUpperCase();" disabled></textarea>
                        </div>

                        <input type="hidden" name="idAgenda" id="idAgenda3">
						<div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    userType = <?= $this->session->userdata('id_rol') ?> ;
    idUser = <?= $this->session->userdata('id_usuario') ?> ;
    typeTransaction = 1;
    base_url = "<?=base_url()?>";
</script>
<!-- <script src="<?=base_url()?>dist/js/controllers/dashboard/agenda/general_calendar.js"></script> -->