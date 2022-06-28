  var calendar;
  var appointment = '';
  var exists = 1;
  var eventsTable;
  $(document).ready(function() {
    getUsersAndEvents(userType,idUser, true);    
  });

  var calendarEl = document.getElementById('calendar');
  calendar = new FullCalendar.Calendar(calendarEl, {   
    headerToolbar: {
      start: 'prev next today appointments googleSignIn googleLogout',
      center: 'title',
      end:   'timeGridDay timeGridWeek dayGridMonth',
    },
    customButtons: {
      appointments: {
        text: 'Citas',
        click: function(){
          $("#allAppointmentsModal").modal();
          createTable();
        }
      },
      googleSignIn: {
        click: function() {
          gapi.auth2.getAuthInstance().signIn();
          listUpcomingEvents();
        }
      },
      googleLogout: {
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
    selectable: (userType == 2 || userType == 3) ? false : true,
    weekends: true,
    height: 'auto',
    contentHeight: 600,
    eventTimeFormat: {
      hour: "2-digit",
      minute: "2-digit",
      hour12: true
    },
    views: {
      // view-specific options here
      timeGridWeek: {
        titleFormat: { year: 'numeric', month: 'long', day: 'numeric' },
      },
      dayGridMonth: {
        dayMaxEvents: 4
      }
    },
    eventClick: function(info) {
      if (info.event.url) {
        window.open(info.event.url, "_blank");
        info.jsEvent.preventDefault();
      }
      else modalEvent(info.event.id);
    },
    select: function(info) {
      cleanModal();
      setDatesToModalInsert(info);
    }
  });
  calendar.render();
  customizeIcon();
  

  updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());

  $.post('Calendar/getStatusRecordatorio', function(data) {
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

  $.post('Calendar/getProspectos', function(data) {
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
    var temp = $(this).val() + ':00';
    $(this).val(temp);
  });

  $("#dateEnd2").on('change', function(e){
    var temp = $(this).val() + ':00';
    $(this).val(temp);
  });

  document.querySelector('#insert_appointment_form').addEventListener('submit',async e =>  {
    e.preventDefault();
    const dataF = Object.fromEntries(
      new FormData(e.target)
    )
    if(gapi.auth2.getAuthInstance().isSignedIn.get() == true){
      let inserted = await insertEventGoogle(dataF);
      dataF['idGoogle'] = inserted;
    }
    dataF['estatus_particular'] = $('#estatus_particular').val();
    dataF['id_prospecto_estatus_particular'] = $("#prospecto").val();
    $.ajax({
      type: 'POST',
      url: 'Calendar/insertRecordatorio',
      data: JSON.stringify(dataF),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        if(gapi.auth2.getAuthInstance().isSignedIn.get()) insertEventGoogle(dataF);
        removeCRMEvents();
        getUsersAndEvents(userType, idUser, false);
        data = JSON.parse(data);
        alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
        $('#agendaInsert').modal('toggle');
      },
      error: function() {
          $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  });

  $(document).on('submit', '#edit_appointment_form', function(e) {
    e.preventDefault();
    const dataF = Object.fromEntries(
      new FormData(e.target)
    );
    updateGoogleEvent(dataF);
  });

  function deleteCita(e){
    let idAgenda = $("#idAgenda2").val();
    let idGoogle = $("#idGoogle").val();
    deleteGoogleEvent(idAgenda,idGoogle);
  }

  function finalizarCita(){
    $('#modalEvent').modal('toggle');
    $('#feedbackModal').modal();
  }

  function modalEvent(idAgenda){
    getAppointmentData(idAgenda);
    $('#modalEvent').modal();
  }

  function getAppointmentData(idAgenda){
    $.ajax({
      type: "POST",
      url: "Calendar/getAppointmentData",
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
        $("#textProspecto").val(appointment.nombre);
        $("#textProspecto").prop("disabled", true);
        $("#prospectoE").val(appointment.idCliente);
        $("#dateStart2").val(moment(appointment.fecha_cita).format().substring(0,19));
        $("#dateEnd2").val(moment(appointment.fecha_final).format().substring(0,19));
        $("#description2").val(appointment.descripcion);
        $("#idAgenda2").val(idAgenda);
        $("#idGoogle").val(appointment.idGoogle)
        var medio = $("#estatus_recordatorio2").val();
        var box = $("#comodinDIV2");
        validateNCreate(appointment, medio, box);
        if(idUser != appointment.idOrganizador) disabledEditModal(true, appointment.estatus);
        else disabledEditModal(false, appointment.estatus);
        $(".dotStatusAppointment").css('color', `${appointment.estatus == 1 ? '#06B025' : '#e52424'}`);
      },
      error: function() {
        $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });    
  }

  function validateNCreate(appointment, medio, box){
    box.empty();
    console.log(appointment);
    if(medio == 2 || medio == 5){
      box.append(`<label class="m-0">Dirección del ${medio == 5 ? 'evento':'recorrido'}</label><input id="direccion" name="direccion" type="text" class="form-control input-gral" value='${((appointment !=  '' && (medio == 2 || medio == 5 )) ? ((appointment.id_direccion == ''|| appointment.id_direccion == null) ? appointment.direccion : '' ) : '' )}' required>`);
    }
    else if(medio == 3){
      box.append(`<div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-6 col-lg-6 pl-0 m-0"><label class="m-0">Teléfono 1</label><input type="text" class="form-control input-gral" value=${(appointment !=  '' &&  medio == 3 ) ? ((appointment.telefono != ''|| appointment.telefono != null) ? appointment.telefono : '') : ''+ $("#prospecto option:selected").attr('data-telefono') +''} disabled></div>`
      +`<div class="col-sm-12 col-md-6 col-lg-6 pr-0 m-0"><label class="m-0">Teléfono 2</label><input type="text" class="form-control input-gral" id="telefono2" name="telefono2" value=${(appointment !=  '' &&  medio == 3 ) ? ((appointment.telefono_2 != ''|| appointment.telefono_2 != null) ? appointment.telefono_2 : '') : ($("#prospecto option:selected").attr('data-telefono2') != '' || $("#prospecto option:selected").attr('data-telefono2') != null ) ? $("#prospecto option:selected").attr('data-telefono2') : '' } ></div></div></div>`);
    }
    else if(medio == 4){
      box.append(`<div class="col-sm-12 col-md-12 col-lg-12 p-0"><label class="m-0">Dirección de oficina</label><select class="selectpicker select-gral m-0 w-100" name="id_direccion" id="id_direccion" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select></div>`);
      getOfficeAddresses(appointment);
    }
    box.removeClass('hide');
  }

  function getOfficeAddresses(appointment){
    $.post('Calendar/getOfficeAddresses', function(data) {
      var len = data.length;
      for (var i = 0; i < len; i++) {
          var id = data[i]['id_direccion'];
          var direccion = data[i]['direccion'];
          $("#id_direccion").append($('<option>').val(id).text(direccion));
      }
      if (len <= 0) {
        $("#id_direccion").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
      }
      if( appointment != null || appointment.id_direccion != null ){
        $("#id_direccion").val(appointment.id_direccion);
        $("#id_direccion").selectpicker('refresh');
      }
    }, 'json');
    $("#id_direccion").selectpicker('refresh');
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

  $('#feedbackModal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
  });

  function getAppointmentSidebarCalendar(idAgenda){
    $.ajax({
      type: "POST",
      url: "Calendar/getAppointmentData",
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
        $("#idGoogle").val(appointment.idGoogle);

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
    var id = new Promise((resolve, reject) => {
      var request = gapi.client.calendar.events.insert({
        'calendarId': 'primary',
        'resource': buildEventGoogle(data)
      });
      
      request.execute(function (event) {
        resolve(event.id);
      });
    });
    return id;
  }

  async function updateGoogleEvent(data){
    const {idGoogle} = data;

    if(idGoogle == ''){
      data['inserted'] = await insertEventGoogle(data);
    }else{
      let evento = new Promise((resolve,reject)=>{
        gapi.client.calendar.events.get({"calendarId": 'primary', "eventId":idGoogle }).execute(function(event){
          resolve(event);
        });
      })
      editGoogleEvent(await evento, data);
    }

    $.ajax({
      type: 'POST',
      url: 'Calendar/updateAppointmentData',
      data: JSON.stringify(data),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        removeCRMEvents();
        getUsersAndEvents(userType, idUser, false);
        data = JSON.parse(data);
        alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
        $('#modalEvent').modal('toggle');
      },
      error: function() {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        $('#spiner-loader').addClass('hide');
      }
    });
  }

  function editGoogleEvent(evento, data){
    const { dateEnd, dateStart, description, estatus_recordatorio, evtTitle, idGoogle} = data;

    evento.summary = evtTitle;
    evento.description = description;
    evento.start.dateTime = dateStart;
    evento.end.dateTime = dateEnd;
    var request = gapi.client.calendar.events.patch({
      'calendarId': 'primary',
      'eventId': idGoogle,
      'resource': evento
    });
    request.execute();
  }
  
  function removeCRMEvents(){
    srcEventos = calendar.getEventSources();
    srcEventos.forEach(event => {
        if(event['internalEventSource']['extendedProps'].hasOwnProperty('title') && event['internalEventSource']['extendedProps']['title'] == "sourceCRM"){
          event.remove();
        }
    });
  }

  function setSourceEventCRM(events){
    calendar.addEventSource({
      title: 'sourceCRM',
      display:'block',
      events: events,
    })
  }

  function disabledEditModal(value, estatus){
    if(value){
      $("#modalEvent #menuModal").addClass('d-none');
      $("#edit_appointment_form input").prop("disabled", true);
      $("#edit_appointment_form textarea").prop("disabled", true);
      $("#prospectoE").prop("disabled", true);
      $("#id_direccion").prop("disabled", true);
      $("#estatus_recordatorio2").prop("disabled", true);
      $(".finishS").addClass("d-none");
    }
    else{
      var menuModal = $("#modalEvent #menuModal");
      (estatus == 1 ? menuModal.removeClass('d-none') : menuModal.addClass('d-none'));
      $("#edit_appointment_form input").prop("disabled", false);
      $("#edit_appointment_form textarea").prop("disabled", false);
      $("#prospectoE").prop("disabled", false);
      $("#id_direccion").prop("disabled", false);
      $("#estatus_recordatorio2").prop("disabled", false);
      var btnSave = $(".finishS");
      ( estatus == 1 ? btnSave.removeClass('d-none') : btnSave.addClass('d-none'));
    }
    $("#prospectoE").selectpicker('refresh');
    $("#estatus_recordatorio2").selectpicker('refresh');
  }

  async function deleteGoogleEvent(idAgenda, idGoogle){
    $.ajax({
      type: 'POST',
      url: 'Calendar/deleteAppointment',
      data: {idAgenda:idAgenda},
      dataType: 'json',
      cache: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');
          if (data == 1) {
              $('#modalEvent').modal("hide");
              calendar.render();
              alerts.showNotification("top", "right", "La actualización se ha llevado a cabo correctamente.", "success");
              if(idGoogle != ''){
                delGoogleEvent(idGoogle);
              }
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

  function delGoogleEvent(idGoogle){
    var request = gapi.client.calendar.events.delete({
      'calendarId': 'primary',
      'eventId': idGoogle
    });
    request.execute();
  }
    
  $(document).on('submit', '#feedback_form', function(e) {
    e.preventDefault();
    let data = new FormData($(this)[0]);
    data.append("idAgenda", $("#idAgenda2").val());
  });

  document.querySelector('#feedback_form').addEventListener('submit', e =>  {
    e.preventDefault();
    const data = Object.fromEntries(
      new FormData(e.target)
    )
    data['idAgenda'] = $("#idAgenda2").val();
    $.ajax({
      type: 'POST',
      url: 'Calendar/setAppointmentRate',
      data: JSON.stringify(data),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');
        data = JSON.parse(data);
        alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
        $('#feedbackModal').modal('toggle');
      },
      error: function() {
          $('#feedbackModal').modal('toggle');
          $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  });

  function customizeIcon(){
    $(".fc-googleSignIn-button").append("<img src='dist/img/googlecalendar.png'>");
    $(".fc-googleLogout-button").append("<img src='dist/img/unsync.png'>");
  }

  function createTable(){
    eventsTable = $('#appointments-datatable').dataTable({
      dom: "<'row w-100 m-0 mb-2 d-flex justify-evenly'<'col-xs-12 col-sm-12 col-md-6 col-lg-6 pl-0'<'toolbar'>><'col-xs-12 col-sm-12 col-md-6 col-lg-6 pr-0'f>>rt<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
      width: "auto",
      pagingType: "full_numbers",
      fixedHeader: true,
      language: {
          url: "static/spanishLoader_v2.json",
          paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
          }
      },
      destroy: true,
      ordering: false,
      columns: [{
        data: function (d) {
          return '<input type="text" name="id_cita" value="'+d.id_cita+'">';
        }
      },
      {
        width: "30%",
        data: function (d) {
          return '<label class="text-center m-0">'+d.nombre+'</label>';
        }
      },
      { 
        width: "12%",
        data: function (d) {
          return '<select class="form-control" name="evaluacion"><option value="0">Abierta</option><option value="1">Positiva</option><option value="2">Negativa</option><option value="3">Cancelada</option></select> ';
        }
      },
      {
        width: "38%",
        data: function (d) {
          return '<textarea class="textarea" name="observaciones" type="text"></textarea>';
        }
      },
      { 
        width: "20%",
        data: function (d) {
          return '<label class="text-center w-100 m-0">'+objectStringToDate(d.fecha_cita)+'</label>';
        }
      }],
      columnDefs: [{
        "targets": [0],
        "sClass": "hide_column",
        "searchable": false
      }],
      fnInitComplete: function(){
        $('div.toolbar').html('<h3 class="m-0">Citas abiertas</h3>');
      },
      ajax: {
        url: "Calendar/AllEvents",
        type: "POST",
        cache: false,
      }
    });
  }

  $(document).on('submit', '#appointmentsForm', function(e) {
    e.preventDefault();

    // Encode a set of form elements from all pages as an array of names and values
    var params = eventsTable.$('input,select,textarea').serialize();
    let array = createArrayEvents(params);
    $.ajax({
      type: 'POST',
      url: 'Calendar/updateNFinishAppointments',
      data: JSON.stringify(array),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');
        data = JSON.parse(data);
        alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
        $('#feedbackModal').modal('toggle');
      },
      error: function() {
          $('#feedbackModal').modal('toggle');
          $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  });

  function createArrayEvents(params){
    array = [], obj = {};
    var nameWithValue = params.split('&');
    for(i=0; i<nameWithValue.length; i++){
      var objAttr = nameWithValue[i].split('=');
      for(j=0; j<objAttr.length; j+=2){
        obj[objAttr[j]] = objAttr[j+1];
        obj['estatus'] = '2';
        if(objAttr[j] == 'observaciones' && obj['evaluacion'] != '0' ){
          array.push(obj);
          obj = {};
        }
      }
    }
    return array;
  }

  function objectStringToDate(objectDate){
    var fecha = new Date(objectDate);
    var options = { year: 'numeric', month: 'long', day: 'numeric' }
    
    return fecha.toLocaleDateString('es-ES', options);
  }