$(document).ready(function () {

    fillCatalogosTable();

    $.ajax({
        url: `${general_base_url}Direcciones/getOnlyEstados`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const id_sede = data[i].id_sede;
                const estado = data[i].estado;
                $('#id_sede').append($('<option>').val(id_sede).text(estado));
                
            }

            $('#id_sede').selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
        }
      });

});


$(document).on('click', '#borrarOpcion', function () {
    $('#id_direccion').val($(this).attr('data-id_direccion'));
    $("#modalBorrar").modal();
});

$(document).on('click', '#borrarOp', function(){
    var id_direccion = $("#id_direccion").val();
    var datos = new FormData();

    $("#spiner-loader").removeClass('hide');

    datos.append("id_direccion", id_direccion);

    $.ajax({
        method: 'POST',
        url: general_base_url + 'Direcciones/borrarOpcion',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data){
            if (data == 1) {
            $('#direcciones_datatable').DataTable().ajax.reload(null, false);
            $("#spiner-loader").addClass('hide');
            $('#modalBorrar').modal('hide');
            alerts.showNotification("top", "right", "Opción dada de baja correctamente.", "success");
            }
        },
        error: function(){
            $("#spiner-loader").addClass('hide');
            $('#modalBorrar').modal('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
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

//edit

$(document).on("click", "#editar-direccion-information", function () {

    $("#id_sedeEdit").val($(this).attr("data-id_sede"));
    $("#direccionM").val($(this).attr("data-direccion"));
    $("#id_direccion").val($(this).attr("data-id_direccion"));

    $("#hora_inicioM").val($(this).attr("data-hora_inicio"));
    $("#hora_finM").val($(this).attr("data-hora_fin"));

    $.ajax({
        url: `${general_base_url}Direcciones/getOnlyEstados`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const id_sede = data[i].id_sede;
                const estado = data[i].estado;
                $('#id_sedeEdit').append($('<option>').val(id_sede).text(estado));
            }

            $('#id_sedeEdit').selectpicker('refresh');
            $('#spiner-loader').addClass('hide');
            $("#openModalDirecciones").modal();
        }
      });
});

$(document).on("click", "#editDirecciones", function () {

    var id_sedeEdit = $("#id_sedeEdit").val();
    var direccion = $("#direccionM").val();
    var id_direccion = $("#id_direccion").val();
    var hora_inicio = $("#hora_inicioM").val();
    var hora_fin = $("#hora_finM").val();

    console.log("horaI:"+hora_inicio,"horaF:"+hora_fin);
    
    var datos = new FormData();
    $("#spiner-loader").removeClass("hide");

    if(id_sedeEdit == ''){
        $("#spiner-loader").addClass('hide');
        alerts.showNotification("top", "right", "Selecciona una opción", "warning");
        return;
    }
  
    datos.append("id_sedeEdit", id_sedeEdit);
    datos.append("direccion", direccion);
    datos.append("id_direccion", id_direccion);
    datos.append("hora_inicio", hora_inicio);
    datos.append("hora_fin", hora_fin);
  
    $.ajax({
      method: "POST",
      url: general_base_url + "Direcciones/editarDireccionInfo",
      data: datos,
      processData: false,
      contentType: false,
      success: function (data) {
        if (data == 1) {
          $("#direcciones_datatable").DataTable().ajax.reload(null, false);
          $("#spiner-loader").addClass("hide"); 
          $("#openModalDirecciones").modal("hide");
          alerts.showNotification("top", "right", "Opcion editada correctamente.", "success");
          $("#direccion").val("");
          $("#id_direccion").val("");
          $("#hora_inicio").val("");
          $("#hora_fin").val("");
         
        }
      },
      error: function () {
        $("#editarModel").modal("hide");
        $("#spiner-loader").addClass("hide");
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      },
    });
  });

  //agregar

function openModal(){
    $("#OpenModalAdd").modal();
}

$(document).on('click', '#guardarDireccion', function(){
    var hora_inicio = $("#hora_inicio").val();
    var hora_fin = $("#hora_fin").val();
    var direccionInfo = $("#direccion").val(); 
    var id_sede = $("#id_sede").val();
   
    var datos = new FormData();
    $("#spiner-loader").removeClass('hide');
  
    datos.append("direccion", direccionInfo)
    datos.append("id_sede", id_sede)
    datos.append("hora_inicio", hora_inicio)
    datos.append("hora_fin", hora_fin)

    if(id_sede == ''){
        $("#spiner-loader").addClass('hide');
        alerts.showNotification("top", "right", "Selecciona una opción", "warning");
        return;
    }
  
    $.ajax({
        method: 'POST',
        url: general_base_url + 'Direcciones/insertDireccion',
        data: datos,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data == 1) {
                $('#direcciones_datatable').DataTable().ajax.reload(null, false);
                $('#OpenModalAdd').modal('hide');
                $("#spiner-loader").addClass('hide');
                alerts.showNotification("top", "right", "Opción insertada correctamente.", "success");
                $('#direccion').val('');
                $('#hora_inicio').val('');
                $('#hora_fin').val('');
                $('#id_sede').val('');
            }
        },
        error: function(){
            $('#OpenModalAdd').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    return;
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
                  return " " + titulos_intxt[columnIdx] + " ";
                },
              },
            },
          }, {
            text: '<i class="fas fa-plus"></i>    ',
            action: function() {
              openModal();
            }, 
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative;',
            },
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
                return '<p class="m-0">' + d.id_sede + "</p>";
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
                return '<p class="m-0">' + d.tipo_oficina + "</p>";
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
                return ('<div class="d-flex justify-center"><button class="btn-data btn-orangeYellow change-user-status editar-direccion-information" id="editar-direccion-information" name="editar-direccion-information" data-id_direccion="' + d.id_direccion +'" data-id_sede="' + d.id_sede +'" data-direccion="' + d.direccion + '" data-hora_inicio="' + d.hora_inicio + '" data-hora_fin="' + d.hora_fin + '" style="margin-right: 3px" data-toggle="tooltip" data-placement="top" title="EDITAR"><i class="fas fa-edit"></i></button><button class="btn-data btn-warning borrarOpcion" id="borrarOpcion" name="borrarOpcion" style="margin-right: 3px" data-toggle="tooltip" data-placement="top" title="DAR DE BAJA" data-id_direccion="' +d.id_direccion + '"><i class="fas fa-lock"></i></button></div>');

              } else {
                return ('<div class="d-flex justify-center"><button class="btn-data btn-orangeYellow change-user-status editar-direccion-information" id="editar-direccion-information" name="editar-direccion-information" data-id_direccion="' + d.id_direccion +'" data-id_sede="' + d.id_sede +'" data-direccion="' + d.direccion + '" data-hora_inicio="' + d.hora_inicio + '" data-hora_fin="' + d.hora_fin + '" style="margin-right: 3px" data-toggle="tooltip" data-placement="top" title="EDITAR"><i class="fas fa-edit"></i></button><button class="btn-data btn-warning borrarOpcion" id="borrarOpcion" name="borrarOpcion" style="margin-right: 3px" data-toggle="tooltip" data-placement="top" title="DAR DE BAJA" data-id_direccion="' +d.id_direccion + '"><i class="fas fa-lock"></i></button></div>');
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