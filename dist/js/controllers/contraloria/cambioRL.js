var idLote = 0;
let titulos_intxt = [];

$(document).ready(function () {

  $.post(`${general_base_url}Contraloria/selectRL`, function (data) {
    for (var i = 0; i < data.length; i++) {
      $("#rl").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
    }
    $("#rl").selectpicker('refresh');
  }, 'json');

  $.post(`${general_base_url}Contraloria/selectSede`, function (data) {
    for (var i = 0; i < data.length; i++) {
      $("#sede").append($('<option>').val(data[i]['id_sede']).text(data[i]['nombre']));
    }
    $("#sede").selectpicker('refresh');
  }, 'json');

  $.post(`${general_base_url}Contraloria/selectStatusLote`, function (data) {
    for (var i = 0; i < data.length; i++) {
      $("#lote").append($('<option>').val(data[i]['idStatusLote']).text(data[i]['nombre']));
    }
    $("#lote").selectpicker('refresh');
  }, 'json');

});

$("#tabla_RL thead tr:eq(0) th").each(function (i) {
  var title = $(this).text();
  titulos_intxt.push(title);
  $(this).html(
    '<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' +
    title +
    '" placeholder="' +
    title +
    '"/>'
  );
  $("input", this).on("keyup change", function () {
    if ($("#tabla_RL").DataTable().column(i).search() !== this.value) {
      $("#tabla_RL").DataTable().column(i).search(this.value).draw();
    }
  });
});

$("#one").click(function () {
  $("#Rl_form").removeClass("hide");
  $("#save").removeClass("hide");
  $("#Sede_form").addClass("hide");
  $("#save2").addClass("hide");
  $("#Lote_form").addClass("hide");
  $("#save3").addClass("hide");
  $("#Comision_form").addClass("hide");
  $("#save4").addClass("hide");
});

$("#two").click(function () {
  $("#Rl_form").addClass("hide");
  $("#save").addClass("hide");
  $("#Sede_form").removeClass("hide");
  $("#save2").removeClass("hide");
  $("#Lote_form").addClass("hide");
  $("#save3").addClass("hide");
  $("#Comision_form").addClass("hide");
  $("#save4").addClass("hide");
});

$("#three").click(function () {
  $("#Rl_form").addClass("hide");
  $("#save").addClass("hide");
  $("#Sede_form").addClass("hide");
  $("#save2").addClass("hide");
  $("#Lote_form").removeClass("hide");
  $("#save3").removeClass("hide");
  $("#Comision_form").addClass("hide");
  $("#save4").addClass("hide");
});

$("#four").click(function () {
  $("#Rl_form").addClass("hide");
  $("#save").addClass("hide");
  $("#Sede_form").addClass("hide");
  $("#save2").addClass("hide");
  $("#Lote_form").addClass("hide");
  $("#save3").addClass("hide");
  $("#Comision_form").removeClass("hide");
  $("#save4").removeClass("hide");
});

let titulosInventario = [];
$('#tableLotificacionNeodata thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosInventario.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);                       
    $('input', this).on('keyup change', function () {
        if ($('#tableLotificacionNeodata').DataTable().column(i).search() !== this.value) {
            $('#tableLotificacionNeodata').DataTable().column(i).search(this.value).draw();
        }
    });
});

var getInfo1 = new Array(8);
$(".find_doc").click(function () {
  $("#spiner-loader").removeClass("hide");
  $("#tabla_RL").removeClass("hide");
  var idLote = $("#inp_lote").val();

  tabla = $("#tabla_RL").DataTable({
    dom:
      "Brt" +
      "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: "100%",
    scrollX: true,
    ajax: {
      url: `${general_base_url}Contraloria/getCambioRLContraloria/` + idLote,
      dataSrc: "",
    },
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: "btn buttons-excel",
        titleAttr: "MADERAS CRM CAMBIO RL",
        title: "MADERAS CRM CAMBIO RL",
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
          format: {
            header: function (d, columnIdx) {
              return " " + titulosInventario[columnIdx - 1] + " ";
            },
          },
        },
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
        className: "btn buttons-pdf",
        titleAttr: "MADERAS CRM CAMBIO RL",
        title: "MADERAS CRM CAMBIO RL",
        orientation: "landscape",
        pageSize: "LEGAL",
        exportOptions: {
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
          format: {
            header: function (d, columnIdx) {
              return " " + titulosInventario[columnIdx - 1] + " ";
            },
          },
        },
      },
    ],
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
      url: general_base_url + "/static/spanishLoader_v2.json",
      paginate: {
        previous: "<i class='fa fa-angle-left'>",
        next: "<i class='fa fa-angle-right'>",
      },
    },
    pageLength: 10,
    fixedColumns: true,
    ordering: false,
    scrollX: true,
    columns: [
      {
        data: function (d) {
          return `<span class="label lbl-green">${d.tipo_venta}</span>`;
        },
      },
      {
        data: function (d) {
          return `<span class="label lbl-violetBoots">${d.tipo_proceso}</span>`;
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreResidencial + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreCondominio.toUpperCase() + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.nombreLote + "</p>";
        },
      },
      {
        data: function (d) {
          return (
            '<p class="m-0">' +
            d.nombre +
            " " +
            d.apellido_paterno +
            " " +
            d.apellido_materno +
            "</p>"
          );
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.gerente + "</p>";
        },
      },
      {
        data: function (d) {
          let respuesta = "";
          if (d.residencia == 0 || d.residencia == null)
            respuesta = '<p class="m-0">NACIONAL</p>';
          else respuesta = '<p class="m-0">EXTRANJERO</p>';
          return respuesta;
        },
      },
      {
        data: function (d) {
          return `<span class="label lbl-azure">${d.nombreSede}</span>`;
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.representanteLegal + "</p>";
        },
      },
      {
        data: function (d) {
          return '<p class="m-0">' + d.estatusLote + "</p>";
        },
      },
      {
        orderable: false,
        data: function (d) {
          let bt = ``;
          bt =
            '<button href="#" data-idLote="' +
            d.idLote +
            '" data-nomLote="' +
            d.nombreLote +
            '" data-representanteLegal="' +
            d.representanteLegal +
            '" data-idRL="' +
            d.id_rl +
            '" data-idCliente="' +
            d.id_cliente +
            '" data-sede="' +
            d.nombreSede +
            '" data-idUbicacion="' +
            d.ubicacion +
            '" data-estatusLote="' +
            d.estatusLote +
            '" data-idEstatusLote="' +
            d.idEstatusLote +
            '" class="btn-data btn-green editReg" data-toggle="tooltip" data-placement="left" title="EDITAR INFORMACIÓN">' +
            '<i class="fas fa-pencil-alt"></i></button>';
          return '<div class="d-flex justify-center">' + bt + "</div>";
        },
      },
    ],
    columnDefs: [
      {
        defaultContent: "Sin especificar",
        targets: "_all",
        searchable: true,
        orderable: false,
      },
    ],
    order: [[1, "asc"]],
    initComplete: function () {
      $('[data-toggle="tooltip"]').tooltip();
      $("#spiner-loader").addClass("hide");
    },
  });

  $.ajax({
    url: `${general_base_url}/Contraloria/get_comisiones/` + idLote,
    type: "post",
    dataType: "json",
    success: function (data) {
        if (data.message == "OK") {
          $("#four").removeClass("hide");
          $("#titCM").removeClass("hide");

          $("#idCom").val(data[0].id_comision);
          
        }
    },
    error: function (data) {
      console.log('error');
    }
  })

  $("#tabla_RL").on("draw.dt", function () {
    $('[data-toggle="tooltip"]').tooltip({
      trigger: "hover",
    });
  });

  $("#tabla_RL tbody").on("click", ".editReg", function (e) {
    e.preventDefault();

    getInfo1[0] = $(this).attr("data-idLote");
    getInfo1[1] = $(this).attr("data-tipoProceso");
    getInfo1[2] = $(this).attr("data-idRL");
    getInfo1[3] = $(this).attr("data-representanteLegal").toUpperCase();
    getInfo1[4] = $(this).attr("data-idCliente");
    getInfo1[5] = $(this).attr("data-sede").toUpperCase();
    getInfo1[6] = $(this).attr("data-idubicacion");
    getInfo1[7] = $(this).attr("data-estatusLote");
    getInfo1[8] = $(this).attr("data-idestatuslote");
    nombreLote = $(this).data("nomlote");
    $(".lote").html(nombreLote);
    $("#editReg").modal("show");

    $("#rl").val(getInfo1[2]).selectpicker("refresh");
    $("#sede").val(getInfo1[6]).selectpicker("refresh");
    $("#lote").val(getInfo1[8]).selectpicker("refresh");

    if (getInfo1[8] == 6 || getInfo1[8] == 9) {
      $("#three").removeClass("hide");
      $("#titEL").removeClass("hide");
    }

  });

  $(window).resize(function () {
    tabla.columns.adjust();
  });
});

$(document).on("click", "#save", function (e) {
  e.preventDefault();
  var rl = $("#rl").val();
  var dataExp1 = new FormData();
  dataExp1.append("idCliente", getInfo1[4]);
  dataExp1.append("idLote", getInfo1[0]);
  dataExp1.append("rl", rl);
  $("#spiner-loader").removeClass("hide");
  $("#save").prop("disabled", true);
  $.ajax({
    url: `${general_base_url}Contraloria/updateRL`,
    data: dataExp1,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (data) {
      response = JSON.parse(data);
      if (response.message == "OK") {
        $("#save").prop("disabled", false);
        $("#editReg").modal("hide");
        $("#tabla_RL").DataTable().ajax.reload();
        alerts.showNotification(
          "top",
          "right",
          "Representante Legal Actualizado",
          "success"
        );
        $("#spiner-loader").addClass("hide");
      }
    },
    error: function (data) {
      $("#save").prop("disabled", false);
      $("#editReg").modal("hide");
      $("#tabla_RL").DataTable().ajax.reload();
      alerts.showNotification(
        "top",
        "right",
        "Error al enviar la solicitud.",
        "danger"
      );
      $("#spiner-loader").addClass("hide");
    },
  });
});

$(document).on("click", "#save2", function (e) {
  e.preventDefault();
  var sede = $("#sede").val();
  var dataExp2 = new FormData();
  dataExp2.append("idLote", getInfo1[0]);
  dataExp2.append("sede", sede);
  $("#spiner-loader").removeClass("hide");
  $("#save2").prop("disabled", true);
  $.ajax({
    url: `${general_base_url}Contraloria/updateSede`,
    data: dataExp2,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (data) {
      response = JSON.parse(data);
      if (response.message == "OK") {
        $("#save2").prop("disabled", false);
        $("#editReg").modal("hide");
        $("#tabla_RL").DataTable().ajax.reload();
        alerts.showNotification(
          "top",
          "right",
          "Sede Actualizada",
          "success"
        );
        $("#spiner-loader").addClass("hide");
      }
    },
    error: function (data) {
      $("#save2").prop("disabled", false);
      $("#editReg").modal("hide");
      $("#tabla_RL").DataTable().ajax.reload();
      alerts.showNotification(
        "top",
        "right",
        "Error al enviar la solicitud.",
        "danger"
      );
      $("#spiner-loader").addClass("hide");
    },
  });
});

$(document).on("click", "#save3", function (e) {
  e.preventDefault();
  var lote = $("#lote").val();
  var dataExp3 = new FormData();
  dataExp3.append("idLote", getInfo1[0]);
  dataExp3.append("lote", lote);
  $("#spiner-loader").removeClass("hide");
  $("#save3").prop("disabled", true);
  $.ajax({
    url: `${general_base_url}Contraloria/updateStatusLote`,
    data: dataExp3,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (data) {
      response = JSON.parse(data);
      if (response.message == "OK") {
        $("#save3").prop("disabled", false);
        $("#editReg").modal("hide");
        $("#tabla_RL").DataTable().ajax.reload();
        alerts.showNotification(
          "top",
          "right",
          "Sede Actualizada",
          "success"
        );
        $("#spiner-loader").addClass("hide");
      }
    },
    error: function (data) {
      $("#save3").prop("disabled", false);
      $("#editReg").modal("hide");
      $("#tabla_RL").DataTable().ajax.reload();
      alerts.showNotification(
        "top",
        "right",
        "Error al enviar la solicitud.",
        "danger"
      );
      $("#spiner-loader").addClass("hide");
    },
  });
});

$(document).on("click", "#save4", function (e) {
  e.preventDefault();
  
  let abono  = $("#abono").val();
  var abonoIns = abono.slice(1, -1).replace(/,/g, "");
  var comentarioIns = $("#comentario").val();
  var estatus_comisionIns = $("#estatus_comision").val();
  var idComIns = $("#idCom").val();
  var dataExp4 = new FormData();

  dataExp4.append("abonoIns", abonoIns);
  dataExp4.append("comentarioIns", comentarioIns);
  dataExp4.append("estatus_comisionIns", estatus_comisionIns);
  dataExp4.append("idComIns", idComIns);
 
  $("#spiner-loader").removeClass("hide");
  $("#save4").prop("disabled", true);
  $.ajax({
    url: `${general_base_url}Contraloria/InsertAbono`,
    data: dataExp4,
    cache: false,
    contentType: false,
    processData: false,
    type: "POST",
    success: function (data) {
      response = JSON.parse(data);
      if (response.message == "OK") {
        $("#save4").prop("disabled", false);
        $("#editReg").modal("hide");
        $("#tabla_RL").DataTable().ajax.reload();
        alerts.showNotification(
          "top",
          "right",
          "Abono Registrado",
          "success"
        );
        $("#abono").val("");
        $("#comentario").val("");
        $("#estatus_comision").val("");
        $("#idCom").val("");
        $("#spiner-loader").addClass("hide");
      }
    },
    error: function (data) {
      $("#save4").prop("disabled", false);
      $("#editReg").modal("hide");
      $("#tabla_RL").DataTable().ajax.reload();
      alerts.showNotification(
        "top",
        "right",
        "Error al enviar la solicitud.",
        "danger"
      );
      $("#spiner-loader").addClass("hide");
    },
  });
});
