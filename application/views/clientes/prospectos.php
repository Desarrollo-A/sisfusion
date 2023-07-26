<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">
            .progress .progress-bar, .progress .progress-bar.progress-bar-default {
                background-color: #0073c8;
            }
            .progress-bar.indeterminate {
                position: relative;
                animation: progress-indeterminate 1.2s linear infinite;
            }
            .input-gral {
                background-color: #eaeaea !important;
                color: #929292 !important;
                border-radius: 27px !important;
                background-image: none !important;
                padding-left: 20px;
            }

            .input-gral ::placeholder {
                margin-left: 20px;
            }

            .form-group. label.control-label, .form-group.label-placeholder label.control-label {
                top: -3px;
                font-size: 14px;
                line-height: 1.42857;
            }

            .form-group label.control-label {
                color: #929292;
            }

            @keyframes progress-indeterminate {
                from { left: -25%; width: 25%; }
                to { left: 100%; width: 25%;}
            }

            .isRequired{
                color: #EA4335;
                margin: 0 3px;
            }

            .u2be i{
                color: red;
            }
        </style>

        <div class="content">
            <div class="container-fluid">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- Wizard container -->
                    <div class="wizard-container">
                        <div class="card wizard-card" data-color="green" id="wizardProfile">
                            <form id="my-form" name="my-form" method="post">
                                <div class="wizard-header">
                                    <h3 class="wizard-title">Construye su perfil</h3>
                                    <h5>Esta información nos permitirá saber más sobre él.
                                        <a href="https://youtu.be/pj80dBMw6y4" class="p-0 ml-3 d-flex align-center justify-center u2be" target="_blank">
                                            <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                        </a>
                                    </h5>
                                </div>
                                <div class="wizard-navigation" id="wiz-nav" name="wiz-nav">
                                    <ul>
                                        <li>
                                            <a href="#about" data-toggle="tab">Acerca de</a>
                                        </li>
                                        <li>
                                            <a href="#job" data-toggle="tab">Empleo</a>
                                        </li>
                                        <li>
                                            <a href="#prospecting" data-toggle="tab">Prospección</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane" id="about">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="info-text"> Comencemos con la información básica </h4>
                                            </div>
                                            <div class="col-sm-12 box-alert" style="display:none">
                                                <div class="alert alert-danger" role="alert">
                                                    El nombre o teléfono o email, ya están registrados. Favor de verficar.
                                                </div>
                                            </div>

                                            <div class="col-sm-12 pl-3 pr-3 pb-2">
                                                <div class="col-sm-3">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">
                                                            Nacionalidad (<span class="isRequired">*</span>)
                                                        </label>
                                                        <select id="nationality" 
                                                                name="nationality"
                                                                class="selectpicker select-gral m-0"
                                                                data-style="btn"
                                                                data-show-subtext="true"
                                                                data-live-search="true"
                                                                title="Selecciona una opción"
                                                                data-size="7"
                                                                data-container="body"
                                                                onchange="validateSelect('nationality')"
                                                                required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">Personalidad jurídica (<span class="isRequired">*</span>)</label>
                                                        <select id="legal_personality" 
                                                                name="legal_personality"
                                                                class="selectpicker select-gral m-0"
                                                                data-style="btn"
                                                                data-show-subtext="true"
                                                                title="Selecciona una opción"
                                                                data-size="7"
                                                                data-container="body"
                                                                onchange="validatePersonality(), validateSelect('legal_personality')"
                                                                required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">CURP</label>
                                                        <input  id="curp" 
                                                                name="curp"
                                                                type="text"
                                                                class="form-control input-gral" 
                                                                minlength="18" 
                                                                maxlength="18" 
                                                                readonly
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">RFC</label>
                                                        <input  id="rfc"
                                                                name="rfc"
                                                                type="text"
                                                                class="form-control input-gral"
                                                                minlength="12"
                                                                maxlength="13" 
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 pl-3 pr-3 pb-2">
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">Nombre / Razón social (<span class="isRequired">*</span>)</label>
                                                        <input  id="name"
                                                                name="name"
                                                                type="text"
                                                                class="form-control input-gral"
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                                                onchange="validateInputs(this);"
                                                                required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">Apellido paterno</label>
                                                        <input  id="last_name"
                                                                name="last_name"
                                                                type="text"
                                                                class="form-control input-gral"
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">Apellido materno</label>
                                                        <input  id="mothers_last_name"
                                                                name="mothers_last_name"
                                                                type="text"
                                                                class="form-control input-gral"
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">Fecha de nacimiento</label>
                                                        <input  id="date_birth"
                                                                name="date_birth"
                                                                type="date"
                                                                class="form-control input-gral" onchange="getAge(1)"/>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12 pl-3 pr-3 pb-2">
                                                <div class="col-sm-2">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">Edad</label>
                                                        <input  id="company_antiquity"
                                                                name="company_antiquity"
                                                                type="text"
                                                                class="form-control input-gral"
                                                                readonly
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group ">
                                                        <label class="control-label">Correo electrónico</label>
                                                        <input  id="email"
                                                                name="email"
                                                                type="email"
                                                                class="form-control input-gral"
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();"
                                                                onchange="validateInputs(this);">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">Teléfono celular (<span class="isRequired">*</span>)</label>
                                                        <input  id="phone_number"
                                                                name="phone_number"
                                                                type="number"
                                                                class="form-control input-gral"
                                                                maxlength="15"
                                                                required
                                                                oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onchange="validateInputs(this);"
                                                                required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">Teléfono casa</label>
                                                        <input  id="phone_number2"
                                                                name="phone_number2"
                                                                type="number"
                                                                class="form-control input-gral"
                                                                maxlength="15"
                                                                oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 pl-3 pr-3 pb-2">
                                                <div class="col-sm-2">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">Estado civil</label>
                                                        <select id="civil_status"
                                                                name="civil_status"
                                                                class="selectpicker select-gral m-0"
                                                                data-style="btn"
                                                                data-show-subtext="true"
                                                                title="Selecciona una opción"
                                                                data-size="7"
                                                                data-container="body">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">Régimen matrimonial</label>
                                                        <select id="matrimonial_regime"
                                                                name="matrimonial_regime"
                                                                class="selectpicker select-gral m-0"
                                                                data-style="btn"
                                                                data-show-subtext="true"
                                                                title="Selecciona una opción"
                                                                data-size="7"
                                                                data-container="body"
                                                                onchange="validateMatrimonialRegime(1)">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">Cónyugue</label>
                                                        <input  id="spouce"
                                                                name="spouce"
                                                                type="text"
                                                                class="form-control input-gral"
                                                                readonly
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group ">
                                                        <label class="control-label">Originiario de</label>
                                                        <input  id="from"
                                                                name="from"
                                                                type="text"
                                                                class="form-control input-gral"
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group ">
                                                        <label class="control-label">Domicilio particular</label>
                                                        <input  id="home_address"
                                                                name="home_address"
                                                                type="text"
                                                                class="form-control input-gral"
                                                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <br>
                                            <div class="col-sm-12">La casa donde vive es</div>
                                            <div class="col-sm-12 col-sm-offset-1">
                                                <div class="col-sm-2">
                                                    <div class="choice" data-toggle="wizard-radio">
                                                        <input  id="own"
                                                                name="lives_at_home"
                                                                type="radio"
                                                                value="1">
                                                        <div class="icon"><i class="fa fa-home"></i></div>
                                                        <h6>Propia</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="choice" data-toggle="wizard-radio">
                                                        <input  id="rented"
                                                                name="lives_at_home"
                                                                type="radio"
                                                                value="2">
                                                        <div class="icon"><i class="fa fa-file"></i></div>
                                                        <h6>Rentada</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="choice" data-toggle="wizard-radio">
                                                        <input  id="paying"
                                                                name="lives_at_home"
                                                                type="radio"
                                                                value="3">
                                                        <div class="icon">
                                                            <i class="fa fa-money"></i>
                                                        </div>
                                                        <h6>Pagándose</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="choice" data-toggle="wizard-radio">
                                                        <input  id="family"
                                                                name="lives_at_home"
                                                                type="radio"
                                                                value="4">
                                                        <div class="icon"><i class="fa fa-group"></i></div>
                                                        <h6>Familiar</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="choice" data-toggle="wizard-radio">
                                                        <input  id="other"
                                                                name="lives_at_home"
                                                                type="radio"
                                                                value="5">
                                                        <div class="icon"><i class="fa fa-circle"></i></div>
                                                        <h6>Otro</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="job">
                                        <h4 class="info-text"> ¿Cuál es su empleo? </h4>
                                        <div class="row">
                                            <div class="col-sm-4 col-sm-offset-1">
                                                <div class="form-group ">
                                                    <label class="control-label">Ocupación</label>
                                                    <input  id="occupation"
                                                            name="occupation"
                                                            type="text"
                                                            class="form-control input-gral"
                                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group ">
                                                    <label class="control-label">Empresa</label>
                                                    <input  id="company"
                                                            name="company"
                                                            type="text"
                                                            class="form-control input-gral"
                                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-sm-offset-1">
                                                <div class="form-group ">
                                                    <label class="control-label">Puesto</label>
                                                    <input  id="position"
                                                            name="position"
                                                            type="text"
                                                            class="form-control input-gral"
                                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group ">
                                                    <label class="control-label">Antigüedad (años)</label>
                                                    <input  id="antiquity"
                                                            name="antiquity"
                                                            type="number"
                                                            class="form-control input-gral"
                                                            maxlength="2"
                                                            oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group ">
                                                    <label class="control-label">Domicilio</label>
                                                    <input  id="residence"
                                                            name="company_residence"
                                                            type="text"
                                                            class="form-control input-gral"
                                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="prospecting">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="info-text"> Es importante saber cómo nos conoció </h4>
                                            </div>
                                            <div class="col-sm-12 pl-3 pr-3"> 
                                                <div class="col-sm-4">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">¿Cómo nos contactaste? (<span class="isRequired">*</span>)</label>
                                                        <select id="prospecting_place"
                                                                name="prospecting_place"
                                                                class="selectpicker select-gral m-0"
                                                                data-style="btn"
                                                                data-show-subtext="true"
                                                                data-live-search="true"
                                                                title="Selecciona una opción"
                                                                data-size="7"
                                                                data-container="body"
                                                                onchange="validateProspectingPlace(), validateSelect('prospecting_place')"
                                                                required>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">Específique cuál</label>
                                                        <input id="specify" name="specify" type="text" class="form-control input-gral" readonly onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                        <div id="specify_mkt_div" name="specify_mkt_div" style="display: none;">
                                                            <select id="specify_mkt"name="specify_mkt" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body" style="display: none;">
                                                                <option value="01 800">01 800</option>
                                                                <option value="Chat">Chat</option>
                                                                <option value="Contacto web">Contacto web</option>
                                                                <option value="Facebook">Facebook</option>
                                                                <option value="Instagram">Instagram</option>
                                                                <option value="Recomendado">Recomendado</option>
                                                                <option value="WhatsApp">WhatsApp</option>
                                                            </select>
                                                        </div>
                                                        <select id="specify_recommends" name="specify" class="form-control input-gral" required data-live-search="true" style="display: none; width: 100%" onchange="getRecommendationData()">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group  select-is-empty">
                                                        <label class="control-label">Plaza de venta (<span class="isRequired">*</span>)</label>
                                                        <select id="sales_plaza" name="sales_plaza" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" data-container="body" title="Selecciona una opción" data-size="7" onchange="validateSelect('sales_plaza')" required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 pl-3 pr-3">
                                                <div class="col-sm-12">
                                                    <div class="form-group ">
                                                        <label class="control-label">Observaciones</label>
                                                        <textarea   type="password" id="observations" name="observations" class="form-control input-gral" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 pl-3 pr-3">
                                                <div class="col-sm-12">
                                                    <div class="form-group ">
                                                        <input  id="type_recomendado" name="type_recomendado" type="hidden" class="form-control input-gral">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wizard-footer">
                                    <div class="col-md-12" id="savingProspect"></div>
                                    <div class="pull-right">
                                        <input  type="hidden" name="asesor_prospecto" id="asesor_prospecto" value="0">
                                        
                                        <input  type='button' class='btn btn-next btn-fill btn-wd' name='next' value='Siguiente' style="background-color: #4caf50"/>
                                        
                                        <button type='button' class='btn btn-finish btn-fill btn-wd' name='finish' id="finish" value='Finalizar' style="background-color: #4caf50">
                                            Finalizar
                                        </button>

                                        <button type="submit" id="submt" class="hide">
                                            Enviar final
                                        </button>

                                    </div>
                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Anterior' />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                            <div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content" style="height: 250px;">
                                        <div class="modal-header">
                                            <button type="button"
                                                    class="close"
                                                    data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">
                                                    &times;
                                                </span>
                                            </button>
                                            <br>
                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                    <em>Recuerda que dependiendo del lugar de prospección que selecciones se calculará tu comisión. El valor no podrá ser modificado una vez guardado.</em><br>¿Estás seguro que deseas continuar?
                                            </h5>
                                        </div>
                                        <div class="modal-footer"><br><br>
                                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" id="btns" onclick="save();" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/controllers/prospectos.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/global_functions.js"></script>

</body>