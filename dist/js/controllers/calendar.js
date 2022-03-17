var calendar;
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar:
      {
        start:   'timeGridDay,timeGridWeek,dayGridMonth',
        center: 'title',
        end: 'prev,next today'
      },
      initialView: 'dayGridMonth',
      locale: 'es',
      dayHeaderContent: (args) => {
        return moment(args.date).format('ddd Do')
    },
      eventSources: [
        // your event source
        {
          url: base_url+'index.php/calendar/Events',
          method: 'POST',
          color: '#12558C',   // a non-ajax option
          textColor: 'white', // a non-ajax option
          backgroundColor:'#12558C',
          display:'block' 
        },
      ],
      eventClick: function(info) {
        modalEvent(info.event.id);
      }
    });
    calendar.render();
  });

  $.post('../Calendar/getStatusRecordatorio', function(data) {
    $("#estatus_recordatorio2").append($('<option disabled selected>').val("0").text("Seleccione una opción"));
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#estatus_recordatorio2").append($('<option>').val(id).text(name));
    }
    if (len <= 0) {
        $("#estatus_recordatorio2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    }
    $("#estatus_recordatorio2").selectpicker('refresh');
}, 'json');

$("#estatus_recordatorio2").on('change', function(e){
  let idAgenda = $("#idAgenda2").val();
  getAppointmentData(idAgenda, $(this).val());
})

$("#dateStart2").on('change', function(e){
  $('#dateEnd2').val("");
  $("#dateEnd2").prop('disabled', false);
  $('#dateEnd2').prop('min', $(this).val());

})

$("#edit_appointment_form").on('submit', function(e) {
  e.preventDefault();
  var formData = new FormData(this);
  $.ajax({
      type: 'POST',
      url: 'updateAppointmentData',
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
          if (data == 1) {
              $('#modalEvent').modal("hide");
             
              calendar.refetchEvents()

              alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
          } else {
              alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
          }
      },
      error: function() {
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
  });

});

  function modalEvent(idAgenda){
    getAppointmentData(idAgenda, null);
    $('#modalEvent').modal();
  }

  function deleteCita(){
    let idAgenda = $("#idAgenda2").val();
    $.ajax({
      type: 'POST',
      url: 'deleteAppointment',
      data: {idAgenda: idAgenda},
      dataType: 'json',
      cache: false,
      success: function(data) {
          if (data == 1) {
              $('#modalEvent').modal("hide");
             
              calendar.refetchEvents()

              alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
          } else {
              alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
          }
      },
      error: function() {
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
  });
  }

  function createComodin(data, medio){
    if(medio == 2 || medio == 4 || medio == 5 || medio == 1){
      $("#comodinDIV2").empty();
      $("#comodinDIV2").append(`<label>${medio == 1 ? 'URL':'Dirección'}</label>`+
      `<input id="comodin2" name="comodin" type="text" class="form-control" value='${data.direccion}'>`);
    }else if(medio == 3){
      $("#comodinDIV2").empty();
      $("#comodinDIV2").append(`<div class="col-lg-6 form-group" id="tel1"> <label>Teléfono 1</label><input id="telefono" name="telefono" type="text" class="form-control" value=${data.telefono} disabled></div>`+
      `<div class="col-lg-6 form-group" id="tel2"><label>Teléfono 2</label><input id="telefono2" name="telefono2" type="text" class="form-control" value='${data.telefono_2}' disabled></div>`);
    }
  }

  function getAppointmentData(idAgenda, medio){
    $.ajax({
      type: "POST",
      url: "getAppointmentData",
      data: {idAgenda: idAgenda},
      dataType: 'json',
      cache: false,
      success: function(data){
        if(medio == null){
          $("#estatus_recordatorio2").val(data[0].medio);
          $("#estatus_recordatorio2").selectpicker('refresh');
          $("#dateStart2").val(moment(data[0].fecha_cita).format().substring(0,19));
          $("#dateEnd2").val(moment(data[0].fecha_final).format().substring(0,19));
          $("#evtTitle2").val(data[0].titulo);
          $("#description2").val(data[0].descripcion);
          $("#idAgenda2").val(idAgenda);
        }
        createComodin(data[0], medio == null ? data[0].medio: medio);
      }
    });    
  }