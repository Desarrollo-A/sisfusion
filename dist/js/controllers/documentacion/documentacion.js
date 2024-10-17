$('[data-toggle="tooltip"]').tooltip();

const movimientosPermitidosEstatus7 = [36, 6, 23, 76, 83, 95, 97, 112];
const rolesPermitidosContratoEspecial = [8];
const rolesPermitidosEstatus7 = [15];
const usuariosPermitidosContratoEspecial = [2762, 2747];
const movimientosPermitidosContratoFirmado = [45];
const movimientosPermitidosEstatus6 = [35, 22, 62, 75, 94, 106, 45];
const ROLES_PERMITIDOS_DOCUMENTOS_CONTRALORIA = [17, 70, 71, 73];
const rolesPermitidosEstatus6And15 = [17, 70];
const movimientosPermitidosEstatus8 = [37, 7, 64, 66, 77, 41];
const rolesPermitidosEstatus8 = [5, 2, 6];
const movimientosPermitidosEstatus2 = [31, 85, 20, 63, 73, 82, 92, 96, 99, 102, 104, 107, 108, 109, 111];
const rolesPermitidosEstatus2 = [7, 9, 3, 2];
const rolesPermitidosAsesorInactivo = [6];
const rolesPermitidosAnexo1 = [15];
const usuariosPermitidosEstatus3 = [12271];
const movimientosPermitidosEstatus3 = [98, 100, 102, 105, 107, 110, 113, 114];
const rolMaster = [8];


const AccionDoc = {
    DOC_NO_CARGADO: 1, // NO HAY DOCUMENTO CARGADO
    DOC_CARGADO: 2, // LA RAMA TIENE UN DOCUMENTO CARGADO
    SUBIR_DOC: 3, // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
    ELIMINAR_DOC: 4, // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
    ENVIAR_SOLICITUD: 5
};

const TipoDoc = {
    CONTRATO: 8,
    CORRIDA: 7,
    CARTA_DOMICILIO: 29,
    CONTRATO_FIRMADO: 30,
    DS_NEW: 'ds_new',
    DS_OLD: 'ds_old',
    EVIDENCIA_MKTD_OLD: 66, // EXISTE LA RAMA CON LA EVIDENCIA DE MKTD (OLD)
    AUTORIZACIONES: 'autorizacion',
    PROSPECTO: 'prospecto',
    APOSTILLDO_CONTRATO: 31,
    CARTA: 32,
    RESCISION_CONTRATO: 33,
    CARTA_PODER: 34,
    RESCISION_CONTRATO_FIRMADO: 35,
    DOCUMENTO_REESTRUCTURA: 36,
    DOCUMENTO_REESTRUCTURA_FIRMADO: 37,
    CONSTANCIA_SITUACION_FISCAL: 38,
    CORRIDA_ANTERIOR: 39,
    CONTRATO_ANTERIOR: 40,
    COMPLEMENTO_ENGANCHE: 45,
    CONTRATO_ELEGIDO_FIRMA_CLIENTE: 41,
    CONTRATO_1_CANCELADO: 42,
    CONTRATO_2_CANCELADO: 43,
    CONTRATO_REUBICACION_FIRMADO: 44,
    DOCUMENTO_REESTRUCTURA_FIRMA_CLIENTE: 46,
    NUEVO_CONTRATO_REESTRUCTURA_FIRMA_CLIENTE: 47,
    ANEXO_1: 48,
    VIDEO_FIRMA: 49,
    ANEXO_VENTA_DE_PARTICULARES: 50,
    COMPLEMENTO_DE_PAGO: 55,
};

const observacionContratoUrgente = 1; // Bandera para inhabilitar

/**
 * Bandera para inhabilitar el eliminado del contrato cuando ya hizo el movimiento asistentes de gerentes
 * @type {number}
 */
const status8Flag = 1;
let documentacionLoteTabla = null;
let titulos = [];
Shadowbox.init();

$(document).ready(function () {
    construirHead("tableDoct"); 
    changeButtonTooltips();
    $('#addDeleteFileModal').on('hidden.bs.modal', function () {
        $('#fileElm').val(null);
        $('#file-name').val('');
    })

    $("input:file").on("change", function () {
        const target = $(this);
        const relatedTarget = target.siblings(".file-name");
        const fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
});

$(document).on('change', '.btn-file :file', function () {
    const input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

$('#idResidencial').change(function () {
    $("#idCondominio").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');

    $.ajax({
        url: `${general_base_url}registroCliente/getCondominios/${$(this).val()}`,
        type: 'post',
        dataType: 'json',
        success: function (response) {
            for (let i = 0; i < response.length; i++) {
                $("#idCondominio").append($('<option>').val(response[i]['idCondominio']).text(response[i]['nombre']));
            }

            $('#idCondominio').selectpicker('refresh');
        },
        complete: function () {
            $('#spiner-loader').addClass('hide');
        }
    });
});

$('#idCondominio').change(function () {
    $("#idLote").empty().selectpicker('refresh');
    $('#spiner-loader').removeClass('hide');

    $.ajax({
        url: `${general_base_url}registroCliente/getLotesAsesor/${$(this).val()}/${$('#idResidencial').val()}`,
        type: 'post',
        dataType: 'json',
        success: function (response) {
            for (let i = 0; i < response.length; i++) {
                $("#idLote").append($('<option>').val(response[i]['idLote'] + ',' + response[i]['venta_compartida']).text(response[i]['nombreLote']));
            }

            $('#idLote').selectpicker('refresh');
        },
        complete: function () {
            $('#spiner-loader').addClass('hide');
        }
    });
});

$('#idLote').change(function () {
    $('#tableDoct').removeClass('hide');
    const seleccion = $(this).val();
    const datos = seleccion.split(',');
    const valorSeleccionado = datos[0];

    let tabla_6 = $('#tableDoct').DataTable({
        destroy: true,
        ajax: {
            url: `${general_base_url}registroCliente/expedientesWS/${valorSeleccionado}`,
            dataSrc: ""
        },
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        ordering: false,
        pageLength: 20,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: `${_("descargar-excel")}`,
                filename: `${_("documentacion-lote")}`,
                title: `${_("documentacion-lote")}`,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                    format: {
                        header:  function (d, columnIdx) {
                            return $(d).attr('placeholder').toUpperCase();
                        }
                    }
                },
            }
        ],
        language: {
            url: `${general_base_url}/static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        columns: [
            { data: 'nombreResidencial' },
            { data: 'nombre' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombreCliente' },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            { data: 'nombreRegional2' },
            { data: 'movimiento' },
            { data: 'modificado' },
            {
                data: null,
                render: function (data) {
                    return myFunctions.validateEmptyFieldDocs(data.primerNom) + ' ' +
                        myFunctions.validateEmptyFieldDocs(data.apellidoPa) + ' ' +
                        myFunctions.validateEmptyFieldDocs(data.apellidoMa);
                },
            },
            { data: 'ubic' },
            {
                data: null,
                render: function (data) {
                    let buttonMain = '';
                    let buttonDelete = '';

                    if (data.observacionContratoUrgente && parseInt(data.observacionContratoUrgente) === observacionContratoUrgente) {
                        buttonMain = (data.expediente == null || data.expediente === "")
                            ? `<p data-i18n="proceso-liberacion">${_("proceso-liberacion")}</p>`
                            : crearBotonAccion(AccionDoc.DOC_CARGADO, data);

                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    if (
                        data.tipo_doc == TipoDoc.CONTRATO &&
                        (includesArray(rolesPermitidosContratoEspecial, id_rol_general) ||
                            includesArray(usuariosPermitidosContratoEspecial,id_usuario_general) || includesArray(rolMaster, id_rol_general))
                    ) {
                        if (data.expediente == null || data.expediente === "") {
                            // NO HAY DOCUMENTO CARGADO
                            buttonMain = crearBotonAccion(AccionDoc.SUBIR_DOC, data);

                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);

                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    if (data.tipo_doc == TipoDoc.CONTRATO || data.tipo_doc == TipoDoc.DOCUMENTO_REESTRUCTURA) { // CONTRATO
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = ((includesArray(movimientosPermitidosEstatus7, data.idMovimiento) && includesArray(rolesPermitidosEstatus7, id_rol_general)) || includesArray(rolMaster, id_rol_general))                                                
                                // ESTÁ EN ESTATUS 7 Y ES JURÍDICO EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);

                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        if ((includesArray(movimientosPermitidosEstatus7, data.idMovimiento) && includesArray(rolesPermitidosEstatus7, id_rol_general)) || includesArray(rolMaster, id_rol_general)) {
                            buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        }

                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    // VALIDACIÓN ANEXO 1 PARA JURÍDICO
                    if (data.tipo_doc == TipoDoc.ANEXO_1) { // ANEXO 1 PARA JURÍDICO
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = (includesArray(rolesPermitidosAnexo1, id_rol_general) || includesArray(rolMaster, id_rol_general)) ? crearBotonAccion(AccionDoc.SUBIR_DOC, data) : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);
                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }
                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        if (includesArray(rolesPermitidosAnexo1, id_rol_general) || includesArray(rolMaster, id_rol_general))
                            buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    if (data.tipo_doc == TipoDoc.CORRIDA) { // CORRIDA
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = ((includesArray(movimientosPermitidosEstatus6, data.idMovimiento) && includesArray(ROLES_PERMITIDOS_DOCUMENTOS_CONTRALORIA, id_rol_general)) || includesArray(rolMaster, id_rol_general))
                                // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);

                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                        if ((includesArray(movimientosPermitidosEstatus6, data.idMovimiento) && includesArray(ROLES_PERMITIDOS_DOCUMENTOS_CONTRALORIA, id_rol_general)) || includesArray(rolMaster, id_rol_general)) {
                            buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        }

                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    if (data.tipo_doc == TipoDoc.CARTA_DOMICILIO || data.tipo_doc == TipoDoc.APOSTILLDO_CONTRATO || data.tipo_doc == TipoDoc.COMPLEMENTO_DE_PAGO) { // CARTA DOMICILIO || APOSTILLADO CONTRATO
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = (
                                (includesArray(movimientosPermitidosEstatus8, data.idMovimiento) &&
                                includesArray(rolesPermitidosEstatus8, id_rol_general) ) 
                                ||(includesArray(rolMaster, id_rol_general))&&
                                parseInt(data.status8Flag) !== status8Flag
                            )
                                // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);

                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                        if (
                            ((includesArray(movimientosPermitidosEstatus8, data.idMovimiento) &&
                            includesArray(rolesPermitidosEstatus8, id_rol_general) )
                            || includesArray(rolMaster, id_rol_general))&&
                            parseInt(data.status8Flag) !== status8Flag
                        ) {
                            buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        }

                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    if (
                        data.tipo_doc == TipoDoc.CARTA ||
                        data.tipo_doc == TipoDoc.CARTA_PODER ||
                        data.tipo_doc == TipoDoc.CONSTANCIA_SITUACION_FISCAL ||
                        data.tipo_doc == TipoDoc.CONTRATO_1_CANCELADO ||
                        data.tipo_doc == TipoDoc.CONTRATO_2_CANCELADO ||
                        data.tipo_doc == TipoDoc.CONTRATO_ELEGIDO_FIRMA_CLIENTE ||
                        data.tipo_doc == TipoDoc.CONTRATO_FIRMADO ||
                        data.tipo_doc == TipoDoc.CONTRATO_REUBICACION_FIRMADO ||
                        data.tipo_doc == TipoDoc.DOCUMENTO_REESTRUCTURA_FIRMA_CLIENTE ||
                        data.tipo_doc == TipoDoc.DOCUMENTO_REESTRUCTURA_FIRMADO ||
                        data.tipo_doc == TipoDoc.NUEVO_CONTRATO_REESTRUCTURA_FIRMA_CLIENTE ||
                        data.tipo_doc == TipoDoc.RESCISION_CONTRATO_FIRMADO
                    ) { // LOS DOCUMENTOS QUE VA A CARGAR CONTRALORÍA DEL PROYECTO DE REESTRUCTURA
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = (includesArray(ROLES_PERMITIDOS_DOCUMENTOS_CONTRALORIA, id_rol_general) || includesArray(rolMaster, id_rol_general))
                                // ESTÁ EN ESTATUS 15 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);
                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }
                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        // ESTÁ EN ESTATUS 8 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                        if (includesArray(ROLES_PERMITIDOS_DOCUMENTOS_CONTRALORIA, id_rol_general) || includesArray(rolMaster, id_rol_general))
                            buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    // ANEXO VENTA DE PARTICUALES
                    if (data.tipo_doc == TipoDoc.ANEXO_VENTA_DE_PARTICULARES) { // ANEXO VENTAS DE PARTICULAES
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = ((includesArray(movimientosPermitidosEstatus3, data.idMovimiento) && includesArray(usuariosPermitidosEstatus3, id_usuario_general)) || includesArray(rolMaster, id_rol_general))
                                // ESTÁ EN ESTATUS 15 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);
                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }
                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        // ESTÁ EN ESTATUS 8 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                        if ((includesArray(movimientosPermitidosEstatus3, data.idMovimiento) && includesArray(usuariosPermitidosEstatus3, id_usuario_general)) || includesArray(rolMaster, id_rol_general))
                            buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    if (data.tipo_doc === TipoDoc.DS_NEW && data.expediente === "Depósito de seriedad") { // EXISTE EL DEPÓSITO DE SERIEDAD (VERSIÓN NUVEA)
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    if (data.tipo_doc === TipoDoc.DS_NEW && data.expediente === "Depósito de seriedad versión anterior") { // EXISTE EL DEPÓSITO DE SERIEDAD (VERSIÓN VIEJITA)
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    if (data.tipo_doc == TipoDoc.EVIDENCIA_MKTD_OLD) { // EXISTE LA RAMA CON LA EVIDENCIA DE MKTD (OLD)
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    if (data.tipo_doc === TipoDoc.AUTORIZACIONES) { // EXISTE LA RAMA DE AUTORIZACIONES
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    if (data.tipo_doc === TipoDoc.PROSPECTO) { // EXISTE LA RAMA DEL PROSPECTO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    if (
                        data.tipo_doc == TipoDoc.CORRIDA_ANTERIOR ||
                        data.tipo_doc == TipoDoc.CONTRATO_ANTERIOR ||
                        data.tipo_doc == TipoDoc.RESCISION_CONTRATO
                    ) {
                        if (data.expediente == null || data.expediente === "") {
                            buttonMain = crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);
                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data);
                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    // ES EL RESTO DEL EXPEDIENTE (HISTORIAL DOCUMENTOS)
                    if (data.expediente == null || data.expediente === "") {
                        // NO HAY DOCUMENTO CARGADO
                        buttonMain =
                            includesArray(
                                movimientosPermitidosEstatus2,
                                parseInt(data.idMovimiento)
                            ) || includesArray(rolMaster, id_rol_general) &&
                                ((includesArray(
                                    rolesPermitidosEstatus2,
                                    parseInt(id_rol_general)
                                ) || includesArray(rolMaster, id_rol_general) &&
                                    parseInt(data.id_asesor) === parseInt(id_usuario_general) &&
                                    parseInt(data.estatusAsesor) === 1) ||
                                    (includesArray(rolesPermitidosAsesorInactivo, id_rol_general) 
                                    || includesArray(rolMaster, id_rol_general)
                                    &&
                                        parseInt(data.estatusAsesor) !== 1))
                                ? // ESTÁ EN ESTATUS 2 Y ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                : // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);
                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }
                    // LA RAMA TIENE UN DOCUMENTO CARGADO
                    buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                    // ESTÁ EN ESTATUS 2 Y ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                    if (
                        includesArray(
                            movimientosPermitidosEstatus2,
                            parseInt(data.idMovimiento)
                        ) || includesArray(rolMaster, id_rol_general) &&
                        ((includesArray(
                            rolesPermitidosEstatus2,
                            parseInt(id_rol_general)
                        ) || includesArray(rolMaster, id_rol_general) &&
                            parseInt(data.id_asesor) === parseInt(id_usuario_general) &&
                            parseInt(data.estatusAsesor) === 1) ||
                            (includesArray(rolesPermitidosAsesorInactivo, id_rol_general) || includesArray(rolMaster, id_rol_general)
                            &&
                                parseInt(data.estatusAsesor) !== 1))
                    ) {
                        buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                    }
                    return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                }
            }
        ],
        initComplete: function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            });
        },
    });

    applySearch(tabla_6);
    changeButtonTooltips();
    $('body').i18n();
});

$(document).on('click', '.verDocumento', function () {
    const $itself = $(this);

    let pathUrl = $itself.attr("data-expediente");
    if ($itself.attr("data-bucket") != 1) {
        pathUrl = general_base_url + $itself.attr("data-expediente");
    }

    if ($itself.attr('data-tipoDocumento') === TipoDoc.DS_NEW || $itself.attr('data-tipoDocumento') === TipoDoc.DS_OLD) {
        const idCliente = $itself.attr('data-idCliente');
        const urlDs = ($itself.attr('data-expediente') === 'Depósito de seriedad')
            ? 'deposito_seriedad' : 'deposito_seriedad_ds';

        pathUrl = `${general_base_url}asesor/${urlDs}/${idCliente}/1`;
    }
    if (parseInt($itself.attr('data-tipoDocumento')) === TipoDoc.CORRIDA || parseInt($itself.attr('data-tipoDocumento')) === TipoDoc.CORRIDA_ANTERIOR) {
        descargarArchivo(pathUrl, $itself.attr('data-expediente'));

        alerts.showNotification('top', 'right', `${_("el-documento")} <b>` + $itself.attr('data-expediente') + `</b> ${_("descarga-exito")}`, 'success');
        return;
    }

    if ($itself.attr('data-tipoDocumento') === TipoDoc.AUTORIZACIONES) {
        abrirModalAutorizaciones($itself.attr('data-idLote'));
        return;
    }

    if ($itself.attr('data-tipoDocumento') === TipoDoc.PROSPECTO) {
        const urlProspecto = ($itself.attr('data-lp') == 6) ? 'printProspectInfoMktd' : 'printProspectInfo';

        pathUrl = `${general_base_url}clientes/${urlProspecto}/` + $itself.attr('data-idProspeccion');
    }

    if (screen.width > 480 && screen.width < 800) {
        window.location.href = `${pathUrl}`;
    }
    else {
        fileExists(pathUrl);
        Shadowbox.open({
            content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${pathUrl}"></iframe></div>`,
            player: "html",
            title: `${_('visualizando-archivo2')}: ${$itself.attr('data-nombre')}`,
            width: 985,
            height: 660
        });
    }
});

$(document).on('click', '.seeAuts', function (e) {
    e.preventDefault();
    const $itself = $(this);

});

$(document).on("click", ".addRemoveFile", function (e) {
    e.preventDefault();
    let idDocumento = $(this).attr("data-idDocumento");
    let tipoDocumento = $(this).attr("data-tipoDocumento");
    let accion = parseInt($(this).data("accion"));
    let nombreDocumento = $(this).data("nombre");

    $("#idLoteValue").val($(this).attr("data-idLote"));
    $("#idDocumento").val(idDocumento);
    $("#tipoDocumento").val(tipoDocumento);
    $("#nombreDocumento").val(nombreDocumento);
    $('#tituloDocumento').val($(this).attr('data-tituloDocumento'));
    $("#accion").val(accion);

    if (accion === AccionDoc.DOC_NO_CARGADO || accion === AccionDoc.DOC_CARGADO) {
        document.getElementById("mainLabelText").innerHTML =
            (accion === AccionDoc.DOC_NO_CARGADO)
                ? `${_("selecciona-archivo-asociar")} <b>` + nombreDocumento + '</b>'
                : (accion === AccionDoc.DOC_CARGADO)
                    ? `${_("eliminar-archivo")} <b>` + nombreDocumento + '</b>?'
                    : `${_("selecciona-motivos")} <b>` + nombreDocumento + '</b>.';

        document.getElementById("secondaryLabelDetail").innerHTML =
            (accion === AccionDoc.DOC_NO_CARGADO)
                ? `${_("el-documento-elegido")} <i data-i18n="guardar">${_('guardar')}</i>.`
                : (accion === AccionDoc.DOC_CARGADO)
                    ? `${_("el-documento-eliminar")} <i data-i18n="guardar">${_('guardar')}</i>.`
                    : `${_("los-motivos")} <i data-i18n="guardar">${_('guardar')}</i>.`;

        $('#file-name').attr('placeholder', _('archivo-no-selecionado'));

        if (accion === AccionDoc.DOC_NO_CARGADO) { // ADD FILE
            $("#selectFileSection").removeClass("hide");
            $("#txtexp").val("");
        }

        if (accion === AccionDoc.DOC_CARGADO) { // REMOVE FILE
            $("#selectFileSection").addClass("hide");
        }

        $("#addDeleteFileModal").modal("show");
    }

    if (accion === AccionDoc.SUBIR_DOC) {
        const fileName = $(this).attr("data-file");
        window.location.href = getDocumentPath(tipoDocumento, fileName, 0, 0, 0);
        alerts.showNotification("top", "right", `${_("el-documento")} <b>` + nombreDocumento + `</b> ${_("descarga-exito")}`, "success");
    }

    if (accion === AccionDoc.ENVIAR_SOLICITUD) {
        $("#sendRequestButton").click();
    }
});

$(document).on("click", "#sendRequestButton", function () {
    const accion = parseInt($("#accion").val());

    if (accion === AccionDoc.DOC_NO_CARGADO) { // UPLOAD FILE
        const uploadedDocument = document.getElementById("fileElm").value;
        let validateUploadedDocument = (uploadedDocument.length === 0);

        // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVE A CABO EL REQUEST
        if (validateUploadedDocument) {
            alerts.showNotification("top", "right", `${_("antes-guardar")}`, "warning");
            return;
        }

        const archivo = $("#fileElm")[0].files[0];

        const tipoDocumento = parseInt($("#tipoDocumento").val());
        let extensionDeDocumento = archivo.name.split('.').pop();
        let extensionesPermitidas = getExtensionPorTipoDocumento(tipoDocumento);
        let statusValidateExtension = validateExtension(extensionDeDocumento, extensionesPermitidas);
        if (!statusValidateExtension) { // MJ: ARCHIVO VÁLIDO PARA CARGAR
            alerts.showNotification("top", "right",
                `${_("archivo-extension")} <b>${extensionDeDocumento}</b> ${_("no-valido")} ` +
                `${_("recuerda-archivo")} ${extensionesPermitidas}`, "warning");
            return;
        }

        const nombreDocumento = $("#nombreDocumento").val();
        let data = new FormData();
        data.append("idLote", $("#idLoteValue").val());
        data.append("idDocumento", $("#idDocumento").val());
        data.append("tipoDocumento", tipoDocumento);
        data.append("uploadedDocument", archivo);
        data.append("accion", accion);
        data.append('tituloDocumento', $('#tituloDocumento').val());

        $.ajax({
            url: `${general_base_url}Documentacion/subirArchivo`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function () {
                $('#uploadFileButton').prop('disabled', true);
            },
            success: function (response) {
                console.log("response: ", response);
                const res = JSON.parse(response);

                if (res.code === 200) {
                    alerts.showNotification("top", "right", `${_("el-documento")} ${nombreDocumento} ${_("descarga-exito")}`, "success");
                    documentacionLoteTabla.ajax.reload();
                    $("#addDeleteFileModal").modal("hide");
                }

                if (res.code === 400) {
                    alerts.showNotification("top", "right", res.message, "warning");
                }

                if (res.code === 500) {
                    alerts.showNotification("top", "right", `${_("algo-salio-mal")}`, "warning");
                }
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", `${_("algo-salio-mal")}`, "danger");
            }
        });
    } else { // VA A ELIMINAR
        const nombreDocumento = $("#nombreDocumento").val();

        let data = new FormData();
        data.append("idDocumento", $("#idDocumento").val());
        data.append("tipoDocumento", parseInt($("#tipoDocumento").val()));

        $.ajax({
            url: `${general_base_url}Documentacion/eliminarArchivo`,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                const res = JSON.parse(response);

                $("#sendRequestButton").prop("disabled", false);

                if (res.code === 200) {
                    alerts.showNotification("top", "right", `${_("el-documento")} ${nombreDocumento} ${_("eliminado-exito")}`, "success");

                    documentacionLoteTabla.ajax.reload();
                    $("#addDeleteFileModal").modal("hide");
                }

                if (res.code === 400) {
                    alerts.showNotification("top", "right", res.message, "warning");
                }

                if (res.code === 500) {
                    alerts.showNotification("top", "right", `${_("algo-salio-mal")}`, "warning");
                }
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", `${_("algo-salio-mal")}`, "danger");
            }
        });
    }
});

function abrirModalAutorizaciones(idLote) {
    $.post(`${general_base_url}registroLote/get_auts_by_lote/${idLote}`, function (data) {
        let statusProceso;
        $('#auts-loads').empty();

        $.each(JSON.parse(data), function (i, item) {
            if (item['estatus'] == 0) {
                statusProceso = `<small class='label lbl-green' data-i18n="aceptada">ACEPTADA</small>`;
            } else if (item['estatus'] == 1) {
                statusProceso = `<small class='label lbl-orangeYellow' data-i18n="en-proceso">En proceso</small>`;
            } else if (item['estatus'] == 2) {
                statusProceso = `<small class='label lbl-warning' data-i18n="denegada">DENEGADA</small>`;
            } else if (item['estatus'] == 3) {
                statusProceso = `<small class='label lbl-sky' data-i18n="en-dc">En DC</small>`;
            } else {
                statusProceso = "<small class='label lbl-gray'>N/A</small>";
            }
            item["ultima_fecha"] = moment(item["ultima_fecha"].split('.')[0], 'YYYY/MM/DD HH:mm:ss').format('DD/MM/YYYY HH:mm:ss');
            $('#auts-loads').append(`
            <div class="container-fluid" style="background-color: #f7f7f7; border-radius: 15px; padding: 15px; margin-bottom: 15px">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 float-end text-right">
                        ${item["ultima_fecha"]}
                    </div>
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <span style="font-weight:100; font-size: 12px" data-i18n="solicitud-autorizacion">Solicitud de autorización<b>: ${statusProceso}</b></span>
                        <span style="font-weight:100; font-size: 12px" data-i18n="autoriza">Autoriza<span>: ${item['nombreAUT'].split(":").shift()}</span></span>
                    </div>
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <p style="text-align: justify;">
                            <span class="font-weight:400">${item['autorizacion']}</span>
                        </p>
                    </div>
                </div>
            </div>
        `);
        });

        $('#verAutorizacionesAsesor').modal('show');
    });
}

/**
 * @param {number} tipoDocumento
 * @returns {string}
 */
function getExtensionPorTipoDocumento(tipoDocumento) {
    if (tipoDocumento === TipoDoc.CORRIDA) {
        return 'xlsx';
    }

    if (tipoDocumento === TipoDoc.CONTRATO || tipoDocumento === TipoDoc.CONTRATO_FIRMADO) {
        return 'pdf';
    }

    if (tipoDocumento === TipoDoc.COMPLEMENTO_DE_PAGO) {
        return 'pdf';
    }

    return 'jpg, jpeg, png, pdf';
}

/**
 * Función para crear el botón a partir del tipo de acción
 *
 * @param {number} type
 * @param {any} data
 * @returns {string}
 */
function crearBotonAccion(type, data) {
    const [
        buttonTitulo,
        buttonEstatus,
        buttonClassColor,
        buttonClassAccion,
        buttonTipoAccion,
        buttonIcono,
        buttonTooltip
    ] = getAtributos(type);

    const d = new Date();
    const dateStr = [d.getMonth() + 1, d.getDate(), d.getFullYear()].join('-');

    const tituloDocumento = `${data.nombreResidencial}_${data.nombre.slice(0, 4)}_${data.idLote}_${data.idCliente}` +
        `_TDOC${data.tipo_doc}${data.movimiento.slice(0, 4)}_${dateStr}`;

    return `<button class="${buttonClassColor} ${buttonClassAccion}" 
                title="${buttonTitulo}" 
                data-i18n-tooltip="${buttonTooltip}"
                data-expediente="${data.expediente}" 
                data-bucket="${data.bucket}"
                data-accion="${buttonTipoAccion}" 
                data-tipoDocumento="${data.tipo_doc}" ${buttonEstatus} 
                data-toggle="tooltip" 
                data-placement="left" 
                data-nombre="${data.movimiento}" 
                data-idDocumento="${data.idDocumento}" 
                data-idLote="${data.idLote}" 
                data-tituloDocumento="${tituloDocumento}"
                data-idCliente="${data.idCliente ?? data.id_cliente}"
                data-lp="${data.lugar_prospeccion}"
                data-idProspeccion="${data.id_prospecto}">
                    <i class="${buttonIcono}"></i>
            </button>`
}

/**
 * Función para obtener los atributos del botón de acción de la tabla
 *
 * @param {number} type
 * @returns {string[]}
 */
function getAtributos(type) {
    let buttonTitulo = '';
    let buttonEstatus = '';
    let buttonClassColor = '';
    let buttonClassAccion = '';
    let buttonIcono = '';
    let buttonTipoAccion = '';
    let buttonTooltip = '';

    if (type === AccionDoc.DOC_NO_CARGADO) {
        buttonTitulo = _("documento-no-cargado");
        buttonEstatus = 'disabled';
        buttonClassColor = 'btn-data btn-orangeYellow';
        buttonClassAccion = '';
        buttonIcono = 'fas fa-file';
        buttonTipoAccion = '';
        buttonTooltip = 'documento-no-cargado';
    }
    if (type === AccionDoc.DOC_CARGADO) {
        buttonTitulo = _("ver-documento");
        buttonEstatus = '';
        buttonClassColor = 'btn-data btn-blueMaderas';
        buttonClassAccion = 'verDocumento';
        buttonIcono = 'fas fa-eye';
        buttonTipoAccion = '3';
        buttonTooltip = 'ver-documento';
    }
    if (type === AccionDoc.SUBIR_DOC) {
        buttonTitulo = _("subir-documento");
        buttonEstatus = '';
        buttonClassColor = 'btn-data btn-green';
        buttonClassAccion = 'addRemoveFile';
        buttonIcono = 'fas fa-upload';
        buttonTipoAccion = '1';
        buttonTooltip = 'subir-documento';
    }
    if (type === AccionDoc.ELIMINAR_DOC) {
        buttonTitulo = _("eliminar-documento");
        buttonEstatus = '';
        buttonClassColor = 'btn-data btn-warning';
        buttonClassAccion = 'addRemoveFile';
        buttonIcono = 'fas fa-trash';
        buttonTipoAccion = '2';
        buttonTooltip = 'elimitar-document';
    }

    return [buttonTitulo, buttonEstatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono, buttonTooltip]
}

/**
 * Método que busca si un valor está dentro del objeto
 *
 * @param {number[]|string[]} arr
 * @param {string} searchArray
 * @returns boolean
 */
function includesArray(arr, searchArray) {
    return arr.includes(parseInt(searchArray));
}

/**
 * Función para descargar un archivo en otra pestaña
 *
 * @param {string} pathUrl
 * @param {string} filename
 */
function descargarArchivo(pathUrl, filename) {
    const a = document.createElement("a");
    a.href = pathUrl;
    a.target = "_blank";
    a.download = filename;
    a.click();
}

function fileExists(path) {
    console.log('path', path);
    /*fetch(path, { method: 'HEAD'})
        .then(response => {
            console.log('Respuesta check archivo:', response);
            if(response.ok){
                console.log('Foto existe');
            }
            else{
                console.log('Foto no existe');
            }
        });*/
    var http = new XMLHttpRequest();
    http.open('HEAD', path, false);
    http.send();
    return http.status != 404;
}