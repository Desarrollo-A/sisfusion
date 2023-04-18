var movimientosPermitidosContrato = ["36", "6", "23", "76", "83", "95", "97"];
var rolesPermitidosContrato = [15];

var movimientosPermitidosContratoFirmado= ["45"];
var movimientosPermitidosCorrida = ["35", "22", "62", "75", "94", "106"];
var rolesPermitidosContraloria = [13, 17, 32, 70];

var movimientosPermitidosCartaDomicilio = ["37", "7", "64", "66", "77", "41"];
var rolesPermitidosCartaDomicilio = [5, 2];

var movimientosPermitidosEstatus2 = ["31", "85", "20", "63", "73", "82", "92", "96"];
var rolesPermitidosEstatus2 = [7, 9, 3, 2];
Shadowbox.init();

$(document).ready(function () {
    $(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length)
            input.val(log);
        else
            if (log) alert(log);
    });
});

$(document).on('change', '.btn-file :file', function () {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

$('#idResidencial').change(function () {
    $("#idCondominio").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}registroCliente/getCondominios/${$(this).val()}`,
        type: 'post',
        dataType: 'json',
        success: function (response) {
            for (var i = 0; i < response.length; i++) {
                $("#idCondominio").append($('<option>').val(response[i]['idCondominio']).text(response[i]['nombre']));
            }
            $("#idCondominio").selectpicker('refresh');
        }
    });
});

$('#idCondominio').change(function () {
    $("#idLote").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}registroCliente/getLotesAsesor/${$(this).val()}/${$('#idResidencial').val()}`,
        type: 'post',
        dataType: 'json',
        success: function (response) {
            for (var i = 0; i < response.length; i++) {
                $("#idLote").append($('<option>').val(response[i]['idLote'] + ',' + response[i]['venta_compartida']).text(response[i]['nombreLote']));
            }
            $("#idLote").selectpicker('refresh');
        },
    });
});

let titulos = [];
$('#tableDoct thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos.push(title);
});

$('#idLote').change(function () {
    var seleccion = $(this).val();
    let datos = seleccion.split(',');
    let valorSeleccionado = datos[0];
    let ventaC = datos[1];
    let titulos = [];
    $('#tableDoct thead tr:eq(0) th').each(function (i) {
        $(this).css('text-align', 'center');
        var title = $(this).text();
        titulos.push(title);
        $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($('#tableDoct').DataTable().column(i).search() !== this.value) {
                $('#tableDoct').DataTable().column(i).search(this.value).draw();
            }
        });
    });

    function getAtributos(type) {
        if (type == 1) { // NO HAY DOCUMENTO CARGADO
            buttonTitle = 'Documento no cargado';
            buttonStatus = 'disabled';
            buttonClassColor = 'btn-data btn-orangeYellow';
            buttonClassAction = '';
            buttonIcon = 'fas fa-file';
            buttonTypeTransaction = '';
        } else if (type == 2) { // LA RAMA TIENE UN DOCUMENTO CARGADO
            buttonTitle = 'Ver documento';
            buttonStatus = '';
            buttonClassColor = 'btn-data btn-blueMaderas';
            buttonClassAction = 'verDocumento';
            buttonIcon = 'fas fa-eye';
            buttonTypeTransaction = '1';
        } else if (type == 3) { // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
            buttonTitle = 'Subir documento';
            buttonStatus = '';
            buttonClassColor = 'btn-data btn-green';
            buttonClassAction = 'subirDocumento';
            buttonIcon = 'fas fa-upload';
            buttonTypeTransaction = '2';
        }  else if (type == 4) { // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
            buttonTitle = 'Eliminar documento';
            buttonStatus = '';
            buttonClassColor = 'btn-data btn-warning';
            buttonClassAction = 'eliminarDocumento';
            buttonIcon = 'fas fa-trash';
            buttonTypeTransaction = '3';
        }
        return [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon]
    }

    $('#tableDoct').DataTable({
        destroy: true,
        ajax: {
            url: `${general_base_url}registroCliente/expedientesWS/${valorSeleccionado}`,
            dataSrc: ""
        },
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        scrollX: true,
        ordering: false,
        pageLength: 20,
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
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
                    return myFunctions.validateEmptyFieldDocs(data.primerNom) + ' ' + myFunctions.validateEmptyFieldDocs(data.apellidoPa) + ' ' + myFunctions.validateEmptyFieldDocs(data.apellidoMa);
                },
            },
            { data: 'ubic' },
            {
                data: null,
                render: function (data) {
                    buttonMain = '';
                    buttonDelete = '';
                    buttonTitle = '';
                    buttonStatus = '';
                    buttonClassColor = ''
                    buttonClassAction = '';
                    buttonIcon = '';
                    buttonTypeTransaction = '';

                    if (data.tipo_doc == 8) { // CONTRATO
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidosContrato.includes(data.idMovimiento) && rolesPermitidosContrato.includes(id_rol_general)) // ESTÁ EN ESTATUS 7 Y ES JURÍDICO EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidosContrato.includes(data.idMovimiento) && rolesPermitidosContrato.includes(id_rol_general)) { // ESTÁ EN ESTATUS 7 Y ES JURÍDICO EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else if (data.tipo_doc == 7) { // CORRIDA
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidosCorrida.includes(data.idMovimiento) && rolesPermitidosContraloria.includes(id_rol_general)) // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidosCorrida.includes(data.idMovimiento) && rolesPermitidosContraloria.includes(id_rol_general)) { // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else if (data.tipo_doc == 29) { // CARTA DOMICILIO
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidosCartaDomicilio.includes(data.idMovimiento) && rolesPermitidosCartaDomicilio.includes(id_rol_general)) // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidosCartaDomicilio.includes(data.idMovimiento) && rolesPermitidosCartaDomicilio.includes(id_rol_general)) { // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else if (data.tipo_doc == 30) { // CONTRATO FIRMADO
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidosContratoFirmado.includes(data.idMovimiento) && rolesPermitidosContraloria.includes(id_rol_general)) // ESTÁ EN ESTATUS 15 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidosContratoFirmado.includes(data.idMovimiento) && rolesPermitidosContraloria.includes(id_rol_general)) { // ESTÁ EN ESTATUS 8 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 'ds_new' && data.expediente == "Depósito de seriedad") { // EXISTE EL DEPÓSITO DE SERIEDAD (VERSIÓN NUVEA)
                        var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 'ds_new' && data.expediente == "Depósito de seriedad versión anterior") { // EXISTE EL DEPÓSITO DE SERIEDAD (VERSIÓN VIEJITA)
                        var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 66) { // EXISTE LA RAMA CON LA EVIDENCIA DE MKTD (OLD)
                        var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 'autorizaciones') { // EXISTE LA RAMA DE AUTORIZACIONES
                        var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 'prospecto') { // EXISTE LA RAMA DEL PROSPECTO
                        var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    } else { // ES EL RESTO DEL EXPEDIENTE (HISTORIAL DOCUMENTOS)
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidosEstatus2.includes(data.idMovimiento) && rolesPermitidosEstatus2.includes(id_rol_general) && data.id_asesor == id_usuario_general) // ESTÁ EN ESTATUS 2 Y ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidosEstatus2.includes(data.idMovimiento) && rolesPermitidosEstatus2.includes(id_rol_general) && data.id_asesor == id_usuario_general) { // ESTÁ EN ESTATUS 2 Y ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonStatus, buttonClassColor, buttonClassAction, buttonTypeTransaction, buttonIcon] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction}" data-tipo-documento="${data.tipo_doc}" ${buttonStatus}><i class="${buttonIcon}"></i></button>`;
                    }
                   return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                }
            }
        ]
    });
});

$(document).on('click', '.pdfLink', function () {
    var $itself = $(this);
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src=${general_base_url}static/documentos/cliente/expediente/${$itself.attr('data-expediente')}"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${$itself.attr('data-expediente')}`,
        width: 985,
        height: 660
    });
});

$(document).on('click', '.seeAuts', function (e) {
    e.preventDefault();
    var $itself = $(this);
    var idLote = $itself.attr('data-idLote');
    $.post(`${general_base_url}registroLote/get_auts_by_lote/${idLote}`, function (data) {
        $('#auts-loads').empty();
        var statusProceso;
        $.each(JSON.parse(data), function (i, item) {
            if (item['estatus'] == 0)
                statusProceso = "<small class='label bg-green' style='background-color: #00a65a'>ACEPTADA</small>";
            else if (item['estatus'] == 1)
                statusProceso = "<small class='label bg-orange' style='background-color: #FF8C00'>En proceso</small>";
            else if (item['estatus'] == 2)
                statusProceso = "<small class='label bg-red' style='background-color: #8B0000'>DENEGADA</small>";
            else if (item['estatus'] == 3)
                statusProceso = "<small class='label bg-blue' style='background-color: #00008B'>En DC</small>";
            else
                statusProceso = "<small class='label bg-gray' style='background-color: #2F4F4F'>N/A</small>";
            $('#auts-loads').append('<h4>Solicitud de autorización:  ' + statusProceso + '</h4><br>');
            $('#auts-loads').append('<h4>Autoriza: ' + item['nombreAUT'] + '</h4><br>');
            $('#auts-loads').append('<p style="text-align: justify;"><i>' + item['autorizacion'] + '</i></p><br><hr>');
        });
        $('#verAutorizacionesAsesor').modal('show');
    });
});
