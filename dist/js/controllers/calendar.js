  var calendar;
  var appointment = '';

  $(document).ready(function() {
    if(userType == 2){ /* Subdirector */
      getGerentes();
    }
    else if(userType == 3){ /* Gerente */
      getCoordinators(idUser);
    }
    else if(userType == 7 ){
      getEventos(idUser).then( response => {
        setSourceEventCRM(response, '#143860');
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger"); });
    }
    else if(userType == 9){ /* Coordinador */
      getAdvisers(idUser).then( response => {
        var arrayId = idUser;
        for (var i = 0; i < response.length; i++) {
          arrayId = arrayId + ',' + response[i]['id_usuario'];
        }
        getEventos(arrayId).then( response => {
          setSourceEventCRM(response, '#143860');
        }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger"); });
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger"); });
    }
  });

  $("#gerente").on('change', function(e){
    let id = $("#gerente").val();
    getCoordinators(id);
    $("#coordinador").empty().selectpicker('refresh');
    $("#asesor").empty().selectpicker('refresh');
  });

  $("#coordinador").on('change', function(e){
    removeEvents();
    var idCoordinador = $("#coordinador").val();
    getAdvisers(idCoordinador).then( response => {
      var arrayId = idCoordinador;
      for (var i = 0; i < response.length; i++) {
        arrayId = arrayId + ',' + response[i]['id_usuario'];
      }
      getEventos(arrayId).then( response => {
        setSourceEventCRM(response, '#143860');
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger"); });;
    }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger"); });
    $("#asesor").empty().selectpicker('refresh');
  });

  $("#asesor").on('change', function(e){
    removeEvents();
    if(userType == 9) var arrayId = idUser + ', ' + $("#asesor").val();
    else var arrayId = $("#coordinador").val() + ', ' +$("#asesor").val();
    
    getEventos(arrayId).then( response => {
      setSourceEventCRM(response, '#143860');
    }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger"); });;
  });

  function getGerentes(){
    $.post('../Calendar/getManagers', function(data) {
      var len = data.length;
      for (var i = 0; i < len; i++) {
          var id = data[i]['id_usuario'];
          var nombre = data[i]['nombre'];
          $("#gerente").append($('<option>').val(id).text(nombre));
      }
      if (len <= 0) {
        $("#gerente").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
      }
      $("#gerente").selectpicker('refresh');
    }, 'json');
  }

  function getCoordinators(id){
    $('#spiner-loader').removeClass('hide');
    $.post('../Calendar/getCoordinators', {id: id}, function(data) {
      $('#spiner-loader').addClass('hide');
      var len = data.length;
      for (var i = 0; i < len; i++) {
          var id = data[i]['id_usuario'];
          var nombre = data[i]['nombre'];
          $("#coordinador").append($('<option>').val(id).text(nombre));
      }
      if (len <= 0) {
        $("#coordinador").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
      }
      $("#coordinador").selectpicker('refresh');

      return data;
    }, 'json');
  }

  function getAdvisers(idCoordinador){
    return $.ajax({
      type: 'POST',
      url: 'getAdvisers',
      data: {id: idCoordinador},
      dataType: 'json',
      cache: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');
        var len = data.length;
        for (var i = 0; i < len; i++) {
          var id = data[i]['id_usuario'];
          var nombre = data[i]['nombre'];
          $("#asesor").append($('<option>').val(id).text(nombre));
        }
        if (len <= 0) {
          $("#asesor").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
        }

        $("#asesor").selectpicker('refresh');
      },
      error: function() {
        $('#spiner-loader').addClass('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  }

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
          window.location.reload();
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
    eventClick: function(info) {
      if (info.event.url) {
        window.open(info.event.url, "_blank");
        info.jsEvent.preventDefault();
      }else modalEvent(info.event.id);
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
  });
  
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
        if(gapi.auth2.getAuthInstance().isSignedIn.get()) insertEventGoogle(data);
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
        beforeSend: function() {
          $('#spiner-loader').removeClass('hide');
        },
        success: function(data) {
            calendar.refetchEvents();
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
          $('#modalEvent').modal('toggle');
          $('#spiner-loader').addClass('hide');
        },
        error: function() {
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
          $('#spiner-loader').addClass('hide');
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

  //SIDEBAR CALENDAR
  function modalSidebarCalendar(idAgenda){
    getAppointmentSidebarCalendar(idAgenda);
    $('#sidebarView').modal();
  }

  function getAppointmentSidebarCalendar(idAgenda){
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
        $("#estatus_recordatorio2").selectpicket('refresh');
        $("#prospectoE").append($('<option>').val(appointment.idCliente).text(appointment.nombre));
        $("#prospectoE").val(appointment.idCliente);
        $("#prospectoE").selectpicker('refresh');
        $("#dateStart2").val(moment(appointment.fecha_cita).format().substring(0,19));
        $("#dateEnd2").val(moment(appointment.fecha_final).format().substring(0,19));
        $("#description2").val(appointment.description);
        $("#idAgenda2").val(idAgenda);

        var medio = $("#estatus_recordatorio2").val();
        var box = $("comodinDIV2");
        validateNCreate(appointment, medio, box);
      },
      error: function() {
        $('#spiner-loader').addClass('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    })
  }

  /* Google sign in estatus true */

  /* Event's structure sent to Google */
  function buildEventGoogle(data){
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
      'reminders': {
        'useDefault': false,
        'overrides': [
          {'method': 'email', 'minutes': 24 * 60},
          {'method': 'popup', 'minutes': 10}
        ]
      },
      'extendedProperties':{
        'private' : [
          { 'setByFullCalendar' : true }
        ]
      }
    };

    return evento;
  }
  /* Event's structure sent to Google */

  function insertEventGoogle(data){
    var request = gapi.client.calendar.events.insert({
      'calendarId': 'primary',
      'resource': buildEventGoogle(data)
    });
    
    request.execute();
  }
  /* Google sign in estatus true */

  function removeEvents(){
    srcEventos = calendar.getEventSources();
    srcEventos.forEach(event => {
      if(!gapi.auth2.getAuthInstance().isSignedIn.get() && event['internalEventSource']['extendedProps'].hasOwnProperty('title') && event['internalEventSource']['extendedProps']['title'] == "sourceGoogle")
          event.remove();
      else{
        if(event['internalEventSource']['extendedProps'].hasOwnProperty('title') && event['internalEventSource']['extendedProps']['title'] == "sourceCRM"){
          event.remove();
        }
      }
    });
  }

  function getEventos(ids){
    return $.ajax({
      type: 'POST',
      url: 'Events',
      data: {ids: ids},
      dataType: 'json',
      cache: false,
      success: function(data) {
        if(data.length == 0){
          alerts.showNotification("top", "right", "Aún no hay ningún evento registrado", "success");
        }
      },
      error: function(){
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  }

  function setSourceEventCRM(events, colorBk){
    calendar.addEventSource({
      title: 'sourceCRM',
      color: colorBk,
      textColor: 'white',
      backgroundColor: colorBk,
      display:'block',
      borderColor: '#999',
      events: events
    })
    
    calendar.refetchEvents();
  }
