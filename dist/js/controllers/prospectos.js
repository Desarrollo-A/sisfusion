let coincidencias = 0;
$(document).ready(function() {
	$(".select-is-empty").removeClass("is-empty");
	$("#prospecto").empty().selectpicker('refresh');

    function reloadPage() {
        location.reload();
    }
    
    demo.initMaterialWizard();
    md.initSliders()
    demo.initFormExtendedDatetimepickers();
});

/*update validaciones*/
$('#finish').on('click', function() {
    validateFile();
});
$(document).on('click', '#btns', function() {
    $('#submt').click();
});
$(document).on('click', '#submt', function() {
    $('#confirmar').modal('toggle');
});
$("#my-form").on('submit', function(e) {
    e.preventDefault();
    validateEmptySelects(1);
    $.ajax({
        type: 'POST',
        url: 'saveProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            document.getElementById("finish").disabled = true;
            var myDataHTML = '<center>Guardando ...</center> <div class="progress progress-line-info"><div class="progress-bar indeterminate" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;"></div></div>;';
            $('#savingProspect').html(myDataHTML);


        },
        success: function(data) {
            if (data == 1) {
                //reloadPage();
                alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                var myDataHTML = '<center><b style="color:green">Guardado correctamente</b></center> ';
                $('#savingProspect').html(myDataHTML);
                setTimeout(function() {
                    document.location.reload()
                }, 2000);
            } else {
                document.getElementById("finish").disabled = false;
                var myDataHTML = '';
                $('#savingProspect').html(myDataHTML);
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            document.getElementById("finish").disabled = false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});
/*end validaciones*/

function validateFile() {
    var elementos_req = new Array('prospecting_place', 'sales_plaza');
    var exito_confirmar = false;
    let flagErrors = 0;
    for (let index = 0; index < elementos_req.length; index++) {
        index_select = document.getElementById(elementos_req[index]).selectedIndex;
        if(index_select =! undefined && index_select > 0){
            $("#"+elementos_req[index]).parent('div').parent('div').removeClass('has-error');
        }else{
            $("#"+elementos_req[index]).parent('div').parent('div').addClass('has-error');
            flagErrors = flagErrors+1;
        }
    }

    if(flagErrors == 0){
        exito_confirmar = true;
    }else{
        exito_confirmar = false;
    }
    
    if (!exito_confirmar) {
        alerts.showNotification('top', 'right', 'Debes ingresar los campos requeridos', 'danger');
    } else {
       $('#confirmar').modal('toggle');
    }
}

function validateEmptySelects(type) {
    /*
     * 1 insert prospect
     * 2 update prospect
     * 3 insert co-owner
     */
    if (type == 1 || type == 2) { // validate fields before insert/update a prospect
        if ($("#civil_status").val() == null || $("#civil_status").val() == '') {
            $("#civil_status").val(7);
        }
        if ($("#matrimonial_regime").val() == null || $("#matrimonial_regime").val() == '') {
            $("#matrimonial_regime").val(5);
        }
        if ($("#state").val() == null || $("#state").val() == '') {
            $("#state").val(33);
        }

    } else if (type == 3) { // validate fields before insert a co-owner
        if ($("#civil_status_co").val() == null || $("#civil_status_co").val() == '') {
            $("#civil_status_co").val(7);
        }
        if ($("#matrimonial_regime_co").val() == null || $("#matrimonial_regime_co").val() == '') {
            $("#matrimonial_regime_co").val(5);
        }
        if ($("#state_co").val() == null || $("#state_co").val() == '') {
            $("#state_co").val(33);
        }
        if (($("#own_co").val() == null || $("#own_co").val() == '') && ($("#rented_co").val() == null || $("#rented_co").val() == '') && ($("#paying_co").val() == null || $("#paying_co").val() == '') && ($("#family_co").val() == null || $("#family_co").val() == '') && ($("#other_co").val() == null || $("#other_co").val() == '')) {
            $("#hidden").val(6);
        }
    }
}

function cleanFields(type) {
    /*
     * 1 insert prospect
     * 2 update prospect
     * 3 insert co-owner
     * 4 insert references
     */
    if (type == 1 || type == 2) {
        $("#nationality").val("");
        $("#nationality").selectpicker('refresh');
        $("#legal_personality").val("0");
        $("#legal_personality").selectpicker('refresh');
        $("#curp").val("");
        $("#rfc").val("");
        $("#name").val("");
        $("#last_name").val("");
        $("#mothers_last-name").val("");
        $("#email").val("");
        $("#phone_number").val("");
        $("#phone_number2").val("");
        $("#prospecting_place").val("0");
        $("#prospecting_place").selectpicker('refresh');
        $("#specify").val("");
        $("#specify-mkt").val("0");
        $("#specify-mkt").selectpicker('refresh');
        $("#advertising").val("0");
        $("#advertising").selectpicker('refresh');
        $("#sales-plaza").val("0");
        $("#sales-plaza").selectpicker('refresh');
        $("#comments").val("");
        $(".clean-field").addClass("is-empty");
    } else if (type == 3) {
        $("#nationality_co").val("");
        $("#legal_personality_co").val("");
        $("#rfc_co").val("");
        $("#date_birth_co").val("");
        $("#name_co").val("");
        $("#last_name_co").val("");
        $("#mothers_last_name_co").val("");
        $("#email_co").val("");
        $("#phone_number_co").val("");
        $("#phone_number2_co").val("");
        $("#civil_status_co").val("");
        $("#matrimonial_regime_co").val("");
        $("#spouce_co").val("");
        $("#street_name_co").val("");
        $("#ext_number_co").val("");
        $("#suburb_co").val("");
        $("#postal_code_co").val("");
        $("#town_cow").val("");
        $("#state_co").val("");
        $("#occupation_co").val("");
        $("#company_co").val("");
        $("#position_co").val("");
        $("#antiquity_co").val("");
        $("#company_antiquity_co").val("");
        $("#company_residence_co").val("");
        $("#nationality").val("");
    } else if (type == 4) {
        $("#name").val("");
        $("#phone_number").val("");
        $('#prospecto').val(null).trigger('change');
        $("#prospecto").selectpicker('refresh');
        $('#kinship').val(null).trigger('change');
        $("#kinship").selectpicker('refresh');
    }
}

function validateMatrimonialRegime(type) {
    /*
     * 1 insert prospect
     * 2 update prospect
     * 3 insert co-owner
     */
    if (type == 1 || type == 2) {
        mr = document.getElementById('matrimonial_regime');
        mr = mr.value;
        if (mr == 1) { // IS A CONJUGAL SOCIETY
            document.getElementById('spouce').removeAttribute("readonly");
        } else { // IT'S NOT A CONJUGAL SOCIETY
            $("#spouce").val("");
            document.getElementById('spouce').setAttribute("readonly", "true");
        }
    } else if (type == 3) {
        mr = document.getElementById('matrimonial_regime_co');
        mr = mr.value;
        if (mr == 1) { // IS A CONJUGAL SOCIETY
            document.getElementById('spouce_co').removeAttribute("readonly");
        } else { // IT'S NOT A CONJUGAL SOCIETY
            $("#spouce").val("");
            document.getElementById('spouce_co').setAttribute("readonly", "true");
        }
    }
}

function getAge(type) {
    // 1 insert
    // 2 update
    // 3 co-owner
    if (type == 1 || type == 2) {
        dateString = $("#date_birth").val();
    } else if (type == 3) {
        dateString = $("#date_birth_co").val();
    }
    today = new Date();
    birthDate = new Date(dateString);
    age = today.getFullYear() - birthDate.getFullYear();
    m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    if (type == 1 || type == 2) {
        $("#company_antiquity").val(age);
    } else if (type == 3) {
        $("#company_antiquity_co").val(age);
    }
}

// Validate prospect's legal personality
function validatePersonality() {
    lp = document.getElementById('legal_personality');
    lp = lp.value;
    if (lp == 1) {
        document.getElementById('curp').value = '';
        document.getElementById('last_name').value = '';
        document.getElementById('mothers_last_name').value = '';

        document.getElementById('curp').setAttribute("readonly", "true");
        document.getElementById('last_name').setAttribute("readonly", "true");
        document.getElementById('mothers_last_name').setAttribute("readonly", "true");
    } else if (lp == 2 || lp == 3) {
        document.getElementById('curp').removeAttribute("readonly");
        document.getElementById('last_name').removeAttribute("readonly");
        document.getElementById('mothers_last_name').removeAttribute("readonly");
    }
}

// Validate the prospecting place to see if it requires specification or not
function validateProspectingPlace() {
    pp = document.getElementById('prospecting_place');
    pp = pp.value;
    if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
        document.getElementById('specify_mkt').value = '';
        document.getElementById('specify_recommends').value = '';
        document.getElementById('type_recomendado').value = '0';
        $("#specify_recommends").removeAttr("required");
        $("#specify").removeAttr("style");
        document.getElementById('specify').removeAttribute("readonly");
        $("#specify_mkt").css({ "display": "none" });
        $("#specify_mkt_div").css({ "display": "none" });
        $("#specify_recommends").css({ "display": "none" });
        $("#specify_recommends").next(".select2-container").hide();

    } else if (pp == 6) { // SPECIFY MKTD OPTION
        document.getElementById('specify').value = '';
        document.getElementById('specify_recommends').value = '';
        document.getElementById('type_recomendado').value = '0';
        $("#specify_recommends").removeAttr("required");
        $("#specify").css({ "display": "none" });
        $("#specify_recommends").css({ "display": "none" });
        $("#specify_recommends").next(".select2-container").hide();
        $("#specify_mkt").removeAttr("style");
        $("#specify_mkt_div").removeAttr("style");
    } else{ // WITHOUT SPECIFICATION
        document.getElementById('specify').value = '';
        document.getElementById('specify_mkt').value = '';
        document.getElementById('specify_recommends').value = '';
        document.getElementById('type_recomendado').value = '0';
        document.getElementById('specify').setAttribute("readonly", "true");
        $("#specify_recommends").removeAttr("required");
        $("#specify_mkt").css({ "display": "none" });
        $("#specify_mkt_div").css({ "display": "none" });
        $("#specify_recommends").css({ "display": "none" });
        $("#specify_recommends").next(".select2-container").hide();
        $("#specify").removeAttr("style");
    }
}

function getPersonsWhoRecommends() {
    $.getJSON("getCAPListByAdvisor").done(function(data) {
        $("#specify_recommends").append($('<option disabled selected="true">').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            var type = data[i]['tipo'];
            $("#specify_recommends").append($('<option>').val(id).attr('data-type', type).text(name));
        }
    });
}

function fillFields(v, type) {
    /*
     * 0 update prospect
     * 1 see information modal
     * 2 update reference
     */
    if (type == 0) {
        $("#nationality").val(v.nacionalidad);
        $("#legal_personality").val(v.personalidad_juridica);
        $("#curp").val(v.curp);
        $("#rfc").val(v.rfc);
        $("#name").val(v.nombre);
        $("#last_name").val(v.apellido_paterno);
        $("#mothers_last_name").val(v.apellido_materno);
        $("#date_birth").val(v.fecha_nacimiento);
        $("#email").val(v.correo);
        $("#phone_number").val(v.telefono);
        $("#phone_number2").val(v.telefono_2);
        $("#civil_status").val(v.estado_civil);
        $("#matrimonial_regime").val(v.regimen_matrimonial);
        $("#spouce").val(v.conyuge);
        $("#from").val(v.originario_de);
        $("#home_address").val(v.domicilio_particular);
        $("#occupation").val(v.ocupacion);
        $("#company").val(v.empresa);
        $("#position").val(v.posicion);
        $("#antiquity").val(v.antiguedad);
        $("#company_antiquity").val(v.edadFirma);
        $("#company_residence").val(v.direccion);
        $("#prospecting_place").val(v.lugar_prospeccion);
        $("#advertising").val(v.medio_publicitario);
        $("#sales_plaza").val(v.plaza_venta);
        $("#observation").val(v.observaciones);
        if (v.tipo_vivienda == 1) {
            document.getElementById('own').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 2) {
            document.getElementById('rented').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 3) {
            document.getElementById('paying').setAttribute("checked", "true");
        } else if (v.tipo_vivienda == 4) {
            document.getElementById('family').setAttribute("checked", "true");
        } else {
            document.getElementById('other').setAttribute("checked", "true");
        }

        pp = v.lugar_prospeccion;
        if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
            $("#specify").val(v.otro_lugar);
        } else if (pp == 6) { // SPECIFY MKTD OPTION
            document.getElementById('specify_mkt').value = v.otro_lugar;
        } else if (pp == 21) { // RECOMMENDED SPECIFICATION
            document.getElementById('specify_recommends').value = v.otro_lugar;
        } else { // WITHOUT SPECIFICATION
            $("#specify").val("");
        }

    } else if (type == 1) {
        $("#nationality-lbl").val(v.nacionalidad);
        $("#legal-personality-lbl").val(v.personalidad_juridica);
        $("#curp-lbl").val(v.curp);
        $("#rfc-lbl").val(v.rfc);
        $("#name-lbl").val(v.nombre);
        $("#last-name-lbl").val(v.apellido_paterno);
        $("#mothers-last-name-lbl").val(v.apellido_materno);
        $("#email-lbl").val(v.correo);
        $("#phone-number-lbl").val(v.telefono);
        $("#phone-number2-lbl").val(v.telefono_2);
        $("#prospecting-place-lbl").val(v.lugar_prospeccion);
        $("#specify-lbl").html(v.otro_lugar);
        //$("#advertising-lbl").val(v.medio_publicitario);
        $("#sales-plaza-lbl").val(v.plaza_venta);
        $("#comments-lbl").val(v.observaciones);
        $("#asesor-lbl").val(v.asesor);
        $("#coordinador-lbl").val(v.coordinador);
        $("#gerente-lbl").val(v.gerente);
        $("#phone-asesor-lbl").val(v.tel_asesor);
        $("#phone-coordinador-lbl").val(v.tel_coordinador);
        $("#phone-gerente-lbl").val(v.tel_gerente);

    } else if (type == 2) {
        $("#prospecto_ed").val(v.id_prospecto).trigger('change');
        $("#prospecto_ed").selectpicker('refresh');
        $("#kinship_ed").val(v.parentesco).trigger('change');
        $("#kinship_ed").selectpicker('refresh');
        $("#name_ed").val(v.nombre);
        $("#phone_number_ed").val(v.telefono);
    }
}

function validateEmptyFields(v, type) {
    /*
     * 1 edit prospect
     * 2 edit reference
     */
    if (type === 1) {
        $(".select-is-empty").removeClass("is-empty");
        if (v.nombre != '') {
            $(".div-name").removeClass("is-empty");
        }
        if (v.apellido_paterno != '') {
            $(".div-last-name").removeClass("is-empty");
        }
        if (v.apellido_materno != '') {
            $(".div-mothers-last-name").removeClass("is-empty");
        }
        if (v.rfc != '') {
            $(".div-rfc").removeClass("is-empty");
        }
        if (v.curp != '') {
            $(".div-curp").removeClass("is-empty");
        }
        if (v.correo != '') {
            $(".div-email").removeClass("is-empty");
        }
        if (v.telefono != '') {
            $(".div-phone-number").removeClass("is-empty");
        }
        if (v.telefono_2 != '') {
            $(".div-phone-number2").removeClass("is-empty");
        }
        if (v.observaciones != '') {
            $(".div-observations").removeClass("is-empty");
        }
        if (v.otro_lugar != '') {
            $(".div-specify").removeClass("is-empty");
        }
        if (v.fecha_nacimiento != '') {
            $(".div-date-birth").removeClass("is-empty");
        }
        if (v.conyuge != '') {
            $(".div-spouce").removeClass("is-empty");
        }
        if (v.calle != '') {
            $(".div-street-name").removeClass("is-empty");
        }
        if (v.numero != '') {
            $(".div-ext-number").removeClass("is-empty");
        }
        if (v.colonia != '') {
            $(".div-suburb").removeClass("is-empty");
        }
        if (v.municipio != '') {
            $(".div-town").removeClass("is-empty");
        }
        if (v.codigo_postal != '') {
            $(".div-postal-code").removeClass("is-empty");
        }
        if (v.ocupacion != '') {
            $(".div-occupation").removeClass("is-empty");
        }
        if (v.empresa != '') {
            $(".div-company").removeClass("is-empty");
        }
        if (v.posicion != '') {
            $(".div-position").removeClass("is-empty");
        }
        if (v.antiguedad != '') {
            $(".div-antiquity").removeClass("is-empty");
        }
        if (v.edadFirma != '') {
            $(".div-company-antiquity").removeClass("is-empty");
        }
        if (v.domicilio != '') {
            $(".div-company-residence").removeClass("is-empty");
        }
    } else if (type === 2) {
        if (v.nombre != '') {
            $(".div-name").removeClass("is-empty");
        }
        if (v.telefono != '') {
            $(".div-phone-number").removeClass("is-empty");
        }
    }
}

function fillTimeline(v) {
    $("#comments-list").append('<li class="timeline-inverted">\n' +
        '    <div class="timeline-badge info"></div>\n' +
        '    <div class="timeline-panel">\n' +
        '            <label><h6>' + v.creador + '</h6></label>\n' +
        '            <br>' + v.observacion + '\n' +
        '        <h6>\n' +
        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + '</span>\n' +
        '        </h6>\n' +
        '    </div>\n' +
        '</li>');
}

function fillChangelog(v) {
    $("#changelog").append('<li class="timeline-inverted">\n' +
        '    <div class="timeline-badge success"></div>\n' +
        '    <div class="timeline-panel">\n' +
        '            <label><h6>' + v.parametro_modificado + '</h6></label><br>\n' +
        '            <b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n' +
        '        <h6>\n' +
        '            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + ' - ' + v.creador + '</span>\n' +
        '        </h6>\n' +
        '    </div>\n' +
        '</li>');
}

/*VALIDAR ESTAS*/

function getRecommendationData() {
    type = $("#specify_recommends option:selected").attr('data-type');
    $("#type_recomendado").val(type);
}

function showSpecificationObject() {
    pp = document.getElementById('prospecting_place');
    pp = pp.value;
    if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
        $("#specify").removeAttr("style");
    } else if (pp == 6) { // SPECIFY MKTD OPTION
        $("#specify_mkt").removeAttr("style");
    } else if (pp == 21) { // RECOMMENDED SPECIFICATION
        $("#specify_recommends").removeAttr("style");
    } else { // WITHOUT SPECIFICATION
        $("#specify").removeAttr("style");
    }
}

function validateInputs(t){
    let id_input = t.id;
    let value = t.value;
}

function validateCoincidences(){
    if (coincidencias >= 2){
        $(".box-alert").css("display", "block");
        $('.btn-next').prop('disabled', true);
    }
    else{
        $(".box-alert").css("display", "none");
        $('.btn-next').prop('disabled', false);
    }
}

//validacion de select 
function validateSelect(id_elemento) {
    elemento_select = document.getElementById(id_elemento);
    index_elemento = elemento_select.selectedIndex;
    if(index_elemento >= 0)
        $("#"+id_elemento).parent('div').parent('div').removeClass("has-error");
}