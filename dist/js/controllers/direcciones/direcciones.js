var arregloEstado = [];

$(document).ready(function () {

    fillCatalogosTable();

    $.ajax({
        url: `${general_base_url}Direcciones/getOnlyEstados`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
                 arregloEstado= data;
                 for (let i = 0; i < arregloEstado.length; i++) {
                  const id_sede = arregloEstado[i].id_sede;
                  const estado = arregloEstado[i].estado;
                  $('#id_sede').append($('<option>').val(id_sede).text(estado));
              }
              $('#id_sede').selectpicker('refresh');
        }
      }); 
});

$(document).on("click", ".editarCatalogos", function () {
  $("#id_direccion").val($(this).attr("data-id_direccion"));
  $("#estatus_n").val($(this).attr("data-id_estatus"));
  $("#editCatalogoModal").modal();
});

$(document).on("click", "#btn_aceptar", function () {

  var id_direccion = $("#id_direccion").val();
  var estatus_n = $("#estatus_n").val();

  var datos = new FormData();
  $("#spiner-loader").removeClass("hide");

  if (estatus_n == 1) {
    estatus_n = 0;
  } else{
    estatus_n = 1;
  }
  
  datos.append("id_direccion", id_direccion);
  datos.append("estatus_n", estatus_n);

  $.ajax({
    method: "POST",
    url: general_base_url + "Direcciones/borrarOpcion",
    data: datos,
    processData: false,
    contentType: false,
    success: function (data) {
      if (data == 1) {
        $("#direcciones_datatable").DataTable().ajax.reload(null, false);
        $("#spiner-loader").addClass("hide"); 
        alerts.showNotification("top", "right", "Opcion editada correctamente.", "success");
        $("#id_direccion").val("");
        $("#estatus_n").val("");
        $("#editCatalogoModal").modal("hide");
      }
    },
    error: function () {
      $("#editarModel").modal("hide");
      $("#spiner-loader").addClass("hide");
      alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    },
  });
});

let titulos_intxtLiberado = [];
$('#direcciones_datatable thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxtLiberado.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $( 'input', this ).on('keyup change', function () {
        if ($('#direcciones_datatable').DataTable().column(i).search() !== this.value ) {
            $('#direcciones_datatable').DataTable().column(i).search(this.value).draw();
        }
    });
});

  function generarOpciones(opcion) {
    for (var j = 0; j < 2; j++) {
      var amPm = (j === 0) ? "AM" : "PM";
      for (var i = 1; i <= 12; i++) {
        var hora = (i < 10) ? "0" + i : i;
        var option = new Option(hora + ":00 " + amPm, hora + " " + amPm);
        opcion.appendChild(option);
      }
    }
  }

  $('#spiner-loader').addClass('hide');
  var selectHoras = document.getElementById("horaIni");
  var selectHoras2 = document.getElementById("hora_final_hr");

  generarOpciones(selectHoras);
  generarOpciones(selectHoras2);

  $("#horaIni").selectpicker('refresh');
  $("#hora_final_hr").selectpicker('refresh');

  $(document).on("click", ".editar-direccion-information", function () {
    var data = CatalogoTable.row($(this).parents("tr")).data();

    $("#id_direccionM").val(data.id_direccion);
    $("#direccion").val(data.direccion);
   
    $("#id_sede").val(data.id_sede).trigger("change");
    $("#id_sede").selectpicker("refresh");  

    $("#horaIni").val(data.hora_inicio).trigger("change");
    $("#horaIni").selectpicker('refresh');

    $("#hora_final_hr").val(data.hora_fin).trigger("change");
    $("#hora_final_hr").selectpicker('refresh');
    
    $('#OpenModalAdd').modal('show');
  });
  
function limpiarCampos() {
  $("#formDireccion")[0].reset();
  $("#id_direccionM").val('');
  $('#id_sede').selectpicker('refresh');
  $('#horaIni').selectpicker('refresh');
  $('#hora_final_hr').selectpicker('refresh');
}

$("#formDireccion").on('submit', function(e){

  e.preventDefault();

  let datos = new FormData($(this)[0]);

  if ($('#id_direccionM').val() === '' ){

      let id_sede = $('#id_sede').val();
      let direccion = $('#direccion').val().trim();
      let horaInicial = $('#horaIni').val();
      let horaFinal = $('#hora_final_hr').val();

      if(id_sede === '' || direccion === '' || horaInicial === '' || horaFinal === ''){
        alerts.showNotification("top", "right", "Falta llenar un campo", "warning");
        $("#spiner-loader").addClass('hide');
        return;
      }
      $.ajax({
        method: 'POST',
        url: general_base_url + 'Direcciones/AddEditDireccion',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data){
            if (data == 1) {
                $('#direcciones_datatable').DataTable().ajax.reload(null, false);
                $('#OpenModalAdd').modal('hide');
                $("#spiner-loader").addClass('hide');
                alerts.showNotification("top", "right", "Opción insertada correctamente.", "success");
                limpiarCampos();
                
            }
        },
        error: function(){
            $('#OpenModalAdd').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
  } else {
      let id_sede = $('#id_sede').val();
      let direccion = $('#direccion').val().trim();
      let horaInicial = $('#horaIni').val();
      let horaFinal = $('#hora_final_hr').val();

      if(id_sede === '' || direccion === '' || horaInicial === '' || horaFinal === ''){
        alerts.showNotification("top", "right", "Captura todos los datos", "warning");
        $("#spiner-loader").addClass('hide');
        return;
      }
      $.ajax({
            method: "POST",
            url: general_base_url + "Direcciones/AddEditDireccion",
            data: datos,
            processData: false,
            contentType: false,
            success: function (data) {
              if (data == 1) {
                $("#direcciones_datatable").DataTable().ajax.reload(null, false);
                $('#OpenModalAdd').modal('hide');
                alerts.showNotification("top", "right", "Opcion editada correctamente.", "success");
                limpiarCampos();
                $('#id_sede').selectpicker('refresh');
                $('#horaIni').selectpicker('refresh');
                $('#hora_final_hr').selectpicker('refresh');
                $("#spiner-loader").addClass("hide"); 
              }
            },
            error: function () {
              $("#OpenModalAdd").modal("hide");
              $("#spiner-loader").addClass("hide");
              alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            },
      });
  }
});

function fillCatalogosTable() {
    CatalogoTable = $("#direcciones_datatable").DataTable({
      width: "100%",
      dom:
        "Brt" +
        "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
          {
            extend: "excelHtml5",
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    
            className: "btn buttons-excel",
            titleAttr: "Direcciones",
            title: "Direcciones",
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6],
              format: {
                header: function (d, columnIdx) {
                  return " " + titulos_intxtLiberado[columnIdx] + " ";
                },
              },
            },
          }, {
            text: '<i class="fas fa-plus"></i>    ', 
            action:function(){
              $('#OpenModalAdd').modal('show');
            },
            attr: {
              class: 'btn btn-azure agregarDireccionBtn',
              'data-action': 'agregar',
              name: 'AgregarID'
          }
          }
        ],
      pagingType: "full_numbers",
      language: {
        url: general_base_url + "static/spanishLoader_v2.json",
        paginate: {
          previous: "<i class='fa fa-angle-left'>",
          next: "<i class='fa fa-angle-right'>",
        },
      },
      processing: true,
      pageLength: 10,
      bAutoWidth: true,
      bLengthChange: false,
      scrollX: true,
      bInfo: true,
      searching: true,
      ordering: false,
      fixedColumns: true,
      destroy: true,
      columns: [
        {
            data: function (d) {
                return '<p class="m-0">' + d.id_direccion + "</p>";
            },
        },
        
        {
            data: function (d) {
                return '<p class="m-0">' + d.direccion + "</p>";
            },
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.estado + "</p>";
            },
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.hora_inicio + "</p>";
            },
        },
        {
            data: function (d) {
                return '<p class="m-0">' + d.hora_fin + "</p>";
            },
        },
        {
          data: function (d) {
            if (d.estatus == 1) {
              return '<center><span class="label lbl-green">ACTIVO</span><center>';
            } else {
              return '<center><span class="label lbl-warning">INACTIVO</span><center>';
            }
          },
        },
        {
            data: function (d) {
              if (d.estatus == 1) { 
                return ('<div class="d-flex justify-center"><button class="btn-data btn-orangeYellow editar-direccion-information" data-action="editar" id="editar-direccion-information" name="editar-direccion-information" data-id_direccion="' + d.id_direccion +'" data-id_sede="' + d.id_sede +'" data-direccion="' + d.direccion + '" data-hora_inicio="' + d.hora_inicio + '" data-hora_fin="' + d.hora_fin + '" style="margin-right: 3px" data-toggle="tooltip" data-placement="top" title="EDITAR"><i class="fas fa-edit"></i></button><button class="btn-data btn-warning editarCatalogos" id="editarCatalogos" name="editarCatalogos" style="margin-right: 3px" data-toggle="tooltip" data-placement="top" title="CAMBIAR ESTATUS" data-id_estatus="' + d.estatus +'" data-id_direccion="' +d.id_direccion + '"><i class="fas fa-lock"></i></button></div>');
              } else {
                return ('<div class="d-flex justify-center"><button class="btn-data btn-orangeYellow editar-direccion-information" data-action="editar" id="editar-direccion-information" name="editar-direccion-information" data-id_direccion="' + d.id_direccion +'" data-id_sede="' + d.id_sede +'" data-direccion="' + d.direccion + '" data-hora_inicio="' + d.hora_inicio + '" data-hora_fin="' + d.hora_fin + '" style="margin-right: 3px" data-toggle="tooltip" data-placement="top" title="EDITAR"><i class="fas fa-edit"></i></button><button class="btn-data btn-warning editarCatalogos" id="editarCatalogos" name="editarCatalogos" style="margin-right: 3px" data-toggle="tooltip" data-placement="top" title="CAMBIAR ESTATUS" data-id_estatus="' + d.estatus +'" data-id_direccion="' +d.id_direccion + '"><i class="fas fa-lock"></i></button></div>');
              }
            },
        },
        ],
      columnDefs: [
        {
          defaultContent: "",
          targets: "_all",
          searchable: true,
          orderable: false,
        },
      ],
      ajax: {
        url: general_base_url + "Direcciones/getDireccionesAll",
        dataSrc: "",
        type: "GET",
        cache: false,
      },
      initComplete: function () {
        $("#spiner-loader").addClass("hide");
      },
    });
  
    $("#direcciones_datatable").on("draw.dt", function () {
      $('[data-toggle="tooltip"]').tooltip({
        trigger: "hover",
      });
    });
  }