$( document ).ready(function() {
  backDiv();
});
var sideCalendar;
$(document).on('click', '#minimizeSidecalendar', function(e){
  e.preventDefault();
  console.log('click');
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
    </div>`).insertAfter("#side-calendar .fc-header-toolbar");
}


function minMaxSideCalendar(){
  if($('#sideCalendar').is(":visible")){
    $('body').removeClass('sidebar-calendar');
    $('#sideCalendar').hide("slow");
    $('#side-calendar').html("");
  }else{
    // sideCalendar.refetchEvents();
    $('body').addClass('sidebar-calendar');
    $('.sidebar-wrapper').removeClass('ps-container ps-theme-default ps-active-x ps-active-y');

    $('#sideCalendar').show("slow");
    setTimeout(function() {
      createCalendar();
    },500)
  }

  if (md.misc.sidebar_mini_active == true) {
    console.log('entra if');

    md.misc.sidebar_mini_active = false;
  } else {
    console.log('entra else');
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
      $("#estatus_recordatorio3").val(appointment.medio);
      $("#estatus_recordatorio3").selectpicker('refresh');
      $("#prospectoE2").append($('<option>').val(appointment.idCliente).text(appointment.nombre));
      $("#prospectoE2").val(appointment.idCliente);
      $("#prospectoE2").selectpicker('refresh');
      $("#dateStart3").val(moment(appointment.fecha_cita).format().substring(0,19));
      $("#dateEnd3").val(moment(appointment.fecha_final).format().substring(0,19));
      $("#description3").val(appointment.descripcion);
      $("#idAgenda3").val(idAgenda);

      var medio = $("#estatus_recordatorio2").val();
      var box = $("#comodinDIV2");
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
    box.append(`<label>Dirección del ${medio == 5 ? 'evento':'recorrido'}</label><input id="direccion2" name="direccion2" type="text" class="form-control input-gral" value='${((appointment !=  '' && (medio == 2 || medio == 5 )) ? ((appointment.id_direccion == ''|| appointment.id_direccion == null) ? appointment.direccion : '' ) : '' )}' required>`);
  }
  else if(medio == 3){
    box.append(`<div class="container-fluid"><div class="row"><div class="col-sm-12 col-md-6 col-lg-6 pl-0 m-0"><label>Teléfono 1</label><input type="text" class="form-control input-gral" value=${(appointment !=  '' &&  medio == 3 ) ? ((appointment.telefono != ''|| appointment.telefono != null) ? appointment.telefono : '') : ''+ $("#prospecto option:selected").attr('data-telefono') +''} disabled></div>`
    +`<div class="col-sm-12 col-md-6 col-lg-6 pr-0 m-0"><label>Teléfono 2</label><input type="text" class="form-control input-gral" id="telefono4" name="telefono4" value=${(appointment !=  '' &&  medio == 3 ) ? ((appointment.telefono_2 != ''|| appointment.telefono_2 != null) ? appointment.telefono_2 : '') : ($("#prospecto option:selected").attr('data-telefono2') != '' || $("#prospecto option:selected").attr('data-telefono2') != null ) ? $("#prospecto option:selected").attr('data-telefono2') : '' } ></div></div></div>`);
  }
  else if(medio == 4){
    box.append(`<div class="col-sm-12 col-md-12 col-lg-12 p-0"><label>Dirección de oficina</label><select class="selectpicker select-gral m-0 w-100" name="id_direccion2" id="id_direccion2" data-style="btn" data-show-subtext="true" data-live-search="true" title="Seleccione una opción" data-size="7" required></select></div>`);
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
      start: '',
      center: 'title',
      end: ''
    },
    timeZone: 'none',
    locale: 'es',
    initialView: 'timeGridDay',
    allDaySlot: false,
    height: 'auto',
    eventSources: [{
      url: `${base_url}Calendar/Events`,
      method: 'POST',
      color: '#12558C',   // a non-ajax option
      textColor: 'white', // a non-ajax option
      backgroundColor:'#12558C',
      display:'block' 
    }],
    eventClick: function(info) {
      modalEventC(info.event.id);
    },
  });
  sideCalendar.render();
  createCustomButtons();
}

function backDiv(){
  $sidebar = $('#sideCalendar');
  image_src = $sidebar.data('image');

  if (image_src !== undefined) {
    sidebar_container = '<div class="sidebarCalendar-background" style="background-image: url(' + image_src + ') "/>';
    $sidebar.append(sidebar_container);
  }
}