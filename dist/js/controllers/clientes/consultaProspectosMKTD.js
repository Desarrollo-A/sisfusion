let titulosEvidence = [];

$('#prospects-datatable_dir thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosEvidence.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value) {
            $('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
        }
    });
});

$('#prospects-datatable_dir').on('draw.dt', function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setIniDatesXMonth("#beginDate", "#endDate");
    let finalBeginDate2 = $("#beginDate").val();
    let finalEndDate2 = $("#endDate").val();
    if(id_rol_general == 18){
    $("#subDir").empty().selectpicker('refresh');
        $('#spiner-loader').removeClass('hide');
        $.post(general_base_url+'Clientes/getSubdirs_mkt/', function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#subDir").append($('<option>').val(id).text(name));
            }
            if(len<=0)
            {
                $("#subDir").append('<option selected="selected" disabled>NINGÚN SUBDIRECTOR</option>');
            }
            $("#subDir").selectpicker('refresh');
        }, 'json');
    }
    else if (id_rol_general == 19){
        var subdir = id_usuario_general;
        $("#gerente").empty().selectpicker('refresh');
        $("#coordinador").empty().selectpicker('refresh');
        $("#asesores").empty().selectpicker('refresh');
        $.post(general_base_url+'Clientes/getGerentesBySubdir_mkt/'+subdir, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#gerente").append($('<option>').val(id).text(name));
            }
            if(len<=0)
            {
                $("#gerente").append('<option selected="selected" disabled>NINGUN GERENTE</option>');
            }
            $("#gerente").selectpicker('refresh');
        }, 'json');
        var url = general_base_url+'Clientes/getProspectsListByGerente/'+subdir;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0)
    }
    $('#spiner-loader').addClass('hide');
});

sp = {
    initFormExtendedDatetimepickers: function () {
        var today = new Date();
        var date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
        var time = today.getHours() + ":" + today.getMinutes();
        $(".datepicker").datetimepicker({
            format: "DD/MM/YYYY",
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-screenshot",
                clear: "fa fa-trash",
                close: "fa fa-remove",
                inline: true,
            },
        });
    },
};

sp.initFormExtendedDatetimepickers();

if(id_rol_general != 19){
    $('#subDir').on('change', function () {
        var subdir = $("#subDir").val();
        //gerente
        $("#gerente").empty().selectpicker('refresh');
        $("#coordinador").empty().selectpicker('refresh');
        $("#asesores").empty().selectpicker('refresh');
        $.post(general_base_url+'Clientes/getGerentesBySubdir_mkt/'+subdir, function(data) {
            var len = data.length;
            for( var i = 0; i<len; i++)
            {
                var id = data[i]['id_usuario'];
                var name = data[i]['nombre'] + ' ' + data[i]['apellido_paterno'] + ' ' + data[i]['apellido_materno'];
                $("#gerente").append($('<option>').val(id).text(name));
            }
            if(len<=0)
            {
                $("#gerente").append('<option selected="selected" disabled>NINGUN GERENTE</option>');
            }
            $("#gerente").selectpicker('refresh');
        }, 'json');
        var url = general_base_url+'Clientes/getProspectsListByGerente/'+subdir;
        let finalBeginDate = $("#beginDate").val();
        let finalEndDate = $("#endDate").val();
        updateTable(url, 1, finalBeginDate, finalEndDate, 0)
    });
}

$('#gerente').on('change', function () {
    var gerente = $("#gerente").val();
    var url = general_base_url+"Clientes/getProspectsListByCoord/"+gerente;
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    updateTable(url, 1, finalBeginDate, finalEndDate, 0)
});

$(document).on("click", "#searchByDateRange", function () {
    var gerente = $("#gerente").val();
    if(id_rol_general == 19){
        if(gerente!=''){
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            var gerente = $("#gerente").val();
            var url = general_base_url+"Clientes/getProspectsListByCoord/"+gerente;
            updateTable(url, 3, finalBeginDate, finalEndDate, 0);
        }
        else{
            alerts.showNotification('top', 'right', 'Porfavor selecciona gerente', 'danger');
        }
    }else{
        var subdir = $('#subDir').val();
        if(gerente=='' && subdir != ''){
            var url = general_base_url+'Clientes/getProspectsListByGerente/'+subdir;
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            updateTable(url, 1, finalBeginDate, finalEndDate, 0)
        }else if(gerente!='' && subdir != ''){
            let finalBeginDate = $("#beginDate").val();
            let finalEndDate = $("#endDate").val();
            var gerente = $("#gerente").val();
            var url = general_base_url+"Clientes/getProspectsListByCoord/"+gerente;
            updateTable(url, 3, finalBeginDate, finalEndDate, 0);
        }
    }    
});

function updateTable(url, typeTransaction, beginDate, endDate, where){
        prospectsTable = $('#prospects-datatable_dir').dataTable({
            dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
            width: "100%",
            scrollX: true,
            bAutoWidth: true,
            pagingType: "full_numbers",
            lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
            ],
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Listado general de prospectos',
                title:"Listado general de prospectos",
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosEvidence[columnIdx] + ' ';
                        }
                    }
                }
            }],
            language: {
                url: "../static/spanishLoader_v2.json",
                paginate: {
                    previous: "<i class='fa fa-angle-left'>",
                    next: "<i class='fa fa-angle-right'>"
                }
            },
            ordering: false,
            destroy: true,
            columnDefs: [{
                defaultContent: "",
                targets: "_all",
                searchable: true,
                orderable: false
            }],
            columns: [
                { 
                    data: function (d) {
                            if (d.estatus == 1) {
                            return '<center><span class="label lbl-green">VIGENTE</span><center>';
                        } else {
                            return '<center><span class="label lbl-warning">SIN VIGENCIA</span><center>';
                        }
                    }
                },
                { 
                    data: function (d) {
                    var b;
                        if(d.estatus_particular == 1) { // DESCARTADO
                        b = '<center><span class="label lbl-warning">DESCARTADO</span><center>';
                    } else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
                        b = '<center><span class="label lbl-yellow">INTERESADO SIN CITA</span><center>';
                    } else if (d.estatus_particular == 3){ // CON CITA
                        b = '<center><span class="label lbl-green">CON CITA</span><center>';
                    } else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
                        b = '<center><span class="label lbl-gray">SIN ESPECIFICAR</span><center>';
                    } else if (d.estatus_particular == 5){ // PAUSADO
                        b = '<center><span class="label lbl-azure">PAUSADO</span><center>';
                    } else if (d.estatus_particular == 6){ // PREVENTA
                        b = '<center><span class="label lbl-violetBoots">PREVENTA</span><center>';
                    }
                    else {
                        b = '<center><span class="label lbl-gray">SIN ESPECIFICAR</span><center>';
                        
                    }
                    return b;
                    }    
                },
                { 
                    data: function (d) {
                        return d.nombre;
                    }
                },
                { 
                    data: function (d) {
                        return d.asesor;
                    }
                },
                {
                    data: function (d) {
                        return d.coordinador;
                    }
                },
                { 
                    data: function (d) {
                        return d.gerente;
                    }
                },
                {
                    data: function (d) {
                        return (d.subdirector === '  ') ? 'SIN ESPECIFICAR' : d.subdirector;
                    }
                },
                {
                    data: function (d) {
                        return (d.regional === '  ') ? 'SIN ESPECIFICAR' : d.regional;
                    }
                },
                {
                    data: function (d) {
                        return (d.regional_2 === '  ') ? 'SIN ESPECIFICAR' : d.regional_2;
                    }
                },
                { 
                    data: function (d) {
                        return d.fecha_creacion;
                    }
                },
                { 
                    data: function (d) {
                        return d.fecha_vencimiento;
                    }
                },
                { 
                    data: function (d) {
                    if (d.estatus == 1) { 
                        var actions = '';
                        var group_buttons = '';
                        group_buttons = '<button class="btn-data btn-orangeYellow to-comment" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px" data-toggle="tooltip"  data-placement="top" title="INGRESA UN COMENTARIO"><i class="fas fa-comment-alt"></i></button>' +
                                    '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px;" data-toggle="tooltip"  data-placement="top" title="EDITAR LA INFORMACIÓN"><i class="fas fa-pencil-alt"></i></button>' +
                                    '<button class=" btn-data btn-details-grey see-information" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px;" data-toggle="tooltip"  data-placement="top" title="VER INFORMACIÓN"><i class="fas fa-eye"></i></button>' +
                                    '<button class="btn-data btn-details-violet re-asign" data-id-prospecto="' + d.id_prospecto +'" data-toggle="tooltip"  data-placement="top" title="RE-ASIGNAR"><i class="fas fa-retweet"></i></button>';

                        actions += '<button title="DESPLEGAR" data-toggle="tooltip"  data-placement="top" style="margin-right: 3px;" class="desplegable btn-data btn-details-grey" id="btn_'+d.id_prospecto+'" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_'+d.id_prospecto+'\').removeClass(\'hide\'); "><span class="fas fa-chevron-up"></span></button>';
                        actions +=	'<div class="hide" id="cnt_'+d.id_prospecto+'">'+group_buttons+'<br><br><button title="MINIMIZAR" data-toggle="tooltip"  data-placement="top" style="margin-right: 3px;" onclick="javascript: $(\'#btn_'+d.id_prospecto+'\').removeClass(\'hide\');$(\'#cnt_'+d.id_prospecto+'\').addClass(\'hide\'); " class="btn-data btn-details-grey" style="background-color: orangered"><i class="fas fa-chevron-down"></i></button></div>';
                        actions +=	'<button class="btn-data btn-blueMaderas update-status" data-id-prospecto="' + d.id_prospecto +'" data-toggle="tooltip"  data-placement="top title="ACTUALIZAR ESTATUS"><i class="fas fa-redo" ></i></button>';
                        actions += '<button data-toggle="tooltip"  data-placement="top" class="btn-data btn-warning change-pl" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px" title="REMOVER MKTD"><i class="fas fa-trash"></i></button>';
                        return actions;
                    } 
                    else { // IS NOT ACTIVE
                        var actions = '';
                        var group_buttons = '';
                        if (d.vigencia >= 0 /*< 5 && d.fecha_creacion >= '2021-04-19 23:59:59.000'*/) {
                            actions +=	'<button class="btn-data btn-warning update-validity" data-id-prospecto="' + d.id_prospecto +'" data-toggle="tooltip"  data-placement="top" title="RENOVAR VIGENCIA"><i class="fas fa-redo"></i></button>';
                        }
                        return actions;
                    }
                }
            }
            ],
            ajax: {
                url: url,
                dataSrc: "",
                cache: false,
                type: "POST",
                data: {
                    "typeTransaction": typeTransaction,
                    "beginDate": beginDate,
                    "endDate": endDate,
                    "where": where
                }
            }
    })
}

$(document).on('click', '.edit-information', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    source = $(this).attr("data-source");
    editProspecto = $(this).attr("data-editProspecto");
    owner = $(this).attr("data-owner");
    $.getJSON("getProspectInformation/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
                $("#nationality option[value="+v.nacionalidad+"]").attr("selected", true);
                $("#nationality").selectpicker("refresh");
                $("#legal_personality option[value="+v.personalidad_juridica+"]").attr("selected", true);
                $("#legal_personality").selectpicker("refresh");
                $("#civil_status option[value="+v.estado_civil+"]").attr("selected", true);
                $("#civil_status").selectpicker("refresh");
                $("#matrimonial_regime option[value="+v.regimen_matrimonial+"]").attr("selected", true);
                $("#matrimonial_regime").selectpicker("refresh");
                $("#prospecting_place option[value="+v.lugar_prospeccion+"]").attr("selected", true);
                $("#prospecting_place").selectpicker("refresh");
                $("#sales_plaza option[value="+v.plaza_venta+"]").attr("selected", true);
                $("#sales_plaza").selectpicker("refresh");
                $("#myEditModal").modal();
                fillFields(v, 0);
                validateEmptyFields(v, 1);
                $("#id_prospecto_ed").val(id_prospecto);
                $("#owner").val(owner);
                $("#source").val(source);
                $("#editProspecto").val(editProspecto);
                showSpecificationObject();
        });
    });
});

$(document).on('click', '.update-status', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    telefono = $(this).attr("data-telefono");
    telefono2 = $(this).attr("data-telefono2");
    $("#myUpdateStatusModal").modal();
    $("#id_prospecto_estatus_particular").val(id_prospecto);
    $("#telefono1").val(telefono);
    $("#telefono2").val(telefono2);
});

$("#my_update_status_form").on('submit', function(e) {
    e.preventDefault();
    if($('#estatus_particular').val() == 3){
        cleanModal();
        $("#agendaInsert").modal();
    }else{$.ajax({
        type: 'POST',
        url: 'updateStatus',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
        },
        success: function(data) {
            if (data == 1) { 
                $('#myUpdateStatusModal').modal("hide");
                $('#estatus_particular').val("0");
                $("#estatus_particular").selectpicker("refresh");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
            } else if (data == 2) {
                alerts.showNotification("top", "right", "La asignación no se ha podido llevar a cabo debido a que el lote seleccionado ya se encuentra apartado.", "warning");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });}
});

$("#my_update_status_prevee").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateStatusPreventa',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
        },
        success: function(data) {
            if (data == 1) {
                $('#myUpdateStatusPreve').modal("hide");
                $('#myUpdateStatusModalPreventa').modal("hide");
                $('#estatus_particular2').val("0");
                $("#estatus_particular2").selectpicker("refresh");
                $prospectsPreventaTable.ajax.reload();
                alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

});

document.querySelector('#estatus_recordatorio_form').addEventListener('submit',async e =>  {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(e.target));
    data['estatus_particular'] = $('#estatus_particular').val();
    data['id_prospecto_estatus_particular'] = $("#id_prospecto_estatus_particular").val();
    $.ajax({
        type: 'POST',
        url: '../Calendar/insertRecordatorio',
        data: JSON.stringify(data),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            $('#spiner-loader').removeClass('hide');
        },
        success: function(data) {
            $('#spiner-loader').addClass('hide');
            $('#myUpdateStatusModal').modal("toggle");
            $('#agendaInsert').modal("toggle");
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
        },
        error: function() {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function cleanModal(){
    $('#evtTitle').val('');
    $("#prospecto option:selected").prop("selected", false);
    $("#prospecto").selectpicker('refresh');
    $("#estatus_recordatorio option:selected").prop("selected", false);
    $("#estatus_recordatorio").selectpicker('refresh');
    $("#description").val('');
    $("#comodinDIV").addClass('hide');
}
$(document).on('click', '.change-pl', function () { // MJ: FUNCIÓN CAMBIO DE ESTATUS ACTIVO / INACTIVO
    id_prospecto = $(this).attr("data-id-prospecto");
    $.ajax({
        type: 'POST',
        url: 'change_lp',
        data: {
            'id': id_prospecto,
            'lugar_p': 11
        },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "El lugar de prospección se ha actualizado con éxito.", "success");
                prospectsTable.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function fillFields(v, type) {
    $("#name").val(v.nombre).attr('readonly',false);
    $("#last_name").val(v.apellido_paterno).attr('readonly',false);
    $("#mothers_last_name").val(v.apellido_materno).attr('readonly',false);
    if (type == 0) {
        $("#nationality").val(v.nacionalidad);
        $("#legal_personality").val(v.personalidad_juridica);
        $("#curp").val(v.curp);
        $("#rfc").val(v.rfc);
        v.source!=0 && v.editProspecto==0?$("#name").val(v.nombre):$("#name").val(v.nombre).attr('readonly',true);
        v.source!=0 && v.editProspecto==0?$("#last_name").val(v.apellido_paterno):$("#last_name").val(v.apellido_paterno).attr('readonly',true);
        v.source!=0 && v.editProspecto==0?$("#mothers_last_name").val(v.apellido_materno):$("#mothers_last_name").val(v.apellido_materno).attr('readonly',true);
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
        $("#comentario").val(v.observaciones);
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
        if (pp == 3 || pp == 7 || pp == 9 || pp == 10) {
            $("#specify").val(v.otro_lugar);
        } else if (pp == 6) { 
            document.getElementById('specify_mkt').value = v.otro_lugar;
        } else if (pp == 21) {
            document.getElementById('specify_recommends').value = v.otro_lugar;
        } else {
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
        $("#sales-plaza-lbl").val(v.plaza_venta);
        $("#comments-lbl").val(v.observaciones);
        $("#asesor-lbl").val(v.asesor);
        $("#coordinador-lbl").val(v.coordinador);
        $("#gerente-lbl").val(v.gerente);
        $("#phone-asesor-lbl").val(v.tel_asesor);
        $("#phone-coordinador-lbl").val(v.tel_coordinador);
        $("#phone-gerente-lbl").val(v.tel_gerente);
        $("#comentario").val(v.observaciones);
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
        if (v.antiguedad != '' || v.antiguedad == 0 ) {
            $(".div-antiquity").removeClass("is-empty");
        }
        if (v.edadFirma != '' || v.edadFirma == 0) {
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
    if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { 
        $("#specify").removeAttr("style");
        $("#specify_mkt_div").css({ "display": "none" });
    } else if (pp == 6) {
        $("#specify_mkt").removeAttr("style");
        $("#specify_mkt_div").removeAttr("style");
    } else if (pp == 21) {
        $("#specify_recommends").removeAttr("style");
        $("#specify_mkt_div").css({ "display": "none" });
    } else {
        $("#specify").removeAttr("style");
        $("#specify_mkt_div").css({ "display": "none" });
    }
}

$(document).on('click', '.to-comment', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#myCommentModal").modal();
    $("#comment").val("");
    $("#id_prospecto").val(id_prospecto);
    $(".label-floating").removeClass("is-empty");
});

$(document).on('click', '.see-information', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#seeInformationModal").modal();
    $("#prospecto_lbl").val(id_prospecto);
    $.getJSON("getInformationToPrint/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            fillFields(v, 1);
        });
    });
    $.getJSON("getComments/" + id_prospecto).done(function(data) {
        if (data.length == 0) {
            $("#comments-list").append('SIN DATOS POR MOSTRAR');
        } else {
            counter = 0;
            $.each(data, function(i, v) {
                counter++;
                fillTimeline(v, counter);
            });
        }
    });
    $.getJSON("getChangelog/" + id_prospecto).done(function(data) {
        if (data.length == 0) {
            $("#changelog").append('SIN DATOS POR MOSTRAR');
        } else {
            $.each(data, function(i, v) {
                fillChangelog(v);
            });
        }
    });
});

$(document).on('click', '.re-asign', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    if (id_rol_general == 3 || id_rol_general == 6) {
        $("#myReAsignModalVentas").modal();
        getManagers();
        $("#id_prospecto_re_asign_ve").val(id_prospecto);
    } else if (id_rol_general == 19) {
        $("#myReAsignModalSubMktd").modal();
        $("#id_prospecto_re_asign_sm").val(id_prospecto);
    } else if (id_rol_general == 20) {
        $("#myReAsignModalGerMktd").modal();
        $("#id_prospecto_re_asign_gm").val(id_prospecto);
    }
});