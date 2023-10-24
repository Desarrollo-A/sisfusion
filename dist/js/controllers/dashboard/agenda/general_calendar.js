//jquery
  $(document).on('change','#gerente', function(){
    removeCRMEvents();

    $("#labelAses").show();

    let id = $("#gerente").val();
    getCoordinators(id);
    $("#coordinador").empty().selectpicker('refresh');
  });

  $(document).on('change', '#coordinador', function(){
    const idCoordinador = $("#coordinador").val();
    $("#labelAses").show();

    getAsesores(idCoordinador, true).then( () => {
      getEventos(idCoordinador).then( response => {
        setSourceEventCRM(response);
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
    }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
    
    $("#asesor").empty().selectpicker('refresh');
  });

  $(document).on('change','#asesor', function(e){
    let arrayId = (userType == 9) ? idUser + ', ' + $("#asesor").val() : $("#coordinador").val() + ', ' +$("#asesor").val();
    
    getEventos(arrayId).then( response => {
      setSourceEventCRM(response);
    }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger"); });
  });

//funciones
  function getCoordinators(id){
    $('#spiner-loader').removeClass('hide');
    $.post(`${base_url}Calendar/getCoordinators`, {id: id}, function(data) {
      $("#labelCoord").show();
      $('#spiner-loader').addClass('hide');
      const len = data.length;
      for (let i = 0; i < len; i++) {
          const id = data[i]['id_usuario'];
          const nombre = data[i]['nombre'];
          $("#coordinador").append($('<option>').val(id).text(nombre));
      }
      if (len <= 0) {
      $("#coordinador").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
      }
      $("#coordinador").selectpicker('refresh');

      return data;
    }, 'json');
  }

  function getAsesores(idCoordinador, firstLoad){
    return $.ajax({
      type: 'POST',
      url: `${base_url}Calendar/getAdvisers`,
      data: {id: idCoordinador},
      dataType: 'json',
      cache: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');

        let ids = '';

        if(firstLoad) {
          const len = data.length;
          for (let i = 0; i < len; i++) {
            const id = data[i]['id_usuario'];
            const nombre = data[i]['nombre'];

            $("#asesor").append($('<option>').val(id).text(nombre));

            ids += (i+1 === len) ? data[i]['id_usuario'] : `${data[i]['id_usuario']},`;
          }

          if (len <= 0) {
            $("#asesor").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
          } else {
            $("#asesor").append($('<option>').val(ids).text('SELECCIONAR TODOS'));
          }
  
          $("#asesor").selectpicker('refresh');
        }
      },
      error: function() {
        $('#spiner-loader').addClass('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  }

  
  function getEventos(ids){
    removeCRMEvents();

    return $.ajax({
      type: 'POST',
      url: `${base_url}Calendar/Events`,
      data: {ids: ids},
      dataType: 'json',
      cache: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');

        if(data.length == 0) {
          alerts.showNotification("top", "right", "Aún no hay ningún evento registrado", "success");
        }
      },
      error: function(){
        $('#spiner-loader').addClass('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  }

  function getGerentes(){
    $.post(`${base_url}Calendar/getManagers`, function(data) {
      const len = data.length;
      for (let i = 0; i < len; i++) {
          const id = data[i]['id_usuario'];
          const nombre = data[i]['nombre'];
          $("#gerente").append($('<option>').val(id).text(nombre));
      }
      if (len <= 0) {
        $("#gerente").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
      }
      $("#gerente").selectpicker('refresh');
    }, 'json');
  }

  function getUsersAndEvents(userType, idUser, firstLoad){
    if(userType == 2){ /* Subdirector */
      getGerentes();
    } else if(userType == 3){ /* Gerente */
      getCoordinators(idUser, 1);
    } else if(userType == 7 ){
      getEventos(idUser).then( response => {
        setSourceEventCRM(response);
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
    } else if(userType == 9){ /* Coordinador */
        getAsesores(idUser, firstLoad).then( response => {
          getEventos(idUser).then( response => {
            setSourceEventCRM(response);
          }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
    }
  }

function removeCRMEvents(){
  if (typeof calendar !== 'undefined') {
    const srcEventos = calendar.getEventSources();
    srcEventos.forEach(event => {
      if(
          event['internalEventSource']['extendedProps'].hasOwnProperty('title') &&
          event['internalEventSource']['extendedProps']['title'] === "sourceCRM"
      ) {
        event.remove();
      }
    });
  }
}

const removeGoogleEvents = () => {
  if (typeof calendar !== 'undefined') {
    const srcEventos = calendar.getEventSources();
    srcEventos.forEach(event => {
      if(
          event['internalEventSource']['extendedProps'].hasOwnProperty('title') &&
          event['internalEventSource']['extendedProps']['title'] !== "sourceCRM"
      ) {
        event.remove();
      }
    });
  }
}