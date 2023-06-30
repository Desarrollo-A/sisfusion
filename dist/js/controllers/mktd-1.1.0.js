$(document).ready( function() {

    $("#myselectgerente").empty().selectpicker('refresh');
    $("#myselectasesor2").empty().selectpicker('refresh');

    $.post('getAdvisersM', function(data) {
        $("#myselectasesor2").append($('<option disabled>').val("default").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor2").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if(len<=0)
        {
            $("#myselectasesor2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectasesor2").selectpicker('refresh');
    }, 'json');

    // Set options for myselectgerente
    $.post('getManagersMktd', function(data) {
        $("#myselectgerente").append($('<option disabled>').val("default").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectgerente").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if(len<=0)
        {
            $("#myselectgerente").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectgerente").selectpicker('refresh');
    }, 'json');

});

$(document).on('click', '.see-comments', function(e){
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#seeCommentsModal").modal();

    $.getJSON("getComments/"+id_prospecto).done( function( data ){
        counter = 0;
        data.length > 0 ? data = data : data[0] = {creador:'', fecha_creacion: '', observacion: '<b>SIN COMENTARIOS</b>'};
        $.each( data, function(i, v){
            counter ++;
            fillTimeline(v, counter);
        });
    });

    $.getJSON("getChangelog/"+id_prospecto).done( function( data ){
        $.each( data, function(i, v){
            fillChangelog(v);
        });
    });

});

function cleanComments() {
    var myCommentsList = document.getElementById('comments-list');
    if( myCommentsList != null )
        myCommentsList.innerHTML = '';

    var myChangelog = document.getElementById('changelog');
    if( myChangelog != null )
        myChangelog.innerHTML = '';
}

function fillTimeline (v) {
    let etiqueta_creador = v.creador !== '' 
                            ?`<label><h6>${v.creador}</h6></label><br>`
                            : '';

    let etiqueta_fecha = v.fecha_creacion !== '' 
                        ? `<h6><span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>${v.fecha_creacion}</span></h6>`
                        : '';
    $("#comments-list")
        .append(`<li class="timeline-inverted">
                    <div class="timeline-badge success"></div>
                    <div class="timeline-panel">
                        ${etiqueta_creador}
                        ${v.observacion}
                        ${etiqueta_fecha}
                    </div>
                </li>`);
}

function fillChangelog (v) {
    $("#changelog").append(
        '<li class="timeline-inverted">\n' +
            '<div class="container-fluid">'+
                '<div class="row>'+
                    '<div class="timeline-panel">\n' +
                        '<div class="col-sm-6 col-md-6 col-lg-6 p-0"><a>Campo: '+v.parametro_modificado+'</a><br></div>\n' +
                        '<div class="col-sm-6 col-md-6 col-lg-6 text-right"><a class="float-end"> '+v.fecha_creacion+'</a></div>\n' +
                        '<p class="m-0">USUARIO: <b>'+v.creador+' </b></p>'+
                        '<p class="m-0">CAMPO ANTERIOR:<b> '+v.anterior+'</b></p>'+                       
                        '<p class="m-0">CAMPO NUEVO:<b> '+v.nuevo+'</b></p>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</li>');
}

    $(document).on('click', '.to-comment', function(e){
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#myCommentModal").modal();
    $("#comment").val("");
    $("#id_prospecto").val(id_prospecto);
    $(".label-floating").removeClass("is-empty");
});


$("#my-comment-form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveComment',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myCommentModal').modal("hide");
                $('#observations').val('');
               $('#prospects-datatable_dir').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "El comentario se ha ingresado exitosamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.edit-information', function(e){
    id_prospecto = $(this).attr("data-id-prospecto");
    $.getJSON("getProspectInformation/"+id_prospecto).done( function( data ){
        $.each( data, function(i, v){
            $("#myEditModal").modal();
            fillFields(v, 0);
            validateEmptyFields(v, 1);
            $("#id_prospecto_ed").val(id_prospecto);
            showSpecificationObject();
        });
    });
});

function fillFields (v, type) {
 
    if (type == 0){
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
        }  else { // WITHOUT SPECIFICATION
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

    } else if (type == 2){
        $("#prospecto_ed").val(v.id_prospecto).trigger('change');
        $("#prospecto_ed").selectpicker('refresh');
        $("#kinship_ed").val(v.parentesco).trigger('change');
        $("#kinship_ed").selectpicker('refresh');
        $("#name_ed").val(v.nombre);
        $("#phone_number_ed").val(v.telefono);
    }
}

$("#my-edit-form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            // Actions before send post
            //validateEmptySelects(2);
            //enableSelects(2);
        },
        success: function(data) {
            if (data == 1) {
                $('#myEditModal').modal("hide");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#prospects-datatable_dir').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});



function validateEmptyFields (v, type) {
  
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

function showSpecificationObject() {
    pp = document.getElementById('prospecting_place');
    pp = pp.value;
    if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
        $("#specify").removeAttr("style");
    } else if (pp == 6) { // SPECIFY MKTD OPTION
        $("#specify_mkt").removeAttr("style");
    } else if (pp == 21) { // RECOMMENDED SPECIFICATION
        $("#specify_recommends").removeAttr("style");
    }  else { // WITHOUT SPECIFICATION
        $("#specify").removeAttr("style");
    }
}


$(document).on('click', '.see-information', function(e){
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#seeInformationModal").modal();
    $("#prospecto_lbl").val(id_prospecto);

    $.getJSON("getInformationToPrint/"+id_prospecto).done( function( data ){
        $.each( data, function(i, v){
            fillFields(v, 1);
        });
    });

    $.getJSON("getComments/"+id_prospecto).done( function( data ){
        counter = 0;
        $.each( data, function(i, v){
            counter ++;
            fillTimeline(v, counter);
        });
    });

    $.getJSON("getChangelog/"+id_prospecto).done( function( data ){
        $.each( data, function(i, v){
            fillChangelog(v);
        });
    });

});

function printProspectInfoMktd() {
    id_prospecto =  $("#prospecto_lbl").val();
    window.open( "printProspectInfoMktd/"+id_prospecto, "_blank")
}

function printProspectInfo() {
    id_prospecto =  $("#prospecto_lbl").val();
    window.open( "printProspectInfo/"+id_prospecto, "_blank")
}

$(document).on('click', '.re-asign', function(e){
    id_prospecto = $(this).attr("data-id-prospecto");
    console.log(id_prospecto);
    if (userType == 3 || userType == 6) { // Gerente & asistente de ventas
        $("#myReAsignModalVentas").modal();
        $("#id_prospecto_re_asign_ve").val(id_prospecto);
    } else if(userType == 19) { // Subdirector MKTD
        $("#myReAsignModalSubMktd").modal();
        $("#id_prospecto_re_asign_sm").val(id_prospecto);
    }  else if(userType == 20) { // Gerente MKTD
        $("#myReAsignModalGerMktd").modal();
        $("#id_prospecto_re_asign_gm").val(id_prospecto);
    }
    //id_prospecto = $(this).attr("data-id-prospecto");
    //$("#myReAsignModal").modal();
    //$("#id_prospecto_re_asign").val(id_prospecto);
});


function getCoordinatorsByManager(element) {
    gerente = $('option:selected', element).val();
    $("#myselectcoordinador").find("option").remove();
    $("#myselectcoordinador").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getCoordinatorsByManager/'+gerente, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectcoordinador").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if(len<=0)
        {
            $("#myselectcoordinador").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectcoordinador").selectpicker('refresh');
    }, 'json');
}


function getAdvisersByCoordinator(element) {
    coordinador = $('option:selected', element).val();
    $("#myselectasesor3").find("option").remove();
    $("#myselectasesor3").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getAdvisersByCoordinator/'+coordinador, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor3").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if(len<=0)
        {
            $("#myselectasesor3").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectasesor3").selectpicker('refresh');
    }, 'json');
}

$("#my_reasign_form_ve").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'reasignProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myReAsignModalVentas').modal("hide");
                $('#prospects-datatable_dir').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La reasignación se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.update-status', function(e){
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#myUpdateStatusModal").modal();
    $("#id_prospecto_estatus_particular").val(id_prospecto);
});

function cleanSelects() {
    $('#estatus_particular').val("0");
    $("#estatus_particular").selectpicker("refresh");
}

$("#my_update_status_form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateStatus',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateStatusModal').modal("hide");
                $('#prospects-datatable_dir').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
                $('#estatus_particular').val("0");
                $("#estatus_particular").selectpicker("refresh");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

  // Fill the select of matrimonial regime
    $.getJSON("getMatrimonialRegime").done( function( data ){
        $(".matrimonial_regime").append($('<option selected="true">').val("0").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".matrimonial_regime").append($('<option>').val(id).text(name));
        }
    });

function validateCivilStatus(type){
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
        }  else { // IT'S NOT MARRIED
            $("#matrimonial_regime").val("0");
            $("#spouce").val("");
            document.getElementById('matrimonial_regime').setAttribute("disabled", "true");
            document.getElementById('spouce').setAttribute("disabled", "true");
        }
    } else if (type == 3) {
        cs = document.getElementById('civil_status_co');
        cs = cs.value;
        if (cs == 4) { // IS MARRIED
            document.getElementById('matrimonial_regime_co').removeAttribute("disabled");
        }  else { // IT'S NOT MARRIED
            $("#matrimonial_regime_co").val("0");
            $("#spouce_co").val("");
            document.getElementById('matrimonial_regime_co').setAttribute("disabled", "true");
            document.getElementById('spouce_co').setAttribute("disabled", "true");
        }
    }
}

// Validate prospect's legal personality
function validatePersonality(){
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



    // Set options for myselectgerente
    $.post('getManagersMktd', function(data) {
        $("#myselectgerente").append($('<option disabled>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectgerente").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if(len<=0)
        {
            $("#myselectgerente").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectgerente").selectpicker('refresh');
    }, 'json');


function getAdvisers(element) {
    sede = $('option:selected', element).attr('data-sede');
    $("#myselectasesor").find("option").remove();
    $("#myselectasesor").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getAdvisers/'+sede, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if(len<=0)
        {
            $("#myselectasesor").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectasesor").selectpicker('refresh');
    }, 'json');
} 

$("#my_reasign_form_sm").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'reasignProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            // Actions before send post
        },
        success: function(data) {
            if (data == 1) {
                $('#myReAsignModalSubMktd').modal("hide");
                $('#prospects-datatable_dir').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La reasignación se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});


    $.post('getStatusMktd', function(data) {
        $("#estatus_particular").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for( var i = 0; i<len; i++)
        {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatus_particular").append($('<option>').val(id).text(name));
        }
        if(len<=0)
        {
            $("#estatus_particular").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatus_particular").selectpicker('refresh');
    }, 'json');

function cleanCombos() {
    $("#specify").val("0");
    $("#specify_mkt").val("0");
    $("#specify_recommends").val("0");

    $("#specify").css({ "display" : "none"});
    $("#specify_mkt").css({ "display" : "none"});
    $("#specify_recommends").css({ "display" : "none"});
}

$(document).on('click', '.update-validity', function() {
    $.ajax({
        type: 'POST',
        url: 'updateValidity',
        data: {'id_prospecto': $(this).attr("data-id-prospecto")},
        dataType: 'json',
        success: function(data){
            if( data == 1 ){
                alerts.showNotification("top", "right", "La vigencia de tu prospecto se ha renovado exitosamente.", "success");
               $('#prospects-datatable_dir').DataTable().ajax.reload(null, false);
            }else{
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },error: function( ){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});