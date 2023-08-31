let calendar;
let appointment = '';
let exists = 1;
let eventsTable;
let arrayEvents = [];

function readyAgenda(){
  if (!localStorage.getItem('auth-google-token')) {
    $('#signInGoogleModal').modal('toggle');
  }

  createGoogleCalendar();

  getUsersAndEvents(id_rol_general, id_usuario_general, true);    
}

const getTimeZone = () => {
  const parts = (new Date().toString().match(/([-\+][0-9]+)\s/)[1]).split('');
  return `${parts[0] + parts[1] + parts[2]}:${parts[3] + parts[4]}`;
}

$('[data-toggle="tooltip"]').tooltip();

const createGoogleCalendar = () => {
  let calendarEl = document.getElementById('calendar');
  calendar = new FullCalendar.Calendar(calendarEl, {
    longPressDelay: 0,
    headerToolbar: {
      start: 'prev next today appointments googleBtn',
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
    },
    timeZone: 'none',
    locale: 'es',
    initialView: 'dayGridMonth',
    allDaySlot: false,
    selectable: (id_rol_general == 2 || id_rol_general == 3) ? false : true,
    weekends: true,
    height: 'auto',
    contentHeight: 600,
    eventTimeFormat: {
      hour: "2-digit",
      minute: "2-digit",
      hour12: true
    },
    views: {
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
  isSignInGoogle();
}

function listUpcomingEvents(tokenGoogleCalendar) {
  arrayEvents = [];

  $.ajax({
    url: 'https://www.googleapis.com/calendar/v3/calendars/primary/events',
    type: 'GET',
    dataType: "json",
    headers: {
      Authorization: `Bearer ${tokenGoogleCalendar}`
    },
    data: {
      timeMin: (new Date()).toISOString()
    },
    beforeSend: function() {
      $('#spiner-loader').removeClass('hide');
    },
    success: function (googleEvents) {
      const { items } = googleEvents;

      for(let i = 0; i < items.length; i++) {
        //Verificamos que no sea un evento insertado por el CRM, para dar la libertad de editarlo
        const isFullcalendar = doesObjectHaveNestedKey( items[i], 'setByFullCalendar' );
        if(!isFullcalendar) {
          eventTemplateGoogle(arrayEvents, items[i]);
        }
      }

      if(typeof(calendar) != 'undefined') {
        calendar.addEventSource({
          title: 'sourceGoogle',
          display:'block',
          events: arrayEvents
        });
      }

      calendar.refetchEvents();

      alerts.showNotification("top", "right", "Se han cargado los eventos de Google Calendar de manera exitosa.", "success");
    },
    error: function (err) {
      const { code } = err.responseJSON.error;
      if (code === 401) {
        $(".fc-googleBtn-button").append('<a id="signInGoogle"><i class="fab fa-google"></i></a>');
        localStorage.removeItem('auth-google-token');
      }
    },
    complete: function () {
      $('#spiner-loader').addClass('hide');
    }
  });
}

/* Search for existence of key in obj */
function doesObjectHaveNestedKey(obj, key) {
  if(obj === null || obj === undefined) {
    return false;
  }

  for(const k of Object.keys(obj)) {
    if(k === key) {
      /* Search keys of obj for match and return true if match found */
      return true
    }
    else {
      const val = obj[k];
      /* If k not a match, try to search it's value.*/
      if(typeof val === 'object') {
        /* Recursivly search for nested key match in nested val */
        if(doesObjectHaveNestedKey(val, key) === true) {
          return true;
        }
      }
    }
  }
  return false;
}

function eventTemplateGoogle(arrayEvents, googleAppointments){
  const { summary, htmlLink } = googleAppointments;
  let start, end;

  if( googleAppointments.start.hasOwnProperty('date') ) {
    start = ( googleAppointments.start.date != null ) ? googleAppointments.start.date : googleAppointments.start.dateTime;
  } else {
    start = googleAppointments.start.dateTime;
  }

  if(googleAppointments.end.hasOwnProperty('date') ) {
    end = ( googleAppointments.end.date != null ) ? googleAppointments.end.date : googleAppointments.end.dateTime;
  } else {
    end = googleAppointments.end.dateTime;
  }

  arrayEvents.push({
    className: 'googleEvents',
    title: summary,
    start: start,
    end: end,
    url: htmlLink,
    backgroundColor:'transparent',
    borderColor: '#999',
    textColor: '#999'
  });
}

function isSignInGoogle(){
  //Se es diferente de '' significa que se autorizó autentificación y pintaremos estos eventos.
  const googleToken = localStorage.getItem('auth-google-token');
  if (googleToken !== null){
    $(".fc-googleBtn-button").html('');
    listUpcomingEvents(googleToken);
  } else {
    $(".fc-googleBtn-button").append('<a id="signInGoogle"><i class="fab fa-google"></i></a>');
  }
}

$(document).on('click', '#signInGoogle', function (e) {
  e.preventDefault();

  gisLoaded();
});

$(document).on('click', '#signInGoogleButton', function () {
  $('#signInGoogleModal').modal('hide');
  gisLoaded();
});

$.post(`${general_base_url}Calendar/getStatusRecordatorio`, function(data) {
  const len = data.length;
  for (let i = 0; i < len; i++) {
      const id = data[i]['id_opcion'];
      const name = data[i]['nombre'];
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

$.post(`${general_base_url}Calendar/getProspectos`, function(data) {
  const len = data.length;
  for (let i = 0; i < len; i++) {
      const id = data[i]['id_prospecto'];
      const name = data[i]['nombre'];
      const telefono = data[i]['telefono'];
      const telefono2 = data[i]['telefono_2'];
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
  const medio = $("#estatus_recordatorio").val();
  const box = $("#comodinDIV");
  validateNCreate(appointment, medio, box);
})

$("#estatus_recordatorio2").on('change', function(e){
  const medio = $("#estatus_recordatorio2").val();
  const box = $("#comodinDIV2");
  validateNCreate(appointment, medio, box);
});

$("#prospecto").on('change', function(e){
  $("#select_recordatorio").removeClass("d-none");
});

$("#dateStart2").on('change', function(e){
  $('#dateEnd2').val("");
  $("#dateEnd2").prop('disabled', false);
  $('#dateEnd2').prop('min', $(this).val());
  const temp = $(this).val() + ':00';
  $(this).val(temp);
});

$("#dateEnd2").on('change', function(e){
  const temp = $(this).val() + ':00';
  $(this).val(temp);
});

document.querySelector('#insert_appointment_form').addEventListener('submit',async e =>  {
  e.preventDefault(); 
  const formValues = Object.fromEntries(new FormData(e.target));

  const data = buildEventGoogle(formValues);

  const rangeOfDates = validateDates(formValues);
  const emptyTitle = $("#evtTitle").val().replace(/\s/g, '').length ;

  if(!rangeOfDates || !emptyTitle) {
    if(!rangeOfDates)
      alerts.showNotification("top", "right", "Rango de fechas inválido", "danger");
    if(!emptyTitle)
      alerts.showNotification("top", "right", "Título inválido", "danger");
  } else {
    if (localStorage.getItem('auth-google-token') !== null) {
      formValues['idGoogle'] = await insertEventGoogle(data);
    }

    formValues['estatus_particular'] = $('#estatus_particular').val();
    formValues['id_prospecto_estatus_particular'] = $("#prospecto").val();
    $.ajax({
      type: 'POST',
      url: `${general_base_url}Calendar/insertRecordatorio`,
      data: JSON.stringify(formValues),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        if ( document.getElementById('asesor') != null && document.getElementById('asesor').value !== '' ) {
          $('#asesor').trigger('change');
        } else {
          getUsersAndEvents(id_rol_general, id_usuario_general, false);
        }

        data = JSON.parse(data);
        alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");

        const googleToken = localStorage.getItem('auth-google-token');
        $('#agendaInsert').modal('toggle');
      },
      error: function() {
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      },
      complete: function () {
        $('#spiner-loader').addClass('hide');
      }
    });
  }
});

$(document).on('submit', '#edit_appointment_form', function(e) {
  e.preventDefault();
  const dataF = Object.fromEntries(
    new FormData(e.target)
  );

  const rangeOfDates = validateDates(dataF);

  if(!rangeOfDates) {
    alerts.showNotification("top", "right", "Rango de fechas inválido", "danger");
  } else {
    updateEvent(dataF);
  }
});

function backToEvent(){
  $('#feedbackModal').modal('toggle');
  $('#modalEvent').modal();
}

function backFromDelete(){
  $('#modalDeleteEvt').modal('toggle');
  $('#modalEvent').modal();
}

function confirmDelete(){
  $('#modalDeleteEvt').modal();
  $('#modalEvent').modal('toggle');
}

function deleteCita(){
  let idAgenda = $(".idAgenda2").val();
  let idGoogle = $(".idGoogle").val();
  deleteEvent(idAgenda,idGoogle);
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
    url: `${general_base_url}Calendar/getAppointmentData`,
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
      $(".idAgenda2").val(idAgenda);
      $(".idGoogle").val(appointment.idGoogle)

      const medio = $("#estatus_recordatorio2").val();
      const box = $("#comodinDIV2");
      
      validateNCreate(appointment, medio, box);
      if(id_usuario_general != appointment.idOrganizador || appointment.estatus == 2 ) disabledEditModal(true, appointment.estatus);
      else disabledEditModal(false, appointment.estatus);

      $(".dotStatusAppointment").css('color', `${appointment.estatus == 1 ? '#06B025' : '#e52424'}`);

      if (id_usuario_general != appointment.idOrganizador) {
        $('#organizadorDiv').show();
        $('#organizador').val(appointment.nombreOrganizador);
      } else {
        $('#organizadorDiv').hide();
        $('#organizador').val('');
      }
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
  $.post(`${general_base_url}Calendar/getOfficeAddresses`, function(data) {
    const len = data.length;
    for (let i = 0; i < len; i++) {
        const id = data[i]['id_direccion'];
        const direccion = data[i]['direccion'];
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

/* Event's structure sent to Google */
function buildEventGoogle(data){
  const { dateEnd, dateStart, description, evtTitle } = data;
  const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

  return {
    'kind': "calendar#event",
    'summary': evtTitle,
    'description': description, 
    'start': {
      'dateTime': `${dateStart}:00${getTimeZone()}`,
      'timeZone': timeZone
    },
    'end': {
      'dateTime': `${dateEnd}:00${getTimeZone()}`,
      'timeZone': timeZone
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
}

function insertEventGoogle(data){
  return new Promise((resolve, reject) => {
    const tokenGoogleCalendar = localStorage.getItem('auth-google-token');

    $.ajax({
      url: `https://www.googleapis.com/calendar/v3/calendars/primary/events?key=${API_KEY}`,
      type: 'POST',
      data: JSON.stringify(data),
      dataType: 'json',
      headers: {
        Authorization: `Bearer ${tokenGoogleCalendar}`
      },
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function (event) {
        resolve(event.id);
      },
      error: function (err) {
        reject(err);
      },
      complete: function () {
        $('#spiner-loader').addClass('hide');
      }
    });
  });
}

async function updateEvent(formValues){
  const {idGoogle} = formValues;

  if(!idGoogle) {
    const data = buildEventGoogle(formValues);

    formValues['idGoogle'] = await insertEventGoogle(data);
  } else {
    let evento = new Promise((resolve,reject)=>{
      const tokenGoogleCalendar = localStorage.getItem('auth-google-token');

      $.ajax({
        type: 'GET',
        url: `https://www.googleapis.com/calendar/v3/calendars/primary/events/${idGoogle}?key=${API_KEY}`,
        dataType: 'json',
        headers: {
          Authorization: `Bearer ${tokenGoogleCalendar}`
        },
        beforeSend: function() {
          $('#spiner-loader').removeClass('hide');
        },
        success: function (response) {
          resolve(response);
        },
        error: function (err) {
          reject(err);
        },
        complete: function () {
          $('#spiner-loader').addClass('hide');
        }
      });
    });

    await editGoogleEvent(await evento, formValues);
  }

  $.ajax({
    type: 'POST',
    url: `${general_base_url}Calendar/updateAppointmentData`,
    data: JSON.stringify(formValues),
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      $('#spiner-loader').removeClass('hide');
    },
    success: function(data) {
      if ( document.getElementById('asesor') != null && document.getElementById('asesor').value != '' ) {
        $('#asesor').trigger('change');
      } else {
        getUsersAndEvents(id_rol_general, id_usuario_general, false);
      }

      data = JSON.parse(data);
      alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
      $('#modalEvent').modal('toggle');

      const googleToken = localStorage.getItem('auth-google-token');
    },
    error: function() {
      alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      $('#spiner-loader').addClass('hide');
    }
  });
}

function editGoogleEvent(evento, data){
  return new Promise((resolve, reject) => {
    const { dateEnd, dateStart, description, evtTitle, idGoogle} = data;
    const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    evento.summary = evtTitle;
    evento.description = description;
    evento.start.dateTime = `${dateStart}:00${getTimeZone()}`;
    evento.start.timeZone = timeZone;
    evento.end.dateTime = `${dateEnd}:00${getTimeZone()}`;
    evento.end.timeZone = timeZone;
    delete evento.etag;

    const tokenGoogleCalendar = localStorage.getItem('auth-google-token');

    $.ajax({
      type: 'PUT',
      url: `https://www.googleapis.com/calendar/v3/calendars/primary/events/${idGoogle}?key=${API_KEY}`,
      headers: {
        Authorization: `Bearer ${tokenGoogleCalendar}`
      },
      data: JSON.stringify(evento),
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function (d) {
        resolve(d);
      },
      error: function (err) {
        alerts.showNotification("top", "right", "Error en actualizar el evento en Google Calendar.", "danger");
        reject(err);
      },
      complete: function () {
        $('#spiner-loader').addClass('hide');
      }
    });
  });
}

function setSourceEventCRM(events){
  calendar.addEventSource({
    title: 'sourceCRM',
    display:'block',
    events: events,
  });
}

function disabledEditModal(value, estatus){
  if(value){
    $("#modalEvent #menuModal").addClass('d-none');
    $("#edit_appointment_form input").prop("disabled", true);
    $("#edit_appointment_form textarea").prop("disabled", true);
    $("#prospectoE").prop("disabled", true);
    $("#id_direccion").prop("disabled", true);
    $("#estatus_recordatorio2").prop("disabled", true);
    $("#modalEvent .finishS").addClass("d-none");
  }
  else{
    const menuModal = $("#modalEvent #menuModal");
    (estatus == 1 ? menuModal.removeClass('d-none') : menuModal.addClass('d-none'));
    $("#edit_appointment_form input").prop("disabled", false);
    $("#edit_appointment_form textarea").prop("disabled", false);
    $("#prospectoE").prop("disabled", false);
    $("#id_direccion").prop("disabled", false);
    $("#estatus_recordatorio2").prop("disabled", false);
    const btnSave = $("#modalEvent .finishS");
    ( estatus == 1 ? btnSave.removeClass('d-none') : btnSave.addClass('d-none'));
  }
  $("#prospectoE").selectpicker('refresh');
  $("#estatus_recordatorio2").selectpicker('refresh');
}

async function deleteEvent(idAgenda, idGoogle){
  if (idGoogle != '') {
    await deleteGoogleEvent(idGoogle);
  }

  $.ajax({
    type: 'POST',
    url: `${general_base_url}Calendar/deleteAppointment`,
    data: {idAgenda:idAgenda},
    dataType: 'json',
    cache: false,
    beforeSend: function() {
      $('#spiner-loader').removeClass('hide');
    },
    success: function(data) {
      $('#spiner-loader').addClass('hide');
        if (data == 1) {
            $('#modalDeleteEvt').modal("hide");

            if ( document.getElementById('asesor') != null && document.getElementById('asesor').value !== '' ) {
              $('#asesor').trigger('change');
            } else {
              getUsersAndEvents(id_rol_general, id_usuario_general, false);
            }

            alerts.showNotification("top", "right", "Se ha eliminado el registro de manera de exitosa.", "success");
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

function deleteGoogleEvent(idGoogle){
  return new Promise((resolve, reject) => {
    const tokenGoogleCalendar = localStorage.getItem('auth-google-token');

    $.ajax({
      url: `https://www.googleapis.com/calendar/v3/calendars/primary/events/${idGoogle}?key=${API_KEY}`,
      type: 'DELETE',
      dataType: 'json',
      headers: {
        Authorization: `Bearer ${tokenGoogleCalendar}`
      },
      success: function () {
        resolve(true);
      },
      error: function () {
        reject(false);
      }
    });
  });
}
  
$(document).on('submit', '#feedback_form', function(e) {
  e.preventDefault();
  let data = new FormData($(this)[0]);
  data.append("idAgenda", $(".idAgenda2").val());
});

document.querySelector('#feedback_form').addEventListener('submit', e =>  {
  e.preventDefault();
  const data = Object.fromEntries(
    new FormData(e.target)
  )
  data['idAgenda'] = $(".idAgenda2").val();
  $.ajax({
    type: 'POST',
    url: `${general_base_url}Calendar/setAppointmentRate`,
    data: JSON.stringify(data),
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      $('#spiner-loader').removeClass('hide');
    },
    success: function(data) {
      $('#spiner-loader').addClass('hide');
      removeCRMEvents();
      getUsersAndEvents(id_rol_general, id_usuario_general, false);
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
  $(".fc-googleSignIn-button").append("<img src='"+general_base_url+"dist/img/googlecalendar.png'>");
  $(".fc-googleLogout-button").append("<img src='"+general_base_url+"dist/img/unsync.png'>");
}

function createTable(){
  eventsTable = $('#appointments-datatable').dataTable({
    dom: "<'row w-100 m-0 mb-2 d-flex justify-evenly'<'col-xs-12 col-sm-12 col-md-6 col-lg-6 pl-0'<'toolbar'>><'col-xs-12 col-sm-12 col-md-6 col-lg-6 pr-0'f>>rt<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
    width: "auto",
    pagingType: "full_numbers",
    fixedHeader: true,
    language: {
        url: `${general_base_url}static/spanishLoader_v2.json`,
        paginate: {
          previous: "<i class='fa fa-angle-left'>",
          next: "<i class='fa fa-angle-right'>"
        }
    },
    destroy: true,
    ordering: false,
    columns: [{
      data: function (d) {
        return '<label>'+d.id_cita+'</label><input class="d-none" type="text" name="id_cita" value="'+d.id_cita+'">';
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
    fnInitComplete: function(){
      $('div.toolbar').html('<h3 class="m-0">Citas abiertas</h3>');
    },
    ajax: {
      url: `${general_base_url}Calendar/AllEvents`,
      type: "POST",
      cache: false,
    }
  });
}

$(document).on('submit', '#appointmentsForm', function(e) {
  e.preventDefault();

  // Encode a set of form elements from all pages as an array of names and values
  const params = eventsTable.$('input,select,textarea').serialize();
  let array = createArrayEvents(params);
  if (array.length === 0) {
    alerts.showNotification("top", "right", "No hay ningún registro que modificar.", "warning");
  } else {
    $.ajax({
      type: 'POST',
      url: `${general_base_url}Calendar/updateNFinishAppointments`,
      data: JSON.stringify(array),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        // if(localStorage.getItem('auth-google-token') !== null) {
        //   insertEventGoogle(dataF);
        // }

        removeCRMEvents();
        getUsersAndEvents(id_rol_general, id_usuario_general, false);
        $('#spiner-loader').addClass('hide');
        data = JSON.parse(data);
        alerts.showNotification("top", "right", data["message"], (data["status" == 503]) ? "danger" : (data["status" == 400]) ? "warning" : "success");
        $('#allAppointmentsModal').modal('hide');
      },
      error: function() {
          $('#spiner-loader').addClass('hide');
          alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
}
});

function createArrayEvents(params){
  let array = []
  let obj = {};
  const nameWithValue = params.split('&');

  for(i=0; i<nameWithValue.length; i++){
    const objAttr = nameWithValue[i].split('=');
    for(j=0; j<objAttr.length; j+=2){
      obj[objAttr[j]] = objAttr[j+1];
      if(objAttr[j] == 'observaciones' && obj['evaluacion'] != '0' ){
        obj['estatus'] = '2';
        array.push(obj);
        obj = {};
      }
    }
  }
  return array;
}

function objectStringToDate(objectDate){
  const fecha = new Date(objectDate);
  const options = { year: 'numeric', month: 'long', day: 'numeric' }
  
  return fecha.toLocaleDateString('es-ES', options);
}

function validateDates(data){
  const {dateEnd, dateStart} = data;
  let start = moment(dateStart);
  let end = moment(dateEnd);
  return start.isBefore(end);
}

document.querySelector('style').textContent += "@media screen and (max-width:767px) { .fc-toolbar.fc-header-toolbar {flex-direction:column;} .fc-toolbar-chunk { display: table-row; text-align:center; padding:5px 0; } }";
