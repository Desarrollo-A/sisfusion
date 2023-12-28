
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
      format: "DD/MM/YYYY LT",
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
          `<div class="col-lg-12" style="padding-left:40px;">
          <li>
            <a style="color:${v.color};">${v.nombre}</a>&nbsp;<a style="color:${v.color}" class="float-right"><b>${fecha_creacion}</b></a><p>${v.descripcion}</p></li>
          </div>`
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

$(document).on("change", "#documents", function () {
  let idDocument = $(this).val();
  displayInput(idDocument);
});

$(document).on("click", "#sendRequestButton2", function (e) {
  $("#spiner-loader").removeClass("hide");
  let uploadedDocument = $("#uploadedDocument2")[0].files[0];
  let validateUploadedDocument = uploadedDocument == undefined ? 0 : 1;
  if (validateUploadedDocument == 0){
    alerts.showNotification(
      "top",
      "right",
      "Asegúrese de haber seleccionado un archivo antes de guardar.",
      "warning"
    );
  }else {
    sendRequestPermission = 1;
  } 

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

let integracionExpediente = new Object(); /////SIRVE
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
          return  `<span class="label lbl-sky">${d.rechazo}</span><span class="label lbl-sky" >${d.vencimiento}</span><br><br>
          <div class="d-flex justify-center"><span class="label ${d.estatusAct == 'RECHAZO' ? 'lbl-warning' : 'lbl-green'}">${d.estatusAct}</span></div>`;
        }
      },
      {
        data: function (d) {
          var group_buttons = '';    //variable para botones que se muestran en el datatable 
          $('[data-toggle="tooltip"]').tooltip();
          group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
          group_buttons += `<button data-idSolicitud=${d.id_solicitud} data-lotes=${d.nombreLote} class="btn-data btn-details-grey comentariosModel" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="HISTORIAL DE COMENTARIOS"><i class="fa fa-history"></i></button>`;
          return '<div class="d-flex justify-center">' + group_buttons + '<div>';
        }
      },
    ],
    columnDefs: [{
      "searchable": true,
      "orderable": false,
      "targets": 0
    }],
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
}

var arrayTables = [
  {'nombreTabla' : 'escrituracion-datatable',
  'data':{},
  'url':'getSolicitudes',
  'numTable':0
}];

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

function getDocumentsClient(idEscritura) {
  $("#spiner-loader").removeClass("hide");
  $("#documents").find("option").remove();
  $("#documents").append(
    $("<option disabled>").val("0").text("Seleccione una opción")
  );
  $.post(
    "getDocumentacionCliente",
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
        }else {
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
        }
      }
      break;
    case 4:
      if (banderaBoton == 1) {
        botones += BtnsAdicionales;
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
    solicitudes += `<td> <span class="label" style="background:${v.colour}">${v.estatus_validacion}</span>${v.editado == 1 ? `<br><br><span class="label" style="background:#C0952B">EDITADO</span>`:``} </td>`;
    solicitudes += '<td><div class="d-flex justify-center">';
    
    if (v.expediente == null || v.expediente == ''){
      solicitudes +=  `<span class="label lbl-gray"> No se ha cargado el archivo </span>`;
    } else{
      //BOTON PARA VISUALIZAR CADA ARCHIVO
      let expe = v.tipo_documento == 12 ? v.movimiento : v.expediente;
      solicitudes +=  `<button id="preview" data-documentType="${v.tipo_documento}" data-doc="${expe}" class="btn-data btn-gray" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
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
    }
    solicitudes += '</div></td></tr>';
  });
  return solicitudes += '</table>';
}

function createDocRow(row, tr, thisVar) { ///SIRVE
  $.post("getDocumentacionCliente", {
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

function createDocRowOtros(row, tr, thisVar, contador = 0) {
  var v = 0;
  $.post("getDocumentacionCliente", {  
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

function createDocRowOtros(row, tr, thisVar, contador = 0) {
  //FUNCIÓN PARA CREAR ROWDETAILS DE LA ACTIVIDAD APE004 CARGA DE CONTRATO Y OTROS
  var v = 0;
  $.post("getDocumentacionCliente", {  
    idEscritura: row.data().id_solicitud
  })
  .done(function (data) {
    row.data().solicitudes = JSON.parse(data);
    //let estatusAct4 = [3, 4, 6, 8, 10];
    escrituracionTable.ajax.reload(null, false);
    createDocRowOtros(rowOtros.row, rowOtros.tr, rowOtros.this);
    
    escrituracionTable.row(tr).data(row.data());
    row = escrituracionTable.row(tr);
    row.child(buildTableDetail(row.data().solicitudes, $(".details-control-otros").attr("data-permisos"))).show();
    tr.addClass("shown");
    thisVar.parent().find(".animacion").removeClass("fa-caret-right").addClass("fa-caret-down");
    $("#spiner-loader").addClass("hide");
  });
}

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