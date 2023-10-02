
var puestos = [{id : 59, nombre : 'Director regional'}], sedes = []; 
$(document).ready( function() { 
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
                sedes.push({
                    id : data[i]['id_opcion'],
                    nombre : data[i]['nombre']
                });
            }
        }
        $('#payment_method').selectpicker('refresh');
        $('#headquarter').selectpicker('refresh');
        $('#member_type').selectpicker('refresh');
    });
    $(".select-is-empty").removeClass("is-empty");
    fillUsersTable();
});

$(document).on('change', '#leader', function() {
    let sede = $('#headquarter').val();
    let puesto = $('#member_type').val();
    let lider = $('#leader').val();
    document.getElementById('lineaVenta').innerHTML = '';
    let puestosVentas = [3,7,9];
    let sedeSelected = document.getElementById("headquarter");
    let selectedSede = sedeSelected.options[sedeSelected.selectedIndex].text;
    let puestoSelected = document.getElementById("member_type");
    let selectedPuesto = puestoSelected.options[puestoSelected.selectedIndex].text;
    let nombreSelected = $('#name').val() + ' ' + $('#last_name').val() + ' ' + $('#mothers_last_name').val();
    if(puestosVentas.includes(parseInt(puesto))){
        $.post("consultarLinea",{
            sede: sede,
            puesto: puesto,
            lider : lider
        },
        function (data) {
        let sedesSinRegional = [5,2,3,6];
        let arraySedes = puesto == 7 ? ( data[0].banderaGer == 0 ? [data[0].idSedeCoor,data[0].idSedeGer,data[0].idSedeSub,data[0].idSedeReg] : [data[0].idSedeGer,data[0].idSedeSub,data[0].idSedeReg]) : ( puesto == 9 ? sedesSinRegional.includes(parseInt(sede)) ? [data[0].idSedeGer,data[0].idSedeSub] : [data[0].idSedeGer,data[0].idSedeSub,data[0].idSedeReg] : sedesSinRegional.includes(parseInt(sede)) ? [data[0].idSedeSub] : [data[0].idSedeSub,data[0].idSedeReg]);
    let buscarDiff = arraySedes.filter(element => element != sede);
    if(buscarDiff.length > 0){
        $('#btn_acept').prop('disabled', true);
    }else{
        $('#btn_acept').prop('disabled', false);
    }

    let tabla = `
    <div class="row subBoxDetail">
        <div class=" col-sm-12 col-sm-12 col-lg-12 text-center" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>NUEVA LÍNEA DE VENTAS</b></label></div>
        <div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label><b>Nombre </b></label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label><b>Puesto</b></label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label><b>Sede</b></label></div>
        <div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label>${nombreSelected}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${selectedPuesto}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${selectedSede}</label></div>`;
        tabla += puesto == 7  ? `<div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label>${data[0].coordinador}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${data[0].puestoCoor}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${data[0].sedeCoor}</label></div>` : '';
        tabla += puesto == 3 ? '' : `<div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label>${data[0].gerente}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${data[0].puestoGer}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${data[0].sedeGerente}</label></div>`;
        tabla += `<div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label>${data[0].sub}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${data[0].puestoSub}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${data[0].sedeSubdirector}</label></div>`;
        tabla += sedesSinRegional.includes(parseInt(sede)) ? '' : `<div class="col-2 col-sm-12 col-md-6 col-lg-6 text-center"><label>${data[0].regional_1}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${data[0].puestoReg}</label></div><div class="col-2 col-sm-12 col-md-3 col-lg-3 text-center"><label>${data[0].sedeReg}</label></div>`;
        tabla += `</div>`;
        $('#lineaVenta').append(tabla);
        },"json");
    }
});
$(document).on('change', '#member_type', function() {
    document.getElementById('lineaVenta').innerHTML = '';
    //MOC: SI SE DETECTA UN SUBDIRECTOR Ó DIR. REGIONAL AGREGAR OPCIÓN DE MULTIROL
    if($(this).val() == 2 || $(this).val() == 59){
        $('#btnmultirol').append(`
        <button class="btn-data btn-green" type="button" id="btnMultiRol" data-toggle="tooltip" data-placement="top" title="Agregar rol"><i class="fas fa-user-plus"></i></button>
        `);
    }else{
        document.getElementById('btnmultirol').innerHTML = '';
        document.getElementById('multirol').innerHTML = '';
        $('#index').val(0);
    }
});
function validarSede(indexActual){
    let index = parseInt($('#index').val());
    let c = 0;
    for (let j = 0; j < index; j++) {
        if(document.getElementById(`sedes_${j}`)){
            if(j != indexActual){
                let sedeActual = $(`#sedes_${indexActual}`).val();
                let sedes = $(`#sedes_${j}`).val();
                if(sedeActual == sedes){
                    c++;
                    alerts.showNotification("top", "right", "LA SEDE SELECCIONADA YA FUE SELECCIONADA", "warning");
                    $('#btn_acept').prop('disabled', true);
                }
            }
        }
    }
    if(c == 0){
        $('#btn_acept').prop('disabled', false);
    }
}

$(document).on("click","#btnMultiRol",function(){
    let index = parseInt($('#index').val());
    $('#multirol').append(`
            <div class="col-md-12 aligned-row" id="mult_${index}">
                <div class="col-md-6 pr-0 pr-0">
                    <div class="form-group text-left m-0">
                        <label class="control-label">Tipo de miembro (<small class="isRequired">*</small>)</label>
                        <select class="selectpicker select-gral m-0" name="multi_${index}" id="multi_${index}" data-style="btn"
                        data-show-subtext="true"
                        title="Selecciona una opción"
                        data-size="7"
                        data-live-search="true" data-container="body"
                        ></select>
                    </div>
                </div>
                <div class="col-md-4 pr-0 pr-0">
                    <div class="form-group text-left m-0">
                        <label class="control-label">Sede (<small class="isRequired">*</small>)</label>
                        <select class="selectpicker select-gral m-0" onchange="validarSede(${index},'sedes_');" name="sedes_${index}" id="sedes_${index}" data-style="btn"
                        data-show-subtext="true"
                        title="Selecciona una opción"
                        data-size="7"
                        data-live-search="true" data-container="body"
                        ></select>
                    </div>
                </div>
                <div class="col-md-2 justify-center d-flex align-end">
                    <div class="form-group m-0 p-0">
                        <button class="btn-data btn-warning mb-1" type="button" onclick="borrarMulti(${index})" data-toggle="tooltip" data-placement="top" title="Eliminar rol"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `);
        $('[data-toggle="tooltip"]').tooltip();
        for (var i = 0; i < puestos.length; i++) {
            var id = puestos[i].id;
            var name = puestos[i].nombre;
            $(`#multi_${index}`).append($('<option>').val(id).text(name.toUpperCase()));
        }
        for (var i = 0; i < sedes.length; i++) {
            var id = sedes[i].id;
            var name = sedes[i].nombre;
            $(`#sedes_${index}`).append($('<option>').val(id).text(name.toUpperCase()));
        }
        $(`#multi_${index}`).selectpicker('refresh');
        $(`#sedes_${index}`).selectpicker('refresh');
        index = parseInt(index + 1);
        $('#index').val(index);
});

$("#deleteRol").on('submit', function(e){
    let indice = $('#indice').val();
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'borrarMulti',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){},
        success: function(data) {
            if (data == true) {
                alerts.showNotification("top", "right", "El rol se ha eliminado correctamente", "success");
                $('#modalDelRol').modal('toggle');
                document.getElementById(`mult_${indice}`).innerHTML = '';
                document.getElementById("deleteRol").reset();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});
function borrarMulti(index,id = ''){
    if( id != ''){
        $('#idRU').val(id);
        $('#indice').val(index);
        $('#modalDelRol').modal('show');
    }else{
        document.getElementById(`mult_${index}`).innerHTML = '';
    }
    
  }
let titulos = [];
$('#all_users_datatable thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#all_users_datatable').DataTable().column(i).search() !== this.value) {
            $('#all_users_datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

function fillUsersTable() {
    $allUsersTable = $('#all_users_datatable').DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Listado de usuarios',
            title: 'Listado de usuarios',
            exportOptions: {
                columns:  (id_rol_general==54) ? [0, 1, 2, 3, 4, 5, 6, 7] : [0, 1, 2, 3, 4, 5, 6, 7],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
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
                    return '<center><span class="label lbl-green">ACTIVO</span><center>';
                } else if (d.estatus == 3) {
                    return '<center><span class="label lbl-orangeYellow">INACTIVO COMISIONADO</span><center>';
                } else {
                    return '<center><span class="label lbl-warning">INACTIVO</span><center>';
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
                if(d.puesto == 'Asesor' && d.simbolico==1){
                    propiedadExtra = '<br><label class="label lbl-sky">SIMBÓLICO</label>';
                }
                return d.puesto + propiedadExtra;
            }
        },
        {
            data: function (d) {
                return d.sede;
            }
        },
        {
            data: function (d) {
                return d.jefe_directo == '  ' ? 'NO APLICA' : d.jefe_directo;
            }
        },
        {
            data: function (d) {
                var id_rol = id_rol_global;
                if(id_rol == 8 && d.estatus == 1){
                    if (id_usuario_general == 1297 || id_usuario_general == 1) { 
                        // filtro para soporte excluyendo ambos perfiles
                        return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas edit-user-information" data-rol="'+d.id_rol+'" data-toggle="tooltip"  data-placement="top" title="EDITAR INFORMACIÓN" data-id-usuario="' + d.id_usuario +'"> '+
                        '<i class="fas fa-pencil-alt"></i></button><button class="btn-data btn-orangeYellow  see-changes-log"  data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip"  data-placement="top" title="CONSULTA LA INFORMACIÓN" ><i class="fas fa-eye"></i> </button>' +
                            '<button class="btn-data btn-warning change-user-status"  id="' + d.id_usuario +'" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-name="'+d.nombre+'" data-rol="'+d.puesto+'" data-idrol="'+d.id_rol+'" data-toggle="tooltip"  data-placement="top" title="DAR DE BAJA"><i class="fas fa-lock"></i></button>'+
                            '</div>';
                        } 
                        else {
                            //TODO SOPORTE
                            return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="'+d.id_rol+'" data-id-usuario="' + d.id_usuario +'"><i class="fas fa-pencil-alt"></i></button><button data-toggle="tooltip"  data-placement="top" title="BITÁCORA DE CAMBIOS"class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' +
                            '<button data-toggle="tooltip"  data-placement="top" title="DAR DE BAJA" class="btn-data btn-warning change-user-status"  id="' + d.id_usuario +'" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-name="'+d.nombre+'" data-rol="'+d.puesto+'" data-idrol="'+d.id_rol+'"><i class="fas fa-lock"></i></button></div>';
                        }
                    }
                else {
                    if (id_usuario_general == 1297 || id_usuario_general == 1) {
                        return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="'+d.id_rol+'" data-id-usuario="' + d.id_usuario +'"><i class="fas fa-pencil-alt"></i></button><button data-toggle="tooltip"  data-placement="top" title="BITACORA DE CAMBIOS" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' ;
                        }
                        else {
                            if (id_usuario_general != 1297 || id_usuario_general != 1  ) {
                                let bt = ``;
                                bt =  '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="'+d.id_rol+'" data-id-usuario="' + d.id_usuario +'"><i class="fas fa-pencil-alt"></i></button>' +
                                '<button  class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" data-toggle="tooltip"  data-placement="top" title="BITACORA DE CAMBIOS" ><i class="fas fa-eye"></i> </button>' ;
                                if ((d.puesto == 'Asesor' || d.puesto == 'Coordinador de ventas' || d.puesto == 'Gerente') && (id_rol != 6 && id_rol != 5 && id_rol != 4)) {
                                }
                                else {
                                    if(d.estatus == 1){
                                        bt += '<button class="btn-data btn-warning change-user-status" id="' + d.id_usuario +'" data-estatus="0" data-id-usuario="' + d.id_usuario +'" data-name="'+d.nombre+'" data-rol="'+d.puesto+'" data-idrol="'+d.id_rol+'" data-toggle="tooltip"  data-placement="top" title="DAR DE BAJA"><i class="fas fa-lock-open"></i></button>';
                                    }
                                    else{
                                        bt += '';
                                    }
                                }
                                bt += '</div>';
                                return bt;
                            }
                        if(id_rol == 8 && id_usuario_general != 1297 && d.puesto == 'Contraloría' && d.estatus == 0){
                            return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="BITÁCORA DE CAMBIOS" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' + '<button data-toggle="tooltip"  data-placement="top" title="DAR DE ALTA" class="btn-data btn-green change-user-status" id="' + d.id_usuario +'" data-estatus="1" data-id-usuario="' + d.id_usuario +'" data-name="'+d.nombre+'" data-rol="'+d.puesto+'" data-idrol="'+d.id_rol+'"><i class="fas fa-lock-open"></i></button>'+ '</div>';
                        }
                    }
                }
                if (id_rol == 53) {
                    return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="BITÁCORA DE CAMBIOS" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' ;
                } else if (id_rol == 41) {
                    return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="' + d.id_rol + '" data-id-usuario="' + d.id_usuario + '"><i class="fas fa-pencil-alt"></i></button>' +
                            '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="BITÁCORA DE CAMBIOS" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario +'" ><i class="fas fa-eye"></i> </button>' +
                        '</div>';
                } else if(id_rol_general==25){
                    return '';
                }
                else{
                    if (d.estatus == 1) {
                        return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas edit-user-information" data-rol="' + d.id_rol + '" data-id-usuario="' + d.id_usuario + '"><i class="fas fa-pencil-alt"></i></button>' +
                            '<button data-toggle="tooltip"  data-placement="top" title="BITÁCORA DE CAMBIOS" class="btn-data btn-orangeYellow  see-changes-log" data-id-usuario="' + d.id_usuario + '" ><i class="fas fa-eye"></i> </button>' +
                            '<button data-toggle="tooltip"  data-placement="top" title="DAR DE BAJA" class="btn-data btn-warning change-user-status"  id="' + d.id_usuario + '" data-estatus="0" data-id-usuario="' + d.id_usuario + '" data-name="' + d.nombre + '" data-rol="' + d.puesto + '" data-idrol="'+d.id_rol+'"><i class="fas fa-lock"></i></button>'+ '</div>';
                        } 
                        else {
                        if (d.puesto == 'Asesor' || d.puesto == 'Coordinador de ventas' || d.puesto == 'Gerente') {
                            return '<div class="d-flex justify-center"><button data-toggle="tooltip"  data-placement="top" title="EDITAR INFORMACIÓN" class="btn-data btn-blueMaderas  edit-user-information" data-rol="' + d.id_rol + '" data-id-usuario="' + d.id_usuario + '"><i class="fas fa-pencil-alt"></i></button>' +
                                '<button data-toggle="tooltip"  data-placement="top" title="BITÁCORA DE CAMBIOS" class="btn-data btn-orangeYellow see-changes-log" data-id-usuario="' + d.id_usuario + '" ><i class="fas fa-eye"></i></button>' +
                                '</div>';
                            }
                            else {
                            return '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas  edit-user-information" data-rol="' + d.id_rol + '" data-id-usuario="' + d.id_usuario + '" data-toggle="tooltip"  data-placement="top" title="EDITAR INFORMACIÓN"><i class="fas fa-pencil-alt"></i></button>' +
                                '<button class="btn-data btn-orangeYellow see-changes-log" data-id-usuario="' + d.id_usuario + '" data-toggle="tooltip"  data-placement="top" title="BITÁCORA DE CAMBIOS" ><i class="fas fa-eye"></i></button>' +
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
}

$('#all_users_datatable').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
});

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
                alerts.showNotification("top", "right", "La información se ha actualizado correctamente.", "success");
                setTimeout(function() {
                    document.location.reload()
                }, 3000);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my_add_user_form").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveUser',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "El usuario se ha registrado correctamente.", "success");
                setTimeout(function() {
                    document.location.reload()
                }, 3000);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
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
                    alerts.showNotification("top", "right", "Se ha activado con éxito.", "success");
                } else {
                    alerts.showNotification("top", "right", "Se ha desactivado con éxito.", "success");
                }
                CloseModalBaja();
                $allUsersTable.ajax.reload();
            }else{
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
            document.getElementById('btnS').disabled = false;

        },
        error: function(){
            document.getElementById('btnS').disabled = false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
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
                    alerts.showNotification("top", "right", "Se ha activado con éxito.", "success");
                } else {
                    alerts.showNotification("top", "right", "Se ha desactivado con éxito.", "success");
                }
                $allUsersTable.ajax.reload();
            }else{
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
            document.getElementById('btnSub').disabled = false;
        },error: function( ){
            BajaConfirmM();
            document.getElementById('btnSub').disabled = false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
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
        document.getElementById('nameUs').innerHTML = '';
        $('#id_user').val(0);
        $('#idrol').val(0);
        document.getElementById('nameUs').innerHTML = nameUser;
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
            document.getElementById('msj').innerHTML = '¿Está seguro que desea dar de baja a ';
            document.getElementById('nameUs2').innerHTML = nameUser;
            $('#iduser').val(id_user);
            $('#id_rol').val(id_rol);
            $('#status').val(estatus);
            $("#BajaConfirm").modal();
        }else{
            document.getElementById('msj').innerHTML = '¿Está seguro que desea dar de alta a ';
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
    document.getElementById('lineaVenta').innerHTML = '';
    $('#btn_acept').prop('disabled', false);
    $('.simbolico_column').html('');
    $('.col-estructura').html('');
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
                            <label class="control-label">Nueva estructura (<small class="isRequired">*</small>)</label>
                            <select class="selectpicker select-gral m-0" id="nueva_estructura" name="nueva_estructura" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                <option value="0" ${ (v.nueva_estructura == 0 || v.nueva_estructura != null ) ? 'checked' : ''}>No</option>
                                <option value="1" ${ (v.nueva_estructura == 1 || v.nueva_estructura != null ) ? 'checked' : ''}>Sí</option>
                            </select>
                        </div>
                    </div>
                `);
            }

            //se valida que tipo de usuario está editando el usuario para poder agregarle la propiedad
            //de si es simbólico o no
            if(id_rol_general == 4 || id_rol_general == 5 || id_rol_general==6){
                if (v.id_rol == '7' ){
                    $('#tipoMiembro_column').removeClass('col-sm-6');
                    $('#tipoMiembro_column').addClass('col-sm-3');
                    var row_add = $('.simbolico_column');
                    row_add.append(`
                    <div class="col-sm-3 mt-3">
                        <div class="form-group label-floating select-is-empty div_membertype">
                            <label class="control-label"><small class="isRequired">*</small>¿Asesor simbólico?</label>
                            <select class="selectpicker select-gral m-0" id="simbolicoType" name="simbolicoType" data-style="btn" data-show-subtext="true" 
                            data-live-search="true" title="Seleccione sí es simbolíco" data-size="7" data-container="body" required>
                                <option value="1" ${ (v.simbolico == 1 || v.simbolico == '1' ) ? 'selected' : ''}>SÍ</option>
                                <option value="0" ${ (v.simbolico == 0 || v.simbolico == '0' || v.simbolico == null ) ? 'selected' : ''}>NO</option>
                            </select>
                        </div>
                    </div>`);
                }else{
                    $('#tipoMiembro_column').removeClass('col-sm-3');
                    $('#tipoMiembro_column').addClass('col-sm-6');
                }
                $('#simbolicoType').selectpicker('refresh');
            }
            $('#nueva_estructura').selectpicker('refresh');
            getLeadersListForEdit(v.id_sede, v.id_rol, leader);
            $("#editUserModal").modal();
            fillFields(v);
            validateEmptyFields(v);
        });
    });
});

$(document).on('change', '#sedech', function() {
    let id_sede = $('#sedech').val();
    $("#sucursal").empty();
    $("#sucursal").append($('<option disabled selected>').val("").text("SELECCIONA UNA OPCIÓN"));
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
    sede == 0 ?  $("#sedech").append($('<option disabled selected>').val("").text("SELECCIONA UNA OPCIÓN")) : '';
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
        $("#member_type option[value=2]").text("DIRECTOR REGIONAL");
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
        if(v.sedech == null) {
            getSedesCH();
        } else {
            getSedesCH(v.sedech,v.sucursalch);
        }
        $('#sedech').selectpicker('refresh');
        if (v.nueva_estructura == 1) {
            $("#member_type option[value=7]").text("ASESOR FINANCIERO");
            $("#member_type option[value=9]").text("LÍDER COMERCIAL");
            $("#member_type option[value=3]").text("EMBAJADOR");
        } else {
            $("#member_type option[value=7]").text("ASESOR");
            $("#member_type option[value=9]").text("COORDINADOR DE VENTAS");
            $("#member_type option[value=3]").text("GERENTE");
        }
    } else {
        $('#ch'). hide();
        document.getElementById("sedech").removeAttribute("required");
        $("#sedech").empty();
        document.getElementById("sucursal").removeAttribute("required");
        $("#sucursal").empty();
    }
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
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
            } else if (data.respuesta == 0) {
                alerts.showNotification("top", "right", data.message, "warning");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function(){
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.see-changes-log', function(){
    id_usuario = $(this).attr("data-id-usuario");
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
            dataMovimiento = '<b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'apellido_paterno':
            nombreMovimiento = 'Apellido paterno';
            dataMovimiento = '<b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'apellido_materno':
            nombreMovimiento = 'Apellido materno';
            dataMovimiento = '<b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'contrasena':
            nombreMovimiento = 'Contraseña';
            dataMovimiento = 'Cambio de Contraseña';
        break;
        case 'telefono':
            nombreMovimiento = 'Teléfono';
            dataMovimiento = '<b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'imagen_perfil':
            nombreMovimiento = 'Imagen de perfil';
            dataMovimiento = '<b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        case 'forma_pago':
            nombreMovimiento = 'Forma de pago';
            dataMovimiento = '<b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
        default:
            nombreMovimiento = v.col_afect;
            dataMovimiento = '<b>Valor anterior:</b> ' + v.anterior + '\n' +
        '            <br>\n' +
        '            <b>Valor nuevo:</b> ' + v.nuevo + '\n';
        break;
    }

    $("#changelogUsers").append('<li>\n' +
    '    <div class="container-fluid">\n' +
    '       <div class="row">\n' +
    '           <div class="col-md-6">\n' +
    '               <a><small>Campo: </small><b> ' +v.col_afect.toUpperCase()+ '</b></a><br>\n' +
    '           </div>\n' +
    '<div class="float-end text-right">\n' +
    '               <a>' + v.fecha_creacion + '</a>\n' +
    '           </div>\n' +
    '           <div class="col-md-12">\n' +
    '                <p class="m-0"><small>USUARIO: </small><b> ' + v.creador + '</b></p>\n'+
    '                <p class="m-0"><small>VALOR ANTERIOR: </small><b> ' + v.anterior.toUpperCase() + '</b></p>\n' +
    '                <p class="m-0"><small>VALOR NUEVO: </small><b> ' + v.nuevo.toUpperCase() + '</b></p>\n' +
    '           </div>\n' +
    '        <h6>\n' +
    '        </h6>\n' +
    '       </div>\n' +
    '    </div>\n' +
        '</li>');
}

$(document).on('change', '#nueva_estructura', function() {
    if ($(this).val() == 1) {
        $("#member_type option[value=7]").text("ASESOR FINANCIERO");
        $("#member_type option[value=9]").text("LÍDER COMERCIAL");
        $("#member_type option[value=3]").text("EMBAJADOR");
    } else {
        $("#member_type option[value=7]").text("ASESOR");
        $("#member_type option[value=9]").text("COORDINADOR DE VENTAS");
        $("#member_type option[value=3]").text("GERENTE");
    }
    $("#member_type").val('').selectpicker("refresh");
    $("#leader").val('').selectpicker("refresh");
});