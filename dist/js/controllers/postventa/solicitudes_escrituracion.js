$('#prospects-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#prospects-datatable').DataTable().column(i).search() !== this.value ) {
            $('#prospects-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
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
            },
            minDate:new Date(),
        });
    }
}

$(document).ready(function () {
    sp.initFormExtendedDatetimepickers();
    sp2.initFormExtendedDatetimepickers();
    $('.datepicker').datetimepicker({locale: 'es'});
    getEstatusEscrituracion();
    setInitialValues();

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

    getRejectionReasons(2); // MJ: SE MANDAN TRAER LOS MOTIVOS DE RECHAZO PARA EL ??RBOL DE DOCUMENTOS DE ESCRUTURACI??N

});

//eventos jquery
$(document).on('change', '#cliente', function () {
    if ($(this).val() == 'uno') {
        $('#ifClient').show();
    } else {
        $('#ifClient').hide();

    }
});

$(document).on('change', '#cliente2', function () {
    if ($(this).val() == 'uno') {
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
        <p><b>Direcc??on de la notaria:</b> ${data[0].direccion}</p>
        <p><b>Correo de la notaria:</b> ${data[0].correo}</p>`);
    }, 'json');
});

$(document).on('change', '#valuador', function () {
    $('#spiner-loader').removeClass('hide');
    $.post('getValuador',{idValuador: $(this).val()}, function(data) {
        $('#spiner-loader').addClass('hide');
        $('#information2').html(`<p><b>Nombre del perito:</b> ${data[0].perito}</p>
        <p><b>Direcc??on del valuador:</b> ${data[0].direccion}</p>
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
        case '18':
            folder = 'RFC_MORAL';
            break; 
        case '19':
            folder = 'ACTA_CONSTITUTIVA';
        break;
        default:
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
    let estatus = $('#estatus').val();
    let type = estatus == 12 ? 4:2; 
    changeStatus(id_solicitud, 2, motivos_rechazo, type);
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
    fillTable(fDate, fEDate, $('#estatusE').val());
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
            changeStatus(idSolicitud, 3, `Nueva fecha para firma: ${signDateFinal}`, type);
        }
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$(document).on("click", ".upload", function () {
    let idDocumento = $(this).attr("data-idDocumento");
    let documentType = $(this).attr("data-documentType");
    let action = $(this).data("action");
    let documentName = $(this).data("name");
    let presupuestoType = $(this).attr("data-presupuestoType");

    $("#idSolicitud").val($(this).attr("data-idSolicitud"));
    $("#idDocumento").val(idDocumento);
    $("#documentType").val(documentType);
    $("#docName").val(documentName);
    $("#action").val(action);
    $("#presupuestoType").val(presupuestoType);
    $("#details").val($(this).data("details"));
    if (action == 1 || action == 2 || action == 4) {
        document.getElementById("mainLabelText").innerHTML = action == 1 ? "Seleccione el archivo que desees asociar." : action == 2 ? "??Est??s seguro de eliminar el archivo?" : "Seleccione los motivos de rechazo que asociar??s al documento.";
        document.getElementById("secondaryLabelDetail").innerHTML = action == 1 ? "El documento que hayas elegido se almacenar?? de manera autom??tica una vez que des clic en guardar." : action == 2 ? "El documento se eliminar?? de manera permanente una vez que des clic en Guardar." : "Los motivos de rechazo que selecciones se registrar??n de manera permanente una vez que des clic en Guardar.";
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
        $('#uploadedDocument').val('');
        $( "#uploadedDocument" ).trigger( "change" );
        $("#uploadModal").modal();
    } else if (action == 3) {
        $("#sendRequestButton").click();
    }
    
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");

        if(target.val() == ''){
            var fileName = 'No ha seleccionado nada a??n';
        }else{
            var fileName = target[0].files[0].name;
        }
        relatedTarget.val(fileName);
    });
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    let action = $("#action").val();
    let sendRequestPermission = 0;
    if (action == 1) { // UPLOAD FILE
        let uploadedDocument = $("#uploadedDocument")[0].files[0];
        let allowedExtensions = /(\.xls|\.xlsx|\.pdf|\.jpg|\.jpeg|\.png|\.doc|\.docx|\.csv|\.rar|\.zip)$/i;
        let validateUploadedDocument = (uploadedDocument == undefined) || !allowedExtensions.exec(uploadedDocument.name) ? 0 : 1;
        // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVAR A CABO EL REQUEST

        if (validateUploadedDocument == 0) alerts.showNotification("top", "right", "Aseg??rate de haber seleccionado un archivo antes de guardar.", "warning");
        else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE S?? HAY ARCHIVO SELECCIONADO
    } else if (action == 2) // MJ: DELETE FILE
        sendRequestPermission = 1;
    else if (action == 3)// MJ: VALIDATE OK
        sendRequestPermission = 1;
    else if (action == 4) { // MJ: VALIDATE NOK FILE
        let rejectionReasons = $("#rejectionReasons").val();
        if (rejectionReasons == '') { // THERE ARE NO OPTIONS
            alerts.showNotification("top", "right", "Aseg??rese de haber seleccionado al menos un motivo de rechazo", "warning");
        } else sendRequestPermission = 1;
    }

    if (sendRequestPermission == 1) {
        let idSolicitud = $("#idSolicitud").val();
        let data = new FormData();
        let details = $("#details").val();
        data.append("idSolicitud", idSolicitud);
        data.append("idDocumento", $("#idDocumento").val());
        data.append("documentType", $("#documentType").val());
        if($("#documentType").val() == 13){
            data.append("presupuestoType", $("#presupuestoType").val());
        }
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
                console.log(response);
                $("#sendRequestButton").prop("disabled", false);
                if (response == 1) {
                    // getDocumentsInformation(idSolicitud);
                    alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con ??xito." : action == 2 ? "El documento se ha eliminado con ??xito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento ha sido validado correctamente.", "success");
                    if(details == 1){
                        var tr = $(`#trees${idSolicitud}`).closest('tr');
                        var row = prospectsTable.row(tr);
                        createDocRow(row, tr, $(`#trees${idSolicitud}`));
                    }else if(details == 2){
                        var tr = $(`#treePresupuesto${idSolicitud}`).closest('tr');
                        var row = prospectsTable.row(tr);
                        createDocRowPresupuesto(row, tr, $(`#treePresupuesto${idSolicitud}`));
                    }
                    else{
                        prospectsTable.ajax.reload();
                    }
                    $("#uploadModal").modal("hide");
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo sali?? mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extenci??n .xlsx", "warning");
                $('#spiner-loader').addClass('hide');
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo sali?? mal.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    }
});

$(document).on("submit", "#formPresupuesto", function (e) {
    e.preventDefault();
    let data = new FormData($(this)[0]);
    data.append('nombreT', $('#nombreT').val() == '' ? null : $('#nombreT').val());
    data.append('fechaCA2', $('#fechaCA').val() == '' ? null : formatDate($('#fechaCA').val()));
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
                var win =  window.open("pdfPresupuesto/" + $('#id_solicitud3').val(), "_blank");
                $("#presupuestoModal").modal("hide");
                $('#spiner-loader').addClass('hide');
                win.onload = function(){
                    prospectsTable.ajax.reload();
                }
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo sali?? mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$(document).on('click', '#request', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    $('#id_solicitud').val(data.idSolicitud);
    $('#status').val(data.estatus);
    $('#observations').val('');
    $("#approveModal").modal();
});

$(document).on('click', '#createDate', function () {
    let idNotaria = $(this).attr('data-idNotaria');
    let signDate = getSignDate(idNotaria);
    $('#signDate').val(signDate);
    $('#idSolicitud').val($(this).attr('data-idSolicitud'));
    $('#type').val(1);
    $("#dateModal").modal();
});

$(document).on('click', '#reject', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    $('#id_solicitud2').val(data.idSolicitud);
    $('#status2').val(data.estatus);
    $('#estatus').val(data.idEstatus);
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
    let idNotaria = $(this).attr('data-idNotaria');
    let signDate = getSignDate(idNotaria);
    $('#signDate').val(signDate);
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
    $('#nombre_notaria').val('');
    $('#nombre_notario').val('');
    $('#direccion').val('');
    $('#correo').val('');
    $('#telefono').val('');
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
    if (validateUploadedDocument == 0) alerts.showNotification("top", "right", "Aseg??rese de haber seleccionado un archivo antes de guardar.", "warning");
    else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE S?? HAY ARCHIVO SELECCIONADO

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
                    alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con ??xito." : action == 2 ? "El documento se ha eliminado con ??xito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento ha sido validado correctamente.", "success");
                    // prospectsTable.ajax.reload();
                    // $("#uploadModal").modal("hide");
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo sali?? mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extenci??n .xlsx", "warning");
                $('#spiner-loader').addClass('hide');
            }, error: function () {
                $("#sendRequestButton2").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo sali?? mal.", "danger");
                $('#spiner-loader').addClass('hide');
            }
        });
    }
})

$(document).on('click', '.details-control', function () {
    var detailRows = [];
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
        createDocRow(row, tr, $(this));
        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.attr('id'));
        }
    }
});

$(document).on('click', '#estatusL', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    $('#id_solicitudEstatus').val(data.idSolicitud);
    getEstatusConstruccion();
    $("#estatusLModal").modal();
});

$(document).on('submit', '#formEstatusLote', function (e) {
    e.preventDefault();
    let id_solicitud = $('#id_solicitudEstatus').val();
    let formData = new FormData($(this)[0]);
    saveEstatusLote(id_solicitud, formData);
})

$(document).on('click', '.treePresupuesto', function () {
    var detailRows = [];
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
        createDocRowPresupuesto(row, tr, $(this));
        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.attr('id'));
        }
    }
});

$(document).on('click', '.approve', function(){
    let idDocumento = $(this).attr("data-idDocumento");
    let idSolicitud = $(this).attr("data-idSolicitud");

    let data = new FormData();
    let details =  $(this).attr("data-details");
    data.append("idSolicitud", idSolicitud);
    data.append("idDocumento", idDocumento);

    $.ajax({
        url: 'approvePresupuesto',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            console.log(details);
            $("#sendRequestButton").prop("disabled", false);
            if (response == 1) {
                // getDocumentsInformation(idSolicitud);
                alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con ??xito." : action == 2 ? "El documento se ha eliminado con ??xito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento ha sido validado correctamente.", "success");
                if(details == 1){
                    var tr = $(`#trees${idSolicitud}`).closest('tr');
                    var row = prospectsTable.row(tr);
                    createDocRow(row, tr, $(`#trees${idSolicitud}`));
                }
                else{
                    prospectsTable.ajax.reload();
                }
                // $("#uploadModal").modal("hide");
            } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo sali?? mal.", "warning");
            else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
            else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extenci??n .xlsx", "warning");
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo sali?? mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
})

//funciones
function fillTable(beginDate, endDate, estatus) {

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
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {
                    return d.tipo == 1 || d.tipo == 3 ? d.comentarios : d.tipo == 2 || d.tipo == 4? d.motivos_rechazo : d.tipo == 5 ? '':'';
                }
            },
            {
                data: function (d) {
                    return `<center><span><b>${d.idEstatus} - ${d.estatus}</b></span><center>
                    <center><span>(${d.area})</span><center>`;   
                }
            },
            {
                data: function (d) {
                    var actions = '';
                    var group_buttons = '';
                    let newBtn = '';
                    let exp;
                    let permiso;

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
                            newBtn += `<button id="estatusL" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="top" title="Estatus del lote"><i class="fas fa-tools"></i></button>`;
                            if(userType == 56 && d.flagEstLot == 0){
                                exp = null;
                                permiso = 3
                            }else{
                                exp = 1;
                                permiso = 3;
                            }
                            group_buttons += permisos(permiso, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 4:
                            if (userType == 55) {
                                newBtn += `<button id="presupuesto" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="top" title="Presupuesto"><i class="fas fa-money-bill-wave"></i></button>`;
                                newBtn += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                if(d.Spresupuesto == 1){
                                    newBtn += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="far fa-paper-plane"></i></button>';
                                }
                            }
                            group_buttons += permisos(d.permisos,d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 5:
                            newBtn += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 6:
                            //solicitud de valores (solicitud de presupuesto)
                            newBtn += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;                            
                            newBtn += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="far fa-paper-plane"></i></button>';
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 7:
                            newBtn += `<button id="treePresupuesto${d.idSolicitud}" data-idSolicitud=${d.idSolicitud} class="btn-data btn-details-grey treePresupuesto" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose presupuestos"><i class="fas fa-chevron-down"></i></button>`;
                            if(d.flagPresupuesto == 1){
                                exp = 2
                            }else{
                                exp = d.expediente;
                            }
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 8:
                            if(d.flagPresupuesto == 1){
                                exp = 1
                            }else{
                                exp = d.expediente;
                            }
                            newBtn += `<button id="treePresupuesto${d.idSolicitud}" data-idSolicitud=${d.idSolicitud} class="btn-data btn-details-grey treePresupuesto" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose presupuestos"><i class="fas fa-chevron-down"></i></button>`;
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 9:
                            //se notifica al cliente el presupuesto
                            newBtn += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="far fa-paper-plane"></i></button>';
                            group_buttons += permisos(d.permisos, 1, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 10:
                            exp = d.expediente;
                            if (d.result == 1 && d.approvedPresupuesto == 1) {
                                exp = 1;
                            }
                            newBtn += `<button id="trees${d.idSolicitud}" data-idSolicitud=${d.idSolicitud} class="btn-data btn-details-grey details-control" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                            newBtn += `<button id="newNotary" data-idSolicitud=${d.idSolicitud} class="btn-data btn-sky" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Nueva Notar??a"><i class="fas fa-user-tie"></i></button>`;
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 11:
                            exp = d.expediente;
                            if (d.result == 1 && d.estatusValidacion != 1)
                                exp = 1;
                            else if (d.result == 1 && d.estatusValidacion == 1)
                                exp = 2;   
                                newBtn += `<button id="trees${d.idSolicitud}" data-idSolicitud=${d.idSolicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                            if (d.pertenece == 2){
                                newBtn += `<button id="notaria" data-idSolicitud=${d.idSolicitud} class="btn-data btn-green" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Notar??a"><i class="fas fa-user-tie"></i></button>`;
                            } 
                            if (userType == 57 && d.estatusValidacion == 0 && exp != null && d.no_rechazos != 0) { // MJ: ANTES 55
                                newBtn += `<button id="reject"  class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 12:
                            //se envia documentacion a la notaria
                            exp = d.expediente;
                            if (d.result == 1) {
                                exp = 1;
                            }
                            if (userType == 57) { // MJ: ANTES 56
                                newBtn += `<button id="reject"  class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                newBtn += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="far fa-paper-plane"></i></button>';
                            }
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);

                            break;
                        case 13://14
                            if (userType == 57) { // MJ: ANTES 56
                                newBtn += `<button id="createDate" data-idSolicitud=${d.idSolicitud} data-action="3" data-idNotaria=${d.idNotaria} class="btn-data btn-green" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Fecha para firma"><i class="far fa-calendar-alt"></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 14://15
                            //se notifica la fecha de escrituracion
                            exp = d.expediente;
                            if (d.result == 1) {
                                exp = 1;
                            }
                            newBtn += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="far fa-paper-plane"></i></button>';
                            group_buttons += permisos(d.permisos, exp, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 15://16
                            if (userType == 55) { // MJ: ANTES 54
                                newBtn +=  `<button id="newDate" data-idSolicitud=${d.idSolicitud} data-idNotaria=${d.idNotaria} class="btn-data btn-orangeYellow"  data-toggle="tooltip" data-placement="top"  title="Nueva fecha"><i class="fas fa-calendar-alt"></i></i></button>`;
                            }
                            group_buttons += permisos(d.permisos, 1, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 16://13
                            newBtn += `<button id="observacionesButton" data-idSolicitud=${d.idSolicitud} data-action="3" class="btn-data btn-violetBoots" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Envi?? Observaciones"><i class="far fa-comment"></i></button>`;
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 17:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 18:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 19:

                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 20:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 21:
                            //notificacion de la factura electronica
                            if (userType == 55) { // MJ: ANTES 54
                                newBtn += `<button id="reject"  class="btn-data btn-warning" data-toggle="tooltip" data-placement="top"  title="Rechazar"><i class="fas fa-ban"></i></button>`;
                                newBtn += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="far fa-paper-plane"></i></button>';
                            }
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        case 22:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 23:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 24:
                            group_buttons += permisos(d.permisos, d.expediente, d.idDocumento, d.tipo_documento, d.idSolicitud, 2, newBtn);
                            break;
                        case 90:
                            newBtn += `<button id="newDate" data-idSolicitud=${d.idSolicitud} data-idNotaria=${d.idNotaria} class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Nueva fecha"><i class="fas fa-calendar-alt"></i></button>`;
                            group_buttons += permisos(d.permisos, 1, d.idDocumento, d.tipo_documento, d.idSolicitud, 1, newBtn);
                            break;
                        default:
                            break;
                    }
                    $('[data-toggle="tooltip"]').tooltip();
                    return '<center>' + group_buttons + '<center>';
                }
            },
            {
                data: function (d) {
                    return d.idEstatus;   
                }
            }
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        },
        {
            "targets": [ 9 ],
            "visible": false
        }
        ],
        ajax: {
            url: 'getSolicitudes',
            type: "POST",
            cache: false,
            data: {
                "beginDate": beginDate,
                "endDate": endDate,
                "estatus":estatus
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
    $.post(action == 1 ? 'mailPresupuesto': action == 2 ? 'presupuestoCliente': action  == 3 ? 'mailNotaria': action  == 4 ? 'mailFecha':'mailPresupuesto', obj, function (data) {
        // if(data == true){//cambiar a true
        // }
        changeStatus(idSolicitud, action == 1 ? 4:0, 'correo enviado', 1);

        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function setInitialValues() {
    // BEGIN DATE
    const fechaInicio = new Date();
    // Iniciar en este a??o, este mes, en el d??a 1
    const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
    // END DATE
    const fechaFin = new Date();
    // Iniciar en este a??o, el siguiente mes, en el d??a 0 (as?? que as?? nos regresamos un d??a)
    const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
    finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
    finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
    finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
    
    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);

    fillTable(finalBeginDate, finalEndDate, $('#estatusE').val());
}

function getMotivosRechazos(tipo_documento) {
    $('#spiner-loader').removeClass('hide');
    $("#motivos_rechazo").find("option").remove();
    $("#motivos_rechazo").append($('<option disabled>').val("0").text("Seleccione una opci??n"));
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
    $("#documents").append($('<option disabled>').val("0").text("Seleccione una opci??n"));
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
    $("#notaria").append($('<option disabled>').val("0").text("Seleccione una opci??n"));
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
        $("#valuador").append($('<option disabled>').val("0").text("Seleccione una opci??n"));
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
        getEstatusPago();
        getTipoEscrituracion();
        $.post('getBudgetInfo',{
            idSolicitud:idSolicitud
        }, function(data) {
            $('#nombrePresupuesto').val(data.nombre);
            $('#nombrePresupuesto2').val(data.nombre_escrituras);
            $('#estatusPago').val(data.estatus_pago).trigger('change');
            $("#estatusPago").selectpicker('refresh');
            $('#superficie').val(data.superficie);
            var str = (data.modificado).split(" ")[0].split("-");
            var strM = `${str[2]}-${str[1]}-${str[0]}`;
            $('#fContrato').val(strM);
            $('#catastral').val(data.clave_catastral);
            $('#construccionInfo').val(data.nombreConst);
            $('#cliente').val(data.cliente_anterior == 1 ? 'uno':'dos').trigger('change');
            $("#cliente").selectpicker('refresh');
            $('#nombreT').val(data.nombre_anterior);
            $('#fechaCA').val(data.fecha_anterior);
            $('#rfcDatos').val(data.RFC);
            $("#encabezado").html(`${data.nombreResidencial} / ${data.nombreCondominio} / ${data.nombreLote}`);
            $('#tipoE').val(data.tipo_escritura).trigger('change');
            $("#tipoE").selectpicker('refresh');
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
        $('#estatusPago2').val(data.nombrePago);
        $('#superficie2').val(data.superfice);
        $('#fContrato2').val(data.modificado);
        $('#catastral2').val(data.clave_catastral);
        $('#construccion2').val(data.nombreConst);
        $('#cliente2').val(data.cliente_anterior == 1 ? 'uno':'dos').trigger('change');
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
    $("#cliente").append($('<option disabled>').val(0).text("Seleccione una opci??n"));
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
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="top" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                } else {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="top" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                    botones += newBtn;
                }
            } else {
                if (aditional == 2) {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="top" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                } else {
                    botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${expediente == null || expediente == '' ? 1 : 2} class="btn-data ${expediente == null || expediente == '' ? "btn-sky" : "btn-gray"} upload" data-toggle="tooltip" data-placement="top" title=${expediente == null || expediente == '' ? 'Cargar' : 'Eliminar'}>${expediente == null || expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
                    botones += newBtn;
                }
                botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>`;
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';
            }
            break;
        case 2: //lectura
            if (aditional == 1) {
                botones += newBtn;
            }
            if (expediente != 1) {
                botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>`;
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
                    botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>`;
                    botones += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-ban"></i></button>`;
                }
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';

            }
            break;
        case 4: //especial
            if (aditional == 1) {
                botones += newBtn;
            }
            if (expediente == 2) {// 2 CUANDO NING??N DOCUMENTO TENGA MOTIVOS DE RECHAZO
                botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="top" title="Enviar"><i class="far fa-paper-plane"></i></button>';
            }
            break;
    }
    return '<div class="d-flex justify-center">'+botones+'</div>';
}

function buildTableDetail(data, permisos) {
    var filtered = data.filter(function(value){ 
        if(value.tipo_documento == 13 && value.estatusActual == 11 && value.estatusPropuesta != 1){
        }else{
            return value;
        }
    });
    var solicitudes = '<table class="table subBoxDetail">';
    solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'DOCUMENTO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'CARGADO POR ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'MOTIVOS DE RECHAZO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'VALIDADO POR ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ESTATUS VALIDACI??N ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ACCIONES ' + '</b></td>';
    solicitudes += '</tr>';
    $.each(filtered, function (i, v) {

        //i es el indice y v son los valores de cada fila
        solicitudes += '<tr>';
        solicitudes += '<td> ' + (i + 1) + ' </td>';
        solicitudes += '<td> ' + v.nombre + ' </td>';
        solicitudes += '<td> ' + v.creado_por + ' </td>';
        solicitudes += '<td> ' + v.fecha_creacion + ' </td>';
        solicitudes += '<td> ' + v.motivos_rechazo + ' </td>';
        solicitudes += '<td> ' + v.validado_por + ' </td>';
        solicitudes += `<td> <span class="label" style="background:${v.colour}">${v.estatus_validacion}</span>${v.editado == 1 ? `<br><span class="label" style="background:${v.colour}">EDITADO</span>`:``} </td>`;
        /*data-action = 1 (UPLOAD FILE)
        data-action = 2 (DELETE FILE)*/

        solicitudes += '<td><div class="d-flex justify-center">';
        // MJ: TIENE PERMISOS (ESCRITURA) && (LA RAMA EST?? SIN VALIDAR O RECHAZADA) && VALIDACI??N ESTATUS
        if (permisos == 1 && (v.ev == null || v.ev == 2) && v.estatusActual == 10 && (v.tipo_documento == 7 || v.tipo_documento == 13)){
            solicitudes += ``;
            if(v.tipo_documento == 13){
                if(v.estatusPropuesta == null || v.estatusPropuesta == 0){
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-deepGray approve" data-toggle="tooltip" data-placement="top" title="Documento OK"><i class="fas fa-thumbs-up"></i></button>`;
                }else{
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-green approve" data-toggle="tooltip" data-placement="top" title="Documento NOK" disabled><i class="fas fa-thumbs-up"></i></button>`;
                }
            }
        }
        else if(permisos == 1 && (v.ev == null || v.ev == 2) && v.estatusActual == 10){
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-toggle="tooltip" data-placement="top" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }else if (permisos == 2 && v.estatusActual == 11) {
            if(v.tipo_documento == 13 || v.tipo_documento == 7){
                solicitudes += ``;
            }else{
                if (v.ev == 1) // MJ: VALIDADO OK
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-warning upload" data-toggle="tooltip" data-placement="top" title="Documento NOK"><i class="fas fa-thumbs-down"></i></button>`;
                else if (v.ev == 2) // MJ: VALIDADO NOK
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-green upload" data-toggle="tooltip" data-placement="top" title="Documento OK"><i class="fas fa-thumbs-up"></i></button>`;
                else { // MJ: SIN VALIDAR
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-gray upload" data-toggle="tooltip" data-placement="top" title="Sin validar OK"><i class="fas fa-thumbs-up"></i></button>`;
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-gray upload" data-toggle="tooltip" data-placement="top" title="Sin validar NOK"><i class="fas fa-thumbs-down"></i></button>`;
                }
            }
        }

        if (v.expediente == null || v.expediente == '')
            solicitudes += '';
        else
            solicitudes += `<button id="preview" data-doc="${v.expediente}" data-documentType="${v.tipo_documento}" class="btn-data btn-gray" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>`;

        solicitudes += '</div></td></tr>';

    });
    return solicitudes += '</table>';
}

function getSignDate(idNotaria) {
    let date = new Date();
    let i = 0;
    console.log(idNotaria);
    let dias = idNotaria == 1 ? 20:7;
    console.log(dias);

    while (i < dias) {//dias habiles despues del dia de hoy
        date.setTime(date.getTime() + 24 * 60 * 60 * 1000); // a??adimos 1 d??a
        if (date.getDay() != 6 && date.getDay() != 0)
            i++;
    }
    let minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
    let fecha = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + minutes;
    return fecha;
}

function changeStatus(id_solicitud, action, comentarios, type, notaria) {
    $('#spiner-loader').removeClass('hide');
    $.post('changeStatus', {
        id_solicitud: id_solicitud,
        type: type,
        comentarios: comentarios,
        notaria: notaria
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

//INSERTAR NUEVA NOTARIA
$(document).on("submit", "#newNotario", function (e) {
    e.preventDefault();
    let idSolicitud = $("#idSolicitud").val();
    let data = new FormData($(this)[0]);
    data.append('nombre_notaria', $('#nombre_notaria').val() == '' ? null : $('#nombre_notaria').val());
    data.append('nombre_notario', $('#nombre_notario').val() == '' ? null : $('#nombre_notario').val());
    data.append('direccion', $('#direccion').val() == '' ? null : $('#direccion').val());
    data.append('correo', $('#correo').val() == '' ? null : $('#correo').val());
    data.append('telefono', $('#telefono').val() == '' ? null : $('#telefono').val());
    data.append("idSolicitud", idSolicitud);
    //data.append('idSolicitud', $('#idSolicitud').val() == '' ? null : $('#idSolicitud').val());

    $.ajax({
        url: "nuevoNotario",
        data: data,
        cache: false,
        contentType: false,
        processData: false, 
        type: 'POST',
        success: function (response) {
            alerts.showNotification("top", "right", "Se agrego una nueva Notar??a.", "success");
            $("#altaNotario").modal("hide");
            prospectsTable.ajax.reload();
        }
    });
});

//MOSTRAR INFORMACION DE LA NOTARIA
$(document).on('click', '#notaria', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    getBudgetNotaria(data.idSolicitud);
    $('#idSolicitud').val(data.idSolicitud);
    $("#gestionNotaria").modal();
});

function getBudgetNotaria(idSolicitud){
    $.get('getBudgetNotaria',{
        idSolicitud:idSolicitud
    }, function(data) {
        $('#nombreNotaria').val(data.nombre_notaria);
        $('#nombreNotario').val(data.nombre_notario);
        $('#direccionN').val(data.direccion);
        $('#correoN').val(data.correo);
        $('#telefonoN').val(data.telefono);
    }, 'json');
}

//RECHAZAR NOTARIA
$(document).on("submit", "#rechazar", function (e) {
    e.preventDefault();
    let idSolicitud = $("#idSolicitud").val();
    let data = new FormData($(this)[0]);
    data.append("idSolicitud", idSolicitud);

    $.ajax({
        url: "rechazarNotaria",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            $("#gestionNotaria").modal("hide");
            prospectsTable.ajax.reload();
        }
    });
});

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

function getEstatusConstruccion() {
    $('#spiner-loader').removeClass('hide');
    $("#construccion").find("option").remove();
    $("#construccion").append($('<option disabled selected>').val("0").text("Seleccione una opci??n"));
    $.post('getEstatusConstruccion', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#construccion").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#construccion").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#construccion").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function getEstatusPago() {
    $('#spiner-loader').removeClass('hide');
    $("#estatusPago").find("option").remove();
    $("#estatusPago").append($('<option disabled selected>').val("0").text("Seleccione una opci??n"));
    $.post('getEstatusPago', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#estatusPago").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#estatusPago").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatusPago").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

function createDocRow(row, tr, thisVar){
    $.post("getDocumentsClient", {
        idEscritura: row.data().idSolicitud
    }).done(function (data) {
        row.data().solicitudes = JSON.parse(data);
        prospectsTable.row(tr).data(row.data());
        row = prospectsTable.row(tr);
        row.child(buildTableDetail(row.data().solicitudes, $('.details-control').attr('data-permisos'))).show();
        tr.addClass('shown');
        thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        $('#spiner-loader').addClass('hide');
    });
}
     
//ENVIO OBSERVACIONES
$(document).on('click', '#observacionesButton', function () {
    var data = prospectsTable.row($(this).parents('tr')).data();
    $('#idSolicitud').val(data.idSolicitud);
    $('#viewObservaciones').modal();
});

$(document).on('change', '#pertenece', function () {
    if($(this).val() == 'Postventa') {
        $('#postventa').show();
    }else {
        $('#postventa').hide();
    }
});

$(document).on('change', '#pertenece', function () {
    if($(this).val() == 'Proyectos') {
        $('#proyectos').show();
    }else {
        $('#proyectos').hide();
    }
});

$(document).on("submit", '#observacionesForm', function (e) {
    e.preventDefault();
    let idSolicitud = $("#idSolicitud").val();
    let data = new FormData($(this)[0]);
    data.append("idSolicitud", idSolicitud);

    $.ajax({
        url: "observacionesPostventa",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            $("#viewObservaciones").modal("hide");
            prospectsTable.ajax.reload();
        }
    });
});

$(document).on('click', '#observacionesSubmit', function (e) {
    e.preventDefault();
    let idSolicitud = $('#idSolicitud').val();
    let action = $('#action').val();
    let observaciones = $('#observacionesS').val();
    emailObservaciones(idSolicitud, 1, observaciones);
});

function emailObservaciones(idSolicitud, action, observaciones = null) {
    $('#spiner-loader').removeClass('hide');
    let obj;
    switch (action) {
        case '1':
            obj = {idSolicitud: idSolicitud, observaciones: observaciones};
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
    $.post(action == 1 ? 'mailObservaciones' : 'mailObservaciones', {idSolicitud: idSolicitud, observaciones: observaciones}, function (data) {
        // if(data == true){
        // }
        changeStatus(idSolicitud, action == 1 ? 4:0, 'Correo Env??ado a Proyectos', 1);

        $('#spiner-loader').addClass('hide');
        $("#viewObservaciones").modal("hide");
        prospectsTable.ajax.reload();
    }, 'json');
}

function saveEstatusLote(idSolicitud, data){
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: "saveEstatusLote",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (response) {
            if (response == 1) {
                $("#estatusLModal").modal("hide");
                $('#spiner-loader').addClass('hide');
                prospectsTable.ajax.reload();
                alerts.showNotification("top", "right", "Registro editado correctamente.", "success");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo sali?? mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

function createDocRowPresupuesto(row, tr, thisVar){
    $.post("getPresupuestos", {
        idEscritura: row.data().idSolicitud
    }).done(function (data) {
        row.data().solicitudes = JSON.parse(data);
        prospectsTable.row(tr).data(row.data());
        row = prospectsTable.row(tr);
        row.child(buildTableDetailP(row.data().solicitudes, $('.treePresupuesto').attr('data-permisos'))).show();
        tr.addClass('shown');
        thisVar.parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
        $('#spiner-loader').addClass('hide');
    });
}

function buildTableDetailP(data, permisos) {
    var filtered = data.filter(function(value){ 
        if(permisos == 2 && value.expediente == ''){
        }else{
            return value;
        }
    });
    var solicitudes = '<table class="table subBoxDetail">';
    solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
    solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'DOCUMENTO ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'TIPO DE PRESUPUESTO' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'FECHA ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ACCIONES ' + '</b></td>';
    solicitudes += '</tr>';
    console.log(permisos);
    $.each(filtered, function (i, v) {

        //i es el indice y v son los valores de cada fila
        solicitudes += '<tr>';
        solicitudes += '<td> ' + (i + 1) + ' </td>';
        solicitudes += '<td> ' + (permisos == 1 ? v.expediente:'Presupuesto') + ' </td>';
        solicitudes += '<td> ' + v.nombre + ' </td>';
        solicitudes += '<td> ' + v.fecha_creacion + '</td>';
        
        solicitudes += '<td><div class="d-flex justify-center">';
        if(permisos == 1){
            solicitudes += `<button data-idDocumento="${v.idPresupuesto}" data-documentType="13" data-presupuestoType="${v.tipo}" data-idSolicitud=${v.idSolicitud} data-details ="2" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-toggle="tooltip" data-placement="top" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-cloud-upload-alt"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }
  
        if (v.expediente == null || v.expediente == '')
            solicitudes += '';
        else
            solicitudes += `<button id="preview" data-idDocumento="${v.idPresupuesto}" data-doc="${v.expediente}" data-documentType="13" data-presupuestoType="${v.tipo}"  class="btn-data btn-gray" data-toggle="tooltip" data-placement="top" title="Vista previa"><i class="fas fa-eye"></i></button>`;

        solicitudes += '</div></td></tr>';

    });
    return solicitudes += '</table>';
}

function getEstatusEscrituracion(){
    $('#spiner-loader').removeClass('hide');
    $("#estatusE").find("option").remove();
    $("#estatusE").append($('<option selected>').val("0").text("Propios"));
    $("#estatusE").append($('<option>').val("1").text("Todos"));
    $("#estatusE").selectpicker('refresh');
    $('#spiner-loader').addClass('hide');
    // $.post('getEstatusEscrituracion', function(data) {
    //     var len = data.length;
    //     for (var i = 0; i < len; i++) {
    //         var id = data[i]['id_opcion'];
    //         var name = data[i]['nombre'];
    //         $("#estatusE").append($('<option>').val(id).text(name));
    //     }
    //     if (len <= 0) {
    //         $("#estatusE").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    //     }
    //     $("#estatusE").selectpicker('refresh');
    //     $('#spiner-loader').addClass('hide');
    // }, 'json');
}

function getTipoEscrituracion() {
    $('#spiner-loader').removeClass('hide');
    $("#tipoE").find("option").remove();
    $("#tipoE").append($('<option disabled selected>').val("0").text("Seleccione una opci??n"));
    $.post('getTipoEscrituracion', function(data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['id_opcion'];
            var name = data[i]['nombre'];
            $("#tipoE").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#tipoE").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#tipoE").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}