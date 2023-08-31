<link href="<?= base_url() ?>dist/css/calendarDashboard.css" rel="stylesheet"/>

<div class="card">
    <div class="card-content">
        <div class="container-fluid">
            <div class="row mb-2 selects">
            <!-- Subdirector -->
            <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden pl-0">
                    <label class="label-gral">Gerente</label>
                    <select class="selectpicker select-gral m-0" id="gerente" name="gerente" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un gerente" data-size="7" data-container="body"></select>
                </div>
            <?php } ?>
            <!-- Subdirector y Gerente -->
            <?php if( $this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 3 ) { ?>
                <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden">
                <?php } else  { ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden pl-0" >
                <?php } ?>
                    <label class="label-gral" id="labelCoord" style="display:none">Coordinador</label>
                    <select class="selectpicker select-gral m-0" id="coordinador" name="coordinador" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un coordinador" data-size="7" data-container="body"></select>
                </div>
                <?php if( $this->session->userdata('id_rol') == 2 ) { ?>
                <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden pr-0">
                <?php } else  { ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 overflow-hidden pr-0">
                <?php } ?>
                    <label class="label-gral" id="labelAses" style="display:none">Asesor</label>
                    <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un asesor" data-size="7" data-container="body"></select>
                </div>
            <?php } ?>
            <!-- Coordinador -->
            <?php if( $this->session->userdata('id_rol') == 9 ) { ?>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden p-0 mb-1">
                    <label class="label-gral">Asesor</label>
                    <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un asesor" data-size="7" data-container="body"></select>
                </div>
            <?php } ?>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                    <div id='calendar'></div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                    <div class="boxCodigos d-flex">
                        <div class="boxStatus d-flex">
                            <i class="fas fa-circle codeFinish"></i>
                            <p class="m-0">Cita finalizada</p>
                        </div>
                        <div class="boxStatus d-flex">
                            <i class="fas fa-circle codeOpen"></i>
                            <p class="m-0">Cita abierta</p>
                        </div>
                        <?php if( $this->session->userdata('id_rol') != 7 ) { ?>
                            <div class="boxStatus d-flex">
                                <i class="fas fa-square codeAdviser"></i>
                                <p class="m-0">Evento de asesor de ventas</p>
                            </div>
                            <div class="boxStatus d-flex">
                                <i class="fas fa-square codeManager"></i>
                                <p class="m-0">Evento de coordinador</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
