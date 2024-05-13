$(document).ready(function () {
    console.log("JS file loaded...");
});

/**
 * newButton function => Create a custom button with parameters
 *
 * @param {string} btnClass
 * @param {string} title
 * @param {string} action
 * @param {object} data
 * @param {string} icon
 * @returns {string} 
 */
const newButton = (btnClass, title, action = '', data, icon) => {
    const CUSTOM_BTN = `<button class='${btnClass}'
        data-toggle='tooltip' 
        data-placement='top'
        title='${title.toUpperCase()}'
        data-accion='${action}'
        data-data='${JSON.stringify(data)}'>
            <i class='${icon}'></i>
        </button>`;

    return CUSTOM_BTN;
}

const datatableButtons = (d) => {
    const BTN_AVANCE_P1  = newButton('btn-data btn-green btn-accion', 'AVANZAR LIBERACIÓN A CONTRALORÍA', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_AVANCE_P2  = newButton('btn-data btn-green btn-accion', 'AVANZAR LIBERACIÓN A POSTVENTA', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_RECHAZO_P2 = newButton('btn-data btn-warning btn-accion', 'RECHAZAR LIBERACIÓN A POSTVENTA', 'RECHAZO', d, 'fas fa-thumbs-down');
    const BTN_AVANCE_P3  = newButton('btn-data btn-green btn-accion', 'AVANZAR LIBERACIÓN A CAJAS', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_LIBERA     = newButton('btn-data btn-green btn-accion', 'APROBAR LIBERACIÓN', 'AVANCE', d, 'fa fa-check');
    const BTN_NO_LIBERA  = newButton('btn-data btn-warning btn-accion', 'RECHAZAR LIBERACIÓN', 'RECHAZO', d, 'fa fa-times-circle');
    const BTN_INFO       = newButton('btn-data btn-blueMaderas historico', 'HISTORICO DE LA LIBERACIÓN', 'HISTORICO', d, 'fas fa-info');
    const BTN_VER_DOC    = newButton('btn-data btn-sky btn-archivo', 'VISUALIZAR ARCHIVO', 'VER-ARCHIVO', d, 'fas fa-eye');
    
    let NO_BTN = '';

    if (id_rol_general == 55) { // POSTVENTA
        if (d.enProcesoLiberacion === 0 ) return BTN_AVANCE_P1 + BTN_INFO ;
        if (d.enProcesoLiberacion === 1 ) return BTN_AVANCE_P1 + BTN_VER_DOC + BTN_INFO;
        if (d.enProcesoLiberacion === 3 ) return BTN_AVANCE_P3 + BTN_VER_DOC + BTN_INFO ;
        return BTN_INFO;
    }
    if (id_rol_general == 17) { // CONTRALORIA
        if (d.enProcesoLiberacion === 2) return BTN_AVANCE_P2 + BTN_RECHAZO_P2 + BTN_VER_DOC +BTN_INFO;
        return BTN_INFO;
    }
    if (id_rol_general == 12) { // CAJAS
        if (d.enProcesoLiberacion === 4) return BTN_LIBERA + BTN_NO_LIBERA + BTN_VER_DOC + BTN_INFO;
        return BTN_INFO;
    }
    return NO_BTN;
}

const fillInputs = () => {
    const documentos = Object.freeze({
        LIB_PARTICULARES: 130,
    })

    $catalogo = null;
    switch ( id_rol_general ) {
        case 130:
            $catalogo = documentos.LIB_PARTICULARES;
            break;
        default:
            break;
    }

    $.ajax({
        url: "obtenerDocumentacionPorLiberacion",
        type: "POST",
        data: {catalogo: 31},
        dataType: "json",
        success: function(data) {
            for (let i = 0; i < data.length; i++) {
                if ([51, 52].includes(data[i]['id_opcion'])) $("#id_documento_liberacion").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            }
            $('#id_documento_liberacion').selectpicker('refresh');
        }
    });
}

$(document).on("change", "#archivo_liberacion", function () {
    const target = $(this);
    const relatedTarget = target.siblings(".file-name");
    const fileName = target[0].files[0].name;
    relatedTarget.val(fileName);
});

$(document).on('keyup', "input[data-type='currency']", function() {
    formatCurrencyG($(this));
});

// Encabezados de datatable
let titulosTabla = [];
$('#liberacionesDataTable thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulosTabla.push(title);
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($('#liberacionesDataTable').DataTable().column(i).search() !== this.value) {
            $('#liberacionesDataTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});

// DATATABLE
let liberacionesDataTable = $('#liberacionesDataTable').DataTable({
    dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
    width: '100%',
    scrollX: true,
    buttons: [{
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
        className: 'btn buttons-excel',
        titleAttr: 'Liberación de lotes (Particulares)',
        title:"Liberación de lotes (Particulares)",
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    },
    {
        extend: 'pdfHtml5',
        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
        className: 'btn buttons-pdf',
        titleAttr: 'Liberación de lotes (Particulares)',
        title:"Liberación de lotes (Particulares)",
        orientation: 'landscape',
        pageSize: 'LEGAL',
        exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 21, 22, 24],
            format: {
                header: function (d, columnIdx) {
                    return ' ' + titulosTabla[columnIdx] + ' ';
                }
            }
        }
    }],
    columnDefs: [
        {
            searchable: true,
            visible: true
        },
        { 
            orderable: true, 
            targets: '_all' 
        }
    ],
    pageLength: 4,
    bAutoWidth: false,
    fixedColumns: true,
    ordering: true,
    language: {
        url: general_base_url+"static/spanishLoader_v2.json",
        paginate: {
            previous: "<i class='fa fa-angle-left'>",
            next: "<i class='fa fa-angle-right'>"
        }
    },
    order: [[15, 'DESC']],
    destroy: true,
    columns: [
        {
            data: (d) => {
                if (d.enProcesoLiberacion === 0 || d.estatus_lib === 1) return `<span class="label" style="color: #1B4F72; background: #1B4F7218;}">NUEVO</span>`;
                if (d.estatus_lib === 2) return `<span class="label" style="color: #B03A2E; background: #B03A2E18;}">RECHAZO</span>`;
                if (d.estatus_lib === 3) return `<span class="label" style="color: #DF7314; background: #DF731418;}">CORRECCIÓN</span>`;
                return 'SIN ESPECIFICAR';
            }
        },
        { data: "nombreProcesoLiberacion" },
        { data: "nombreResidencial" },
        { data: "nombreCondominio" },
        { data: "nombreLote" },
        { data: "idLote" },
        { data: "cliente" },
        { data: "nombreAsesor" },
        { data: "nombreCoordinador" },
        { data: "nombreGerente" },
        { data: "nombreSubdirector" },
        { data: "nombreRegional" },
        { data: "nombreRegional2" },
        { data: "fechaApartado" },
        { data: "sup"},
        {
            data: function (d) {
                return d.costom2f == 'SIN ESPECIFICAR' ? d.costom2f : `${formatMoney(d.costom2f)}`;
            }
        },
        {
            data: function (d) {
                return `${formatMoney(d.total)}`
            }
        },
        {
            data: function (d) {
                return `<div class="d-flex justify-center">${datatableButtons(d)}</div>`;
            }
        }
    ],
    ajax: {
        url: `${general_base_url}Liberaciones/getLotesParaLiberacion`,
        dataSrc: "",
        type: "POST",
        cache: false,
    },
    initComplete: function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    }
});

// ABRIR MODAL
$(document).on('click', '.btn-accion', async function(){

    // Leemos los datos del registro
    const d = JSON.parse($(this).attr("data-data"));
    const accion = $(this).attr("data-accion");

    // Creamos titulo y titulo comentario
    let titulo = '';
    if (accion === 'AVANCE') titulo = '<h4><b>Avanzar</b> la liberación del lote <b>'+d.nombreLote+'</b></h4>'    
    if (accion === 'RECHAZO') titulo = '<h4>¿Está seguro de <b>rechazar</b> la liberación del lote <b>'+d.nombreLote+'</b>?</h4>'
    if (accion === 'HISTORICO') titulo = '<h4>Historico del proceso de liberación de <b>'+d.nombreLote+'</b>?</h4>'    

    let comentarioLabel = 'Comentario (opcional)';
    if (accion === 'RECHAZO') comentarioLabel = 'Motivo del rechazo (opcional)';
    if (d.enProcesoLiberacion === 3 && accion === 'AVANCE') comentarioLabel = 'Plazo: (*)';

    // Embebemos contenido a header y comentario.
    $('#labelHeaderAccionModal').html(titulo);
    $('#labelComentarioAccionModal').html(comentarioLabel);

    // Declaramos el contenido extra que embeberemos
    let content = ``;
    if (d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1) {
        content = `
            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 overflow-hidden">
                <label class="control-label" for="id_documento_liberacion">Documento a adjuntar (*)</label>
                <select id="id_documento_liberacion" name="id_documento_liberacion" class="selectpicker select-gral" data-style="btn" data-show-subtext="true" title="Selecciona una opción" data-size="7" size="5" data-container="body" required></select>
            </div>
            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1">
                <div id="selectFileSection">
                    <div class="file-gph">
                        <input type="file" accept="application/pdf" id="archivo_liberacion">
                        <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                        <label class="upload-btn m-0" for="archivo_liberacion">
                            <span>Seleccionar</span>
                            <i class="fas fa-folder-open"></i>
                        </label>
                    </div>
                </div>
            </div>`;
    }
    if (d.enProcesoLiberacion === 3) {
        content = `
            <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="cambioPrecio">
                <label class="control-label"> Precio por m<sup>2</sup> (<span class="isRequired">*</span>)</label>
                <input class="form-control input-gral" placeholder="$" name="costoM2" id="costoM2" data-type="currency" step="any">
            </div>`;
    }

    // Embebemos el contenido extra
    $('#extra-content-accion-modal').html(content);
    if (d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1) fillInputs(); //Cargamos los valores de los inputs

    // Limpiamos valores de los campos antes de abrir el modal.
    $('#comentarioAccionModal').val('');

    // Mostramos el modal y mostramos la info del lote en el modal
    $('#accion-modal').modal('show');

    // Le agregamos la información que vallamos a usar en caso de confirmar el modal
    const info = 
        '<input type="hidden" id="accion"></input>' + 
        '<input type="hidden" id="data"></input>' ;
    $('#data-modal').append(info);
    
    // Asignación de valores a los inputs
    $("#accion").val(accion);
    $("#data").val(JSON.stringify(d));
});

// FUNCIONALIDAD DEL BOTÓN DE ACEPTAR DEL MODAL
$(document).on("click", "#btn-accion", async function (e) {
    e.preventDefault();

    // Obteniendo los valores para su proceso
    const accion = $("#accion").val();
    const d = JSON.parse($("#data").val());
    let comentario = $('#comentarioAccionModal').val();
    let tieneRescision = 0;
    let tieneAutorizacionDG = 0;
    let relatedTarget, proceso, estatusLib, rescision, autorizacionDG, concepto, precioLiberacion, plazo;

    //Validaciones en caso de tener
    if ((d.enProcesoLiberacion === 1 || d.enProcesoLiberacion === 0)) { // POSTVENTA: LIBERAR LOTE O AL COLOCAR PLAZO. 
        if ($("#id_documento_liberacion").val() ==  51) tieneRescision = 1; // idOpcion en oxc catalogo 31
        if ($("#id_documento_liberacion").val() ==  52) tieneAutorizacionDG = 1;
        relatedTarget = $('#archivo_liberacion').siblings(".file-name");
        
        // Select de tipo de archivo vacio
        if (tieneRescision === 0 && tieneAutorizacionDG === 0) return alerts.showNotification("top", "right", "Seleccione el tipo de archivo a adjuntar.", "warning");
        
        // Input sin archivo
        if (relatedTarget.val() === '') return alerts.showNotification("top", "right", "Seleccione el archivo a adjuntar.", "warning");
        
    }
    if ((d.enProcesoLiberacion === 3 )) { // POSTVENTA: Generar las condiciones de venta (precio, plazo).
        precioLiberacion = $('#costoM2').val().replace('$', '').replace(',', ''); // El precio del lote
        plazo = comentario; // El plazo es el input del comentario
        comentario = ''; // El comentario no está habilitado para el proceso de liberación para el proceso 3
        
        // Input de precio sin monto
        if (precioLiberacion === '') return alerts.showNotification("top", "right", `Digite el nuevo precio por m<sup>2</sup> del lote.`, "warning");

         // Input de plazo sin valor
         if (plazo === '') return alerts.showNotification("top", "right", "Digite el plazo.", "warning");
    }

    // Asignación de valores dependiendo el proceso
    if (accion === 'AVANCE') {
        proceso = d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1 ? 2 : d.enProcesoLiberacion + 1; // Avanza proceso
        estatusLib = d.estatus_lib === 2 ? 3 : 1; // 1: avance normal, 2 rechazo y 3 correccion.
        rescision = d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1 ? tieneRescision :d.rescision; // Si esta en el proceso 0 o 1, el valor es el input, si no el que ya habia registrado.
        autorizacionDG = d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1 ? tieneAutorizacionDG : d.autorizacion_DG; // Si esta en el proceso 0 o 1, el valor es el input, si no el que ya habia registrado.
        concepto = d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1 ? 1 : d.concepto;
        if ( d.enProcesoLiberacion >=  4 ) {
            precioLiberacion = d.precioLiberacion;
            plazo = d.plazo;
        }
    }
    if (accion === 'RECHAZO') {
        proceso = d.enProcesoLiberacion  === 4 ? d.enProcesoLiberacion + 2 : d.enProcesoLiberacion - 1; // Rechaza proceso, si proceso = 4 entonces se finaliza y es otro estatus.
        estatusLib = d.enProcesoLiberacion  === 4 ? 1 : 2; // Estatus de liberacion es rechazo
        rescision = proceso === 1 ? 0 : d.rescision; // Si lo regresan para validar doc, se asigna 0 sino el que ya tenia registrado.
        autorizacionDG = proceso === 1 ? 0 : d.autorizacion_DG; // Si lo regresan para validar doc, se asigna 0 sino el que ya tenia registrado.
        concepto = d.concepto;
        if ( d.enProcesoLiberacion >=  4 ) {
            precioLiberacion = d.precioLiberacion;
            plazo = d.plazo;
        }
    }

    // Loading y disables mientras hace la carga
    $('#btn-accion').attr('disabled', true); // Deshabilita botón
    $('#spiner-loader').removeClass('hide'); // Aparece spinner

    // Datos a envíar al endpoint para su registro.
    const data = new FormData();
    data.append("idLote", d.idLote);
    data.append("id_cliente", d.idCliente);
    data.append("rescision", rescision);
    data.append("autorizacion_DG", autorizacionDG);
    data.append("proceso_lib", proceso);
    data.append("estatus_lib", estatusLib);
    data.append("concepto", concepto);
    data.append("comentario", comentario);
    if (precioLiberacion) data.append("precioLiberacion", precioLiberacion); // Solo se envia cuando tenga valor o mas bien cuando no sea null, undefined, false, 0, NaN.
    if (plazo) data.append("plazo", plazo); // Solo se envia cuando tenga valor o mas bien cuando no sea null, undefined, false, 0, NaN.
    $.ajax({
        type: 'POST',
        url: 'actualizaLiberacionLote',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            const res = JSON.parse(data);
            alerts.showNotification("top", "right", res.msg, res.status === 200 ? "success" : "warning");
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
    liberacionesDataTable.ajax.reload();
    $('#accion-modal').modal('hide');
    $('#btn-accion').attr('disabled', false);  // Lo vuelvo a activar
    $('#spiner-loader').addClass('hide'); // Quito spinner  

    // En caso de ser el ultimo proceso, ya se libera.
    if (d.enProcesoLiberacion === 4 && proceso === 5) {
        // Generamos el token para liberar el lote
        let res = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Api/getToken`,
            data: JSON.stringify({"id": 6489}),
            contentType: 'application/json',
            cache: false,
            processData: false,
        });

        res = JSON.parse(res);

        // Realizamos la acción de la función que libera el lote!
        let data = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Caja_outside/caja_modules`,
            headers: {
                'Authorization': res.id_token
            },
            data: JSON.stringify({
                "accion": 3,
                "activeLE": false,
                "activeLP": false,
                "id_proy": d.idResidencial,
                "idCondominio": d.idCondominio,
                "id_usuario": id_usuario_general,
                "tipo": "1",
                "lotes": [
                    {
                        "nombreLote": d.nombreLote,
                        "idLote": d.idLote,
                        "precio": precioLiberacion,
                        "tipo_lote": "1"
                    }
                ]
            }),
            contentType: 'application/json',
            cache: false,
            processData: false,
        });

        // Notificamos al usuario
        data = JSON.parse(data);
        alerts.showNotification("top", "right", data.message === 'SUCCESS' ? 'La liberación se ha completado' : 'Surgió un error al intentar liberar el lote', data.message === 'SUCCESS' ? "success" : "warning");
    }
});

const fillChangelog = (i, v) => {
    let liberacionTexto = v.id_proceso === 1 ? 'RESCISIÓN' : 'DEVOLUCIÓN';
    let accion = '<b>ENVIADO A: </b>'
    if (v.proceso_realizado == '1') {
        accion = '<b>REGRESADO A: </b>'
    }
    if (i === 1 ) {
        console.log('v', typeof v, v);
    }
    $("#changelog").append('<li>\n' +
  '            <a><b>Campo: </b>PROCESO</a>\n' +
  '            <a style="float: right">'+v.fecha_modificacion+'</a><br>\n' +
  '            <a><b>Tipo de liberación:</b> '+ v.nombreConceptoLiberacion + '</a> \n' +
  '            <br>\n' + 
  '            <a><b>Estatus: </b> '+accion+v.nombreProcesoLiberacion.toUpperCase()+' </a>\n' +
  '            <br>\n' +  
  '            <a><b>Modificado por: </b> '+(v.nombreMod+' '+v.ap1_mod+ ' '+ v.ap2_mod).toUpperCase()+' </a>\n' +
  '            <br>\n' +
  '            <a><b>Comentario: </b> '+v.comentario+' </a>\n' +
      '</li>');
}

$(document).on('click', '.historico', async function(){
    // Leemos los datos del registro
    const d = JSON.parse($(this).attr("data-data"));
    $("#changelog").html('');

    // ACTION
    $.ajax({
        url: general_base_url + 'Liberaciones/historialLiberacionLote',
        type: 'POST',
        data: {
          "idLote": d.idLote,
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
});