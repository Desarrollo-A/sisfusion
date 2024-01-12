$(document).ready(function() {
	$(".select-is-empty").removeClass("is-empty");

    console.log("wer")
    $.getJSON("getCAPListByAdvisor").done(function(data) {
        $("#specify_recommends").append($('<option>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            var type = data[i]['tipo'];
            $("#specify_recommends").append($('<option>').val(id).attr('data-type', type).text(name));
        }
    });

        // Fill the select of prospecting places
    $.getJSON("getProspectingPlaces").done(function(data) {
        $(".prospecting_place").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".prospecting_place").append($('<option>').val(id).text(name));
        }
    }); 

    $.getJSON("getNationality").done(function(data) {
        $(".nationality").append($('<option disabled selected>').val("").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".nationality").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of legal personality
    $.getJSON("getLegalPersonality").done(function(data) {
        $(".legal_personality").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".legal_personality").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of advertising
    $.getJSON("getAdvertising").done(function(data) {
        $(".advertising").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".advertising").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of sales plaza
    $.getJSON("getSalesPlaza").done(function(data) {
        $(".sales_plaza").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".sales_plaza").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of civil status
    $.getJSON("getCivilStatus").done(function(data) {
        $(".civil_status").append($('<option selected="true">').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".civil_status").append($('<option>').val(id).text(name));
        }
    });

    // Fill the select of matrimonial regime
    $.getJSON("getMatrimonialRegime").done(function(data) {
        $(".matrimonial_regime").append($('<option selected="true">').val("5").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".matrimonial_regime").append($('<option>').val(id).text(name));
        }
    });
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
            // Actions before send post
            //validateEmptySelects(1);
            //enableSelects(1);
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

$("#my-comment-form").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveComment',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myCommentModal').modal("hide");
                $('#observations').val('');
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "El comentario se ha ingresado exitosamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my_reasign_form_sm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'reasignProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myReAsignModalSubMktd').modal("hide");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La reasignación se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my_reasign_form_gm").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'reasignProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myReAsignModalGerMktd').modal("hide");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La reasignación se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my_reasign_form_ve").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'reasignProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myReAsignModalVentas').modal("hide");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La reasignación se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function validateFile() {
    if ($('#prospecting_place').val() == '' || $('#prospecting_place').val() == null ||
        $('#sales_plaza').val() == '' || $('#sales_plaza').val() == null ||
        $('#asesor_prospecto').val() == '' || $('#asesor_prospecto').val() == null) {
        console.log('vals 5');
        alerts.showNotification('top', 'right', 'Debes ingresar los campos requeridos', 'danger');

    } else {
        $('#confirmar').modal('toggle');
    }
    /*console.log('emtro aqui');
    if($('#prospecting_place').val() == 6  && $('#specify_mkt').val()=='Recomendado')
    {
        console.log('Entro aqui II');
        if( document.getElementById("archivo_evidencia").files.length == 0 ){
            alerts.showNotification('top', 'right', 'DEBES SELECCIONAR UN ARCHIVO', 'danger');

        }
        else
        {
            if($('#prospecting_place').val()=='' ||  $('#prospecting_place').val() == null ||
                $('#sales_plaza').val() =='' || $('#sales_plaza').val() == null ||
                $('#asesor_prospecto').val()=='' || $('#asesor_prospecto').val() == null)
            {
                console.log('vals 3');
                alerts.showNotification('top', 'right', 'Debes ingresar los campos requeridos', 'danger');

            }
            else
            {
                $('#confirmar').modal('toggle');
            }
        }
    }
    else
    {
        console.log('vals 4');
        if($('#prospecting_place').val()=='' ||  $('#prospecting_place').val() == null ||
            $('#sales_plaza').val() =='' || $('#sales_plaza').val() == null ||
            $('#asesor_prospecto').val()=='' || $('#asesor_prospecto').val() == null)
        {
            console.log('vals 5');
            alerts.showNotification('top', 'right', 'Debes ingresar los campos requeridos', 'danger');

        }
        else {
            $('#confirmar').modal('toggle');
        }
    }*/
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
        /* if (($("#own").val() == null || $("#own").val() == '') && ($("#rented").val() == null || $("#rented").val() == '') && ($("#paying").val() == null || $("#paying").val() == '') && ($("#family").val() == null || $("#family").val() == '') && ($("#other").val() == null || $("#other").val() == '')) {
             $("#hidden").val(6);
         }*/
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

function validateCivilStatus(type) {
    /*
     * 1 insert prospect
     * 2 update prospect
     * 3 insert co-owner
     */
    if (type == 1 || type == 2) {
        cs = document.getElementById('civil_status');
        cs = cs.value;
        if (cs == 4) { // IS MARRIED
            document.getElementById('matrimonial_regime').removeAttribute("disabled");
        } else { // IT'S NOT MARRIED
            $("#matrimonial_regime").val("5");
            $("#spouce").val("");
            document.getElementById('matrimonial_regime').setAttribute("disabled", "true");
            document.getElementById('spouce').setAttribute("disabled", "true");
        }
    } else if (type == 3) {
        cs = document.getElementById('civil_status_co');
        cs = cs.value;
        if (cs == 4) { // IS MARRIED
            document.getElementById('matrimonial_regime_co').removeAttribute("disabled");
        } else { // IT'S NOT MARRIED
            $("#matrimonial_regime_co").val("5");
            $("#spouce_co").val("");
            document.getElementById('matrimonial_regime_co').setAttribute("disabled", "true");
            document.getElementById('spouce_co').setAttribute("disabled", "true");
        }
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
    console.log("entra a la función de validación");
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
    } else if (pp == 21) { // RECOMMENDED SPECIFICATION
        document.getElementById('specify').value = '';
        document.getElementById('specify_mkt').value = '';
        $("#specify").css({ "display": "none" });
        $("#specify_mkt").css({ "display": "none" });
        $("#specify_recommends").removeAttr("style");
        $("#specify_recommends").css({ "required": "true" });
        $("#specify_recommends").select2();
        getPersonsWhoRecommends();
    } else { // WITHOUT SPECIFICATION
        document.getElementById('specify').value = '';
        document.getElementById('specify_mkt').value = '';
        document.getElementById('specify_recommends').value = '';
        document.getElementById('type_recomendado').value = '0';
        document.getElementById('specify').setAttribute("readonly", "true");
        $("#specify_recommends").removeAttr("required");
        $("#specify_mkt").css({ "display": "none" });
        $("#specify_recommends").css({ "display": "none" });
        $("#specify_recommends").next(".select2-container").hide();
        $("#specify").removeAttr("style");
    }
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
        //document.getElementById("observations").innerHTML = v.observaciones;
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
        console.log(pp);
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
    //colours = ["success", "danger", "warning", "info", "rose"];
    //colourSelected = colours[Math.floor(Math.random() * colours.length)];
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

$(document).on('click', '.edit-reference-information', function(e) {
    id_referencia = $(this).attr("data-id-referencia");
    $.getJSON("getReferenceInformation/" + id_referencia).done(function(data) {
        $.each(data, function(i, v) {
            $("#editReferencesModal").modal();
            fillFields(v, 2);
            validateEmptyFields(v, 2);
            $("#id_referencia").val(id_referencia);
        });
    });
});

$(document).on('click', '.change-reference-status', function() {
    estatus = $(this).attr("data-estatus");
    $.ajax({
        type: 'POST',
        url: 'changeReferenceStatus',
        data: { 'id_referencia': $(this).attr("data-id-referencia"), 'estatus': $(this).attr("data-estatus") },
        dataType: 'json',
        success: function(data) {
            if (data == 1) {
                if (estatus == 1) {
                    alerts.showNotification("top", "right", "Se ha activado con éxito.", "success");
                } else {
                    alerts.showNotification("top", "right", "Se ha desactivado con éxito.", "success");
                }
                $referencesTable.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.edit-information', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $.getJSON("getProspectInformation/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            $("#myEditModal").modal();
            fillFields(v, 0);
            validateEmptyFields(v, 1);
            $("#id_prospecto_ed").val(id_prospecto);
            showSpecificationObject();
        });
    });
});

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
        //document.getElementById("observations").innerHTML = v.observaciones;
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
        console.log(pp);
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
