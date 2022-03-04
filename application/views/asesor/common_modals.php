<div class="modal fade" id="modalEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cleanSelects()">
                    <i class="material-icons">clear</i>
                </button>
                <button type="button" class="close" aria-hidden="true" onclick="deleteCita()">
                    <i class="material-icons">delete</i>
                </button>
                <h4 class="modal-title">Detalles de la cita:</h4>
            </div>
            <form id="edit_appointment_form" name="edit_appointment_form" method="post">
                <div class="col-lg-12 form-group">
                    <label>Titulo</label>
                    <input id="evtTitle2" name="evtTitle" type="text" class="form-control">
                </div>
                <div class="col-lg-12 form-group" id="select">
                    <label>Tipo de cita</label>
                    <select class="selectpicker" name="estatus_recordatorio2" id="estatus_recordatorio2" data-style="select-with-transition" title="Seleccione una opción" data-size="7" <!--onchange="validateParticularStatus(this)"-->></select>
                </div>
                <div class="col-lg-12 form-group" id="comodinDIV2">
                </div>
                <div class="col-lg-6 form-group">
                    <label>Inicio</label>
                    <input id="dateStart2" name="dateStart" type="datetime-local" class="form-control">
                </div> 
                <div class="col-lg-6 form-group">
                    <label>Final</label>
                    <input id="dateEnd2" name="dateEnd" type="datetime-local" class="form-control" disabled>
                </div>
                <div class="col-lg-12 form-group">
                    <label>Descripción</label>
                    <textarea class="form-control" type="text" name="description" id="description2" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                </div>

                <input type="hidden" name="idAgenda" id="idAgenda2">

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="finishS">Aceptar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanSelects()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
