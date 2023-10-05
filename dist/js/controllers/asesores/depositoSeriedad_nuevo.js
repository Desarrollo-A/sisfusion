Shadowbox.init();
let getInfo2A = new Array(7);
let getInfo2_2A = new Array(7);
let getInfo5A = new Array(7);
let getInfo6A = new Array(7);
let getInfo2_3A = new Array(7);
let getInfo2_7A = new Array(7);
let getInfo5_2A = new Array(7);
let return1a = new Array(7);
let tipo_comprobante ;
let aut;
let titulos_intxt = [];
let cliente = null;
let titulo_modal = '';

$(document).ready(function() {
    if (id_usuario_general == 9651) { // MJ: ERNESTO DEL PINO SILVA
        $('#tabla_deposito_seriedad').addClass('hide');
        $.post(`${general_base_url}Contratacion/lista_proyecto`, function(data) {
            for(let i = 0; i < data.length; i++){
                const id = data[i]['idResidencial'];
                const name = data[i]['descripcion'];
                $('#proyecto').append($('<option>').val(id).text(name.toUpperCase()));
            }
            $('#proyecto').selectpicker('refresh');
        }, 'json');
    } else { // MJ: PARA LOS DEMÁS SÍ CARGA EN EL READY
        fillDataTable(0);
    }

    $('#subdirector').empty().selectpicker('refresh');
    $.get(`${general_base_url}Asesor/getSubdirectores`, function (data) {
        const subdirectores = JSON.parse(data);
        subdirectores.forEach(subdirector => {
            $('#subdirector').append($('<option>').val(subdirector.id_subdir).text(subdirector.nombre_subdir));
        });
        $('#subdirector').selectpicker('refresh');
    });
});

$('#tabla_deposito_seriedad thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>`);

    $('input', this).on('keyup change', function () {
        if ($('#tabla_deposito_seriedad').DataTable().column(i).search() !== this.value) {
            $('#tabla_deposito_seriedad').DataTable().column(i).search(this.value).draw();
        }
    });
});

const MOVIMIENTOS = Object.freeze({
    RECHAZO_CONTRALORIA_ESTATUS_5: 20,
    NUEVO_APARTADO: 31,
    RECHAZO_CONTRALORIA_ESTATUS_6: 63,
    RECHAZO_VENTAS_ESTATUS_8: 73,
    RECHAZO_JURIDICO_ESTATUS_7: 82,
    RECHAZO_CONTRALORIA_ESTATUS_2: 85,
    RECHAZO_CONTRALORIA_ESTATUS_5_II: 92,
    RECHAZO_JURIDICO_ESTATUS_7_II: 96,
    RECHAZO_POSTVENTA_ESTATUS_3: 99,
    RECHAZO_CONTRALORIA_ESTATUS_2_II: 102,
    RECHAZO_CONTRALORIA_ESTATUS_6_II: 104,
    RECHAZO_CONTRALORIA_ESTATUS_6_III: 107,
    RECHAZO_POSTVENTA_ESTATUS_3_II: 108,
    RECHAZO_JURIDICO_ESTATUS_7_III: 109,
    RECHAZO_POSTVENTA_3: 111,
});
const ESTATUS_AUTORIZACION = Object.freeze({
    ENVIADO: 1,
    AUTORIZADO: 2
});
const STATUS_CONTRATACION = 1;

$(document).on("click", ".getInfo", function (e) {
    e.preventDefault();
    getInfo2A[0] = $(this).attr("data-idCliente");
    getInfo2A[1] = $(this).attr("data-nombreResidencial");
    getInfo2A[2] = $(this).attr("data-nombreCondominio");
    getInfo2A[3] = $(this).attr("data-idCondominio");
    getInfo2A[4] = $(this).attr("data-nombreLote");
    getInfo2A[5] = $(this).attr("data-idLote");
    getInfo2A[6] = $(this).attr("data-fechavenc");
    getInfo2A[7] = $(this).attr("data-idMov");

      (getInfo2A[7] == MOVIMIENTOS.NUEVO_APARTADO) ? titulo_modal = "Integración de Expediente - "
    : (getInfo2A[7] == MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2) ? titulo_modal = "Integración de expediente (Rechazo estatus 5 Contraloría) -"
    : (getInfo2A[7] == MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5) ? titulo_modal = "Integración de expediente (Rechazo estatus 5 Contraloría) -"
    : (getInfo2A[7] == MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6) ? tiulo_modal = "Integración de Expediente (Rechazo estatus 6 Contraloría) -"
    : (getInfo2A[7] == MOVIMIENTOS.RECHAZO_VENTAS_ESTATUS_8) ? titulo_modal = "Integración de Expediente (Rechazo estatus 8 Ventas) -"
    : (getInfo2A[7] == MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7) ? titulo_modal = "Integración de Expediente (Rechazo estatus 7 Jurídico) -"
    : (getInfo2A[7] == MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5_II) ? titulo_modal = "Integración de expediente (Rechazo estatus 5 Contraloría) -"
    : (getInfo2A[7] == MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_II) ? titulo_modal = "Integración de Expediente (Rechazo estatus 7 Jurídico) -"
    : (getInfo2A[7] == MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3) ? titulo_modal = 'Enviar nuevamente a postventa (despúes de un rechazo de postventa) -'
    :  titulo_modal = "Integración de Expediente - ";

    $(".lote").html(getInfo2A[4]);
    $(".titulo_modal").html(titulo_modal);
    tipo_comprobante = $(this).attr('data-ticomp');
    $('#modal1').modal('show');
});

function fillDataTable(idCondominio) {
    tabla_valores_ds = $("#tabla_deposito_seriedad").DataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        pageLength: 10,
        ordering: false,
        destroy: true,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Tus ventas',
            title:"Tus ventas",
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos_intxt[columnIdx] + ' ';
                    }
                }
            }
        },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                className: 'btn buttons-pdf',
                titleAttr: 'Tus ventas',
                title:"Tus ventas",
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                }
            }],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        language: {
            url: general_base_url+"static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns: [
            {
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipo_proceso}</span>`;
                }
            },
            { "data": "nombreResidencial" },
            { "data": "nombreCondominio" },
            { "data": "nombreLote" },
            { "data": "nombreCliente" },
            {
                "data": function( d ){
                    return d.coordinador;
                }
            },
            {
                "data": function( d ){
                    return d.gerente;
                }
            },
            {
                "data": function( d ){
                    return d.subdirector;
                }
            },
            {
                "data": function( d ){
                    return d.regional;
                }
            },
            {
                "data": function( d ){
                    return d.regional2;
                }
            },
            { "data": "fechaApartado" },
            {
                "data": function( d ){
                    return (
                        [
                            MOVIMIENTOS.RECHAZO_VENTAS_ESTATUS_8,
                            MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5_II,
                            MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_II,
                            MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2_II,
                            MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_II,
                            MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3_II,
                            MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_III,
                            MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_III,
                            MOVIMIENTOS.RECHAZO_POSTVENTA_3
                        ].includes(d.idMovimiento)
                    ) ? d.modificado : d.fechaVenc;
                }
            },
            {
                "data": function( d ){
                    const idMovimiento = parseInt(d.idMovimiento);
                    if (idMovimiento === MOVIMIENTOS.NUEVO_APARTADO) {
                        return `${d.comentario}<br><span class='label lbl-sky'>Nuevo apartado</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2 || idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 2</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5 || idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 5</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6 || idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_II || idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_III) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 6</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_VENTAS_ESTATUS_8) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Ventas estatus 8</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7 || idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_II || idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_III) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3 || idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Postventa estatus 3</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_3) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Postventa 3</span>`;
                    }

                    return d.comentario;
                }
            },
            {
                "data" : function(d){
                    if (d.dsType != 1) {
                        return '';
                    }
                    if (parseInt(d.idMovimiento) !== MOVIMIENTOS.NUEVO_APARTADO && parseInt(d.idStatusContratacion) !== STATUS_CONTRATACION) {
                        return 'ASIGNADO CORRECTAMENTE';
                    }
                    if (d.id_prospecto != 0) {
                        return 'ASIGNADO CORRECTAMENTE';
                    }
                    if (d.id_coordinador == 10807 || d.id_coordinador == 10806 || d.id_gerente == 10807 || d.id_gerente == 10806) {
                        return 'ASIGNADO CORRECTAMENTE';
                    }
                return '<p>DEBES ASIGNAR EL PROSPECTOS AL CLIENTE PARA PODER ACCEDER AL DEPÓSITO DE SERIEDAD O INTEGRAR EL EXPEDIETNE</p>';
                }
            },
            {
                "data": function (d) {
                    if (d.autorizacion_correo === null) {
                        return "<span class='label lbl-gray'>Sin envío de verificación</span>";
                    }
                    if (parseInt(d.total_sol_correo_pend) > 0) {
                        return "<span class='label lbl-azure'>Solicitud de autorización</span>";
                    }
                    if (parseInt(d.total_sol_correo_rech) > 0 && parseInt(d.total_sol_correo_aut) === 0 && parseInt(d.total_sol_correo_pend) === 0) {
                        return "<span class='label lbl-warning'>Solicitud rechazada</span>";
                    }
                    if (parseInt(d.autorizacion_correo) === 1) {
                        return `<span class='label lbl-yellow'>Verificación pendiente:</span></br>&nbsp;<span class='label lbl-yellow'>${d.correo}</span>`;
                    }
                    if (parseInt(d.autorizacion_correo) === 2) {
                        return `<span class='label lbl-green'>Verificado:</span></br>&nbsp;<span class='label lbl-green'>${d.correo}</span>`;
                    }
                    return '';
                }
            },
            {
                "data": function (d) {
                    if (d.autorizacion_sms === null) {
                        return "<span class='label lbl-gray'>Sin envío de verificación</span>";
                    }
                    if (parseInt(d.total_sol_sms_pend) > 0) {
                        return "<span class='label lbl-azure'>Solicitud de autorización</span>";
                    }
                    if (parseInt(d.total_sol_sms_rech) > 0 && parseInt(d.total_sol_sms_aut) === 0 && parseInt(d.total_sol_sms_pend) === 0) {
                        return "<span class='label lbl-warning'>Solicitud rechazada</span>";
                    }
                    if (parseInt(d.autorizacion_sms) === 1) {
                        return `<span class='label lbl-yellow'>Verificación pendiente:</span></br>&nbsp;<span class='label lbl-yellow'>${d.telefono}</span>`;
                    }
                    if (parseInt(d.autorizacion_sms) === 2) {
                        return `<span class='label lbl-green'>Verificado:</span></br>&nbsp;<span class='label lbl-green'>${d.telefono}</span>`;
                    }
                    return '';
                }
            },
            {
                "data": function( d ){
                    let atributoButton = '';
                    let buttons = '';
                    const idMovimiento = parseInt(d.idMovimiento);
                    const idStatusContratacion = parseInt(d.idStatusContratacion);
                    if(d.vl == '1') {
                        buttons = 'En proceso de Liberación';
                    }
                    else {
                        buttons = construirBotonEstatus(d, d.fechaVenc, 'getInfo');

                        if(idMovimiento == MOVIMIENTOS.NUEVO_APARTADO && idStatusContratacion === STATUS_CONTRATACION){
                            if (d.id_prospecto == 0 && (d.id_coordinador !== 10807 || d.id_coordinador !== 10806 || d.id_gerente !== 10807 || d.id_gerente !== 10806)) {
                                buttons = construirBotonEstatus(d, d.id_coordinador, 'disabled', 'disabled');
                                atributoButton = 'disabled';
                            }
                            buttons += generarBotonesAutorizacion(d);          
                        }                         
                                            
                        if (d.dsType == 1){
                            buttons += '<button class="btn-data btn-blueMaderas btn_ds'+d.id_cliente+'" '+atributoButton+' id="btn_ds'+d.id_cliente+'" onclick="openLink('+ d.id_cliente +')" data-toggle="tooltip" data-placement="top" title="DEPÓSITO DE SERIEDAD" target=”_blank”><i class="fas fa-print"></i></button>';
                        } 
                        if(d.dsType == 2) { // DATA FROM DEPOSITO_SERIEDAD_CONSULTA OLD VERSION
                            buttons += '<a class="btn-data btn-blueMaderas" href="'+general_base_url+'Asesor/deposito_seriedad_ds/'+d.id_cliente+'/0" data-toggle="tooltip" data-placement="left" title="DEPÓSITO DE SERIEDAD" target=”_blank”><i class="fas fa-print"></i></a>';
                        }

                        if ( d.dsType == 1 && (parseInt(d.idMovimiento) === MOVIMIENTOS.NUEVO_APARTADO && parseInt(d.idStatusContratacion) === STATUS_CONTRATACION) &&
                             d.id_prospecto == 0 && (d.id_coordinador != 10807 && d.id_coordinador != 10806 && d.id_gerente != 10807 && d.id_gerente != 10806)) {
                             buttons += `<button class="btn-data btn-green abrir_prospectos btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="left" title="ASIGNAR PROSPECTO" data-idCliente="${d.id_cliente}" data-nomCliente="${d.nombreCliente}"> <i class="fas fa-user-check"></i></button>`;
                            }
                        }

                    // Botón para descargar la carta de reubicación
                    if (idMovimiento === MOVIMIENTOS.NUEVO_APARTADO) {
                        if ([2, 3, 4].includes(parseInt(d.proceso))) {
                            if ([2,4].includes(parseInt(d.proceso))) {
                                const url = `${general_base_url}Reestructura/imprimirCartaReubicacion/${d.id_cliente}`;
                                buttons += `<a href="${url}" target="_blank" class="btn-data btn-orangeYellow btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="left" title="DESCARGAR CARTA REUBICACIÓN"><i class="fas fa-download"></i></a>`;
                            }

                            if (parseInt(d.proceso) === 3) {
                                const url = `${general_base_url}Reestructura/imprimirCartaReestructura/${d.id_cliente}`;
                                buttons += `<a href="${url}" target="_blank" class="btn-data btn-orangeYellow btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="left" title="DESCARGAR CARTA REESTRUCTURA"><i class="fas fa-download"></i></a>`;
                            }
                        }
                    }
                    
                    return '<div class="d-flex justify-center">'+buttons+'</div>';
                }
            }
        ],
        ajax: {
            url: general_base_url+"Asesor/tableClienteDS/",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "idCondominio": idCondominio,
            }
        }
    });
}

$(document).on('click', '#save1', function(e) {
    e.preventDefault();
    const comentario = $("#comentario").val();
    var complementoUrl = 'asesor/intExpAsesor/'
    var validaComent = (document.getElementById("comentario").value.trim() == '') ? 0 : 1;

    let dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfo2A[0]);
    dataExp1.append("nombreResidencial", getInfo2A[1]);
    dataExp1.append("nombreCondominio", getInfo2A[2]);
    dataExp1.append("idCondominio", getInfo2A[3]);
    dataExp1.append("nombreLote", getInfo2A[4]);
    dataExp1.append("idLote", getInfo2A[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfo2A[6]);
    dataExp1.append('tipo_comprobante', tipo_comprobante);
    dataExp1.append('idMovimiento', getInfo2A[7]);

    if(getInfo2A[7] == 99)
        complementoUrl = 'Postventa/enviarLoteARevisionPostVenta3/';

    if (validaComent == 0) {
        alerts.showNotification("top", "right", "Ingresa un comentario.", "danger");
    }
    else {
        $('#save1').prop('disabled', true);
        $.ajax({
            url : general_base_url + complementoUrl,
            data: dataExp1,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                response = JSON.parse(data);
                
                if(response.status)
                    alerts.showNotification("top", "right", response.message, "success");
                else{
                    alerts.showNotification("top", "right", response.message, "danger");
                }
            },
            error: function(){
                $('#save1').prop('disabled', false);
                $('#modal1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            }
        });
    }
});

function construirBotonEstatus(data, fechaVenc, classButton, atributoButton = '', titulo = 'ENVIAR ESTATUS') {
    return `<button href='#' ${atributoButton} 
                data-tiComp='${data.tipo_comprobanteD}' 
                data-nomLote='${data.nombreLote}' 
                data-idCliente='${data.id_cliente}'
                data-nombreResidencial='${data.nombreResidencial}' 
                data-nombreCondominio='${data.nombreCondominio}' 
                data-nombreLote='${data.nombreLote}' 
                data-idCondominio='${data.idCondominio}' 
                data-idLote='${data.idLote}' 
                data-fechavenc='${fechaVenc}'
                data-idMov='${data.idMovimiento}' 
                class="btn-data btn-green ${classButton}" 
                data-toggle="tooltip" data-placement="top" 
                title="${titulo}"> <i class="fas fa-check"></i></button>`;
}

function generarBotonesAutorizacion(clienteData) {
    let botones = '';
    if (clienteData.autorizacion_correo === null || clienteData.autorizacion_sms === null) {
        botones += `
            <button class="btn-data btn-violetDeep btn-rounded btn-autorizacion" data-toggle="tooltip"  data-placement="left" title="ENVÍO DE VERIFICACIONES" data-idCliente='${clienteData.id_cliente}'><i class="fas fa-send"></i></button>
        `;
    }
    if (parseInt(clienteData.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO || parseInt(clienteData.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO) {
        botones += `
            <button class="btn-data btn-azure btn-rounded btn-reenvio" data-toggle="tooltip" data-placement="left" title="REENVÍO DE VERIFICACIÓN" data-idCliente='${clienteData.id_cliente}'><i class="fas fa-rotate-right"></i></button>
        `;
    }

    if (
        (parseInt(clienteData.total_sol_correo_pend) === 0 && parseInt(clienteData.total_sol_correo_aut) === 0) &&
            parseInt(clienteData.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO ||
        (parseInt(clienteData.total_sol_sms_pend) === 0 && parseInt(clienteData.total_sol_sms_aut) === 0) &&
            parseInt(clienteData.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO
    ) {
        botones += `
            <button class="btn-data btn-yellow btn-rounded btn-solicitar" data-toggle="tooltip" data-placement="left" title="SOLICITAR EDICIÓN DEL REGISTRO" data-idCliente='${clienteData.id_cliente}'><i class="fas fa-hand-paper-o"></i></button>
        `;
    }
    
    return botones;
}

function openLink(id_cliente){
        window.open(general_base_url+'Asesor/deposito_seriedad/'+ id_cliente+'/0', '_blank');
}