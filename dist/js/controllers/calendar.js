var calendar;
var appointment = '';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {   
      headerToolbar: {
        start:   'timeGridDay,timeGridWeek,dayGridMonth',
        center: 'title',
        end: 'prev,next today googleSignIn googleLogout'
      },
      customButtons: {
        googleSignIn: {
          icon: 'fab fa-google',
          click: function() {
            gapi.auth2.getAuthInstance().signIn();
            listUpcomingEvents();
          }
        },
        googleLogout: {
          icon: 'fas fa-power-off',
          click: function() {
            gapi.auth2.getAuthInstance().signOut();
          }
        }
      },
      timeZone: 'none',
      locale: 'es',
      initialView: 'dayGridMonth',
      allDaySlot: false,
      selectable: true,
      weekends: true,
      height: 'auto',
      contentHeight: 550,
      views: {
        // view-specific options here
        timeGridWeek: {
          titleFormat: { year: 'numeric', month: 'long', day: 'numeric' },
        },
        dayGridMonth: {
          dayMaxEvents: 2
        }
      },
      eventSources: [{
        url: base_url+'index.php/calendar/Events',
        method: 'POST',
        color: '#12558C',   // a non-ajax option
        textColor: 'white', // a non-ajax option
        backgroundColor:'#12558C',
        display:'block' 
      }],
      eventClick: function(info) {
        modalEvent(info.event.id);
      },
      dateClick: function(info) {
        if(info.view.type == "dayGridMonth" || info.view.type == "timeGridWeek") {
          calendar.changeView( 'timeGridDay', info.dateStr );
        }
      },
      select: function(info) {
        if(info.view.type == "timeGridDay") {
          cleanModal();
          setDatesToModalInsert(info);
        }
      }
    });
    calendar.render();
  });

  $.post('../Calendar/getStatusRecordatorio', function(data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_opcion'];
        var name = data[i]['nombre'];
        $("#estatus_recordatorio").append($('<option>').val(id).text(name));
        $("#estatus_recordatorio2").append($('<option>').val(id).text(name));
    }
    if (len <= 0) {
        $("#estatus_recordatorio").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        $("#estatus_recordatorio2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    }
    $("#estatus_recordatorio").selectpicker('refresh');
    $("#estatus_recordatorio2").selectpicker('refresh');

  }, 'json'); 

  $.post('../Calendar/getProspectos', function(data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_prospecto'];
        var name = data[i]['nombre'];
        var telefono = data[i]['telefono'];
        var telefono2 = data[i]['telefono_2'];
        $("#prospecto").append($('<option data-telefono="'+telefono+'" data-telefono2="'+telefono2+'">').val(id).text(name));
    }
    if (len <= 0) {
        $("#prospecto").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    }
    $("#prospecto").selectpicker('refresh');
  }, 'json');

  function setDatesToModalInsert(info){
    appointment = '';
    $("#dateStart").val(info.startStr);
    $("#dateEnd").val(info.endStr);
    $('#agendaInsert').modal();
  }

  $("#estatus_recordatorio").on('change', function(e){
    var medio = $("#estatus_recordatorio").val();
    var box = $("#comodinDIV");
    validateNCreate(appointment, medio, box);
  })

  $("#estatus_recordatorio2").on('change', function(e){
    var medio = $("#estatus_recordatorio2").val();
    var box = $("#comodinDIV2");
    validateNCreate(appointment, medio, box);
  })

  $("#prospecto").on('change', function(e){
    $("#select_recordatorio").removeClass("d-none");
  })
  prospecto
  
  $("#dateStart2").on('change', function(e){
    $('#dateEnd2').val("");
    $("#dateEnd2").prop('disabled', false);
    $('#dateEnd2').prop('min', $(this).val());
  });

  document.querySelector('#insert_appointment_form').addEventListener('submit', e => {
    e.preventDefault();
    const data = Object.fromEntries(
      new FormData(e.target)
    )
    
    insertEvent(data);
    data['estatus_particular'] = $('#estatus_particular').val();
    data['id_prospecto_estatus_particular'] = $("#prospecto").val()
    $.ajax({
      type: 'POST',
      url: '../Calendar/insertRecordatorio',
      data: JSON.stringify(data),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        calendar.refetchEvents();
        data = JSON.parse(data);
        $('#spiner-loader').addClass('hide');
        alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
        $('#agendaInsert').modal('toggle');

        
      },
      error: function() {
          $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  });

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
            calendar.refetchEvents();
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
          $('#modalEvent').modal('toggle');
        },
        error: function() {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
  });

  function deleteCita(){
    let idAgenda = $("#idAgenda2").val();
    $.ajax({
      type: 'POST',
      url: 'deleteAppointment',
      data: {idAgenda: idAgenda},
      dataType: 'json',
      cache: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');
          if (data == 1) {
              $('#modalEvent').modal("hide");
              calendar.refetchEvents();
              alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
          } else {
              alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
          }
      },
      error: function() {
        $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  }

  function modalEvent(idAgenda){
    getAppointmentData(idAgenda);
    $('#modalEvent').modal();
  }

  function getAppointmentData(idAgenda){
    $.ajax({
      type: "POST",
      url: "getAppointmentData",
      data: {idAgenda: idAgenda},
      dataType: 'json',
      cache: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data){
        appointment = data[0];
        $('#spiner-loader').addClass('hide');
        $("#evtTitle2").val(appointment.titulo);
        $("#estatus_recordatorio2").val(appointment.medio);
        $("#estatus_recordatorio2").selectpicker('refresh');
        $("#prospectoE").append($('<option>').val(appointment.idCliente).text(appointment.nombre));
        $("#prospectoE").val(appointment.idCliente);
        $("#prospectoE").selectpicker('refresh');
        $("#dateStart2").val(moment(appointment.fecha_cita).format().substring(0,19));
        $("#dateEnd2").val(moment(appointment.fecha_final).format().substring(0,19));
        $("#description2").val(appointment.descripcion);
        $("#idAgenda2").val(idAgenda);

        var medio = $("#estatus_recordatorio2").val();
        var box = $("#comodinDIV2");
        validateNCreate(appointment, medio, box);
      },
      error: function() {
        $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });    
  }

  function validateNCreate(appointment, medio, box){
    box.empty();
    if(medio == 2 || medio == 5){
      box.append(`<label>Dirección del ${medio == 5 ? 'evento':'recorrido'}</label><input id="direccion" name="direccion" type="text" class="form-control input-gral" value='${((appointment !=  '' && (medio == 2 || medio == 5 )) ? ((appointment.id_direccion == ''|| appointment.id_direccion == null) ? appointment.direccion : '' ) : '' )}' required>`);
    }
    else if(medio == 3){
      box.append(`<div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-6 col-lg-6 pl-0 m-0"><label>Teléfono 1</label><input type="text" class="form-control input-gral" value=${(appointment !=  '' &&  medio == 3 ) ? ((appointment.telefono != ''|| appointment.telefono != null) ? appointment.telefono : '') : ''+ $("#prospecto option:selected").attr('data-telefono') +''} disabled></div>`
      +`<div class="col-sm-12 col-md-6 col-lg-6 pr-0 m-0"><label>Teléfono 2</label><input type="text" class="form-control input-gral" id="telefono2" name="telefono2" value=${(appointment !=  '' &&  medio == 3 ) ? ((appointment.telefono_2 != ''|| appointment.telefono_2 != null) ? appointment.telefono_2 : '') : ($("#prospecto option:selected").attr('data-telefono2') != '' || $("#prospecto option:selected").attr('data-telefono2') != null ) ? $("#prospecto option:selected").attr('data-telefono2') : '' } ></div></div></div>`);
    }
    else if(medio == 4){
      box.append(`<div class="col-sm-12 col-md-12 col-lg-12 p-0"><label>Dirección de oficina</label><select class="selectpicker select-gral m-0 w-100" name="id_direccion" id="id_direccion" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select></div>`);
      getOfficeAddresses(appointment);
    }
    box.removeClass('hide');
  }

  function getOfficeAddresses(appointment){
    $.post('../Calendar/getOfficeAddresses', function(data) {
      var len = data.length;
      for (var i = 0; i < len; i++) {
          var id = data[i]['id_direccion'];
          var direccion = data[i]['direccion'];
          $("#id_direccion").append($('<option>').val(id).text(direccion));
      }
      if (len <= 0) {
        $("#id_direccion").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
      }
      $("#id_direccion").selectpicker('refresh');

      if( appointment != null && appointment.id_direccion != null ){
        $("#id_direccion").val(appointment.id_direccion);
      }

      $("#id_direccion").selectpicker('refresh');
    }, 'json');
  }

  function cleanModal(){
    $('#evtTitle').val('');
    $("#prospecto option:selected").prop("selected", false);
    $("#prospecto").selectpicker('refresh');
    $("#estatus_recordatorio option:selected").prop("selected", false);
    $("#estatus_recordatorio").selectpicker('refresh');
    $("#description").val('');
    $("#comodinDIV").addClass('hide');
  }


  /* Google sign in estatus true */
  function buildEvent(data){
    const { dateEnd, dateStart, description, estatus_recordatorio, evtTitle } = data;
    var evento = {
      'summary': evtTitle,
      'description': description,
      'start': {
        'dateTime': dateStart,
        'timeZone': 'America/Mexico_City'
      },
      'end': {
        'dateTime': dateEnd,
        'timeZone': 'America/Mexico_City'
      },
      'recurrence': [
        'RRULE:FREQ=DAILY;COUNT=2'
      ],
      'attendees': [
        {'email': 'lpage@example.com'},
        {'email': 'sbrin@example.com'}
      ],
      'reminders': {
        'useDefault': false,
        'overrides': [
          {'method': 'email', 'minutes': 24 * 60},
          {'method': 'popup', 'minutes': 10}
        ]
      }
    };

    return evento;
  }

  function insertEvent(data){
    var request = gapi.client.calendar.events.insert({
      'calendarId': 'primary',
      'resource': buildEvent(data)
    });
    
    request.execute();
  }
  /* Google sign in estatus true */