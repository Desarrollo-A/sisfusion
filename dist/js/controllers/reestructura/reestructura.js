var datosCatalogo = [];
var tabla_valores_catalogos = '';
$(document).ready(function(){
    $("#tabla_clientes").addClass('hide');
    $("#tabla_clientes_liberar").addClass('hide');
    $("#spiner-loader").removeClass('hide');
    $.post(`${general_base_url}Reestructura/lista_proyecto`, function(data) {
        for (var i = 0; i < data.length; i++) {
            $("#proyecto").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion'].toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $("#spiner-loader").addClass('hide');
    }, 'json');

    $.post(`${general_base_url}Reestructura/lista_proyecto`, { bandera: 1, }, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#proyectoLiberado").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion'].toUpperCase()));
        }
        $("#proyectoLiberado").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');

    $.post(`${general_base_url}General/getOpcionesPorCatalogo/100`, function(data) {
        datosCatalogo = data;
        for (var i = 0; i < data.length; i++) {
            var id = data[i]['id_opcion'];
        }
        $('.indexCo').val($(this).attr(id));
        $('#spiner-loader').addClass('hide');
    }, 'json');
});

$('#proyecto').change(function () {
    let index_proyecto = $(this).val();
    $("#spiner-loader").removeClass('hide');
    $("#tabla_clientes").removeClass('hide');
    fillTableCartera(index_proyecto);
});

let titulos_intxt = [];
$('#tabla_clientes thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tabla_clientes').DataTable().column(i).search() !== this.value)
            $('#tabla_clientes').DataTable().column(i).search(this.value).draw();
    });
});

$(document).on('click', '.liberarLote', function () {
    $('#idLoteenvARevCE').val($(this).attr('data-idLote'));
    $('#nombreLoteAv').val($(this).attr('data-nombreLote'));
    $('#precioAv').val($(this).attr('data-precio'));
    $('#idCliente').val($(this).attr('data-idCliente'));
    $('#liberarReestructura').modal();
});

$(document).on('click', '.validarReestructura', function () {
    document.getElementById("idLoteCatalogo").value = "";
    document.getElementById("comentario2").value = "";
    let idCatalogo = $(this).attr('data-idCatalogo');
    $("#grabado").empty();
    for (var i = 0; i < datosCatalogo.length; i++) {
        $("#grabado").append($('<option>').val(datosCatalogo[i]['id_opcion']).text(datosCatalogo[i]['nombre'].toUpperCase()));
    }
    $("#grabado").selectpicker('refresh');
    $("#grabado").selectpicker();
    $("#grabado").val(idCatalogo);
    $("select[name=grabado]").change();
    $('#idLoteCatalogo').val($(this).attr('data-idLote'));
    $('#aceptarReestructura').modal();
});
$(document).on('click', '.guardarValidacion', function () {
    var idLoteCa = $('#idLoteCatalogo').val();
    var opcionValidacion = $('#grabado').val();
    var comentarioValidacion = $('#comentario2').val();
    $("#spiner-loader").removeClass('hide');
    if (comentarioValidacion == '')
        comentarioValidacion = "SIN COMENTARIO";
    if (opcionValidacion == '') {
        $("#spiner-loader").addClass('hide');
        alerts.showNotification("top", "right", "Selecciona una opción", "warning");
        return;
    }
    var datos = new FormData();
    datos.append("idLote", idLoteCa);
    datos.append("opcionReestructura", opcionValidacion);
    datos.append("comentario", comentarioValidacion);
    $.ajax({
        method: 'POST',
        url: `${general_base_url}Reestructura/validarLote`,
        data: datos,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == 1) {
                $('#tabla_clientes').DataTable().ajax.reload(null, false);
                $('#aceptarReestructura').modal('hide');
                alerts.showNotification("top", "right", "Información actualizada.", "success");
                $('#idLoteCatalogo').val('');
                $('#grabado').val('');
                $('#comentario2').val('');
                $("#spiner-loader").addClass('hide');
            }
        },
        error: function () {
            $('#aceptarReestructura').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

$(document).on('click', '.historial', function () {
    id_prospecto = $(this).attr("data-idLote");
    $('#historialLine').html('');
    $("#spiner-loader").removeClass('hide');
    $.getJSON(`getHistorial/${id_prospecto}`).done(function (data) {
        array = data.sort(function (a, b) {
            return a.id_auditoria - b.id_auditoria;
        });
        if (array.length == 0) {
            $("#spiner-loader").addClass('hide');
            $('#historialLine').append("SIN DATOS POR MOSTRAR");
        } else {
            $.each(array, function (i, v) {
                $("#spiner-loader").addClass('hide');
                fillChangelog(v);
            });
        }
    });
    $('#modal_historial').modal();
});
function fillChangelog(v) {
    $("#historialLine").append(`<li>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 colmd-6 col-lg-6">
                    <a><b> ${v.creado_por.toUpperCase()} </b></a><br>
                </div>
                <div class="float-end text-right">
                    <a> ${v.fecha_creacion}</a>
                </div>
                <div class="col-md-12">
                    <p class="m-0"><small>Valor anterior: </small><b> ${(v.nombre) ? v.nombre.toUpperCase() : '-'}</b></p>
                    <p class="m-0"><small>Valor nuevo: </small><b> ${v.nombreNuevo.toUpperCase()}</b></p>
                </div>
            </div>
        </div>
    </li>`);
}

$(document).on('click', '#saveLiberacion', function () {
    $("#spiner-loader").removeClass('hide');
    var idLote = $("#idLoteenvARevCE").val();
    var nombreLot = $("#nombreLoteAv").val();
    var precio = $("#precioAv").val();
    var idCliente = $("#idCliente").val();
    var datos = new FormData();
    datos.append("idLote", idLote);
    datos.append("nombreLote", nombreLot);
    datos.append("precio", precio);
    datos.append("tipoLiberacion", 9);
    datos.append("idCliente", idCliente);
    $.ajax({
        method: 'POST',
        url: `${general_base_url}Reestructura/aplicarLiberacion`,
        data: datos,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == 1) {
                $('#tabla_clientes').DataTable().ajax.reload(null, false);
                $('#liberarReestructura').modal('hide');
                alerts.showNotification("top", "right", "Lote liberado.", "success");
                $("#spiner-loader").addClass('hide');
                $('#idLoteenvARevCE').val('');
                $('#nombreLoteAv').val('');
                $('#precioAv').val('');
            }
        },
        error: function () {
            $('#liberarReestructura').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function catalogoAcciones(opcionAccion, data, successMessage, modalId) {
    $("#spiner-loader").removeClass('hide');
    data.append("actionCode", opcionAccion); 
    $.ajax({
        method: 'POST',
        url: `${general_base_url}Reestructura/catalogoAcciones`,
        data:data,
        processData: false,
        contentType: false,
        success:function(response) {
            if (response == 1) {
                $('#tableCatalogo').DataTable().ajax.reload(null, false);
                $("#spiner-loader").addClass('hide');
                $(modalId).modal('hide');
                alerts.showNotification("top", "right", successMessage, "success");
                if (opcionAccion === 1 || opcionAccion === 1) {
                    $('#inputCatalogo, #editarCatalogo').val('');
                    $('#id_opcion, #idOpcionEdit').val('');
                }
            }
        }, 
        error: function () {
            $(modalId).modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

$(document).on("submit", "#addNewDesc", function(e){
    e.preventDefault();
    let data = new FormData($(this)[0]);
    catalogoAcciones(1, data, "Opción insertada correctamente.", '#catalogoNuevo');
    return false;
});

$(document).on('click', '.editarOpcion', function(){
    let estatus = $(this).attr('data-estatusOpcion');
    $('#idOpcion').val($(this).attr('data-idOpcion'));
    $('#estatusOpcion').val($(this).attr('data-estatusOpcion'));
    let titulo = estatus == 1 ? '¿Desea activar esta opción?' : '¿Desea desactivar esta opción?';
    $('#edtTitle').text(titulo);
    $('#modalEditar').modal();
});

$(document).on('click', '#editarOpcion', function(){
    var idOpcion = $("#idOpcion").val();
    var estatusOpcion = $("#estatusOpcion").val();
    var data = new FormData();
    data.append("idOpcion", idOpcion);
    data.append("estatusOpcion", estatusOpcion);
    let mensaje = estatusOpcion == 0 ? "Opción activada." : 'Opción desactivada.';
    catalogoAcciones(2, data, mensaje, '#modalEditar');
});



function fillTableCartera(index_proyecto) {
    tabla_valores_cliente = $("#tabla_clientes").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                text: '<i class="fas fa-tags"></i> CATÁLOGO',
                action: function () {
                    $("#catalogoReestructura").modal();
                    fillTableCatalogo(100);
                },
                attr: {
                    class: 'btn btn-azure',
                    style: 'position: relative; float: right',
                },
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Reestructuración',
                title: 'Reestructuración',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxt[columnIdx] + ' ';
                        }
                    }
                },
            }
        ],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [
            { data: "nombreResidencial" },
            { data: "nombreCondominio" },
            { data: "nombreLote" },
            { data: "idLote" },
            { data: "superficie" },
            { data: "precio" },
            { data: "nombreCliente" },
            { data: "estatus" },
            {
                data: function (d) {
                    return `<span class="label" style="background:#${d.background_sl}18; color:#${d.color};">${d.estatusContratacion}</span>`;
                }
            },
            { data: "comentarioReubicacion" },
            {
                data: function (d) {
                    if (d.idStatusLote == 15 || d.idStatusLote == 16) { // MJ: ESTÁ LIBERADO
                        return `<div class="d-flex justify-center"><button class="btn-data btn-violetDeep validarReestructura" data-toggle="tooltip" data-idCatalogo="${d.idCatalogo}" data-placement="top" title= "VALIDAR REESTRUCTURACIÓN" data-idLote="${d.idLote}"><i class="fas fa-edit"></i></button>
                        <button class="btn-data btn-blueMaderas historial" data-toggle="tooltip" data-placement="top" data-idLote="${d.idLote}" title="HISTORIAL"><i class="fas fa-info"></i></button></div>`;
                    } else {
                        return `<div class="d-flex justify-center"><button class="btn-data btn-green liberarLote" data-toggle="tooltip" data-placement="top" title= "LIBERAR LOTE" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}" data-precio="${d.precio}" data-idCliente="${d.idCliente}"><i class="fas fa-thumbs-up"></i></button>
                        <button class="btn-data btn-violetDeep validarReestructura" data-toggle="tooltip" data-placement="top" data-idCatalogo="${d.idCatalogo}" title= "VALIDAR REESTRUCTURACIÓN" data-idLote="${d.idLote}"><i class="fas fa-edit"></i></button>
                        <button class="btn-data btn-blueMaderas historial" data-toggle="tooltip" data-placement="top" data-idLote="${d.idLote}" title="HISTORIAL"><i class="fas fa-info"></i></button></div>`;
                    }
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Reestructura/getLotesRegistros`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: { index_proyecto: index_proyecto }
        },
        initComplete: function () {
            $("#spiner-loader").addClass('hide');
        },
        order: [
            [1, 'asc']
        ],
    });
    $('#tabla_clientes').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}
$('#tableCatalogo thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + ' " placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if($('#tableCatalogo').DataTable().column(i).search() !== this.value)
            $('#tableCatalogo').DataTable().column(i).search(this.value).draw();
    });
});

function fillTableCatalogo(id_catalogo) {
    tabla_valores_catalogos = $("#tableCatalogo").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            text: '<i class="fas fa-check"></i> Agregar',
            action: function () {
                $("#catalogoNuevo").modal();
            },
            attr: {
                class: 'btn btn-azure',
                style: 'position: relative; float: left: margin-bottom: 5px;',
            },
        }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 5,
        bLengthChange: false,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [
            { data: "nombre" },
            { data: 'statusOpcion'},
            {
                data: function (d) {
                    if(d.estatus == 0){
                        return `<div class="d-flex justify-center">
                        <button class="btn-data btn-green editarOpcion" id="activarOpcion" name="activarOpcion" data-toggle="tooltip" data-placement="top" title="ACTIVAR OPCIÓN" data-idOpcion="${d.id_opcion}" data-estatusOpcion="1"><i class="fas fa-check"></i></button>
                        </div>`;
                    }
                    return `<div class="d-flex justify-center">
                    <button class="btn-data btn-warning editarOpcion" id="desactivarOpcion" name="desactivarOpcion" data-toggle="tooltip" data-placement="top" title= "DESACTIVAR OPCIÓN" data-idOpcion="${d.id_opcion}" data-estatusOpcion="0"><i class="fas fa-trash"></i></button>
                    </div>`;
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Reestructura/getOpcionesCatalogo`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: { id_catalogo: id_catalogo },
        },
        initComplete: function () {
            $("#spiner-loader").addClass('hide');
        },
        order: [
            [0, 'asc']
        ],
    });
    $('#tabla_clientes').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

let titulos_intxtLiberado = [];
$('#tabla_clientes_liberar thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxtLiberado.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tabla_clientes_liberar').DataTable().column(i).search() !== this.value)
            $('#tabla_clientes_liberar').DataTable().column(i).search(this.value).draw();
    });
});

$(document).on('change', '#proyectoLiberado', function() {
    let index_proyecto = $(this).val();
    $("#spiner-loader").removeClass('hide');
    $("#tabla_clientes_liberar").removeClass('hide');
    fillTableClienteLiberacion(index_proyecto);
});

$(document).on('click', '.accionModal', function() {
    let idLote = $(this).attr('data-idLote');
    let bandera = $(this).attr('data-bandera');
    let idCliente = $(this).attr('data-idCliente');
    let preproceso = $(this).attr('data-preproceso');
    let titulo = ''
    if(bandera == 0) {
        if(preproceso > 0) {
            titulo = '¿Estás seguro de BLOQUEAR y DESHACER el pre-proceso del lote?';
        }
        else {
            titulo = '¿Estás seguro de BLOQUEAR el lote?';
        }
    }
    else {
        titulo = '¿Estás seguro de LIBERAR el lote para reestructura?';
    }
    $('#idLoteAccion').val(idLote);
    $('#banderaAccion').val(bandera);
    $('#clienteAccion').val(idCliente);
    $('#preprocesoAccion').val(preproceso);
    $('#tituloAccion').text(titulo);
    $("#accionModal").modal();
});

$(document).on('click', '#guardarAccion', function() {
    document.getElementById('guardarAccion').disabled = true;
    let idLote = $('#idLoteAccion').val();
    let bandera = $('#banderaAccion').val();
    let idCliente =  $('#clienteAccion').val();
    let preproceso = $('#preprocesoAccion').val();
    $("#spiner-loader").removeClass('hide');
    let data = { bandera, idLoteBandera: idLote };
    if (bandera == 0) {
        data.idCliente = idCliente;
        data.preproceso = preproceso;
    }
    $.ajax({
        url: `${general_base_url}Reestructura/cambiarBandera`,
        type: 'POST',
        dataType: "json",
        data: data,
        success: function (response) {
            if(response.result == true) {
                if(bandera == 0 && (response.flagRe > 0 || response.flagFusion > 0)) {
                    regresarLote(response.flagRe, response.flagFusion, idCliente, preproceso, idLote, response.idLotePvOrigen);
                }
                else {
                    let successMessage = bandera == 1 ? "Lote liberado satisfactoriamente." : "Lote bloqueado satisfactoriamente.";
                    alerts.showNotification("top", "right", successMessage, "success");
                    $('#tabla_clientes_liberar').DataTable().ajax.reload(null, false);
                    $('#accionModal').modal('toggle');
                    document.getElementById('guardarAccion').disabled = false;
                }
            } 
            $("#spiner-loader").addClass('hide');
        },
        error: function (response) {
            let errorMessage = bandera == 1 ? response.message : response.message;
            alerts.showNotification("top", "right", errorMessage, "danger");
            $("#spiner-loader").addClass('hide');
            document.getElementById('guardarAccion').disabled = true;
        }
    });
});

function regresarLote(flagRe, flagFusion, idCliente, preproceso, idLote, idLotePvOrigen){ // proceso para regresar el preproceso del lote a bloquear
    var url = '';
    var lote = 0;

    if(flagRe > 0){
        url = 'regresoPreproceso';
        lote = idLote;
    }
    else if(flagFusion > 0){
        url = 'regresoPreprocesoFusion';
        lote = idLotePvOrigen;
    }
    $.ajax({
        url: url,
        type: 'POST',
        dataType: "json",
        data: {
                preproceso: 0,
                juridico: 2,
                contraloria: 1,
                idLote: lote,
                idCliente: idCliente,
                comentario: 'Regreso de pre-proceso por bloqueo del lote'
            },
        success: function (response) {
            if(response.result){
                if(flagFusion > 0){
                    deshacerFusion(idLotePvOrigen);
                }
                else if(flagRe > 0){
                    $("#spiner-loader").addClass('hide');
                    alerts.showNotification("top", "right", response.message, "success");
                }
            }
            else
                alerts.showNotification("top", "right", response.message, "danger");

            $('#tabla_clientes_liberar').DataTable().ajax.reload(null, false);
            $('#accionModal').modal('toggle');
            document.getElementById('guardarAccion').disabled = false;
        },
        error: function(){
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Error al actualizar el lote .", "danger");
            document.getElementById('guardarAccion').disabled = false;
        }
    });
}

function deshacerFusion(idLotePvOrigen){
    $.ajax({
        url: `${general_base_url}Reestructura/deshacerFusion`,
        type: 'POST',
        dataType: "json",
        data: {
            idLotePvOrigen 
        },
        success: function (response) {
            if(response.result){
                alerts.showNotification("top", "right", response.message, "success");
                $('#tabla_clientes_liberar').DataTable().ajax.reload(null, false);
            }
            else
                alerts.showNotification("top", "right", response.message, "danger");

            document.getElementById('guardarAccion').disabled = false;
            $("#spiner-loader").addClass('hide');
        },
        error: function(){
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Error al actualizar el lote .", "danger");
            document.getElementById('guardarAccion').disabled = false;
        }
    });
}
function fillTableClienteLiberacion(index_proyecto) {
    tabla_valores_cliente = $("#tabla_clientes_liberar").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Reestructuración',
                title: 'Reestructuración',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulos_intxtLiberado[columnIdx] + ' ';
                        }
                    }
                },
            }],
        pagingType: "full_numbers",
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        processing: true,
        pageLength: 10,
        bAutoWidth: true,
        bLengthChange: false,
        scrollX: true,
        bInfo: true,
        searching: true,
        ordering: false,
        fixedColumns: true,
        destroy: true,
        columns: [
            { data: "nombreResidencial" },
            { data: "nombreCondominio" },
            { data: "nombreLote" },
            { data: "idLote" },
            { data: "superficie" },
            { data: "precio" },
            { data: "nombreCliente" },
            {
                data: function (d) {
                    return `<span class="label lbl-violetBoots">${d.estatusLiberacion}</span>`;
                }
            },
            {
                data: function (d) {
                    if (d.liberaBandera == 0)
                        return `<div class="d-flex justify-center">
                                    <button class="btn-data btn-blueMaderas accionModal" data-toggle="tooltip" data-placement="top" title= "Liberar lote" data-idLote="${d.idLote}" data-bandera="1" data-toggle="modal" data-target="#accionModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>`;
                    else if(d.estatus_preproceso < 7)
                        return `<div class="d-flex justify-center">
                                    <button class="btn-data btn-warning accionModal" data-toggle="tooltip" data-placement="top" title= "Regresar y bloquear lote" data-idLote="${d.idLote}" data-bandera="0" data-idCliente="${d.idCliente}" data-preproceso="${d.estatus_preproceso}" data-toggle="modal" data-target="#accionModal">
                                        <i class="fas fa-ban"></i>
                                    </button>                
                                </div>`;
                }
            }
        ],
        columnDefs: [{
            defaultContent: "",
            targets: "_all",
            searchable: true,
            orderable: false
        }],
        ajax: {
            url: `${general_base_url}Reestructura/getregistrosLotes`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: { index_proyecto: index_proyecto }
        },
        initComplete: function () {
            $("#spiner-loader").addClass('hide');
        },
        order: [
            [1, 'asc']
        ],
    });

    $('#tabla_clientes').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}