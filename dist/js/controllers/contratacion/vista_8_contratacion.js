var getInfo1 = new Array(7);
var getInfo2 = new Array(7);
var getInfo3 = new Array(7);
var getInfo4 = new Array(7);
var getInfo5 = new Array(7);
var getInfo6 = new Array(7);

let titulos = [];
$(document).ready(function () {
  $("#Jtabla thead tr:eq(0) th").each(function (i) {
    if (i != 0) {
      var title = $(this).text();
      titulos.push(title);
      $(this).html(
        '<input class="textoshead" type="text" data-toggle="tooltip" data-placement="top" title="' +
          title +
          '" placeholder="' +
          title +
          '"/>'
      );
      $("input", this).on("keyup change", function () {
        if (tabla_6.column(i).search() !== this.value) {
          tabla_6.column(i).search(this.value).draw();
        }
      });
    }
  });

  tabla_6 = $("#Jtabla").DataTable({
    dom:
      "Brt" +
      "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: "100%",
    scrollX: true,
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: "btn buttons-excel",
        filename: "Registro de Estatus 8",
        titleAttr: "Descargar archivo de Excel",
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
          format: {
            header: function (d, columnIdx) {
              return " " + titulos[columnIdx - 1] + " ";
            },
          },
        },
      },
    ],
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
      url: `${general_base_url}static/spanishLoader_v2.json`,
      paginate: {
        previous: "<i class='fa fa-angle-left'>",
        next: "<i class='fa fa-angle-right'>",
      },
    },
    destroy: true,
    ordering: false,
    columns: [
      {
        className: "details-control",
        orderable: false,
        data: null,
        defaultContent:
          '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>',
      },
      {
        data: function (d) {
          return `<span class="label lbl-green">${d.tipo_venta}</span>`;
        },
      },
      {
        data: function (d) {
          return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreResidencial + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreCondominio.toUpperCase();
          +"</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreLote + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.gerente + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreCliente + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.descripcion + "</p>";
        },
      },

      {
        data: function (d) {
          return `<span class="label lbl-azure">${d.nombreSede}</span>`;
        },
      },
      {
        orderable: false,
        data: function (data) {
          if (
            id_rol_general != 53 &&
            id_rol_general != 54 &&
            id_rol_general != 63
          ) {
            // ANALISTA DE COMISIONES Y SUBDIRECTOR CONSULTA (POPEA)

            var cntActions;
            if (data.vl == "1") {
              cntActions = "EN PROCESO DE LIBERACIÓN";
            } else {
              if (
                data.idStatusContratacion == 7 &&
                data.idMovimiento == 64 &&
                (data.perfil == 32 ||
                  data.perfil == 13 ||
                  data.perfil == 17 ||
                  data.perfil == 70)
              ) {
                cntActions =
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '" ' +
                  'class="btn-data btn-orangeYellow editReg2" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                  '<i class="far fa-thumbs-up"></i></button>';

                cntActions +=
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '"  ' +
                  'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                  '<i class="far fa-thumbs-down"></i></button>';

                cntActions +=
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '" ' +
                  'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                  '<i class="far fa-thumbs-down"></i></button>';
              } else if (
                (data.idStatusContratacion == 7 &&
                  data.idMovimiento == 37 &&
                  data.perfil == 15) ||
                (data.idStatusContratacion == 7 &&
                  data.idMovimiento == 7 &&
                  data.perfil == 15) ||
                (data.idStatusContratacion == 7 &&
                  data.idMovimiento == 77 &&
                  data.perfil == 15) ||
                (data.idStatusContratacion == 11 &&
                  data.idMovimiento == 41 &&
                  data.perfil == 11)
              ) {
                cntActions =
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '" ' +
                  'class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                  '<i class="far fa-thumbs-up"></i></button>';

                cntActions +=
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '"  ' +
                  'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                  '<i class="far fa-thumbs-down"></i></button>';

                cntActions +=
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '" ' +
                  'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                  '<i class="far fa-thumbs-down"></i></button>';
              } else if (
                data.idStatusContratacion == 7 &&
                data.idMovimiento == 66 &&
                data.perfil == 11
              ) {
                cntActions =
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '" ' +
                  'class="btn-data btn-violetBoots editLoteTo8" data-toggle="tooltip" data-placement="top" title="REGISTRAR ESTATUS">' +
                  '<i class="far fa-thumbs-up"></i></button>';

                cntActions +=
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '"  ' +
                  'class="btn-data btn-warning cancelReg" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (JURÍDICO)">' +
                  '<i class="far fa-thumbs-down"></i></button>';

                cntActions +=
                  '<button href="#" data-idLote="' +
                  data.idLote +
                  '" data-nomLote="' +
                  data.nombreLote +
                  '" data-idCond="' +
                  data.idCondominio +
                  '"' +
                  'data-idCliente="' +
                  data.id_cliente +
                  '" data-fecVen="' +
                  data.fechaVenc +
                  '" data-ubic="' +
                  data.ubicacion +
                  '" data-code="' +
                  data.cbbtton +
                  '" ' +
                  'class="btn-data btn-orangeYellow cancelAs" data-toggle="tooltip" data-placement="top" title="RECHAZO/REGRESO ESTATUS (ASESOR)">' +
                  '<i class="far fa-thumbs-down"></i></button>';
              } else {
                cntActions = "N/A";
              }
            }
            return (
              '<div class="d-flex justify-center">' + cntActions + "</div>"
            );
          } else {
            return `<span class="label lbl-warning">N/A</span>`;
          }
        },
      },
    ],
    columnDefs: [
      {
        searchable: false,
        orderable: false,
        targets: 0,
      },
    ],
    ajax: {
      url: `${general_base_url}Asistente_gerente/getStatus8ContratacionAsistentes`,
      dataSrc: "",
      type: "POST",
      cache: false,
    },
  });

  $("#Jtabla").on("draw.dt", function () {
    $('[data-toggle="tooltip"]').tooltip({
      trigger: "hover",
    });
  });

  const idStatusContratacion = [7, 11];
  const idMovimiento = [7, 37, 64, 66, 77, 41];

  $("#Jtabla tbody").on("click", "td.details-control", function () {
    var tr = $(this).closest("tr");
    var row = tabla_6.row(tr);

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass("shown");
      $(this)
        .parent()
        .find(".animacion")
        .removeClass("fas fa-chevron-up")
        .addClass("fas fa-chevron-down");
    } else {
      var status;
      var fechaVenc;

      if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 37
      ) {
        status = "ESTATUS 7 LISTO (JURÍDICO)";
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 7
      ) {
        status = "ESTATUS 7 LISTO CON MODIFICACIONES (JURÍDICO)";
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 64
      ) {
        status = "ESTATUS 8 RECHAZADO (CONTRALORIA)";
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 66
      ) {
        status = "ESTATUS 8 RECHAZADO (ADMINISTRACIÓN)";
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 77
      ) {
        status = "ESTATUS 2 ENVIADO REVISIÓN (VENTAS)";
      } else if (
        row.data().idStatusContratacion == 11 &&
        row.data().idMovimiento == 41
      ) {
        status = "ESTATUS 11 VALIDACIÓN DE ENGANCHE (ADMINISTRACIÓN)";
      }

      if (
        (row.data().idStatusContratacion == 7 &&
          row.data().idMovimiento == 37) ||
        (row.data().idStatusContratacion == 7 &&
          row.data().idMovimiento == 7) ||
        (row.data().idStatusContratacion == 7 &&
          row.data().idMovimiento == 64) ||
        (row.data().idStatusContratacion == 7 && row.data().idMovimiento == 77)
      ) {
        fechaVenc = row.data().fechaVenc;
      } else if (
        row.data().idStatusContratacion == 7 &&
        row.data().idMovimiento == 66
      ) {
        fechaVenc = "VENCIDO";
      }

      var informacion_adicional =
        '<div class="container subBoxDetail bottom"><div class="row">' +
        '<div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px">' +
        "<label><b>INFORMACIÓN ADICIONAL</b></label>" +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Estatus: </b>" +
        status +
        "</label>" +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Comentario: </b>" +
        row.data().comentario +
        "</label>" +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Fecha de vencimiento: </b>" +
        fechaVenc +
        "</label>" +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Fecha de realizado: </b>" +
        row.data().modificado +
        "</label> " +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Coordinador: </b>" +
        row.data().coordinador +
        "</label> " +
        "</div>" +
        '<div class="col-12 col-sm-12 col-md-12 col-lg-12">' +
        "<label><b>Asesor: </b>" +
        row.data().asesor +
        "</label>" +
        "</div>" +
        "</div>" +
        "</div>";

      row.child(informacion_adicional).show();
      tr.addClass("shown");
      $(this)
        .parent()
        .find(".animacion")
        .removeClass("fas fa-chevron-down")
        .addClass("fas fa-chevron-up");
    }
  });

  $("#Jtabla tbody").on("click", ".editReg", function (e) {
    e.preventDefault();
    getInfo1[0] = $(this).attr("data-idCliente");
    getInfo1[1] = $(this).attr("data-nombreResidencial");
    getInfo1[2] = $(this).attr("data-nombreCondominio");
    getInfo1[3] = $(this).attr("data-idcond");
    getInfo1[4] = $(this).attr("data-nomlote");
    getInfo1[5] = $(this).attr("data-idLote");
    getInfo1[6] = $(this).attr("data-fecven");
    getInfo1[7] = $(this).attr("data-code");
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $("#editReg").modal("show");
  });

  $("#Jtabla tbody").on("click", ".editLoteRev", function (e) {
    e.preventDefault();
    getInfo2[0] = $(this).attr("data-idCliente");
    getInfo2[1] = $(this).attr("data-nombreResidencial");
    getInfo2[2] = $(this).attr("data-nombreCondominio");
    getInfo2[3] = $(this).attr("data-idcond");
    getInfo2[4] = $(this).attr("data-nomlote");
    getInfo2[5] = $(this).attr("data-idLote");
    getInfo2[6] = $(this).attr("data-fecven");
    getInfo2[7] = $(this).attr("data-code");
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $("#editLoteRev").modal("show");
  });

  $("#Jtabla tbody").on("click", ".cancelReg", function (e) {
    e.preventDefault();
    getInfo3[0] = $(this).attr("data-idCliente");
    getInfo3[1] = $(this).attr("data-nombreResidencial");
    getInfo3[2] = $(this).attr("data-nombreCondominio");
    getInfo3[3] = $(this).attr("data-idcond");
    getInfo3[4] = $(this).attr("data-nomlote");
    getInfo3[5] = $(this).attr("data-idLote");
    getInfo3[6] = $(this).attr("data-fecven");
    getInfo3[7] = $(this).attr("data-code");
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $("#rechReg").modal("show");
  });

  $("#Jtabla tbody").on("click", ".cancelAs", function (e) {
    e.preventDefault();
    getInfo4[0] = $(this).attr("data-idCliente");
    getInfo4[1] = $(this).attr("data-nombreResidencial");
    getInfo4[2] = $(this).attr("data-nombreCondominio");
    getInfo4[3] = $(this).attr("data-idcond");
    getInfo4[4] = $(this).attr("data-nomlote");
    getInfo4[5] = $(this).attr("data-idLote");
    getInfo4[6] = $(this).attr("data-fecven");
    getInfo4[7] = $(this).attr("data-code");
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $("#rechazoAs").modal("show");
  });

  $("#Jtabla tbody").on("click", ".editLoteTo8", function (e) {
    e.preventDefault();
    getInfo5[0] = $(this).attr("data-idCliente");
    getInfo5[1] = $(this).attr("data-nombreResidencial");
    getInfo5[2] = $(this).attr("data-nombreCondominio");
    getInfo5[3] = $(this).attr("data-idcond");
    getInfo5[4] = $(this).attr("data-nomlote");
    getInfo5[5] = $(this).attr("data-idLote");
    getInfo5[6] = $(this).attr("data-fecven");
    getInfo5[7] = $(this).attr("data-code");
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $("#rev8").modal("show");
  });

  $("#Jtabla tbody").on("click", ".editReg2", function (e) {
    e.preventDefault();
    getInfo6[0] = $(this).attr("data-idCliente");
    getInfo6[1] = $(this).attr("data-nombreResidencial");
    getInfo6[2] = $(this).attr("data-nombreCondominio");
    getInfo6[3] = $(this).attr("data-idcond");
    getInfo6[4] = $(this).attr("data-nomlote");
    getInfo6[5] = $(this).attr("data-idLote");
    getInfo6[6] = $(this).attr("data-fecven");
    getInfo6[7] = $(this).attr("data-code");
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $("#rev_2").modal("show");
  });
});

$(document).on("click", "#save1", function (e) {
  e.preventDefault();
  var comentario = $("#comentario").val();
  var validaComent = $("#comentario").val().length == 0 ? 0 : 1;
  var dataExp1 = new FormData();
  dataExp1.append("idCliente", getInfo1[0]);
  dataExp1.append("nombreResidencial", getInfo1[1]);
  dataExp1.append("nombreCondominio", getInfo1[2]);
  dataExp1.append("idCondominio", getInfo1[3]);
  dataExp1.append("nombreLote", getInfo1[4]);
  dataExp1.append("idLote", getInfo1[5]);
  dataExp1.append("comentario", comentario);
  dataExp1.append("fechaVenc", getInfo1[6]);
  dataExp1.append("numContrato", getInfo1[7]);

  if (validaComent == 0)
    alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

  if (validaComent == 1) {
    $("#save1").prop("disabled", true);
    $.ajax({
      url: `${general_base_url}Asistente_gerente/editar_registro_lote_asistentes_proceceso8`,
      data: dataExp1,
      cache: false,
      contentType: false,
      processData: false,
      type: "POST",
      success: function (data) {
        response = JSON.parse(data);
        if (response.message == "OK") {
          $("#save1").prop("disabled", false);
          $("#editReg").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Estatus enviado.",
            "success"
          );
        } else if (response.message == "MISSING_COMPLEMENTO_DE_ENGANCHE") {
          $("#save1").prop("disabled", false);
          $("#editReg").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Primero debes cargar el COMPLEMENTO DE ENGANCHE para" +
              " poder avanzar el lote",
            "danger"
          );
        } else if (response.message == "MISSING_CARTA_UPLOAD") {
          $("#save1").prop("disabled", false);
          $("#editReg").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Primero debes subir la Carta de Domicilio CM antes de avanzar el expediente",
            "danger"
          );
        } else if (response.message == "FALSE") {
          $("#save1").prop("disabled", false);
          $("#editReg").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "El status ya fue registrado.",
            "danger"
          );
        } else if (response.message == "ERROR") {
          $("#save1").prop("disabled", false);
          $("#editReg").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Error al enviar la solicitud.",
            "danger"
          );
        }
      },
      error: function (data) {
        $("#save1").prop("disabled", false);
        $("#editReg").modal("hide");
        $("#Jtabla").DataTable().ajax.reload();
        alerts.showNotification(
          "top",
          "right",
          "Error al enviar la solicitud.",
          "danger"
        );
      },
    });
  }
});

$(document).on("click", "#save3", function (e) {
  e.preventDefault();
  var comentario = $("#comentario3").val();
  var validaComent = $("#comentario3").val().length == 0 ? 0 : 1;
  var dataExp3 = new FormData();
  dataExp3.append("idCliente", getInfo3[0]);
  dataExp3.append("nombreResidencial", getInfo3[1]);
  dataExp3.append("nombreCondominio", getInfo3[2]);
  dataExp3.append("idCondominio", getInfo3[3]);
  dataExp3.append("nombreLote", getInfo3[4]);
  dataExp3.append("idLote", getInfo3[5]);
  dataExp3.append("comentario", comentario);
  dataExp3.append("fechaVenc", getInfo3[6]);
  dataExp3.append("numContrato", getInfo3[7]);
  if (validaComent == 0)
    alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

  if (validaComent == 1) {
    $("#save3").prop("disabled", true);
    $.ajax({
      url: `${general_base_url}Asistente_gerente/editar_registro_loteRechazo_asistentes_proceceso8`,
      data: dataExp3,
      cache: false,
      contentType: false,
      processData: false,
      type: "POST",
      success: function (data) {
        response = JSON.parse(data);
        if (response.message == "OK") {
          $("#save3").prop("disabled", false);
          $("#rechReg").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Estatus enviado.",
            "success"
          );
        } else if (response.message == "FALSE") {
          $("#save3").prop("disabled", false);
          $("#rechReg").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "El status ya fue registrado.",
            "danger"
          );
        } else if (response.message == "ERROR") {
          $("#save3").prop("disabled", false);
          $("#rechReg").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Error al enviar la solicitud.",
            "danger"
          );
        }
      },
      error: function (data) {
        $("#save3").prop("disabled", false);
        $("#rechReg").modal("hide");
        $("#Jtabla").DataTable().ajax.reload();
        alerts.showNotification(
          "top",
          "right",
          "Error al enviar la solicitud.",
          "danger"
        );
      },
    });
  }
});

$(document).on("click", "#save4", function (e) {
  e.preventDefault();
  var comentario = $("#comentario4").val();
  var validaComent = $("#comentario4").val().length == 0 ? 0 : 1;
  var dataExp4 = new FormData();
  dataExp4.append("idCliente", getInfo4[0]);
  dataExp4.append("nombreResidencial", getInfo4[1]);
  dataExp4.append("nombreCondominio", getInfo4[2]);
  dataExp4.append("idCondominio", getInfo4[3]);
  dataExp4.append("nombreLote", getInfo4[4]);
  dataExp4.append("idLote", getInfo4[5]);
  dataExp4.append("comentario", comentario);
  dataExp4.append("fechaVenc", getInfo4[6]);
  dataExp4.append("numContrato", getInfo4[7]);
  if (validaComent == 0)
    alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

  if (validaComent == 1) {
    $("#save4").prop("disabled", true);
    $.ajax({
      url: `${general_base_url}Asistente_gerente/editar_registro_loteRechazoAstatus2_asistentes_proceceso8/`,
      data: dataExp4,
      cache: false,
      contentType: false,
      processData: false,
      type: "POST",
      success: function (data) {
        response = JSON.parse(data);
        if (response.message == "OK") {
          $("#save4").prop("disabled", false);
          $("#rechazoAs").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Estatus enviado.",
            "success"
          );
        } else if (response.message == "FALSE") {
          $("#save4").prop("disabled", false);
          $("#rechazoAs").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "El status ya fue registrado.",
            "danger"
          );
        } else if (response.message == "ERROR") {
          $("#save4").prop("disabled", false);
          $("#rechazoAs").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Error al enviar la solicitud.",
            "danger"
          );
        }
      },
      error: function (data) {
        $("#save4").prop("disabled", false);
        $("#rechazoAs").modal("hide");
        $("#Jtabla").DataTable().ajax.reload();
        alerts.showNotification(
          "top",
          "right",
          "Error al enviar la solicitud.",
          "danger"
        );
      },
    });
  }
});

$(document).on("click", "#save5", function (e) {
  e.preventDefault();
  var comentario = $("#comentario5").val();
  var validaComent = $("#comentario5").val().length == 0 ? 0 : 1;
  var dataExp5 = new FormData();
  dataExp5.append("idCliente", getInfo5[0]);
  dataExp5.append("nombreResidencial", getInfo5[1]);
  dataExp5.append("nombreCondominio", getInfo5[2]);
  dataExp5.append("idCondominio", getInfo5[3]);
  dataExp5.append("nombreLote", getInfo5[4]);
  dataExp5.append("idLote", getInfo5[5]);
  dataExp5.append("comentario", comentario);
  dataExp5.append("fechaVenc", getInfo5[6]);
  dataExp5.append("numContrato", getInfo5[7]);
  if (validaComent == 0)
    alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");

  if (validaComent == 1) {
    $("#save5").prop("disabled", true);
    $.ajax({
      url: `${general_base_url}Asistente_gerente/editar_registro_loteRevision_asistentesAadministracion11_proceceso8/`,
      data: dataExp5,
      cache: false,
      contentType: false,
      processData: false,
      type: "POST",
      success: function (data) {
        response = JSON.parse(data);
        if (response.message == "OK") {
          $("#save5").prop("disabled", false);
          $("#rev8").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Estatus enviado.",
            "success"
          );
        } else if (response.message == "FALSE") {
          $("#save5").prop("disabled", false);
          $("#rev8").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "El status ya fue registrado.",
            "danger"
          );
        } else if (response.message == "MISSING_CARTA_UPLOAD") {
          $("#save5").prop("disabled", false);
          $("#rev8").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Primero debes subir la Carta de Domicilio CM antes de avanzar el expediente",
            "danger"
          );
        } else if (response.message == "ERROR") {
          $("#save5").prop("disabled", false);
          $("#rev8").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Error al enviar la solicitud.",
            "danger"
          );
        }
      },
      error: function (data) {
        $("#save5").prop("disabled", false);
        $("#rev8").modal("hide");
        $("#Jtabla").DataTable().ajax.reload();
        alerts.showNotification(
          "top",
          "right",
          "Error al enviar la solicitud.",
          "danger"
        );
      },
    });
  }
});

$(document).on("click", "#save6", function (e) {
  e.preventDefault();
  var comentario = $("#comentario6").val();
  var validaComent = $("#comentario6").val().length == 0 ? 0 : 1;
  var dataExp6 = new FormData();
  dataExp6.append("idCliente", getInfo6[0]);
  dataExp6.append("nombreResidencial", getInfo6[1]);
  dataExp6.append("nombreCondominio", getInfo6[2]);
  dataExp6.append("idCondominio", getInfo6[3]);
  dataExp6.append("nombreLote", getInfo6[4]);
  dataExp6.append("idLote", getInfo6[5]);
  dataExp6.append("comentario", comentario);
  dataExp6.append("fechaVenc", getInfo6[6]);
  dataExp6.append("numContrato", getInfo6[7]);

    if (validaComent == 0)
      alerts.showNotification(
        "top",
        "right",
        "Ingresa un comentario.",
        "danger"
      );

    if (validaComent == 1) {
      $("#save6").prop("disabled", true);
      $.ajax({
        url: `${general_base_url}Asistente_gerente/editar_registro_loteRevision_asistentes_proceceso8`,
        data: dataExp6,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function (data) {
          response = JSON.parse(data);
          if (response.message == "OK") {
            $("#save6").prop("disabled", false);
            $("#rev_2").modal("hide");
            $("#Jtabla").DataTable().ajax.reload();
            alerts.showNotification(
              "top",
              "right",
              "Estatus enviado.",
              "success"
            );

          } else if (response.message == "MISSING_COMPLEMENTO_DE_ENGANCHE") {
            $("#save6").prop("disabled", false);
            $("#rev_2").modal("hide");
            $("#Jtabla").DataTable().ajax.reload();
            alerts.showNotification(
              "top",
              "right",
              "Primero debes cargar el COMPLEMENTO DE ENGANCHE para" +
                " poder avanzar el lote",
              "danger"
            );
          } else if (response.message == "FALSE") {
            $("#save6").prop("disabled", false);
            $("#rev_2").modal("hide");
            $("#Jtabla").DataTable().ajax.reload();
            alerts.showNotification(
              "top",
              "right",
              "El status ya fue registrado.",
              "danger"
            );
          } else if (response.message == "ERROR") {
            $("#save6").prop("disabled", false);
            $("#rev_2").modal("hide");
            $("#Jtabla").DataTable().ajax.reload();
            alerts.showNotification(
              "top",
              "right",
              "Error al enviar la solicitud.",
              "danger"
            );
          }
        },
        error: function (data) {
          $("#save6").prop("disabled", false);
          $("#rev_2").modal("hide");
          $("#Jtabla").DataTable().ajax.reload();
          alerts.showNotification(
            "top",
            "right",
            "Error al enviar la solicitud.",
            "danger"
          );
        },
      });
    }
});

jQuery(document).ready(function () {
  jQuery("#editReg").on("hidden.bs.modal", function (e) {
    jQuery(this).removeData("bs.modal");
    jQuery(this).find("#comentario").val("");
  });

  jQuery("#editLoteRev").on("hidden.bs.modal", function (e) {
    jQuery(this).removeData("bs.modal");
    jQuery(this).find("#comentario2").val("");
  });

  jQuery("#rechReg").on("hidden.bs.modal", function (e) {
    jQuery(this).removeData("bs.modal");
    jQuery(this).find("#comentario3").val("");
  });

  jQuery("#rechazoAs").on("hidden.bs.modal", function (e) {
    jQuery(this).removeData("bs.modal");
    jQuery(this).find("#comentario4").val("");
  });

  jQuery("#rev8").on("hidden.bs.modal", function (e) {
    jQuery(this).removeData("bs.modal");
    jQuery(this).find("#comentario5").val("");
  });

  jQuery("#rev_2").on("hidden.bs.modal", function (e) {
    jQuery(this).removeData("bs.modal");
    jQuery(this).find("#comentario6").val("");
  });
});
