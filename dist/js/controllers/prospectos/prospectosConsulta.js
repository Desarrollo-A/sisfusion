typeTransaction = 1;
let sedesGet;
$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({ locale: 'es' });
    setInitialValues();
    getStatusRecordatorio();

    $.post(`${general_base_url}Prospectos/getSedesProspectos`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#sede").append($('<option>').val(data[i]['id_sede']).text(data[i]['nombre']));
        }
        $("#sede").selectpicker('refresh');
    }, 'json');
});

$("#close").click(function () {
    $("#sedeForm").removeClass("hide");
    $("#form-Asesor").addClass("hide");
    $("#form-Coor").addClass("hide");
    $("#form-Gere").addClass("hide");
    $("#form-Sub").addClass("hide");
    $("#form-Dr").addClass("hide");
    $("#form-Dr2").addClass("hide");
    $("#con1").addClass("hide");
    $("#con2").addClass("hide");
    $("#con3").addClass("hide");

});

function changeSede() {
    var idSede = $("#sede").val();

    $("#sedeForm").removeClass("hide");
    $("#form-Asesor").addClass("hide");
    $("#form-Coor").addClass("hide");
    $("#form-Gere").addClass("hide");
    $("#form-Sub").addClass("hide");
    $("#form-Dr").addClass("hide");
    $("#form-Dr2").addClass("hide");
    $("#con1").addClass("hide");
    $("#con2").addClass("hide");
    $("#con3").addClass("hide");

    $.post(`${general_base_url}Asesor/getAsesor/` + idSede, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#asesor").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombre']));
        }
        $("#asesor").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Asesor/getCoordinador/` + idSede, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#coordinador").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombre']));
        }
        $("#coordinador").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Asesor/getGerentes/` + idSede, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#gerente").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombre']));
        }
        $("#gerente").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Asesor/getSubdirector/` + idSede, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#subdirector").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombre']));
        }
        $("#subdirector").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Asesor/getDirectorRegional/` + idSede, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#DireRegional").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombre']));
        }
        $("#DireRegional").selectpicker('refresh');
    }, 'json');

    $.post(`${general_base_url}Asesor/getDirectorRegional/` + idSede, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#DireRegional2").append($('<option>').val(data[i]['id_usuario']).text(data[i]['nombre']));
        }
        $("#DireRegional2").selectpicker('refresh');
    }, 'json');

    if (idSede == 2 || idSede == 5 || idSede == 6 || idSede == 3) {
        $("#sedeForm").addClass("hide");
        $("#form-Asesor").removeClass("hide");
        $("#form-Coor").removeClass("hide");
        $("#form-Gere").removeClass("hide");
        $("#form-Sub").removeClass("hide");
        $("#con1").removeClass("hide");
        $("#con2").addClass("hide");
        $("#con3").addClass("hide");
    } else if (idSede == 13 || idSede == 14) {
        $("#sedeForm").addClass("hide");
        $("#form-Asesor").removeClass("hide");
        $("#form-Coor").removeClass("hide");
        $("#form-Gere").removeClass("hide");
        $("#form-Sub").removeClass("hide");
        $("#form-Dr").removeClass("hide");
        $("#form-Dr2").removeClass("hide");
        $("#con1").addClass("hide");
        $("#con2").removeClass("hide");
        $("#con3").addClass("hide");
    } else {
        $("#sedeForm").addClass("hide");
        $("#form-Asesor").removeClass("hide");
        $("#form-Coor").removeClass("hide");
        $("#form-Gere").removeClass("hide");
        $("#form-Sub").removeClass("hide");
        $("#form-Dr").removeClass("hide");
        $("#con1").addClass("hide");
        $("#con2").addClass("hide");
        $("#con3").removeClass("hide");
    }
};

let titulosListadoProspectos = [];

$('#prospects-datatable thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosListadoProspectos.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($("#prospects-datatable").DataTable().column(i).search() !== this.value)
            $("#prospects-datatable").DataTable().column(i).search(this.value).draw();
    });
});

function fillTable() {
    prospectsTable = $('#prospects-datatable').DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'LISTADO DE PROSPECTOS CRM',
                title: "LISTADO DE PROSPECTOS CRM",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosListadoProspectos[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        bAutoWidth: true,
        columns: [
            {
                data: function (d) {
                    if (d.estatus_particular == 1) // DESCARTADO
                        b = '<span class="label lbl-warning">DESCARTADO</span>';
                    else if (d.estatus_particular == 2) // INTERESADO SIN CITA
                        b = '<span class="label lbl-green">INTERESADO SIN CITA</span>';
                    else if (d.estatus_particular == 3) // CON CITA
                        b = '<span class="label lbl-sunny">CON CITA</span>';
                    else if (d.estatus_particular == 4) // SIN ESPECIFICAR
                        b = '<span class="label lbl-gray">SIN ESPECIFICAR</span>';
                    else if (d.estatus_particular == 5) // PAUSADO
                        b = '<span class="label lbl-orangeYellow">PAUSADO</span>';
                    else if (d.estatus_particular == 6) // PREVENTA
                        b = '<span class="label lbl-violetDeep">PREVENTA</span>';
                    else if (d.estatus_particular == 7) // CLIENTE
                        b = '<span class="label lbl-oceanGreen">CLIENTE</span>';
                    else // CLIENTE
                        b = '<span class="label lbl-gray">SIN ESPECIFICAR</span>';
                    return b;
                }
            },
            {
                data: function (d) {
                    elemento = `${d.nombre}<br><span class="label lbl-cerulean">${d.id_prospecto}</span>`;
                    return elemento;
                }
            },
            {
                data: function (d) {
                    return d.asesor;
                }
            },
            {
                data: function (d) {
                    return d.coordinador == '  ' ? 'SIN ESPECIFICAR' : d.coordinador;
                }
            },
            {
                data: function (d) {
                    return d.gerente == '  ' ? 'SIN ESPECIFICAR' : d.gerente;
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
                    if (d.nombre_lp == '' || d.nombre_lp === null) {
                        return 'SIN ESPECIFICAR';
                    } else {
                        if (d.nombre_lp == 'MKTD DRAGON')
                            id_dragon = '<br><span class="label lbl-blueMaderas">' + d.id_dragon + '</span>';
                        else
                            id_dragon = '';
                        return d.nombre_lp + id_dragon;
                    }
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {

                    const BTNGROUPS = '<button class="btn-data btn-orangeYellow to-comment" data-id-prospecto="' + d.id_prospecto + '" data-toggle="tooltip" data-placement="top" title="INGRESAR COMENTARIO"><i class="far fa-comments"></i></button>' +
                        '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto + '" data-owner="' + d.id_asesor + '" data-source="' + d.source + '" data-editProspecto="' + d.editProspecto + '" data-toggle="tooltip" data-placement="top" title="EDITAR INFORMACIÓN"><i class="fas fa-pencil-alt"></i></button>' +
                        '<button class="btn-data btn-sky see-information" data-id-prospecto="' + d.id_prospecto + '" data-toggle="tooltip" data-placement="top" title="VER INFORMACIÓN"><i class="far fa-eye"></i></button>' +
                        '<button class="btn-data btn-details-grey re-asign" data-id-prospecto="' + d.id_prospecto + '" data-toggle="tooltip" data-placement="top" title="RE - ASIGNAR"><i class="fab fa-rev"></i></button>';

                    const ACT1 = `<button class="desplegable btn-data btn-blueMaderas" id="btn_${d.id_prospecto}" data-toggle="tooltip" data-placement="top" title="DESPLEGAR OPCIONES" onclick="javascript: $(this).addClass('hide');$('#cnt_${d.id_prospecto}').removeClass('hide');"> <i class="fas fa-chevron-up"></i> </button>`;
                    const ACT2 = `<div class= "hide boxSBtns" id="cnt_${d.id_prospecto}"> ${BTNGROUPS} <br> <button onclick="javascript: $('#btn_${d.id_prospecto}').removeClass('hide'); $('#cnt_${d.id_prospecto}').addClass('hide');" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="top" title="CERRAR OPCIONES"> <i class="fas fa-chevron-down"></i></button></div>`;

                    if (d.lugar_prospeccion == 42 && d.becameClient == null) {
                        var ACT3 = '<button class="btn-data btn-acidGreen update-status" ' + 'data-id-prospecto="' + d.id_prospecto + '" ' + 'data-telefono="' + d.telefono + '" ' + 'data-telefono2="' + d.telefono2 + '" ' + 'data-toggle="tooltip"' + 'data-placement="top" ' + 'title="ACTUALIZAR ESTATUS">' + '<i class="fas fa-redo"></i>';
                    } else {
                        ACT3 = '';
                    }

                    if (id_rol_general != "19") {
                        if (id_rol_general == "3" || id_rol_general == "6") {
                            if (d.estatus == 1) {
                                var actions = '';
                                var group_buttons = '';
                                if (id_usuario_general != d.id_asesor && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) {
                                    actions = '';
                                } else {
                                    group_buttons += BTNGROUPS;
                                    actions += ACT1;
                                    actions += ACT2;
                                    actions += ACT3;
                                }
                                return '<center>' + actions + '</center>';
                            } else {
                                var actions = '';
                                var group_buttons = '';
                                if (id_usuario_general != d.id_asesor && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) {
                                    actions = '';
                                } else {
                                    group_buttons += BTNGROUPS;
                                    actions += ACT1;
                                    actions += ACT2;
                                }
                                return '<center>' + actions + '</center>';
                            }
                        } else {
                            if (d.estatus == 1) {
                                var actions = '';
                                var group_buttons = '';
                                if (id_usuario_general != d.id_asesor && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) {
                                    actions = '';
                                } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                    group_buttons += BTNGROUPS;
                                    actions += ACT1;
                                    actions += ACT2;
                                    actions += ACT3;
                                }
                                return '<center>' + actions + '</center>';
                            } else {
                                var actions = '';
                                var group_buttons = '';
                                if (id_usuario_general != d.id_asesor && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) {
                                    actions = '';
                                } else {
                                    group_buttons += BTNGROUPS;
                                    actions += '<button class="desplegable btn-blueMaderas" ' + 'id="btn_' + d.id_prospecto + '" ' + 'onclick="javascript: $(this).addClass(\'hide\');' + '$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\');">' + '<i class="fas fa-chevron-up"></i>' + '</button>';
                                    actions += '<div class="hide boxSBtns" ' + 'id="cnt_' + d.id_prospecto + '">' + group_buttons + '' + '<br>' +
                                        '<button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');' + '$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\');" ' + 'class="btn-data btn-blueMaderas">' +
                                        '<i class="fas fa-chevron-down"></i>' +
                                        '</button>' +
                                        '</div>';
                                    if (d.vigencia >= 0) {
                                        actions += '<button class="btn-data btn-acidGreen update-validity" ' + 'data-id-prospecto="' + d.id_prospecto + '" ' + 'rel="tooltip" ' + 'data-placement="left"' + 'data-toggle="tooltip"' + 'data-placement="top" ' + 'title="Renovar vigencia">' +
                                            '<i class="fas fa-history"></i>' +
                                            '</button>';
                                    }
                                }
                                return '<center>' + actions + '</center>';
                            }
                        }
                    } else {
                        return '';
                    }
                }
            }],
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        scrollX: true,
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        },
        ],
        ajax: {
            "url": "getProspectsList",
            "type": "POST",
            cache: false,
        },
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        },
    });

}

$('#prospects-datatable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
    });
});

$('#myEditModal').modalSteps();
$('#myCoOwnerModal').modalSteps();

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'MM/DD/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
    }
}

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    fillTable(3, finalBeginDate, finalEndDate, 0);
});

function setInitialValues() {
    const fechaInicio = new Date();
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    const fechaFin = new Date();
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    $("#beginDate").val(convertDate(beginDate));
    $("#endDate").val(convertDate(endDate));
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
    fillTable(1, finalBeginDate, finalEndDate, 0);
}

$('#finish').on('click', function () {
    validateFile();
});

function validateFile() {
    if ($('#prospecting_place').val() == '' || $('#prospecting_place').val() == null ||
        $('#sales_plaza').val() == '' || $('#sales_plaza').val() == null ||
        $('#asesor_prospecto').val() == '' || $('#asesor_prospecto').val() == null) {
        alerts.showNotification('top', 'right', 'Debes ingresar los campos requeridos', 'danger');
    } else {
        $('#confirmar').modal('toggle');
    }
}

function validateEmptySelects(type) {
    if (type == 1 || type == 2) {
        if ($("#civil_status").val() == null || $("#civil_status").val() == '') {
            $("#civil_status").val(7);
        }
        if ($("#matrimonial_regime").val() == null || $("#matrimonial_regime").val() == '') {
            $("#matrimonial_regime").val(5);
        }
        if ($("#state").val() == null || $("#state").val() == '') {
            $("#state").val(33);
        }
    } else if (type == 3) {
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
    if (type == 1 || type == 2) {
        cs = document.getElementById('civil_status');
        cs = cs.value;
        if (cs == 4) {
            document.getElementById('matrimonial_regime').removeAttribute("disabled");
        } else {
            $("#matrimonial_regime").val("5");
            $("#spouce").val("");
            document.getElementById('matrimonial_regime').setAttribute("disabled", "true");
            document.getElementById('spouce').setAttribute("disabled", "true");
        }
    } else if (type == 3) {
        cs = document.getElementById('civil_status_co');
        cs = cs.value;
        if (cs == 4) {
            document.getElementById('matrimonial_regime_co').removeAttribute("disabled");
        } else {
            $("#matrimonial_regime_co").val("5");
            $("#spouce_co").val("");
            document.getElementById('matrimonial_regime_co').setAttribute("disabled", "true");
            document.getElementById('spouce_co').setAttribute("disabled", "true");
        }
    }
}

function validateMatrimonialRegime(type) {
    if (type == 1 || type == 2) {
        mr = document.getElementById('matrimonial_regime');
        mr = mr.value;
        if (mr == 1) {
            document.getElementById('spouce').removeAttribute("readonly");
        } else {
            $("#spouce").val("");
            document.getElementById('spouce').setAttribute("readonly", "true");
        }
    } else if (type == 3) {
        mr = document.getElementById('matrimonial_regime_co');
        mr = mr.value;
        if (mr == 1) {
            document.getElementById('spouce_co').removeAttribute("readonly");
        } else {
            $("#spouce").val("");
            document.getElementById('spouce_co').setAttribute("readonly", "true");
        }
    }
}


function getAdvisers(element) {
    sede = $('option:selected', element).attr('data-sede');
    $("#myselectasesor").find("option").remove();
    $.post('getAdvisers/' + sede, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectasesor").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $("#myselectasesor").selectpicker('refresh');
    }, 'json');
}
var selectGerente;
var selectCoordinador;
var selectAsesor;
//SELECT gerente
function getManagers() {
    $("#myselectgerente2").find("option").remove();
    $.post('getManagers/', function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectgerente2").append($('<option>').val(id).attr('data-sede', sede).text(name));
            $("#myselectgerente2").selectpicker('refresh');
        }
        if (len <= 0) {
            $("#myselectgerente2").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $("#myselectgerente2").selectpicker('refresh');
        selectGerente = $("#myselectgerente2").val();
    }, 'json');
}

function getCoordinatorsByManager(element) {
    gerente = $('option:selected', element).val();
    $("#myselectcoordinador").find("option").remove();
    $.post('getCoordinatorsByManager/' + gerente, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectcoordinador").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectcoordinador").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $("#myselectcoordinador").selectpicker('refresh');
        selectCoordinador = $("#myselectcoordinador").val();

    }, 'json');
}

function getAdvisersByCoordinator(element) {
    coordinador = $('option:selected', element).val();
    $("#myselectasesor3").find("option").remove();
    $.post('getAdvisersByCoordinator/' + coordinador, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor3").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectasesor3").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $("#myselectasesor3").selectpicker('refresh');
        selectAsesor = $("#myselectasesor3").val();
    }, 'json');
}

function getAge(type) {
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

function printProspectInfo() {
    id_prospecto = $("#prospecto_lbl").val();
    window.open("printProspectInfo/" + id_prospecto, "_blank")
}

function printProspectInfoMktd() {
    id_prospecto = $("#prospecto_lbl").val();
    window.open("printProspectInfoMktd/" + id_prospecto, "_blank")
}

function fillFields(v, type) {
    $("#name").val(v.nombre).attr('readonly', false);
    $("#last_name").val(v.apellido_paterno).attr('readonly', false);
    $("#mothers_last_name").val(v.apellido_materno).attr('readonly', false);
    if (type == 0) {
        $("#nationality").val(v.nacionalidad);
        $("#legal_personality").val(v.personalidad_juridica);
        $("#curp").val(v.curp);
        $("#rfc").val(v.rfc);
        v.source != 0 && v.editProspecto == 0 ? $("#name").val(v.nombre) : $("#name").val(v.nombre).attr('readonly', true);
        v.source != 0 && v.editProspecto == 0 ? $("#last_name").val(v.apellido_paterno) : $("#last_name").val(v.apellido_paterno).attr('readonly', true);
        v.source != 0 && v.editProspecto == 0 ? $("#mothers_last_name").val(v.apellido_materno) : $("#mothers_last_name").val(v.apellido_materno).attr('readonly', true);
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
        if (v.antiguedad != '' || v.antiguedad == 0) {
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

function fillTimeline(v) {
    $("#comments-list").append(
        '<li>\n' +
        '    <div class="container-fluid">\n' +
        '       <div class="row">\n' +
        '           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">\n' +
        '               <a><small>Creador por: </small><b>' + v.creador + '</b></a><br>\n' +
        '           </div>\n' +
        '           <div class="float-end text-right">\n' +
        '               <a>' + v.fecha_creacion + '</a>\n' +
        '           </div>\n' +
        '           <div class="col-md-12">\n' +
        '                <p class="m-0"><small>Comentario: </small><b> ' + v.observacion + '</b></p>\n' +
        '           </div>\n' +
        '       </div>\n' +
        '    </div>\n' +
        '</li>'
    );
}

function fillChangelog(v) {
    $("#changelog").append('<li>\n' +
        '    <div class="container-fluid">\n' +
        '       <div class="row">\n' +
        '           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">\n' +
        '               <a><small>Campo: </small><b>' + v.parametro_modificado.toUpperCase() + '</b></a><br>\n' +
        '           </div>\n' +
        '           <div class="float-end text-right">\n' +
        '               <a>' + v.fecha_creacion + '</a>\n' +
        '           </div>\n' +
        '           <div class="col-md-12">\n' +
        '             <p class="m-0"><small>Usuario: </small><b> ' + v.creador.toUpperCase() + '</b></p>\n' +
        '             <p class="m-0"><small>Valor anterior: </small><b> ' + v.anterior.toUpperCase() + '</b></p>\n' +
        '             <p class="m-0"><small>Valor Nuevo: </small><b> ' + v.nuevo.toUpperCase() + '</b></p>\n' +
        '           </div>\n' +
        '        <h6>\n' +
        '        </h6>\n' +
        '       </div>\n' +
        '    </div>\n' +
        '</li>');
}

function cleanComments() {
    var myCommentsList = document.getElementById('comments-list');
    myCommentsList.innerHTML = '';
    var myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
}

$(document).on('click', '.change-reference-status', function () {
    estatus = $(this).attr("data-estatus");
    $.ajax({
        type: 'POST',
        url: 'changeReferenceStatus',
        data: { 'id_referencia': $(this).attr("data-id-referencia"), 'estatus': $(this).attr("data-estatus") },
        dataType: 'json',
        success: function (data) {
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
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.update-validity', function () {
    $.ajax({
        type: 'POST',
        url: 'updateValidity',
        data: { 'id_prospecto': $(this).attr("data-id-prospecto") },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "La vigencia de tu prospecto se ha renovado exitosamente.", "success");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.change-status', function () {
    estatus = $(this).attr("data-estatus");
    $.ajax({
        type: 'POST',
        url: 'changeSalesPartnerStatus',
        data: { 'id_vcompartida': $(this).attr("data-id-vcompartida"), 'estatus': $(this).attr("data-estatus") },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                if (estatus == 1) {
                    alerts.showNotification("top", "right", "Se ha activado con éxito.", "success");
                } else {
                    alerts.showNotification("top", "right", "Se ha desactivado con éxito.", "success");
                }
                $sharedSalesTable.ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.to-comment', function (e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#comment").val("");
    $("#id_prospecto").val(id_prospecto);
    $(".label-floating").removeClass("is-empty");

    changeSizeModal('modal-md');
    appendBodyModal(`
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            <i class="material-icons">clear</i>
        </button>
        <h4 class="modal-title">Ingresa tus comentarios</h4>
    </div>
    <form id="my-comment-form" name="my-comment-form" method="post">
        <div class="modal-body">
            <textarea class="text-modal" type="text" name="observations" id="observations" autofocus="true">
            </textarea>
            <input name="id_prospecto" id="id_prospecto" value="${id_prospecto}" hidden>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="coment">Aceptar</button>
        </div>
    </form>`);
    showModal();
});

$(document).on('click', '#coment', function (e) {

    var dataExp = new FormData();
    var observations = $("#observations").val();
    var id_prospecto = $("#id_prospecto").val();
    dataExp.append("observations", observations);
    dataExp.append("id_prospecto", id_prospecto);
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: 'saveComment',
        data: dataExp,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
        },
        success: function (data) {
            if (data == 1) {
                $('#blank-modal').modal("hide");
                $('#observations').val('');
                alerts.showNotification("top", "right", "El comentario se ha ingresado exitosamente.", "success");
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                console.log(data);
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function openTab(evt, tabName) {
    var i, x, tablinks;
    x = document.getElementsByClassName("tabs");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" tab-selected", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " tab-selected";
  }

$(document).on('click', '.edit-information', function (e) {





























    id_prospecto = $(this).attr("data-id-prospecto");
    source = $(this).attr("data-source");
    editProspecto = $(this).attr("data-editProspecto");
    owner = $(this).attr("data-owner");
    $.getJSON("getProspectInformation/" + id_prospecto).done(function (data) {
        $.each(data, function (i, v) {
            changeSizeModal('modal-lg');
            appendBodyModal(`

        <div class="worko-tabs">

            <div class="modal-header">
                <h4 class="modal-title">Editar Información</h4>
            </div>
            <br>
            <input class="state" type="radio" title="tab-one" name="tabs-state" id="tab-one" checked />
            <input class="state" type="radio" title="tab-two" name="tabs-state" id="tab-two" />
            <input class="state" type="radio" title="tab-three" name="tabs-state" id="tab-three" />
        
            <div class="tabs flex-tabs">
                <label for="tab-one" id="tab-one-label" class="tab">#1 Acerca de</label>
                <label for="tab-two" id="tab-two-label" class="tab">#2 Empleo</label>
                <label for="tab-three" id="tab-three-label" class="tab">#3 Prospección</label>
        
                <div class="modal-body">
                    <div id="tab-one-panel" class="panel active">
                  
                                <div class="col-sm-3">
                                    <div class="form-group select-is-empty overflow-hidden">
                                        <label class="control-label">Nacionalidad<small id="lbl-nacionalidad"> (requerido)</small></label>
                                        <select id="nationality" name="nationality"class="selectpicker select-gral m-0"
                                            data-style="btn" data-show-subtext="true" data-live-search="true"
                                            title="Selecciona una opción" data-size="7" data-container="body" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group select-is-empty overflow-hidden">
                                        <label class="control-label">Personalidad jurídica<small id="lbl-personalidad">
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
                                        <label class="control-label">Nombre / Razón social<small id="lbl-razon">
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
                                        <label class="control-label">Teléfono celular<small id="lbl-tel"> (requerido)</small></label>
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
                                <br>
                                <div class="col-sm-3">La casa donde vive es</div>
                                <div class="col-lg-12 text-center">
                                    <div class="radio-inline">
                                        <label><input id="own" class="lives_at_home" name="lives_at_home" type="radio" value="1"> Propia</label>
                                    </div>
                                    <div class="radio-inline">
                                        <label><input id="rented" class="lives_at_home" name="lives_at_home" type="radio" value="2">
                                            Rentada</label>
                                    </div>
                                    <div class="radio-inline">
                                        <label><input id="paying" class="lives_at_home" name="lives_at_home" type="radio" value="3">
                                            Pagándose</label>
                                    </div>
                                    <div class="radio-inline">
                                        <label><input id="family" class="lives_at_home" name="lives_at_home" type="radio" value="4">
                                            Familiar</label>
                                    </div>
                                    <div class="radio-inline">
                                        <label><input id="other" class="lives_at_home" name="lives_at_home" type="radio" value="5"> Otro</label>
                                    </div>
                                </div>
                
                    </div>
                    </div>
                <div id="tab-two-panel" class="panel">
                
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
                <div id="tab-three-panel" class="panel">
                
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
                                    <label class="control-label">Plaza de venta<small id="lbl-plaza"> (requerido)</small></label>
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
                                    <input type="hidden" name="id_prospecto_ed" id="id_prospecto_ed" value="${id_prospecto}">
                                    <input type="hidden" name="owner" id="owner">
                                    <input type="hidden" name="source" id="source">
                                    <input type="hidden" name="editProspecto" id="editProspecto">
                                </div>
                            </div>

                </div>
            </div>

            <div class="modal-footer">
                        <div class="pull-right">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn" id="edit-form1" class="btn" style="background-color: #4caf50;">Finalizar</button>
                        </div>
                    </div>
        
        </div>`);
            showModal();

            $.getJSON("fillSelects").done(function(data) {
                $(".advertising").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        
                $("#estatus_particular2").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
                $("#estatus_particular").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
                for (let i = 0; i < data.length; i++) {
                    if (data[i]['id_catalogo'] == 5) // SALES PLAZA SELECT
                    $("#sales_plaza").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
                    if (data[i]['id_catalogo'] == 7) // ADVERTISING SELECT
                        $(".advertising").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                    if (data[i]['id_catalogo'] == 9){ // PROSPECTING PLACE SELECT
                        //$(".prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                        if (data[i]['id_opcion'] == 6 || data[i]['id_opcion'] == 31) { // SON LOS DOS LP DE MKTD
                            $("#prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']).addClass("boldtext")).selectpicker('refresh');
                        } else { // SON OTROS LP
                            $("#prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
                        }
                    }
                    if (data[i]['id_catalogo'] == 10) // LEGAL PERSONALITY SELECT
                        $("#legal_personality").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
                    if (data[i]['id_catalogo'] == 11) // NATIONALITY SELECT
                        $("#nationality").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
                    if (data[i]['id_catalogo'] == 18) // CIVIL STATUS SELECT
                        $("#civil_status").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
                    if (data[i]['id_catalogo'] == 19) // MATRIMONIAL REGIME SELECT
                        $("#matrimonial_regime").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
                    if (data[i]['id_catalogo'] == 38) { // STATUS PARTICULAR 2 SELECT
                        $("#estatus_particular").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                        $("#estatus_particular2").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                        $("#estatus_particular").selectpicker('refresh');
                        $("#estatus_particular2").selectpicker('refresh');
                    }
                }
                $("#nationality").val(v.nacionalidad).selectpicker("refresh");
                $("#legal_personality").val(v.personalidad_juridica).selectpicker("refresh");
                $("#civil_status").val(v.estado_civil).selectpicker("refresh");
                $("#matrimonial_regime").val(v.matrimonial_regime).selectpicker("refresh");
                $("#sales_plaza").val(v.plaza_venta).selectpicker("refresh");
            });
            
            $("#prospecting_place option[value="+v.lugar_prospeccion+"]").attr("selected", true);
            $("#prospecting_place").selectpicker("refresh");
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

$(document).on('click', '#edit-form1', function (e) {

    if($("#nationality").val() == '' ){
        $("#lbl-nacionalidad").addClass("dateReq");
    }
    if($("#legal_personality").val() == '' ){
        $("#lbl-personalidad").addClass("dateReq");
    }
    if($("#name").val() == '' ){
        $("#lbl-razon").addClass("dateReq");
    }
    if($("#sales_plaza").val() == '' ){
        $("#lbl-plaza").addClass("dateReq");
    }

    let form = 1;
    var dataExp2 = new FormData();
    var nationality = $("#nationality").val();
    var legal_personality = $("#legal_personality").val();
    var curp = $("#curp").val();
    var rfc = $("#rfc").val();
    var name = $("#name").val();
    var last_name = $("#last_name").val();
    var mothers_last_name = $("#mothers_last_name").val();
    var date_birth = $("#date_birth").val();
    var company_antiquity = $("#company_antiquity").val();
    var email = $("#email").val();
    var phone_number2 = $("#phone_number2").val();
    var civil_status = $("#civil_status").val();
    var matrimonial_regime = $("#matrimonial_regime").val();
    var spouce = $("#spouce").val();
    var from = $("#from").val();
    var home_address = $("#home_address").val();
    var lives_at_home = $(".lives_at_home").val();
    var id_prospecto_ed = $("#id_prospecto_ed").val();

    var occupation = $("#occupation").val();
    var company = $("#company").val();
    var position = $("#position").val();
    var antiquity = $("#antiquity").val();
    var company_residence = $("#company_residence").val();

    var observation = $("#observation").val();
    var sales_plaza = $("#sales_plaza").val();
    
    dataExp2.append("nationality", nationality);
    dataExp2.append("legal_personality", legal_personality);
    dataExp2.append("curp", curp);
    dataExp2.append("rfc", rfc);
    dataExp2.append("name", name);
    dataExp2.append("last_name", last_name);
    dataExp2.append("mothers_last_name", mothers_last_name);
    dataExp2.append("date_birth", date_birth);
    dataExp2.append("company_antiquity", company_antiquity);
    dataExp2.append("email", email);
    dataExp2.append("phone_number2", phone_number2);
    dataExp2.append("civil_status", civil_status);
    dataExp2.append("matrimonial_regime", matrimonial_regime);
    dataExp2.append("spouce", spouce);
    dataExp2.append("from", from);
    dataExp2.append("home_address", home_address);
    dataExp2.append("lives_at_home", lives_at_home);
    dataExp2.append("form", form);
    dataExp2.append("id_prospecto_ed", id_prospecto_ed);

    dataExp2.append("occupation", occupation);
    dataExp2.append("company", company);
    dataExp2.append("position", position);
    dataExp2.append("antiquity", antiquity);
    dataExp2.append("company_residence", company_residence);

    dataExp2.append("sales_plaza", sales_plaza);
    dataExp2.append("observation", observation);
    
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: 'updateProspect',
        data: dataExp2,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
        },
        success: function (data) {
            if (data == 1) {
                $('#blank-modal').modal("hide");
                $("#lbl-personalidad").removeClass("dateReq");
                $("#lbl-nacionalidad").removeClass("dateReq");
                $("#lbl-plaza").removeClass("dateReq");
                $("#lbl-razon").removeClass("dateReq");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.re-asign', function (e) {
    var id_prospecto = $(this).attr("data-id-prospecto");
    $("#id_prospecto").val(id_prospecto)
    $("#myReAsignModal").modal();

    changeSizeModal('modal-lg');
    appendBodyModal(`
                    <div class="modal-header">
                        <h4 class="modal-title">Asignación de prospecto</h4>
                    </div>
                    <div class="modal-body">
                        <form id="my_reasign_form_ve" name="my_reasign_form_ve" method="post">
                            <div class="col-lg-12">
                                <div class="col-lg-12" name="sedeForm" id="sedeForm">
                                    <label class="control-label">Sede</label>
                                    <select name="sede" id="sede" onchange="changeSede()" class="selectpicker select-gral m-0" data-style="btn"
                                        data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN"
                                        data-size="7" data-container="body" required>
                                    </select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Asesor">
                                    <label class="control-label">Asesor</label>
                                    <select class="selectpicker select-gral m-0" name="asesor" id="asesor"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Coor">
                                    <label class="control-label">Coordinador</label>
                                    <select class="selectpicker select-gral m-0" name="coordinador" id="coordinador"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Gere">
                                    <label class="control-label">Gerente</label>
                                    <select class="selectpicker select-gral m-0" name="gerente" id="gerente"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Sub">
                                    <label class="control-label">Subdirector</label>
                                    <select class="selectpicker select-gral m-0" name="subdirector" id="subdirector"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Dr">
                                    <label class="control-label">Director regional</label>
                                    <select class="selectpicker select-gral m-0" name="DireRegional" id="DireRegional"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>
                                <div class="col-sm-4 hide" id="form-Dr2">
                                    <label class="control-label">Director regional 2</label>
                                    <select class="selectpicker select-gral m-0" name="DireRegional2" id="DireRegional2"
                                        data-style="btn" data-live-search="true" data-style="select-with-transition"
                                        title="Selecciona una opción" data-size="7" required></select>
                                </div>

                                <input type="hidden" name="id_prospecto" id="id_prospecto">
                                <br>
                                <br>
                            </div>

                            <div class="modal-footer">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-end pt-1">
                                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                                        id="close">Cancelar</button>
                                    <button type="button" id="con1" class="btn btn-primary hide">Aceptar</button>
                                    <button type="button" id="con2" class="btn btn-primary hide">Aceptar</button>
                                    <button type="button" id="con3" class="btn btn-primary hide">Aceptar</button>
                                </div>
                            </div>
                        </form>
                    </div>`);
                    $.post(`${general_base_url}Prospectos/getSedesProspectos`, function (data) {
                        for (var i = 0; i < data.length; i++) {
                            $("#sede").append($('<option>').val(data[i]['id_sede']).text(data[i]['nombre']));
                        }
                        $("#sede").selectpicker('refresh');
                    }, 'json');
    showModal();

});

$(document).on('click', '.see-information', function (e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#seeInformationModal").modal();
    changeSizeModal('modal-lg');
    appendBodyModal(`
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
                </div>`);
                    $.post(`${general_base_url}Prospectos/getSedesProspectos`, function (data) {
                        for (var i = 0; i < data.length; i++) {
                            $("#sede").append($('<option>').val(data[i]['id_sede']).text(data[i]['nombre']));
                        }
                        $("#sede").selectpicker('refresh');
                    }, 'json');
    showModal();



    $("#prospecto_lbl").val(id_prospecto);
    $.getJSON("getInformationToPrint/" + id_prospecto).done(function (data) {
        $.each(data, function (i, v) {
            fillFields(v, 1);
        });
    });
    $.getJSON("getComments/" + id_prospecto).done(function (data) {
        if (data.length == 0) {
            $("#comments-list").append('SIN DATOS POR MOSTRAR');
        } else {
            counter = 0;
            $.each(data, function (i, v) {
                counter++;
                fillTimeline(v, counter);
            });
        }
    });
    $.getJSON("getChangelog/" + id_prospecto).done(function (data) {
        if (data.length == 0) {
            $("#changelog").append('SIN DATOS POR MOSTRAR');
        } else {
            $.each(data, function (i, v) {
                fillChangelog(v);
            });
        }
    });
});

$(document).on("click", "#con1", function (e) {
    e.preventDefault();

    let asesor = $("#asesor").val();
    let coordinador = $("#coordinador").val();
    let gerente = $("#gerente").val();
    let subdirector = $("#subdirector").val();
    let id_prospecto = $("#id_prospecto").val();

    var dataExp = new FormData();

    dataExp.append("asesor", asesor);
    dataExp.append("coordinador", coordinador);
    dataExp.append("gerente", gerente);
    dataExp.append("subdirector", subdirector);
    dataExp.append("id_prospecto", id_prospecto);

    $("#spiner-loader").removeClass("hide");
    $("#con1").prop("disabled", true);
    $.ajax({
        url: `${general_base_url}Asesor/updateProspecto1`,
        data: dataExp,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function (data) {
            response = JSON.parse(data);
            if (response.message == "OK") {
                $("#con1").prop("disabled", false);
                $('#blank-modal').modal("hide");
                $("#prospects-datatable").DataTable().ajax.reload();
                alerts.showNotification(
                    "top",
                    "right",
                    "Abono Registrado",
                    "success"
                );
                $("#spiner-loader").addClass("hide");
            }
        },
        error: function (data) {
            $("#con1").prop("disabled", false);
            $('#blank-modal').modal("hide");
            $("#prospects-datatable").DataTable().ajax.reload();
            alerts.showNotification(
                "top",
                "right",
                "Error al enviar la solicitud.",
                "danger"
            );
            $("#spiner-loader").addClass("hide");
        },
    });
});

$(document).on("click", "#con2", function (e) {

    let asesor = $("#asesor").val();
    let coordinador = $("#coordinador").val();
    let gerente = $("#gerente").val();
    let subdirector = $("#subdirector").val();
    let DireRegional = $("#DireRegional").val();
    let DireRegional2 = $("#DireRegional2").val();
    let id_prospecto = $("#id_prospecto").val();

    var dataExp2 = new FormData();

    dataExp2.append("asesor", asesor);
    dataExp2.append("coordinador", coordinador);
    dataExp2.append("gerente", gerente);
    dataExp2.append("subdirector", subdirector);
    dataExp2.append("DireRegional", DireRegional);
    dataExp2.append("DireRegional2", DireRegional2);
    dataExp2.append("id_prospecto", id_prospecto);

    $("#spiner-loader").removeClass("hide");
    $("#con2").prop("disabled", true);
    $.ajax({
        url: `${general_base_url}Asesor/updateProspecto2`,
        data: dataExp2,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function (data) {
            response = JSON.parse(data);
            if (response.message == "OK") {
                $("#con2").prop("disabled", false);
                $('#blank-modal').modal("hide");
                $("#prospects-datatable").DataTable().ajax.reload();
                alerts.showNotification(
                    "top",
                    "right",
                    "Abono Registrado",
                    "success"
                );
                $("#spiner-loader").addClass("hide");
            }
        },
        error: function (data) {
            $("#con2").prop("disabled", false);
            $('#blank-modal').modal("hide");
            $("#prospects-datatable").DataTable().ajax.reload();
            alerts.showNotification(
                "top",
                "right",
                "Error al enviar la solicitud.",
                "danger"
            );
            $("#spiner-loader").addClass("hide");
        },
    });
});

$(document).on("click", "#con3", function (e) {
    e.preventDefault();

    let asesor = $("#asesor").val();
    let coordinador = $("#coordinador").val();
    let gerente = $("#gerente").val();
    let subdirector = $("#subdirector").val();
    let DireRegional = $("#DireRegional").val();
    let id_prospecto = $("#id_prospecto").val();

    var dataExp3 = new FormData();

    dataExp3.append("asesor", asesor);
    dataExp3.append("coordinador", coordinador);
    dataExp3.append("gerente", gerente);
    dataExp3.append("subdirector", subdirector);
    dataExp3.append("DireRegional", DireRegional);
    dataExp3.append("id_prospecto", id_prospecto);

    $("#spiner-loader").removeClass("hide");
    $("#con3").prop("disabled", true);
    $.ajax({
        url: `${general_base_url}Asesor/updateProspecto3`,
        data: dataExp3,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function (data) {
            response = JSON.parse(data);
            if (response.message == "OK") {
                $("#con3").prop("disabled", false);
                $('#blank-modal').modal("hide");
                $("#prospects-datatable").DataTable().ajax.reload();
                alerts.showNotification(
                    "top",
                    "right",
                    "Abono Registrado",
                    "success"
                );
                $("#spiner-loader").addClass("hide");
            }
        },
        error: function (data) {
            $("#con3").prop("disabled", false);
            $('#blank-modal').modal("hide");
            $("#prospects-datatable").DataTable().ajax.reload();
            alerts.showNotification(
                "top",
                "right",
                "Error al enviar la solicitud.",
                "danger"
            );
            $("#spiner-loader").addClass("hide");
        },
    });
});

$(document).on('click', '.update-status', function (e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    telefono = $(this).attr("data-telefono");
    telefono2 = $(this).attr("data-telefono2");

    changeSizeModal('modal-md');
    appendBodyModal(`
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
                            <button type="button" id="updateStatus" class="btn btn-primary finishS">Aceptar</button>
                        </div>
                    </div>
                    <input type="hidden" name="id_prospecto_estatus_particular" id="id_prospecto_estatus_particular" value="${id_prospecto}">
                    <input type="hidden" id="telefono1" name="${telefono}" value="${telefono}">
                    <input type="hidden" id="telefono2" name="${telefono2}" value="${telefono2}">
                </div>
            </form>`);
    showModal();

    $.getJSON("fillSelects").done(function(data) {
        $(".advertising").append($('<option disabled selected>').val("0").text("Seleccione una opción"));

        $("#estatus_particular2").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        $("#estatus_particular").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        for (let i = 0; i < data.length; i++) {
            if (data[i]['id_catalogo'] == 5) // SALES PLAZA SELECT
            $("#sales_plaza").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 7) // ADVERTISING SELECT
                $(".advertising").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            if (data[i]['id_catalogo'] == 9){ // PROSPECTING PLACE SELECT
                //$(".prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                if (data[i]['id_opcion'] == 6 || data[i]['id_opcion'] == 31) { // SON LOS DOS LP DE MKTD
                    $("#prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']).addClass("boldtext")).selectpicker('refresh');
                } else { // SON OTROS LP
                    $("#prospecting_place").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
                }
            }
            if (data[i]['id_catalogo'] == 10) // LEGAL PERSONALITY SELECT
                $("#legal_personality").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 11) // NATIONALITY SELECT
                $("#nationality").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 18) // CIVIL STATUS SELECT
                $("#civil_status").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 19) // MATRIMONIAL REGIME SELECT
                $("#matrimonial_regime").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre'])).selectpicker('refresh');
            if (data[i]['id_catalogo'] == 38) { // STATUS PARTICULAR 2 SELECT
                $("#estatus_particular").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                $("#estatus_particular2").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
                $("#estatus_particular").selectpicker('refresh');
                $("#estatus_particular2").selectpicker('refresh');
            }
        }
    });
    
});

$(document).on('click', '#updateStatus', function (e) {

    var id_prospecto = $("#id_prospecto_estatus_particular").val();
    var estatus_particular = $("#estatus_particular").val();
    var telefono1 = $('#telefono1').val();
    var telefono2 = $('#telefono2').val();

    $.post('../Calendar/getStatusRecordatorio', function (data) {
        $("#estatus_recordatorio").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatus_recordatorio").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#estatus_recordatorio").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $("#estatus_recordatorio").selectpicker('refresh');
    }, 'json');

    e.preventDefault();
    if (estatus_particular == 3) {
        cleanModal();
        changeSizeModal('modal-md');
        appendBodyModal(`
                        <div class="modal-header mb-1">
                        <h4 class="modal-title text-center">Detalles de la cita</h4>
                    </div>
                    <div class="container-fluid">
                        <form method="post">
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
                            <input type="hidden" name="id_prospecto_estatus_particular" id="id_prospecto_estatus_particular" value="${id_prospecto}">
                            <input type="hidden" name="estatus_particular" id="estatus_particular" value="${estatus_particular}">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"
                                    onclick="cleanSelects()">Cancelar</button>
                                <button type="button" id="cita-form" class="btn btn-primary finishS">Aceptar</button>
                            </div>
                        </form>
                    </div>`);
        showModal();

        $("#estatus_recordatorio").on('change', function (e) {
            var medio = $("#estatus_recordatorio").val();
            var box = $("#comodinDIV");
            validateNCreate(medio, box);
        });
        
        function validateNCreate(medio, box) {
            box.empty();
           
            if (medio == 2 || medio == 5) {
                box.append(`<label class="m-0">Dirección del ${medio == 5 ? 'evento' : 'recorrido'}</label><input id="direccion" name="direccion" type="text" class="form-control input-gral" value='' required>`);
            }
            else if (medio == 3) {
                box.append(`<div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-6 col-lg-6 pl-0 m-0"><label class="m-0">Teléfono 1</label><input type="text" class="form-control input-gral" value=${telefono1 != 'undefined' ? telefono1 : ''} disabled></div>`
                    + `<div class="col-sm-12 col-md-6 col-lg-6 pr-0 m-0"><label class="m-0">Teléfono 2</label><input type="text" class="form-control input-gral" id="telefono2" name="telefono2" value=${telefono2 != 'undefined' ? telefono2 : ''}  ></div></div></div>`);
            }
            else if (medio == 4) {
                box.append(`<div class="col-sm-12 col-md-12 col-lg-12 p-0"><label class="m-0">Dirección de oficina</label><select class="selectpicker select-gral m-0 w-100" name="id_direccion" id="id_direccion" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select></div>`);
                getOfficeAddresses();
            }
            box.removeClass('hide');
        }

       
    } else {

        var dataExp3 = new FormData();
        dataExp3.append("estatus_particular", estatus_particular);
        dataExp3.append("id_prospecto_estatus_particular", id_prospecto);
        id_prospecto

        $.ajax({
            type: 'POST',
            url: 'updateStatus',
            data: dataExp3,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
            },
            success: function (data) {
                if (data == 1) {
                    $('#blank-modal').modal("hide");
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
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }

});

function cleanSelects() {
    $('#estatus_particular').val("0");
    $("#estatus_particular").selectpicker("refresh");
}

function getPersonsWhoRecommends() {
    $.getJSON("getCAPListByAdvisor").done(function (data) {
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

function cleanCombos() {
    $("#specify").val("0");
    $("#specify_mkt").val("0");
    $("#specify_recommends").val("0");
    $("#specify").css({ "display": "none" });
    $("#specify_mkt").css({ "display": "none" });
    $("#specify_recommends").css({ "display": "none" });
}

function validateParticularStatus(element) {
    estatus = $('option:selected', element).val();
    if (estatus == 6) {
        document.getElementById("datatoassign").style.display = "block";
    } else {
        document.getElementById("datatoassign").style.display = "none";
        $("#condominio").empty().selectpicker('refresh');
        $("#lote").empty().selectpicker('refresh');
    }
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

function compareDates(fecha_creacion) {
    var isBefore = moment(fecha_creacion).isBefore('2022-01-20T00:00:00Z');
    return isBefore;
}

$(document).on('click', '#cita-form', function (e) {
    e.preventDefault();

    const data = Object.fromEntries(new FormData());

    data['estatus_particular'] = $('#estatus_particular').val();
    data['id_prospecto_estatus_particular'] = $('#id_prospecto_estatus_particular').val();
    data['evtTitle'] = $("#evtTitle").val();
    data['estatus_recordatorio'] = $("#estatus_recordatorio").val();
    data['dateStart'] = $("#dateStart").val();
    data['dateEnd'] = $("#dateEnd").val();
    data['description'] = $("#description").val();
    data['direccion'] = $("#direccion").val();

    $.ajax({
        type: 'POST',
        url: 'insertRecordatorio',
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
            $('#blank-modal').modal("hide");
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
        },
        error: function() {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function getStatusRecordatorio() {
    $.post('../Calendar/getStatusRecordatorio', function (data) {
        $("#estatus_recordatorio").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatus_recordatorio").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#estatus_recordatorio").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $("#estatus_recordatorio").selectpicker('refresh');
    }, 'json');
}



function getOfficeAddresses() {
    $.post('../Calendar/getOfficeAddresses', function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_direccion'];
            var direccion = data[i]['direccion'];
            $("#id_direccion").append($('<option>').val(id).text(direccion));
        }
        if (len <= 0) {
            $("#id_direccion").append('<option selected="selected" disabled>NINGUNA OPCIÓN</option>');
        }
        $("#id_direccion").selectpicker('refresh');
    }, 'json');
}

function cleanModal() {
    $('#evtTitle').val('');
    $("#prospecto option:selected").prop("selected", false);
    $("#prospecto").selectpicker('refresh');
    $("#estatus_recordatorio option:selected").prop("selected", false);
    $("#estatus_recordatorio").selectpicker('refresh');
    $("#description").val('');
    $("#comodinDIV").addClass('hide');
}