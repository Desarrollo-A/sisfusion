Shadowbox.init();
let getInfoData = new Array(7);
let tipo_comprobante ;
let aut;
let titulos_intxt = [];
let cliente = null;
let titulo_modal = '';

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

$('#proyecto').change( function(){
    const proyecto = $(this).val();
    $("#condominio").html("");
    $(document).ready(function(){
        $.post(`${general_base_url}Contratacion/lista_condominio/`+proyecto, function(data) {
            $('#condominio').append($('<option disabled selected>Selecciona un codominio</option>'));
            for(let i = 0; i < data.length; i++) {
                const id = data[i]['idCondominio'];
                const name = data[i]['nombre'];
                $('#condominio').append($('<option>').val(id).text(name.toUpperCase()));
            }
            $("#condominio").selectpicker('refresh');
        }, 'json');
    });
});

$('#condominio').change( function(){
    $('#tabla_deposito_seriedad').removeClass('hide');
    fillDataTable($(this).val());
});

$(document).on("click", ".getInfo", function (e) {
    e.preventDefault();
    getInfoData[0] = $(this).attr("data-idCliente");
    getInfoData[1] = $(this).attr("data-nombreResidencial");
    getInfoData[2] = $(this).attr("data-nombreCondominio");
    getInfoData[3] = $(this).attr("data-idCondominio");
    getInfoData[4] = $(this).attr("data-nombreLote");
    getInfoData[5] = $(this).attr("data-idLote");
    getInfoData[6] = $(this).attr("data-fechavenc");
    getInfoData[7] = $(this).attr("data-idMov");

      (getInfoData[7] == MOVIMIENTOS.NUEVO_APARTADO) ? titulo_modal = "Integración de Expediente - "
    : (getInfoData[7] == MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2) ? titulo_modal = "Integración de expediente (Rechazo estatus 5 Contraloría) -"
    : (getInfoData[7] == MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5) ? titulo_modal = "Integración de expediente (Rechazo estatus 5 Contraloría) -"
    : (getInfoData[7] == MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6) ? titulo_modal = "Integración de Expediente (Rechazo estatus 6 Contraloría) -"
    : (getInfoData[7] == MOVIMIENTOS.RECHAZO_VENTAS_ESTATUS_8) ? titulo_modal = "Integración de Expediente (Rechazo estatus 8 Ventas) -"
    : (getInfoData[7] == MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7) ? titulo_modal = "Integración de Expediente (Rechazo estatus 7 Jurídico) -"
    : (getInfoData[7] == MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5_II) ? titulo_modal = "Integración de expediente (Rechazo estatus 5 Contraloría) -"
    : (getInfoData[7] == MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_II) ? titulo_modal = "Integración de Expediente (Rechazo estatus 7 Jurídico) -"
    : (getInfoData[7] == MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3) ? titulo_modal = 'Enviar nuevamente a postventa (despúes de un rechazo de postventa) -'
    :  titulo_modal = "Integración de Expediente - ";

    $(".lote").html(getInfoData[4]);
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
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 2</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 5</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 6</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_VENTAS_ESTATUS_8) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Ventas estatus 8</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_5_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 5</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Postventa estatus 3</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_2_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 2</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Contraloría estatus 6</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_ESTATUS_3_II) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Postventa estatus 3</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_JURIDICO_ESTATUS_7_III) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Jurídico estatus 7</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_POSTVENTA_3) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo Postventa 3</span>`;
                    }
                    if (idMovimiento === MOVIMIENTOS.RECHAZO_CONTRALORIA_ESTATUS_6_III) {
                        return `${d.comentario}<br><span class='label lbl-warning'>Rechazo de Contraloría estatus 6</span>`;
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

                        if (d.dsType == 1 && (d.idMovimiento == MOVIMIENTOS.NUEVO_APARTADO && d.idStatusContratacion == STATUS_CONTRATACION) &&
                             d.id_prospecto == 0 && (d.id_coordinador != 10807 && d.id_coordinador != 10806 && d.id_gerente != 10807 && d.id_gerente != 10806)) {
                             buttons += `<button class="btn-data btn-green abrir_prospectos btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="left" title="ASIGNAR PROSPECTO" data-idCliente="${d.id_cliente}" data-nomCliente="${d.nombreCliente}"> <i class="fas fa-user-check"></i></button>`;
                            }
                        }

                    // Botón para descargar la carta de reubicación
                    if (idMovimiento === MOVIMIENTOS.NUEVO_APARTADO) {
                            if ([2,4].includes(parseInt(d.proceso))) {
                                const url = `${general_base_url}Reestructura/imprimirCartaReubicacion/${d.id_cliente}`;
                                buttons += `<a href="${url}" target="_blank" class="btn-data btn-orangeYellow btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="left" title="DESCARGAR CARTA REUBICACIÓN"><i class="fas fa-download"></i></a>`;
                            }
                            if (d.proceso == 3) {
                                const url = `${general_base_url}Reestructura/imprimirCartaReestructura/${d.id_cliente}`;
                                buttons += `<a href="${url}" target="_blank" class="btn-data btn-orangeYellow btn-fab btn-fab-mini" data-toggle="tooltip" data-placement="left" title="DESCARGAR CARTA REESTRUCTURA"><i class="fas fa-download"></i></a>`;
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

    if ((parseInt(clienteData.total_sol_correo_pend) === 0 && parseInt(clienteData.total_sol_correo_aut) === 0) &&
         parseInt(clienteData.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO ||
        (parseInt(clienteData.total_sol_sms_pend) === 0 && parseInt(clienteData.total_sol_sms_aut) === 0) &&
         parseInt(clienteData.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO) {
        botones += `<button class="btn-data btn-yellow btn-rounded btn-solicitar" data-toggle="tooltip" data-placement="left" title="SOLICITAR EDICIÓN DEL REGISTRO" data-idCliente='${clienteData.id_cliente}'><i class="fas fa-hand-paper-o"></i></button>`;
    }
    
    return botones;
}

function openLink(id_cliente){
        window.open(general_base_url+'Asesor/deposito_seriedad/'+ id_cliente+'/0', '_blank');
}

$(document).on('click', '#save1', function(e) {
    e.preventDefault();
    const comentario = $("#comentario").val();
    var validaComent = (document.getElementById("comentario").value.trim() == '') ? 0 : 1;
    var complementoUrl = 'asesor/intExpAsesor/'

    let dataExp1 = new FormData();
    dataExp1.append("idCliente", getInfoData[0]);
    dataExp1.append("nombreResidencial", getInfoData[1]);
    dataExp1.append("nombreCondominio", getInfoData[2]);
    dataExp1.append("idCondominio", getInfoData[3]);
    dataExp1.append("nombreLote", getInfoData[4]);
    dataExp1.append("idLote", getInfoData[5]);
    dataExp1.append("comentario", comentario);
    dataExp1.append("fechaVenc", getInfoData[6]);
    dataExp1.append('tipo_comprobante', tipo_comprobante);
    dataExp1.append('idMovimiento', getInfoData[7]);

    if(getInfoData[7] == 99)
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
                else
                    alerts.showNotification("top", "right", response.message, "danger");
                
                $('#save1').prop('disabled', false);
                $('#modal1').modal('hide');
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
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

$(document).on('click', '.btn-autorizacion', function () {
    const $itself = $(this);
    const idCliente = $itself.attr('data-idCliente');
    $.get(`${general_base_url}Asesor/clienteAutorizacion/${idCliente}`, function (data) {
        cliente = JSON.parse(data);
        if (cliente.autorizacion_correo != null) {
            $('#chk-correo-aut-div').hide();
            $('#correo-aut-div').hide();
            $('#correoAut').removeAttr('required');
            $('#chk-sms-aut-div').removeAttr('class');
            $('#chk-sms-aut-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
        } else {
            $('#correoAut').val(cliente.correo);
            $('#chkCorreoAut').prop('checked', true);
        }
        if (cliente.autorizacion_sms != null) {
            $('#chk-sms-aut-div').hide();
            $('#sms-aut-div').hide();
            $('#ladaAut').removeAttr('required');
            $('#smsAut').removeAttr('required');
            $('#chk-correo-aut-div').removeAttr('class');
            $('#chk-correo-aut-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
        } else {
            let telefono = '';
            if (cliente.telefono1) {
                const telLength = cliente.telefono1.length;
                telefono = (telLength > 10)
                    ? parseInt(cliente.telefono1.substring(telLength - 10, telLength))
                    : parseInt(cliente.telefono1);
            }
            $('#smsAut').val(telefono);
            $('#ladaAut').val(cliente.lada_tel).trigger('change');
            $('#chkSmsAut').prop('checked', true);
        }
        $('#autorizaciones-modal').modal('toggle');
    });
});

$(document).on('click', '.btn-reenvio', function () {
    const $itself = $(this);
    const idCliente = $itself.attr('data-idCliente');
    $.get(`${general_base_url}Asesor/clienteAutorizacion/${idCliente}`, function (data) {
        cliente = JSON.parse(data);
        if (parseInt(cliente.autorizacion_correo) !== ESTATUS_AUTORIZACION.ENVIADO) {
            $('#chk-correo-reenvio-div').hide();
            $('#chk-sms-reenvio-div').removeAttr('class');
            $('#chk-sms-reenvio-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
            $('#chkCorreoReenvio').prop('checked', false);
        }
        if (parseInt(cliente.autorizacion_sms) !== ESTATUS_AUTORIZACION.ENVIADO) {
            $('#chk-sms-reenvio-div').hide();
            $('#chk-correo-reenvio-div').removeAttr('class');
            $('#chk-correo-reenvio-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
            $('#chkSmsReenvio').prop('checked', false);
        }
        $('#reenvio-modal').modal('toggle');
    });
});

$(document).on('click', '.btn-solicitar', function () {
    const $itself = $(this);
    const idCliente = $itself.attr('data-idCliente');
    $.get(`${general_base_url}Asesor/clienteAutorizacion/${idCliente}`, function (data) {
        cliente = JSON.parse(data);
        if (parseInt(cliente.total_sol_correo_pend) > 0 || parseInt(cliente.total_sol_correo_aut) > 0 || cliente.autorizacion_correo === null || parseInt(cliente.autorizacion_correo) === ESTATUS_AUTORIZACION.AUTORIZADO) {
            $('#chk-correo-sol-div').hide();
            $('#chk-sms-sol-div').removeAttr('class');
            $('#chk-sms-sol-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
            $('#chkCorreoSol').prop('checked', false);
        }
        if (parseInt(cliente.total_sol_sms_pend) > 0 || parseInt(cliente.total_sol_sms_aut) > 0 || cliente.autorizacion_sms === null || parseInt(cliente.autorizacion_sms) === ESTATUS_AUTORIZACION.AUTORIZADO) {
            $('#chk-sms-sol-div').hide();
            $('#chk-correo-sol-div').removeAttr('class');
            $('#chk-correo-sol-div').attr('class', 'col-12 col-sm-12 col-md-12 col-lg-12 p-0');
            $('#chkSmsSol').prop('checked', false);
        }
        $('#solicitar-modal').modal('toggle');
    });
});

$(document).on('hidden.bs.modal', '#autorizaciones-modal', function () {
    cliente = null;
    $('#correoAut').val('');
    $('#smsAut').val('');
    $('#chk-correo-aut-div').show();
    $('#correo-aut-div').show();
    $('#chk-sms-aut-div').show();
    $('#sms-aut-div').show();
    $('#correoAut').attr('required');
    $('#ladaAut').attr('required');
    $('#smsAut').attr('required');
    $('#chk-sms-aut-div').removeAttr('class');
    $('#chk-sms-aut-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chk-correo-aut-div').removeAttr('class');
    $('#chk-correo-aut-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chkCorreoAut').prop('checked', true);
    $('#chkSmsAut').prop('checked', true);
});

$(document).on('hidden.bs.modal', '#reenvio-modal', function () {
    cliente = null;
    $('#chk-correo-reenvio-div').show();
    $('#chk-sms-reenvio-div').show();
    $('#chk-sms-reenvio-div').removeAttr('class');
    $('#chk-sms-reenvio-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chk-correo-reenvio-div').removeAttr('class');
    $('#chk-correo-reenvio-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chkCorreoReenvio').prop('checked', true);
    $('#chkSmsReenvio').prop('checked', true);
});

$(document).on('hidden.bs.modal', '#solicitar-modal', function () {
    cliente = null;
    $('#chk-correo-sol-div').show();
    $('#chk-sms-sol-div').show();
    $('#chk-sms-sol-div').removeAttr('class');
    $('#chk-sms-sol-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chk-correo-sol-div').removeAttr('class');
    $('#chk-correo-sol-div').attr('class', 'col-12 col-sm-12 col-md-6 col-lg-6 p-0');
    $('#chkCorreoSol').prop('checked', true);
    $('#chkSmsSol').prop('checked', true);
    $('#comentarioSol').val('');
    $('#subdirector').val(null).trigger('change');
});

$(document).on('submit', '#autorizacion-form', function (e) {
    e.preventDefault();
    let formValues = {};
    $.each($('#autorizacion-form').serializeArray(), function (i, campo) {
        formValues[campo.name] = campo.value;
    });
    if (!formValues.chkCorreoAut && !formValues.chkSmsAut) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (cliente.autorizacion_correo !== null && !formValues.chkSmsAut) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (cliente.autorizacion_sms !== null && !formValues.chkCorreoAut) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (formValues.chkCorreoAut && cliente.autorizacion_correo === null) {
        if (formValues.correoAut.length === 0) {
            alerts.showNotification('top', 'right', 'El campo correo electrónico es obligatorio.', 'danger');
            return;
        }
    }
    if (formValues.chkSmsAut && cliente.autorizacion_sms === null) {
        if (formValues.ladaAut.length === 0) {
            alerts.showNotification('top', 'right', 'El campo lada es obligatorio.', 'danger');
            return;
        }
        if (formValues.smsAut.length === 0) {
            alerts.showNotification('top', 'right', 'El campo teléfono es obligatorio.', 'danger');
            return;
        }
        if (formValues.smsAut.length !== 10) {
            alerts.showNotification('top', 'right', 'El campo teléfono debe tener una longitud de 10 caracteres.', 'danger');
            return;
        }
    }

    let data = new FormData();
    data.append('idCliente', cliente.id_cliente);
    if (formValues.chkCorreoAut && cliente.autorizacion_correo === null) {
        data.append('correo', formValues.correoAut);
    }
    if (formValues.chkSmsAut && cliente.autorizacion_sms === null) {
        data.append('telefono', formValues.smsAut);
        data.append('lada', formValues.ladaAut);
    }
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Asesor/enviarAutorizaciones`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            const response = JSON.parse(data);
            if (response.code === 200) {
                alerts.showNotification("top", "right", 'Verificación enviada con éxito', "success");
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                $('#autorizaciones-modal').modal('hide');
            }
            if (response.code === 400) {
                alerts.showNotification("top", "right", response.message, "warning");
            }
            if (response.code === 500) {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
            $('#spiner-loader').addClass('hide');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$(document).on('submit', '#reenvio-form', function (e) {
    e.preventDefault();
    let formValues = {};
    $.each($('#reenvio-form').serializeArray(), function (i, campo) {
        formValues[campo.name] = campo.value;
    });
    if (!formValues.chkCorreoReenvio && !formValues.chkSmsReenvio) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (parseInt(cliente.autorizacion_sms) !== ESTATUS_AUTORIZACION.ENVIADO &&
        parseInt(cliente.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO && !formValues.chkCorreoReenvio) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (parseInt(cliente.autorizacion_correo) !== ESTATUS_AUTORIZACION.ENVIADO &&
        (parseInt(cliente.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO && !formValues.chkSmsReenvio)) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    let data = new FormData();
    data.append('idCliente', cliente.id_cliente);
    if (parseInt(cliente.autorizacion_correo) === ESTATUS_AUTORIZACION.ENVIADO && formValues.chkCorreoReenvio) {
        data.append('correo', true);
    }
    if (parseInt(cliente.autorizacion_sms) === ESTATUS_AUTORIZACION.ENVIADO && formValues.chkSmsReenvio) {
        data.append('sms', true);
    }
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Asesor/reenvioAutorizacion`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            const response = JSON.parse(data);
            if (response.code === 200) {
                alerts.showNotification("top", "right", 'Autorización reenviada con éxito', "success");
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                $('#reenvio-modal').modal('hide');
            }
            if (response.code === 400) {
                alerts.showNotification("top", "right", response.message, "warning");
            }
            if (response.code === 500) {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
            $('#spiner-loader').addClass('hide');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

$(document).on('submit', '#solicitar-form', function (e) {
    e.preventDefault();
    let formValues = {};
    $.each($('#solicitar-form').serializeArray(), function (i, campo) {
        formValues[campo.name] = campo.value;
    });
    if (!formValues.chkCorreoSol && !formValues.chkSmsSol) {
        alerts.showNotification('top', 'right', 'Debe seleccionar un método de envío.', 'danger');
        return;
    }
    if (formValues.comentario.length === 0) {
        alerts.showNotification('top', 'right', 'El comentario es requerido.', 'danger');
        return;
    }
    if (formValues.subdirector === null || formValues.subdirector === '') {
        alerts.showNotification('top', 'right', 'El subdirector es requerido.', 'danger');
        return;
    }
    let data = new FormData();
    data.append('idCliente', cliente.id_cliente);
    data.append('idSubdirector', formValues.subdirector);
    data.append('comentario', formValues.comentario);
    if ((parseInt(cliente.total_sol_correo_pend) === 0 || cliente.autorizacion_correo !== null) && formValues.chkCorreoSol) {
        data.append('correo', true);
    }
    if ((parseInt(cliente.total_sol_sms_pend) === 0 || cliente.autorizacion_sms !== null) && formValues.chkSmsSol) {
        data.append('sms', true);
    }
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Asesor/solicitarAclaracion`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            const response = JSON.parse(data);
            if (response.code === 200) {
                alerts.showNotification("top", "right", 'Solicitud enviada con éxito', "success");
                $('#tabla_deposito_seriedad').DataTable().ajax.reload();
                $('#solicitar-modal').modal('hide');
            }
            if (response.code === 400) {
                alerts.showNotification("top", "right", response.message, "warning");
            }
            if (response.code === 500) {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
            }
            $('#spiner-loader').addClass('hide');
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
});

function chkCorreoAutOnChange() {
    const isChecked = $('#chkCorreoAut').is(':checked');
    if (isChecked) {
        $('#correo-aut-div').show();
        $('#correoAut').attr('required');
    } else {
        $('#correo-aut-div').hide();
        $('#correoAut').removeAttr('required');
    }
}

function chkSmsAutOnChange() {
    const isChecked = $('#chkSmsAut').is(':checked');
    if (isChecked) {
        $('#sms-aut-div').show();
        $('#ladaAut').attr('required');
        $('#smsAut').attr('required');
    } else {
        $('#sms-aut-div').hide();
        $('#ladaAut').removeAttr('required');
        $('#smsAut').removeAttr('required');
    }
}

jQuery(document).ready(function(){
    jQuery('#modal1').on('hidden.bs.modal', function (e) {
        jQuery(this).removeData('bs.modal');
        jQuery(this).find('#comentario').val('');
    })
})

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
});