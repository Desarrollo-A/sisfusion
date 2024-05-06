$(document).ready(function () {
console.log("JS loaded...");
fillInputs(); //Carga los inputs
// $('#avanza-proceso-liberacion').modal('toggle');
});

$("input:file").on("change", function () {
    const target = $(this);
    const relatedTarget = target.siblings(".file-name");
    const fileName = target[0].files[0].name;
    relatedTarget.val(fileName);
});

const AccionDoc = {
    DOC_NO_CARGADO: 1, // NO HAY DOCUMENTO CARGADO
    DOC_CARGADO: 2, // LA RAMA TIENE UN DOCUMENTO CARGADO
    SUBIR_DOC: 3, // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
    ELIMINAR_DOC: 4, // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
    ENVIAR_SOLICITUD: 5
};

const documentoLiberacion = {
    RESCISION_CONTRATO: 1,
    AUTORIZACION_DG: 2
};

let titulosTabla = [];
$('#liberacionesDataTable thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#liberacionesDataTable').DataTable().column(i).search() !== this.value) {
            $('#liberacionesDataTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

let liberacionesDataTable = $('#liberacionesDataTable').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Liberación de lotes (Particulares)',
        title:"Liberación de lotes (Particulares)",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
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
        titleAttr: 'Liberación de lotes (Particulares)',
        title:"Liberación de lotes (Particulares)",
        orientation: 'landscape',
        pageSize: 'LEGAL',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 21, 22, 24],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    }],
    columnDefs: [
        {
            searchable: true,
            visible: true
        },
        { 
            orderable: true, 
            targets: '_all' 
        }
    ],
    pageLength: 10,
    bAutoWidth: false,
    fixedColumns: true,
    ordering: true,
    language: {
        url: general_base_url+"static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    order: [[4, "desc"]],
    destroy: true,
    columns: [
        {
            data: (d) => d.nombreResidencial
        },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "idLote" },
        { data: "cliente" },
        { data: "nombreAsesor" },
        { data: "nombreCoordinador" },
        { data: "nombreGerente" },
        { data: "nombreSubdirector" },
        { data: "nombreRegional" },
        { data: "nombreRegional2" },
        { data: "fechaApartado" },
        { data: "sup"},
        {
            data: function (d) {
                return d.costom2f == 'SIN ESPECIFICAR' ? d.costom2f : `$${formatMoney(d.costom2f)}`;
            }
        },
        {
            data: function (d) {
                return `$${formatMoney(d.total)}`
            }
        },
        {
             // "visible": (id_rol_general == 4) ? false : true,
            data: function (d) {
                return `<div class="d-flex justify-center">${datatableButtons(d)}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Liberaciones/getLotesParaLiberacion`,
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

const datatableButtons = (d) => {
    const BTN_AVANCE = `<button class="btn-data btn-green btn-avanzar"
        data-toggle="tooltip" 
        data-placement="left"
        title="ENVIAR A CONTRALORÍA"
        data-idLote="${d.idLote}"
        data-idCliente="${d.idCliente}"
        data-nombreLote="${d.nombreLote}">
            <i class="fas fa-thumbs-up"></i>
        </button>`;

    const BTN_INFO =  `<button class="btn-data btn-blueMaderas btn-informacion-liberacion"
        data-toggle="tooltip" 
        data-placement="left"
        title="INFORMACIÓN DE LIBERACIÓN">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
        </button>`;
    
    let BUTTONREGRESO = '';


    if (id_rol_general == 55) // POSTVENTA
        return BTN_INFO + BTN_AVANCE;
    if (id_rol_general == 80) // Ni idea, lo dejo para futura revisión 
        return BTN_REESTRUCTURA + BUTTONREGRESO;
    return '';
}

const fillInputs = () => {
    const documentos = Object.freeze({
        LIB_PARTICULARES: 130,
    })

    $catalogo = null;
    switch ( id_rol_general ) {
        case 130:
            $catalogo = documentos.LIB_PARTICULARES;
            break;
        default:
            break;
    }

    $.ajax({
        url: "obtenerDocumentacionPorLiberacion",
        type: "POST",
        data: {catalogo: 31},
        dataType: "json",
        success: function(data) {
            for (let i = 0; i < data.length; i++) {
                if ([51, 52].includes(data[i]['id_opcion'])) $("#id_documento_liberacion").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            }
            $('#id_documento_liberacion').selectpicker('refresh');
        }
    });
}

$(document).on("click", ".upload", function () {
    $("#spiner-loader").removeClass("hidden");
    let idDocumento = $(this).attr("data-idDocumento");
    let documentType = $(this).attr("data-documentType");
    let action = $(this).data("action");
    let documentName = $(this).data("name");
    let presupuestoType = $(this).attr("data-presupuestoType");
    let documento_validar = $(this).attr("data-data-documento-validar");
    let idPresupuesto = $(this).attr("data-idPresupuesto");
    let idNxS = $(this).attr("data-idNxS");
    let id_estatus = $(this).attr("data-id-estatus");
    $("#idSolicitud").val($(this).attr("data-idSolicitud"));
    $("#idDocumento").val(idDocumento);
    $("#documentType").val(documentType);
    $("#docName").val(documentName);
    $("#action").val(action);
    $("#documento_validar").val(documento_validar);
    $("#presupuestoType").val(presupuestoType);
    $("#idPresupuesto").val(idPresupuesto);
    $("#idNxS").val(idNxS);
    $("#id_estatus").val(id_estatus);
    $("#details").val($(this).data("details"));
    if (action == 1 || action == 2 || action == 4) {
      document.getElementById("mainLabelText").innerHTML =
        action == 1
          ? "Seleccione el archivo que desees asociar."
          : action == 2
          ? "¿Estás seguro de eliminar el archivo?"
          : "Seleccione los motivos de rechazo que asociarás al documento.";
      document.getElementById("secondaryLabelDetail").innerHTML =
        action == 1
          ? "El documento que hayas elegido se almacenará de manera automática una vez que des clic en guardar."
          : action == 2
          ? "El documento se eliminará de manera permanente una vez que des clic en Guardar."
          : "Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en Guardar.";
      if (action == 1) {
        // ADD FILE
        $("#selectFileSection").removeClass("hide");
        $("#rejectReasonsSection").addClass("hide");
        $("#txtexp").val("");
      } else if (action == 2) {
        // REMOVE FILE
        $("#selectFileSection").addClass("hide");
        $("#rejectReasonsSection").addClass("hide");
      } else {
        // REJECT FILE
        filterSelectOptions(documentType);
        $("#selectFileSection").addClass("hide");
        $("#rejectReasonsSection").removeClass("hide");
      }
      $("#uploadedDocument").val("");
      $("#uploadedDocument").trigger("change");
      $("#uploadModal").modal();
    } else if (action == 3) {
      $("#sendRequestButton").click();
    }
    $("input:file").on("change", function () {
      var target = $(this);
      var relatedTarget = target.siblings(".file-name");
      if (target.val() == "") {
        var fileName = "No ha seleccionado nada aún";
      } else {
        var fileName = target[0].files[0].name;
      }
      relatedTarget.val(fileName);
    });
    $("#spiner-loader").addClass("hidden");
});

// Este fragmento de código muestra el modal con la información del registro seleccionado
$(document).on('click', '.btn-avanzar', async function(){
     // Leemos los datos del registro
     const idLote = $(this).attr("data-idLote");
     const idCliente = $(this).attr("data-idCliente");
     const nombreLote = $(this).attr("data-nombreLote");

    // Mostramos el modal y mostramos la info del lote en el modal
    $('#nombreLoteLiberar').html(nombreLote);
    $('#id_documento_liberacion').val('');
    $('#id_documento_liberacion').selectpicker('refresh');
    const relatedTarget = $('#archivo_liberacion').siblings(".file-name");
    relatedTarget.val('');
    $("#comentario").val('');
    $('#modal-proceso-liberacion').modal('show');
    
    const info = 
        '<input type="hidden" id="idLote"></input>' +
        '<input type="hidden" id="idCliente"></input>' +
        '<input type="hidden" id="procesoLib"></input>' +
        '<input type="hidden" id="estatusLib"></input>' +
        '<input type="hidden" id="concepto"></input>' ;
    $('#modal-liberacion').append(info);
    
    // Asignación de valores a los inputs
    $("#idLote").val(idLote);
    $("#idCliente").val(idCliente);
    $("#procesoLib").val(2); // El proceso es con que area se encuentra, 1 postventa, 2, contraloria, 3 otro y asi..
    $("#estatusLib").val(1); // Estatus liberacion: 1 bien primera vez, 2 rechazo, 3 corregido.
    $("#concepto").val(1); // Particulares 1, bloqueo 2 y asi
});

//Este fragmento de código se acciona al presionar el botón de aceptar liberación del modal
$(document).on("click", "#btn-proceso-liberacion", function (e) {
    e.preventDefault();
    $('#btn-proceso-liberacion').attr('disabled', true); // Deshabilita botón

    // Obteniendo los valores para su proceso
    const idLote = $("#idLote").val();
    const idCliente = $("#idCliente").val();
    const rescision = $("#id_documento_liberacion").val() ==  51 ? 1 : 0;
    const autorizacionDG = $("#id_documento_liberacion").val() ==  52 ? 1 : 0;
    const relatedTarget = $('#archivo_liberacion').siblings(".file-name");
    const procesoLib = $("#procesoLib").val();
    const estatusLib = $("#estatusLib").val();
    const concepto = $("#concepto").val();
    const comentario = $("#comentario").val();
    // Validamos que no falte data
    if ( rescision === 0 && autorizacionDG === 0 ){
        $('#btn-proceso-liberacion').attr('disabled', false);
        return alerts.showNotification("top", "right", "Seleccione el tipo de archivo a adjuntar.", "warning");
    } 
    if (relatedTarget.val() === '') {
        $('#btn-proceso-liberacion').attr('disabled', false);
        return alerts.showNotification("top", "right", "Seleccione el archivo a adjuntar.", "warning");
    }

    $('#spiner-loader').removeClass('hide');

    // Datos a envíar al endpoint para su registro.
    const data = new FormData();
    data.append("idLote", idLote);
    data.append("id_cliente", idCliente);
    data.append("rescision", rescision);
    data.append("autorizacion_DG", autorizacionDG);
    data.append("proceso_lib", procesoLib);
    data.append("estatus_lib", estatusLib);
    data.append("concepto", concepto);
    data.append("comentario", comentario);
    
    $.ajax({
        type: 'POST',
        url: 'iniciaLiberacionLote',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            const res = JSON.parse(data);
            console.log(res);
            if (res.status === 200) alerts.showNotification("top", "right", 'Se ha subido correctamente el archivo.', "success");
            if (res.status === 400) alerts.showNotification("top", "right", "Ocurrió un error", "warning");
            if (res.status === 500) alerts.showNotification("top", "right", "Oops, algo salió mal al subir el archivo, inténtalo de nuevo.", "warning");
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    liberacionesDataTable.ajax.reload();
    $('#modal-proceso-liberacion').modal('hide');
    $('#btn-proceso-liberacion').attr('disabled', false); // Lo vuelvo a activar
    $('#spiner-loader').addClass('hide');
});



/*  TO DO LIST
/       1.- Mostrar input select de tipo de archivo a 
/
*/