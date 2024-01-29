Shadowbox.init();

$(document).ready(function () {
    $('#addDeleteFileModal').on('hidden.bs.modal', function () {
        $('#fileElm').val(null);
        $('#file-name').val('');
    })

    $("input:file").on("change", function () {
        const target = $(this);
        const relatedTarget = target.siblings(".file-name");
        const fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
});

const AccionDoc = {
    DOC_NO_CARGADO: 1, // NO HAY DOCUMENTO CARGADO
    DOC_CARGADO: 2, // LA RAMA TIENE UN DOCUMENTO CARGADO
    SUBIR_DOC: 3, // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
    ELIMINAR_DOC: 4, // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
    ENVIAR_SOLICITUD: 5
};

let titulosTabla = [];
$('#cargaContratoFirmadoTabla thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#cargaContratoFirmadoTabla').DataTable().column(i).search() !== this.value)
            $('#cargaContratoFirmadoTabla').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip();
});

cargaContratoFirmadoTabla = $('#cargaContratoFirmadoTabla').DataTable({
    dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Lotes para reubicar',
        title: "Lotes para reubicar",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    },
    {
        extend: 'pdfHtml5',
        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
        className: 'btn buttons-pdf',
        titleAttr: 'Lotes para reubicar',
        title: "Lotes para reubicar",
        orientation: 'landscape',
        pageSize: 'LEGAL',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    }],
    columnDefs: [],
    pageLength: 10,
    bAutoWidth: false,
    fixedColumns: true,
    ordering: true,
    language: {
        url: `${general_base_url}static/spanishLoader_v2.json`,
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [
        { data: "nombreResidencial" },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "idLote" },
        { data: "nombreCliente" },
        {
            data: (d) => {
                return d.fechaApartado == null ? '-' : d.fechaApartado;
            }
        },
        { data: "estatusPreproceso" },
        {
            data: (d) => {
                return `<label class="label ${d.nombreDocumento == null ? 'lbl-warning' : 'lbl-green'}">${d.estatusContratoFirmado}</label>`;
            }
        },
        {
            data: function (d) {
                const DATE = new Date();
                const DATE_STR = [DATE.getMonth() + 1, DATE.getDate(), DATE.getFullYear()].join('-');
                const TITULO_DOCUMENTO = `${d.abreviaturaNombreResidencial}_${d.nombreLote}_${d.idLote}_${d.idCliente}_TDOC${d.tipoDocumento}${d.rama.slice(0, 4)}_${DATE_STR}`;
                let BOTON_ELIMINAR = `<button class="btn-data btn-warning addRemoveFile" data-toggle="tooltip" data-placement="top" title= "ELIMINAR DOCUMENTO" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-idDocumento="${d.idDocumento}" data-tipoDocumento="${d.tipoDocumento}" data-accion="2" data-nombre="${d.rama}"><i class="fas fa-trash"></i></button>`;
                let BOTON_CARGAR = `<button class="btn-data btn-green addRemoveFile" data-toggle="tooltip" data-placement="top" title= "SUBIR DOCUMENTO" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-idDocumento="${d.idDocumento}" data-tipoDocumento="${d.tipoDocumento}" data-accion="1" data-nombre="${d.rama}" data-tituloDocumento="${TITULO_DOCUMENTO}"><i class="fas fa-upload"></i></button>`;
                let BOTON_VER = `<button class="btn-data btn-blueMaderas verDocumento" data-toggle="tooltip" data-placement="top" title= "VER DOCUMENTO" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-idDocumento="${d.idDocumento}" data-tipoDocumento="${d.tipoDocumento}" data-accion="3" data-nombre="${d.rama}" data-nombreDocumento="${d.nombreDocumento}"><i class="fas fa-eye"></i></button>`;
                return `<div class="d-flex justify-center">${d.nombreDocumento == null ? BOTON_CARGAR : BOTON_VER + BOTON_ELIMINAR}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Reestructura/getLotesParaCargarContratoFirmado`,
        dataSrc: "",
        type: "POST",
        cache: false,
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    }
});

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
            (accion === AccionDoc.DOC_NO_CARGADO) ? 'Selecciona el archivo que desees asociar a <b>' + nombreDocumento + '</b>' : (accion === AccionDoc.DOC_CARGADO) ? '¿Estás seguro de eliminar el archivo <b>' + nombreDocumento + '</b>?' : 'Selecciona los motivos de rechazo que asociarás al documento <b>' + nombreDocumento + '</b>.';
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

$(document).on('click', '.verDocumento', function () {
    const $itself = $(this);
    let pathUrl = `${general_base_url}static/documentos/cliente/contratoFirmado/${$itself.attr("data-nombreDocumento")}`;
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${pathUrl}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${$itself.attr('data-nombreDocumento')}`,
        width: 985,
        height: 660
    });
});

