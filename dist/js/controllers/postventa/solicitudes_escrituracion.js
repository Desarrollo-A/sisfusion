
let headersTable = ['ID SOLICITUD','PROYECTO','LOTE','CLIENTE','VALOR DE OPEACIÓN','FECHA CREACIÓN','ESTATUS','ÁREA','ASIGANADA A','CREADA POR','COMENTARIOS','OBSERVACIONES','ACCIONES'];
$('#escrituracion-datatable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    let width = i == 0 || i == 1 || i == 7 || i == 4 || i == 10 || i==2 || i == 5 || i == 8 ? '' : '';     
    $(this).html(`<input class="${width}" id="head_${i}" data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${headersTable[i]}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#escrituracion-datatable').DataTable().column(i).search() !== this.value ) {
            $('#escrituracion-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

$("#carga-datatable thead tr:eq(0) th").each(function (i) {
  var title = $(this).text();
  $(this).html(`<input  placeholder="${title}" data-toggle="tooltip" data-placement="top" title="${title}"/>`);
  $("input", this).on("keyup change", function () {
    if ($("#carga-datatable").DataTable().column(i).search() !== this.value) {
      $("#carga-datatable").DataTable().column(i).search(this.value).draw();
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
});
$("#pausadas_tabla thead tr:eq(0) th").each(function (i) {
  var title = $(this).text();
  $(this).html(`<input  placeholder="${title}" data-toggle="tooltip" data-placement="top" title="${title}"/>`);
  $("input", this).on("keyup change", function () {
    if ($("#pausadas_tabla").DataTable().column(i).search() !== this.value) {
      $("#pausadas_tabla").DataTable().column(i).search(this.value).draw();
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
});

$("#notas-datatable thead tr:eq(0) th").each(function (i) {
  var title = $(this).text();
  $(this).html('<input class="textoshead"  placeholder="' + title + '"/>');
  $("input", this).on("keyup change", function () {
    if ($("#notas-datatable").DataTable().column(i).search() !== this.value) {
      $("#notas-datatable").DataTable().column(i).search(this.value).draw();
    }
  });
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

sp2 = {
  initFormExtendedDatetimepickers: function () {
    $(".datepicker2").datetimepicker({
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
      minDate: new Date(),
    });
  },
};

var arrayEstatusLote = [];
$(document).ready(function () {
  sp.initFormExtendedDatetimepickers();
  sp2.initFormExtendedDatetimepickers();
  $(".datepicker").datetimepicker({ locale: "es" });
  getEstatusEscrituracion();
  setInitialValues();
  $(document).on(
    "fileselect",
    ".btn-file :file",
    function (event, numFiles, label) {
      var input = $(this).closest(".input-group").find(":text"),
        log = numFiles > 1 ? numFiles + " files selected" : label;
      if (input.length) {
        input.val(log);
      } else {
        if (log) alert(log);
      }
    }
  );
  $(document).on("change", ".btn-file :file", function () {
    var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, "/").replace(/.*\//, "");
    input.trigger("fileselect", [numFiles, label]);
  });
  getRejectionReasons(2); // MJ: SE MANDAN TRAER LOS MOTIVOS DE RECHAZO PARA EL ÁRBOL DE DOCUMENTOS DE ESCRUTURACIÓN
  $.post(`getTipoContratoAnt`, function(data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#tipoContratoAnt").append($('<option>').val(id).text(name));
    }
    if (len <= 0) {
        $("#tipoContratoAnt").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    }
    $("#tipoContratoAnt").selectpicker('refresh');
  }, 'json'); 
  $.post(
    "getEstatusPago",
    function (data) {
        arrayEstatusLote = data;
      var len = data.length;
    },
    "json"
  );
});

$(document).on("change", "#cliente", function () {
  if ($(this).val() == "uno") {
    $(".ifClient").show();
  } else {
    $(".ifClient").hide();
  }
});

$(document).on("change", "#cliente2", function () {
  if ($(this).val() == "uno") {
    $("#ifClient2").show();
  } else {
    $("#ifClient2").hide();
  }
});

$(document).on("change", "#notaria", function () {
  $("#spiner-loader").removeClass("hide");
  $.post(
    "getNotaria",
    { idNotaria: $(this).val() },
    function (data) {
      $("#spiner-loader").addClass("hide");
      $("#information")
        .html(`<p><b>Nombre de la notaria:</b> ${data[0].nombre_notaria}</p>
        <p><b>Nombre del notario:</b> ${data[0].nombre_notario}</p>
        <p><b>Direccíon de la notaria:</b> ${data[0].direccion}</p>
        <p><b>Correo de la notaria:</b> ${data[0].correo}</p>`);
    },
    "json"
  );
});

$(document).on("change", "#valuador", function () {
  $("#spiner-loader").removeClass("hide");
  $.post(
    "getValuador",
    { idValuador: $(this).val() },
    function (data) {
      $("#spiner-loader").addClass("hide");
      $("#information2")
        .html(`<p><b>Nombre del perito:</b> ${data[0].perito}</p>
        <p><b>Direccíon del valuador:</b> ${data[0].direccion}</p>
        <p><b>Correo del valuador:</b> ${data[0].correo}</p>
        <p><b>Telefono del valuador:</b> ${data[0].telefono}</p>`);
    },
    "json"
  );
});

$(document).on("submit", "#rejectForm", function (e) {
  e.preventDefault();
  let id_solicitud = $("#id_solicitud2").val();
  let motivos_rechazo = $("#motivos_rechazo").val();
  let area_rechazo = $("#area_rechazo").val();
  if (area_rechazo != "") {
    let datos = area_rechazo.split(",");
    area_rechazo = datos[0];
  }
  let estatus = $("#estatus").val();
  let type = 3;
  changeStatus(id_solicitud, 3, motivos_rechazo, type, 0, area_rechazo);
});

$(document).on("submit", "#approveForm", function (e) {
  e.preventDefault();
  let id_solicitud = $("#id_solicitud").val();
  let observations = $("#observations").val();
  let id_estatus = $("#status").val();
  let type = $("#type").val(); 
  if (id_estatus == 30) {
    changeStatus(id_solicitud, 1, observations, 5, 0, 29);
  } else {
    changeStatus(id_solicitud, 1, observations, type);
  }
});

$(document).on("click", "#submitUpload", function (e) {
  e.preventDefault();
});

$(document).on("click", "#searchByDateRange", function () {
    let finalBeginDate = $("#beginDate").val();
    let finalEndDate = $("#endDate").val();
    let fDate = formatDate(finalBeginDate);
    let fEDate = formatDate(finalEndDate);
    arrayTables[0].data = {
        "beginDate": fDate,
        "endDate": fEDate,
        "estatus":$('#estatusE').val(),
        "tipo_tabla":arrayTables[0].numTable 
    };
        crearTablas(arrayTables[0],arrayTables[0].numTable);    
});
$(document).on("click", "#createDate", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  let idNotaria = $(this).attr("data-idNotaria");
  let signDate = getSignDate(idNotaria);
  $("#signDate").val(signDate);
  $("#idSolicitudFecha").val($(this).attr("data-idSolicitud"));
  $("#type").val(data.id_estatus == 30 ? 5 : 1);
  $("#dateModal").modal();
});
$(document).on("click", "#newDate", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  let idNotaria = $(this).attr("data-idNotaria");
  let signDate = getSignDate(idNotaria);
  $("#signDate").val(signDate);
  $("#idSolicitudFecha").val($(this).attr("data-idSolicitud"));
  $("#type").val(3);
  $("#dateModal").modal();
});

$(document).on("click", "#searchByDateTest", function (){
    let finalBeginDate = $("#startDate").val();
    let finalEndDate = $("#finalDate").val();
    let fDate = formatDate(finalBeginDate);
    let fEDate = formatDate(finalEndDate);
    arrayTables[1].data = {
        "beginDate": fDate,
        "endDate": fEDate,
        "estatus":0,
        "tipo_tabla":arrayTables[1].numTable 
    };
        crearTablas(arrayTables[1],arrayTables[1].numTable);
})

$(document).on("click", "#dateSubmit", function () {
  let signDate = $("#signDate").val();
  let idSolicitud = $("#idSolicitudFecha").val();
  let signDateFinal = formatDate2(signDate);
  let type = $("#type").val();
  $("#spiner-loader").removeClass("hide");
  $.post(
    "saveDate",
    {
      signDate: signDateFinal,
      idSolicitud: idSolicitud,
    },
    function (data) {
      $("#spiner-loader").addClass("hide");
      $("#dateModal").modal("hide");
      if (data == true) {
        if (type == 5) {
          changeStatus(
            idSolicitud,
            2,
            `Nueva fecha para firma: ${signDateFinal}`,
            type,
            31
          );
        } else {
          changeStatus(
            idSolicitud,
            2,
            `Nueva fecha para firma: ${signDateFinal}`,
            type
          );
        }
      }
    },
    "json"
  );
});

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

$(document).on("click", "#sendRequestButton", function (e) {
    var info = escrituracionTable.page.info();
    e.preventDefault();
    let action = $("#action").val();
    let id_estatus =  $('#id_estatus').val();
    let documento_validar =  $('#documento_validar').val();
    let sendRequestPermission = 0;
    if (action == 1) { // UPLOAD FILE
        let uploadedDocument = $("#uploadedDocument")[0].files[0];
        let allowedExtensions = /(\.xls|\.xlsx|\.pdf|\.jpg|\.jpeg|\.png|\.doc|\.docx|\.csv|\.rar|\.zip)$/i;
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
            alerts.showNotification("top", "right", "Asegúrese de haber seleccionado al menos un motivo de rechazo", "warning");
        } else sendRequestPermission = 1;
    }

    if (sendRequestPermission == 1) {
        let idSolicitud = $("#idSolicitud").val();
        let data = new FormData();
        let details = $("#details").val();
        data.append("idSolicitud", idSolicitud);
        data.append("idDocumento", $("#idDocumento").val());
        data.append("documentType", $("#documentType").val());
        if($("#documentType").val() == 12){
            data.append("presupuestoType", $("#presupuestoType").val());
            data.append("idPresupuesto", $("#idPresupuesto").val());
            data.append("idNxS", $("#idNxS").val());
        }
        data.append("uploadedDocument", $("#uploadedDocument")[0].files[0]);
        data.append("rejectionReasons", $("#rejectionReasons").val());
        data.append("action", action);
        let documentName = $("#docName").val();
        $('#uploadFileButton').prop('disabled', true);
        $('#spiner-loader').removeClass('hide');
        let contador = action == 1 ? 1 : action == 2 ? 2 : 0;
if(id_estatus == 19 || id_estatus == 22 ){
    var indexidDocumentos = documentosObligatorios.findIndex(e => e.idDocumento == $("#idDocumento").val());
    console.log(indexidDocumentos)
    if(indexidDocumentos >= 0){
        documentosObligatorios[indexidDocumentos].cargado = action == 1 ? 1 : 0;
    }
}
if(id_estatus == 20 || id_estatus == 25 || id_estatus == 12){
    var indexidDocumentos = documentosObligatorios.findIndex(e => e.idDocumento == $("#idDocumento").val());
    console.log(indexidDocumentos)
    if(indexidDocumentos >= 0){
        documentosObligatorios[indexidDocumentos].validado = action == 3 ? 1 : 2;
    }
}
if(id_estatus == 12){
    var indexidDocumentos = documentosObligatorios.findIndex(e => e.idDocumento == $("#idDocumento").val());
    console.log(indexidDocumentos)
    if(indexidDocumentos >= 0){
        documentosObligatorios[indexidDocumentos].validado = action == 3 ? 1 : 2;
    }
}
if(action == 1){
    if($("#uploadedDocument")[0].files[0].size > 50000000){
      alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor, ya que supera los 50MB", "warning");
      return false;
    }
}
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
                    alerts.showNotification("top", "right", action == 1 ? "El documento se ha cargado con éxito." : action == 2 ? "El documento se ha eliminado con éxito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento." : "El documento ha sido validado correctamente.", "success");
                    if(details == 1){
                        var tr = $(`#trees${idSolicitud}`).closest('tr');
                        var row = escrituracionTable.row(tr);
                        createDocRow(row, tr, $(`#trees${idSolicitud}`));
                        if((id_estatus == 19 || id_estatus == 22) && (action == 1 || action == 2)){
                            var index = documentosObligatorios.findIndex(e => e.cargado == 0);
                            // SI LA ACCIÓN ES CARGA Y NO TODOS LOS ARCHIVOS ESTAN CARGADOS RECARGAR
                            //SI LA ACCIÓN ES DELETE Y FALTA UN ARCHIVO AL MENOS RECARGAR
                            if((index < 0 && action == 1) || (action == 2 && index >= 0 )){
                                escrituracionTable.ajax.reload(null,false);
                                createDocRow(integracionExpediente.row,integracionExpediente.tr,integracionExpediente.this);
                            }
                        }
                        if((id_estatus == 20 || id_estatus == 25 || id_estatus == 12) && (action == 3 || action == 4)){
                            var index2 = documentosObligatorios.findIndex(e => e.validado == 2);
                            var indexNull = documentosObligatorios.findIndex(e => e.validado == null);
                            // SI LA ACCIÓN ES CARGA Y NO TODOS LOS ARCHIVOS ESTAN CARGADOS RECARGAR
                            //SI LA ACCIÓN ES DELETE Y FALTA UN ARCHIVO AL MENOS RECARGAR
                            if(((index2 < 0 && indexNull < 0) && action == 3) || (action == 4 && index2 >= 0 )){
                                escrituracionTable.ajax.reload(null,false);
                                createDocRow(integracionExpediente.row,integracionExpediente.tr,integracionExpediente.this);
                            }
                        }
                        if((id_estatus == 26 || id_estatus == 30 || id_estatus == 31) ){
                            escrituracionTable.ajax.reload(null,false);
                            createDocRow(integracionExpediente.row,integracionExpediente.tr,integracionExpediente.this);
                        }
                    }else if(details == 2){
                        let idNxS = $("#idNxS").val();
                        buildUploadCards(idNxS);
                    }else if(details == 3){
                        var tr = $(`#docs${idSolicitud}`).closest('tr');
                        var row = escrituracionTable.row(tr);
                        createDocRowOtros(row, tr, $(`#docs${idSolicitud}`),contador);
                    }else if(details == 4){
                        var tr = $(`#pago${idSolicitud}`).closest('tr');
                        var row = escrituracionTable.row(tr);
                        createDocRowPago(row, tr, $(`#pago${idSolicitud}`));
                    }
                    else{
                        escrituracionTable.ajax.reload(null,false);
                        escrituracionTableTest.ajax.reload(null,false);
                    }
                    $("#uploadModal").modal("hide");
                    $('#spiner-loader').addClass('hide');
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor, ya que supera los 50MB", "warning");
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
  let idSolicitud = $("#id_solicitud3").val();
  let data = new FormData($(this)[0]);
  data.append(
    "nombreT",
    $("#nombreT").val() == "" ? null : $("#nombreT").val()
  );
  data.append(
    "fechaCA2",
    $("#fechaCA").val() == "" ? null : formatDate($("#fechaCA").val())
  );
  data.append(
    "nombre_notaria",
    $("#nombre_notaria").val() == "" ? null : $("#nombre_notaria").val()
  );
  data.append(
    "nombre_notario",
    $("#nombre_notario").val() == "" ? null : $("#nombre_notario").val()
  );
  data.append(
    "direccion",
    $("#direccion").val() == "" ? null : $("#direccion").val()
  );
  data.append("correo", $("#correo").val() == "" ? null : $("#correo").val());
  data.append(
    "telefono",
    $("#telefono").val() == "" ? null : $("#telefono").val()
  );
  data.append("idSolicitud", idSolicitud);
  $("#spiner-loader").removeClass("hide");
  $.ajax({
    url: "savePresupuesto",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (response) {
      if (response == 1) {
        $("#presupuestoModal").modal("hide");
        clearCopropietario();
        var win = window.open(
          "pdfPresupuesto/" + $("#id_solicitud3").val(),
          "_blank"
        );
        $("#spiner-loader").addClass("hide");
        win.onload = function () {
          $("#formPresupuesto")[0].reset();
          escrituracionTable.ajax.reload(null, false);
        };
      }
    },
    error: function () {
      alerts.showNotification(
        "top",
        "right",
        "Oops, algo salió mal.",
        "danger"
      );
      $("#spiner-loader").addClass("hide");
    },
  });
});

$(document).on("click", "#request", function () {
  let num_table = $(this).attr("data-num-table");
  var data =
    num_table == 0
      ? escrituracionTable.row($(this).parents("tr")).data()
      : num_table == 1
      ? escrituracionTableTest.row($(this).parents("tr")).data()
      : escrituracionPausadas.row($(this).parents("tr")).data();
  document.getElementById("actividad_siguiente").innerHTML = "";
  $("#id_solicitud").val(data.id_solicitud);
  $("#status").val(data.id_estatus);
  $("#observations").val("");
  let actividad_next = $(this).attr("data-siguiente_actividad");
  actividad_next = actividad_next.split("-");
  document.getElementById("actividad_siguiente").innerHTML =
    '<br><p style="color:#154360;">Estatus siguiente: <b>' +
    actividad_next[0] +
    " - " +
    actividad_next[1] +
    "</b> <br> Área(s) siguiente(s): <b>" +
    (data.id_estatus == 1
      ? "Administración y Comité Técnico"
      : actividad_next[2]) +
    "</b></p>";
  let type = $(this).attr("data-type");
  $("#type").val(data.id_estatus == 1 ? 2 : data.id_estatus == 12 ? 4 : 1);
  $("#approveModal").modal();
});

$(document).on("click", "#pausarSolicitud", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  document.getElementById("labelmodal").innerHTML = "Pausar solicitud";
  $("#comentarioPausa").attr("placeholder", "Motivo de la pausa");
  $("#id_solicitud").val(data.id_solicitud);
  $("#accion").val(1);
  $("#modalPausar").modal();
});

$(document).on("click", "#borrarSolicitud", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  document.getElementById("labelmodal").innerHTML = "Borrar solicitud";
  $("#comentarioPausa").attr(
    "placeholder",
    "Descripción del por que se elimina la solicitud"
  );
  $("#id_solicitud").val(data.id_solicitud);
  $('#id_est').val($(this).attr("data-idEstatus"));
  $("#banderaCliente").val($(this).attr("data-banderaEscrituracion"));
  $("#idCliente").val($(this).attr("data-idCliente"));
  $("#idLote").val($(this).attr("data-idLote"));
  $("#accion").val(2);
  $("#modalPausar").modal();
});

$(document).on("submit", "#formPausar", function (e) {
  e.preventDefault();
  let idSolicitud = $("#id_solicitud").val();
  let data = new FormData($(this)[0]);
  let accion = $("#accion").val();
  data.append("idSolicitud", idSolicitud);
  $("#spiner-loader").removeClass("hide");
  $.ajax({
    url: accion == 1 ? "pausarSolicitud" : "borrarSolicitud",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (response) {
      if (response == 1) {
        document.getElementById("formPausar").reset();
        $("#modalPausar").modal("hide");
        $("#spiner-loader").addClass("hide");
        escrituracionTable.ajax.reload(null, false);
        escrituracionPausadas.ajax.reload(null, false);
      }
    },
    error: function () {
      alerts.showNotification(
        "top",
        "right",
        "Oops, algo salió mal.",
        "danger"
      );
      $("#spiner-loader").addClass("hide");
    },
  });
});

$(document).on("click", ".comentariosModel", function (e) {
  e.preventDefault();
  e.stopImmediatePropagation();
  id_solicitud = $(this).attr("data-idSolicitud");
  lote = $(this).attr("data-lotes");
  $("#comentariosModal").modal();
  $("#titulo_comentarios").append(
    "<h4>Movimientos de Lote: <b>" + lote + "</b></h4>"
  );
  $.getJSON("getDetalleNota/" + id_solicitud).done(function (data) {
    if (data != "") {
      $.each(data, function (i, v) {
        let fecha_creacion = moment(v.fecha_creacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
        $("#comments-list-asimilados").append(
          `<div class="col-lg-12" style="padding-left:40px;"><li><a style="color:${v.color};">${v.nombre}</a>&nbsp;<a style="color:${v.color}" class="float-right"><b>${fecha_creacion}</b></a><p>${v.descripcion}</p></li></div>`
        );
      });
    } else {
      $("#comments-list-asimilados").append(
        `<div class="col-lg-12"><p><i style="color:39A1C0;">No se han encontrado notas</i></p></div>`
      );
    }
  });
});

function cleanCommentsAsimilados() {
  var myCommentsList = document.getElementById("comments-list-asimilados");
  var myCommentsLote = document.getElementById("titulo_comentarios");
  myCommentsList.innerHTML = "";
  myCommentsLote.innerHTML = "";
}

$("#observations").keydown(function () {
  document.getElementById("text-observations").innerHTML = "";
  var max = 250;
  var len = $(this).val().length;
  if (len >= max) {
    document.getElementById("text-observations").innerHTML =
      "Limite de caracteres superado";
    $("#ApproveF").addClass("disabled");
    document.getElementById("ApproveF").disabled = true;
  } else {
    document.getElementById("text-observations").innerHTML = "";
    var ch = max - len;
    $("#ApproveF").removeClass("disabled");
    document.getElementById("ApproveF").disabled = false;
  }
});

$(document).on("click", "#reject", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  $("#id_solicitud2").val(data.id_solicitud);
  $("#status2").val(data.id_estatus);
  $("#estatus").val(data.idEstatus);
  getMotivosRechazos(
    data.tipo_documento == null || data.tipo_documento == 0
      ? 0
      : data.tipo_documento,
    data.id_estatus
  );
  $("#rejectModal").modal();
});

$(document).on("click", "#presupuesto", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  let area_actual = $(this).attr("data-area-actual");

  if (
    area_actual == 55 &&
    (data.id_estatus == 9 ||
      data.id_estatus == 11 ||
      data.id_estatus == 36 ||
      data.id_estatus == 59)
  ) {
    document.getElementById("cliente").disabled = true;
    document.getElementById("liquidado").disabled = true;
    document.getElementById("tipoContratoAnt").disabled = true;
    document.getElementById("nombreT").disabled = true;
    document.getElementById("fechaCA").disabled = false;
    document.getElementById("rfcDatos").disabled = true;
    document.getElementById("aportaciones").disabled = true;
    document.getElementById("descuentos").disabled = true;
    document.getElementById("motivo").disabled = true;
  }
  getBudgetInfo(data.id_solicitud);
  $("#id_solicitud3").val(data.id_solicitud);
  $("#presupuestoModal").modal();
});

$(document).on("click", "#checkPresupuesto", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  checkBudgetInfo(data.idSolicitud);
  $("#id_solicitud4").val(data.idSolicitud);
  $("#checkPresupuestoModal").modal();
});

$(document).on("click", "#sendMail", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  let action = $("#sendMail").attr("data-action");
  switch (action) {
    case "1":
      getNotarias();
      getValuadores();
      $("#idSolicitud").val(data.idSolicitud);
      $("#action").val(action);
      $("#information").html("");
      $("#information2").html("");
      $("#notarias").modal();
      break;
    case "2":
      email(data.idSolicitud, action);
      break;
    case "3":
      email(data.idSolicitud, action);
      break;
    case "4":
      email(data.idSolicitud, action);
      break;
    case "5":
      email(data.idSolicitud, action);
      break;
  }
});

$(document).on("click", "#tree", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  getDocumentsClient(data.idSolicitud, data.idEstatus);
  $("#documentTree").modal();
});

$(document).on("click", "#asignarNotariaButton", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  let informacion_lote = $(this).attr("data-lote");
  let solicitud = $(this).attr("data-solicitud");
  $("#tipoNotaria").selectpicker("refresh");
  document.getElementById("informacion_lote").innerHTML =
    "Lote: " + informacion_lote;
  $("#id_solicitud").val(solicitud);
  $("#altaNotario").modal();
});

$(document).on("change", "#tipoNotaria", function (e) {
  if ($(this).val()) {
    $("#tipo_notaria").val($(this).val());
    if ($(this).val() == 2) {
      $("#div_notaria").show();
      $("#nombre_notaria").attr("required", true);
      $("#nombre_notario").attr("required", true);
      $("#direccion").attr("required", true);
      $("#correo").attr("required", true);
      $("#telefono").attr("required", true);
    } else {
      $("#div_notaria").hide();
      $("#nombre_notaria").removeAttr("required");
      $("#nombre_notario").removeAttr("required");
      $("#direccion").removeAttr("required");
      $("#correo").removeAttr("required");
      $("#telefono").removeAttr("required");
    }
  }
});

$(document).on("change", "#documents", function () {
  let idDocument = $(this).val();
  displayInput(idDocument);
});

$(document).on("click", "#notariaSubmit", function (e) {
  let idSolicitud = $("#idSolicitud").val();
  let action = $("#action").val();
  let notaria = $("#notaria").val();
  let valuador = $("#valuador").val();
  email(idSolicitud, action, notaria, valuador);
});

$(document).on("click", "#sendRequestButton2", function (e) {
  $("#spiner-loader").removeClass("hide");
  let uploadedDocument = $("#uploadedDocument2")[0].files[0];
  let validateUploadedDocument = uploadedDocument == undefined ? 0 : 1;
  if (validateUploadedDocument == 0)
    alerts.showNotification(
      "top",
      "right",
      "Asegúrese de haber seleccionado un archivo antes de guardar.",
      "warning"
    );
  else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE SÍ HAY ARCHIVO SELECCIONADO

  if (sendRequestPermission == 1) {
    let data = new FormData();
    data.append("idDocumento", $("#uploadedDocument2").attr("data-iddoc"));
    data.append("uploadedDocument2", uploadedDocument);
    $.ajax({
      url: "uploadFile2",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      type: "POST",
      success: function (response) {
        $("#sendRequestButton2").prop("disabled", false);
        if (response == 1) {
          alerts.showNotification(
            "top",
            "right",
            action == 1
              ? "El documento se ha cargado con éxito."
              : action == 2
              ? "El documento se ha eliminado con éxito."
              : action == 4
              ? "Los motivos de rechazo se han asociado de manera exitosa para el documento."
              : "El documento ha sido validado correctamente.",
            "success"
          );
        } else if (response == 0)
          alerts.showNotification(
            "top",
            "right",
            "Oops, algo salió mal.",
            "warning"
          );
        else if (response == 2)
          alerts.showNotification(
            "top",
            "right",
            "No fue posible almacenar el archivo en el servidor.",
            "warning"
          );
        else if (response == 3)
          alerts.showNotification(
            "top",
            "right",
            "El archivo que se intenta subir no cuenta con la extención .xlsx",
            "warning"
          );
        $("#spiner-loader").addClass("hide");
      },
      error: function () {
        $("#sendRequestButton2").prop("disabled", false);
        alerts.showNotification(
          "top",
          "right",
          "Oops, algo salió mal.",
          "danger"
        );
        $("#spiner-loader").addClass("hide");
      },
    });
  }
});

let integracionExpediente = new Object();
$(document).on("click", ".details-control", function () {
  var detailRows = [];
  var tr = $(this).closest("tr");
  var row = escrituracionTable.row(tr);
  var idx = $.inArray(tr.attr("id"), detailRows);
  if (row.child.isShown()) {
    tr.removeClass("details");
    row.child.hide();
    detailRows.splice(idx, 1);
  } else {
    $("#spiner-loader").removeClass("hide");
    tr.addClass("details");
    createDocRow(row, tr, $(this));
    integracionExpediente = {
      row: row,
      tr: tr,
      this: $(this),
    };
    if (idx === -1) {
      detailRows.push(tr.attr("id"));
    }
  }
});

let rowOtros = new Object();

$(document).on("click", ".details-control-otros", function () {
  var detailRows = [];
  var tr = $(this).closest("tr");
  var row = escrituracionTable.row(tr);
  var idx = $.inArray(tr.attr("id"), detailRows);
  if (row.child.isShown()) {
    tr.removeClass("details");
    row.child.hide();
    detailRows.splice(idx, 1);
  } else {
    $("#spiner-loader").removeClass("hide");
    tr.addClass("details");
    rowOtros = {
      row: row,
      tr: tr,
      this: $(this),
    };
    createDocRowOtros(row, tr, $(this));
    if (idx === -1) {
      detailRows.push(tr.attr("id"));
    }
  }
});

$(document).on("click", ".details-control-pago", function () {
  var detailRows = [];
  var tr = $(this).closest("tr");
  var row = escrituracionTable.row(tr);
  var idx = $.inArray(tr.attr("id"), detailRows);
  if (row.child.isShown()) {
    tr.removeClass("details");
    row.child.hide();
    detailRows.splice(idx, 1);
  } else {
    $("#spiner-loader").removeClass("hide");
    tr.addClass("details");
    createDocRowPago(row, tr, $(this));
    if (idx === -1) {
      detailRows.push(tr.attr("id"));
    }
  }
});

$(document).on("click", "#estatusL", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  document.getElementById("informacion_lote_construccion").innerHTML = "";
  document.getElementById("informacion_lote_construccion").innerHTML =
    '<br><p style="color:#154360;">Estatus a Lote: <b>' +
    data.nombreLote +
    "</b></p>";
  $("#id_solicitudEstatus").val(data.id_solicitud);
  let estatus_construccion = $(this).attr("data-estatus-construccion");
  getEstatusConstruccion(estatus_construccion);
  $("#estatusLModal").modal();
});

$(document).on("submit", "#formEstatusLote", function (e) {
  e.preventDefault();
  let id_solicitud = $("#id_solicitudEstatus").val();
  let formData = new FormData($(this)[0]);
  saveEstatusLote(id_solicitud, formData);
});

$(document).on("click", ".treePresupuesto", function () {
  var detailRows = [];
  var tr = $(this).closest("tr");
  var row = escrituracionTable.row(tr);
  var idx = $.inArray(tr.attr("id"), detailRows);
  if (row.child.isShown()) {
    tr.removeClass("details");
    row.child.hide();
    detailRows.splice(idx, 1);
  } else {
    $("#spiner-loader").removeClass("hide");
    tr.addClass("details");
    createRowNotarias(
      row,
      tr,
      $(this),
      row.data().id_solicitud,
      row.data().id_estatus
    );
    if (idx === -1) {
      detailRows.push(tr.attr("id"));
    }
  }
});

$(document).on("click", ".approve", function () {
  let idDocumento = $(this).attr("data-idDocumento");
  let idSolicitud = $(this).attr("data-idSolicitud");
  let idEstatusSolicitud = $(this).attr("data-estatus-solicitud");
  let data = new FormData();
  let details = $(this).attr("data-details");
  data.append("idSolicitud", idSolicitud);
  data.append("idDocumento", idDocumento);
  $.ajax({
    url: "approvePresupuesto",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (response) {
      $("#sendRequestButton").prop("disabled", false);
      if (response == 1) {
        alerts.showNotification(
          "top",
          "right",
          action == 1
            ? "El documento se ha cargado con éxito."
            : action == 2
            ? "El documento se ha eliminado con éxito."
            : action == 4
            ? "Los motivos de rechazo se han asociado de manera exitosa para el documento."
            : "El documento ha sido validado correctamente.",
          "success"
        );
        if (details == 1) {
          var tr = $(`#trees${idSolicitud}`).closest("tr");
          var row = escrituracionTable.row(tr);
          createDocRow(row, tr, $(`#trees${idSolicitud}`));
          if (idEstatusSolicitud == 19 || idEstatusSolicitud == 22) {
            var index = documentosObligatorios.findIndex((e) => e.cargado == 0);
            if (index < 0) {
              escrituracionTable.ajax.reload(null, false);
            }
          }
        } else {
          escrituracionTable.ajax.reload(null, false);
        }
      } else if (response == 0)
        alerts.showNotification(
          "top",
          "right",
          "Oops, algo salió mal.",
          "warning"
        );
      else if (response == 2)
        alerts.showNotification(
          "top",
          "right",
          "No fue posible almacenar el archivo en el servidor.",
          "warning"
        );
      else if (response == 3)
        alerts.showNotification(
          "top",
          "right",
          "El archivo que se intenta subir no cuenta con la extención .xlsx",
          "warning"
        );
      $("#spiner-loader").addClass("hide");
    },
    error: function () {
      $("#sendRequestButton").prop("disabled", false);
      alerts.showNotification(
        "top",
        "right",
        "Oops, algo salió mal.",
        "danger"
      );
      $("#spiner-loader").addClass("hide");
    },
  });
});

$(document).on("change", ".selectpicker.notaria-select", async function (e) {
  if ($(this).val()) {
    let descripcion = {};
    let iconSave = $(this).parent().next().find(".icon-save");
    iconSave.removeClass("inactive");
    iconSave.addClass("active");
    descripcion = await getDescriptionNotaria($(this).val());
    $(this).parent().parent().next().text(descripcion.direccion);
  }
});

$(document).on("click", ".modalPresupuestos", function () {
  let idNxS = $(this).attr("data-idNxS");
  $("#idNxS").val(idNxS);
  buildUploadCards(idNxS);
  $("#loadPresupuestos").modal();
  $('[data-toggle="tooltip"]').tooltip();
});

$(document).on('click', '.saveNotaria', function() {
    let tr = $(this).closest('tr');
    let select = tr.find('select').val();
    if (tr.find('select').val()) {
        saveNotaria($(this).attr('data-idSolicitud'), select, $(this));
    }else{
        alerts.showNotification("top", "right", "Debe seleccionar una notaría", "warning");
    }
});

$(document).on('click', '.modalCopiaCertificada', function(){
    let idNxS = $(this).attr('data-idNxS2');
    $("#idNxS2").val(idNxS);
    buildUploadCards(idNxS);
    $('#loadPresupuestos').modal();
    $('[data-toggle="tooltip"]').tooltip();
});

function crearTablas(datosTablas,numTabla = ''){
    $(`#${datosTablas.nombreTabla}`).DataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        fixedHeader: true,
        scrollX: true,
        bAutoWidth: true,
        pagingType: "full_numbers",
        language: {
            url: "../static/spanishLoader_v2.json",
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
                    return d.id_solicitud;
                }
            },
            {   
                data: function (d) {
                    return d.nombreResidencial
                }
            },
            {
                data: function (d) {
                    return d.nombreLote
                }
            },
            {
                data: function (d) {
                    return d.cliente;
                }
            },
            {
                data: function (d) {
                    return  formatMoney(d.valor_contrato);
                }
            },
            {
                data: function (d) {
                  let fecha_inicio = moment(d.fecha_creacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
                    return fecha_inicio;
                }
            },
            {
                data: function (d) {
                    return `<center><span><b> ${d.nombre_estatus}</b></span><center>`;   
                }
            },
            {
                data: function (d) {
                    return `<center>${d.area}</center>`;
                }
            },
            {
                data: function (d) {
                    return `<center>${d.asignada_a}</center>`;
                }
            },
            {
              data: function (d) {
                  return `<center>${d.creado}</center>`;
              }
          },
            {
                data: function (d) {
                    if(d.id_estatus == 27 || d.id_estatus == 28 || d.id_estatus == 30 || d.id_estatus == 31){
                        return '<b>Fecha firma: '+d.fecha_firma.split('.')[0]+'</b>';
                    }else{
                        return d.ultimo_comentario;
                    }
                }
            },
            {
                data: function (d) {
                    return  `<span class="label lbl-sky">${d.rechazo}</span><span class="label lbl-sky" >${d.vencimiento}</span>`;
                }
            },
            {   
                data: function (d) {
                    var group_buttons = '';    //variable para botones que se muestran en el datatable 
                    let btnsAdicionales = ''; //variable para botones que se envian a la funcion de permisos
                    let permiso;
                    let bandera_request=0;
                    let bandera_reject = 0;
                    let banderaAdmin=0;
                    let numTable =0;
                    var datosEstatus = {
                        area_sig: d.area_sig,
                        nombre_estatus_siguiente: d.nombre_estatus_siguiente,
                    }; 
                    switch (d.id_estatus){
                            case 1: 
                              if(d.creado_por == idUser){
                                group_buttons +=`<button id="borrarSolicitud" data-idLote="${d.id_lote}" data-idCliente="${d.id_cliente}" data-banderaEscrituracion="${d.banderaEscrituracion}" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Borrar solicitud"><i class="fa fa-trash"></i></button>`;
                                bandera_request = userType == 55 ? 1 : 0;
                              }
                            break;
                            case 2:
                                //ADMINISTRACIÓN Y COMITÉ TÉCNICO AUN NO DAN SU ESTATUS
                                if (userType == 11 || userType == 56) { 
                                    group_buttons += userType == 56 ?
                                      `<button id="estatusL" data-estatus-construccion="${d.estatus_construccion}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Estatus del lote"><i class="fa fa-pencil-square-o"></i></button>` :
                                      `<button id="informacion" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información Cliente"><i class="fa fa-file"></i></button>`;
                                    bandera_request = userType == 11 && (d.cliente_anterior != null && d.cliente_anterior != '' ) ? 1 
                                    : userType == 56 && (d.estatus_construccion != 0 && d.estatus_construccion != null) ? 1  : 0;
                                    }
                                    bandera_reject = userType == 11 ? 1 : 0;
                            break;
                            case 58:
                              if(d.creado_por == idUser){
                                  bandera_request = userType == 55 ? 1 : 0;
                                  if (userType == 55) { 
                                      group_buttons +=`<button id="btnValorOper" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Valor de operación"><i class="fa fa-file"></i></button>`;
                                  }
                              }
                            break;
                            case 3:
                                //ADMINISTRACIÓN Y COMITÉ TÉCNICO YA DIERON SU ESTATUS
                                if (userType == 55 && d.creado_por == idUser && d.bandera_admin == 1 && d.bandera_comite == 1) {
                                    /**COMITÉ Y ADMIN DIERON SU ESTATUS, ADMIN FUE EL ULTIMO EN DAR ESTATUS */
                                      // BOTON APROBAR    
                                    bandera_request = d.contrato == 1 ? 1 : 0;
                                    group_buttons += `<button id="docs${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control-otros" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons +=`<button id="informacion" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información Cliente"><i class="fa fa-file"></i></button>`;
                                    bandera_reject = 1;
                                }
                                if (userType == 56 && d.bandera_admin == 1 && (d.bandera_comite == 0 ||  d.bandera_comite == null)) { 
                                /**SI COMITÉ TÉCNICO NO HA DADO SU ESTATUS Y ADMINISTRACIÓN SI*/
                                    // BOTON APROBAR
                                    bandera_request =  d.estatus_construccion != 0 && d.estatus_construccion != null ? 1 :0;
                                    group_buttons += `<button id="estatusL" data-estatus-construccion="${d.estatus_construccion}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Estatus del lote"><i class="fa fa-pencil-square-o"></i></button>`;   
                              }
                              break;
                            case 4:
                                //ADMINISTRACIÓN Y COMITÉ TÉCNICO YA DIERON SU ESTATUS
                                if (userType == 55 && d.creado_por == idUser && d.bandera_admin == 1 && d.bandera_comite == 1) {      
                                    /**COMITÉ Y ADMIN DIERON SU ESTATUS, COMITÉ FUE EL ULTIMO EN DAR ESTATUS */
                                    // BOTON APROBAR  
                                    group_buttons += `<button id="docs${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control-otros" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons +=`<button id="informacion" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información Cliente"><i class="fa fa-file"></i></button>`;
                                    bandera_reject = 1;
                                    bandera_request = d.contrato == 1 ? 1 : 0;
                                }
                                if (userType == 11 && (d.bandera_admin == 0 || d.bandera_admin == null) && d.bandera_comite == 1) {
                                /**SI ADMIN NO HA DADO SU ESTATUS Y COMITÉ SI */ 
                                    // BOTON APROBAR
                                    banderaAdmin=1;
                                    bandera_reject = userType == 11 ? 1 : 0;
                                    bandera_request = userType == 11 && (d.cliente_anterior != null && d.cliente_anterior != 0) ? 1 : 0;
                                    group_buttons += `<button id="informacion" data-area-actual="${userType}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`;
                                }
                            break;
                            case 5:
                                if (userType == 11) { 
                                    bandera_request = 1;
                                    group_buttons += `<button id="informacion" data-area-actual="${userType}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información Cliente"><i class="fa fa-file"></i></button>`;
                                }
                            break;
                            case 7: 
                                if (userType == 56) {      
                                    /**COMITÉ Y ADMIN DIERON SU ESTATUS, COMITÉ FUE EL ULTIMO EN DAR ESTATUS */
                                    // BOTON APROBAR
                                    group_buttons += `<button id="estatusL" data-estatus-construccion="${d.estatus_construccion}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Estatus del lote"><i class="fa fa-pencil-square-o"></i></button>`;   
                                    bandera_request = 1;
                                }
                            break;
                            case 6:
                            case 8:
                            case 10:
                                if (userType == 55 && d.creado_por == idUser && d.bandera_admin == 1 && d.bandera_comite == 1) {
                                    group_buttons += `<button id="docs${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control-otros" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons +=`<button id="informacion" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información Cliente"><i class="fa fa-file"></i></button>`;
                                    bandera_reject = d.id_estatus == 10 ? 1 : 0; 
                                    bandera_request = d.contrato == 1 ? 1 : 0;
                                }
                            break;
                            case 9:
                            case 11:
                            case 36:
                                if ((d.creado_por == idUser || idUser == 12071 || idUser == 12066)) { 
                                    bandera_request = (d.nombre_a_escriturar != 0 && d.nombre_a_escriturar != null) ? 1 : 0;
                                    group_buttons += `<button id="presupuesto" data-area-actual="${userType}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`;// `<button id="presupuesto" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Presupuesto"><i class="fas fa-coins"></i></button>`; 
                                    bandera_reject = 1;                           
                                }
                            break;
                            case 12:
                            case 36:
                                if (userType == 57 && d.id_titulacion == idUser) { 
                                  bandera_reject = 1;  
                                  bandera_request = d.estatusValidacion == 1 ? 1 : 0;                                        
                                  group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                  group_buttons += `<button id="viewInfoClient" data-area-actual="${userType}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información del cliente"><i class="fas fa-user-circle"></i></i></button>`; 
                                }
                            break;
                            case 59:
                                if (d.creado_por == idUser) {
                                    group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons += `<button id="presupuesto" data-area-actual="${userType}" class="btn-data btn-blueMaderas" data-toggle="tooltip" data-placement="left" title="Información"><i class="fas fa-info"></i></button>`; 
                                    bandera_request = 1;                                        
                                }
                            break;
                            case 13:
                            case 37:
                            case 16:
                                if (userType == 57 && d.id_titulacion == idUser) { 
                                    bandera_request = d.banderaPresupuesto == 1 ? 1 : 0;
                                    group_buttons += `<button id="treePresupuesto${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey treePresupuesto" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose presupuestos"><i class="fas fa-chevron-down"></i></button>`;
                                }
                            break;
                            case 14:
                            case 17:
                            case 38:
                                if (d.creado_por == idUser) { 
                                    bandera_request = d.banderaPresupuesto == 1 ? 1 : 0;
                                    bandera_reject = 1;
                                    group_buttons += `<button id="treePresupuesto${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey treePresupuesto" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Desglose presupuestos"><i class="fas fa-chevron-down"></i></button>`;
                                }
                            break;
                            case 15:
                                if (d.creado_por == idUser) { 
                                    bandera_request = 1;
                                }
                            break;
                            case 18:
                            case 21:
                                if (userType == 11) { 
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    permiso=1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 2, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 19:
                            case 22:
                            case 24:
                                    // if ((d.creado_por == idUser || idUser == 12071 || idUser == 12066)) { 
                                        //ESTATUS 19 Y 22 SE VALIDA QUE LOS DOCUMENTOS OBLIGATORIOS ESTEN CARGADOS Y UN PRESUPUESTO ESTE VALIDADO SOLO SI SE TRABAJARA CON UNA NOTARIA INTERNA
                                        if (d.creado_por == idUser || idUser == 12071 || idUser == 12066){
                                          group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                        } else if (d.creado_por == idUser){
                                        group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                        group_buttons += `<button id="newNotary" data-idSolicitud=${d.id_solicitud} class="btn-data btn-sky" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Nueva Notaría"><i class="fas fa-user-tie"></i></button>`;
                                        group_buttons += `<button id="pausarSolicitud" data-idSolicitud=${d.id_solicitud} class="btn-data btn-orangeYellow" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Pausar solicitud"><i class="fas fa-pause"></i></button>`;
                                        bandera_request = (d.id_notaria == 0 && d.documentosCargados == 1 && d.presupuestoAprobado == 1 && d.formasPago == 1) 
                                        ? 1 
                                        : (d.id_notaria != 0 && d.documentosCargados == 1 && d.formasPago == 1  && (d.presupuestoAprobado == 1 || d.presupuestoAprobado == 0 || d.presupuestoAprobado == null) 
                                        ? 1 
                                        : 0) ;                                        
                                        bandera_reject = 1;
                                    }
                            break;
                            case 20:
                            case 25:
                                    if (userType == 57 && d.id_titulacion == idUser) { 
                                        
                                        group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                        bandera_request = d.estatusValidacion == 1 ? 1 : 0;                                        
                                        bandera_reject = 1;
                                    }
                            break;
                            case 34:
                                if (userType == 57 && d.id_titulacion == idUser) { 
                                    group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    bandera_request = 1;
                                }
                            break;
                            case 23:
                                if (userType == 57 && d.id_titulacion == idUser) { 
                                    //BOTONES DANI
                                    bandera_request = 1;
                                }
                            break;
                            case 26:
                                if (userType == 57 && d.id_titulacion == idUser) {
                                    group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons += d.documentosCargados22 == 0  ? '' : `<button id="createDate" data-idSolicitud=${d.id_solicitud} data-action="3" data-idNotaria=${d.id_notaria} class="btn-data btn-green" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Fecha para firma"><i class="far fa-calendar-alt"></i></button>`;
                                }
                            break;
                            case 27:
                                if (d.creado_por == idUser) {
                                    //revisar si se muestran mas datos o solo avance
                                    group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    bandera_request = 1;
                                }
                            break;
                            case 28:
                            case 31:
                                if (d.creado_por == idUser) {
                                    //revisar si se muestran mas datos o solo avance
                                    bandera_request = 1;
                                    group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons +=  `<button id="newDate" data-idSolicitud=${d.id_solicitud} data-idNotaria=${d.id_notaria} class="btn-data btn-orangeYellow"  data-toggle="tooltip" data-placement="left"  title="Nueva fecha"><i class="fas fa-calendar-alt"></i></i></button>`;
                                    bandera_request = d.estatusValidacion22 == 1 ? 1 : 0;
                                }
                            break;
                            case 29:
                            case 40:
                                if (userType == 57 && d.id_titulacion == idUser) {
                                    //revisar si se muestran mas datos o solo avance
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    bandera_reject = 1;
                                    permiso=1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 2, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 30:
                                if (userType == 57 && d.id_titulacion == idUser) {
                                    //revisar si se muestran mas datos o solo avance
                                    group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    group_buttons += `<button id="createDate" data-idSolicitud=${d.id_solicitud} data-action="3" data-idNotaria=${d.id_notaria} class="btn-data btn-green" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Fecha para firma"><i class="far fa-calendar-alt"></i></button>`;
                                    bandera_request = d.estatusValidacion22 == 1 || d.no_editados22 == 1 ? 1 : 0;
                                }
                            break;
                            case 33:
                            case 41:
                                    if (d.creado_por == idUser) {
                                        //revisar si se muestran mas datos o solo avance
                                        bandera_reject = 1;
                                        bandera_request = d.expediente != null ? 1 : 0;
                                        permiso=2;
                                        group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 2, btnsAdicionales,datosEstatus);
                                    }
                            break;
                            case 39:
                            case 44:
                                    if (userType == 11) { 
                                        bandera_request = d.expediente != null ? 1 : 0;
                                        permiso = 1;
                                        group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                    }
                            break;
                            case 42:
                            case 45:
                                    if (d.creado_por == idUser) { 
                                        bandera_request = d.expediente != null ? 1 : 0;
                                        bandera_reject = 1;
                                        permiso = 2;
                                        group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                    }
                            break;
                            case 43:
                                if (d.creado_por == idUser) {
                                    //revisar si se muestran mas datos o solo avance
                                    group_buttons += d.fecha_firma != null ? '' : `<button id="createDate" data-idSolicitud=${d.id_solicitud} data-action="3" data-idNotaria=${d.id_notaria} class="btn-data btn-green" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="Fecha para firma"><i class="far fa-calendar-alt"></i></button>`;
                                    bandera_request = 1;
                                }
                            break;
                            case 46:
                            case 52:
                                if (userType == 57 && d.id_titulacion == idUser) { 
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    permiso = 1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 47:
                            case 50:
                                if (userType == 57 && d.id_titulacion == idUser) { 
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    permiso = 1;
                                    numTable=1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 37:
                                if (userType == 57 && d.id_titulacion == idUser) { 
                                    bandera_request = 1;
                                }
                            break;
                            case 38:
                                if (d.creado_por == idUser) { 
                                    bandera_request = 1;
                                    bandera_reject = 1;
                                }
                            break;
                            case 48:
                            case 51:
                            case 53:
                                if (userType == 17) { 
                                    bandera_request = 1;
                                    group_buttons += `<button id="docs${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control-otros" data-permisos="2" data-toggle="tooltip" data-placement="left" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
                                    bandera_reject = 1;
                                }
                            break;
                            case 47:
                            case 50: 
                                if (userType == 57 && d.id_titulacion == idUser) { 
                                    numTable=1;
                                    bandera_request = d.expediente != null ? 1 : 0;
                                    permiso = 1;
                                    group_buttons += permisos(permiso,  d.expediente, d.idDocumento, d.tipo_documento, d.id_solicitud, 1, btnsAdicionales,datosEstatus);
                                }
                            break;
                            case 54: 
                                if (d.creado_por == idUser) { 
                                    numTable=3;
                                    bandera_request = 1;
                                }
                            break;
                      
                        default:
                            break;
                    }
                    $('[data-toggle="tooltip"]').tooltip();
                    if(bandera_request == 1){
                      d.area_sig = banderaAdmin == 1 ? 'Postventa' : d.area_sig;
                      d.nombre_estatus_siguiente = banderaAdmin == 1 ? 'APE0004 - RECEPCIÓN DE ESTATUS DE CONSTRUCCIÓN - POSTVENTA' : d.nombre_estatus_siguiente;
                      group_buttons += `<button id="request" data-num-table="${numTable}" data-siguiente-area="${d.area_sig}" data-siguiente_actividad="${d.nombre_estatus_siguiente}" data-type="5" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Aprobar"><i class="fas fa-paper-plane"></i></button>`;
                    }
                    if(bandera_reject == 1){
                        group_buttons += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-reply"></i></button>`;
                    }
                    let usuarios = [10865,10862,10843,10863,10877,10871,12071,12160,12066,12113,11933,2965,12668,2964];
                    if(usuarios.includes(idUser)){
                      group_buttons +=`<button id="borrarSolicitud" data-idLote="${d.id_lote}" data-idEstatus="${d.id_estatus}" data-idCliente="${d.id_cliente}" data-banderaEscrituracion="${d.banderaEscrituracion}" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Borrar solicitud"><i class="fa fa-trash"></i></button>`;
                    }
                      group_buttons += `<button data-idSolicitud=${d.id_solicitud} data-lotes=${d.nombreLote} class="btn-data btn-details-grey comentariosModel" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="HISTORIAL DE COMENTARIOS"><i class="fa fa-history"></i></button>`;
                    return '<div class="d-flex justify-center">' + group_buttons + '<div>';
                }
            },
        ],
        columnDefs: [{
            "searchable": true,
            "orderable": false,
            "targets": 0
        }
        ],
        ajax: {
            url: datosTablas.url,
            type: "POST",
            cache: false,
            data: datosTablas.data
        },
        initComplete: function(settings, json) {
          numTabla == 0 ? escrituracionTable = $('#escrituracion-datatable').DataTable() : ''; 
          numTabla == 1 ?  escrituracionTableTest = $('#carga-datatable').DataTable() : ''; 
        },
    });
    if(datosTablas.numTable == 2){
        escrituracionTable = $('#escrituracion-datatable').DataTable();
        escrituracionTableTest = $('#carga-datatable').DataTable();
        escrituracionPausadas = $('#pausadas_tabla').DataTable();
    }   

}

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
        changeStatus(idSolicitud, action == 1 ? 4:0, 'correo enviado', 1);

        $('#spiner-loader').addClass('hide');
    }, 'json');
}
var arrayTables = [
      {'nombreTabla' : 'escrituracion-datatable',
        'data':{},
        'url':'getSolicitudes',
        'numTable':0
      },
      { 'nombreTabla' : 'carga-datatable',
        'data':{},
        'url':'getSolicitudes',
        'numTable':1
      }, 
    { 'nombreTabla' : 'pausadas_tabla',
      'data':{},
      'url':'getSolicitudes',
      'numTable':2
    }

];

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
    finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
    finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');
    
    $('#beginDate').val(finalBeginDate2);
    $('#endDate').val(finalEndDate2);
    $('#startDate').val(finalBeginDate2);
    $('#finalDate').val(finalEndDate2);
/*cuando se carga por primera vez, se mandan los valores en cero, para no filtar por mes*/
console.log(arrayTables.length)
    for (let z = 0; z < arrayTables.length; z++) {
        arrayTables[z].data =  {
            "beginDate": 0,
            "endDate": 0,
            "estatus": z == 0 ? $('#estatusE').val() : z == 1 ? 0 : 2,
            "tipo_tabla":arrayTables[z].numTable 
        };
            crearTablas(arrayTables[z]);
    }
    $('[data-toggle="tooltip"]').tooltip();

}

function getMotivosRechazos(tipo_documento,estatus) {
    document.getElementById('area_selected').innerHTML = '';
    $('#spiner-loader').removeClass('hide');
    $("#motivos_rechazo").find("option").remove();
    $("#motivos_rechazo").append($('<option disabled>').val("0").text("Seleccione una opción"));
    $("#area_rechazo").find("option").remove();
    $("#area_rechazo").append($('<option disabled>').val("0").text("Seleccione una opción"));
    let showSelect = estatus == 3 || estatus == 4 && userType != 11 ? 'show' : estatus == 29 || estatus == 48 ? 'show' : 'none';
    if(estatus != 3 && estatus != 4){
        $('#area_rechazo').prop('required', false);
    }
    if(estatus == 4 && userType == 11){
        $('#area_rechazo').prop('required', false);
    }
    document.getElementById("rechazo").style.display = showSelect;
    $.post('getMotivosRechazos', {
        tipo_documento: tipo_documento,
        estatus: estatus
    }, function (data) {
        var len = data.dataMotivos.length;
        var len2 = data.dataEstatus.length;
        for (var i = 0; i < len; i++) {
            var id = data.dataMotivos[i]['id_motivo'];
            var name = data.dataMotivos[i]['motivo'];
            $("#motivos_rechazo").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#motivos_rechazo").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        for (var i = 0; i < len2; i++) { 
            var id = data.dataEstatus[i]['estatus_siguiente']+','+data.dataEstatus[i]['nombre_siguiente'];
            var name = data.dataEstatus[i]['actividad_actual'] +' - '+ data.dataEstatus[i]['nombre_siguiente'];
            var descripcion = data.dataEstatus[i]['nombre_siguiente'];
            $("#area_rechazo").append($('<option>').val(id).text(name));
        }
        if (len <= 0) {
            $("#area_rechazo").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#motivos_rechazo").selectpicker('refresh');
        $("#area_rechazo").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
}

$(document).on("change", "#area_rechazo", function () {
  var input = $(this).val();
  let datos = input.split(",");
  document.getElementById("area_selected").innerHTML = datos[1];
});

function getDocumentsClient(idEscritura) {
  $("#spiner-loader").removeClass("hide");
  $("#documents").find("option").remove();
  $("#documents").append(
    $("<option disabled>").val("0").text("Seleccione una opción")
  );
  $.post(
    "getDocumentsClient",
    {
      idEscritura: idEscritura,
      idEstatus: idEstatus,
    },
    function (data) {
      var len = data.length;
      for (var i = 0; i < len; i++) {
        var id = data[i]["idDocumento"];
        var name = data[i]["nombre"];
        $("#documents").append($("<option>").val(id).text(name));
      }
      if (len <= 0) {
        $("#documents").append(
          '<option selected="selected" disabled>No se han encontrado registros que mostrar</option>'
        );
      }
      $("#documents").selectpicker("refresh");
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

function getNotarias(datos = null) {
  $("#spiner-loader").removeClass("hide");
  $(".notaria-select").find("option").remove();
  $(".notaria-select").append(
    $("<option disabled>").val("0").text("Seleccione una opción")
  );
  $.post(
    "getNotarias",
    function (data) {
      data = data.data;
      var len = data.length;
      for (var i = 0; i < len; i++) {
        var id = data[i]["idNotaria"];
        var name = data[i]["nombre_notaria"];
        $(".notaria-select").append($("<option>").val(id).text(name));
      }
      if (len <= 0) {
        $(".notaria-select").append(
          '<option selected="selected" disabled>No se han encontrado registros que mostrar</option>'
        );
      }
      $(".notaria-select").selectpicker("refresh");
      if (datos != null) {
        let selects = $(`#notarias-${datos.id_solicitud}`).find(
          ".selectpicker.notaria-select"
        );
        selects.each(function (index, element) {
          $(`#${element.id}`).selectpicker(
            "val",
            datos.notarias[index] ? datos.notarias[index].id_notaria : null
          );
          $(`#${element.id}`).trigger("change");
        });
      }
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

function getValuadores() {
  $("#spiner-loader").removeClass("hide");
  $("#valuador").find("option").remove();
  $("#valuador").append(
    $("<option disabled>").val("0").text("Seleccione una opción")
  );
  $.post(
    "getValuadores",
    function (data) {
      var len = data.length;
      for (var i = 0; i < len; i++) {
        var id = data[i]["idValuador"];
        var name = data[i]["perito"];
        $("#valuador").append($("<option>").val(id).text(name));
      }
      if (len <= 0) {
        $("#valuador").append(
          '<option selected="selected" disabled>No se han encontrado registros que mostrar</option>'
        );
      }
      $("#valuador").selectpicker("refresh");
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

function getBudgetInfo(idSolicitud) {
  $("#spiner-loader").removeClass("hide");
  getEstatusPago();
  getTipoEscrituracion();
  $.post(
    "getBudgetInfo",
    {
      idSolicitud: idSolicitud,
    },
    function (data) {
      $("#nombrePresupuesto").val(data.nombre);
      $("#nombrePresupuesto2").val(data.nombre_a_escriturar);
      $("#valor_escri").val(data.valor_escriturar);
      $("#estatusPago").selectpicker();
      $("#estatusPago").val(data.estatus_pago);
      $("select[name=estatusPago]").change();
      $("#aportaciones").val(formatMoney(data.aportacion));
      $("#descuentos").val(formatMoney(data.descuento));
      $("#motivo").val(data.motivo);
      $("#superficie").val(data.superficie);
      $("#superficie").val(data.superficie);
      var str =
        data.modificado != null ? data.modificado.split(" ")[0].split("-") : "";
      var strM = data.modificado != null ? `${str[2]}-${str[1]}-${str[0]}` : "";
      var fechaContrato =data.fecha_contrato != null ? data.fecha_contrato.split("-") : null;
      strM = data.fecha_contrato == null ? strM : `${fechaContrato[2]}-${fechaContrato[1]}-${fechaContrato[0]}`;
      $("#fContrato").val(strM);
      $("#catastral").val(data.clave_catastral);
      $("#construccionInfo").val(data.nombreConst);
      $("#cliente")
        .val(data.cliente_anterior == 1 ? "uno" : "dos")
        .trigger("change");
      $("#cliente").selectpicker("refresh");
      $("#nombreT").val(data.nombre_anterior);
      lengthCopropietarios = data.copropietarios.length;
      $('#indexCo').val(lengthCopropietarios);
      for (let m = 0; m < lengthCopropietarios; m++) {
        $('#copropietarios').append(`
        <div class="col-lg-12" id="coo_${m}">
            <div class="col-md-7 pr-0 pr-0">
              <div class="form-group text-left m-0">
                  <input id="id_copropietario_${m}" value="${data.copropietarios[m].idCopropietario}" name="id_copropietario_${m}" class="form-control input-gral" type="hidden"> 
                  <input id="copropietario_Update_${m}" value="${data.copropietarios[m].nombre}" name="copropietario_Update_${m}" class="form-control input-gral" type="text" required> 
              </div>
            </div>
            <div class="col-md-1 pr-0 pr-0 d-flex align-top justify-center">
              <div class="form-group m-0">
                <button class="btn-data btn-warning" type="button" onclick="borrarCopropietario(${m},${data.copropietarios[m].idCopropietario})" data-toggle="tooltip" data-placement="top" title="Eliminar copropietario"><i class="fas fa-user-times"></i></button>
              </div>
            </div>
            <br>
          </div>`);
        
      }
      let fechaAnterior =
        data.fecha_anterior != null
          ? data.fecha_anterior.split(" ")[0].split("-").reverse().join("-")
          : data.fecha_anterior;
      $("#fechaCA").val(fechaAnterior);
      $("#rfcDatos").val(data.RFC);
      $("#encabezado").html(
        `${data.nombreResidencial} / ${data.nombreCondominio} / ${data.nombreLote}`
      );
      $("#tipoE").selectpicker();
      $("#tipoE").val(data.tipo_escritura);
      $("select[name=tipoE]").change();
      $("#tipoNotaria")
        .val(data.id_notaria != 0 ? 2 : 1)
        .trigger("change");
      $("#tipoNotaria").selectpicker("refresh");
      $("#nombre_notaria").val(data.id_notaria != 0 ? data.nombre_notaria : "");
      $("#nombre_notario").val(data.id_notaria != 0 ? data.nombre_notario : "");
      $("#direccion").val(data.id_notaria != 0 ? data.direccion : "");
      $("#correo").val(data.id_notaria != 0 ? data.correo : "");
      $("#telefono").val(data.id_notaria != 0 ? data.telefono : "");
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

function checkBudgetInfo(idSolicitud) {
  $("#spiner-loader").removeClass("hide");
  $.post(
    "checkBudgetInfo",
    {
      idSolicitud: idSolicitud,
    },
    function (data) {
      $("#nombrePresupuesto3").val(data.nombre);
      $("#nombrePresupuesto4").val(data.nombre_escrituras);
      $("#valor_escri4").val(data.valor_escriturar);
      $("#estatusPago2").val(data.nombrePago);
      $("#superficie2").val(data.superfice);
      $("#fContrato2").val(data.modificado);
      $("#catastral2").val(data.clave_catastral);
      $("#construccion2").val(data.nombreConst);
      $("#cliente2")
        .val(data.cliente_anterior == 1 ? "uno" : "dos")
        .trigger("change");
      $("#cliente2").selectpicker("refresh");
      $("#nombreT2").val(data.nombre_anterior);
      $("#fechaCA2").val(data.fecha_anterior);
      $("#rfcDatos2").val(data.RFC);
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

function formatDate(date) {
  var dateParts = date.split("/");
  var d = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();
  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;
  return [year, month, day].join("-");
}

function formatDate2(date) {
  var dateParts = date.split("/");
  let timePart = dateParts[2].split(" ");
  let timeParts = timePart[1].split(":");
  var d = new Date(+timePart[0], dateParts[1] - 1, +dateParts[0], timeParts[0], timeParts[1]),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();
    time = d.getTime();
  if (month.length < 2) month = "0" + month;
  if (day.length < 2) day = "0" + day;
  let newDate =
    [year, month, day].join("-") + " " + timeParts[0] + ":" + timeParts[1];
  return newDate;
}

function sino() {
  $("#cliente").find("option").remove();
  $("#cliente").append($("<option disabled>").val(0).text("Seleccione una opción"));
  $("#cliente").append($("<option>").val(1).text("si"));
  $("#cliente").append($("<option>").val(2).text("no"));
  $("#cliente").selectpicker("refresh");
}

function displayInput(idDocumento) {
  $("#uploadedDocument2").attr("data-idDoc", idDocumento);
  $("#documentsSection").removeClass("hide");
}

function permisos(
  permiso,
  expediente,
  idDocumento,
  tipo_documento,
  idSolicitud,
  banderaBoton,
  BtnsAdicionales,
  datosEstatus
) {

  let botones = "";
  switch (permiso) {
    case 0:
      botones += ``;
      break;
    case 1: //escritura
      if (expediente == null || expediente == "" || expediente == "null") {
        if (banderaBoton == 2) {
          botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${
            expediente == null || expediente == "" ? 1 : 2
          } class="btn-data ${
            expediente == null || expediente == "" ? "btn-sky" : "btn-gray"
          } upload" data-toggle="tooltip" data-placement="left" title=${
            expediente == null || expediente == "" ? "Cargar" : "Eliminar"
          }>${
            expediente == null || expediente == ""
              ? '<i class="fas fa-upload"></i>'
              : '<i class="fas fa-trash"></i>'
          }</button>`;
        } else {
          botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${
            expediente == null || expediente == "" ? 1 : 2
          } class="btn-data ${
            expediente == null || expediente == "" ? "btn-sky" : "btn-gray"
          } upload" data-toggle="tooltip" data-placement="left" title=${
            expediente == null || expediente == "" ? "Cargar" : "Eliminar"
          }>${
            expediente == null || expediente == ""
              ? '<i class="fas fa-upload"></i>'
              : '<i class="fas fa-trash"></i>'
          }</button>`;
          botones += BtnsAdicionales;
        }
      } else {
        if (banderaBoton == 2) {
          botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${
            expediente == null || expediente == "" ? 1 : 2
          } class="btn-data ${
            expediente == null || expediente == "" ? "btn-sky" : "btn-gray"
          } upload" data-toggle="tooltip" data-placement="left" title=${
            expediente == null || expediente == "" ? "Cargar" : "Eliminar"
          }>${
            expediente == null || expediente == ""
              ? '<i class="fas fa-upload"></i>'
              : '<i class="fas fa-trash"></i>'
          }</button>`;
        } else {
          botones += `<button data-idDocumento="${idDocumento}" data-documentType="${tipo_documento}" data-idSolicitud=${idSolicitud} data-action=${
            expediente == null || expediente == "" ? 1 : 2
          } class="btn-data ${
            expediente == null || expediente == "" ? "btn-sky" : "btn-gray"
          } upload" data-toggle="tooltip" data-placement="left" title=${
            expediente == null || expediente == "" ? "Cargar" : "Eliminar"
          }>${
            expediente == null || expediente == ""
              ? '<i class="fas fa-upload"></i>'
              : '<i class="fas fa-trash"></i>'
          }</button>`;
          botones += BtnsAdicionales;
        }
        botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
      }
      break;
    case 2:
      if (banderaBoton == 1) {
        botones += BtnsAdicionales;
      }
      if (expediente != 1) {
        botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
      }
      break;
    case 3:
      if (expediente == null || expediente == "" || expediente == "null") {
        if (banderaBoton == 1) {
          botones += BtnsAdicionales;
        }
      } else {
        if (banderaBoton == 1) {
          botones += BtnsAdicionales;
        }
        if (expediente != 1) {
          botones += `<button id="preview" data-doc="${expediente}" data-documentType="${tipo_documento}" class="btn-data btn-details-grey" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
          botones += `<button id="reject" class="btn-data btn-warning" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fas fa-reply"></i></button>`;
        }
        botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar"><i class="fas fa-paper-plane"></i></button>';
      }
      break;
    case 4:
      if (banderaBoton == 1) {
        botones += BtnsAdicionales;
      }
      if (expediente == 2) {
        botones += '<button id="request" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" title="Enviar"><i class="fas fa-paper-plane"></i></button>';
      }
      break;
  }
  return '<div class="d-flex justify-center">' + botones + "</div>";
}
let documentosObligatorios = [];
function buildTableDetail(data, permisos,proceso = 0) {
    documentosObligatorios = [];
    var filtered = data.filter(function(value){ 
        if((value.tipo_documento == 12 && (value.estatus_solicitud == 20 || value.estatus_solicitud == 25 || value.estatus_solicitud == 34) && value.estatusPresupuesto != 1) || (value.tipo_documento == 12 && (value.estatus_solicitud == 48 || value.estatus_solicitud == 51 || value.estatus_solicitud == 53))){
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
    solicitudes += '<td>' + '<b>' + 'ESTATUS VALIDACIÓN ' + '</b></td>';
    solicitudes += '<td>' + '<b>' + 'ACCIONES ' + '</b></td>';
    solicitudes += '</tr>';
    $.each(filtered, function (i, v) {
        let documento = v.tipo_documento == 12 ? v.expediente : v.descripcion;
        solicitudes += '<tr>';
        solicitudes += '<td> ' + (i + 1) + ' </td>';
        solicitudes += '<td> ' + documento + ' </td>';
        solicitudes += '<td> ' + v.documento_creado_por + ' </td>';
        let fecha_inicio = moment(v.fecha_creacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
        solicitudes += '<td> ' + fecha_inicio + ' </td>';
        solicitudes += '<td> ' + v.motivos_rechazo + ' </td>';
        solicitudes += '<td> ' + v.validado_por + ' </td>';
        solicitudes += `<td> <span class="label" style="background:${v.colour}">${v.estatus_validacion}</span></span>${v.editado == 1 ? `<br><span class="label" style="background:#C0952B">EDITADO</span>`:``} </td>`;
        solicitudes += '<td><div class="d-flex justify-center">';
        if (permisos == 1 && (v.ev == null || v.ev == 2) && ( v.estatus_solicitud == 19 || v.estatus_solicitud == 22 || v.estatus_solicitud ==  24) && (v.tipo_documento == 7 || v.tipo_documento == 12 || v.tipo_documento == 18)){
            solicitudes += ``;
            if(v.tipo_documento == 12 || v.tipo_documento == 7){
                if(v.tipo_documento == 12){
                    if(v.estatusPresupuesto == null || v.estatusPresupuesto == 0){
                        solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-estatus-solicitud="${v.estatus_solicitud}" data-details ="1" data-action="3" class="btn-data btn-deepGray approve" data-toggle="tooltip" data-placement="left" title="Documento OK"><i class="fas fa-thumbs-up" style="color: aliceblue"></i></button>`;
                    }else{
                        solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-estatus-solicitud="${v.estatus_solicitud}" data-details ="1" data-action="4" class="btn-data btn-green approve" data-toggle="tooltip" data-placement="left" title="Documento NOK" disabled><i class="fas fa-thumbs-up"></i></button>`;
                    }
                }else{
                                    //EV: ESTATUS VALIDACIÓN DE CADA DOCUMENTO
                        if (v.ev == 1) // 1 VALIDADO, SE MUESTRA BOTON PARA NOK
                            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-warning upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Documento NOK"><i class="fas fa-thumbs-down"></i></button>`;
                        else if (v.ev == 2) //2 DOCUMENTO RECHAZADO, SE MUESTRA BOTON PARA VALIDAR
                            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-green upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Documento OK"><i class="fas fa-thumbs-up"></i></button>`;
                        else if (v.expediente != null) { //EXPEDIENTE SIN MOVIMIENTOS, SE MUESTRA BOTON PARA VALIDAR OK Y RECHACHAZAR
                            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-gray upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Sin validar OK"><i class="fas fa-thumbs-up"></i></button>`;
                            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-gray upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Sin validar NOK"><i class="fas fa-thumbs-down"></i></button>`;
                    }
                    
                }
            }
        }
        else if(permisos == 1 && (v.ev == 1) && ( v.estatus_solicitud == 19 || v.estatus_solicitud == 22 || v.estatus_solicitud ==  24) && (v.tipo_documento == 18)){
          solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }
        //ACTIVIDAD APE0004 - POSTVENTA CARGA DOCUMENTO (CONTRATO Y OTROS) 
        else if(permisos == 1 && (v.ev == null || v.ev == 2) && (v.estatus_solicitud == 3 || v.estatus_solicitud == 4 || v.estatus_solicitud == 6 || v.estatus_solicitud == 8 || v.estatus_solicitud == 10) && (v.tipo_documento == 17 || v.tipo_documento == 18) ) {
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="3" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        } //PERMISO DE ESCRITURA SUBIR NUEVO ARCHIVO FORMAS DE PAGO FECHA FIRMA
        else if(permisos == 1 && (v.ev == null || v.ev == 2) && (v.estatus_solicitud == 26 || v.estatus_solicitud == 30) && (v.tipo_documento == 22) ) {
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        } else if(permisos == 1 && (v.ev == null || v.ev == 2) && (v.estatus_solicitud == 59) && (v.tipo_documento == 17 || v.tipo_documento == 18) ) {
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }
        else if (permisos == 2 && v.estatus_solicitud == 5) {
            if(v.tipo_documento == 17 || v.tipo_documento == 18){
                solicitudes += ``;
            }
        }//ACTIDAD APE0011 - POSTVENTA INTEGRACIÓN DE EXPEDIENTE, CARGA Y ELIMINACIÓN DE ARCHIVOS
        else if(permisos == 1 && (v.ev == null || v.ev == 2) && ( v.estatus_solicitud == 19 || v.estatus_solicitud == 22 || v.estatus_solicitud ==  24)){
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documento-validar="${v.documento_a_validar}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }//ACTIVIDAD APE0012 VISTA PARA VALIDAR LOS ARCHIVOS CARGADOS EXCEPTO: PRESUPUESTO, OTROS, CONTRATO, FORMAS DE PAGO
        else if (permisos == 2 && (v.estatus_solicitud == 20 || v.estatus_solicitud == 25 || v.estatus_solicitud == 27 || v.estatus_solicitud == 31)) {
            if(v.tipo_documento == 12 || v.tipo_documento == 7 || v.tipo_documento == 17 || v.tipo_documento == 11){
                solicitudes += ``;
            }else{
                //EV: ESTATUS VALIDACIÓN DE CADA DOCUMENTO
                if (v.ev == 1) // 1 VALIDADO, SE MUESTRA BOTON PARA NOK
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-warning upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Documento NOK"><i class="fas fa-thumbs-down"></i></button>`;
                else if (v.ev == 2) //2 DOCUMENTO RECHAZADO, SE MUESTRA BOTON PARA VALIDAR
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-green upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Documento OK"><i class="fas fa-thumbs-up"></i></button>`;
                else if (v.expediente != null) { //EXPEDIENTE SIN MOVIMIENTOS, SE MUESTRA BOTON PARA VALIDAR OK Y RECHACHAZAR
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-gray upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Sin validar OK"><i class="fas fa-thumbs-up"></i></button>`;
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-gray upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Sin validar NOK"><i class="fas fa-thumbs-down"></i></button>`;
                }
            }
        }else if (permisos == 2 && (v.estatus_solicitud == 12 || v.estatus_solicitud == 59)) {
            if(v.tipo_documento == 17){
                solicitudes += ``;
            }else{
                                    //EV: ESTATUS VALIDACIÓN DE CADA DOCUMENTO
                if (v.ev == 1) // 1 VALIDADO, SE MUESTRA BOTON PARA NOK
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-warning upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Documento NOK"><i class="fas fa-thumbs-down"></i></button>`;
                else if (v.ev == 2) //2 DOCUMENTO RECHAZADO, SE MUESTRA BOTON PARA VALIDAR
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-green upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Documento OK"><i class="fas fa-thumbs-up"></i></button>`;
                else if (v.expediente != null) { //EXPEDIENTE SIN MOVIMIENTOS, SE MUESTRA BOTON PARA VALIDAR OK Y RECHACHAZAR
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="3" class="btn-data btn-gray upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Sin validar OK"><i class="fas fa-thumbs-up"></i></button>`;
                    solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action="4" class="btn-data btn-gray upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title="Sin validar NOK"><i class="fas fa-thumbs-down"></i></button>`;
                }
            }
            
        }//PENDIENTE SI BORRAR O NO
        else if (permisos == 1 && v.ev == null && v.estatus_solicitud == 13 && v.tipo_documento == 7){
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="1" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;
        }else if (permisos == 2 && v.ev == null && v.estatus_solicitud == 23  && (v.tipo_documento == 14 || v.tipo_documento == 19)){            
            solicitudes += `<button data-idDocumento="${v.idDocumento}" data-documentType="${v.tipo_documento}" data-idSolicitud=${v.idSolicitud} data-details ="3" data-action=${v.expediente == null || v.expediente == '' ? 1 : 2} class="btn-data btn-${v.expediente == null || v.expediente == '' ? 'blueMaderas' : 'warning'} upload" data-id-estatus="${v.estatus_solicitud}" data-toggle="tooltip" data-placement="left" title=${v.expediente == null || v.expediente == '' ? 'Cargar' : 'Eliminar'}>${v.expediente == null || v.expediente == '' ? '<i class="fas fa-upload"></i>' : '<i class="far fa-trash-alt"></i>'}</button>`;   
        }else if (permisos == 1 && v.ev == null && v.estatus_solicitud == 23 && (v.tipo_documento == 16 || v.tipo_documento == 22)){            
            solicitudes += ``;
        }
        if (v.expediente == null || v.expediente == ''){
            solicitudes += '';
        } 
        else{
            //BOTON PARA VISUALIZAR CADA ARCHIVO
            let expe = v.tipo_documento == 12 ? v.movimiento : v.expediente;
            solicitudes += `<button id="preview" data-documentType="${v.tipo_documento}" data-doc="${expe}" class="btn-data btn-gray" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
        }
        if(proceso == 1 && v.documento_a_validar == 1 ){
            //SE LLENA ARRAY GLOBAL CON DATOS DE LOS ARCHIVOS QUE SON REQUERIDOS Y SE VALIDAN(COLUMNA DOCUMENTO_A_VALIDAR = 1) EN LA ACTIVIDAD APE0012 Y APE001
            documentosObligatorios.push({
                "idDocumento" : v.idDocumento,
                "expediente" : v.tipo_documento == 12 ? v.movimiento : v.expediente,
                "obligario" : v.documento_a_validar == null ? 0 : 1,
                "tipo_documento"  : v.tipo_documento,
                "validado" : v.estatusValidacion,
                "cargado": v.expediente != null ? 1 : 0
            });
            console.log(documentosObligatorios)
        }
        solicitudes += '</div></td></tr>';
    });
    return solicitudes += '</table>';
}

function getSignDate(idNotaria) {
  let date = new Date();
  let i = 0;
  let dias =
    idNotaria == 1
      ? 7
      : idNotaria == 2
      ? 7
      : idNotaria == 3
      ? 7
      : idNotaria == 4
      ? 7
      : idNotaria == 5
      ? 7
      : idNotaria == 6
      ? 7
      : idNotaria == 10
      ? 15
      : idNotaria == 11
      ? 15
      : idNotaria == 12
      ? 15
      : 0;
  while (i < dias) {
    //dias habiles despues del dia de hoy
    date.setTime(date.getTime() + 24 * 60 * 60 * 1000); // añadimos 1 día
    if (date.getDay() != 6 && date.getDay() != 0) i++;
  }
  let minutes =
    date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
  let fecha =
    date.getDate() +
    "/" +
    (date.getMonth() + 1) +
    "/" +
    date.getFullYear() +
    " " +
    date.getHours() +
    ":" +
    minutes;
  return fecha;
}

function changeStatus(
  id_solicitud,
  action,
  comentarios,
  type,
  notaria,
  area_rechazo = 0
) {
  $("#spiner-loader").removeClass("hide");
  $.post(
    "changeStatus",
    {
      id_solicitud: id_solicitud,
      type: type,
      comentarios: comentarios,
      notaria: notaria,
      area_rechazo: area_rechazo,
    },
    function (data) {
      switch (action) {
        case 1: //MODAL PARA APROBAR LA SOLICITUD
          $("#approveModal").modal("hide");
          break;
        case 3: //MODAL PARA RECHAZAR LA SOLICITUD
          $("#rejectModal").modal("hide");
          break;
        case 2: //MODAL PARA FECHA DE FIRMA DEL CLIENTE
          $("#dateModal").modal("hide");
          break;
        case 4: //MODAL
          $("#notarias").modal("hide");
          break;
        default:
          break;
      }
      escrituracionTable.ajax.reload(null, false);
      escrituracionTableTest.ajax.reload(null, false);
      escrituracionPausadas.ajax.reload(null, false);
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

$(document).on("submit", "#asignarNotaria", function (e) {
  e.preventDefault();
  let id_solicitud = $("#id_solicitud").val();
  let data = new FormData($(this)[0]);
  data.append(
    "nombre_notaria",
    $("#nombre_notaria").val() == "" ? null : $("#nombre_notaria").val()
  );
  data.append(
    "nombre_notario",
    $("#nombre_notario").val() == "" ? null : $("#nombre_notario").val()
  );
  data.append(
    "direccion",
    $("#direccion").val() == "" ? null : $("#direccion").val()
  );
  data.append("correo", $("#correo").val() == "" ? null : $("#correo").val());
  data.append(
    "telefono",
    $("#telefono").val() == "" ? null : $("#telefono").val()
  );
  data.append(
    "id_solicitud",
    $("#id_solicitud").val() == "" ? null : $("#id_solicitud").val()
  );
  $.ajax({
    url: "registrarNotaria",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (response) {
      if (response) {
        alerts.showNotification(
          "top",
          "right",
          "Se asignó correctamente una Notaría.",
          "success"
        );
        $("#altaNotario").modal("hide");
        escrituracionTable.ajax.reload();
      } else {
        alerts.showNotification(
          "top",
          "right",
          "Error en asignar Notaría",
          "warning"
        );
      }
    },
  });
});

$(document).on("submit", "#newNotario", function (e) {
  e.preventDefault();
  let idSolicitud = $("#idSolicitud").val();
  let data = new FormData($(this)[0]);
  data.append(
    "nombre_notaria",
    $("#nombre_notaria").val() == "" ? null : $("#nombre_notaria").val()
  );
  data.append(
    "nombre_notario",
    $("#nombre_notario").val() == "" ? null : $("#nombre_notario").val()
  );
  data.append(
    "direccion",
    $("#direccion").val() == "" ? null : $("#direccion").val()
  );
  data.append("correo", $("#correo").val() == "" ? null : $("#correo").val());
  data.append(
    "telefono",
    $("#telefono").val() == "" ? null : $("#telefono").val()
  );
  data.append("idSolicitud", idSolicitud);
  $.ajax({
    url: "nuevoNotario",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (response) {
      alerts.showNotification(
        "top",
        "right",
        "Se agrego una nueva Notaría.",
        "success"
      );
      $("#altaNotario").modal("hide");
      escrituracionTable.ajax.reload(null, false);
    },
  });
});


$(document).on('click','#viewInfoClient',function(){
    var dataTable = escrituracionTable.row($(this).parents('tr')).data();
        $('#spiner-loader').removeClass('hide');
        document.getElementById('modalContent').innerHTML = '';
                $.post('getInfoCliente',{id_cliente:dataTable.id_cliente}, function(data) {
                    $('#modalContent').append(`
                        <div class="row aligned-row">
                            <div class="col-lg-1 p-0 text-right d-flex align-center justify-center">
                              <i class="fas fa-info fa-lg"></i>
                            </div>
                            <div class="col-lg-11 ">
                              <h6>Id cliente: <b>${data[0].id_cliente}</b></h6>
                              <h6>Nombre cliente: <b>${data[0].nombreCliente}</b></h6>
                            </div>
                        </div>
                    `);
                    $('#spiner-loader').addClass('hide');
                }, 'json');
        $('#modalInfoClient').modal('show');
});

function clearCopropietario(){
  $('#indexCo').val(0);
  document.getElementById('copropietarios').innerHTML = '';
}

function borrarCopropietario(index,id = ''){
  if( id != ''){
    $.post(
      "borrarCopropietario",
      {
        idCopropietario: id,
      },
      function (data) {
      },
      "json"
    );
  }
  document.getElementById(`coo_${index}`).innerHTML = '';
}

$(document).on("click","#btnCopropietario",function(){
  let index = parseInt($('#indexCo').val());
  $('#copropietarios').append(`
  <div class="col-lg-12" id="coo_${index}">
      <div class="col-md-7 pr-0 pr-0">
        <div class="form-group text-left m-0">
          <input id="copropietario_${index}" placeholder="Nombre del copropietario" name="copropietario_${index}" class="form-control input-gral" type="text" required> 
        </div>
      </div>
      <div class="col-md-1 pr-0 pr-0 d-flex align-top justify-center">
        <div class="form-group m-0">
          <button class="btn-data btn-warning" type="button" onclick="borrarCopropietario(${index})" data-toggle="tooltip" data-placement="top" title="Eliminar copropietario"><i class="fas fa-user-times"></i></button>
        </div>
      </div>
      <br>
    </div>`);
  $('[data-toggle="tooltip"]').tooltip();
  index = parseInt(index + 1);
  $('#indexCo').val(index);
});

$(document).on("click", "#notaria", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  getinfoNotariaExt(data.id_solicitud);
  $("#idSolicitud").val(data.id_solicitud);
  $("#gestionNotaria").modal();
});

$(document).on("click", "#newNotary", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  $("#idSolicitud").val(data.id_solicitud);
  $("#nombre_notaria").val("");
  $("#nombre_notario").val("");
  $("#direccion").val("");
  $("#correo").val("");
  $("#telefono").val("");
  $("#altaNotario").modal();
});

function getinfoNotariaExt(idSolicitud) {
  $.get(
    "getinfoNotariaExt",
    {
      idSolicitud: idSolicitud,
    },
    function (data) {
      $("#nombreNotaria").val(data.nombre_notaria);
      $("#nombreNotario").val(data.nombre_notario);
      $("#direccionN").val(data.direccion);
      $("#correoN").val(data.correo);
      $("#telefonoN").val(data.telefono);
    },
    "json"
  );
}

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
    type: "POST",
    success: function (response) {
      $("#gestionNotaria").modal("hide");
      escrituracionTable.ajax.reload();
    },
  });
});

function filterSelectOptions(documentType) {
  $("#rejectionReasons option").each(function () {
    if ($(this).attr("data-type") === documentType) {
      $(this).show();
    } else {
      $(this).hide();
    }
    $("select").val(documentType);
  });
  $("#rejectionReasons option:selected").prop("selected", false);
  $("#rejectionReasons").trigger("change");
  $("#rejectionReasons").selectpicker("refresh");
}

function getEstatusConstruccion(estatus_construccion) {
  $("#spiner-loader").removeClass("hide");
  $("#construccion").find("option").remove();
  if (estatus_construccion == null || estatus_construccion == 0) {
    $("#construccion").append(
      $("<option disabled selected>").val("").text("Seleccione una opción")
    );
  }
  $.post(
    "getEstatusConstruccion",
    function (data) {
      var len = data.length;
      for (var i = 0; i < len; i++) {
        var id = data[i]["id_opcion"];
        var name = data[i]["nombre"];
        $("#construccion").append($("<option>").val(id).text(name));
      }
      if (len <= 0) {
        $("#construccion").append(
          '<option selected="selected" disabled>No se han encontrado registros que mostrar</option>'
        );
      }
      if (estatus_construccion != null && estatus_construccion != 0) {
        $(`#construccion`).val(estatus_construccion);
        $(`#construccion`).trigger("change");
      }
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

function getEstatusPago() {
    console.log(arrayEstatusLote)
    $("#spiner-loader").removeClass("hide");
    $("#estatusPago").find("option").remove();
    $("#liquidado").find("option").remove();
    $("#estatusPago").append(
      $("<option disabled selected>").val("0").text("Seleccione una opción")
    );
        var len = arrayEstatusLote.length;
        for (var i = 0; i < len; i++) {
          $("#estatusPago").append($("<option>").val(arrayEstatusLote[i].id_opcion).text(arrayEstatusLote[i].nombre));
          $("#liquidado").append($("<option>").val(arrayEstatusLote[i].id_opcion).text(arrayEstatusLote[i].nombre));
        }
        if (len <= 0) {
          $("#estatusPago").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
          $("#liquidado").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }
        $("#estatusPago").selectpicker("refresh");
        $("#liquidado").selectpicker("refresh");
        $("#spiner-loader").addClass("hide");
      
  }

function createDocRow(row, tr, thisVar) {
  $.post("getDocumentsClient", {
    idEscritura: row.data().id_solicitud,
    idEstatus: row.data().id_estatus,
  }).done(function (data) {
    row.data().solicitudes = JSON.parse(data);
    escrituracionTable.row(tr).data(row.data());
    row = escrituracionTable.row(tr);
    row
      .child(
        buildTableDetail(
          row.data().solicitudes,
          $(".details-control").attr("data-permisos"),
          1
        )
      )
      .show();
    tr.addClass("shown");
    thisVar
      .parent()
      .find(".animacion")
      .removeClass("fa-caret-right")
      .addClass("fa-caret-down");
    $("#spiner-loader").addClass("hide");
  });
}

$(document).on("click", "#observacionesButton", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  $("#idSolicitud").val(data.id_solicitud);
  $("#viewObservaciones").modal();
});

$(document).on("change", "#pertenece", function () {
  if ($(this).val() == "Postventa") {
    $(document).on("submit", "#observacionesForm", function (e) {
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
        type: "POST",
        success: function (response) {
          $("#viewObservaciones").modal("hide");
          escrituracionTable.ajax.reload(null, false);
        },
      });
    });
  } else if ($(this).val() == "Proyectos") {
    $(document).on("submit", "#observacionesForm", function (e) {
      e.preventDefault();
      let idSolicitud = $("#idSolicitud").val();
      let data = new FormData($(this)[0]);
      data.append("idSolicitud", idSolicitud);
      $.ajax({
        url: "observacionesProyectos",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function (response) {
          $("#viewObservaciones").modal("hide");
          escrituracionTable.ajax.reload();
        },
      });
    });
  }
});

function saveEstatusLote(idSolicitud, data) {
  $("#spiner-loader").removeClass("hide");
  $.ajax({
    url: "saveEstatusLote",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (response) {
      if (response == 1) {
        $("#estatusLModal").modal("hide");
        $("#spiner-loader").addClass("hide");
        escrituracionTable.ajax.reload(null, false);
        alerts.showNotification(
          "top",
          "right",
          "Registro editado correctamente.",
          "success"
        );
      }
    },
    error: function () {
      alerts.showNotification(
        "top",
        "right",
        "Oops, algo salió mal.",
        "danger"
      );
      $("#spiner-loader").addClass("hide");
    },
  });
}

function createDocRowPresupuesto(row, tr, thisVar) {
  $.post("getPresupuestos", {
    idEscritura: row.data().idSolicitud,
  }).done(function (data) {
    row.data().solicitudes = JSON.parse(data);
    escrituracionTable.row(tr).data(row.data());
    row = escrituracionTable.row(tr);
    row
      .child(
        buildTableDetailP(
          row.data().solicitudes,
          $(".treePresupuesto").attr("data-permisos")
        )
      )
      .show();
    tr.addClass("shown");
    thisVar
      .parent()
      .find(".animacion")
      .removeClass("fa-caret-right")
      .addClass("fa-caret-down");
    $("#spiner-loader").addClass("hide");
  });
}

let datosPresupuestos = new Object();
function RecargarTablePresupuestos() {
  if (
    datosPresupuestos.id_estatus != 38 &&
    datosPresupuestos.id_estatus != 14 &&
    datosPresupuestos.id_estatus != 17
  ) {
    escrituracionTable.ajax.reload(null, false);
    createRowNotarias(
      datosPresupuestos.row,
      datosPresupuestos.tr,
      datosPresupuestos.thisVar,
      datosPresupuestos.idSolicitud
    );
  }
}

function createRowNotarias(row, tr, thisVar, idSolicitud, id_estatus = 0) {
  datosPresupuestos = {
    row: row,
    tr: tr,
    thisVar: thisVar,
    idSolicitud: idSolicitud,
    id_estatus: id_estatus,
  };
  $.post("getNotariasXUsuario", {
    idSolicitud: idSolicitud,
  }).done(function (data) {
    row.data().notarias = JSON.parse(data);
    escrituracionTable.row(tr).data(row.data());
    row = escrituracionTable.row(tr);
    row.child(crearDetailsPresupuestos(row.data(),$(".treePresupuesto").attr("data-permisos"))).show();
    tr.addClass("shown");
    thisVar.parent().find(".animacion").removeClass("fa-caret-right").addClass("fa-caret-down");
    $("#spiner-loader").addClass("hide");
  }, "json");
}

function buildTableDetailP(data, permisos) {
  var filtered = data.filter(function (value) {
    if (permisos == 2 && value.expediente == "") {
    } else {
      return value;
    }
  });

  var solicitudes = '<table class="table subBoxDetail">';
  solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
  solicitudes += "<td>" + "<b>" + "# " + "</b></td>";
  solicitudes += "<td>" + "<b>" + "DOCUMENTO " + "</b></td>";
  solicitudes += "<td>" + "<b>" + "TIPO DE PRESUPUESTO" + "</b></td>";
  solicitudes += "<td>" + "<b>" + "FECHA " + "</b></td>";
  solicitudes += "<td>" + "<b>" + "ACCIONES " + "</b></td>";
  solicitudes += "</tr>";
  $.each(filtered, function (i, v) {
    //i es el indice y v son los valores de cada fila
    solicitudes += "<tr>";
    solicitudes += "<td> " + (i + 1) + " </td>";
    solicitudes +=
      "<td> " + (permisos == 1 ? v.expediente : "Presupuesto") + " </td>";
    solicitudes += "<td> " + v.nombre + " </td>";
    solicitudes += "<td> " + v.fecha_creacion + "</td>";
    solicitudes += '<td><div class="d-flex justify-center">';
    if (permisos == 1) {
      solicitudes += `<button data-idDocumento="${
        v.idPresupuesto
      }" data-documentType="12" data-presupuestoType="${
        v.tipo
      }" data-idSolicitud=${v.id_solicitud} data-details ="2" data-action=${
        v.expediente == null || v.expediente == "" ? 1 : 2
      } class="btn-data btn-${
        v.expediente == null || v.expediente == "" ? "blueMaderas" : "warning"
      } upload" data-toggle="tooltip" data-placement="left" title=${
        v.expediente == null || v.expediente == "" ? "Cargar" : "Eliminar"
      }>${
        v.expediente == null || v.expediente == ""
          ? '<i class="fas fa-cloud-upload-alt"></i>'
          : '<i class="far fa-trash-alt"></i>'
      }</button>`;
    }
    if (v.expediente == null || v.expediente == "") solicitudes += "";
    else
      solicitudes += `<button id="preview" data-idDocumento="${v.idPresupuesto}" data-doc="${v.expediente}" data-documentType="12" data-presupuestoType="${v.tipo}"  class="btn-data btn-gray" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
    solicitudes += "</div></td></tr>";
  });
  return (solicitudes += "</table>");
}

function getEstatusEscrituracion() {
  $("#spiner-loader").removeClass("hide");
  $("#estatusE").find("option").remove();
  $("#estatusE").append($("<option selected>").val("0").text("Propios"));
  $("#estatusE").append($("<option>").val("1").text("Todos"));
  $("#estatusE").selectpicker("refresh");
  $("#spiner-loader").addClass("hide");
}

function getTipoEscrituracion() {
  $("#spiner-loader").removeClass("hide");
  $("#tipoE").find("option").remove();
  $("#tipoE").append(
    $("<option disabled selected>").val("").text("Seleccione una opción")
  );
  document.getElementById("tipoE").title = "Seleccione una opción";
  $.post(
    "getTipoEscrituracion",
    function (data) {
      var len = data.length;
      for (var i = 0; i < len; i++) {
        var id = data[i]["id_opcion"];
        var name = data[i]["nombre"];
        $("#tipoE").append($("<option>").val(id).text(name));
      }
      if (len <= 0) {
        $("#tipoE").append(
          '<option selected="selected" disabled>No se han encontrado registros que mostrar</option>'
        );
      }
      $("#tipoE").selectpicker("refresh");
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

$(document).on('click', '#informacion', function () {
    var data = escrituracionTable.row($(this).parents('tr')).data();
    getBudgetInformacion(data.id_solicitud);
    $('#idSolicitud').val(data.id_solicitud);
    $("#informacionModal").modal();
});
/**------------ACTUALIZAR VALOR DE OPERACIÓN DE CONTRATO */
$(document).on("click", "#btnValorOper", function () {
  var data = escrituracionTable.row($(this).parents("tr")).data();
  getBudgetInformacion(data.id_solicitud, 1);
  $("#id_solicitudOper").val(data.id_solicitud);
  $("#valorOperModal").modal();
});
$(document).on("submit", "#formValorOperacion", function (e) {
  e.preventDefault();
  let idSolicitud = $("#id_solicitudOper").val();
  let data = new FormData($(this)[0]);
  $.ajax({
    url: "updateValorOper",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (response) {
      alerts.showNotification(
        "top",
        "right",
        "Se actualizó la información.",
        "success"
      );
      $("#valorOperModal").modal("hide");
      escrituracionTable.ajax.reload(null, false);
    },
  });
});
/**------------------------------------------- */
function getBudgetInformacion(idSolicitud, actividad = 0) {
  $("#spiner-loader").removeClass("hide");
  getEstatusPago();
  $.post(
    "getBudgetInformacion",
    {
      idSolicitud: idSolicitud,
    },
    function (data) {
      if (actividad == 1) {
        $("#valorOper").val(`${formatMoney(data.valor_contrato)}`);
      } else {
        if (data.bandera_admin == 1 && data.bandera_comite == 1) {
          $("#RequestInformacion").addClass("hide");
          $("#information_campos").addClass("hide");
          document.getElementById("construccionI").disabled = true;
          document.getElementById("liquidado").disabled = true;
          document.getElementById("tipoContratoAnt").disabled = true;
          document.getElementById("clienteI").disabled = true;
          document.getElementById('nombreI').disabled = true;
          document.getElementById('fechaCAI').disabled = true;
          document.getElementById('rfcDatosI').disabled = true;
          document.getElementById("aportacionesI").disabled = true;
          document.getElementById("descuentosI").disabled = true;
          document.getElementById("motivoI").disabled = true;
        }
        $("#liquidado").val(data.idEstatusPago).trigger("change");
        $("#construccionI").val(data.nombreConst);
        $("#clienteI")
          .val(data.cliente_anterior == 1 ? "uno" : "dos")
          .trigger("change");
        $("#clienteI").selectpicker("refresh");
        $("#tipoContratoAnt").val(data.tipo_contrato_ant).trigger("change");
        $("#tipoContratoAnt").selectpicker('refresh');
        $("#nombreI").val(data.nombre_anterior);
        let fechaAnterior =
          data.fecha_anterior != null
            ? data.fecha_anterior.split(" ")[0].split("-").reverse().join("-")
            : data.fecha_anterior;
        if (fechaAnterior != null)
            $("#fechaCAI").val(fechaAnterior);
        else
            $('#fechaCAI').val(moment().format('DD/MM/YYYY'));
        $("#rfcDatosI").val(data.RFC);
        $("#aportacionesI").val(formatMoney(data.aportacion));
        $("#descuentosI").val(formatMoney(data.descuento));
        $("#motivoI").val(data.motivo);
      }
      $("#spiner-loader").addClass("hide");
    },
    "json"
  );
}

$(document).on("change", "#clienteI", function () {
    if ($(this).val() == 'uno') {
        $('#ifInformacion').show();
        $("#ifInformacion input").attr("required", true);
    } else {
        $('#ifInformacion').hide();
        $("#ifInformacion input").attr("required", false);
        $("#ifInformacion input").val('');
        $('#tipoContratoAnt').val('').trigger('change');
    }
  });

//AGREGAR INFORMACIÓN - ADMIN
$(document).on("submit", "#formInformacion", function (e) {
    e.preventDefault();
    let idSolicitud = $("#idSolicitud").val();
    let data = new FormData($(this)[0]);
    data.append("idSolicitud", idSolicitud);
    data.append("tipoContratoAnt", $("#tipoContratoAnt").val());
    if( $("#clienteI").val() == "uno" ){
      if( $("#tipoContratoAnt").val() != '' ){
        setNewInformacion(data);
      }
      else{
        alerts.showNotification('top', 'right', 'Debes seleccionar el tipo de contrato anterior', 'danger');
      }
    }
    else{
      setNewInformacion(data);
    }
  });

function setNewInformacion(data){
    $.ajax({
        url: "newInformacion",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function (response) {
          alerts.showNotification( "top", "right", "Se agrego la información.", "success");
          $("#informacionModal").modal("hide");
          escrituracionTable.ajax.reload(null, false);
        },
    });
}

//NOTARIA
$(document).on("change", "#not", function () {
  if ($(this).val() == "yes") {
    $("#ifNotaria").show();
  } else {
    $("#ifNotaria").hide();
  }
});

function crearDetailsPresupuestos(data, permisos) {
  let notarias = `<table id="notarias-${data.id_solicitud}" class="table subBoxDetail">`;
  notarias += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
  notarias += "<td>" + "<b>" + "# " + "</b></td>";
  notarias += "<td>" + "<b>" + "NOTAÍA " + "</b></td>";
  notarias += "<td>" + "<b>" + "DESCRIPCIÓN" + "</b></td>";
  notarias += "<td>" + "<b>" + "CARGAR PRESUPUESTOS" + "</b></td>";
  notarias += "</tr>";
  let accion = userType == 55 ? "Ver" : "Subir";
  for (let i = 0; i < 3; i++) {
    notarias += "<tr>";
    notarias += "<td> " + (i + 1) + " </td>";
    notarias += `<td class="d-flex direction-row justify-center align-center"> 
        ${
          permisos == 1
            ? `<select id="notaria-${i}-${data.id_solicitud}" name="notaria" class="selectpicker select-gral m-0 notaria-select" data-style="btn" data-show-subtext="true"
                        data-live-search="true" data-container="body" title="Selecciona una notaría" data-size="7" required></select>`
            : `${data.notarias[i] ? data.notarias[i].nombre_notaria : ""}`
        } </td>`;
    notarias += `<td id="desc">${
      permisos != 1 && data.notarias[i] ? data.notarias[i].direccion : ""
    }</td>`;
    notarias += '<td><div class="d-flex justify-center">';
    notarias += `<button  class="btn-data btn-blueMaderas ${
      data.notarias[i] != undefined ? "modalPresupuestos" : "saveNotaria"
    }" 
        data-idNxS ="${
          data.notarias[i] ? data.notarias[i].idNotariaxSolicitud : null
        }" data-idSolicitud="${data.id_solicitud}" data-toggle="tooltip" 
        data-placement="left" title="${
          data.notarias[i] != undefined
            ? accion + " presupuesto"
            : "Guardar notaria"
        }">${
      data.notarias[i] != undefined
        ? '<i class="fas fa-box-open"></i>'
        : '<i class="far fa-save"></i>'
    }
        </button>`;
    notarias += "</div></td></tr>";
  }
  $("#spiner-loader").addClass("hide");
  getNotarias(data);
  return (notarias += "</table>");
}

async function getDescriptionNotaria(idNotaria) {
  $("#spiner-loader").removeClass("hide");
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "getNotaria",
      data: { idNotaria: idNotaria },
      type: "POST",
      dataType: "json",
      success: function (response) {
        resolve(response[0]);
        $("#spiner-loader").addClass("hide");
      },
    });
  });
}

function saveNotaria(idSolicitud, idNotaria, thisVar) {
  $.ajax({
    url: "saveNotaria",
    data: { idNotaria: idNotaria, idSolicitud: idSolicitud },
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.message) {
        alerts.showNotification("top", "right", response.message, "danger");
        $("#spiner-loader").addClass("hide");
      } else {
        const tr = $(`#treePresupuesto${idSolicitud}`).closest("tr");
        const row = escrituracionTable.row(tr);
        createRowNotarias(row, tr, $(`#trees${idSolicitud}`), idSolicitud);
        $("#spiner-loader").addClass("hide");
      }
    },
  });
}

function buildUploadCards(idNxS) {
  //FUNCIÓN PARA CREAR LOS 3 PRESUPUESTOS POR NOTARIA ESTATUS 13,16 Y 37. PARA MOSTRAR ESTATUS 14, 17 Y 38
  let permisos = $(".treePresupuesto").attr("data-permisos");
  $("#body_uploads").html("");
  $("#spiner-loader").removeClass("hide");
  $.ajax({
    url: "getPresupuestosUpload",
    data: { idNxS: idNxS },
    type: "POST",
    dataType: "json",
    success: function (response) {
      let html = "";
      response.forEach((element) => {
        html += `
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 cardUpload">
                <div class="d-flex direction-column">
                ${
                  element.expediente == ""
                    ? '<div class="d-flex justify-end mb-1"></div>'
                    : element.expediente != "" && permisos == 1
                    ? `<div class="d-flex justify-end mb-1"> <a href="#" title="Borrar" data-details="2" data-toggle="tooltip" data-doc="${element.expediente}" data-action="2" data-idSolicitud=${element.id_solicitud} data-documentType="12" data-idDocumento="${element.idPresupuesto}" data-idPresupuesto= "${element.idPresupuesto}" data-idNxS= "${element.idNotariaxSolicitud}" data-presupuestoType="${element.tipo}" class="far fa-trash-alt text-danger upload"></i></a></div>`
                    : '<div class="d-flex justify-end mb-1"></div>'
                }
                ${
                  element.expediente == "" && permisos == 1
                    ? `<a href="#" title="Subir documento" data-details="2" data-action="1" data-toggle="tooltip" data-idSolicitud=${element.id_solicitud} data-documentType="12" data-idDocumento="${element.idPresupuesto}" data-idPresupuesto= "${element.idPresupuesto}" data-idNxS= "${element.idNotariaxSolicitud}" data-presupuestoType="${element.tipo}" class="fas fa-cloud-upload-alt fs-5 uploadIcon_modal upload"></a>`
                    : element.expediente == "" && permisos != 1
                    ? `<i class="far fa-file-excel nodata_icon fs-5" data-toggle="tooltip" title="Sin documento"></i>`
                    : `<a href="#" id="preview" data-details="2" title="Ver documento" data-doc="${element.expediente}" data-action="2" data-toggle="tooltip" data-idSolicitud=${element.id_solicitud} data-documentType="12" data-idDocumento="${element.idPresupuesto}" data-idPresupuesto= "${element.idPresupuesto}" data-idNxS= "${element.idNotariaxSolicitud}" data-presupuestoType="${element.tipo}" class="far fa-file-pdf fs-5 text-info watchIcon_modal"></a>`
                }
                    <span class="mt-2">Presupuesto</span>
                    <span>${element.nombre}</span>
                </div>
            </div>
            `;
      });
      $("#body_uploads").append(html);
      $("#spiner-loader").addClass("hide");
      $('[data-toggle="tooltip"]').tooltip();
    },
  });
}

function createDocRowOtros(row, tr, thisVar, contador = 0) {
  //FUNCIÓN PARA CREAR ROWDETAILS DE LA ACTIVIDAD APE004 CARGA DE CONTRATO Y OTROS
  var v = 0;
  console.log(row)
  $.post("getDocumentsClient", {
    idEscritura: row.data().id_solicitud,
    idEstatus: row.data().id_estatus,
  }).done(function (data) {
    row.data().solicitudes = JSON.parse(data);
    let estatusAct4 = [3, 4, 6, 8, 10];
    if (estatusAct4.includes(row.data().solicitudes[0].estatus_solicitud)) {
      var index1 = row
        .data()
        .solicitudes.findIndex((e) => e.tipo_documento == 18);
      if (index1 != -1) {
        if (contador == 1) {
          if (row.data().solicitudes[index1].expediente != null) {
            v = 1;
          }
        } else if (contador == 2) {
          if (row.data().solicitudes[index1].expediente == null) {
            v = 1;
          }
        }
      }
    }
    if (v == 1) {
      escrituracionTable.ajax.reload(null, false);
      createDocRowOtros(rowOtros.row, rowOtros.tr, rowOtros.this);
    } else {
      escrituracionTable.row(tr).data(row.data());
      row = escrituracionTable.row(tr);
      row.child(buildTableDetail(row.data().solicitudes, $(".details-control-otros").attr("data-permisos"))).show();
      tr.addClass("shown");
      thisVar.parent().find(".animacion").removeClass("fa-caret-right").addClass("fa-caret-down");
      $("#spiner-loader").addClass("hide");
    }
  });
}

function createDocRowPago(row, tr, thisVar) {
  $.post("getDocumentsClient", {
    idEscritura: row.data().id_solicitud,
    idEstatus: row.data().id_estatus,
  }).done(function (data) {
    row.data().solicitudes = JSON.parse(data);
    escrituracionTable.row(tr).data(row.data());
    row = escrituracionTable.row(tr);
    row.child(buildTableDetail(row.data().solicitudes, $(".details-control-pago").attr("data-permisos"))).show();
    tr.addClass("shown");
    thisVar.parent().find(".animacion").removeClass("fa-caret-right").addClass("fa-caret-down");
    $("#spiner-loader").addClass("hide");
  });
}

// ----------------------------------------------------------------------

$(document).on("click", "#bajarConMotivo", function () {
  idStatus = 1;
  denegarTexto = "";
  let estatus_validacion = 0;
  idDocumento = $(this).attr("data-idDocumento");
  ipOcion = $(this).attr("data-idOpcion");
  opcionEditar = $(this).attr("data-editar");
  estatus = $(this).attr("data-editar");
  index = $(this).attr("data-index");
  proceso = document.querySelector("selectMotivo" + index);
  Motivo = document.getElementById("selectMotivo" + index).value;
  // Dividiendo la cadena "proceso" usando el carácter espacio
  let motivos = Motivo.split("//");
  let estatusValidacion = " ";
  let dataMostrar = " ";
  if (estatus == 1) {
  } else if (estatus == 2) {
  }
  $.ajax({
    url: "validarDocumentoss",
    type: "POST",
    dataType: "json",
    data: {
      proceso: motivos[1],
      motivo: motivos[0],
      estatus_validacion: estatus,
      Iddocumentos: idDocumento,
      idOpcion: ipOcion,
      opcionEditar: opcionEditar,
    },
    success: function (data) {
      document.getElementById("estatusValidacion" + index).innerHTML =
        estatusValidacion;
      if (estatus == 1) {
        estatusVal = "Estatus actual VALIDADO";
        denegarTexto += "";
      } else if (estatus == 2) {
        estatusVal = "Estatus actual DENEGADO";
      } else {
        estatusVal = "Estatus  CARGADO";
      }
      var estatusmensaje = document.getElementById("estatusValidacion" + index);
      document.getElementById("denegarVISTA" + index).innerHTML = dataMostrar;
      document.getElementById("validarVISTA" + index).innerHTML = dataMostrar;
      document.getElementById("opcionesDeRechazo" + index).innerHTML =
        dataMostrar;
      document.getElementById("botonRechazo" + index).innerHTML = dataMostrar;
      estatusValidacion += estatusVal;
      estatusmensaje.innerHTML = estatusValidacion;
      alerts.showNotification(
        "top",
        "right",
        "" + data.message + "",
        "" + data.response_type + ""
      );
    },
    error: (a, b, c) => {
      alerts.showNotification(
        "top",
        "right",
        "Error pruebelo más tarde.",
        "error"
      );
    },
  });
});

$(document).on("click", "#preview", function () {
  var itself = $(this);
  var folder;
  switch (itself.attr('data-documentType')) {
    case '1':
        folder = "INE";
    break;
    case '2':
        folder = "RFC";
    break;
    case '3':
        folder = "COMPROBANTE_DE_DOMICILIO";
    break;
    case '4':
        folder = "ACTA_DE_NACIMIENTO";
    break;
    case '5':
        folder = "ACTA_DE_MATRIMONIO";
    break;
    case '6':
        folder = "CURP";
    break;
    case '7':
        folder = "FORMAS_DE_PAGO";
    break;
    case '8':
        folder = "BOLETA_PREDIAL";
    break;
    case '9':
        folder = "CONSTANCIA_MANTENIMIENTO";
    break;
    case '10':
        folder = "CONSTANCIA_AGUA";
    break;
    case '11':
        folder = "SOLICITUD_PRESUPUESTO";
    break;
    case '12':
        folder = "PRESUPUESTO";
    break;
    case '13':
        folder = "FACTURA";
    break;
    case '14':
        folder = "TESTIMONIO";
    break;
    case '15':
        folder = "PROYECTO_ESCRITURA";
    break;
    case '16':
        folder = "ACTA_CONSTITUTIVA";
    break;
    case '17':
        folder = "OTROS";
    break;
    case '18':
        folder = "CONTRATO";
    break;
    case '19':
        folder = "COPIA_CERTIFICADA";
    break;
    case '20':
        folder = "PRESUPUESTO_NOTARIA_EXTERNA";
    break;
    case '21':
        folder = "RFC_MORAL";
    break;
    case '22':
        folder = "FORMAS_PAGO_FECHA";
    break;
    case '23':
        folder = "CHECK_LIST";
    break; 
    case '24':
        folder = "BENEFICIARIO_CONTROLADOR";
    break; 
    case '25':
        folder = "CARATULAS_BANCARIAS";
    break;  
    case '26':
        folder = "ESTADOS_DE_CUENTA";
    break;
    default:
        break;
}
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;z-index:999999!important;" src="${general_base_url}static/documentos/postventa/escrituracion/${folder}/${itself.attr('data-doc')}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${itself.attr('data-doc')} `,
        width: 985,
        height: 660
    });
});  

$(window).resize(function(){
    escrituracion-datatable.columns.adjust();
    carga-datatable.columns.adjust();
    pausadas_tabla.columns.adjust();
});
