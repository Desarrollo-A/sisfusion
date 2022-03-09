$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    sp2.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});

    setInitialValues();

    $('#solicitudes-datatable thead tr:eq(0) th').each(function (i) {
        var title = $(this).text();
        $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if (prospectsTable.column(i).search() !== this.value) {
                prospectsTable.column(i).search(this.value).draw();
            }
        });
    });

    $(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    getRejectionReasons(2); // MJ: SE MANDAN TRAER LOS MOTIVOS DE RECHAZO PARA EL ÁRBOL DE DOCUMENTOS DE ESCRUTURACIÓN

});

sp = { // MJ: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
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

sp2 = { // CHRIS: SELECT PICKER
    initFormExtendedDatetimepickers: function () {
        $('.datepicker2').datetimepicker({
            format: 'DD/MM/YYYY LT',
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

//eventos jquery
$(document).on('change', '#cliente', function () {
    if ($(this).val() == 'uno') {
        $('#ifClient').show();
    } else {
        $('#ifClient').hide();

    }
});

$(document).on('change', '#cliente2', function () {
    if ($(this).val() == '1') {
        $('#ifClient2').show();
    } else {
        $('#ifClient2').hide();

    }
});

$(document).on('change', '#notaria', function () {
    $('#spiner-loader').removeClass('hide');
    $.post('getNotaria',{idNotaria: $(this).val()}, function(data) {
        $('#spiner-loader').addClass('hide');
        $('#information').html(`<p><b>Nombre de la notaria:</b> ${data[0].nombre_notaria}</p>
        <p><b>Nombre del notario:</b> ${data[0].nombre_notario}</p>
        <p><b>Direccíon de la notaria:</b> ${data[0].direccion}</p>
        <p><b>Correo de la notaria:</b> ${data[0].correo}</p>`);
    }, 'json');
});

$(document).on('change', '#valuador', function () {
    $('#spiner-loader').removeClass('hide');
    $.post('getValuador',{idValuador: $(this).val()}, function(data) {
        $('#spiner-loader').addClass('hide');
        $('#information2').html(`<p><b>Nombre del perito:</b> ${data[0].perito}</p>
        <p><b>Direccíon del valuador:</b> ${data[0].direccion}</p>
        <p><b>Correo del valuador:</b> ${data[0].correo}</p>
        <p><b>Telefono del valuador:</b> ${data[0].telefono}</p>`);
    }, 'json');
});


$(document).on("click", "#preview", function () {
    var itself = $(this);
    var folder;
    switch (itself.attr('data-documentType')) {
        case '1':
            folder = 'INE';
            break;
        case '2':
            folder = 'RFC';
            break;
        case '3':
            folder = 'COMPROBANTE_DE_DOMICILIO';
            break;
        case '4':
            folder = 'ACTA_DE_NACIMIENTO';
            break;
        case '5':
            folder = 'ACTA_DE_MATRIMONIO';
            break;
        case '6':
            folder = 'CURP';
            break;
        case '8':
            folder = 'BOLETA_PREDIAL';
            break;
        case '9':
            folder = 'CONSTANCIA_MANTENIMIENTO';
            break;
        case '10':
            folder = 'CONSTANCIA_AGUA';
            break;
        case '7':
            folder = 'FORMAS_DE_PAGO';
            break;
        case '11':
            folder = 'SOLICITUD_PRESUPUESTO';
            break;
        case '12':
            folder = 'ESTATUS_CONSTRUCCION';
            break;
        case '13':
            folder = 'PRESUPUESTO';
            break;
        case '14':
            folder = 'PROYECTO';
            break;
        case '15':
            folder = 'FACTURA';
            break;
        case '16':
            folder = 'TESTIMONIO';
            break;
        case '17':
            folder = 'PROYECTO_ESCRITURA';
            break;
        default:
            //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
            break;
    }

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${base_url}static/documentos/postventa/escrituracion/${folder}/${itself.attr('data-doc')}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${itself.attr('data-doc')} `,
        width: 985,
        height: 660
    });
});

$(document).on('submit', '#rejectForm', function (e) {
    e.preventDefault();
    let id_solicitud = $('#id_solicitud2').val();
    let motivos_rechazo = $('#motivos_rechazo').val();
    changeStatus(id_solicitud, 2, motivos_rechazo, 2);
})


$(document).on('submit', '#approveForm', function (e) {
    e.preventDefault();
    let id_solicitud = $('#id_solicitud').val();
    let observations = $('#observations').val();
    changeStatus(id_solicitud, 1, observations, 1);
})

$(document).on('click', '#submitUpload', function (e) {
    e.preventDefault();
})

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    let fDate = formatDate(finalBeginDate);
    let fEDate = formatDate(finalEndDate);
    fillTable(fDate, fEDate);
});

$(document).on("click", "#dateSubmit", function () {
    let signDate = $("#signDate").val();
    let idSolicitud = $("#idSolicitud").val();
    let signDateFinal = formatDate2(signDate);
    let type = $("#type").val();
    $('#spiner-loader').removeClass('hide');
    $.post('saveDate', {
        signDate: signDateFinal,
        idSolicitud: idSolicitud
    }, function (data) {
        if (data == true) {
            changeStatus(idSolicitud, 3, 'cambio de fecha', type);
        }
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$(document).on("click", ".upload", function () {
    let idDocumento = $(this).attr("data-idDocumento");
    let documentType = $(this).attr("data-documentType");
    let action = $(this).data("action");
    let documentName = $(this).data("name");
    $("#idSolicitud").val($(this).attr("data-idSolicitud"));
    $("#idDocumento").val(idDocumento);
    $("#documentType").val(documentType);
    $("#docName").val(documentName);
    $("#action").val(action);
    if (action == 1 || action == 2 || action == 4) {
        document.getElementById("mainLabelText").innerHTML = action == 1 ? "Selecciona el archivo que desees asociar." : action == 2 ? "¿Estás seguro de eliminar el archivo?" : "Selecciona los motivos de rechazo que asociarás al documento.";
        document.getElementById("secondaryLabelDetail").innerHTML = action == 1 ? "El documento que hayas elegido se almacenará de manera automática una vez que des clic en guardar." : action == 2 ? "El documento se eliminará de manera permanente una vez que des clic en Guardar." : "Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en Guardar.";
        if (action == 1) { // ADD FILE
            $("#selectFileSection").removeClass("hide");
            $("#rejectReasonsSection").addClass("hide");
            $("#txtexp").val("");
        } else if (action == 2) { // REMOVE FILE
            $("#selectFileSection").addClass("hide");
            $("#rejectReasonsSection").addClass("hide");
        } else { // REJECT FILE
            filterSelectOptions(documentType);
            $("#selectFileSection").addClass("hide");
            $("#rejectReasonsSection").removeClass("hide");
        }

        $("#uploadModal").modal();
    } else if (action == 3) {
        $("#sendRequestButton").click();
    }
    
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    let action = $("#action").val();
    let sendRequestPermission = 0;
    if (action == 1) { // UPLOAD FILE
        let uploadedDocument = $("#uploadedDocument")[0].files[0];
        let allowedExtensions = /(\.xls|\.xlsx|\.pdf|\.jpg|\.jpeg|\.png|\.doc|\.docx|\.csv)$/i;
        let validateUploadedDocument = (uploadedDocument == undefined) || !allowedExtensions.exec(uploadedDocument.name) ? 0 : 1;
        // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVAR A CABO EL REQUEST

        if (validateUploadedDocument == 0) alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
        else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE SÍ HAY ARCHIVO SELECCIONADO
    } else if (action == 2) // MJ: DELETE FILE
        sendRequestPermission = 1;
    else if (action == 3)// MJ: VALIDATE OK
        sendRequestPermission = 1;
    else if (action == 4) { // MJ: VALIDATE NOK FILE
        let rejectionReasons = $("#rejectionReasons").val();
        if (rejectionReasons == '') { // THERE ARE NO OPTIONS
            alerts.showNotification("top", "right", "Asegúrate de haber seleccionado al menos un motivo de rechazo", "warning");
        } else sendRequestPermission = 1;
    }

    if (sendRequestPermission == 1) {
        let idSolicitud = $("#idSolicitud").val();
        let data = new FormData();
        data.append("idSolicitud", idSolicitud);
        data.append("idDocumento", $("#idDocumento").val());
        data.append("documentType", $("#documentType").val());
        data.append("uploadedDocument", $("#uploadedDocument")[0].files[0]);
        data.append("rejectionReasons", $("#rejectionReasons").val());
        data.append("action", action);
        let documentName = $("#docName").val();
        $('#uploadFileButton').prop('disabled', true);
        $('#spiner-loader').removeClass('hide');
        $.ajax({
            url: action == 1 ? "uploadFile" : action == 2 ? "deleteFile" : "validateFile",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                $("#sendRequestButton").prop("disabled", false);
                if (response == 1) {
                    // getDocumentsInformation(idSolicitud);
                    alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con éxito." : action == 2 ? "El documento se ha eliminado con éxito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento se ha sido validado correctamente.", "success");
                    prospectsTable.ajax.reload();
                    $("#uploadModal").modal("hide");
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extención .xlsx", "warning");
                $('#spiner-loader').addClass('hide');
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    }
});

$(document).on("submit", "#formPresupuesto", function (e) {
    e.preventDefault();
    let data = new FormData($(this)[0]);
    data.append('nombreT', $('#nombreT').val() == '' ? null : $('#nombreT').val());
    data.append('fechaCA', $('#fechaCA').val() == '' ? null : $('#fechaCA').val());
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: "savePresupuesto",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            if (response == 1) {
                window.open("pdfPresupuesto/" + $('#id_solicitud3').val(), "_blank")
                $("#presupuestoModal").modal("hide");
                prospectsTable.ajax.reload();
            }
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$(document).on('click', '#request', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    $('#id_solicitud').val(data.idSolicitud);
    $('#status').val(data.estatus);
    $("#approveModal").modal();
});

$(document).on('click', '#createDate', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    let signDate = getSignDate();
    $('#signDate').val(signDate);
    $('#idSolicitud').val($(this).attr('data-idSolicitud'));
    $('#type').val(1);
    $("#dateModal").modal();
});

$(document).on('click', '#reject', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    $('#id_solicitud2').val(data.idSolicitud);
    $('#status2').val(data.estatus);
    getMotivosRechazos(data.tipo_documento);
    $("#rejectModal").modal();
});

$(document).on('click', '#presupuesto', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    // $('#id_solicitud3').val(data.idSolicitud);
    getBudgetInfo(data.idSolicitud);
    $('#id_solicitud3').val(data.idSolicitud);
    ;
    $("#presupuestoModal").modal();
});

$(document).on('click', '#checkPresupuesto', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    // $('#id_solicitud3').val(data.idSolicitud);
    checkBudgetInfo(data.idSolicitud);
    $('#id_solicitud4').val(data.idSolicitud);

    $("#checkPresupuestoModal").modal();
});

$(document).on('click', '#newDate', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    // $('#id_solicitud3').val(data.idSolicitud);
    $('#idSolicitud').val($(this).attr('data-idSolicitud'));
    $('#type').val(3);
    $("#dateModal").modal();
});

$(document).on('click', '#sendMail', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    let action = $('#sendMail').attr('data-action');
    switch (action) {
        case '1':
            getNotarias();
            getValuadores();
            $('#idSolicitud').val(data.idSolicitud);
            $('#action').val(action);
            $('#information').html('');
            $('#information2').html('');
            $("#notarias").modal();
            break;
        case '2':
            email(data.idSolicitud, action);

            break;
        case '3':
            email(data.idSolicitud, action);
            break;
        case '4':
            email(data.idSolicitud, action);
            break;
        case '5':
            email(data.idSolicitud, action);
            break;
    }
});

$(document).on('click', '#tree', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    getDocumentsClient(data.idSolicitud);
    $("#documentTree").modal();
});

$(document).on('click', '#newNotary', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    $('#idSolicitud').val(data.idSolicitud);
    $("#altaNotario").modal();
});

$(document).on('change', '#documents', function () {
    let idDocument = $(this).val();
    displayInput(idDocument);
});

$(document).on('click', '#notariaSubmit', function (e) {
    let idSolicitud = $('#idSolicitud').val();
    let action = $('#action').val();
    let notaria = $('#notaria').val();
    let valuador = $('#valuador').val();
    email(idSolicitud, action, notaria, valuador);
})

$(document).on("click", "#sendRequestButton2", function (e) {
    $('#spiner-loader').removeClass('hide');
    let uploadedDocument = $("#uploadedDocument2")[0].files[0];
    let validateUploadedDocument = (uploadedDocument == undefined) ? 0 : 1;
    // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVAR A CABO EL REQUEST
    if (validateUploadedDocument == 0) alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
    else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE SÍ HAY ARCHIVO SELECCIONADO

    if (sendRequestPermission == 1) {
        let data = new FormData();
        data.append("idDocumento", $("#uploadedDocument2").attr('data-iddoc'));
        data.append("uploadedDocument2", uploadedDocument);

        $.ajax({
            url: "uploadFile2",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                $("#sendRequestButton2").prop("disabled", false);
                if (response == 1) {
                    // getDocumentsInformation(idSolicitud);
                    alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con éxito." : action == 2 ? "El documento se ha eliminado con éxito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento se ha sido validado correctamente.", "success");
                    // prospectsTable.ajax.reload();
                    // $("#uploadModal").modal("hide");
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extención .xlsx", "warning");
                $('#spiner-loader').addClass('hide');
            }, error: function () {
                $("#sendRequestButton2").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    }
})

var detailRows = [];
$(document).on('click', '.details-control', function () {
    var tr = $(this).closest('tr');
    var row = prospectsTable.row(tr);
    var idx = $.inArray(tr.attr('id'), detailRows);

    if (row.child.isShown()) {
        tr.removeClass('details');
        row.child.hide();

        // Remove from the 'open' array
        detailRows.splice(idx, 1);
    } else {
        $('#spiner-loader').removeClass('hide');
        tr.addClass('details');
        $.post("getDocumentsClient", {
            idEscritura: row.data().idSolicitud
        }).done(function (data) {
            row.data().solicitudes = JSON.parse(data);
            prospectsTable.row(tr).data(row.data());
            row = prospectsTable.row(tr);
            row.child(buildTableDetail(row.data().solicitudes, $('#trees').attr('data-permisos'))).show();
            tr.addClass('shown');
            $(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
            $('#spiner-loader').addClass('hide');
        });

        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.attr('id'));
        }
    }
});


//funciones
function fillTable(beginDate, endDate) {

    prospectsTable = $('#prospects-datatable').DataTable({
        dom: 'rt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            // {
            //     "className": "details-control",
            //     "orderable": false,
            //     "data": null,
            //     "defaultContent": '<i class="material-icons" style="color: #003d82;" title="Click aquí para más detalles">add_circle</i>'
            // },
            {
                data: function (d) {
                    return d.idSolicitud
                }

            },
            {
                data: function (d) {
                    return d.nombreResidencial
                }

            },
            {
                data: function (d) {

                    return d.nombreCondominio
                }
            },
            {
                data: function (d) {
                    return d.nombreLote
                }
            },
            {
                data: function (d) {
                    return d.nombre;
                }
            },
            {
                data: function (d) {
                    return `<center><span class="label" style="background:${d.tipo == 1 || d.tipo == null ? '#28B463' : '#f44336'}">${d.estatus}</span><center>
                    <center><span class="label" style="background:${d.tipo == 1 || d.tipo == null ? '#28B463' : '#f44336'}">(${d.area})</span><center>`;
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {
                    return d.tipo == 1 ? d.comentarios : d.motivos_rechazo;
                }
            },
            {
                data: function (d) {
                    var actions = '';
                    var group_buttons = '';
                    let newBtn = '';
                    let exp;

                    switch (d.idEstatus) {
                        case 0:
                            if (userType == 55) { // MJ: ANTES 54
                                group_buttons += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="far fa-paper-plane"></i></button>';
                            }
                            break;
                        case 1:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 2:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 3:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 4:
                            if (userType == 55) {
                                newBtn += `<button id="presupuesto" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="top" title="presupuesto"><i class="fas fa-money-bill-wave"></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 5:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);


                            break;
                        case 6:
                            //solicitud de valores (solicitud de presupuesto)
                            newBtn += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                            newBtn += `<button id="checkPresupuesto" data-idSolicitud=${d.idSolicitud} class="btn-data btn-details-grey" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Revisar"><i class="fas fa-search"></i></button>`
                            newBtn += `<button id="sendMail" data-idSolicitud=${d.idSolicitud}  data-action="1" class="btn-data btn-violetBoots" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Correo"><i class="fas fa-envelope"></i></button>`;
                            group_buttons += permisos(d.permisos, 1, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 7:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 8:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 9:
                            //se notifica al cliente el presupuesto
                            newBtn += `<button id="sendMail" data-idSolicitud=${d.idSolicitud}  data-action="2" class="btn-data btn-violetBoots" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Correo"><i class="fas fa-envelope"></i></button>`;
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 10:
                            exp = d.expediente;
                            if (d.result == 1) {
                                exp = 1;
                            }
                            newBtn += `<button id="trees" data-idSolicitud=${d.idSolicitud} class="btn-data btn-details-grey details-control" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                            newBtn += `<button id="newNotary" data-idSolicitud=${d.idSolicitud} class="btn-data btn-sky details-control" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Nuevo notario"><i class="fas fa-user-tie"></i></button>`;
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 11:
                            exp = d.expediente;
                            if (d.result == 1 && d.estatusValidacion != 1)
                                exp = 1;
                            else if (d.result == 1 && d.estatusValidacion == 1)
                                exp = 2;

                            newBtn += `<button id="trees" data-idSolicitud=${d.idSolicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                            if (userType == 57 && d.estatusValidacion == 0 && exp != null) { // MJ: ANTES 55
                                newBtn += `<button id="reject"  class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 12:
                            //se envia documentacion a la notaria
                            exp = d.expediente;
                            if (d.result == 1) {
                                exp = 1;
                            }
                            if (userType == 57) { // MJ: ANTES 56
                                newBtn += `<button id="sendMail" data-idSolicitud=${d.idSolicitud} data-action="3" class="btn-data btn-violetBoots" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Correo"><i class="fas fa-envelope"></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 13:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 14:
                            if (userType == 57) { // MJ: ANTES 56
                                newBtn += `<button id="createDate" data-idSolicitud=${d.idSolicitud} data-action="3" class="btn-data btn-green" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Fecha para firma"><i class="far fa-calendar-alt"></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 15:
                            //se notifica la fecha de escrituracion
                            exp = d.expediente;
                            if (d.result == 1) {
                                exp = 1;
                            }
                            newBtn += `<button id="sendMail" data-idSolicitud=${d.idSolicitud} data-action="4" class="btn-data btn-violetBoots" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Correo"><i class="fas fa-envelope"></i></button>`;
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                            break;
                        case 16:
                            if (userType == 55) { // MJ: ANTES 54
                                newBtn +=  `<button id="newDate" data-idSolicitud=${d.idSolicitud} class="btn-data btn-orangeYellow"  data-toggle="tooltip" data-placement="top"  title="Nueva fecha"><i class="fas fa-calendar-alt"></i></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, 1, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 17:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 18:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 19:

                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 20:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 21:
                            //notificacion de la factura electronica
                            if (userType == 55) { // MJ: ANTES 54
                                newBtn += `<button id="reject"  class="btn-data btn-warning" data-toggle="tooltip" data-placement="top"  title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                newBtn += `<button id="sendMail" data-idSolicitud=${d.idSolicitud} data-action="4" class="btn-data btn-violetBoots" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Correo"><i class="fas fa-envelope"></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 22:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 23:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 24:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);

                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        case 90:
                            newBtn += `<button id="newDate" data-idSolicitud=${d.idSolicitud} class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Nueva fecha"><i class="fas fa-calendar-alt"></i></button>`;
                            group_buttons += permisos(d.permisos, 1, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            //Declaraciones ejecutadas cuan+do el resultado de expresión coincide con valorN
                            break;
                        default:
                            //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
                            break;
                    }
                    $('[data-toggle="tooltip"]').tooltip();
                    return '<center>' + group_buttons + '<center>';
                }
            }
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        },

        ],
        ajax: {
            url: 'getSolicitudes',
            type: "POST",
            cache: false,
            data: {
                "beginDate": beginDate,
                "endDate": endDate,
            }
        }

    });
};

function email(idSolicitud, action, notaria = null, valuador= null) {
    $('#spiner-loader').removeClass('hide');
    let obj;
    switch (action) {
        case '1':
            obj = {idSolicitud: idSolicitud, notaria: notaria, valuador: valuador};
            break;
        case '2':
            obj = {idSolicitud: idSolicitud};
            break;
        case '3':
            obj = {idSolicitud: idSolicitud};
            break;
        case '4':
            obj = {idSolicitud: idSolicitud};
            break;
        case '5':
            obj = {idSolicitud: idSolicitud};
            break;
    }
    $.post(action == 1 ? 'mailPresupuesto' : action == 2 ? 'presupuestoCliente' : action == 3 ? 'mailNotaria' : action == 4 ? 'mailFecha' : 'mailPresupuesto', obj, function (data) {
        if (data == false) {//cambiar a true
            changeStatus(idSolicitud, action == 1 ? 4 : 0, 'correo enviado', 1);
        }
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este año, este mes, en el día 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
    fillTable(finalBeginDate, finalEndDate);
}

function getMotivosRechazos(tipo_documento) {
    $('#spiner-loader').removeClass('hide');
    $("#motivos_rechazo").find("option").remove();
    $("#motivos_rechazo").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getMotivosRechazos', {
        tipo_documento: tipo_documento
    }, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_motivo'];
            var name = data[i]['motivo'];
            $("#motivos_rechazo").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#motivos_rechazo").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#motivos_rechazo").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function getDocumentsClient(idEscritura) {
    $('#spiner-loader').removeClass('hide');
    $("#documents").find("option").remove();
    $("#documents").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getDocumentsClient', {
        idEscritura: idEscritura
    }, function (data) {        
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idDocumento'];
            var name = data[i]['nombre'];
            $("#documents").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#documents").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#documents").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function getNotarias() {
    $('#spiner-loader').removeClass('hide');
    $("#notaria").find("option").remove();
    $("#notaria").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $.post('getNotarias', function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idNotaria'];
            var name = data[i]['nombre_notaria'];
            $("#notaria").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#notaria").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#notaria").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

    function getValuadores() {
        $('#spiner-loader').removeClass('hide');
        $("#valuador").find("option").remove();
        $("#valuador").append($('<option disabled>').val("0").text("Seleccione una opción"));
        $.post('getValuadores', function(data) {
            var len = data.length;
            for (var i = 0; i < len; i++) {
                var id = data[i]['idValuador'];
                var name = data[i]['perito'];
                $("#valuador").append($('<option>').val(id).text(name));
            }
            if (len <= 0) {
                $("#valuador").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
            }
            $("#valuador").selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }, 'json');
    }

    function getBudgetInfo(idSolicitud){
        $('#spiner-loader').removeClass('hide');
        $.post('getBudgetInfo',{
            idSolicitud:idSolicitud
        }, function(data) {
           $('#nombrePresupuesto').val(data.nombre);
           $('#nombrePresupuesto2').val(data.nombre);
           $('#estatusPago').val(1);
        //    $('#superficie').val(d);
        var str = (data.modificado).split(" ")[0].split("-");
        var strM = `${str[2]}-${str[1]}-${str[0]}`;
        $('#fContrato').val(strM);
        //    $('#catastral').val(data.estatus);
        $('#construccion').val(1);
        $('#cliente').val(1);
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function checkBudgetInfo(idSolicitud) {
    $('#spiner-loader').removeClass('hide');
    $.post('checkBudgetInfo', {
        idSolicitud: idSolicitud
    }, function (data) {
        $('#nombrePresupuesto3').val(data.nombre);
        $('#nombrePresupuesto4').val(data.nombre_escrituras);
        $('#estatusPago2').val(data.estatus_pago);
        $('#superficie2').val(data.superfice);
        $('#fContrato2').val(data.modificado);
        $('#catastral2').val(data.clave_catastral);
        $('#construccion2').val(data.estatus_construccion);
        $('#cliente2').val(data.cliente_anterior).trigger('change');
        ;
        $("#cliente2").selectpicker('refresh');
        $('#nombreT2').val(data.nombre_anterior);
        $('#fechaCA2').val(data.fecha_anterior);
        $('#rfcDatos2').val(data.RFC);
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function formatDate(date) {
    var dateParts = date.split("/");
    var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

function formatDate2(date) {
    var dateParts = date.split("/");
    let timePart = dateParts[2].split(" ");
    let timeParts = timePart[1].split(':');
    var d = new Date(+timePart[0], dateParts[1] - 1, +dateParts[0], timeParts[0], timeParts[1]),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
        time = d.getTime();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    let newDate = [year, month, day].join('-') + ' ' + timeParts[0] + ':' + timeParts[1];
    return newDate;
}


function sino() {
    $("#cliente").find("option").remove();
    $("#cliente").append($('<option disabled>').val(0).text("Seleccione una opción"));
    $("#cliente").append($('<option>').val(1).text('si'));
    $("#cliente").append($('<option>').val(2).text('no'));
    $("#cliente").selectpicker('refresh');
}

function displayInput(idDocumento) {
    $("#uploadedDocument2").attr('data-idDoc', idDocumento);
    $("#documentsSection").removeClass("hide");
}

function permisos(permiso, expediente, idDocumento, tipo_documento, idSolicitud, aditional, newBtn) {
    let botones = '';
    switch (permiso) {
        case 0:
            botones += ``;
            break;
        case 1: //escritura
            if (expediente == null || expediente == '' || expediente == 'null') {
                if (aditional == 2) {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-warning"} upload" data-toggle="tooltip" data-placement="top" title="Upload/Delete">${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                } else {
                    botones += newBtn;
                }
            } else {
                if (aditional == 2) {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-warning"} upload" data-toggle="tooltip" data-placement="top" title="Upload/Delete">${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                } else {
                    botones += newBtn;
                }
                botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Preview"><i class="fas fa-eye"></i></button>`;
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';
            }
            break;
        case 2: //lectura
            if (aditional == 1) {
                botones += newBtn;
            }
            if (expediente != 1) {
                botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Preview"><i class="fas fa-eye"></i></button>`;
            }
            break;
        case 3: //especial
            if (expediente == null || expediente == '' || expediente == 'null') {
                if (aditional == 1) {
                    botones += newBtn;
                }
            } else {
                if (aditional == 1) {
                    botones += newBtn;
                }
                if (expediente != 1) {
                    botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Preview"><i class="fas fa-eye"></i></button>`;
                    botones += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                }
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';
            }
            break;
        case 4: //especial
            if (aditional == 1)
                botones += newBtn;
            if (expediente == 2) // 2 CUANDO NINGÚN DOCUMENTO TENGA MOTIVOS DE RECHAZO
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';
            break;
    }
    return '<div class="d-flex justify-center">'+botones+'</div>';
}

function buildTableDetail(data, permisos) {
    var solicitudes = '<table class="table subBoxDetail">';
    solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'DOCUMENTO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'CARGADO POR ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ESTATUS VALIDACIÓN ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'MOTIVOS DE RECHAZO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'VALIDADO POR ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ACCIONES ' + '</b></td>';
    solicitudes += '</tr>';
    $.each(data, function (i, v) {

        //i es el indice y v son los valores de cada fila
        solicitudes += '<tr>';
        solicitudes += '<td> ' + (i + 1) + ' </td>';
        solicitudes += '<td> ' + v.nombre + ' </td>';
        solicitudes += '<td> ' + v.creado_por + ' </td>';
        solicitudes += '<td> ' + v.fecha_creacion + ' </td>';
        solicitudes += '<td> <span class="label" style="background:' + v.colour + '">' + v.estatus_validacion + '</span> </td>';
        solicitudes += '<td> ' + v.motivos_rechazo + ' </td>';
        solicitudes += '<td> ' + v.validado_por + ' </td>';
        /*data-action = 1 (UPLOAD FILE)
        data-action = 2 (DELETE FILE)*/

        solicitudes += '<td><div class="d-flex justify-center">';
        // MJ: TIENE PERMISOS (ESCRITURA) && (LA RAMA ESTÁ SIN VALIDAR O RECHAZADA) && VALIDACIÓN ESTATUS
        if (permisos == 1 && (v.ev == null || v.ev == 2) && v.estatusActual == 10)
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-toggle="tooltip" data-placement="top" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        // MJ: TIENE PERMISOS (VALIDAR) && (LA RAMA ESTÁ SIN VALIDAR O RECHAZADA) && VALIDACIÓN ESTATUS
        else if (permisos == 2 && v.estatusActual == 11) {
            if (v.ev == 1) // MJ: VALIDADO OK
                solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-action="4" class="btn-data btn-warning upload" data-toggle="tooltip" data-placement="top" title="Documento NOK"><i class="fas fa-thumbs-down"></i></button>`;
            else if (v.ev == 2) // MJ: VALIDADO NOK
                solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-action="3" class="btn-data btn-green upload" data-toggle="tooltip" data-placement="top" title="Documento OK"><i class="fas fa-thumbs-up"></i></button>`;
            else { // MJ: SIN VALIDAR
                solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-action="3" class="btn-data btn-gray upload" data-toggle="tooltip" data-placement="top" title="Sin validar OK"><i class="fas fa-thumbs-up"></i></button>`;
                solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-action="4" class="btn-data btn-gray upload" data-toggle="tooltip" data-placement="top" title="Sin validar NOK"><i class="fas fa-thumbs-down"></i></button>`;
            }
        }

        if (v.expediente == null || v.expediente == '')
            solicitudes += '';
        else
            solicitudes += `<button id="preview" data-doc="${v.expediente}" data-documentType="${v.tipo_documento}" class="btn-data btn-gray" data-toggle="tooltip" data-placement="top" title="Preview"><i class="fas fa-eye"></i></button>`;

        solicitudes += '</div></td></tr>';

    });
    return solicitudes += '</table>';
}

function getSignDate() {
    let date = new Date();
    let i = 0;
    while (i < 15) {//dias habiles despues del dia de hoy
        date.setTime(date.getTime() + 24 * 60 * 60 * 1000); // añadimos 1 día
        if (date.getDay() != 6 && date.getDay() != 0)
            i++;
    }
    let minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
    let fecha = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + minutes;
    return fecha;
}

function changeStatus(id_solicitud, action, comentarios, type) {
    $('#spiner-loader').removeClass('hide');
    $.post('changeStatus', {
        id_solicitud: id_solicitud,
        type: type,
        comentarios: comentarios
    }, function (data) {
        switch (action) {
            case 1:
                $('#approveModal').modal("hide");
                break;
            case 2:
                $('#rejectModal').modal("hide");
                break;
            case 3:
                $('#dateModal').modal("hide");
                break;
            case 4:
                $("#notarias").modal("hide");
                break;
            default:
                break;
        }
        prospectsTable.ajax.reload();
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function filterSelectOptions(documentType) {
    $("#rejectionReasons option").each(function () {
        if ($(this).attr("data-type") === documentType) {
            $(this).show();
        } else {
            $(this).hide();
        }
        $('select').val(documentType);
    });
    $("#rejectionReasons option:selected").prop("selected", false);
    $("#rejectionReasons").trigger('change');
    $("#rejectionReasons").selectpicker('refresh');
}


     
