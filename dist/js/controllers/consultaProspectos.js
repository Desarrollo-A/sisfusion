$(document).ready(function() {
    sp.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    setInitialValues();
    getStatusRecordatorio();
});
    /*---INPUT SEARCH-----*/

    $('#prospects-datatable thead tr:eq(0) th').each(function (i) {
        const title = $(this).text();
        if ( i != 9 ){
            $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($("#prospects-datatable").DataTable().column(i).search() !== this.value) {
                    $("#prospects-datatable").DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }
    });

    function fillTable(transaction, beginDate, endDate, where) {
        prospectsTable = $('#prospects-datatable').DataTable({
            dom: 'rt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: 'auto',
            columns: [{
                data: function(d) {
                    if (d.estatus == 1) {
                        return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
                    } else {
                        return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
                    }
                }

            },
            {
                data: function(d) {

                    if (d.estatus_particular == 1) { // DESCARTADO
                        b = '<center><span class="label" style="background:#E74C3C">Descartado</span><center>';
                    } else if (d.estatus_particular == 2) { // INTERESADO SIN CITA
                        b = '<center><span class="label" style="background:#B7950B">Interesado sin cita</span><center>';
                    } else if (d.estatus_particular == 3) { // CON CITA
                        b = '<center><span class="label" style="background:#27AE60">Con cita</span><center>';
                    } else if (d.estatus_particular == 4) { // SIN ESPECIFICAR
                        b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
                    } else if (d.estatus_particular == 5) { // PAUSADO
                        b = '<center><span class="label" style="background:#2E86C1">Pausado</span><center>';
                    } else if (d.estatus_particular == 6) { // PREVENTA
                        b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
                    } else if (d.estatus_particular == 7) { // CLIENTE
                        b = '<center><span class="label" style="background:#27AE60">Cliente</span><center>';
                    } else { // CLIENTE
                        b = '<center><span class="label" style="background:#A569BD">Sin especificar</span><center>';
                    }
                    return b;
                }
            },
            {
                data: function(d) {
                    return d.nombre + '<br>' +'<span class="label" style="background:#1ABC9C">'+ d.id_prospecto +'</span>';
                }
            },
            {
                data: function(d) {
                    return d.asesor;
                }
            },
            {
                data: function(d) {
                    return d.coordinador;
                }
            },
            {
                data: function(d) {
                    return d.gerente;
                }
            },
            {
                data: function(d) {
                    return d.nombre_lp;
                }
            },
            {
                data: function(d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function(d) {
                    return d.fecha_vencimiento;
                }
            },
            {
                data: function(d) {
                    if (typeTransaction == 0) { // Marketing
                        if (userType == "18" || userType == "19" || userType == "20") { // Array de roles permitidos para reasignar
                            userType == "20" ? change_buttons = '<button class="btn-data btn-warning change-pl mt-1" data-id-prospecto="' + d.id_prospecto +'" rel="tooltip" data-placement="left" title="Remover MKTD de este prospecto"><i class="fas fa-trash"></i></button>' : change_buttons = '';
                            if (d.estatus == 1) { // IS ACTIVE
                                var actions = '';
                                var group_buttons = '';
                                group_buttons += '<button class="btn-data btn-orangeYellow to-comment" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="far fa-comments"></i></button>' +
                                    '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Editar información"><i class="fas fa-pencil-alt"></i></button>' +
                                    '<button class="btn-data btn-sky see-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ver información"><i class="far fa-eye"></i></button>' +
                                    '<button class="btn-data btn-violetChin re-asign" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Re - asignar"><i class="fab fa-rev"></i></button>';

                                actions += '<button class="desplegable btn-data btn-deepGray" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><i class="fas fa-chevron-up"></i></button>';
                                actions += '<div class="hide boxSBtns" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn-data btn-deepGray"><i class="fas fa-chevron-down"></i></button></div>';
                                actions += '<button class="btn-data btn-gray update-status" data-id-prospecto="' + d.id_prospecto + '" title="Actualizar estatus"><i class="fas fa-redo"></i>' + change_buttons;
                                return '<center>'+actions+'<center>';
                            } else { // IS NOT ACTIVE
                                var actions = '';
                                if (d.vigencia >= 0 /*< 5 && d.fecha_creacion >= '2021-04-19 23:59:59.000'*/) {
                                    actions += '<button class="btn-data btn-deepGray update-validity" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Renovar vigencia"><i class="fas fa-history"></i></button>';
                                }
                                actions += change_buttons;
                                return '<center>'+actions+'</center>';
                            }
                        }
                    } else if (typeTransaction == 1) { // Ventas
                        if (userType != "19") { // Subdirecctor MKTD puede ver listado todos los prospectos pero no tiene ninguna acción sobre ellos
                            if (userType == "3" || userType == "6") { // Array de roles permitidos para reasignar
                                if (d.estatus == 1) {
                                    var actions = '';
                                    var group_buttons = '';
                                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                                        actions = '';
                                    } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                        group_buttons = '<button class="btn-data btn-orangeYellow to-comment" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="far fa-comments"></i></button>' +
                                            '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Editar información"><i class="fas fa-pencil-alt"></i></button>' +
                                            '<button class="btn-data btn-sky see-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ver información"><i class="far fa-eye"></i></button>' +
                                            '<button class="btn-data btn-violetChin re-asign" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Re - asignar"><i class="fab fa-rev"></i></button>';
                                        actions += '<button class="desplegable btn-data btn-deepGray" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><i class="fas fa-chevron-up"></i></button>';
                                        actions += '<div class="hide boxSBtns" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn-data btn-deepGray"><i class="fas fa-chevron-down"></i></button></div>';
                                        actions += '<button class="btn-data btn-gray update-status" data-id-prospecto="' + d.id_prospecto + '" title="Actualizar estatus"><i class="fas fa-redo"></i>';
                                    }
                                    return '<center>'+actions+'</center>';
                                } else {
                                    var actions = '';
                                    var group_buttons = '';
                                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                                        actions = '';
                                    } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                        group_buttons = '<button class="btn-data btn-orangeYellow to-comment" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="far fa-comments"></i></button>' +
                                            '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Editar información"><i class="fas fa-pencil-alt"></i></button>' +
                                            '<button class="btn-data btn-sky see-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ver información"><i class="far fa-eye"></i></button>' +
                                            '<button class="btn-data btn-violetChin re-asign" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Re - asignar"><i class="fab fa-rev"></i></button>';

                                        actions += '<button class="desplegable btn-data btn-deepGray" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><i class="fas fa-chevron-up"></i></button>';
                                        actions += '<div class="hide boxSBtns" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn-data btn-deepGray"><i class="fas fa-chevron-down"></i></button></div>';
                                    }

                                    return '<center>'+actions+'</center>';
                                }
                            } else {
                                if (d.estatus == 1) {
                                    var actions = '';
                                    var group_buttons = '';
                                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITÓ EL BOTÓN DE VER
                                        actions = '';
                                    } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                        group_buttons = '<button class="btn-data btn-orangeYellow to-comment" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="far fa-comments"></i></button>' +
                                            '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Editar información"><i class="fas fa-pencil-alt"></i></button>' +
                                            '<button class="btn-data btn-sky see-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ver información"><i class="far fa-eye"></i></button>';
                                        actions += '<button class="desplegable btn-data btn-deepGray" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><i class="fas fa-chevron-up"></i></button>';
                                        actions += '<div class="hide boxSBtns" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn-data btn-deepGray"><i class="fas fa-chevron-down"></i></button></div>';
                                        actions += '<button class="btn-data btn-gray update-status" data-id-prospecto="' + d.id_prospecto + '" title="Actualizar estatus"><i class="fas fa-redo"></i>';
                                    }
                                    return '<center>'+actions+'</center>';
                                } else {
                                    var actions = '';
                                    var group_buttons = '';
                                    if (idUser != d.id_asesor && d.lugar_prospeccion == 6 && compareDates(d.fecha_creacion) == true) { // NO ES ASESOR Y EL REGISTRO ES DE MKTD QUITO EL BOTÓN DE VER
                                        actions = '';
                                    } else { // ES ASESOR Y EL REGISTRO ES DE MKTD - DEJO EL BOTÓN DE VER
                                        group_buttons = '<button class="btn-data btn-orangeYellow to-comment" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Ingresar comentario"><i class="far fa-comments"></i></button>' +
                                            '<button class="btn-data btn-blueMaderas edit-information" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Editar"><i class="fas fa-pencil-alt"></i></button>' +
                                            '<button class="btn-data btn-sky see-information" data-id-prospecto="' + d.id_prospecto + '"><i class="material-icons" rel="tooltip" data-placement="left" title="Ver información">remove_red_eye</i></button>';
                                        actions += '<button class="desplegable btn-data btn-deepGray" id="btn_' + d.id_prospecto + '" onclick="javascript: $(this).addClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').removeClass(\'hide\'); "><i class="fas fa-chevron-up"></i></button>';
                                        actions += '<div class="hide boxSBtns" id="cnt_' + d.id_prospecto + '">' + group_buttons + '<br><button onclick="javascript: $(\'#btn_' + d.id_prospecto + '\').removeClass(\'hide\');$(\'#cnt_' + d.id_prospecto + '\').addClass(\'hide\'); " class="btn-data btn-deepGray"><i class="fas fa-chevron-down"></i></button></div>';
                                        if (d.vigencia >= 0 /*< 5 && d.fecha_creacion >= '2021-04-19 23:59:59.000'*/) {
                                            actions += '<button class="btn-data btn-deepGray update-validity" data-id-prospecto="' + d.id_prospecto + '" rel="tooltip" data-placement="left" title="Renovar vigencia"><i class="fas fa-history"></i></button>';
                                        }
                                    }
                                    return '<center>'+actions+'</center>';
                                }
                            }
                        } else {
                            return '';
                        }
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
            columnDefs: [{
                    "searchable": true,
                    "orderable": false,
                    "targets": 0
                },

            ],
            ajax: {
                "url": "getProspectsList/" + typeTransaction,
                "type": "POST",
                cache: false,
                data: {
                    "transaction": transaction,
                    "beginDate": beginDate,
                    "endDate": endDate,
                    "where": where
                }
            }
        });

    }

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
        // BEGIN DATE
        const fechaInicio = new Date();
        // Iniciar en este año, este mes, en el día 1
        const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
        // END DATE
        const fechaFin = new Date();
        // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
        const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
        $("#beginDate").val(convertDate(beginDate));
        $("#endDate").val(convertDate(endDate));
        finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
        finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
        fillTable(1, finalBeginDate, finalEndDate, 0);
    }    

$("#my-coowner-form").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'saveCoOwner',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            validateEmptySelects(3);
        },
        success: function(data) {
            if (data == 1) {
                $('#myCoOwnerModal').modal("hide");
                cleanFields(3);
                alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$("#my-edit-form").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'updateProspect',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            //validateEmptySelects(2);
            //enableSelects(2);
        },
        success: function(data) {
            if (data == 1) {
                $('#myEditModal').modal("hide");
                alerts.showNotification("top", "right", "El registro se ha actualizado exitosamente.", "success");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});



$('#finish').on('click', function() {
    validateFile();
});

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
                //$('#prospects-datatable').DataTable().ajax.reload(null, false);
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

function getAdvisers(element) {
    sede = $('option:selected', element).attr('data-sede');
    $("#myselectasesor").find("option").remove();
    $("#myselectasesor").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getAdvisers/' + sede, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectasesor").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectasesor").selectpicker('refresh');
    }, 'json');
}

function getCoordinatorsByManager(element) {
    gerente = $('option:selected', element).val();
    $("#myselectcoordinador").find("option").remove();
    $("#myselectcoordinador").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getCoordinatorsByManager/' + gerente, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectcoordinador").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectcoordinador").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectcoordinador").selectpicker('refresh');
    }, 'json');
}

function getAdvisersByCoordinator(element) {
    coordinador = $('option:selected', element).val();
    $("#myselectasesor3").find("option").remove();
    $("#myselectasesor3").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getAdvisersByCoordinator/' + coordinador, function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_usuario'];
            var name = data[i]['nombre'];
            var sede = data[i]['id_sede'];
            $("#myselectasesor3").append($('<option>').val(id).attr('data-sede', sede).text(name));
        }
        if (len <= 0) {
            $("#myselectasesor3").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#myselectasesor3").selectpicker('refresh');
    }, 'json');
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

function printProspectInfo() {
    id_prospecto = $("#prospecto_lbl").val();
    window.open("printProspectInfo/" + id_prospecto, "_blank")
}

function printProspectInfoMktd() {
    id_prospecto = $("#prospecto_lbl").val();
    window.open("printProspectInfoMktd/" + id_prospecto, "_blank")
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
function cleanComments() {
    var myCommentsList = document.getElementById('comments-list');
    myCommentsList.innerHTML = '';

    var myChangelog = document.getElementById('changelog');
    myChangelog.innerHTML = '';
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

$(document).on('click', '.update-validity', function() {
    $.ajax({
        type: 'POST',
        url: 'updateValidity',
        data: { 'id_prospecto': $(this).attr("data-id-prospecto") },
        dataType: 'json',
        success: function(data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "La vigencia de tu prospecto se ha renovado exitosamente.", "success");
                //$prospectsTable.ajax.reload();
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
            } else {
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.change-status', function() {
    estatus = $(this).attr("data-estatus");
    $.ajax({
        type: 'POST',
        url: 'changeSalesPartnerStatus',
        data: { 'id_vcompartida': $(this).attr("data-id-vcompartida"), 'estatus': $(this).attr("data-estatus") },
        dataType: 'json',
        success: function(data) {
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
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

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
        counter = 0;
        $.each(data, function(i, v) {
            counter++;
            fillTimeline(v, counter);
        });
    });

    $.getJSON("getChangelog/" + id_prospecto).done(function(data) {
        $.each(data, function(i, v) {
            fillChangelog(v);
        });
    });

});

$(document).on('click', '.re-asign', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    console.log(id_prospecto);
    if (userType == 3 || userType == 6) { // Gerente & asistente de ventas
        $("#myReAsignModalVentas").modal();
        $("#id_prospecto_re_asign_ve").val(id_prospecto);
    } else if (userType == 19) { // Subdirector MKTD
        $("#myReAsignModalSubMktd").modal();
        $("#id_prospecto_re_asign_sm").val(id_prospecto);
    } else if (userType == 20) { // Gerente MKTD
        $("#myReAsignModalGerMktd").modal();
        $("#id_prospecto_re_asign_gm").val(id_prospecto);
    }
    //id_prospecto = $(this).attr("data-id-prospecto");
    //$("#myReAsignModal").modal();
    //$("#id_prospecto_re_asign").val(id_prospecto);
});

$(document).on('click', '.update-status', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    $("#myUpdateStatusModal").modal();
    $("#id_prospecto_estatus_particular").val(id_prospecto);
});

$("#my_update_status_form").on('submit', function(e) {
    e.preventDefault();
    if($('#estatus_particular').val() == 3){
        $("#agendaInsert").modal();

    }else{$.ajax({
        type: 'POST',
        url: 'updateStatus',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            document.getElementById("finishS").disabled = true;
        },
        success: function(data) {
            /*$("#proyecto").val("");
            $("#proyecto").selectpicker('refresh');
            $("#condominio").empty().selectpicker('refresh');
            $("#lote").empty().selectpicker('refresh');
            document.getElementById("datatoassign").style.display = "none";
            document.getElementById("housesDetail").style.display = "none";*/
            if (data == 1) { // SUCCESS RESPONSE
                document.getElementById("finishS").disabled = false;
                $('#myUpdateStatusModal').modal("hide");
                $('#estatus_particular').val("0");
                $("#estatus_particular").selectpicker("refresh");
                $('#prospects-datatable').DataTable().ajax.reload(null, false);
                alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
            } else if (data == 2) { // LOTE APARTADO
                document.getElementById("finishS").disabled = false;
                alerts.showNotification("top", "right", "La asignación no se ha podido llevar a cabo debido a que el lote seleccionado ya se encuentra apartado.", "warning");
            } else { // ALGO LE FALTÓ
                document.getElementById("finishS").disabled = false;
                alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
            }
        },
        error: function() {
            document.getElementById("finishS").disabled = false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });}
});

function cleanSelects() {
    $('#estatus_particular').val("0");
    $("#estatus_particular").selectpicker("refresh");
}

/*$.post('getStatusMktdPreventa', function(data) {
    $("#estatus_particular2").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#estatus_particular2").append($('<option>').val(id).text(name));
    }
    if (len <= 0) {
        $("#estatus_particular2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    }
    $("#estatus_particular2").selectpicker('refresh');
}, 'json');

$(document).on('click', '.update-status-preventa', function(e) {
    id_prospecto = $(this).attr("data-id-prospecto");
    ///alert(id_prospecto);
    $("#myUpdateStatusModalPreventa").modal();
    $("#id_prospecto_estatus_particular2").val(id_prospecto);
});*/

$("#my_update_status_form_preventa").on('submit', function(e) {
    e.preventDefault();

    let val = $('#estatus_particular2').val();
    let id = $("#id_prospecto_estatus_particular2").val();
    //si la opcion seleccionada es 6 
    if (val == 7) {

        $("#id_prospecto_estatus_particular3").val(id);
        $("#myUpdateStatusPreve").modal();
        //$('#idestatusPP').val(val);


    } else {

        console.log("NADA");

    }

});

$("#my_update_status_prevee").on('submit', function(e) {
    e.preventDefault();

    //let val = $('#estatus_particular2').val();
    //let id = $("#id_prospecto_estatus_particular2").val();
    //si la opcion seleccionada es 6 
    //$("#id_prospecto_estatus_particular3").val(id);
    //  $("#myUpdateStatusPreve").modal();
    $.ajax({
        type: 'POST',
        url: 'updateStatusPreventa',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
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
    if (estatus == 6) { // IT'S PRESALE
        document.getElementById("datatoassign").style.display = "block";
    } else { // IT'S NOT PRESALE
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

function compareDates(fecha_creacion){
    var isBefore = moment(fecha_creacion).isBefore('2022-01-20T00:00:00Z');
    console.log(isBefore);
    return isBefore;
}
$("#estatus_recordatorio").on('change', function(e){
    let medio =  $(this).val();
    console.log('medio', medio);
    if(medio == 2 || medio == 4 || medio == 5){
        $("#comodinDIV").empty();
        $("#comodinDIV").append(`<label>Dirección</label>`+
        `<input id="comodin" name="comodin" type="text" class="form-control">`);
      }else{
        $("#comodinDIV").empty();

      }
  })

$("#estatus_recordatorio_form").on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    console.log('estatus: ', $("#id_prospecto_estatus_particular").val());
    formData.append('estatus_particular',$('#estatus_particular').val());
    formData.append('id_prospecto_estatus_particular',  $("#id_prospecto_estatus_particular").val());
    $.ajax({
        type: 'POST',
        url: '../Calendar/insertRecordatorio',
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
            // Actions before send post
            document.getElementById("finishS").disabled = true;
        },
        success: function(data) {
            $.ajax({
                type: 'POST',
                url: 'updateStatus',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    // Actions before send post
                    document.getElementById("finishS").disabled = true;
                },
                success: function(data) {
                    /*$("#proyecto").val("");
                    $("#proyecto").selectpicker('refresh');
                    $("#condominio").empty().selectpicker('refresh');
                    $("#lote").empty().selectpicker('refresh');
                    document.getElementById("datatoassign").style.display = "none";
                    document.getElementById("housesDetail").style.display = "none";*/
                    if (data == 1) { // SUCCESS RESPONSE
                        document.getElementById("finishS").disabled = false;
                        $('#myUpdateStatusModal').modal("hide");
                        $('#agendaInsert').modal("hide");
                        $('#estatus_particular').val("0");
                        $("#estatus_particular").selectpicker("refresh");
                        $('#prospects-datatable').DataTable().ajax.reload(null, false);
                        alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
                    } else if (data == 2) { // LOTE APARTADO
                        document.getElementById("finishS").disabled = false;
                        alerts.showNotification("top", "right", "La asignación no se ha podido llevar a cabo debido a que el lote seleccionado ya se encuentra apartado.", "warning");
                    } else { // ALGO LE FALTÓ
                        document.getElementById("finishS").disabled = false;
                        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    }
                },
                error: function() {
                    document.getElementById("finishS").disabled = false;
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        },
        error: function() {
            document.getElementById("finishS").disabled = false;
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function getStatusRecordatorio(){
    $.post('../Calendar/getStatusRecordatorio', function(data) {
        $("#estatus_recordatorio").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatus_recordatorio").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#estatus_recordatorio").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatus_recordatorio").selectpicker('refresh');
    }, 'json'); 
}

/*
    $.post('getStatusMktd', function(data) {
        $("#estatus_particular").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatus_particular").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#estatus_particular").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatus_particular").selectpicker('refresh');
    }, 'json');

    $.getJSON("getProspectingPlaces").done(function(data) {
        $(".prospecting_place").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $(".prospecting_place").append($('<option>').val(id).text(name));
        }
    });


        // Fill the select of nationality
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

    // Fill the select of state
    $.getJSON("getState").done(function(data) {
        $(".state").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_estado'];
            var name = data[i]['nombre'];
            $(".state").append($('<option>').val(id).text(name));
        }
        //$("#state").selectpicker('refresh');;
    });*/