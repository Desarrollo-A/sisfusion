$(document).ready(function () {
    getResidenciales();

    $("#rescision-file-input").on("change", function () {
        let archivo = $(this).siblings("#rescision-file-name");
        let nombre = $(this)[0].files[0].name;
        archivo.val(nombre);
    });
});




let titulos = [];
$('#liberacionesTable thead tr:eq(0) th').each( function (i) {
    let title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        console.log($("#liberacionesTable").DataTable().column(i).search(), this.value)
        if ($('#liberacionesTable').DataTable().column(i).search() !== this.value ) {
            $('#liberacionesTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
})

function closeModal(){
    $('#marcarLiberarModal').modal("hide");
    document.getElementById('msj').innerHTML = '';
    $('#idLote').val('')
    $('#selectTipoLiberacion').val('');
    $('#justificacionMarcarLiberar').val('');
}

function getResidenciales() {
    $("#selectResidenciales").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getResidencialesList',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            for (let i = 0; i < response.length; i++) {
                let id = response[i]['idResidencial'];
                let name = response[i]['descripcion'];
                $("#selectResidenciales").append($('<option>').val(id).text(name));
            }
            $("#selectResidenciales").selectpicker('refresh');
        }
    });
}

function updateLotesStatusLiberacion(e) {
    let idLote = $(generalDataTable.$('input[name="idT[]"]:checked')).map(function () {
        return this.value;
    }).get();
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Contraloria/updateLotesStatusLiberacion',
        data: {
            'idLote': idLote
        },
        dataType: 'json',
        success: function (data) {
            if (data == 0) {
                alerts.showNotification("top", "right", "Los registros han sido actualizados de manera éxitosa.", "success");
                $("#liberacionesTable").DataTable().ajax.reload();
            } else {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

function fillTable(idCondominio) {
    generalDataTable = $('#liberacionesTable').dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Liberaciones',
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
                    }
                }
            }
        }],
        pagingType: "full_numbers",
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            visible: false,
        },
        {
            data: function (d){
                return d.nombreResidencial;
            }
        },
        {
            data: function (d){
                return d.nombre;
            }
        },
        {
            data: function (d) {
                return d.idLote;
            }
        },
        {
            data: function (d) {
                return d.nombreLote;
            }
        },
        {
            data: function (d) {
                return d.referencia;
            }
        },
        {
            data: function (d) {
                if(d.nombreCliente == 0 || d.nombreCliente == null)
                {
                    return 'Sin Cliente';
                }else{
                    return d.nombreCliente;
                }
            }
        },
        {
            data: function (d) {
                return d.fechaApartado ? d.fechaApartado.split('.')[0] : 'Sin fecha';
            }
        },
        {
            data: function (d) {
                return '<span class="label" style="color:#' + d.colorEstatusContratacion +'; background:#' + d.colorEstatusContratacion + '18;">' + d.estatusContratacion + '</span>';
            }
        },
        {
            data: function (d) {
                btns = '';
                return btns = '<div class="d-flex justify-center"><button data-toggle="tooltip" data-placement="left" title="Liberar"'+
                ' class="btn-data btn-green marcar-para-liberar" data-id-lote="' + d.idLote +'" data-idcondominio="'+d.idCondominio+'" data-idcliente="'+d.id_cliente+'" data-nombre-lote=" '+ d.nombreLote +'" data-proceso="1"'+
                ' data-idrol="'+d.id_rol+'"><i class="fas fa-thumbs-up"></i></button></div>';
            }
        }],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox dt-body-center',
            targets: 0,
            searchable: false,
            render: function (d, type, full, meta) {
                return '';
            },
            select: {
                style: 'os',
                selector: 'td:first-child'
            },
        }],
        ajax: {
            url: general_base_url + 'Contraloria/getLiberacionesInformation',
            type: "POST",
            cache: false,
            data: {
                "idCondominio": idCondominio
            }
        }
    });
}

function fillFilesTable(idLote) {
    let tabla_archivos_lotes = $("#archivosDataTable").DataTable({
        width: '100%',
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [],
        pagingType: "full_numbers",
        language: {
            url: general_base_url + "static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 5,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [{
            data: function (d) {
                return '<p class="m-0">' + d.nombre_archivo + '</p>';
            }
        },
        {
            data: function (d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-info see-doc-btn" data-toggle="tooltip" data-placement="left" title= "Visualizar archivo" data-id-archivo="' +d.id_archivo_liberacion+ '"><i class="fas fa-file-alt"></i></button></div>';        
            }
        }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: general_base_url + "Contraloria/get_archivos_lote",
            type: "POST",
            cache: false,
            data: {
                "idLote": idLote,
            }, dataSrc: ''
        },
        initComplete: function(){
            $("#spiner-loader").addClass('hide');
        },
        "order": [
            [1, 'asc']
        ],
    });
    
    $('#archivosDataTable').on('draw.dt', function() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

function openFilesModal(idLote){
    $("#filesModal").modal('show');
    fillFilesTable(idLote); 
}

// function openUploadFileModal(){
    // $("#uploadfilesModal").modal('show');
// }

function refreshTipoLiberacionesPicker() {
    let fileContainer = document.getElementById("fileContainer");
    if (!fileContainer.classList.contains('d-none')) fileContainer.classList.add('d-none');
    $("#selectTipoLiberacion").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'Contraloria/get_tipo_liberaciones',
        type: 'GET',
        dataType: 'JSON',
        success: function (res) {
            for (let i = 0; i < res.length; i++) {
                let id = res[i]['id_opcion'];
                let tipo = res[i]['nombre_opc'];
                $("#selectTipoLiberacion").append($('<option>').val(id).text(tipo));
            }
            $("#selectTipoLiberacion").selectpicker('refresh');
        }, error: function (e) {
            console.log('error:', e)
        }, catch: function (c) {
            console.log('catch:', c)
        }
    });
}

$(document).on('click', '.remove-mark', function () { // MJ: FUNCIÓN CAMBIO DE ESTATUS ACTIVO / INACTIVO
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Contraloria/removeMark',
        data: {
            'idLote': $(this).attr("data-idLote")
        },
        dataType: 'json',
        success: function (data) {
            if (data == 1) {
                alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
                $("#liberacionesTable").DataTable().ajax.reload();
            } else {
                alerts.showNotification(" ", "right", "Oops, algo salió mal.", "warning");
            }
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.marcar-para-liberar', function(e) {
  e.preventDefault();
  refreshTipoLiberacionesPicker();
  document.getElementById('btnMarcarParaLiberar').disabled = false;
  
  let proceso = $(this).attr("data-proceso");
  let id_lote = $(this).attr("data-id-lote");
  let idCondominio = $(this).attr("data-idcondominio");
  let id_cliente = $(this).attr("data-idcliente");
  let nombre_lote = $(this).attr("data-nombre-lote");

  console.log(id_cliente);

  if(proceso == 1){
    document.getElementById('msj').innerHTML = 'Liberación del lote <b>' + id_lote + '</b> con nombre <b>' + nombre_lote + '</b>';
    $('#idLote').val(id_lote);
    $('#idCondominio').val(idCondominio);
    $('#idCliente').val(id_cliente);
    $('#marcarLiberarModal').modal('toggle');
  }
});

$(document).on('click', '.delete-btn', function(e) {
  let idArchivoLote = $(this).data('id-archivo');
  console.log("Este es el id del archivo a borrar: ", idArchivoLote);
});

$("#marcarLiberarForm").on('submit', function(e){
  e.preventDefault();
  let idLote = $('#idLote').val();
  let idCliente = $('#idCliente').val();
  let idCondominio = $('#idCondominio').val();
  let selectTipoLiberacion = $('#selectTipoLiberacion').val();
  let textoSeleccionado = $(this).find("option:selected").text();
  let justificacionMarcarLiberar = $('#justificacionMarcarLiberar').val();
  let archivo = $("#rescision-file-input")[0].files[0];
  let hacerUpdate = 0;  

  if (!idLote){
    return alerts.showNotification('top', 'right', '¡Algo salió mal, intentalo de nuevo!', 'warning');
  } else if (selectTipoLiberacion == '') {
    return alerts.showNotification('top', 'right', '¡Falta seleccionar el tipo de liberación!', 'warning');
  } else if (justificacionMarcarLiberar.length == 0 || justificacionMarcarLiberar == '') {
    return alerts.showNotification('top', 'right', '¡Falta por llenar el campo de comentarios!', 'warning');
  } else if (selectTipoLiberacion == '1' && textoSeleccionado == 'Rescisión') {
    if (!archivo) {
      return alerts.showNotification('top', 'right', '¡Anexa el archivo de rescisión!', 'warning');
    }else{
      hacerUpdate = 1;
    }
  }else if (selectTipoLiberacion == '2' && textoSeleccionado == 'Devolución'){
    hacerUpdate = 1;
  }else {
    return alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
  }
  
  if (hacerUpdate === 1) {
    document.getElementById('btnMarcarParaLiberar').disabled = true;
    let data = new FormData();
    data.append("idLote", idLote);
    data.append("selectTipoLiberacion", selectTipoLiberacion);
    data.append("justificacionMarcarLiberar", justificacionMarcarLiberar);
    data.append("archivo", archivo);
    data.append("idCondominio", idCondominio);
    data.append("idCliente", idCliente);
    console.log(idCliente);
        // data.append("tipoLiberacion" , selectTipoLiberacion);
    //console.log(data); PENDIENTE
    
    $.ajax({
      url: general_base_url + 'Contraloria/updateLoteMarcarParaLiberar',
      type: 'POST',
      data: data,
      dataType: 'JSON',
      processData: false,
      contentType: false,
      success: function (response) {
        if(response == true){
          alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
          $("#liberacionesTable").DataTable().ajax.reload();
          closeModal();
        }else if(response == false){
          document.getElementById('btnMarcarParaLiberar').disabled = true;
          alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
        } else {
          document.getElementById('btnMarcarParaLiberar').disabled = true;
          alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
        }
      },
      error: function (e) {
        console.log('catch',e);
        document.getElementById('btnMarcarParaLiberar').disabled = true;
        alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
      }
    });
  }
});

$('#liberacionesTable').on('draw.dt', function() {
  $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

$('#selectTipoLiberacion').change(function () {
  let fileContainer = document.getElementById("fileContainer");
  let valorSeleccionado = $(this).val();
  let textoSeleccionado = $(this).find("option:selected").text();  
  
  if (valorSeleccionado === "1" && textoSeleccionado === 'Rescisión') {
    if (fileContainer.classList.contains('d-none')) fileContainer.classList.remove('d-none'); // Para ocultar el fragmento
  }else if (valorSeleccionado === "1" && textoSeleccionado != 'Rescisión'){
    if (!fileContainer.classList.contains('d-none')) fileContainer.classList.add('d-none'); // Para ocultar el fragmento
  }else {
    if (!fileContainer.classList.contains('d-none')) fileContainer.classList.add('d-none'); // Para ocultar el fragmento
  }
});

$('#selectResidenciales').change(function () {
  let idResidencial = $(this).val();
  $("#selectCondominios").empty().selectpicker('refresh');
  let postData = "idResidencial=" + idResidencial;

  $.ajax({
    url: general_base_url + 'General/getCondominiosList',
    type: 'post',
    data:postData,
    dataType: 'JSON',
    success: function (response) {
      for (let i = 0; i < response.length; i++) {
        let id = response[i]['idCondominio'];
        let name = response[i]['nombre'];
        $("#selectCondominios").append($('<option>').val(id).text(name));
      }
      $("#selectCondominios").selectpicker('refresh');
    }
  });
});

$('#uploadFile').on('submit', function(e){
    console.log(e);
});

$('#selectCondominios').change(function () {
  let idCondominio = $(this).val();
  $('#liberacionesTable').removeClass('hide');
  fillTable(idCondominio);
});

const AccionDoc = { 
  DOC_NO_CARGADO: 1, // NO HAY DOCUMENTO CARGADO
  DOC_CARGADO: 2, // LA RAMA TIENE UN DOCUMENTO CARGADO
  SUBIR_DOC: 3, // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
  ELIMINAR_DOC: 4, // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
  ENVIAR_SOLICITUD: 5,
};

Shadowbox.init();

$(document).ready(function () {
  $("#addDeleteFileModal").on("hidden.bs.modal", function () {
    $("#fileElm").val(null);
    $("#file-name").val("");
  });
  
  $("input:file").on("change", function () {
    const target = $(this);
    const relatedTarget = target.siblings(".file-name");
    const fileName = target[0].files[0].name;
    relatedTarget.val(fileName);
  });
});

// $(document).on("click", ".addRemoveFile", function (e) {
//   e.preventDefault();
//   let idDocumento = $(this).attr("data-idDocumento");
//     //console.log(idDocumento);
//   let tipoDocumento = $(this).attr("data-tipoDocumento");
//   let accion = parseInt($(this).data("accion"));
//   let nombreDocumento = $(this).data("nombre");
//   $("#idLoteValue").val($(this).attr("data-idLote"));
//   $("#idDocumento").val(idDocumento);
//   $("#tipoDocumento").val(tipoDocumento);
//   $("#nombreDocumento").val(nombreDocumento);
//   $("#tituloDocumento").val($(this).attr("data-tituloDocumento"));
//   $("#accion").val(accion);
  
//   if (accion === AccionDoc.DOC_NO_CARGADO || accion === AccionDoc.DOC_CARGADO) {
//     document.getElementById("mainLabelText").innerHTML =
//     accion === AccionDoc.DOC_NO_CARGADO
//     ? "Selecciona el archivo que desees asociar a <b>" +
//     nombreDocumento +
//     "</b>"
//     : accion === AccionDoc.DOC_CARGADO
//     ? "¿Estás seguro de eliminar el archivo <b>" + nombreDocumento + "</b>?"
//     : "Selecciona los motivos de rechazo que asociarás al documento <b>" +
//     nombreDocumento +
//     "</b>.";
//     document.getElementById("secondaryLabelDetail").innerHTML =
//     accion === AccionDoc.DOC_NO_CARGADO
//     ? "El documento que hayas elegido se almacenará de manera automática una vez que des clic en <i>Guardar</i>."
//     : accion === AccionDoc.DOC_CARGADO
//     ? "El documento se eliminará de manera permanente una vez que des clic en <i>Guardar</i>."
//     : "Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en <i>Guardar</i>.";
    
//     if (accion === AccionDoc.DOC_NO_CARGADO) {
//       // ADD FILE
//       $("#selectFileSection").removeClass("hide");
//       $("#txtexp").val("");
//     }
//     if (accion === AccionDoc.DOC_CARGADO) {
//       // REMOVE FILE
//       $("#selectFileSection").addClass("hide");
//     }
//     $("#addDeleteFileModal").modal("show");
//   }
  
  // if (accion === AccionDoc.SUBIR_DOC) {
  //   const fileName = $(this).attr("data-file");
  //   window.location.href = getDocumentPath(tipoDocumento, fileName, 0, 0, 0);
  //   alerts.showNotification(
  //     "top",
  //     "right",
  //     "El documento <b>" + nombreDocumento + "</b> se ha descargado con éxito.",
  //     "success"
  //     );
  //   }
    
  //   if (accion === AccionDoc.ENVIAR_SOLICITUD) {
  //     $("#sendRequestButton").click();
  //   }
  // });


  $(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    const accion = parseInt($("#accion").val());
    if (accion === AccionDoc.DOC_NO_CARGADO) {
      // UPLOAD FILE
      const uploadedDocument = document.getElementById("fileElm").value;
      let validateUploadedDocument = uploadedDocument.length === 0;
      // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVE A CABO EL REQUEST
      if (validateUploadedDocument) {
        alerts.showNotification(
          "top",
          "right",
          "Asegúrate de haber seleccionado un archivo antes de guardar.",
          "warning"
        );
        return;
      }
      const archivo = $("#fileElm")[0].files[0];
      const tipoDocumento = parseInt($("#tipoDocumento").val());
      let extensionDeDocumento = archivo.name.split(".").pop();
      let extensionesPermitidas = getExtensionPorTipoDocumento(tipoDocumento);
      let statusValidateExtension = validateExtension(
        extensionDeDocumento,
        extensionesPermitidas
      );
      if (!statusValidateExtension) {
        // MJ: ARCHIVO VÁLIDO PARA CARGAR
        alerts.showNotification(
          "top",
          "right",
          `El archivo que has intentado cargar con la extensión <b>${extensionDeDocumento}</b> no es válido. ` +
            `Recuerda seleccionar un archivo ${extensionesPermitidas}`,
          "warning"
        );
        return;
      }
      const nombreDocumento = $("#nombreDocumento").val();
      let data = new FormData();
      data.append("idLote", $("#idLoteValue").val());
      data.append("idDocumento", $("#idDocumento").val());
      data.append("tipoDocumento", tipoDocumento);
      data.append("uploadedDocument", archivo);
      data.append("accion", accion);
      data.append("tituloDocumento", $("#tituloDocumento").val());
      $.ajax({
        url: `${general_base_url}Postventa/subirArchivo`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        beforeSend: function () {
          $("#uploadFileButton").prop("disabled", true);
        },
        success: function (response) {
          const res = JSON.parse(response);
          if (res.code === 200) {
            alerts.showNotification(
              "top",
              "right",
              `El documento ${nombreDocumento} se ha cargado con éxito.`,
              "success"
            );
            $('#tabla_estatus3').DataTable().ajax.reload();
            $("#addDeleteFileModal").modal("hide");
          }
          if (res.code === 400) {
            alerts.showNotification("top", "right", res.message, "warning");
          }
          if (res.code === 500) {
            alerts.showNotification(
              "top",
              "right",
              "Oops, algo salió mal.",
              "warning"
            );
          }
        },
        error: function () {
          $("#sendRequestButton").prop("disabled", false);
          alerts.showNotification(
            "top",
            "right",
            "Oops, algo salió mal.",
            "danger"
          );
        },
      });
    }else {
        // VA A ELIMINAR
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
          type: "POST",
          success: function (response) {
            const res = JSON.parse(response);
            $("#sendRequestButton").prop("disabled", false);
            if (res.code === 200) {
              alerts.showNotification(
                "top",
                "right",
                `El documento ${nombreDocumento} se ha eliminado con éxito.`,
                "success"
              );
              $('#tabla_estatus3').DataTable().ajax.reload();
              $("#addDeleteFileModal").modal("hide");
            }
            if (res.code === 400) {
              alerts.showNotification("top", "right", res.message, "warning");
            }
            if (res.code === 500) {
              alerts.showNotification(
                "top",
                "right",
                "Oops, algo salió mal.",
                "warning"
              );
            }
          },
          error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification(
              "top",
              "right",
              "Oops, algo salió mal.",
              "danger"
            );
          },
        });
      }
});

const TipoDoc = {
    CONTRATO: 8,
    CORRIDA: 7,
    CARTA_DOMICILIO: 29,
    CONTRATO_FIRMADO: 30,
    DS_NEW: 'ds_new',
    DS_OLD: 'ds_old',
    EVIDENCIA_MKTD_OLD: 66, // EXISTE LA RAMA CON LA EVIDENCIA DE MKTD (OLD)
    AUTORIZACIONES: 'autorizacion',
    PROSPECTO: 'prospecto',
    APOSTILLDO_CONTRATO: 31,
    CARTA: 32,
    RESCISION_CONTRATO: 33,
    CARTA_PODER: 34,
    RESCISION_CONTRATO_FIRMADO: 35,
    DOCUMENTO_REESTRUCTURA: 36,
    DOCUMENTO_REESTRUCTURA_FIRMADO: 37,
    CONSTANCIA_SITUACION_FISCAL: 38,
    CORRIDA_ANTERIOR: 39,
    CONTRATO_ANTERIOR: 40,
    COMPLEMENTO_ENGANCHE: 45,
    CONTRATO_ELEGIDO_FIRMA_CLIENTE: 41,
    CONTRATO_1_CANCELADO: 42,
    CONTRATO_2_CANCELADO: 43,
    CONTRATO_REUBICACION_FIRMADO: 44,
    AUTORIZACIONES_PARTICULARES: 50,
  };

/**
 * @param {number} tipoDocumento
 * @returns {string}
 */

function getExtensionPorTipoDocumento(tipoDocumento) {
    if (tipoDocumento === TipoDoc.CORRIDA) {
      return "xlsx";
    }
    if (
      tipoDocumento === TipoDoc.CONTRATO ||
      tipoDocumento === TipoDoc.CONTRATO_FIRMADO
    ) {
      return "pdf";
    }
    return "jpg, jpeg, png, pdf";
  }

/**
 * Función para crear el botón a partir del tipo de acción
 *
 * @param {number} type
 * @param {any} data
 * @returns {string}
 */


$(document).on("click", ".verDocumento", function () {
   
    const $itself = $(this);

    var expediente = $itself.attr("data-expediente");
    var cadenaSinEspacios = expediente.replace(/\s/g, '');

    let pathUrl = `${general_base_url}static/documentos/cliente/expediente/${cadenaSinEspacios}`;
    console.log(pathUrl);

    if (screen.width > 480 && screen.width < 800) {
      window.location.href = `${pathUrl}`;
    } else {
      Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${pathUrl}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo:  ${cadenaSinEspacios}  `,
        width: 985,
        height: 660,
      });
    }
  });

//cargar documentos
function crearBotonAccion(type, data) {
    //console.log(data);
    const [
      buttonTitulo,
      buttonEstatus,
      buttonClassColor,
      buttonClassAccion,
      buttonTipoAccion,
      buttonIcono,
    ] = getAtributos(type);
    const d = new Date();
    const dateStr = [d.getMonth() + 1, d.getDate(), d.getFullYear()].join("-");

    const tituloDocumento =
    `${data.nombreResidencial}_${data.nombre}_${data.idLote}_${
      data.id_cliente
    }` + `_TDOC${data.tipo_doc}${data.movimiento}_${dateStr}`;

    return `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${
      data.expediente
    }" data-accion="${buttonTipoAccion}" data-tipoDocumento="${
      data.tipo_doc
    }" ${buttonEstatus} data-toggle="tooltip" data-placement="top" data-nombre="${
      data.movimiento
    }" data-idDocumento="${data.idDocumento}" data-idLote="${
      data.idLote
    }" data-tituloDocumento="${tituloDocumento}" data-idCliente="${
      data.idCliente ?? data.id_cliente
    }" data-lp="${data.lugar_prospeccion}" data-idProspeccion="${
      data.id_prospecto
    }"><i class="${buttonIcono}"></i></button>`;
  }
  
  /**
   * Función para obtener los atributos del botón de acción de la tabla
   *
   * @param {number} type
   * @returns {string[]}
   */
  function getAtributos(type) {
    let buttonTitulo = "";
    let buttonEstatus = "";
    let buttonClassColor = "";
    let buttonClassAccion = "";
    let buttonIcono = "";
    let buttonTipoAccion = "";
    if (type === AccionDoc.DOC_NO_CARGADO) {
      buttonTitulo = "DOCUMENTO NO CARGADO";
      buttonEstatus = "disabled";
      buttonClassColor = "btn-data btn-orangeYellow";
      buttonClassAccion = "";
      buttonIcono = "fas fa-file";
      buttonTipoAccion = "";
    }
    if (type === AccionDoc.DOC_CARGADO) {
      buttonTitulo = "VER DOCUMENTO";
      buttonEstatus = "";
      buttonClassColor = "btn-data btn-blueMaderas";
      buttonClassAccion = "verDocumento";
      buttonIcono = "fas fa-eye";
      buttonTipoAccion = "3";
    }
    if (type === AccionDoc.SUBIR_DOC) {
      buttonTitulo = "SUBIR DOCUMENTO";
      buttonEstatus = "";
      buttonClassColor = "btn-data btn-green";
      buttonClassAccion = "addRemoveFile";
      buttonIcono = "fas fa-upload";
      buttonTipoAccion = "1";
    }
    if (type === AccionDoc.ELIMINAR_DOC) {
      buttonTitulo = "ELIMINAR DOCUMENTO";
      buttonEstatus = "";
      buttonClassColor = "btn-data btn-warning";
      buttonClassAccion = "addRemoveFile";
      buttonIcono = "fas fa-trash";
      buttonTipoAccion = "2";
    }
    
    return [
      buttonTitulo,
      buttonEstatus,
      buttonClassColor,
      buttonClassAccion,
      buttonTipoAccion,
      buttonIcono,
    ];
  }