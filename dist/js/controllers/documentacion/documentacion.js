$('[data-toggle="tooltip"]').tooltip();

const movimientosPermitidosContrato = [36, 6, 23, 76, 83, 95, 97, 112];
const rolesPermitidosContrato = [15];

const movimientosPermitidosContratoFirmado = [45];
const movimientosPermitidosCorrida = [35, 22, 62, 75, 94, 106];
const rolesPermitidosContraloria = [17, 70];

const movimientosPermitidosCartaDomicilio = [37, 7, 64, 66, 77, 41];
const rolesPermitidosCartaDomicilio = [5, 2, 6];

const movimientosPermitidosEstatus2 = [31, 85, 20, 63, 73, 82, 92, 96, 99, 102, 104, 107, 108, 109, 111];
const rolesPermitidosEstatus2 = [7, 9, 3, 2];

const rolesPermitidosEstatus2AsesorInactivo = [6];

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
    EVIDENCIA_MKTD_OLD: 66, // EXISTE LA RAMA CON LA EVIDENCIA DE MKTD (OLD)
    AUTORIZACIONES: 'autorizacion',
    PROSPECTO: 'prospecto',
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
    const seleccion = $(this).val();
    const datos = seleccion.split(',');
    const idLote = datos[0];

    if (document.getElementById('idCliente')) {
        $('#spiner-loader').removeClass('hide');
        $("#idCliente").empty().selectpicker('refresh');
        $.ajax({
            url: `${general_base_url}Documentacion/getClientesPorLote/${idLote}`,
            type: 'post',
            dataType: 'json',
            success:function(response){
                if(response.length > 0){
                    for( var i = 0; i < response.length; i++) {
                        let labelStatus='';
                        if(response[i]['status'] == 1)
                            labelStatus=' [ACTIVO]'
                        $("#idCliente").append($('<option>').val(response[i]['id_cliente']).text(response[i]['nombreCliente'] + labelStatus));
                    }
                } else {
                    $("#idCliente").append($('<option selected>').val(0).text('SIN CLIENTES'));
                }

                $("#idCliente").selectpicker('refresh');
            },
            complete: function () {
                $('#spiner-loader').addClass('hide');
            }
        });
        return;
    }

    cargarTabla(idLote);
});

$('#idCliente').change(function () {
    const loteVal = $("#idLote").val();
    const loteValues = loteVal.split(',');
    const idLote = loteValues[0];

    const seleccionCliente = $(this).val();
    const datosCliente = seleccionCliente.split(',');
    const idCliente = datosCliente[0];

    cargarTabla(idLote, idCliente);
});

$(".find_doc").click(function () {
    const idLote = $('#inp_lote').val();
    if(idLote === '' || idLote === undefined || idLote === null) {
        alerts.showNotification('top', 'right', 'Ingresa el ID de lote', 'danger');
        return;
    }

    cargarTabla(idLote);
});

function cargarTabla(idLote, idCliente = '') {
    $('#tableDoct').removeClass('hide');

    $('#tableDoct thead tr:eq(0) th').each(function (i) {

        $(this).css('text-align', 'center');
        const title = $(this).text();
        titulos.push(title);

        $(this).html('<input type="text" data-toggle="tooltip" data-placement="top" title="' + title + '" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tableDoct').DataTable().column(i).search() !== this.value) {
                $('#tableDoct').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    documentacionLoteTabla = $('#tableDoct').DataTable({
        destroy: true,
        ajax: {
            url: `${general_base_url}registroCliente/expedientesWS/${idLote}/${idCliente}`,
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
                titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
                title: 'DOCUMENTACION_LOTE',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos[columnIdx] + ' ';
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
                            ? '<p>En proceso de liberación</p>'
                            : crearBotonAccion(AccionDoc.DOC_CARGADO, data);

                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    if (data.tipo_doc == TipoDoc.CONTRATO) { // CONTRATO
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = (includesArray(movimientosPermitidosContrato, data.idMovimiento) && includesArray(rolesPermitidosContrato, id_rol_general))
                                // ESTÁ EN ESTATUS 7 Y ES JURÍDICO EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);

                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        if (includesArray(movimientosPermitidosContrato, data.idMovimiento) && includesArray(rolesPermitidosContrato, id_rol_general)) {
                            buttonDelete = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        }

                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    if (data.tipo_doc == TipoDoc.CORRIDA) { // CORRIDA
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = (includesArray(movimientosPermitidosCorrida, data.idMovimiento) && includesArray(rolesPermitidosContraloria, id_rol_general))
                                // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);

                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                        if (includesArray(movimientosPermitidosCorrida, data.idMovimiento) && includesArray(rolesPermitidosContraloria, id_rol_general)) {
                            buttonDelete  = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        }

                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    if (data.tipo_doc == TipoDoc.CARTA_DOMICILIO) { // CARTA DOMICILIO
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = (
                                includesArray(movimientosPermitidosCartaDomicilio, data.idMovimiento) &&
                                includesArray(rolesPermitidosCartaDomicilio, id_rol_general) &&
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
                            includesArray(movimientosPermitidosCartaDomicilio, data.idMovimiento) &&
                            includesArray(rolesPermitidosCartaDomicilio, id_rol_general) &&
                            parseInt(data.status8Flag) !== status8Flag
                        ) {
                            buttonDelete  = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        }

                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    if (data.tipo_doc == TipoDoc.CONTRATO_FIRMADO) { // CONTRATO FIRMADO
                        if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                            buttonMain = (includesArray(movimientosPermitidosContratoFirmado, data.idMovimiento) && includesArray(rolesPermitidosContraloria, id_rol_general))
                                // ESTÁ EN ESTATUS 15 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);

                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        // ESTÁ EN ESTATUS 8 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                        if (includesArray(movimientosPermitidosContratoFirmado, data.idMovimiento) && includesArray(rolesPermitidosContraloria, id_rol_general)) {
                            buttonDelete  = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        }

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

                    // EL ASESOR ESTÁ INACTIVO Y EL ROL DE
                    if (data.estatusAsesor != 1) {
                        if (data.expediente == null || data.expediente === "") {
                            buttonMain = (
                                includesArray(movimientosPermitidosEstatus2, parseInt(data.idMovimiento)) &&
                                includesArray(rolesPermitidosEstatus2AsesorInactivo, parseInt(id_rol_general))
                            )
                                ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                                : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);

                            return `<div class="d-flex justify-center">${buttonMain}</div>`;
                        }

                        // LA RAMA TIENE UN DOCUMENTO CARGADO
                        buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                        if (includesArray(movimientosPermitidosEstatus2, data.idMovimiento) && includesArray(rolesPermitidosEstatus2AsesorInactivo, id_rol_general)) {
                            buttonDelete  = crearBotonAccion(AccionDoc.ELIMINAR_DOC, data);
                        }

                        return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                    }

                    // ES EL RESTO DEL EXPEDIENTE (HISTORIAL DOCUMENTOS)
                    if (data.expediente == null || data.expediente === "") { // NO HAY DOCUMENTO CARGADO
                        buttonMain = (
                            includesArray(movimientosPermitidosEstatus2, parseInt(data.idMovimiento)) &&
                            includesArray(rolesPermitidosEstatus2, parseInt(id_rol_general)) &&
                            parseInt(data.id_asesor) === parseInt(id_usuario_general)
                        )
                            // ESTÁ EN ESTATUS 2 Y ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                            ? crearBotonAccion(AccionDoc.SUBIR_DOC, data)
                            // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                            : crearBotonAccion(AccionDoc.DOC_NO_CARGADO, data);

                        return `<div class="d-flex justify-center">${buttonMain}</div>`;
                    }

                    // LA RAMA TIENE UN DOCUMENTO CARGADO
                    buttonMain = crearBotonAccion(AccionDoc.DOC_CARGADO, data); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO

                    // ESTÁ EN ESTATUS 2 Y ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                    if (
                        movimientosPermitidosEstatus2.includes(parseInt(data.idMovimiento)) &&
                        rolesPermitidosEstatus2.includes(parseInt(id_rol_general)) &&
                        parseInt(data.id_asesor) === parseInt(id_usuario_general)
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
}

$(document).on('click', '.verDocumento', function () {
    const $itself = $(this);

    let pathUrl = `${general_base_url}static/documentos/cliente/${obtenerPathDoc($itself.attr('data-tipoDocumento'))}`+$itself.attr('data-expediente');

    if ($itself.attr('data-tipoDocumento') === TipoDoc.DS_NEW) {
        const idCliente = $itself.attr('data-idCliente');
        const urlDs = ($itself.attr('data-expediente') === 'Depósito de seriedad')
            ? 'deposito_seriedad' : 'deposito_seriedad_ds';

        pathUrl = `${general_base_url}asesor/${urlDs}/${idCliente}/1`;
    }
    if (parseInt($itself.attr('data-tipoDocumento')) === TipoDoc.CORRIDA) {
        descargarArchivo(pathUrl, $itself.attr('data-expediente'));

        alerts.showNotification('top', 'right', 'El documento <b>' + $itself.attr('data-expediente') + '</b> se ha descargado con éxito.', 'success');
        return;
    }

    if ($itself.attr('data-tipoDocumento') === TipoDoc.AUTORIZACIONES) {
        abrirModalAutorizaciones($itself.attr('data-idLote'));
        return;
    }

    if ($itself.attr('data-tipoDocumento') === TipoDoc.DS_NEW) {
        const idCliente = $itself.attr('data-idCliente');
        const urlDs = ($itself.attr('data-expediente') === 'Depósito de seriedad')
            ? 'deposito_seriedad' : 'deposito_seriedad_ds';

        pathUrl = `${general_base_url}asesor/${urlDs}/${idCliente}/1`;
    }

    if ($itself.attr('data-tipoDocumento') === TipoDoc.PROSPECTO) {
        const urlProspecto =  ($itself.attr('data-lp') == 6) ? 'printProspectInfoMktd' : 'printProspectInfo';

        pathUrl = `${general_base_url}clientes/${urlProspecto}/`+$itself.attr('data-idProspeccion');
    }

    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${pathUrl}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${$itself.attr('data-expediente')}`,
        width: 985,
        height: 660
    });
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
                ? 'Selecciona el archivo que desees asociar a <b>' + nombreDocumento + '</b>'
                : (accion === AccionDoc.DOC_CARGADO)
                    ? '¿Estás seguro de eliminar el archivo <b>' + nombreDocumento + '</b>?'
                    : 'Selecciona los motivos de rechazo que asociarás al documento <b>' + nombreDocumento + '</b>.';

        document.getElementById("secondaryLabelDetail").innerHTML =
            (accion === AccionDoc.DOC_NO_CARGADO)
                ? 'El documento que hayas elegido se almacenará de manera automática una vez que des clic en <i>Guardar</i>.'
                : (accion === AccionDoc.DOC_CARGADO)
                    ? 'El documento se eliminará de manera permanente una vez que des clic en <i>Guardar</i>.'
                    : 'Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en <i>Guardar</i>.';

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
        alerts.showNotification("top", "right", "El documento <b>" + nombreDocumento + "</b> se ha descargado con éxito.", "success");
    }

    if (accion === AccionDoc.ENVIAR_SOLICITUD) {
        $("#sendRequestButton").click();
    }
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    const accion = parseInt($("#accion").val());

    if (accion === AccionDoc.DOC_NO_CARGADO) { // UPLOAD FILE
        const uploadedDocument = document.getElementById("fileElm").value;
        let validateUploadedDocument = (uploadedDocument.length === 0);

        // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVE A CABO EL REQUEST
        if (validateUploadedDocument) {
            alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
            return;
        }

        const archivo = $("#fileElm")[0].files[0];

        const tipoDocumento = parseInt($("#tipoDocumento").val());
        let extensionDeDocumento = archivo.name.split('.').pop();
        let extensionesPermitidas = getExtensionPorTipoDocumento(tipoDocumento);
        let statusValidateExtension = validateExtension(extensionDeDocumento, extensionesPermitidas);
        if (!statusValidateExtension) { // MJ: ARCHIVO VÁLIDO PARA CARGAR
            alerts.showNotification("top", "right",
                `El archivo que has intentado cargar con la extensión <b>${extensionDeDocumento}</b> no es válido. `+
                    `Recuerda seleccionar un archivo ${extensionesPermitidas}`, "warning");
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
            url: "subirArchivo",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend: function () {
                $('#uploadFileButton').prop('disabled', true);
            },
            success: function (response) {
                const res = JSON.parse(response);

                if (res.code === 200) {
                    alerts.showNotification("top", "right", `El documento ${nombreDocumento} se ha cargado con éxito.`, "success");
                    documentacionLoteTabla.ajax.reload();
                    $("#addDeleteFileModal").modal("hide");
                }

                if (res.code === 400) {
                    alerts.showNotification("top", "right", res.message, "warning");
                }

                if (res.code === 500) {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                }
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    } else { // VA A ELIMINAR
        const nombreDocumento = $("#nombreDocumento").val();

        let data = new FormData();
        data.append("idDocumento", $("#idDocumento").val());
        data.append("tipoDocumento", parseInt($("#tipoDocumento").val()));

        $.ajax({
            url: "eliminarArchivo",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                const res = JSON.parse(response);

                $("#sendRequestButton").prop("disabled", false);

                if (res.code === 200) {
                    alerts.showNotification("top", "right", `El documento ${nombreDocumento} se ha eliminado con éxito.`, "success");

                    documentacionLoteTabla.ajax.reload();
                    $("#addDeleteFileModal").modal("hide");
                }

                if (res.code === 400) {
                    alerts.showNotification("top", "right", res.message, "warning");
                }

                if (res.code === 500) {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                }
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
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
                statusProceso = "<small class='label lbl-green'>ACEPTADA</small>";
            } else if (item['estatus'] == 1) {
                statusProceso = "<small class='label lbl-orangeYellow'>En proceso</small>";
            } else if (item['estatus'] == 2) {
                statusProceso = "<small class='label lbl-warning'>DENEGADA</small>";
            } else if (item['estatus'] == 3) {
                statusProceso = "<small class='label lbl-sky'>En DC</small>";
            } else {
                statusProceso = "<small class='label lbl-gray'>N/A</small>";
            }

            $('#auts-loads').append(`
            <div class="container-fluid" style="background-color: #f7f7f7; border-radius: 15px; padding: 15px; margin-bottom: 15px">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-7">
                        <span style="font-weight:100; font-size: 12px">Solicitud de autorización: <b>${statusProceso}</b></span>
                        <span style="font-weight:100; font-size: 12px">Autoriza:${item['nombreAUT'].split(":").shift()}</span>
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
        buttonIcono
    ] = getAtributos(type);

    const d = new Date();
    const dateStr = [d.getMonth()+1,d.getDate(),d.getFullYear()].join('-');

    const tituloDocumento =`${data.nombreResidencial}_${data.nombre.slice(0,4)}_${data.idLote}_${data.idCliente}`+
        `_TDOC${data.tipo_doc}${data.movimiento.slice(0,4)}_${dateStr}`;

    return `<button class="${buttonClassColor} ${buttonClassAccion}" 
                title="${buttonTitulo}" 
                data-expediente="${data.expediente}" 
                data-accion="${buttonTipoAccion}" 
                data-tipoDocumento="${data.tipo_doc}" ${buttonEstatus} 
                data-toggle="tooltip" 
                data-placement="top" 
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

    if (type === AccionDoc.DOC_NO_CARGADO) {
        buttonTitulo = 'DOCUMENTO NO CARGADO';
        buttonEstatus = 'disabled';
        buttonClassColor = 'btn-data btn-orangeYellow';
        buttonClassAccion = '';
        buttonIcono = 'fas fa-file';
        buttonTipoAccion = '';
    }
    if (type === AccionDoc.DOC_CARGADO) {
        buttonTitulo = 'VER DOCUMENTO';
        buttonEstatus = '';
        buttonClassColor = 'btn-data btn-blueMaderas';
        buttonClassAccion = 'verDocumento';
        buttonIcono = 'fas fa-eye';
        buttonTipoAccion = '3';
    }
    if (type === AccionDoc.SUBIR_DOC) {
        buttonTitulo = 'SUBIR DOCUMENTO';
        buttonEstatus = '';
        buttonClassColor = 'btn-data btn-green';
        buttonClassAccion = 'addRemoveFile';
        buttonIcono = 'fas fa-upload';
        buttonTipoAccion = '1';
    }
    if (type === AccionDoc.ELIMINAR_DOC) {
        buttonTitulo = 'ELIMINAR DOCUMENTO';
        buttonEstatus = '';
        buttonClassColor = 'btn-data btn-warning';
        buttonClassAccion = 'addRemoveFile';
        buttonIcono = 'fas fa-trash';
        buttonTipoAccion = '2';
    }

    return [buttonTitulo, buttonEstatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono]
}

/**
 * @param {number} tipoDocumento
 * @returns {string}
 */
function obtenerPathDoc(tipoDocumento) {
    if (parseInt(tipoDocumento) === TipoDoc.CORRIDA) { // CORRIDA FINANCIERA: CONTRALORÍA
        return 'corrida/';
    }

    if (parseInt(tipoDocumento) === TipoDoc.CONTRATO) { // CONTRATO: JURÍDICO
        return 'contrato/';
    }

    if (parseInt(tipoDocumento) === TipoDoc.CONTRATO_FIRMADO) { // CONTRATO FIRMADO: CONTRALORÍA
        return 'contratoFirmado/';
    }

    // EL RESTO DE DOCUMENTOS SE GUARDAN EN LA CARPETA DE EXPEDIENTES
    return 'expediente/';
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
    const a = document.createElement('a');
    a.href = pathUrl;
    a.target = '_blank';
    a.download = filename;
    a.click();
}