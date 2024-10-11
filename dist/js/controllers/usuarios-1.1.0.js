$(document).ready( function() {
    construirHead("all_users_datatable")
    $('[data-toggle="tooltip"]').tooltip(); 
    code = '';
    $.getJSON("fillSelectsForUsers").done(function(data) {
        for (let i = 0; i < data.length; i++) {

            if (data[i]['id_catalogo'] == 16){
                $("#payment_method").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                }

            if (data[i]['id_catalogo'] == 1)
                $("#member_type").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));

            if (data[i]['id_catalogo'] == 0){
                $("#headquarter").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            }
        }
        $('#payment_method').selectpicker('refresh');
        $('#headquarter').selectpicker('refresh');
        $('#member_type').selectpicker('refresh');
    });
    $(".select-is-empty").removeClass("is-empty");
    fillUsersTable();
});

//DESCARGAR BT-EXCEL
function translationsUserTable() {
    onChangeTranslations(function() {
        $('#all_users_datatable').DataTable().rows().invalidate().draw(false);
        
    });
}

function fillUsersTable() {
    const $allUsersTable = $('#all_users_datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Listado de usuarios',
            title: _("lista-usuarios"),
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8],
                format: {
                    header:  function (d, columnIdx) {
                        return $(d).attr('placeholder').toUpperCase();
                    }
                }
            }
        }],
        ordering: false,
        paging: true,
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        columns: [{
            data: function (d) {
                if (d.estatus == 1) {
                    return '<center><span class="label lbl-green" data-i18n="activo">ACTIVO</span><center>';
                } else if (d.estatus == 3) {
                    return '<center><span class="label lbl-orangeYellow" data-i18n="inactivo-comisionado">INACTIVO COMISIONADO</span><center>';
                    return '<center><span class="label lbl-orangeYellow" data-i18n="inactivo-comisionado">INACTIVO COMISIONADO</span><center>';
                } else {
                    return '<center><span class="label lbl-warning" data-i18n="inactivo">INACTIVO</span><center>';
                }
            }
        },
        {
            data: function (d) {
                return d.id_usuario;
            }
        },
        {
            data: function (d) {
                return d.nombre;
            }
        },
        {
            data: function (d) {
                return d.correo;
            }
        },
        {
            data: function (d) {
                return d.telefono;
            }
        },
        {
            data: function (d) {
                var propiedadExtra = '';
                let factorEstatus = '';
                if(d.puesto == 'Asesor' && d.simbolico==1){
                    propiedadExtra = '<br><label class="label lbl-sky" data-i18n="simbolico">SIMBÓLICO</label>';
                }
                if(d.fac_humano == 1) {
                    factorEstatus = '<br><label class="label lbl-violetBoots" data-i18n="factor-humano">FACTOR HUMANO</label>';
                }
                return d.puesto + propiedadExtra + factorEstatus;
            }
        },
        {
            data: function (d) {
                return `<span class="label ${d.colorTipo}">${d.tipoUsuario}</span> `; 
            }
        },
        {
            data: function (d) {
                return d.sede;
            }
        },
        {
            data: function (d) {
                return d.jefe_directo == '  ' ? '<span data-i18n="no-aplica"> NO APLICA </span>' : d.jefe_directo;
            }
        },
        {
            data: function (d) {
                var id_rol = id_rol_global;
                if(id_rol == 8 && d.estatus == 1){
                    if (id_usuario_general == 1297 || id_usuario_general == 1) { 
                        // filtro para soporte excluyendo ambos perfiles
                        return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas edit-user-information" data-rol="'+d.id_rol+'" data-toggle="tooltip"  data-placement="top" data-i18n-label="editar-informacion" title="EDITAR INFORMACIÓN" data-id-usuario="' + d.id_usuario +'"> '+
                        '<i class="fas fa-pencil-alt"></i></button><button class="btn-data btn-orangeYellow  see-changes-log"  data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip"  data-placement="top" data-i18n-label="bitacora-cambios" title="CONSULTA LA INFORMACIÓN" ><i class="fas fa-eye"></i> </button>' +
                            '<button class="btn-data btn-warning change-user-status"  id="' + d.id_usuario +'" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-name="'+d.nombre+'" data-rol="'+d.puesto+'" data-idrol="'+d.id_rol+'" data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="dar-baja" title="DAR DE BAJA"><i class="fas fa-lock"></i></button>'+
                            '</div>';
                        } 
                        else {
                            //TODO SOPORTE
                            return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" data-i18n-label="editar-informacion" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="'+d.id_rol+'" data-id-usuario="' + d.id_usuario +'"><i class="fas fa-pencil-alt"></i></button><button data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="bitacora-cambios" title="BITÁCORA DE CAMBIOS"class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' +
                            '<button data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="dar-baja" title="DAR DE BAJA" class="btn-data btn-warning change-user-status"  id="' + d.id_usuario +'" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-name="'+d.nombre+'" data-rol="'+d.puesto+'" data-idrol="'+d.id_rol+'"><i class="fas fa-lock"></i></button></div>';
                        }
                    }
                else {
                    if (id_usuario_general == 1297 || id_usuario_general == 1) {
                        return '<div class="d-flex justify-center"><button data-toggle="tooltip" data-placement="top" data-i18n-tooltip="editar-informacion" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="'+d.id_rol+'" data-id-usuario="' + d.id_usuario +'"><i class="fas fa-pencil-alt"></i></button><button data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="bitacora-cambios" title="BITACORA DE CAMBIOS" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' ;
                        }
                        else {
                            if (id_usuario_general != 1297 || id_usuario_general != 1  ) {
                                let bt = ``;
                                if (id_usuario_general != 16621)
                                    bt =  '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="editar-informacion" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="'+d.id_rol+'" data-id-usuario="' + d.id_usuario +'"><i class="fas fa-pencil-alt"></i></button>' +
                                    '<button  class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="editar-informacion" data-i18n-tooltip="bitacora-cambios" title="BITACORA DE CAMBIOS" ><i class="fas fa-eye"></i> </button>' ;
                                else
                                    bt = '<div class="d-flex justify-center"><button  class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="editar-informacion" data-i18n-tooltip="bitacora-cambios" title="BITACORA DE CAMBIOS" ><i class="fas fa-eye"></i> </button>' ;
                                    if ((d.puesto == 'Asesor' || d.puesto == 'Coordinador de ventas' || d.puesto == 'Gerente') && (id_rol != 6 && id_rol != 5 && id_rol != 4)) {
                                }
                                else {
                                    if(d.estatus == 1){
                                        bt += '<button class="btn-data btn-warning change-user-status" id="' + d.id_usuario +'" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-name="'+d.nombre+'" data-rol="'+d.puesto+'" data-idrol="'+d.id_rol+'" data-toggle="tooltip"  data-placement="top" title="'+_("dar-baja")+'"><i class="fas fa-lock-open"></i></button>';
                                    }
                                    else{
                                        bt += '';
                                    }
                                }
                                bt += '</div>';
                                return bt;
                            }
                        if(id_rol == 8 && id_usuario_general != 1297 && d.puesto == 'Contraloría' && d.estatus == 0){
                            return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="'+_('bitacora-cambios')+'"data-i18n-tooltip="bitacora-cambios" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' + '<button data-toggle="tooltip"  data-placement="top" title="DAR DE ALTA" class="btn-data btn-green change-user-status" id="' + d.id_usuario +'" data-estatus="1" data-id-usuario="' + d.id_usuario +'" data-name="'+d.nombre+'" data-rol="'+d.puesto+'" data-idrol="'+d.id_rol+'"><i class="fas fa-lock-open"></i></button>'+ '</div>';
                        }
                    }
                }
                if (id_rol == 53) {
                    return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="'+_('bitacora-cambios')+'"data-i18n-tooltip="bitacora-cambios" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' ;
                } else if (id_rol == 41) {
                    return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="'+_('editar-informacion')+'"data-i18n-tooltip="editar-informacion" class="btn-data btn-blueMaderas edit-user-information" data-rol="' + d.id_rol + '" data-id-usuario="' + d.id_usuario + '"><i class="fas fa-pencil-alt"></i></button>' +
                            '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="'+_('bitacora-cambios')+'"data-i18n-tooltip="bitacora-cambios" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' +
                        '</div>';
                } else if(id_rol_general==25){
                    return '';
                }
                else{
                    if (d.estatus == 1) {
                        return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="editar-informacion" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="' + d.id_rol + '" data-id-usuario="' + d.id_usuario + '"><i class="fas fa-pencil-alt"></i></button>' +
                            '<button data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="bitacora-cambios" data-i18n-tooltip="bitacora-cambios" title="BITÁCORA DE CAMBIOS" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario + '" ><i class="fas fa-eye"></i> </button>' +
                            '<button data-toggle="tooltip"  data-placement="top" data-i18n-tooltip="dar-baja" title="DAR DE BAJA" class="btn-data btn-warning change-user-status" id="' + d.id_usuario + '" data-estatus="0" data-id-usuario="' + d.id_usuario + '" data-name="' + d.nombre + '" data-rol="' + d.puesto + '" data-idrol="'+d.id_rol+'"><i class="fas fa-lock"></i></button>'+ '</div>';
                        } 
                        else {
                        if (d.puesto == 'Asesor' || d.puesto == 'Coordinador de ventas' || d.puesto == 'Gerente') {
                            return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top"title="'+_('editar-informacion')+'"data-i18n-tooltip="editar-informacion" class="btn-data btn-blueMaderas  edit-user-information" data-rol="' + d.id_rol + '" data-id-usuario="' + d.id_usuario + '"><i class="fas fa-pencil-alt"></i></button>' +
                                '<button data-toggle="tooltip"  data-placement="top" title="'+_('bitacora-cambios')+'"data-i18n-tooltip="bitacora-cambios" class="btn-data btn-orangeYellow see-changes-log" data-id-usuario="' + d.id_usuario + '" ><i class="fas fa-eye"></i></button>' +
                                '</div>';
                            }
                            else {
                            return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas  edit-user-information" data-rol="' + d.id_rol + '" data-id-usuario="' + d.id_usuario + '" data-toggle="tooltip"  data-placement="top" title="'+_('editar-informacion')+'"data-i18n-tooltip="editar-informacion" ><i class="fas fa-pencil-alt"></i></button>' +
                                '<button class="btn-data btn-orangeYellow see-changes-log" data-id-usuario="' + d.id_usuario + '" data-toggle="tooltip"  data-placement="top" title="'+_('bitacora-cambios')+'"data-i18n-tooltip="bitacora-cambios" ><i class="fas fa-eye"></i></button>' +
                                '<button class="btn-data btn-warning change-user-status" id="' + d.id_usuario + '" data-estatus="1" data-id-usuario="' + d.id_usuario + '" data-name="' + d.nombre + '" data-rol="' + d.puesto + '" data-idrol="'+d.id_rol+'" data-toggle="tooltip"  data-placement="top" title="DAR DE BAJA"><i class="fas fa-lock"></i></button>' +
                                '</div>';
                        }
                    }
                }
            }
        }],
        ajax: {
            url: "getUsersList",
            type: "POST",
            cache: false,
            data: function (d) {}
        }
    });
    if(id_rol_general == 54){
        let arrayNOView = [8];
        $allUsersTable.columns(arrayNOView).visible(false);
    }

    applySearch($allUsersTable);
}

$('#all_users_datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
});
translationsUserTable();


function showPassword() {
    if ($("#contrasena").attr("type") == "password") $("#contrasena").attr("type", "text");
    else $("#contrasena").attr("type", "password");
    $("#showPass i").toggle();
}

$("#my_personal_info_form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updatePersonalInformation',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                alerts.showNotification("top", "right",_("informacion-actualizada-correctamente"), "success");
                setTimeout(function() {
                    document.location.reload()
                }, 3000);
            } else {
                alerts.showNotification("top", "right", _("campos-minimos"), "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", _("algo-salio-mal"), "danger");
        }
    });
});

$("#my_add_user_form").on('submit', function(e){
    e.preventDefault();
    let flagSubmit = validarNuevoUsuario();
    if (flagSubmit){
        $.ajax({
            type: 'POST',
            url: 'saveUser',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data) {
                data = JSON.parse(data);
                if (data.response == 1) {
                    alerts.showNotification("top", "right", _("usuario-registrado"), "success");
                    setTimeout(function() {
                        document.location.reload();
                    }, 3000);
                } else if(data.response == -1){
                    alerts.showNotification("top", "right", _("usuario-ya-existe"), "warning");
                    $('#username').focus();
                } else if(data.response == -2){
                    alerts.showNotification("top", "right", _("selecciona-opciones-menu"), "warning");
                    $('#seleccionaTodo').focus();
                }else{
                    alerts.showNotification("top", "right", _("campos-llenos-requeridos"), "warning");
                }
            },
            error: function(){
                alerts.showNotification("top", "right", _("algo-salio-mal"), "danger");
            }
        });
    }
});

function getLeadersList(){
    headquarter = $('#headquarter').val();
    type = $('#member_type').val();
    if(id_rol_general==4 || id_rol_general==5 || id_rol_general==6){
        if(type==7){
            $('#tipoMiembro_column').removeClass('col-sm-6');
            $('#tipoMiembro_column').addClass('col-sm-3');
            $('#simbolico_column').removeClass('hide');
        }else{
            $('#tipoMiembro_column').removeClass('col-sm-3');
            $('#tipoMiembro_column').addClass('col-sm-6');
            $('#simbolico_column').addClass('hide');
        }
    }

    $("#leader").find("option").remove();
    $.post('getLeadersList/'+headquarter+'/'+type, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            $("#leader").append($('<option>').val(id).text(name));
        }
        if(len<=0){
            $("#leader").append('<option selected="selected" value="0">NA</option>');
        }
        $('#leader').selectpicker('refresh');
    }, 'json');
}

function getLeadersListForEdit(headquarter, type, leader){
    $("#leader").find("option").remove();
    $.post('getLeadersList/'+headquarter+'/'+type, function(data) {
        var len = data.length;
        for( var i = 0; i<len; i++){
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            if(id == leader){
                $("#leader").append($('<option selected>').val(id).text(name));
                $("#lastLI").val(id);
            } else{
                $("#leader").append($('<option>').val(id).text(name));
            }
        }
        if(len<=0)
        {
            $("#leader").append('<option selected="selected" value="0">NA</option>');
        }
        $('#leader').selectpicker('refresh');
    }, 'json');
}

function cleadFieldsHeadquarterChange(){
    $("#leader").find("option").remove();
    $("#member_type").val("");
    $('#member_type').selectpicker('refresh');
    $('#leader').selectpicker('refresh');
}

function CloseModalBaja(){
    document.getElementById('nameUs').innerHTML = '';
    $('#id_user').val(0);
    $('#idrol').val(0);
    document.getElementById('motivo').innerHTML = '';
    $('#BajaUserForm')[0].reset();
    $('#BajaUser').modal("hide");
}

function BajaConfirmM(){
    document.getElementById('msj').innerHTML = '';
    document.getElementById('nameUs2').innerHTML = '';
    $('#iduser').val(0);
    $('#id_rol').val(0);
    $('#status').val(0);
    $('#BajaConfirmForm')[0].reset();
    $('#BajaConfirm').modal("hide");
}

$("#BajaUserForm").on('submit', function(e){
    e.preventDefault();
    document.getElementById('btnS').disabled = true;
    $.ajax({
        type: 'POST',
        url: 'changeUserStatus',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if( data == 1 ){
                if (estatus == 1) {
                    alerts.showNotification("top", "right", _("activar-usuario-mensaje"), "success");
                } else {
                    alerts.showNotification("top", "right", _("desactivar-usuario-mensaje"), "success");
                }
                CloseModalBaja();
                $allUsersTable.ajax.reload();
            }else{
                alerts.showNotification("top", "right", _("campos-llenos-requeridos"), "warning");
            }
            document.getElementById('btnS').disabled = false;
        },
        error: function(){
            document.getElementById('btnS').disabled = false;
            alerts.showNotification("top", "right", _("algo-salio-mal"), "danger");
        }
    });
});

$(document).on('click', '.buscar-pass-user', function(e){
    id_usuario = $(this).attr("data-id-usuario");
    $.getJSON("getUserInformation/"+id_usuario).done( function( data ){
        $.each( data, function(i, v){
            let leader;
            var inputNombre = document.getElementById("usuarioPC");
            inputNombre.value =  v.usuario;
            var inputpass = document.getElementById("passPC");
            inputpass.value =  v.contrasena;
            if (v.id_rol == 9)
                leader = v.gerente_id
            else if (v.id_rol == 3)
                leader = v.subdirector_id
            else
                leader = v.id_lider;
        });
    });
    $("#modalData").modal();
});

$("#BajaConfirmForm").on('submit', function(e){
    e.preventDefault();
    document.getElementById('btnSub').disabled = true;
    $.ajax({
        type: 'POST',
        url: 'changeUserStatus',
        data: {'id_user': $('#iduser').val(), 'estatus': $('#status').val()},
        dataType: 'json',
        success: function(data){
            BajaConfirmM();
            if( data == 1 ){
                if (estatus == 1) {
                    alerts.showNotification("top", "right", _("activar-usuario-mensaje-1"), "success");
                } else {
                    alerts.showNotification("top", "right", _("desactivar-usuario-mensaje-1"), "success");
                }
                $allUsersTable.ajax.reload();
            }else{
                alerts.showNotification("top", "right", _("campos-llenos-requerido"), "warning");
            }
            document.getElementById('btnSub').disabled = false;
        },error: function( ){
            BajaConfirmM();
            document.getElementById('btnSub').disabled = false;
            alerts.showNotification("top", "right", _("algo-salio-mal"), "danger");
        }
    });
});

$(document).on('click', '.change-user-status', function(e) {
    e.preventDefault();
    id_user = $(this).attr("data-id-usuario");
    $('#'+id_user+'').prop('disabled', true);
    estatus = $(this).attr("data-estatus");
    id_rol = $(this).attr("data-rol");
    idRol = $(this).attr("data-idrol");
    nameUser = $(this).attr("data-name");
    let roles = [3,7,9,'3','9','7'];
    if(estatus == 0 && roles.includes(idRol)){
        // document.getElementById('nameUs').innerHTML = '';
        $('#id_user').val(0);
        $('#idrol').val(0);
        // document.getElementById('nameUs').innerHTML = nameUser;
        $('#id_user').val(id_user);
        $('#idrol').val(id_rol);
        $("#BajaUser").modal();
    }else{
        document.getElementById('nameUs2').innerHTML = '';
        document.getElementById('msj').innerHTML = '';
        $('#iduser').val(0);
        $('#id_rol').val(0);
        $('#status').val(0);
        if(estatus == 0){
            document.getElementById('msj').innerHTML = '<span data-i18n="seguro-dar-baja">¿Está seguro que desea dar de baja a </span>';
            document.getElementById('nameUs2').innerHTML = nameUser;
            $('#iduser').val(id_user);
            $('#id_rol').val(id_rol);
            $('#status').val(estatus);
            $("#BajaConfirm").modal();
        }else{
            document.getElementById('msj').innerHTML = '<span data-i18n="seguro-dar-alta">¿Está seguro que desea dar de alta a </span>';
            document.getElementById('nameUs2').innerHTML = nameUser;
            $('#iduser').val(id_user);
            $('#id_rol').val(id_rol);
            $('#status').val(estatus);
            $("#BajaConfirm").modal();
        }
    }
    $('#'+id_user+'').prop('disabled', false);
});

$(document).on('click', '.edit-user-information', function(e){
    id_usuario = $(this).attr("data-id-usuario");
    $('#btn_acept').prop('disabled', false);
    $('.simbolico_column').html('');
    $('.col-estructura').html('');
    $('.fac_humano_column').html('');
    $.getJSON("getUserInformation/"+id_usuario).done( function( data ){
        $.each( data, function(i, v){
            const ventas = [7,1,2,3,9];
            const isLargeNumber = (element) => element == v.id_rol;
            if(ventas.findIndex(isLargeNumber) >= 0 && id_rol_global == 8){
                $('#btn_acept').addClass('hide');
            }else{
                $('#btn_acept').removeClass('hide');
            }
            let leader = v.id_lider;

            if (v.id_rol == '7' || v.id_rol == '9' || v.id_rol == '3') { // ASESOR || COORDINADOR || GERENTE
                var row = $('.col-estructura');
                row.append(`
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">${_("nueva-estructura")}(<small class="isRequired">*</small>)</label>
                            <select class="selectpicker select-gral m-0" id="nueva_estructura" name="nueva_estructura" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n-label="selecciona-una-opcion" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                <option value="0" ${ (v.nueva_estructura == 0 || v.nueva_estructura != null ) ? 'checked' : ''}>No</option>
                                <option value="1" ${ (v.nueva_estructura == 1 || v.nueva_estructura != null ) ? 'checked' : ''} data-i18n="si">Sí</option>
                            </select>
                        </div>
                    </div>
                `);
                let row_fac_humano = $('.fac_humano_column');
                    row_fac_humano.append(`
                        <div class="col-sm-6 mt-3">
                        <div class="form-group label-floating select-is-empty div_membertype">
                            <label class="control-label"><small class="isRequired">*</small>${_("asesor-factor-humano")}</label>
                            <select class="selectpicker select-gral m-0" id="fac_humano" name="fac_humano" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n-label="selecciona-una-opcion" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                <option value="1" ${ (v.fac_humano == 1 || v.fac_humano == '1' ) ? 'selected' : ''} data-i18n="si">SÍ</option>
                                <option value="0" ${ (v.fac_humano == 0 || v.fac_humano == '0' || v.fac_humano == null ) ? 'selected' : ''}>NO</option>
                            </select>
                        </div>
                        </div></div>`);       
            }$('#fac_humano').selectpicker('refresh');

            if(id_rol_general == 4 || id_rol_general == 5 || id_rol_general==6){
                if (v.id_rol == '7' ){
                    $('#tipoMiembro_column').removeClass('col-sm-6');
                    $('#tipoMiembro_column').addClass('col-sm-3');
                    var row_add = $('.simbolico_column');
                    row_add.append(`
                    <div class="col-sm-3 mt-3">
                        <div class="form-group label-floating select-is-empty div_membertype">
                            <label class="control-label"><small class="isRequired">*</small>${_("asesor-simbolico")}</label>
                            <select class="selectpicker select-gral m-0" id="simbolicoType" name="simbolicoType" data-style="btn" data-show-subtext="true" data-live-search="true" data-i18n-label="selecciona-simbolico" title="Seleccione sí es simbolíco" data-size="7" data-container="body" required>
                                <option value="1" ${ (v.simbolico == 1 || v.simbolico == '1' ) ? 'selected' : ''} data-i18n="si">SÍ</option>
                                <option value="0" ${ (v.simbolico == 0 || v.simbolico == '0' || v.simbolico == null ) ? 'selected' : ''}>NO</option>
                            </select>
                        </div>
                    </div></div>`);

                  
                }else{
                    $('#tipoMiembro_column').removeClass('col-sm-3');
                    $('#tipoMiembro_column').addClass('col-sm-6');
                }
                $('#simbolicoType').selectpicker('refresh');
            }
            $('#nueva_estructura').selectpicker('refresh');
            getLeadersListForEdit(v.id_sede, v.id_rol, leader);
            $("#editUserModal").modal();

            $("#div-info").html(`<div class="boxIcon" data-html="true" data-toggle="tooltip" data-placement="bottom" title="${_("sede-capital-info")}">
                                    <i class="fas fa-info"></i>
                                </div>`);
            fillFields(v);
            validateEmptyFields(v);
        });
    });
});

$(document).on('change', '#sedech', function() {
    let id_sede = $('#sedech').val();
    $("#sucursal").empty();
    $("#sucursal").append($('<option disabled selected>').val("").text(_("selecciona-una-opcion")));
    $.getJSON("getSucursalCH/"+id_sede).done( function( data ){
        var select = document.getElementsByName('sucursal')[0];
        if(data.data.length > 0){
            $('#sucursal').prop('required', true);
        }else{
            document.getElementById("sucursal").removeAttribute("required");
        }
        $.each( data.data, function(i, v){
            var option = document.createElement("option");
            option.text = v.nom_oficina;
            option.value = v.idsucursal;
            select.add(option);
        });
        $('#sucursal').selectpicker('refresh');
    });
});

function getSedesCH(sede = 0,sucursal = 0){
    $('#spiner-loader').removeClass('hide');
    $('#sedech').selectpicker('refresh');
    $("#sedech").empty();
    sede == 0 ?  $("#sedech").append($('<option disabled selected>').val("").text(_("selecciona-una-opcion"))) : '';
    $('#sedech').prop('required', true);
    $.getJSON("getSedesCH").done( function( data ){
        $('#spiner-loader').addClass('hide');
        var select = document.getElementsByName('sedech')[0];
        $.each( data.data, function(i, v){
            if(v.idsede != 7){
                var option = document.createElement("option");
                option.text = v.nom_sede;
                option.value = v.idsede;
                select.add(option);
                if(v.idsede == sede){
                    $('#sedech').val(v.idsede);
                    $.getJSON("getSucursalCH/"+sede).done( function( data2 ){
                        var select = document.getElementsByName('sucursal')[0];
                        $.each( data2.data, function(i, v){
                                var option = document.createElement("option");
                                option.text = v.nom_oficina;
                                option.value = v.idsucursal;
                                select.add(option);
                                if(v.idsucursal == sucursal){
                                    $('#sucursal').selectpicker('refresh');
                                    $('#sucursal').selectpicker('val',v.idsucursal);
                                }
                        });
                    });
                }
            }
        });
        $('#sedech').selectpicker('refresh');
    });
}

function fillFields (v) {
    $("#id_usuario").val(v.id_usuario);
    $("#name").val(v.nombre);
    $("#last_name").val(v.apellido_paterno);
    $("#mothers_last_name").val(v.apellido_materno);
    $("#rfc").val(v.rfc);
    $("#payment_method").val(v.forma_pago);
    $("#email").val(v.correo);
    $("#phone_number").val(v.telefono);
    $("#headquarter").val(v.id_sede);
    $("#member_type").val(v.id_rol);
    let rol_asignado = v.id_rol;
    if (v.id_rol == 2 && (v.id_usuario == 3 || v.id_usuario == 5 || v.id_usuario == 607 || v.id_usuario == 4 ))
        $("#member_type option[value=2]").text(_("director-regional"));
    else if (v.id_rol == 2 && (v.id_usuario != 3 || v.id_usuario != 5 || v.id_usuario != 607))
        $("#member_type option[value=2]").text("SUBDIRECTOR");
    $("#lastTM").val(v.id_rol);
    $("#talla").val(v.talla == null ? 0 : v.talla);
    $("#sexo").val(v.sexo == null ? 'S' : v.sexo);
    $("#hijos").val(v.tiene_hijos == null ? 'NO' : v.tiene_hijos);
    $("#noHijos").val(v.hijos_12 == null ? 0 : v.hijos_12);
    $('#payment_method').selectpicker('refresh');
    $('#headquarter').selectpicker('refresh');
    $('#member_type').selectpicker('refresh');
    $('#sexo').selectpicker('refresh');
    $('#hijos').selectpicker('refresh');
    $('#nueva_estructura').val(v.nueva_estructura).selectpicker('refresh');
    if(rol_asignado == 7 || rol_asignado== 3 || rol_asignado == 9 ){
        $('#ch').show();
        document.getElementById("sedech").removeAttribute("required");
        $("#sedech").empty();
        document.getElementById("sucursal").removeAttribute("required");
        $("#sucursal").empty();
        /*if(v.sedech == null) {
            getSedesCH();
        } else {
            getSedesCH(v.sedech,v.sucursalch);
        }*/
        $('#sedech').selectpicker('refresh');
        if (v.nueva_estructura == 1) {
            $("#member_type option[value=7]").text(_("asesor-financiero"));
            $("#member_type option[value=9]").text(_("lider-comercial"));
            $("#member_type option[value=3]").text(_("embajador"));
        } else {
            $("#member_type option[value=7]").text(_("asesor"));
            $("#member_type option[value=9]").text(_("coordinador-ventas"));
            $("#member_type option[value=3]").text(_("gerente"));
        }
    } else {
        $('#ch'). hide();
        document.getElementById("sedech").removeAttribute("required");
        $("#sedech").empty();
        document.getElementById("sucursal").removeAttribute("required");
        $("#sucursal").empty();
    }

    // RADIO TIPO USUARIO
    if (parseInt(v.tipo) == 1) // NORMAL
    $('input:radio[name=tipoUsuario]')[0].checked = true;
    else if (parseInt(v.tipo) == 2) // MADERAS UPGRADE
    $('input:radio[name=tipoUsuario]')[1].checked = true;
    else if (parseInt(v.tipo) == 3) // CASAS
    $('input:radio[name=tipoUsuario]')[2].checked = true;
    else if (parseInt(v.tipo) == 4) // SEGUROS
    $('input:radio[name=tipoUsuario]')[3].checked = true;

    $("#rol_actual").val(rol_asignado);
    $("#username").val(v.usuario);
    $("#contrasena").val(v.contrasena);
}

function validateEmptyFields (v) {
    if (v.nombre != '')
        $(".div_name").removeClass("is-empty");
    if (v.apellido_paterno != '')
        $(".div_last_name").removeClass("is-empty");
    if (v.apellido_materno != '')
        $(".div_mothers_last_name").removeClass("is-empty");
    if (v.rfc != '')
        $(".div_rfc").removeClass("is-empty");
    if (v.forma_pago != '')
        $(".div_payment_method").removeClass("is-empty");
    if (v.correo != '')
        $(".div_email").removeClass("is-empty");
    if (v.telefono != '')
        $(".div_phone_number").removeClass("is-empty");
    if (v.id_sede != '')
        $(".div_headquarter").removeClass("is-empty");
    if (v.id_rol != '')
        $(".div_membertype").removeClass("is-empty");
    if (v.id_lider != '')
        $(".div_leader").removeClass("is-empty");
    if (v.hijos_12 == '')
        $(".div_nohijos").removeClass("is-empty");
    if (v.talla != '')
        $(".div_talla").removeClass("is-empty");
}

$("#editUserForm").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateUser',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
        },
        success: function(data) {
            data = JSON.parse(data);
            if (data.respuesta == 1) {
                $allUsersTable.ajax.reload();
                $('#editUserModal').modal("hide");
                alerts.showNotification("top", "right", _("registro-actualizado"), "success");
            } else if (data.respuesta == 0) {
                alerts.showNotification("top", "right", data.message, "warning");
            } else {
                alerts.showNotification("top", "right", _("campos-llenos-requeridos"), "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", _("algo-salio-mal"), "danger");
            alerts.showNotification("top", "right", _("algo-salio-mal"), "danger");
        }
    });
});

$(document).on('click', '.see-changes-log', function(){
    id_usuario = $(this).attr("data-id-usuario");
    document.getElementById('changelogUsers').innerHTML = '';
    $.post("getChangeLogUsers/"+id_usuario).done( function( data ){
        $("#changesRegsUsers").modal();
        $.each( JSON.parse(data), function(i, v){
            fillChangelogUsers(v);
        });
    });
});

function fillChangelogUsers(v) {
    var nombreMovimiento;
    var dataMovimiento;
    document.getElementById('changelogUsers').innerHTML = '';
    switch (v.col_afect) {
        case 'nombre':
            nombreMovimiento = 'Nombre';
            dataMovimiento = '<b data-i18n="valor-anterior">Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'apellido_paterno':
            nombreMovimiento = 'Apellido paterno';
            dataMovimiento = '<b data-i18n="valor-anterior">Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b data-i18n="valor-nuevo">Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'apellido_materno':
            nombreMovimiento = 'Apellido materno';
            dataMovimiento = '<b data-i18n="valor-anterior">Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'contrasena':
            nombreMovimiento = 'Contraseña';
            dataMovimiento = '<span data-i18n="cambio-contrasena">Cambio de Contraseña';
        break;
        case 'telefono':
            nombreMovimiento = 'Teléfono';
            dataMovimiento = '<b data-i18n="valor-anterior">Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b data-i18n="valor-nuevo">Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'imagen_perfil':
            nombreMovimiento = 'Imagen de perfil';
            dataMovimiento = '<b data-i18n="valor-anterior">Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b data-i18n="valor-nuevo">Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'forma_pago':
            nombreMovimiento = 'Forma de pago';
            dataMovimiento = '<b data-i18n="valor-anterior">Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b data-i18n="valor-nuevo">Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        default:
            nombreMovimiento = v.col_afect;
            dataMovimiento = '<b data-i18n="valor-anterior">Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b data-i18n="valor-nuevo">Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
    }

    $("#changelogUsers").append('<li>\n' +
    '    <div class="container-fluid">\n' +
    '       <div class="row">\n' +
    '           <div class="col-md-6">\n' +
    '               <a><span>'+_("campo")+' </span><b> ' +v.col_afect.toUpperCase()+ '</b></a><br>\n' +
    '           </div>\n' +
    '<div class="float-end text-right">\n' +
    '               <a>' + v.fecha_creacion + '</a>\n' +
    '           </div>\n' +
    '           <div class="col-md-12">\n' +
    '                <p class="m-0"><span >'+ _("usuario") +': </span><b> ' + v.creador + '</b></p>\n'+
    '                <p class="m-0"><span>'+ _("ultimo-valor") +'</span><b> ' + v.anterior.toUpperCase() + '</b></p>\n' +
    '                <p class="m-0"><span>'+ _("nuevo-valor") +'</span><b> ' + v.nuevo.toUpperCase() + '</b></p>\n' +
    '           </div>\n' +
    '        <h6>\n' +
    '        </h6>\n' +
    '       </div>\n' +
    '    </div>\n' +
        '</li>');
}

$(document).on('change', '#nueva_estructura', function() {
    if ($(this).val() == 1) {
        $("#member_type option[value=7]").text(_("asesor-financiero"));
        $("#member_type option[value=9]").text(_("lider-comercial"));
        $("#member_type option[value=3]").text(_("embajador"));
    } else {
        $("#member_type option[value=7]").text(_("asesor"));
        $("#member_type option[value=9]").text(_("coordinador-ventas"));
        $("#member_type option[value=3]").text(_("gerente"));
    }
    $("#member_type").val('').selectpicker("refresh");
    $("#leader").val('').selectpicker("refresh");
});