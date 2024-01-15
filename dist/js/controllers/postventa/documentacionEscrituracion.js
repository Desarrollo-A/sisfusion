
let headersTable = ['ID SOLICITUD','PROYECTO','LOTE','CLIENTE','VALOR DE OPEACIÓN','FECHA CREACIÓN','ESTATUS','ÁREA','ASIGANADA A','CREADA POR','COMENTARIOS','OBSERVACIONES','ACCIONES'];

$('#escrituracion-datatable thead tr:eq(0) th').each( function (i) {
  let title = $(this).text();
  let width = i == 0 || i == 1 || i == 7 || i == 4 || i == 10 || i==2 || i == 5 || i == 8 ? '' : '';     
  $(this).html(`<input class="${width}" id="head_${i}" data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${headersTable[i]}"/>` );
  $( 'input', this ).on('keyup change', function () {
    if ($('#escrituracion-datatable').DataTable().column(i).search() !== this.value ) {
      $('#escrituracion-datatable').DataTable().column(i).search(this.value).draw();
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
});


let arrayEstatusLote = [];

$(document).ready(function () {
  $(document).on(
    "fileselect",
    ".btn-file :file",
    function (event, numFiles, label) {
      let input = $(this).closest(".input-group").find(":text"),
        log = numFiles > 1 ? numFiles + " files selected" : label;
      if (input.length) {
        input.val(log);
      } else {
        if (log) alert(log);
      }
    }
  );
});

$(document).on("click", ".comentariosModel", function (e) { 
  e.preventDefault();
  e.stopImmediatePropagation();
  id_solicitud = $(this).attr("data-idSolicitud");
  lote = $(this).attr("data-lotes");
  $("#comentariosModal").modal();
  $("#titulo_comentarios").append(
    "<h4>Movimientos de Lote: <b>" + lote + "</b></h4>"
  );
});

function cleanCommentsAsimilados() {
  let myCommentsList = document.getElementById("comments-list-asimilados");
  let myCommentsLote = document.getElementById("titulo_comentarios");
  myCommentsList.innerHTML = "";
  myCommentsLote.innerHTML = "";
}

let integracionExpediente = new Object(); 

$(document).on("click", ".details-control", function () {
  let detailRows = [];
  let tr = $(this).closest("tr");
  let row = escrituracionTable.row(tr);
  let idx = $.inArray(tr.attr("id"), detailRows);
  if (row.child.isShown()) {
    tr.removeClass("details");
    row.child.hide();
    detailRows.splice(idx, 1);
  } else {
    $("#spiner-loader").removeClass("hide");
    tr.addClass("details");
    createDocRow(row, tr, $(this));
    integracionExpediente = {
      row: row,
      tr: tr,
      this: $(this),
    };
    if (idx === -1) {
      detailRows.push(tr.attr("id"));
    }
  }
});

function crearTablas(datosTablas,numTabla = ''){
  $(`#${datosTablas.nombreTabla}`).DataTable({
    dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: "100%",
    fixedHeader: true,
    scrollX: true,
    bAutoWidth: true,
    pagingType: "full_numbers",
    language: {
      url: "../static/spanishLoader_v2.json",
      paginate: {
        previous: "<i class='fa fa-angle-left'>",
        next: "<i class='fa fa-angle-right'>"
      }
    },
    destroy: true,
    ordering: false,
    columns: [
      {
        data: function (d) {
          return d.id_solicitud;
        }
      },
      {   
        data: function (d) {
          return d.nombreResidencial
        }
      },
      {
        data: function (d) {
          return d.nombreLote
        }
      },
      {
        data: function (d) {
          return d.cliente;
        }
      },
      {
        data: function (d) {
          return  formatMoney(d.valor_contrato);
        }
      },
      {
        data: function (d) {
          let fecha_inicio = moment(d.fecha_creacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
          return fecha_inicio;
        }
      },
      {
        data: function (d) {
          return `<center><span><b> ${d.nombre_estatus}</b></span><center>`;   
        }
      },
      {
        data: function (d) {
          return `<center>${d.area}</center>`;
        }
      },
      {
        data: function (d) {
          return `<center>${d.asignada_a}</center>`;
        }
      },
      {
        data: function (d) {
          return `<center>${d.creado}</center>`;
        }
      },
      {
        data: function (d) {
          if(d.id_estatus == 27 || d.id_estatus == 28 || d.id_estatus == 30 || d.id_estatus == 31){
            return '<b>Fecha firma: '+d.fecha_firma.split('.')[0]+'</b>';
          }else{
            return d.ultimo_comentario;
          }
        }
      },
      {
        data: function (d) {
          return  `<span class="label lbl-sky">${d.rechazo}</span><span class="label lbl-sky" >${d.vencimiento}</span><br><br>
          <div class="d-flex justify-center"><span class="label ${d.estatusAct == 'RECHAZO' ? 'lbl-warning' : 'lbl-green'}">${d.estatusAct}</span></div>`;
        }
      },
      {
        data: function (d) {
          let group_buttons = '';    
          $('[data-toggle="tooltip"]').tooltip();
          group_buttons += `<button id="trees${d.id_solicitud}" data-idSolicitud=${d.id_solicitud} class="btn-data btn-details-grey details-control" data-permisos="2" data-id-prospecto="" data-toggle="tooltip" data-placement="top" title="Desglose documentos"><i class="fas fa-chevron-down"></i></button>`;
          group_buttons += `<button data-idSolicitud=${d.id_solicitud} data-lotes=${d.nombreLote} class="btn-data btn-details-grey comentariosModel" data-permisos="1" data-id-prospecto="" data-toggle="tooltip" data-placement="left" title="HISTORIAL DE COMENTARIOS"><i class="fa fa-history"></i></button>`;
          return '<div class="d-flex justify-center">' + group_buttons + '<div>';
        }
      },
    ],
    columnDefs: [{
      "searchable": true,
      "orderable": false,
      "targets": 0
    }],
    ajax: {
      url: datosTablas.url,
      type: "POST",
      cache: false,
      data: datosTablas.data
    },
    initComplete: function() {
      numTabla == 0 ? escrituracionTable = $('#escrituracion-datatable').DataTable() : ''; 
    },
  });
}

let arrayTables = [
  {'nombreTabla' : 'escrituracion-datatable',
  'data':{},
  'url':'getSolicitudesDocs',
  'numTable':0
}];

for (let z = 0; z < arrayTables.length; z++) {
  arrayTables[z].data =  {
    "beginDate": 0,
    "endDate": 0,
    "estatus": 0,
    "tipo_tabla":arrayTables[z].numTable 
  };
  crearTablas(arrayTables[z]);
}

let documentosObligatorios = []; 

function buildTableDetail(data) {
  documentosObligatorios = [];
  let filtered = data.filter(function(value){ 
    return value;
  });
  let solicitudes = '<table class="table subBoxDetail">';
  solicitudes += '<tr style="border-bottom: 1px solid #fff; color: #4b4b4b;">';
  solicitudes += '<td>' + '<b>' + '# ' + '</b></td>';
  solicitudes += '<td>' + '<b>' + 'DOCUMENTO ' + '</b></td>';
  solicitudes += '<td>' + '<b>' + 'CARGADO POR ' + '</b></td>';
  solicitudes += '<td>' + '<b>' + 'FECHA ' + '</b></td>';
  solicitudes += '<td>' + '<b>' + 'MOTIVOS DE RECHAZO ' + '</b></td>';
  solicitudes += '<td>' + '<b>' + 'VALIDADO POR ' + '</b></td>';
  solicitudes += '<td>' + '<b>' + 'ESTATUS VALIDACIÓN ' + '</b></td>';
  solicitudes += '<td>' + '<b>' + 'ACCIONES ' + '</b></td>';
  solicitudes += '</tr>';
  $.each(filtered, function (i, v) {
    let documento = v.tipo_documento == 12 ? v.expediente : v.descripcion;
    solicitudes += '<tr>';
    solicitudes += '<td> ' + (i + 1) + ' </td>';
    solicitudes += '<td> ' + documento + ' </td>';
    solicitudes += '<td> ' + v.documento_creado_por + ' </td>';
    let fecha_inicio = moment(v.fecha_creacion.split('.')[0],'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss')
    solicitudes += '<td> ' + fecha_inicio + ' </td>';
    solicitudes += '<td> ' + v.motivos_rechazo + ' </td>';
    solicitudes += '<td> ' + v.validado_por + ' </td>';
    solicitudes += `<td> <span class="label" style="background:${v.colour}">${v.estatus_validacion}</span>${v.editado == 1 ? `<br><br><span class="label" style="background:#C0952B">EDITADO</span>`:``} </td>`;
    solicitudes += '<td><div class="d-flex justify-center">';
    
    if (v.expediente == null || v.expediente == ''){
      solicitudes +=  `<span class="label lbl-gray"> No se ha cargado el archivo </span>`;
    } else{
      let expe = v.tipo_documento == 12 ? v.movimiento : v.expediente;
      solicitudes +=  `<button id="preview" data-documentType="${v.tipo_documento}" data-doc="${expe}" class="btn-data btn-gray" data-toggle="tooltip" data-placement="left" title="Vista previa"><i class="fas fa-eye"></i></button>`;
    }
    solicitudes += '</div></td></tr>';
  });
  return solicitudes += '</table>';
}

function createDocRow(row, tr, thisVar) { //BORRAR (TAL VEZ)
  $.post("getDocumentacionCliente", {
    idEscritura: row.data().id_solicitud,
    idEstatus: row.data().id_estatus,
  }).done(function (data) {
    row.data().solicitudes = JSON.parse(data);
    escrituracionTable.row(tr).data(row.data());
    row = escrituracionTable.row(tr);
    row
      .child(
        buildTableDetail(
          row.data().solicitudes,
          $(".details-control").attr("data-permisos"),
          1
        )
      )
      .show();
    tr.addClass("shown");
    thisVar
      .parent()
      .find(".animacion")
      .removeClass("fa-caret-right")
      .addClass("fa-caret-down");
    $("#spiner-loader").addClass("hide");
  });
}

function getEstatusEscrituracion() {
  $("#spiner-loader").removeClass("hide");
  $("#spiner-loader").addClass("hide");
}

$(document).on("click", "#preview", function () {
  let itself = $(this);
  let folder;
  switch (itself.attr('data-documentType')) {
    case '1':
      folder = "INE";
    break;
    case '2':
      folder = "RFC";
    break;
    case '3':
      folder = "COMPROBANTE_DE_DOMICILIO";
    break;
    case '4':
      folder = "ACTA_DE_NACIMIENTO";
    break;
    case '5':
      folder = "ACTA_DE_MATRIMONIO";
    break;
    case '6':
      folder = "CURP";
    break;
    case '7':
      folder = "FORMAS_DE_PAGO";
    break;
    case '8':
      folder = "BOLETA_PREDIAL";
    break;
    case '9':
      folder = "CONSTANCIA_MANTENIMIENTO";
    break;
    case '10':
      folder = "CONSTANCIA_AGUA";
    break;
    case '11':
      folder = "SOLICITUD_PRESUPUESTO";
    break;
    case '12':
      folder = "PRESUPUESTO";
    break;
    case '13':
      folder = "FACTURA";
    break;
    case '14':
      folder = "TESTIMONIO";
    break;
    case '15':
      folder = "PROYECTO_ESCRITURA";
    break;
    case '16':
      folder = "ACTA_CONSTITUTIVA";
    break;
    case '17':
      folder = "OTROS";
    break;
    case '18':
      folder = "CONTRATO";
    break;
    case '19':
      folder = "COPIA_CERTIFICADA";
    break;
    case '20':
      folder = "PRESUPUESTO_NOTARIA_EXTERNA";
    break;
    case '21':
      folder = "RFC_MORAL";
    break;
    case '22':
      folder = "FORMAS_PAGO_FECHA";
    break;
    case '23':
      folder = "CHECK_LIST";
    break; 
    case '24':
      folder = "BENEFICIARIO_CONTROLADOR";
    break; 
    case '25':
      folder = "CARATULAS_BANCARIAS";
    break;  
    case '26':
      folder = "ESTADOS_DE_CUENTA";
    break;
    default:
    break;
  }
  Shadowbox.open({
    content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;z-index:999999!important;" src="${general_base_url}static/documentos/postventa/escrituracion/${folder}/${itself.attr('data-doc')}"></iframe></div>`,
    player: "html",
    title: `Visualizando archivo: ${itself.attr('data-doc')} `,
    width: 985,
    height: 660
  });
});  