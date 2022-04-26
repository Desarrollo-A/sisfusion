//jquery
  $(document).on('change','#gerente', function(e){
    let id = $("#gerente").val();
    getCoordinators(id);
    $("#coordinador").empty().selectpicker('refresh');
    $("#asesor").empty().selectpicker('refresh');
  });

  $(document).on('change', '#coordinador', function(e){
    removeEvents();
    var idCoordinador = $("#coordinador").val();
    console.log('idCoordinador',idCoordinador);

    getAsesores(idCoordinador, true).then( response => {
      var arrayId = idCoordinador;
      for (var i = 0; i < response.length; i++) {
        arrayId = arrayId + ',' + response[i]['id_usuario'];
      }
      getEventos(arrayId).then( response => {
        setSourceEventCRM(response);
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });;
    }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
    $("#asesor").empty().selectpicker('refresh');
  });

  $(document).on('change','#asesor', function(e){
    removeEvents();
    if(userType == 9) var arrayId = idUser + ', ' + $("#asesor").val();
    else var arrayId = $("#coordinador").val() + ', ' +$("#asesor").val();
    
    getEventos(arrayId).then( response => {
      setSourceEventCRM(response);
    }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger"); });;
  });

//funciones
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

  function getAsesores(idCoordinador, firstLoad){
    return $.ajax({
      type: 'POST',
      url: '../Calendar/getAdvisers',
      data: {id: idCoordinador},
      dataType: 'json',
      cache: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');
        if(firstLoad){
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
        }
      },
      error: function() {
        $('#spiner-loader').addClass('hide');
        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
      }
    });
  }

  
  function getEventos(ids){
    return $.ajax({
      type: 'POST',
      url: '../Calendar/Events',
      data: {ids: ids},
      dataType: 'json',
      cache: false,
      beforeSend: function() {
        $('#spiner-loader').removeClass('hide');
      },
      success: function(data) {
        $('#spiner-loader').addClass('hide');
        if(data.length == 0){
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

  function getUsersAndEvents(userType, idUser, firstLoad){
    if(userType == 2){ /* Subdirector */
      getGerentes();
    }
    else if(userType == 3){ /* Gerente */
      getCoordinators(idUser, 1);
    }
    else if(userType == 7 ){
      getEventos(idUser).then( response => {
        setSourceEventCRM(response);
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
    }
    else if(userType == 9){ /* Coordinador */
        getAsesores(idUser, firstLoad).then( response => {
        var arrayId = idUser;
        for (var i = 0; i < response.length; i++) {
          arrayId = arrayId + ',' + response[i]['id_usuario'];
        }
        getEventos(arrayId).then( response => {
          setSourceEventCRM(response);
        }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
      }).catch( error => { alerts.showNotification("top", "right", "Oops, algo salió mal. "+error, "danger"); });
    }
  }