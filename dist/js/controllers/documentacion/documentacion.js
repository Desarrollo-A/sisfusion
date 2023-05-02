$('[data-toggle="tooltip"]').tooltip();

var movimientosPermitidosContrato = ["36", "6", "23", "76", "83", "95", "97"];
var rolesPermitidosContrato = [15];

var movimientosPermitidosContratoFirmado = ["45"];
var movimientosPermitidosCorrida = ["35", "22", "62", "75", "94", "106"];
var rolesPermitidosContraloria = [13, 17, 32, 70];

var movimientosPermitidosCartaDomicilio = ["37", "7", "64", "66", "77", "41"];
var rolesPermitidosCartaDomicilio = [5, 2];

var movimientosPermitidosEstatus2 = ["31", "85", "20", "63", "73", "82", "92", "96", "99", "104"];
var rolesPermitidosEstatus2 = [7, 9, 3, 2];

Shadowbox.init();

$(document).ready(function () {
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
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

$('#idLote').change(function () {
    var seleccion = $(this).val();
    let datos = seleccion.split(',');
    let valorSeleccionado = datos[0];
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
            buttonTitulo = 'Documento no cargado';
            buttonEtatus = 'disabled';
            buttonClassColor = 'btn-data btn-orangeYellow';
            buttonClassAccion = '';
            buttonIcono = 'fas fa-file';
            buttonTipoAccion = '';
        } else if (type == 2) { // LA RAMA TIENE UN DOCUMENTO CARGADO
            buttonTitulo = 'Ver documento';
            buttonEtatus = '';
            buttonClassColor = 'btn-data btn-blueMaderas';
            buttonClassAccion = 'verDocumento';
            buttonIcono = 'fas fa-eye';
            buttonTipoAccion = '3';
        } else if (type == 3) { // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
            buttonTitulo = 'Subir documento';
            buttonEtatus = '';
            buttonClassColor = 'btn-data btn-green';
            buttonClassAccion = 'addRemoveFile';
            buttonIcono = 'fas fa-upload';
            buttonTipoAccion = '1';
        } else if (type == 4) { // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
            buttonTitulo = 'Eliminar documento';
            buttonEtatus = '';
            buttonClassColor = 'btn-data btn-warning';
            buttonClassAccion = 'addRemoveFile';
            buttonIcono = 'fas fa-trash';
            buttonTipoAccion = '2';
        }
        return [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono]
    }

    $('#tableDoct').DataTable({
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
                    buttonTitulo = '';
                    buttonEtatus = '';
                    buttonClassColor = ''
                    buttonClassAccion = '';
                    buttonIcono = '';
                    buttonTipoAccion = '';

                    if (data.tipo_doc == 8) { // CONTRATO
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if (movimientosPermitidosContrato.includes(data.idMovimiento) && rolesPermitidosContrato.includes(id_rol_general)) // ESTÁ EN ESTATUS 7 Y ES JURÍDICO EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if (movimientosPermitidosContrato.includes(data.idMovimiento) && rolesPermitidosContrato.includes(id_rol_general)) { // ESTÁ EN ESTATUS 7 Y ES JURÍDICO EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else if (data.tipo_doc == 7) { // CORRIDA
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if (movimientosPermitidosCorrida.includes(data.idMovimiento) && rolesPermitidosContraloria.includes(id_rol_general)) // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if (movimientosPermitidosCorrida.includes(data.idMovimiento) && rolesPermitidosContraloria.includes(id_rol_general)) { // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else if (data.tipo_doc == 29) { // CARTA DOMICILIO
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if (movimientosPermitidosCartaDomicilio.includes(data.idMovimiento) && rolesPermitidosCartaDomicilio.includes(id_rol_general)) // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if (movimientosPermitidosCartaDomicilio.includes(data.idMovimiento) && rolesPermitidosCartaDomicilio.includes(id_rol_general)) { // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else if (data.tipo_doc == 30) { // CONTRATO FIRMADO
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if (movimientosPermitidosContratoFirmado.includes(data.idMovimiento) && rolesPermitidosContraloria.includes(id_rol_general)) // ESTÁ EN ESTATUS 15 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if (movimientosPermitidosContratoFirmado.includes(data.idMovimiento) && rolesPermitidosContraloria.includes(id_rol_general)) { // ESTÁ EN ESTATUS 8 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else if (data.tipo_doc == 'ds_new' && data.expediente == "Depósito de seriedad") { // EXISTE EL DEPÓSITO DE SERIEDAD (VERSIÓN NUVEA)
                        var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else if (data.tipo_doc == 'ds_new' && data.expediente == "Depósito de seriedad versión anterior") { // EXISTE EL DEPÓSITO DE SERIEDAD (VERSIÓN VIEJITA)
                        var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else if (data.tipo_doc == 66) { // EXISTE LA RAMA CON LA EVIDENCIA DE MKTD (OLD)
                        var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else if (data.tipo_doc == 'autorizaciones') { // EXISTE LA RAMA DE AUTORIZACIONES
                        var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else if (data.tipo_doc == 'prospecto') { // EXISTE LA RAMA DEL PROSPECTO
                        var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                    } else { // ES EL RESTO DEL EXPEDIENTE (HISTORIAL DOCUMENTOS)
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if (movimientosPermitidosEstatus2.includes(data.idMovimiento) && rolesPermitidosEstatus2.includes(id_rol_general) && data.id_asesor == id_usuario_general) // ESTÁ EN ESTATUS 2 Y ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if (movimientosPermitidosEstatus2.includes(data.idMovimiento) && rolesPermitidosEstatus2.includes(id_rol_general) && data.id_asesor == id_usuario_general) { // ESTÁ EN ESTATUS 2 Y ES ASESOR, COORDINADOR, GERENTE O SUBDIRECTOR EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitulo, buttonEtatus, buttonClassColor, buttonClassAccion, buttonTipoAccion, buttonIcono] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassColor} ${buttonClassAccion}" title="${buttonTitulo}" data-expediente="${data.expediente}" data-accion="${buttonTipoAccion}" data-tipoDocumento="${data.tipo_doc}" ${buttonEtatus} data-toggle="tooltip" data-placement="left" data-nombre="${data.movimiento}" data-idDocumento="${data.idDocumento}" data-idLote="${data.idLote}"><i class="${buttonIcono}"></i></button>`;
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

$(document).on("click", ".addRemoveFile", function (e) {
    e.preventDefault();
    let idDocumento = $(this).attr("data-idDocumento");
    let tipoDocumento = $(this).attr("data-tipoDocumento");
    let accion = $(this).data("accion");
    let nombreDocumento = $(this).data("nombre");
    $("#idLoteValue").val($(this).attr("data-idLote"));
    $("#idDocumento").val(idDocumento);
    $("#tipoDocumento").val(tipoDocumento);
    $("#nombreDocumento").val(nombreDocumento);
    $("#accion").val(accion);
    if (accion == 1 || accion == 2) {
        document.getElementById("mainLabelText").innerHTML = accion == 1 ? "Selecciona el archivo que desees asociar a <b>" + nombreDocumento + "</b>" : accion == 2 ? "¿Estás seguro de aliminar el archivo <b>" + nombreDocumento + "</b>?" : "Selecciona los motivos de rechazo que asociarás al documento <b>" + nombreDocumento + "</b>.";
        document.getElementById("secondaryLabelDetail").innerHTML = accion == 1 ? "El documento que hayas elegido se almacenará de manera automática una vez que des clic en <i>Guardar</i>." : accion == 2 ? "El documento se eliminará de manera permanente una vez que des clic en <i>Guardar</i>." : "Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en <i>Guardar</i>.";
        if (accion == 1) { // ADD FILE
            $("#selectFileSection").removeClass("hide");
            $("#txtexp").val("");
        } else if (accion == 2) // REMOVE FILE
            $("#selectFileSection").addClass("hide");
        $("#addDeleteFileModal").modal("show");
    } else if (accion == 3) {
        let fileName = $(this).attr("data-file");
        let url = getDocumentPath(tipoDocumento, fileName, 0, 0, 0);
        window.location.href = url;
        alerts.showNotification("top", "right", "El documento <b>" + nombreDocumento + "</b> se ha descargado con éxito.", "success");
    } else if (accion == 5)
        $("#sendRequestButton").click();
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    let accion = $("#accion").val();
    let sendRequestPermission = 0;
    if (accion == 1) { // UPLOAD FILE
        var uploadedDocument = document.getElementById("fileElm").value;
        let validateUploadedDocument = (uploadedDocument == '') ? 0 : 1;
        // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVAR A CABO EL REQUEST
        if (validateUploadedDocument == 0)
            alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
        else { // PUEDE MANDAR EL REQUEST PORQUE SÍ HAY ARCHIVO SELECCIONADO
            let tipoDocumento = $("#tipoDocumento").val();
            let extensionDeDocumento = uploadedDocument.substring(uploadedDocument.lastIndexOf("."));
            let extensionesPermitidas = getExtensionPorTipoDocumento(tipoDocumento);
            let statusValidateExtension = validateExtension(extensionDeDocumento, extensionesPermitidas);
            if (statusValidateExtension == false) // MJ: ARCHIVO VÁLIDO PARA CARGAR
                alerts.showNotification("top", "right", `El archivo que has intentado cargar con la extensión <b>${extensionDeDocumento}</b> no es válido. Recuerda seleccionar un archivo ${extensionesPermitidas}`, "warning");
            else {
                let data = new FormData();
                data.append("idLote", $("#idLoteValue").val());
                data.append("idDocumento", $("#idDocumento").val());
                data.append("tipoDocumento", tipoDocumento);
                data.append("uploadedDocument", $("#fileElm")[0].files[0]);
                data.append("accion", accion);
                let nombreDocumento = $("#nombreDocumento").val();
                $('#uploadFileButton').prop('disabled', true);
                $.ajax({
                    url: "uploadFile",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function (response) {
                        $("#sendRequestButton").prop("disabled", false);
                        if (response == 1) {
                            alerts.showNotification("top", "right", `El documento ${ombreDocumento} se ha cargado con éxito.`, "success");
                            $("#addDeleteFileModal").modal("hide");
                        }
                        else if (response == 2) 
                            alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                        else if (response == 3) 
                            alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extención .xlsx", "warning");
                        else
                            alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                    }, error: function () {
                        $("#sendRequestButton").prop("disabled", false);
                        alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    }
                });
            }
        }
    } else { // VA A ELIMINAR
        console.log("va a eliminar");
    }
});

function getExtensionPorTipoDocumento(tipoDocumento) {
    let extensiones = '';
    if (tipoDocumento == 7) //  CORRIDA
        extensiones = ".xlsx";
    else if (tipoDocumento == 8 || tipoDocumento == 30) //  CONTRATO Ó CONTRATO FIRMADO
        extensiones = ".pdf";
    else //  EL RESTO DE LOS DOCUMENTOS
      extensiones = ".jpg, .jpeg, .png, .pdf";
    return extensiones;
}