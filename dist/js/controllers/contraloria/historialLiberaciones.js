let titulos = [];
$('#historialLib thead tr:eq(0) th').each( function (i) {
    let title = $(this).text();
    titulos.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($("#historialLib").DataTable().column(i).search() !== this.value) {
            $("#historialLib").DataTable().column(i).search(this.value).draw();
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();
})

$("#historialLib").ready(function () {
  $("#historialLib").DataTable({
    dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    buttons: [ 
      {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
        title: "Historial de Liberaciones",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          format: {
            header: function (d, columnIdx) {
              return ' ' + titulos[columnIdx] + ' ';
            }
          }
        }
      },
    ],
    pagingType: "full_numbers",
    language: {
      url: `${general_base_url}static/spanishLoader_v2.json`,
      paginate: {
        previous: "<i class='fa fa-angle-left'>",
        next: "<i class='fa fa-angle-right'>"
      }
    },    
    pageLength: 11,
    fixedColumns: true,
    ordering: false,
    scrollX: true,
    columns: [ 
      {
        data: function(d){
          return d.nombreResidencial;
        }
      },
      {
        data: function(d){
          return d.nombre;
        }
      },
      {
        data: function (d) {
          return d.idLote.toString(); 
        }
      },
      {
        data: function (d) {
          return d.nombreLote;
        }
      },
      {
        data: function (d) {
          return `${formatMoney(d.precio)}`; 
        }
      },
      {
        data: function (d) {
          return d.idCliente == 0 || d.idCliente == null ? 'Sin Cliente' : d.nombreCliente;
        }
      },
      {
        data: function (d) {
          return d.fecha_modificacion ? d.fecha_modificacion.split('.')[0] : 'Sin Fecha';
        }
      },
      {
        data: function (d) {
          return d.justificacion_liberacion;
        }
      },
      {
        data: function (d) {
          return d.estatus_proceso;
        }
      },
      {
        data: function (d) {
          return  d.id_tipo_liberacion == 1 ? '<span class="label lbl-warning" "> Rescisión </span>' : '<span class="label lbl-green"> Devolución </span>'
        }
      },
      {
        data: function (d) {           
          btns = '<div class="d-flex justify-left">';
          if(id_rol_general == 17)
          {
            btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="HISTORIAL" onclick="openHistorialModal('+d.idLote+')"> <i class="fas fa-history"></i></button>';
            if(d.id_tipo_liberacion == 1 ){
              btns += crearBotonAccion(AccionDoc.DOC_CARGADO, d);
            } 
          }
          
          if(id_rol_general == 33)
          {
            if (d.id_proceso == 1) {
              btns +='<button type="button" class="btn-data btn-green" type="button" data-toggle="tooltip" data-placement="left" title="APROBAR" onclick="fillModal(1, '+d.idLote+', '+d.id_tipo_liberacion+',0,0,0,0)"> <i class="fas fa-check"></i></button>'
              btns +='<button type="button" class="btn-data btn-warning" data-toggle="tooltip"  data-placement="left" title="RECHAZAR" onclick="fillModal(2, '+d.idLote+', '+d.id_tipo_liberacion+',0,0,0,0)"> <i class="fas fa-times"></i></button>'    
            }
            btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="HISTORIAL" onclick="openHistorialModal('+d.idLote+')"> <i class="fas fa-history"></i></button>';
            if(d.id_tipo_liberacion == 1 ){
              btns += crearBotonAccion(AccionDoc.DOC_CARGADO, d);
            } 
          }
          
          if(id_rol_general == 2) 
          {
            if (d.id_proceso == 2) {
              btns +='<button type="button" class="btn-data btn-green" data-toggle="tooltip"  data-placement="left" title="APROBAR" onclick="fillModal(1, '+d.idLote+', '+d.id_tipo_liberacion+',0,0,0,'+d.precio+')"> <i class="fas fa-check"></i></button>'
              btns +='<button type="button" class="btn-data btn-warning" data-toggle="tooltip"  data-placement="left" title="RECHAZAR" onclick="fillModal(2, '+d.idLote+', '+d.id_tipo_liberacion+',0,0,0,0)"> <i class="fas fa-times"></i></button>'
            }
            btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="HISTORIAL" onclick="openHistorialModal('+d.idLote+')"> <i class="fas fa-history"></i></button>'
            if(d.id_tipo_liberacion == 1 ){
              btns += crearBotonAccion(AccionDoc.DOC_CARGADO, d);
            }                     
          }
          
          if(id_rol_general == 12)
          {
            if (d.id_proceso == 3) {
              btns += `<button type="button" class="btn-data btn-green" data-toggle="tooltip" data-placement="left" id="aceptarButton" title="APROBAR" onclick="fillModal(3,  ${d.idLote}, ${d.id_tipo_liberacion}, ${d.idCondominio}, ${d.idResidencial}, '${d.nombreLote}', ${d.precio}, '${d.clausulas}')"><i class="fas fa-check"></i></button>
              <button type="button" class="btn-data btn-warning" data-toggle="tooltip"  data-placement="left" title="RECHAZAR" onclick="fillModal(2, ${d.idLote}, ${d.id_tipo_liberacion},0,0,0,0,0)"> <i class="fas fa-times"></i></button>`
            }
            btns += '<button type="button" class="btn-data btn-blueMaderas" data-toggle="tooltip"  data-placement="left" title="HISTORIAL" onclick="openHistorialModal('+d.idLote+')"> <i class="fas fa-history"></i></button>';
            if(d.id_tipo_liberacion == 1 ){
              btns += crearBotonAccion(AccionDoc.DOC_CARGADO, d);
            } 
          }
          btns += '</div>'
          return btns;
        }
      },
    ],
    ajax: {
      url: "get_historial_liberaciones",
      type: "POST",
      cache: false,
      data: function (d) {}
    }, 
  });
  $('#historialLib').removeClass('hide');
});

$('#historialLib').on('draw.dt', function() {
  $('[data-toggle="tooltip"]').tooltip({
    trigger: "hover"
  });
});

$(document).ready(function () {
  
  if(id_rol_general != 17 ){
    $("#nomT").text('Liberaciones');
  }
  
  if(id_rol_general == 12){
    $.post(general_base_url + "Contraloria/get_tipo_venta", function (data) {
      let len = data.length;
      for (let i = 0; i < len; i++) {
        let id = data[i]['id_tventa'];
        let name = data[i]['tipo_venta'];            
        $("#selLib").append($('<option>').val(id).text(name.toUpperCase()));
      }
      $("#selLib").selectpicker('refresh');
    }, 'json');

    $.post(general_base_url + "Contraloria/get_catalogo", {id_catalogo:48},   function (data) {
      let len = data.length;
      for (let i = 0; i < len; i++) {
        let id = data[i]['id_opcion'];
        let name = data[i]['nombre'];            
        $("#motLib").append($('<option>').val(id).text(name.toUpperCase()));
      }
      $("#motLib").selectpicker('refresh');
    }, 'json');
  } else{
    $("#contenidoMot").addClass('hide');
    $("#contenidoTip").addClass('hide');
  } 
});

$(document).on('click', '#aceptarButton', function(){
  $("#selLib").selectpicker('refresh')
  $("#motLib").selectpicker('refresh')
});

$("#acceptModalButton").click(function() {
  let comentario = $('#comentario').val();
  let accion = $('#accion').val();
  let idLote = $('#idlote').val();
  let idLiberacion = $('#idLiberacion').val();
  let idCondominio = $('#idCondominio').val();
  let idProyecto = $('#idProyecto').val();
  let nombreLote = $('#nombreLote').val();
  let precio = $('#precio').val();
  let selLib = $('#selLib').val(); 
  let motLib = $('#motLib').val();
  let id_usuario_general = $('#id_usuario_general').val();
  let clausulas = $('#clausulas').val();
  
  if(comentario == ''){
    alerts.showNotification("top", "right", "Añade un comentario para actualizar la liberación.", "warning");
    return;
  }

  if(id_rol_general == 12){
    if (accion == 3) {
      if(selLib == ''){
        alerts.showNotification("top", "right", "Elige el tipo de liberación.", "warning");
        return;
      }
      if(motLib == ''){
        alerts.showNotification("top", "right", "Elige el motivo de liberación.", "warning");
        return;
      }
      $.ajax({
        url: general_base_url + 'Contraloria/avance_estatus_liberacion',
        type: 'POST',
        data: {
          "idLote": idLote, 
          "accion": accion, 
          "idLiberacion": idLiberacion, 
          "comentario": comentario, 
          "activeLE": selLib == 7 ? true : false,
          "activeLP": selLib == 1 ? true : false,
          "id_proy": idProyecto, 
          "idCondominio": idCondominio, 
          "id_usuario": id_usuario_general, 
          "tipo": motLib,
          "nombreLote": nombreLote, 
          "precio": precio, 
          "clausulas": clausulas
        },
        dataType: 'JSON',
        success: function (data) {
          console.log(data, "datos");
         
          if(data == 1){
            alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
            $("#historialLib").DataTable().ajax.reload();
            $("#selLib").val('');
            $("#motLib").val('');
            closeModal();
          }else{
            alerts.showNotification("top", "right", "5555 Oops, algo salió mal.", "danger");
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error:', jqXHR.status, errorThrown);
        },
        catch: function () {},
      });
    }
    else if (accion == 2){
      $.ajax({
        url: general_base_url + 'Contraloria/avance_estatus_liberacion',
        type: 'POST',
        data: {
          "idLote": idLote, 
          "accion": accion, 
          "idLiberacion": idLiberacion, 
          "comentario": comentario, 
          "activeLE": selLib == 7 ? true : false,
          "activeLP": selLib == 1 ? true : false,
          "id_proy": idProyecto, 
          "idCondominio": idCondominio, 
          "id_usuario": id_usuario_general, 
          "tipo": motLib,
          "nombreLote": nombreLote, 
          "precio": precio, 
          "clausulas": clausulas
        },
        dataType: 'JSON',
        success: function (data) {

          if(data == 1){
            alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
            $("#historialLib").DataTable().ajax.reload();
            closeModal();
          }else{
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error:', jqXHR.status, errorThrown);
        },
        catch: function () {},
      });
    }else if (!selLib && accion != 2){
      alerts.showNotification("top", "right", "Elige el tipo de liberación.", "warning");
    }else if (!motLib && accion != 2){
      alerts.showNotification("top", "right", "Elige el motivo de la liberación.", "warning");
    }else if (!comentario) {
      alerts.showNotification("top", "right", "Añade un comentario para actualizar la liberación.", "warning");
    }else{
      alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
  }
  
  else if (id_rol_general == 2) {
    let costoM2 = $('#costoM2').val().replace('$', '').replace(',', '');
    let cost = $('#cost').val().replace('$', '').replace(',', '');
    parseFloat(costoM2,cost);
    
    if (accion == 1) {
      if(costoM2 != cost) {
        $.ajax({
          url: general_base_url + 'Contraloria/avance_estatus_liberacion',
          type: 'POST',
          data: {
            "idLote": idLote,
            "accion": accion,
            "idLiberacion": idLiberacion,
            "comentario": comentario,
            "activeLE": selLib == 7 ? true : false,
            "activeLP": selLib == 1 ? true : false,
            "id_proy": idProyecto,
            "idCondominio": idCondominio,
            "id_usuario": id_usuario_general,
            "tipo": motLib,
            "nombreLote": nombreLote,
            "precio": precio,
            "costoM2": costoM2,
            "clausulas": clausulas
          },
          dataType: 'JSON', 
          success: function (data)  {
            if (data == 1) {
              alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
              $("#historialLib").DataTable().ajax.reload();
              closeModal();
            } else {
              alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error:', jqXHR.status, errorThrown);
          }
        });
      } else if(costoM2 == cost){
        alerts.showNotification("top", "right", "Actualiza el precio para actualizar la liberación.", "warning");
      }
    }else if(accion == 2){
      $.ajax({
        url: general_base_url + 'Contraloria/avance_estatus_liberacion',
        type: 'POST',
        data: {
          "idLote": idLote,
          "accion": accion,
          "idLiberacion": idLiberacion,
          "comentario": comentario
        },
        dataType: 'JSON', 
        success: function (data)  {
          if (data == 1) {
            alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
            $("#historialLib").DataTable().ajax.reload();
            closeModal();
          } else {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error('Error:', jqXHR.status, errorThrown);
        }
      });
    }else {
      alerts.showNotification("top", "right", "Oops, algo salió mal5555.", "danger");
    }
  }
  else {
    if (comentario && accion) {
      $.ajax({
        url: general_base_url + 'Contraloria/avance_estatus_liberacion',
        type: 'POST',
        data: {
          "idLote": idLote, 
          "accion": accion, 
          "idLiberacion": idLiberacion, 
          "comentario": comentario 
        },
        dataType: 'JSON',
        success: function (data) {
          if(data == 1){
            alerts.showNotification("top", "right", "El registro se ha actualizado con éxito.", "success");
            $("#historialLib").DataTable().ajax.reload();
            closeModal();
          }else{
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error:', jqXHR.status, errorThrown);
        },
        catch: function () {},
      });
    }else if (!comentario) {
      alerts.showNotification("top", "right", "Añada un comentario para actualizar la liberación.", "warning");
    }else{
      alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
    }
  }
});

function openHistorialModal(idLote) { 
  $.ajax({
    url: general_base_url + 'Contraloria/get_historial_liberaciones_por_lote',
    type: 'POST',
    data: {
      "idLote": idLote,
    },
    dataType: 'JSON',
    success: function (res) {
      $.each( res, function(i, v){
        fillChangelog(i, v);
      });
      $("#seeInformationModal").modal('show')
    },
    error: function () {},
    catch: function () {},
  });
}

function fillChangelog (i, v) {
  let liberacionTexto = v.id_proceso === 1 ? 'RESCISIÓN' : 'DEVOLUCIÓN';
  let txtRechazado = '';
  if (v.proceso_realizado == '1') {
    txtRechazado = '<b>REGRESADO A: </b>'
  }
  $("#changelog").append('<li>\n' +
'            <a><b>Campo: </b>PROCESO</a>\n' +
'            <a style="float: right">'+v.fecha_modificacion.split('.')[0]+'</a><br>\n' +
'            <a><b>Tipo de liberación:</b> '+ liberacionTexto +'</a> \n' +
'            <br>\n' + 
'            <a><b>Estatus: </b> '+txtRechazado+v.nombre_proceso.toUpperCase()+' </a>\n' +
'            <br>\n' +  
'            <a><b>Modificado por: </b> '+(v.nombre_u+' '+v.ap_u+ ' '+ v.am_u).toUpperCase()+' </a>\n' +
'            <br>\n' +
'            <a><b>Comentarios: </b> '+v.justificacion_liberacion+' </a>\n' +
    '</li>');
}

function fillModal(accion, idLote, tipoLiberacion, idCondominio, idProyecto, nombreLote, precio,clausulas='') {
  let modalTitle = document.getElementById("modal-title");
  let modalContent = document.getElementById("contenido");  
  $('#idlote').val(idLote);
  $('#accion').val(accion);
  $('#idLiberacion').val(tipoLiberacion);
  $('#idCondominio').val(idCondominio);
  $('#idProyecto').val(idProyecto);
  $('#nombreLote').val(nombreLote);
  $('#precio').val(precio); 
  $('#clausulas').val(clausulas);
  let picker = document.getElementById("contenidoTip");
  let pickerb = document.getElementById("contenidoMot");
  let inp = document.getElementById("cambioPrecio");

  if (accion == 1 && id_rol_general == 2 ) { 
    modalTitle.innerHTML = "<b>¿Estás seguro de validar la liberación?</b>";
    modalContent.innerHTML= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>"+
    "<label class='control-label'>Comentarios (<span class='isRequired'>*</span>)</label>"+
    "<input class='text-modal mb-1' name='Comentarios' id='comentario' autocomplete='off'></div>" +
    "</div>";  
    
    picker.style.display = "block"; 
    pickerb.style.display = "block"; 
    inp.style.display = "block";
    
    let costoM2 = document.getElementById("costoM2");
    let cost = document.getElementById("cost");
    cost.value = `${formatMoney(precio)}`;
    costoM2.value = `${formatMoney(precio)}`;    
    
    $('#modalGeneral').modal('show');
  }
  else{
    modalTitle.innerHTML = "<b>¿Estás seguro de validar la liberación?</b>";
    modalContent.innerHTML= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>"+
    "<label class='control-label'>Comentarios (<span class='isRequired'>*</span>)</label>"+
    "<input class='text-modal mb-1' name='Comentarios' id='comentario' autocomplete='off'>"+
    "<br><br></div>";
    
    picker.style.display = "block"; 
    pickerb.style.display = "block"; 
    inp.style.display = "none";

    $('#modalGeneral').modal('show');
  }
  
  if (accion == 3) {
    modalTitle.innerHTML = "<b>¿Estás seguro de validar la liberación?</b>";
    modalContent.innerHTML= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>"+
    "<label class='control-label'>Comentarios (<span class='isRequired'>*</span>)</label>"+
    "<input class='text-modal mb-1' name='Comentarios' id='comentario' autocomplete='off'>"+
    "<br><br></div>"; 
    
    picker.style.display = "block"; 
    pickerb.style.display = "block"; 
    inp.style.display = "none";
    
    $('#modalGeneral').modal('show');
  }
  
  if(accion == 2){ 
    modalTitle.innerHTML = "<b>¿Estás seguro de invalidar la liberación?</b>";
    modalContent.innerHTML=" <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>"+
    "<label class='control-label'>Comentarios (<span class='isRequired'>*</span>)</label>"+
    "<input class='text-modal mb-1' name='Comentarios' id='comentario' autocomplete='off'>"+
    "<br><br></div>";
    
    picker.style.display = "none";
    pickerb.style.display = "none";
    inp.style.display = "none";
    
    $('#modalGeneral').modal('show');
  }
}

function closeModal() {
  $('#modal-title').text('');
  $('#modal-content').text('');
  $('#idlote').val('');
  $('#accion').val(''); 
  $('#idLiberacion').val('');
  $('#modalGeneral').modal('hide');
  $('#idLote').val('')
  $('#idCondominio').val('');
  $('#idProyecto').val('');
  $('#nombreLote').val('');
  $('#precio').val('');
  $('#costoM2').val('');
  $('#cost').val('');
  $('#selLib').val('');
  $('#motLib').val('');
}

function cleanComments() { 
  let myChangelog = document.getElementById('changelog');
  myChangelog.innerHTML = '';
}

const AccionDoc = { 
  DOC_NO_CARGADO: 1, // NO HAY DOCUMENTO CARGADO
  DOC_CARGADO: 2, // LA RAMA TIENE UN DOCUMENTO CARGADO
  SUBIR_DOC: 3, // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
  ELIMINAR_DOC: 4, // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
  ENVIAR_SOLICITUD: 5,
};//

Shadowbox.init();

 /** Función para crear el botón a partir del tipo de acción
 * @param {number} type
 * @param {any} data
 * @returns {string}
 */

$(document).on("click", ".verDocumento", function () {
  const $itself = $(this);
  let archivo = $itself.attr("data-expediente");
  let cadenaSinEspacios = archivo.replace(/\s/g, '');
  let pathUrl = `${general_base_url}static/documentos/cliente/rescision/${cadenaSinEspacios}`;
  
  if (screen.width > 480 && screen.width < 800) {
    window.location.href = `${pathUrl}`;
  } else {
    Shadowbox.open({
      content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${pathUrl}"></iframe></div>`,
      player: "html",
      title: `Visualizando archivo:  ${cadenaSinEspacios}  `,
      width: 985,
      height: 660,
    });
  }
});

function crearBotonAccion(type, data) {
  const [
    buttonTitulo,
    buttonEstatus,
    buttonClassColor,
    buttonClassAccion,
    buttonTipoAccion,
    buttonIcono,
  ] = getAtributos(type);
  const d = new Date();
  const dateStr = [d.getMonth() + 1, d.getDate(), d.getFullYear()].join("-");
  
  const tituloDocumento = `${data.nombreLote}_${data.idLote}_${data.idCliente}` + `_TDOC${data.tipo_doc}${data.movimiento}_${dateStr}`;
  
  return `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" 
  data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEstatus} data-toggle="tooltip" data-placement="top" 
  data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}" data-tituloDocumento="${tituloDocumento}" 
  data-idCliente="${data.idCliente ?? data.id_cliente}" data-lp="${data.lugar_prospeccion}" data-idProspeccion="${data.id_prospecto}">
  <i class="${buttonIcono}"></i></button>`;
}

/** Función para obtener los atributos del botón de acción de la tabla
 * @param {number} type
 * @returns {string[]}
 */

function getAtributos(type) {
  let buttonTitulo = "";
  let buttonEstatus = "";
  let buttonClassColor = "";
  let buttonClassAccion = "";
  let buttonIcono = "";
  let buttonTipoAccion = "";
  
  if (type === AccionDoc.DOC_CARGADO) {
    buttonTitulo = "VER DOCUMENTO";
    buttonEstatus = "";
    buttonClassColor = "btn-data btn-blueMaderas";
    buttonClassAccion = "verDocumento";
    buttonIcono = "fas fa-eye";
    buttonTipoAccion = "3";
  }
  
  return [
    buttonTitulo,
    buttonEstatus,
    buttonClassColor,
    buttonClassAccion,
    buttonTipoAccion,
    buttonIcono,
  ];
}