const LIBERACION = Object.freeze({
    PARTICULARES: 133,
    RESCISION: 134,
    BLOQUEADOS: 148,
    SIN_CONTRATO: 500,
})

const TIPO_VENTA = Object.freeze({
    PARTICULARES: 1,
    NORMALES: 2
});

const ROLES = Object.freeze({
    VENTAS: 3,
    SUBDIRECCION: 2,
    ASISTENTE_SUBDIRECCION: 5,
    CAJAS: 12,
});

const PROCESO = Object.freeze({
    INICIO: 0,
    CAMBIO_PRECIO: 1, // MAS DE 30 DÍAS BLOQUEADO
    SOLICITUD_LIBERACION: 2,
    FINALIZADO_LIBERADO: 3,
    FINALIZADO_NO_LIBERADO: 4,
});

const AVANCE = Object.freeze({
    NORMAL: 1,
    RECHAZO: 2,
    CORRECCIÓN: 3,
});

const CONCEPTO = Object.freeze({
    PARTICULARES:1, 
    JURIDICO:2,
    RESCISIÓN:3,
    SIN_CONTRATO:4,
    BLOQUEO:5,
});

let liberacionesDataTable;

$(document).ready(function(){
    // Manejamos la carga de inputs desde la carga del archivo de JS
    if (id_rol_general == ROLES.VENTAS || id_rol_general == ROLES.CAJAS){ // Postventa inicia proceso
        $('#spiner-loader').removeClass('hide'); // Aparece spinner
        $.ajax({
            type: 'POST',
            url: `${general_base_url}Liberaciones/getLotesBloqueados`,
            cache: false,
            success: function(rs) {
                const res = JSON.parse(rs);
                datatableFn(res, 1);
                $('#spiner-loader').addClass('hide'); // Aparece spinner
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                $('#spiner-loader').addClass('hide'); // Aparece spinner
            }
        });
    }

    // Pulsamos sobre el tab de proceso
    if (id_rol_general != ROLES.VENTAS && id_rol_general != ROLES.CAJAS) {
       $('#pendientes').click();
    }
});

// Pestaña de liberar lotes desde el primer paso.
$(document).on("click", "#liberar", function () {
    if (id_rol_general == ROLES.VENTAS || id_rol_general == ROLES.CAJAS){ // Postventa inicia proceso
        $('#spiner-loader').removeClass('hide'); // Aparece spinner
        $.ajax({
            type: 'POST',
            url: `${general_base_url}Liberaciones/getLotesBloqueados`,
            cache: false,
            success: function(rs) {
                const res = JSON.parse(rs);
                datatableFn(res, 1);
                $('#spiner-loader').addClass('hide'); // Aparece spinner
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                $('#spiner-loader').addClass('hide'); // Aparece spinner
            }
        });
    }
})

$(document).on("click", "#pendientes", function () {
    $('#spiner-loader').removeClass('hide'); // Aparece spinner

    $.ajax({
        type: 'POST',
        url: `${general_base_url}Liberaciones/getLotesPendientesBloqueo`,
        cache: false,
        success: function(rs) {
            const res = JSON.parse(rs);
            datatableFn(res, 1);
            $('#spiner-loader').addClass('hide'); // Desaparece spinner
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición AJAX:", error);
            $('#spiner-loader').addClass('hide'); // Desaparece spinner
        }
    });
})

$(document).on("click", "#proceso", function () {
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    
    $.ajax({
        type: 'POST',
        url: `${general_base_url}Liberaciones/getLotesEnProcesoBloqueo`,
        cache: false,
        success: function(rs) {
            const res = JSON.parse(rs);
            datatableFn(res, 2);
            $('#spiner-loader').addClass('hide'); // Desaparece spinner
        },
        error: function(xhr, status, error) {
            console.error("Error en la petición AJAX:", error);
            $('#spiner-loader').addClass('hide'); // Desaparece spinner
        }
    });
})

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

    let content = ``;
    if ((d.enProcesoLiberacion === PROCESO.CAMBIO_PRECIO )) { // POSTVENTA: Generar las condiciones de venta (precio, plazo).
        content = `
            <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="cambioPrecio">
                <label class="control-label"> Precio por m<sup>2</sup> (<span class="isRequired">*</span>)</label>
                <input class="form-control input-gral" placeholder="$" name="costoM2" id="costoM2" data-type="currency" step="any">
            </div>`;
    }
    // Embebemos el contenido extra
    $('#extra-content-accion-modal').html(content);
    //if (d.enProcesoLiberacion === 0 || d.enProcesoLiberacion === 1) fillInputs(); //Cargamos los valores de los inputs

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
    let archivo, proceso, estatusLib, rescision, autorizacionDG, concepto, precioLiberacion, plazo;
    let res; // Dato para saber los dias bloqueados de un lote.

    // VALIDACIONES: En caso de tener
    if ( d.enProcesoLiberacion === PROCESO.INICIO ) { // VENTAS O CAJA: LIBERAR LOTE O AL COLOCAR PLAZO. 
        // Loading y disables mientras hace la carga
        $('#btn-accion').attr('disabled', true); // Deshabilita botón
        $('#spiner-loader').removeClass('hide'); // Aparece spinner

        // Validamos cuantos días tiene el lote desde que se bloqueo.
        const body = new FormData();
        body.append("idLote", d.idLote);

        res = await $.ajax({
            type: 'POST',
            url: `${general_base_url}Liberaciones/getDiasBloqueosDeLote`,
            data: body,
            contentType: false,
            cache: false,
            processData: false,
        });

        res = JSON.parse(res);

        if (res.result !== true) {
            $('#btn-accion').attr('disabled', false);  // Lo vuelvo a activar
            $('#spiner-loader').addClass('hide'); // Quito spinner  
            return alerts.showNotification("top", "right", "Digita el plazo.", "warning");
        }
    }
    if ((d.enProcesoLiberacion === PROCESO.CAMBIO_PRECIO )) { // POSTVENTA: Generar las condiciones de venta (precio, plazo).
        precioLiberacion = $('#costoM2').val().replace('$', '').replace(',', ''); // El precio del lote
        comentario = comentario; // El comentario no está habilitado para el proceso de liberación para el proceso 3
        plazo = ''; // EN BLOQUEADOS NO APLICA EL PLAZO
        
        // Input de precio sin monto
        if (precioLiberacion === '') return alerts.showNotification("top", "right", `Digita el nuevo precio por m<sup>2</sup> del lote.`, "warning");
    }
    if ((d.enProcesoLiberacion === PROCESO.SOLICITUD_LIBERACION )) { // POSTVENTA: Generar las condiciones de venta (precio, plazo).
        // Poner la validación
    }

    // CAMBIO DE PROCESO: se dirige al proceso
    if (accion === 'AVANCE') {
        if ( d.enProcesoLiberacion === PROCESO.INICIO ) { // CUANDO INICIA EL PROCESO.
            if (res.days >= 30) proceso = PROCESO.CAMBIO_PRECIO;
            if (res.days < 30) proceso = PROCESO.SOLICITUD_LIBERACION;

            estatusLib = AVANCE.NORMAL;
            rescision = 0; // NO APLICA PARA BLOQUEADOS
            autorizacionDG = 0; // NO APLICA PARA BLOQUEADOS
            concepto = CONCEPTO.BLOQUEO;
        }
        if ( d.enProcesoLiberacion === PROCESO.CAMBIO_PRECIO ) { // CUANDO INICIA EL PROCESO.

            proceso = PROCESO.SOLICITUD_LIBERACION;
            estatusLib = AVANCE.NORMAL;
            rescision = 0; // NO APLICA PARA BLOQUEADOS
            autorizacionDG = 0; // NO APLICA PARA BLOQUEADOS
            concepto = CONCEPTO.BLOQUEO;
        }
    }
    if (accion === 'RECHAZO') {
        // NO HAY RECHAZOS EN BLOQUEOS SEGÚN EL DIAGRAMA 🤷‍♀️​
    }

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
    await $.ajax({
        type: 'POST',
        url: 'actualizaLiberacionLote',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            const res = JSON.parse(data);
            console.log('Actualiza proceso', res);
            alerts.showNotification("top", "right", res.msg, res.code === 200 ? "success" : "warning");
            if (res.code === 500) return;
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });

    // En caso de ser el ultimo proceso, ya se libera.
    if (d.enProcesoLiberacion === PROCESO.SOLICITUD_LIBERACION && proceso === FINALIZADO_LIBERADO) {
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
        console.log('getToken', res);

        // Realizamos la acción de la función que libera el lote!
        // PD TENGO QUE USAR ESA FUNCIÓN DE CAJA MODULES -> SOLO TENGO QUE ACTUALIZAR EL LOTE DE ESTATUS.
        /*
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
        */

        // Notificamos al usuario
        data = JSON.parse(data);
        console.log('Proceso liberación final', data);
        alerts.showNotification("top", "right", data.message === 'SUCCESS' ? 'La liberación se ha completado' : 'Surgió un error al intentar liberar el lote', data.message === 'SUCCESS' ? "success" : "warning");
        if (data.message != 'SUCCESS') return;
    }

    $('#accion-modal').modal('hide');
    $('#btn-accion').attr('disabled', false);  // Lo vuelvo a activar
    $('#spiner-loader').addClass('hide'); // Quito spinner  
    if (d.enProcesoLiberacion === 0) {
        $.ajax({
            type: 'POST',
            url: `${general_base_url}Liberaciones/getLotesBloqueados`,
            cache: false,
            success: function(rs) {
                const res = JSON.parse(rs);
                datatableFn(res, 1);
                $('#spiner-loader').addClass('hide'); // Aparece spinner
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                $('#spiner-loader').addClass('hide'); // Aparece spinner
            }
        });
    }else {
        $('#pendientes').click();
    }
});

$(document).on('click', '.btn-historico', async function(){
    $('.btn-historico').attr('disabled', true);  // Desactivo btn
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    // Leemos los datos del registro
    const d = JSON.parse($(this).attr("data-data"));
    $("#changelog").html('');

    // ACTION
    await $.ajax({
        url: general_base_url + 'Liberaciones/historialLiberacionLote',
        type: 'POST',
        data: {
          "idLote": d.idLote,
          "tipoVenta" : 1,
          "idProcesoTipoLiberacion": LIBERACION.PARTICULARES
        },
        dataType: 'JSON',
        success: function (res) {
          $.each( res, function(i, data){
            fillChangelog(i, data);
          });
          $("#seeInformationModal").modal('show')
        },
        error: function () {},
        catch: function () {},
    });
    $('.btn-historico').attr('disabled', false);  // Lo vuelvo a activar
    $('#spiner-loader').addClass('hide'); // Quito spinner  
});

$(document).on('click', '.btn-archivo', function () {
    $('.btn-archivo').attr('disabled', true);  // Desactivo btn
    $('#spiner-loader').removeClass('hide'); // Aparece spinner
    Shadowbox.init();
    const d = JSON.parse($(this).attr("data-data"));
    let filePath = `${general_base_url}Documentacion/archivo/${d.expediente}`;
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${filePath}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${d.movimiento}`,
        width: 985,
        height: 660
    });
    $('.btn-archivo').attr('disabled', false);  // Lo vuelvo a activar.
    $('#spiner-loader').addClass('hide'); // Quito spinner.
});

// DATATABLE
const datatableFn = (ndata, type) => {
    liberacionesDataTable = $('#liberacionesDataTable').DataTable({
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
            text: '<i class="fa fa-file-pdf" aria-hidden=s"true"></i>',
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
        pageLength: 10,
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
        order: [[10, 'DESC']],
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
            { data: "movimiento" },
            { data: "nombreResidencial" },
            { data: "nombreCondominio" },
            { data: "nombreLote" },
            { data: "idLote" },
            {   data: function (d) {
                return (d.cliente === null || d.cliente === '' || d.cliente === '  ') ? 'SIN ESPECIFICAR' : d.cliente;
                }
            },
            {   data: function (d) {
                    return (d.referencia === null || d.referencia === '') ? 'SIN ESPECIFICAR' : d.referencia;
                }
            },
            { data: "nombreAsesor" },
            { data: "nombreCoordinador" },
            { data: "nombreGerente" },
            { data: "nombreSubdirector" },
            { data: "nombreRegional" },
            { data: "nombreRegional2" },
            {   data: function (d) {
                return (d.fechaApartado === null || d.fechaApartado === '' || d.fechaApartado === '  ') ? 'SIN ESPECIFICAR' : d.fechaApartado;
                }
            },
            {
                data: function (d) {
                    return `${formatMoney(d.precio)}`
                }
            },
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
                    return d.precioLiberacion === null ? 'SIN ASIGNAR' : `${formatMoney(d.precioLiberacion)}`;
                }
            },
            {   data: function (d) {
                return (d.comentario === null || d.comentario === '' || d.comentario === '  ') ? 'SIN ESPECIFICAR' : d.comentario;
                }
            },
            {
                data: function (d) {
                    return `<div class="d-flex justify-center">${datatableButtons(d, type)}</div>`;
                }
            }
        ],
        data: ndata, // 4007
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        }
    });
}

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

const datatableButtons = (d, type) => {
    const BTN_AVANCE_P0  = newButton('btn-data btn-green btn-accion', 'AVANZAR LOTE', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_AVANCE_P1  = newButton('btn-data btn-green btn-accion', 'AVANZAR A CAJA', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_RECHAZO_P1 = newButton('btn-data btn-warning btn-accion', 'RECHAZAR LIBERACIÓN', 'RECHAZO', d, 'fas fa-thumbs-down');
    const BTN_AVANCE_P3  = newButton('btn-data btn-green btn-accion', 'AVANZAR LIBERACIÓN A CAJAS', 'AVANCE', d, 'fas fa-thumbs-up');
    const BTN_LIBERA     = newButton('btn-data btn-green btn-accion', 'APROBAR DESBLOQUEO', 'AVANCE', d, 'fa fa-check');
    const BTN_NO_LIBERA  = newButton('btn-data btn-warning btn-accion', 'RECHAZAR DESBLOQUEO', 'RECHAZO', d, 'fa fa-times-circle');
    const BTN_INFO       = newButton('btn-data btn-blueMaderas btn-historico', 'HISTORICO DE LA LIBERACIÓN', 'HISTORICO', d, 'fas fa-info');
    const BTN_VER_DOC    = newButton('btn-data btn-sky btn-ins-archivo', 'VISUALIZAR ARCHIVO', 'VER-ARCHIVO', d, 'fas fa-eye');
    const BTN_DEL_DOC    = newButton('btn-data btn-danger btn-del-archivo', 'VISUALIZAR ARCHIVO', 'VER-ARCHIVO', d, 'fas fa-trash');
    
    let NO_BTN = '';

    if (type === 2) { // Es para visualizar documentos o informaciones
        if (d.expediente) return BTN_VER_DOC + BTN_INFO ;
        if (!d.expediente) return BTN_INFO;
        return BTN_INFO;
    }

    if (type === 1) { // PARTICIPAN EN LOS PASOS
        if (id_rol_general == ROLES.VENTAS ) { 
            if (d.enProcesoLiberacion === 0 ) return BTN_AVANCE_P0 +  BTN_INFO ;
            return BTN_INFO; 
        }
        if (id_rol_general == ROLES.SUBDIRECCION) { // CONTRALORIA
            if ( d.enProcesoLiberacion === 1) return BTN_AVANCE_P1 + /* BTN_RECHAZO_P1 + */ BTN_INFO;
            return BTN_INFO;
        }
        if (id_rol_general == ROLES.CAJAS) { // CAJAS
            if (d.enProcesoLiberacion === PROCESO.INICIO ) return BTN_AVANCE_P0 +  BTN_INFO ;
            if (d.enProcesoLiberacion === PROCESO.SOLICITUD_LIBERACION) return BTN_LIBERA + BTN_NO_LIBERA + BTN_INFO;
            return NO_BTN;
        }
        return NO_BTN;
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
                if ([53, 54].includes(data[i]['id_opcion'])) $("#id_documento_liberacion").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
            }
            $('#id_documento_liberacion').selectpicker('refresh');
        }
    });
}

const fillChangelog = (i, d) => {
    let accion = 'Enviado a '
    if (d.estatus_lib == '2') {
        accion = 'Se regresó a:'
    }
    let cambio = '';
    if (d.estatus_lib == 1 && d.enProcesoLiberacion == 4 && d.concepto == 1) cambio = '<a><b>Cambió: </b> Precio de '+ formatMoney(d.precio) +' a ' + formatMoney(d.precioLiberacion) + ' </a>\n<br>\n';
    $("#changelog").append('<li>\n' +
  '            <a style="float: right">'+d.fecha_modificacion+'</a><br>\n' +
  '            <a><b>Tipo de liberación:</b> '+ d.nombreConceptoLiberacion + '</a> \n' +
  '            <br>\n' + 
  '            <a><b>Estatus: </b> '+accion+d.nombreProcesoLiberacion.toLowerCase()+' </a>\n' +
  '            <br>\n' +  cambio +
  '            <a><b>Modificado por: </b> '+(d.nombreMod+' '+d.ap1_mod+ ' '+ d.ap2_mod).toUpperCase()+' </a>\n' +
  '            <br>\n' +
  '            <a><b>Comentario: </b> '+d.comentario+' </a>\n' +
      '</li>');
}