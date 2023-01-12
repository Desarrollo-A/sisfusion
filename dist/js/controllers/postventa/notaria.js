var url = "<?=base_url()?>";

$(document).ready(function(){
  // $.post("../Postventa/listSedes", function(data) {
  //     var len = data.length;
  //     $("#sede").append($('<option disabled selected>Selecciona una opción</option>'));
  //     for( var i = 0; i<len; i++){
  //         var id = data[i]['id_sede'];
  //         var name = data[i]['nombre'];
  //         $("#sede").append($('<option>').val(id).text(name.toUpperCase()));
  //     }
  //     $("#sede").selectpicker('refresh');
  // }, 'json');


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
  if (i != 7) {
    var title = $(this).text();
    $(this).html('<input class="textoshead"  placeholder="'+title+'"/>' );
    $( 'input', this ).on('keyup change', function () {
        if ($('#notaria-datatable').DataTable().column(i).search() !== this.value ) {
            $('#notaria-datatable').DataTable().column(i).search(this.value).draw();
        }
    });
  }
});

    // Traer los registros de la tabla notaria
    prospectsTable = $('#notaria-datatable').DataTable({
        dom: 'rt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        pagingType: "full_numbers",
        pageLength: 12,
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
                width: "3%",
                data: function (d) {
                    return d.idNotaria
                }

            },
            {
              width: "5%",
                data: function (d) {
                    return d.nombre_notaria
                }

            },
            {
              width: "10%",
                data: function (d) {

                    return d.nombre_notario
                }
            },
            {
              width: "20%",
                data: function (d) {
                    return d.direccion
                }
            },
            {
              width: "20%",
                data: function (d) {
                    return d.correo;
                }
            },
            {
              width: "8%",
                data: function (d) {
                    return d.telefono;  
                }
            },
            {
              width: "8%",
                data: function (d) {
                    return d.nombre;  
                }
            },
            { 
                width: "5%",
                orderable: false,
                data: function (d) {
                    // Botones de accion - actualizar y eliminar
                    return '<div class="d-flex justify-center"><button class="btn-data btn-warning btn-delete" value="'+d.idNotaria+'" data-toggle="tooltip" data-placement="right" title="ELIMINAR"><i class="fas fa-trash"></i></button></div>';
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
        // Funcionalidad para eliminar las notarias
    $("#notaria-datatable tbody").on("click", ".btn-delete", function(){    
        id = $(this).val();

        $("#modal-delete .modal-body").html('');
        $("#modal-delete .modal-body").append(`<div id="borrarBono"><form id="form-delete"><center><p style='color:#9D9D9D;'><b>¿Está seguro de eliminar este usuario?</b><br>Se eliminara el registro.</p></center><input type="hidden" id="idNotaria" name="idNotaria" value="${id}"><input type="submit"  class="btn btn-primary" style="margin: 15px;" value="Aceptar"><button class="btn btn-danger" data-dismiss="modal"">Cerrar</button></form></div>`);
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
              document.getElementById("form_abono").reset();
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

      function open_Mb(){
        $("#modal-usuario").modal();
      }

    //   Funciones para crear un nuevo notario
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
              // document.getElementById("form_abono").reset(); 
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


