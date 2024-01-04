<body>
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <style>
        .boldtext {
            font-weight: bold;
            color: #17202A;
        }
    </style>

    <div class="content">
        <div class="container-fluid">


            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card wizard-card" data-color="green" id="wizardProfile">
                        <form id="my-form" name="my-form" method="post">
                            <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                            <div class="wizard-header">
                                <h3 class="wizard-title">
                                    Construye su perfil
                                </h3>
                                <h5>
                                    Esta información nos permitirá saber más sobre él.</h5>
                            </div>
                            <div class="wizard-navigation">
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
                                        <div class="col-sm-2 col-sm-offset-1">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Nacionalidad<small> (requerido)</small></label>
                                                <select id="nationality" name="nationality" class="form-control nationality"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Personalidad jurídica<small> (requerido)</small></label>
                                                <select id="legal_personality" name="legal_personality" class="form-control legal_personality" onchange="validatePersonality()"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">CURP</label>
                                                <input id="curp" name="curp" type="text" class="form-control" minlength="18" maxlength="18" readonly onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">RFC</label>
                                                <input id="rfc" name="rfc" type="text" class="form-control" minlength="12" maxlength="13" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-sm-offset-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre / Razón social<small> (requerido)</small></label>
                                                <input id="name" name="name" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Apellido paterno</label>
                                                <input id="last_name" name="last_name" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Apellido materno</label>
                                                <input id="mothers_last_name" name="mothers_last_name" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Fecha de nacimiento</label>
                                                <input id="date_birth" name="date_birth" type="date" class="form-control" onchange="getAge(1)"/>
<!--                                                <input id="date_birth" name="date_birth" type="text" class="form-control datepicker">-->
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-sm-offset-1">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Edad</label>
                                                <input id="company_antiquity" name="company_antiquity" type="text" class="form-control" readonly onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Correo electrónico</label>
                                                <input id="email" name="email" type="email" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">* Teléfono celular<small> (requerido)</small></label>
                                                <input id="phone_number" name="phone_number" type="number" class="form-control" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Teléfono casa</label>
                                                <input id="phone_number2" name="phone_number2" type="number" class="form-control" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-sm-offset-1">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Estado civil</label>
                                                <select id="civil_status" name="civil_status" class="form-control civil_status"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Régimen matrimonial</label>
                                                <select id="matrimonial_regime" name="matrimonial_regime" class="form-control matrimonial_regime" onchange="validateMatrimonialRegime(1)"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Cónyugue</label>
                                                <input id="spouce" name="spouce" type="text" class="form-control" readonly onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-sm-offset-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Originiario de</label>
                                                <input id="from" name="from" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Domicilio particular</label>
                                                <input id="home_address" name="home_address" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-10 col-lg-offset-1">La casa donde vive es</div>
                                        <div class="col-lg-10 col-lg-offset-2">
                                            <div class="col-sm-2">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input id="own" name="lives_at_home" type="radio" value="1">
                                                    <div class="icon"><i class="fa fa-home"></i></div>
                                                    <h6>Propia</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input id="rented" name="lives_at_home" type="radio" value="2">
                                                    <div class="icon"><i class="fa fa-file"></i></div>
                                                    <h6>Rentada</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input id="paying" name="lives_at_home" type="radio" value="3">
                                                    <div class="icon"><i class="fa fa-money"></i></div>
                                                    <h6>Pagándose</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input id="family" name="lives_at_home" type="radio" value="4">
                                                    <div class="icon"><i class="fa fa-group"></i></div>
                                                    <h6>Familiar</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="choice" data-toggle="wizard-radio">
                                                    <input id="other" name="lives_at_home" type="radio" value="5">
                                                   <!-- <input id="hidden" name="lives_at_home" type="hidden">-->
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
                                            <div class="form-group label-floating">
                                                <label class="control-label">Ocupación</label>
                                                <input id="occupation" name="occupation" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Empresa</label>
                                                <input id="company" name="company" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-sm-offset-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Puesto</label>
                                                <input id="position" name="position" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Antigüedad (años)</label>
                                                <input id="antiquity" name="antiquity" type="number" class="form-control" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Domicilio</label>
                                                <input id="residence" name="company_residence" type="text" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="prospecting">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4 class="info-text"> Es importante saber cómo nos conoció </h4>
                                        </div>
                                        <!--<div class="col-sm-3 col-sm-offset-1">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">¿Cómo se enteró de nosotros?<small> (requerido)</small></label>
                                                <select id="advertising" name="advertising" class="form-control advertising"></select>
                                            </div>
                                        </div>-->
                                        <div class="col-sm-5 col-sm-offset-1">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">¿Cómo nos contactaste?<small> (requerido)</small></label>
                                                <select id="prospecting_place" name="prospecting_place" class="form-control prospecting_place" onchange="validateProspectingPlace()"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Específique cuál</label>
                                                <input id="specify" name="specify" type="text" class="form-control" readonly onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                <select id="specify_mkt" name="specify" class="form-control" style="display: none">
                                                    <option value="0" id="sm" disabled selected>Seleccione una opción</option>
                                                    <option value="01 800">01 800</option>
                                                    <option value="Chat">Chat</option>
                                                    <option value="Contacto web">Contacto web</option>
                                                    <option value="Facebook">Facebook</option>
                                                    <option value="Instagram">Instagram</option>
                                                    <option value="Recomendado">Recomendado</option>
                                                    <option value="WhatsApp">WhatsApp</option>
                                                </select>
                                                <select id="specify_recommends" name="specify" class="form-control" required data-live-search="true" style="display: none; width: 100%" onchange="getRecommendationData()"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">Plaza de venta<small> (requerido)</small></label>
                                                <select id="sales_plaza" name="sales_plaza" class="form-control sales_plaza"></select>
                                            </div>
                                        </div>

                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Observaciones</label>
                                                <textarea type="password" id="observations" name="observations" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="form-group label-floating select-is-empty col-sm-12">
                                                    <label>Asesor asignado al prospecto<small> (requerido)</small></label><br>
                                                    <select id="asesor_prospecto" name="asesor_prospecto" class="form-control select2_so" required="true" data-live-search="true" style="width: 100%"></select>
                                            </div>
                                        </div>

                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="form-group label-floating">
                                                <input id="type_recomendado" name="type_recomendado" type="hidden" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                 <style type="text/css">
                                                .progress .progress-bar, .progress .progress-bar.progress-bar-default {
                                                    background-color: #0073c8;
                                                }
                                                .progress-bar.indeterminate {
                                                  position: relative;
                                                  animation: progress-indeterminate 1.2s linear infinite;
                                                }

                                                @keyframes progress-indeterminate {
                                                   from { left: -25%; width: 25%; }
                                                   to { left: 100%; width: 25%;}
                                                }
                                            </style>
                                <div class="col-md-12" id="savingProspect">
                                           
                                        
                                </div>
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-fill btn-wd' name='next' value='Siguiente' style="background-color: #4caf50" />
                                    <a type='button' class='btn btn-finish btn-fill btn-green btn-wd' name='finish' id="finish" value='Finalizar'  style="background-color: #4caf50"/>Finalizar</a>
                                    <button type="submit" id="submt" class="hide">Enviar final</button>
<!--                                    <button type="submit" class="btn btn-green" style="background-color: #4caf50;">Finalizar</button>-->
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
<br>
        <h5 class="modal-title" id="exampleModalLongTitle"><center>
            <em>Recuerda que dependiendo del lugar de prospección que selecciones se calculará tu comisión. El valor no podrá ser modificado una vez guardado.  </em><br>
        ¿Estás seguro que deseas continuar?</center></h5>
        
            
       
              </div>
     
      <div class="modal-footer"><br><br>
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
</body>
<?php $this->load->view('template/footer');?>

<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>
<link href="<?=base_url()?>dist/js/controllers/select2/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>dist/js/controllers/select2/select2.full.min.js"></script>

<script>
    document.write(new Date().getFullYear());
    $(".select2_so").select2();

    $(document).ready( function(){
           // Fill the select of advertising
    $.getJSON("getAdvisersMktd").done( function( data ){
        $("#asesor_prospecto").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#asesor_prospecto").append($('<option>').val(id).text(name));

        }
    });
    });

</script>

<script type="text/javascript">
    $(document).ready(function() {
        demo.initMaterialWizard();
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
</script>

