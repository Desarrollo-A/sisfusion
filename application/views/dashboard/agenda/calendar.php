<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<!-- <link href="<?= base_url() ?>dist/css/calendar.css" rel="stylesheet"/> -->
    <style>
        .hide_column {
            display : none!important;
        }
    </style>

    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form id="feedback_form" name="feedback_form" method="post">
                <div class="modal-content">                    
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title text-center"><b>Evalua este evento</b></h3>
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
                                        <th class="text-center">Estatus&nbsp;&nbsp;&nbsp;<i class="fas fa-info-circle" data-html="true" data-toggle="tooltip" data-placement="bottom" title="Positivo.<br/>Se identifica como estatus positivo a la cita, llamada o recorrido con un cliente el cual sigue interesado y está un paso más cerca del cliente.<br/><br/>Negativo.<br/> Se identifica como estatus negativo a la cita, llama o recorrido con un prospecto con un prospecto el cual NO sigue sigue interesaso y no desea seguimiento para concretar su compra."></i></th>
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

    <div class="card">
        <div class="card-content">
            <div class="container-fluid">
                <div class="row mb-2">
                <!-- Subdirector -->
                <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden pl-0">
                        <label class="label-gral">Gerente</label>
                        <select class="selectpicker select-gral m-0" id="gerente" name="gerente" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un gerente" data-size="7" data-container="body"></select>
                    </div>
                <?php } ?>
                <!-- Subdirector y Gerente -->
                <?php if( $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 3 ) { ?>
                    <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden">
                    <?php } else  { ?> 
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden pl-0">
                    <?php } ?>
                        <label class="label-gral">Coordinador</label>
                        <select class="selectpicker select-gral m-0" id="coordinador" name="coordinador" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un coordinador" data-size="7" data-container="body"></select>
                    </div>
                    <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden pr-0">
                    <?php } else  { ?> 
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden pr-0">
                    <?php } ?>
                        <label class="label-gral">Asesor</label>
                        <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un asesor" data-size="7" data-container="body"></select>
                    </div>
                <?php } ?>
                <!-- Coordinador -->
                <?php if( $this->session->userdata('id_rol') == 9 ) { ?>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden p-0 mb-1">
                        <label class="label-gral">Asesor</label>
                        <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un asesor" data-size="7" data-container="body"></select>
                    </div>
                <?php } ?>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
    <?php include 'common_modals.php' ?>
    <script src="<?= base_url() ?>dist/assets/js/bootstrap-datetimepicker.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/dashboard/agenda/general_calendar.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/dashboard/agenda/calendar.js"></script>
    <script>
        userType = <?= $this->session->userdata('id_rol') ?> ;
        idUser = <?= $this->session->userdata('id_usuario') ?> ;
        let base_url = "<?=base_url()?>";
    </script>