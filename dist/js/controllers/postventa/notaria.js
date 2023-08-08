$(document).ready(function(){
  $.post("../Postventa/listSedes", function (data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
      var id = data[i]['id_sede'];
      var name = data[i]['nombre'];
      $("#sede").append($('<option>').val(id).text(name.toUpperCase()));
    }
    $("#sede").selectpicker('refresh');
  }, 'json');
});

$('#notaria-datatable thead tr:eq(0) th').each( function (i) {
  var title = $(this).text();
  $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>' );
  $( 'input', this ).on('keyup change', function () {
    if ($('#notaria-datatable').DataTable().column(i).search() !== this.value ) {
      $('#notaria-datatable').DataTable().column(i).search(this.value).draw();
    }
  });
});

prospectsTable = $('#notaria-datatable').DataTable({
    dom: 'rt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: "100%",
    scrollX: true,
    pagingType: "full_numbers",
    pageLength: 12,
    bAutoWidth:true,
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
                return d.idNotaria
            }
        },
        {
            data: function (d) {
                return d.nombre_notaria
            }
        },
        {
            data: function (d) {
                return d.nombre_notario
            }
        },
        {
            data: function (d) {
                return d.direccion
            }
        },
        {
            data: function (d) {
                return d.correo;
            }
        },
        {
            data: function (d) {
                return d.telefono;  
            }
        },
        {
            data: function (d) {
                return d.nombre;  
            }
        },
        { 
            orderable: false,
            data: function (d) {
                return '<div class="d-flex justify-center"><button class="btn-data btn-warning btn-delete" value="'+d.idNotaria+'" data-toggle="tooltip" data-placement="left" title="ELIMINAR"><i class="fas fa-trash"></i></button></div>';
            }
        }
    ],
    columnDefs: [{
        "searchable": true,
        "orderable": false,
        "targets": 0
    },
    ],
    ajax: {
        url: 'getNotarias',
        type: "POST",
        cache: false,
        data: {
        }
    }
});

$('#notaria-datatable').on('draw.dt', function() {
  $('[data-toggle="tooltip"]').tooltip({
    trigger: "hover"
  });
});

// Funcionalidad para eliminar las notarias
$("#notaria-datatable tbody").on("click", ".btn-delete", function(){    
  id = $(this).val();
  $("#modal-delete .modal-body").html('');
  $("#modal-delete .modal-body").append(`<div id="borrarBono"><form id="form-delete"><center><p style='color:#9D9D9D;'><b>¿Está seguro de eliminar este usuario?</b><br>Se eliminara el registro.</p></center><input type="hidden" id="idNotaria" name="idNotaria" value="${id}"><button class="btn btn-danger btn-simple" style="margin: 15px;" data-dismiss="modal">Cerrar</button><input type="submit"  class="btn btn-primary" value="Aceptar"></form></div>`);
  $('#modal-delete').modal('show');
});

function CloseModalDelete2(){
  document.getElementById("form-delete").reset();
  $("#modal-delete").modal('hide');  
}

function closeModalRegisto(){
  document.getElementById("form_notario").reset();
  $("#sede").selectpicker('refresh');
  $("#modal-usuario").modal("hide");
}
    
$(document).on('submit','#form-delete', function(e){ 
  e.preventDefault();
  var formData = new FormData(document.getElementById("form-delete"));
  formData.append("dato", "valor");
  $.ajax({
    method: 'POST',
    url: '../Postventa/updateNotarias',
    data: formData,
    processData: false,
    contentType: false,
    success: function(data) {
      if (data == 1) {
        $('#notaria-datatable').DataTable().ajax.reload(null, false);
        CloseModalDelete2();
        alerts.showNotification("top", "right", "Notaría eliminada correctamente.", "success");
        document.getElementById("form_abono");
      } else if(data == 0) {
        $('#notaria-datatable').DataTable().ajax.reload(null, false);
        CloseModalDelete2();
        alerts.showNotification("top", "right", "No se completo la eliminación de la notaría.", "warning");
      }
    },
    error: function(){
      closeModalEng();
      $('#modal_abono').modal('hide');
      alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
  });
});

$("#form_notario").on('submit', function(e){
  e.preventDefault();
  var formData = new FormData(document.getElementById("form_notario"));
  formData.append("dato", "valor");    
  $.ajax({
    method:'POST',
    url:'../Postventa/insertNotaria',
    data: formData,
    processData: false,
    contentType: false,
    success: function(data) {
      if (data == 1) {
        closeModalRegisto();
        $('#notaria-datatable').DataTable().ajax.reload(null, false);
        alerts.showNotification("top", "right", "Notaría registrada con exito.", "success");
      }
      else if(data == 2) {
        $('#notaria-datatable').DataTable().ajax.reload(null, false);
        closeModalRegisto();
        alerts.showNotification("top", "right", "No se pudo registrar la notaría con exito.", "warning");
      }
    },
    error: function(){
      closeModalRegisto();
      $('#modal_abono').modal('hide');
      alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
  });
});  


