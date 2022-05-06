$( document ).ready(function() {
  backDiv();
  if(exists == 1){
    document.getElementById('openCalendar').style.display = 'none';
    document.getElementById('divCalendar').style.display = 'none';
  }
});
var sideCalendar;
$(document).on('click', '#minimizeSidecalendar', function(e){
  e.preventDefault();
  minMaxSideCalendar();
})

$(document).on('click', '#next', function(e){
  e.preventDefault();
  sideCalendar.next();
})

$(document).on('click', '#prev', function(e){
  e.preventDefault();
  sideCalendar.prev();
})

function createCustomButtons(){
  $(`<div id="customButtons" class="d-flex justify-center">
      <a id="prev" class="iconCustom">
        <i class="fas fa-angle-left"></i>
      </a>
      <a id="next" class="iconCustom">
        <i class="fas fa-angle-right"></i>
      </a>
    </div>`).insertAfter("#selects");
}


function minMaxSideCalendar(){
  if($('#sideCalendar').is(":visible")){
    $('body').removeClass('sidebar-calendar');
    $('#sideCalendar').hide("slow");
    $('#side-calendar').html("");
  }else{
    $('body').addClass('sidebar-calendar');
    $('.sidebar-wrapper').removeClass('ps-container ps-theme-default ps-active-x ps-active-y');

    $('#sideCalendar').show("slow");
    setTimeout(function() {
      createCalendar();
      updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
    },500)
  }

  if (md.misc.sidebar_mini_active == true) {
    md.misc.sidebar_mini_active = false;
  } else {
    md.misc.sidebar_mini_active = true;
  }

   // we simulate the window Resize so the charts will get updated in realtime.
   var simulateWindowResize = setInterval(function() {
    window.dispatchEvent(new Event('resize'));
  }, 180);

  // we stop the simulation of Window Resize after the animations are completed
  setTimeout(function() {
    clearInterval(simulateWindowResize);
  }, 1000);
}

function modalEventC(idAgenda){
  getAppointmentDataC(idAgenda);
  $('#modalEventConsulta').modal();
}

function getAppointmentDataC(idAgenda){
  $.ajax({
    type: "POST",
    url:  `${base_url}Calendar/getAppointmentData`,
    data: {idAgenda: idAgenda},
    dataType: 'json',
    cache: false,
    beforeSend: function() {
      $('#spiner-loader').removeClass('hide');
    },
    success: function(data){
      appointment = data[0];
      $('#spiner-loader').addClass('hide');
      $("#evtTitle3").val(appointment.titulo);
      $("#estatus_recordatorio3").append($('<option>').val(appointment.medio).text(appointment.nombre_medio));
      $("#estatus_recordatorio3").val(appointment.medio);
      $("#estatus_recordatorio3").selectpicker('refresh');
      $("#prospectoE2").append($('<option>').val(appointment.idCliente).text(appointment.nombre));
      $("#prospectoE2").val(appointment.idCliente);
      $("#prospectoE2").selectpicker('refresh');
      $("#dateStart3").val(moment(appointment.fecha_cita).format().substring(0,19));
      $("#dateEnd3").val(moment(appointment.fecha_final).format().substring(0,19));
      $("#description3").val(appointment.descripcion);
      $("#idAgenda3").val(idAgenda);
      $(".dotStatusAppointment").css('color', `${appointment.estatus == 1 ? '#06B025' : '#e52424'}`);
      var medio = $("#estatus_recordatorio3").val();
      var box = $("#comodinDIV3");
      box.prop("disabled", true);
      validateNCreateC(appointment, medio, box);
    },
    error: function() {
      $('#spiner-loader').addClass('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
  });    
}

function validateNCreateC(appointment, medio, box){
  box.empty();
  if(medio == 2 || medio == 5){
    box.append(`<label class="m-0">Dirección del ${medio == 5 ? 'evento':'recorrido'}</label><input id="direccion2" name="direccion2" type="text" class="form-control input-gral" value='${((appointment !=  '' && (medio == 2 || medio == 5 )) ? ((appointment.id_direccion == ''|| appointment.id_direccion == null) ? appointment.direccion : '' ) : '' )}' disabled>`);
  }
  else if(medio == 3){
    box.append(`<div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-6 col-lg-6 pl-0 m-0"><label class="m-0">Teléfono 1</label><input type="text" class="form-control input-gral" value=${(appointment !=  '' &&  medio == 3 ) ? ((appointment.telefono != ''|| appointment.telefono != null) ? appointment.telefono : '') : ''+ $("#prospecto option:selected").attr('data-telefono') +''} disabled></div>`
    +`<div class="col-sm-12 col-md-6 col-lg-6 pr-0 m-0"><label class="m-0">Teléfono 2</label><input type="text" class="form-control input-gral" id="telefono4" name="telefono4" value=${(appointment !=  '' &&  medio == 3 ) ? ((appointment.telefono_2 != ''|| appointment.telefono_2 != null) ? appointment.telefono_2 : '') : ($("#prospecto option:selected").attr('data-telefono2') != '' || $("#prospecto option:selected").attr('data-telefono2') != null ) ? $("#prospecto option:selected").attr('data-telefono2') : '' } disabled></div></div></div>`);
  }
  else if(medio == 4){
    box.append(`<div class="col-sm-12 col-md-12 col-lg-12 p-0"><label class="m-0">Dirección de oficina</label><select class="selectpicker select-gral m-0 w-100" name="id_direccion2" id="id_direccion2" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" disabled></select></div>`);
    getOfficeAddressesC(appointment);
  }
  box.removeClass('hide');
}

function getOfficeAddressesC(appointment){
  $.post(`${base_url}Calendar/getOfficeAddresses`, function(data) {
    var len = data.length;
    for (var i = 0; i < len; i++) {
        var id = data[i]['id_direccion'];
        var direccion = data[i]['direccion'];
        $("#id_direccion2").append($('<option>').val(id).text(direccion));
    }
    if (len <= 0) {
      $("#id_direccion2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
    }
    $("#id_direccion2").selectpicker('refresh');

    if( appointment != null && appointment.id_direccion != null ){
      $("#id_direccion2").val(appointment.id_direccion);
    }

    $("#id_direccion2").selectpicker('refresh');
  }, 'json');
}

function createCalendar(){
  var calendarEl = document.getElementById('side-calendar');
  sideCalendar = new FullCalendar.Calendar(calendarEl, {   
    headerToolbar: {
      start: 'googleSignIn googleLogout',
      center: 'title',
      end: ''
    },
    customButtons: {
      googleSignIn: {
        text: 'Sincronizar con google',
        click: function() {
          gapi.auth2.getAuthInstance().signIn();
          // listUpcomingEvents();
        }
      },
      googleLogout: {
        text: 'Desincronizar',
        click: function() {
          gapi.auth2.getAuthInstance().signOut();
        }
      }
    },
    eventTimeFormat: {
      hour: '2-digit', //2-digit, numeric
      minute: '2-digit', //2-digit, numeric
      second: '2-digit', //2-digit, numeric
      meridiem: 'lowercase', //lowercase, short, narrow, false (display of AM/PM)
      hour12: true //true, false
    },
    slotLabelFormat:{
      hour: '2-digit',
      minute: '2-digit',
      hour12: true
      },
    timeZone: 'none',
    locale: 'es',
    initialView: 'timeGridDay',
    allDaySlot: false,
    height: 'auto',
    eventClick: function(info) {
      modalEventC(info.event.id);
    },
  });
  sideCalendar.render();
  createFilters(userType);
}

function backDiv(){
  $sidebar = $('#sideCalendar');
  image_src = $sidebar.data('image');

  if (image_src !== undefined) {
    sidebar_container = '<div class="sidebarCalendar-background" style="background-image: url(' + image_src + ') "/>';
    $sidebar.append(sidebar_container);
  }
}

function createFilters(rol){
  let fatherDiv = `<div class="container-fluid">
  <div class="row mb-2" id="selects"></div></div>`;
  let selects = '';
  if(rol == 2){
     selects += `<div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden ">
                          <label class="label-gral">Gerente</label>
                          <select class="selectpicker select-gral m-0" id="gerente" name="gerente" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un gerente" data-size="7" data-container="body"></select>
                      </div>`;
  }

  if(rol == 2 || rol == 3){
    selects += `<div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden ">
    <label class="label-gral">Coordinador</label>
    <select class="selectpicker select-gral m-0" id="coordinador" name="coordinador" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un coordinador" data-size="7" data-container="body"></select>
                      </div>`;
  }

  if(rol == 2 || rol == 3 || rol == 9){
    selects += ` <div class="col-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden ">
    <label class="label-gral">Asesor</label>
    <select class="selectpicker select-gral m-0" id="asesor" name="asesor" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione un asesor" data-size="7" data-container="body"></select>
                      </div>`;
  }
  $(fatherDiv).insertAfter("#side-calendar .fc-header-toolbar");
  $('#selects').append(selects);
  getUsersAndEvents(userType,idUser,true);
  createCustomButtons();
}

function setSourceEventCRM(events){
  sideCalendar.addEventSource({
    title: 'sourceCRM',
    display:'block',
    events: events
  })
  
  sideCalendar.render();
}

function removeEvents(){
  srcEventos = sideCalendar.getEventSources();
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