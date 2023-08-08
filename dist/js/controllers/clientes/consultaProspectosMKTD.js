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
                    columns: [0,1,2,3,4,5,6,7],
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
                        actions += '<center><button title="DESPLEGAR" data-toggle="tooltip"  data-placement="top" style="margin-right: 3px;" class="desplegable btn-data btn-details-grey" id="btn_'+d.id_prospecto+'" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_'+d.id_prospecto+'\').removeClass(\'hide\'); "><span class="fas fa-chevron-up"></span></button></center>';
                        actions +=	'<center><div class="hide" id="cnt_'+d.id_prospecto+'">'+group_buttons+'<br><br><button title="MINIMIZAR" data-toggle="tooltip"  data-placement="top" style="margin-right: 3px;" onclick="javascript: $(\'#btn_'+d.id_prospecto+'\').removeClass(\'hide\');$(\'#cnt_'+d.id_prospecto+'\').addClass(\'hide\'); " class="btn-data btn-details-grey" style="background-color: orangered"><i class="fas fa-chevron-down"></i></button></div></center>';
                        actions +=	'<center><button data-toggle="tooltip"  data-placement="top" class="btn-data btn-blueMaderas update-status" data-id-prospecto="' + d.id_prospecto +'"><i class="fas fa-redo" ></i></button></center>';
                        actions += '<center><button data-toggle="tooltip"  data-placement="top" class="btn-data btn-warning change-pl" data-id-prospecto="' + d.id_prospecto +'" style="margin-right: 3px" data-toggle="tooltip"  data-placement="top" title="REMOVER MKTD"><i class="fas fa-trash"></i></button></center>';
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