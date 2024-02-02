$(document).on("click", ".addRemoveFile", function (e) {
    e.preventDefault();
    let idDocumento = $(this).attr("data-idDocumento");
    let tipoDocumento = $(this).attr("data-tipoDocumento");
    let accion = parseInt($(this).data("accion"));
    let nombreDocumento = $(this).data("nombre");

    $("#idLoteValue").val($(this).attr("data-idLote"));
    $("#idDocumento").val(idDocumento);
    $("#tipoDocumento").val(tipoDocumento);
    $("#nombreDocumento").val(nombreDocumento);
    $('#tituloDocumento').val($(this).attr('data-tituloDocumento'));
    $("#accion").val(accion);

    if (accion === AccionDoc.DOC_NO_CARGADO || accion === AccionDoc.DOC_CARGADO) {
        document.getElementById("mainLabelText").innerHTML =
            (accion === AccionDoc.DOC_NO_CARGADO)
                ? 'Selecciona el archivo que desees asociar a <b>' + nombreDocumento + '</b>'
                : (accion === AccionDoc.DOC_CARGADO)
                ? '¿Estás seguro de eliminar el archivo <b>' + nombreDocumento + '</b>?'
                : 'Selecciona los motivos de rechazo que asociarás al documento <b>' + nombreDocumento + '</b>.';

        document.getElementById("secondaryLabelDetail").innerHTML =
            (accion === AccionDoc.DOC_NO_CARGADO)
                ? 'El documento que hayas elegido se almacenará de manera automática una vez que des clic en <i>Guardar</i>.'
                : (accion === AccionDoc.DOC_CARGADO)
                ? 'El documento se eliminará de manera permanente una vez que des clic en <i>Guardar</i>.'
                : 'Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en <i>Guardar</i>.';

        if (accion === AccionDoc.DOC_NO_CARGADO) { // ADD FILE
            $("#selectFileSection").removeClass("hide");
            $("#txtexp").val("");
        }

        if (accion === AccionDoc.DOC_CARGADO) { // REMOVE FILE
            $("#selectFileSection").addClass("hide");
        }

        $("#addDeleteFileModal").modal("show");
    }

    if (accion === AccionDoc.SUBIR_DOC) {
        const fileName = $(this).attr("data-file");
        window.location.href = getDocumentPath(tipoDocumento, fileName, 0, 0, 0);
        alerts.showNotification("top", "right", "El documento <b>" + nombreDocumento + "</b> se ha descargado con éxito.", "success");
    }

    if (accion === AccionDoc.ENVIAR_SOLICITUD) {
        $("#sendRequestButton").click();
    }
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    const accion = parseInt($("#accion").val());
    if (accion === AccionDoc.DOC_NO_CARGADO) { // UPLOAD FILE
        const uploadedDocument = document.getElementById("fileElm").value;
        let validateUploadedDocument = (uploadedDocument.length === 0);
        // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVE A CABO EL REQUEST
        if (validateUploadedDocument) {
            alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
            return;
        }
        const archivo = $("#fileElm")[0].files[0];
        const tipoDocumento = parseInt($("#tipoDocumento").val());
        let extensionDeDocumento = archivo.name.split('.').pop();
        let extensionesPermitidas = 'pdf';
        let statusValidateExtension = validateExtension(extensionDeDocumento, extensionesPermitidas);
        if (!statusValidateExtension) { // MJ: ARCHIVO VÁLIDO PARA CARGAR
            alerts.showNotification("top", "right", `El archivo que has intentado cargar con la extensión <b>${extensionDeDocumento}</b> no es válido. Recuerda seleccionar un archivo ${extensionesPermitidas}`, "warning");
            return;
        }
        const nombreDocumento = $("#nombreDocumento").val();
        let data = new FormData();
        data.append("idLote", $("#idLoteValue").val());
        data.append("idDocumento", $("#idDocumento").val());
        data.append("tipoDocumento", tipoDocumento);
        data.append("uploadedDocument", archivo);
        data.append("accion", accion);
        data.append('tituloDocumento', $('#tituloDocumento').val());
        $.ajax({
            url: `${general_base_url}Documentacion/subirArchivo`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function () {
                $('#uploadFileButton').prop('disabled', true);
            },
            success: function (response) {
                const res = JSON.parse(response);

                if (res.code === 200) {
                    alerts.showNotification("top", "right", `El documento ${nombreDocumento} se ha cargado con éxito.`, "success");
                    cargaContratoFirmadoTabla.ajax.reload();
                    $("#addDeleteFileModal").modal("hide");
                }
                if (res.code === 400)
                    alerts.showNotification("top", "right", res.message, "warning");
                if (res.code === 500)
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    } else { // VA A ELIMINAR
        const nombreDocumento = $("#nombreDocumento").val();
        let data = new FormData();
        data.append("idDocumento", $("#idDocumento").val());
        data.append("tipoDocumento", parseInt($("#tipoDocumento").val()));
        $.ajax({
            url: `${general_base_url}Documentacion/eliminarArchivo`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                const res = JSON.parse(response);
                $("#sendRequestButton").prop("disabled", false);
                if (res.code === 200) {
                    alerts.showNotification("top", "right", `El documento ${nombreDocumento} se ha eliminado con éxito.`, "success");
                    cargaContratoFirmadoTabla.ajax.reload();
                    $("#addDeleteFileModal").modal("hide");
                }
                if (res.code === 400)
                    alerts.showNotification("top", "right", res.message, "warning");
                if (res.code === 500)
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});
