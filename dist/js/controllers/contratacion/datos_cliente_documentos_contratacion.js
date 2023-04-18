var rolesPermitidos = [7, 9, 42, 3, 2, 6, 5, 15, 13, 17, 32, 70]
var movimientosPermitidos = [36, 6, 23, 76, 83, 95, 97, 35, 22, 62, 75, 94, 106, 37, 7, 64, 66, 77, 41, 31, 85, 20, 63, 73, 82, 92, 96]
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
    var valorSeleccionado = $(this).val();
    $("#idCondominio").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}registroCliente/getCondominios/${valorSeleccionado}`,
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['idCondominio'];
                var name = response[i]['nombre'];
                $("#idCondominio").append($('<option>').val(id).text(name));
            }
            $("#idCondominio").selectpicker('refresh');
        }
    });
});

$('#idCondominio').change(function () {
    var residencial = $('#idResidencial').val();
    var valorSeleccionado = $(this).val();
    $("#idLote").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}registroCliente/getLotesAsesor/${valorSeleccionado}/${residencial}`,
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var datos = response[i]['idLote'] + ',' + response[i]['venta_compartida'];
                var name = response[i]['nombreLote'];
                $("#idLote").append($('<option>').val(datos).text(name));
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
                $('#tableDoct').DataTable()
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    function getAtributos(type) {
        if (type == 1) { // NO HAY DOCUMENTO CARGADO
            buttonTitle = 'Documento no disponible';
            buttonClassStatus = 'disabled';
            buttonClassType = 'btn-default';
            buttonClassAction = '';
            buttonIcon = 'fas fa-file';
            buttonTypeTransaction = '';
        } else if (type == 2) { // LA RAMA TIENE UN DOCUMENTO CARGADO
            buttonTitle = 'Ver documento';
            buttonClassStatus = '';
            buttonClassType = 'btn-green';
            buttonClassAction = 'verDocumento';
            buttonIcon = 'fas fa-eye';
            buttonTypeTransaction = '1';
        } else if (type == 3) { // NO HAY DOCUMENTO CARGADO, PERO TIENE PERMISO PARA SUBIRLO
            buttonTitle = 'Subir documento';
            buttonClassStatus = '';
            buttonClassType = 'btn-green';
            buttonClassAction = 'subirDocumento';
            buttonIcon = 'fas fa-upload';
            buttonTypeTransaction = '2';
        }  else if (type == 4) { // LA RAMA TIENE UN DOCUMENTO CARGADO, TIENE PERMISO PARA ELIMINAR EL ARCHIVO
            buttonTitle = 'Eliminar documento';
            buttonClassStatus = '';
            buttonClassType = 'btn-danger';
            buttonClassAction = 'eliminarDocumento';
            buttonIcon = 'fas fa-trash';
            buttonTypeTransaction = '3';
        }
        return [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonIcon, buttonTypeTransaction];
    }

    $('#tableDoct').DataTable({
        destroy: true,
        ajax: {
            url: `${general_base_url}registroCliente/expedientesWS/${valorSeleccionado}`,
            dataSrc: ""
        },
        dom: 'Brt' + "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
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
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
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
            { data: 'movimiento' },
            { data: 'modificado' },
            {
                data: null,
                render: function (data) {
                    buttonMain = '';
                    buttonDelete = '';
                    buttonTitle = '';
                    buttonClassStatus = '';
                    buttonClassType = ''
                    buttonClassAction = '';
                    buttonIcon = '';
                    buttonTypeTransaction = '';
                    if (data.tipo_doc == 8) { // CONTRATO
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidos.includes(36, 6, 23, 76, 83, 95, 97) && id_rol_general == 15) // ESTÁ EN ESTATUS 7 Y ES JURÍDICO EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidos.includes(36, 6, 23, 76, 83, 95, 97) && id_rol_general == 15) { // ESTÁ EN ESTATUS 7 Y ES JURÍDICO EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    } else if (data.tipo_doc == 7) { // CORRIDA
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidos.includes(35, 22, 62, 75, 94, 106) && (id_rol_general == 13 || id_rol_general == 32 || id_rol_general == 17 || id_rol_general == 70)) // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidos.includes(35, 22, 62, 75, 94, 106) && (id_rol_general == 13 || id_rol_general == 32 || id_rol_general == 17 || id_rol_general == 70)) { // ESTÁ EN ESTATUS 6 Y ES CONTRALORÍA EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    } else if (data.tipo_doc == 29) { // CARTA DOMICILIO
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidos.includes(37, 7, 64, 66, 77, 41) && (id_rol_general == 6 || id_rol_general == 5)) // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidos.includes(37, 7, 64, 66, 77, 41) && (id_rol_general == 6 || id_rol_general == 5)) { // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 'ds_new' && data.expediente == "Depósito de seriedad") { // EXISTE EL DEPÓSITO DE SERIEDAD (VERSIÓN NUVEA)
                        var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 'ds_new' && data.expediente == "Depósito de seriedad versión anterior") { // EXISTE EL DEPÓSITO DE SERIEDAD (VERSIÓN VIEJITA)
                        var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 66) { // EXISTE LA RAMA CON LA EVIDENCIA DE MKTD (OLD)
                        var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 'autorizaciones') { // EXISTE LA RAMA DE AUTORIZACIONES
                        var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    } else if(data.tipo_doc == 'prospecto') { // EXISTE LA RAMA DEL PROSPECTO
                        var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    } else { // ES EL RESTO DEL EXPEDIENTE (HISTORIAL DOCUMENTOS)
                        if (data.expediente == null || data.expediente == "") { // NO HAY DOCUMENTO CARGADO
                            if(movimientosPermitidos.includes(31, 85, 20, 63, 73, 82, 92, 96) && (id_rol_general == 7 || id_rol_general == 9 || id_rol_general == 3 || id_rol_general == 2)) // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR ENABLED EL BOTÓN PARA CARGAR EL ARCHIVO
                                var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(3);
                            else // ESTÁ EN CUALQUIER OTRO ESTATUS O NO ES JURÍDICO QUIEN CONSULTA, SE VA A MOSTRAR EL BOTÓN DISABLED
                                var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(1);
                        }
                        else { // LA RAMA TIENE UN DOCUMENTO CARGADO
                            var [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(2); // SE VE A MONSTRAR ENABLED EL BOTÓN PARA VER EL ARCHIVO
                            if(movimientosPermitidos.includes(31, 85, 20, 63, 73, 82, 92, 96) && (id_rol_general == 7 || id_rol_general == 9 || id_rol_general == 3 || id_rol_general == 2)) { // ESTÁ EN ESTATUS 8 Y ES ASISTENTES GERENTES EL QUE CONSULTA, SE VEA A MONSTRAR EL BOTÓN PARA ELIMINAR EL ARCHIVO
                                let [buttonTitle, buttonClassStatus, buttonClassType, buttonClassAction, buttonTypeTransaction] = getAtributos(4);
                                buttonDelete = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                            }
                        }
                        buttonMain = `<button class="${buttonClassType} ${buttonClassStatus} ${buttonClassAction}" title="${buttonTitle}" data-expediente="${data.expediente}" data-transaction="${buttonTypeTransaction} data-tipo-documento="${data.tipo_doc}"><i class="${buttonIcon}"></i></button>`;
                    }
                   return `<div class="d-flex justify-center">${buttonMain} ${buttonDelete}</div>`;
                }
            },
            {
                data: null,
                render: function (data) {
                    return myFunctions.validateEmptyFieldDocs(data.primerNom) + ' ' + myFunctions.validateEmptyFieldDocs(data.apellidoPa) + ' ' + myFunctions.validateEmptyFieldDocs(data.apellidoMa);
                },
            },
            { data: 'ubic' },
        ]
    });
});

$('.btn-documentosGenerales').on('click', function () {
    $('#modalFiles').modal('show');
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

$(document).on('click', '.pdfLink2', function () {
    var $itself = $(this);
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${general_base_url}asesor/deposito_seriedad/${$itself.attr('data-idc')}/1/"></iframe></div>`,
        player: "html",
        title: `Visualizando archivo: ${$itself.attr('data-expediente')}`,
        width: 1600,
        height: 900
    });
});

$(document).on('click', '.pdfLink22', function () {
    var $itself = $(this);
    Shadowbox.open({
        content: '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${general_base_url}asesor/deposito_seriedad_ds/' + $itself.attr('data-idc') + '/1/"></iframe></div>',
        player: "html",
        title: `Visualizandoarchivo: ${$itself.attr('data-expediente')}`,
        width: 1600,
        height: 900
    });
});

$(document).on('click', '.pdfLink3', function () {
    var $itself = $(this);
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${general_base_url}static/documentos/cliente/contrato/${$itself.attr('data-expediente')}"></iframe></div>`,
        player: "html",
        title: `Visualizandoarchivo: ${$itself.attr('data-expediente')}`,
        width: 985,
        height: 660
    });
});

$(document).on('click', '.verProspectos', function () {
    var $itself = $(this);
    let functionName = '';
    if ($itself.attr('data-lp') == 6) // IS MKTD
        functionName = 'printProspectInfoMktd';
    else
        functionName = 'printProspectInfo';
    Shadowbox.open({
        content: `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${general_base_url}clientes/${functionName}/${$itself.attr('data-id-prospeccion')}"></iframe></div>`,
        player: "html",
        title: `VisualizandoProspecto: ${$itself.attr('data-nombreProspecto')}`,
        width: 985,
        height: 660

    });
});


/*evidencia MKTD PDF*/
$(document).on('click', '.verEVMKTD', function () {
    var $itself = $(this);
    var cntShow = '';

    if (checaTipo($itself.attr('data-expediente')) == "pdf")
        cntShow = `<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="${general_base_url}static/documentos/evidencia_mktd/${$itself.attr('data-expediente')}" allowfullscreen></iframe></div>`;
    else
        cntShow = `<div><img src="${general_base_url}static/documentos/evidencia_mktd/${$itself.attr('data-expediente')}" class="img-responsive"></div>`;
    Shadowbox.open({
        content: cntShow,
        player: "html",
        title: `VisualizandoEvidencia MKTD: ${$itself.attr('data-nombreCliente')}`,
        width: 985,
        height: 660

    });
});

function checaTipo(archivo) {
    archivo.split('.').pop();
    return validaFile;
}

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

if (rolesPermitidos.includes(7, 9, 3, 2, 6, 5)) {
    var miArrayAddFile = new Array(8);
    var miArrayDeleteFile = new Array(1);

    $(document).on("click", ".update", function (e) {
        e.preventDefault();
        $('#txtexp').val('');
        var descdoc = $(this).data("descdoc");
        var idCliente = $(this).attr("data-idCliente");
        var nombreResidencial = $(this).attr("data-nombreResidencial");
        var nombreCondominio = $(this).attr("data-nombreCondominio");
        var idCondominio = $(this).attr("data-idCondominio");
        var nombreLote = $(this).attr("data-nombreLote");
        var idLote = $(this).attr("data-idLote");
        var tipodoc = $(this).attr("data-tipodoc");
        var iddoc = $(this).attr("data-iddoc");
        miArrayAddFile[0] = idCliente;
        miArrayAddFile[1] = nombreResidencial;
        miArrayAddFile[2] = nombreCondominio;
        miArrayAddFile[3] = idCondominio;
        miArrayAddFile[4] = nombreLote;
        miArrayAddFile[5] = idLote;
        miArrayAddFile[6] = tipodoc;
        miArrayAddFile[7] = iddoc;
        $(".lote").html(descdoc);
        $('#addFile').modal('show');
    });

    $(document).on('click', '#sendFile', function (e) {
        e.preventDefault();
        var idCliente = miArrayAddFile[0];
        var nombreResidencial = miArrayAddFile[1];
        var nombreCondominio = miArrayAddFile[2];
        var idCondominio = miArrayAddFile[3];
        var nombreLote = miArrayAddFile[4];
        var idLote = miArrayAddFile[5];
        var tipodoc = miArrayAddFile[6];
        var iddoc = miArrayAddFile[7];
        var expediente = $("#expediente")[0].files[0];
        var validaFile = (expediente == undefined) ? 0 : 1;
        tipodoc = (tipodoc == 'null') ? 0 : tipodoc;
        var dataFile = new FormData();

        dataFile.append("idCliente", idCliente);
        dataFile.append("nombreResidencial", nombreResidencial);
        dataFile.append("nombreCondominio", nombreCondominio);
        dataFile.append("idCondominio", idCondominio);
        dataFile.append("nombreLote", nombreLote);
        dataFile.append("idLote", idLote);
        dataFile.append("expediente", expediente);
        dataFile.append("tipodoc", tipodoc);
        dataFile.append("idDocumento", iddoc);
        if (validaFile == 0)
            alerts.showNotification('top', 'right', 'Debes seleccionar un archivoo', 'danger');
        if (validaFile == 1) {
            $('#sendFile').prop('disabled', true);
            $.ajax({
                url: `${general_base_url}registroCliente/addFileAsesor`,
                data: dataFile,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.message == 'OK') {
                        alerts.showNotification('top', 'right', 'Expediente enviado', 'success');
                        $("#expediente").val('');
                        $('#sendFile').prop('disabled', false);
                        $('#addFile').modal('hide');
                        $('#tableDoct').DataTable().ajax.reload();
                    }
                    else if (response.message == 'OBSERVACION_CONTRATO') {
                        alerts.showNotification("top", "right", "EN PROCESO DE LIBERACIÓN. No podrás subir documentación" +
                            " hasta que el proceso de liberación haya concluido.", "danger");
                        $("#expediente").val('');
                        $('#sendFile').prop('disabled', false);
                    }
                    else if (response.message == 'ERROR') {
                        alerts.showNotification('top', 'right', 'Error al enviar expediente y/o formato no válido', 'danger');
                        $("#expediente").val('');
                        $('#sendFile').prop('disabled', false);
                    }
                }
            });
        }
    });

    $(document).ready(function () {
        $(document).on("click", ".delete", function (e) {
            e.preventDefault();
            var iddoc = $(this).data("iddoc");
            var tipodoc = $(this).data("tipodoc");
            miArrayDeleteFile[0] = iddoc;
            $(".tipoA").html(tipodoc);
            $('#cuestionDelete').modal('show');
        });
    });

    $(document).on('click', '#aceptoDelete', function (e) {
        e.preventDefault();
        var id = miArrayDeleteFile[0];
        var dataDelete = new FormData();
        dataDelete.append("idDocumento", id);

        $('#aceptoDelete').prop('disabled', true);
        $.ajax({
            url: `${general_base_url}registroCliente/deleteFile`,
            data: dataDelete,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                response = JSON.parse(response);
                if (response.message == 'OK') {
                    alerts.showNotification('top', 'right', 'Archivo eliminado', 'danger');
                    $('#aceptoDelete').prop('disabled', false);
                    $('#cuestionDelete').modal('hide');
                    $('#tableDoct').DataTable().ajax.reload();
                } else if (response.message == 'ERROR') {
                    alerts.showNotification('top', 'right', 'Error al eliminar el archivo', 'danger');
                    $('#tableDoct').DataTable().ajax.reload();
                }
            }
        });
    });
}