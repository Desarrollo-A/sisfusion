<div class="modal fade" id="myCommentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title">Ingresa tus comentarios</h4>
            </div>
            <form id="my-comment-form" name="my-comment-form" method="post">
                <div class="modal-body">
                    <textarea class="text-modal" type="text" name="observations" id="observations" autofocus="true"
                        onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                    <input type="hidden" name="id_prospecto" id="id_prospecto">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myUpdateStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="my_update_status_form" name="my_update_status_form" method="post">
                <div class="container-fluid pl-2 pr-2 pt-3 pb-1">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
                            <h4 class="modal-title">¿Qué estatus asignarás a este prospecto?</h4>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 overflow-hidden">
                            <select class="selectpicker select-gral m-0" name="estatus_particular"
                                id="estatus_particular" data-style="btn" data-show-subtext="true"
                                data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="5"
                                data-container="body"></select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end pt-1">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                                onclick="cleanSelects()">Cancelar</button>
                            <button type="submit" class="btn btn-primary finishS">Aceptar</button>
                        </div>
                    </div>
                    <input type="hidden" name="id_prospecto_estatus_particular" id="id_prospecto_estatus_particular">
                    <input type="hidden" id="telefono1">
                    <input type="hidden" id="telefono2">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="cleanCombos()"><span
                        aria-hidden="true"><i class="fa fa-times"></i></span><span
                        class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">Mantén la información actualizada</h4>
                <h4 class="js-title-step"></h4>
            </div>
            <form id="my-edit-form" name="my-edit-form" method="post">
                <div class="modal-body">
                    <div class="row" data-step="1" data-title="Acerca de">
                        <div>
                            <div class="col-sm-3">
                                <div class="form-group select-is-empty overflow-hidden">
                                    <label class="control-label">Nacionalidad<small> (requerido)</small></label>
                                    <select id="nationality" name="nationality" class="selectpicker select-gral m-0"
                                        data-style="btn" data-show-subtext="true" data-live-search="true"
                                        title="Selecciona una opción" data-size="7" data-container="body" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group select-is-empty overflow-hidden">
                                    <label class="control-label">Personalidad jurídica<small>
                                            (requerido)</small></label>
                                    <select id="legal_personality" name="legal_personality"
                                        class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"
                                        data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7"
                                        data-container="body" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group div-curp">
                                    <label class="control-label">CURP</label>
                                    <input id="curp" name="curp" type="text" class="form-control input-gral"
                                        minlength="18" maxlength="18"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group div-rfc">
                                    <label class="control-label">RFC</label>
                                    <input id="rfc" name="rfc" type="text" class="form-control input-gral"
                                        minlength="12" maxlength="13"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group  div-name">
                                    <label class="control-label">Nombre / Razón social<small>
                                            (requerido)</small></label>
                                    <input id="name" name="name" type="text" class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group  div-last-name">
                                    <label class="control-label">Apellido paterno</label>
                                    <input id="last_name" name="last_name" type="text" class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group  div-mothers-last-name">
                                    <label class="control-label">Apellido materno</label>
                                    <input id="mothers_last_name" name="mothers_last_name" type="text"
                                        class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group  div-date-birth">
                                    <label class="control-label">Fecha de nacimiento</label>
                                    <input id="date_birth" name="date_birth" type="date" class="form-control input-gral"
                                        onchange="getAge(2)">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group  div-company-antiquity">
                                    <label class="control-label">Edad</label>
                                    <input id="company_antiquity" name="company_antiquity" type="text"
                                        class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group  div-email">
                                    <label class="control-label">Correo electrónico</label>
                                    <input id="email" name="email" type="email" class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group  div-phone-number">
                                    <label class="control-label">Teléfono celular<small> (requerido)</small></label>
                                    <input id="phone_number" name="phone_number" type="text"
                                        class="form-control input-gral" maxlength="10"
                                        oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group div-phone-number2">
                                    <label class="control-label">Teléfono casa</label>
                                    <input id="phone_number2" name="phone_number2" type="text"
                                        class="form-control input-gral" maxlength="10"
                                        oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group select-is-empty overflow-hidden">
                                    <label class="control-label">Estado civil</label>
                                    <select id="civil_status" name="civil_status" class="selectpicker select-gral m-0"
                                        data-style="btn" data-show-subtext="true" data-live-search="true"
                                        title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body"
                                        onchange="validateCivilStatus(2)">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group select-is-empty overflow-hidden">
                                    <label class="control-label">Régimen matrimonial</label>
                                    <select id="matrimonial_regime" name="matrimonial_regime"
                                        class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"
                                        data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7"
                                        data-container="body" onchange="validateMatrimonialRegime(2)">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group div-spouce">
                                    <label class="control-label">Cónyuge</label>
                                    <input id="spouce" name="spouce" type="text" class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group  div-street-name">
                                    <label class="control-label">Originario de</label>
                                    <input id="from" name="from" type="text" class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group  div-ext-number">
                                    <label class="control-label">Domicilio particular</label>
                                    <input id="home_address" name="home_address" type="text"
                                        class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>

                            <div class="col-sm-3">La casa donde vive es</div>
                            <div class="col-lg-10 col-lg-offset-2 align-center">
                                <div class="radio"></div>
                                <div class="radio radio-inline">
                                    <label><input id="own" name="lives_at_home" type="radio" value="1"> Propia</label>
                                </div>
                                <div class="radio radio-inline">
                                    <label><input id="rented" name="lives_at_home" type="radio" value="2">
                                        Rentada</label>
                                </div>
                                <div class="radio radio-inline">
                                    <label><input id="paying" name="lives_at_home" type="radio" value="3">
                                        Pagándose</label>
                                </div>
                                <div class="radio radio-inline">
                                    <label><input id="family" name="lives_at_home" type="radio" value="4">
                                        Familiar</label>
                                </div>
                                <div class="radio radio-inline">
                                    <label><input id="other" name="lives_at_home" type="radio" value="5"> Otro</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row hide" data-step="2" data-title="Empleo">
                        <div>
                            <div class="col-sm-4">
                                <div class="form-group div-occupation">
                                    <label class="control-label">Ocupación</label>
                                    <input id="occupation" name="occupation" type="text" class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group div-company">
                                    <label class="control-label">Empresa</label>
                                    <input id="company" name="company" type="text" class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group div-position">
                                    <label class="control-label">Puesto</label>
                                    <input id="position" name="position" type="text" class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group  div-antiquity">
                                    <label class="control-label">Antigüedad (años)</label>
                                    <input id="antiquity" name="antiquity" type="number" class="form-control input-gral"
                                        maxlength="2"
                                        oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group  div-company-residence">
                                    <label class="control-label">Domicilio</label>
                                    <input id="company_residence" name="company_residence" type="text"
                                        class="form-control input-gral"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row hide" data-step="3" data-title="Prospección">
                        <div>
                            <div class="col-sm-3">
                                <div class="form-group select-is-empty overflow-hidden">
                                    <label class="control-label">¿Cómo nos contactaste?<small>
                                            (requerido)</small></label>
                                    <select id="prospecting_place" name="prospecting_place"
                                        class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"
                                        data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7"
                                        data-container="body" disabled>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group  select-is-empty">
                                    <label class="control-label">Específique cuál</label>
                                    <input id="specify" name="specify" type="text" class="form-control input-gral"
                                        readonly onkeyup="javascript:this.value=this.value.toUpperCase();"
                                        style="display: none;" disabled="">
                                    <div id="specify_mkt_div" name="specify_mkt_div" style="display: none;">
                                        <select id="specify_mkt" name="specify_mkt" class="selectpicker select-gral m-0"
                                            data-style="btn" data-show-subtext="true" data-live-search="true"
                                            title="SELECCIONA UNA OPCIÓN" data-size="7" style="display: none;" disabled>
                                            <option value="01 800">01 800</option>
                                            <option value="Chat">Chat</option>
                                            <option value="Contacto web">Contacto web</option>
                                            <option value="Facebook">Facebook</option>
                                            <option value="Instagram">Instagram</option>
                                            <option value="Recomendado">Recomendado</option>
                                            <option value="WhatsApp">WhatsApp</option>
                                        </select>
                                    </div>
                                    <select id="specify_recommends" name="specify" class="form-control input-gral"
                                        data-live-search="true" style="display: none; width: 100%">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group select-is-empty overflow-hidden">
                                    <label class="control-label">Plaza de venta<small> (requerido)</small></label>
                                    <select id="sales_plaza" name="sales_plaza" class="selectpicker select-gral m-0"
                                        data-style="btn" data-show-subtext="true" data-live-search="true"
                                        title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group  div-observations">
                                    <label class="control-label">Observaciones</label>
                                    <textarea type="text" id="observation" name="observation" class="text-modal"
                                        onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                                    <input type="hidden" name="id_prospecto_ed" id="id_prospecto_ed">
                                    <input type="hidden" name="owner" id="owner">
                                    <input type="hidden" name="source" id="source">
                                    <input type="hidden" name="editProspecto" id="editProspecto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left">
                        <button type="button" class="btn btn-default js-btn-step" data-orientation="previous"></button>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn  js-btn-step" data-orientation="next"
                            style="background-color: #2E86C1;"></button>
                        <button type="submit" class="btn" style="background-color: #4caf50;">Finalizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL-->
<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons" onclick="cleanComments()">clear</i>
                </button>
                <h4 class="modal-title">Consulta información</h4>
            </div>
            <div class="modal-body">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                        <li role="presentation" class="active"><a href="#generalTab" aria-controls="generalTab"
                                role="tab" data-toggle="tab">General</a></li>
                        <li role="presentation"><a href="#commentsTab" aria-controls="commentsTab" role="tab"
                                data-toggle="tab">Comentarios</a></li>
                        <li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab"
                                data-toggle="tab">Bitácora de cambios</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="generalTab">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group m-0">
                                        <label class="control-label">Personalidad jurídica</label>
                                        <input id="legal-personality-lbl" type="text" class="form-control input-gral"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-0">
                                        <label class="control-label">Nacionalidad</label>
                                        <input id="nationality-lbl" type="text" class="form-control input-gral"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-0">
                                        <label class="control-label">CURP</label>
                                        <input id="curp-lbl" type="text" class="form-control input-gral" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-0">
                                        <label class="control-label">RFC</label>
                                        <input id="rfc-lbl" type="text" class="form-control input-gral" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- recovered-->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="control-label">Nombre / Razón social</label>
                                        <input id="name-lbl" type="text" class="form-control input-gral" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-0">
                                        <label class="control-label">Correo electrónico</label>
                                        <input id="email-lbl" type="text" class="form-control input-gral" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group m-0">
                                        <label class="control-label">Teléfono</label>
                                        <input id="phone-number-lbl" type="text" class="form-control input-gral"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="control-label">¿Cómo nos contactaste?</label>
                                        <input id="prospecting-place-lbl" type="text" class="form-control input-gral"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="control-label">Plaza de venta</label>
                                        <input id="sales-plaza-lbl" type="text" class="form-control input-gral"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group m-0">
                                        <label class="control-label">Asesor</label>
                                        <input id="asesor-lbl" type="text" class="form-control input-gral" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-0">
                                        <label class="control-label">Coordinador</label>
                                        <input id="coordinador-lbl" type="text" class="form-control input-gral"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-0">
                                        <label class="control-label">Gerente</label>
                                        <input id="gerente-lbl" type="text" class="form-control input-gral" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group m-0">
                                        <label class="control-label">Observaciones</label>
                                        <textarea class="text-modal scroll-styles" id="comentario" rows="3"
                                            placeholder="Comentario" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" id="id-prospecto-lbl" name="id_prospecto_lbl">
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="commentsTab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                            <ul class="timeline-3" id="comments-list"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="changelogTab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-plain">
                                        <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                            <ul class="timeline-3" id="changelog"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                    onclick="cleanComments()">Cerrar</button>
                <button type="button" class="btn btn-primary"
                    onclick="{{$('#prospecting-place-lbl').val() == 'MKT digital (especificar)' ? printProspectInfoMktd() : printProspectInfo()}}"><i
                        class="material-icons">cloud_download</i> Descargar pdf</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agendaInsert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header mb-1">
                    <h4 class="modal-title text-center">Detalles de la cita</h4>
                </div>
                <div class="container-fluid">
                    <form id="estatus_recordatorio_form" name="estatus_recordatorio_form" method="post">
                        <div class="col-lg-12 form-group m-0">
                            <label class="label-gral">Título</label>
                            <input id="evtTitle" name="evtTitle" type="text" class="form-control input-gral">
                        </div>
                        <div class="col-lg-12 form-group m-0" id="select">
                            <label class="label-gral">Tipo de cita</label>
                            <select class="selectpicker select-gral m-0" name="estatus_recordatorio"
                                id="estatus_recordatorio" data-style="btn" data-show-subtext="true"
                                data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                        <div class="col-lg-12 form-group m-0 hide" id="comodinDIV"></div>
                        <div class="col-lg-12 form-group m-0">
                            <label class="label-gral">Fecha de cita</label>
                            <div class="d-flex">
                                <input id="dateStart" name="dateStart" type="datetime-local"
                                    class="form-control beginDate w-50 text-left pl-1">
                                <input id="dateEnd" name="dateEnd" type="datetime-local"
                                    class="form-control endDate w-50 pr-1">
                            </div>
                        </div>
                        <div class="col-lg-12 form-group m-0">
                            <label class="label-gral">Descripción</label>
                            <textarea class="text-modal" type="text" name="description" id="description"
                                onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                                onclick="cleanSelects()">Cancelar</button>
                            <button type="submit" class="btn btn-primary finishS">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>