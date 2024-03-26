$(document).ready(function () {
    $('#spiner-loader').removeClass('hide');
    $.post(`${general_base_url}Contratacion/lista_proyecto`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#proyecto").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion']));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
    $.post(`${general_base_url}General/getOpcionesPorCatalogo/122`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#tipoTramite").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
        }
        $("#tipoTramite").selectpicker('refresh');
    }, 'json');
});

$('#proyecto').change(function () {
    let index_proyecto = $(this).val();
    $("#condominio").html("");
    $("#table_cambio_nombre_cliente").removeClass('hide');
    $('#spiner-loader').removeClass('hide');
    $.post(`${general_base_url}Contratacion/lista_condominio/${index_proyecto}`, function (data) {
        var len = data.length;
        for (var i = 0; i < len; i++) {
            var id = data[i]['idCondominio'];
            var name = data[i]['nombre'];
            $("#condominio").append($('<option>').val(id).text(name.toUpperCase()));
        }
        $("#condominio").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');
    fillTable(index_proyecto, 0);
});

$('#condominio').change(function () {
    // $('#spiner-loader').removeClass('hide');
    let index_proyecto = $("#proyecto").val();
    let index_condominio = $(this).val();
    fillTable(index_proyecto, index_condominio);
    // $('#spiner-loader').addClass('hide');
});

let titulos = [];
$('#table_cambio_nombre_cliente thead tr:eq(0) th').each(function (i) {
    title = $(this).text();
    titulos.push(title);
    $(this).html(`<input class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#table_cambio_nombre_cliente').DataTable().column(i).search() !== this.value)
            $('#table_cambio_nombre_cliente').DataTable().column(i).search(this.value).draw();
    });
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
});

function fillTable(index_proyecto, index_condominio) {
    tabla_valores_cliente = $("#table_cambio_nombre_cliente").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'Listado de lotes',
            title: 'Listado de lotes',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulos[columnIdx] + ' ';
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
            { data: 'nombreResidencial' },
            { data: 'nombreCondominio' },
            { data: 'nombreLote' },
            { data: 'idLote' },
            { data: 'nombreCliente' },
            { data: 'fechaApartado' },
            { data: 'nombreAsesor' },
            { data: 'nombreCoordinador' },
            { data: 'nombreGerente' },
            { data: 'nombreSubdirector' },
            { data: 'nombreRegional' },
            { data: 'nombreRegional2' },
            {
                data: function (d) {
                    return `<span class="label lbl-azure">${d.tipoVenta}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label lbl-yellow">${d.ubicacion}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label ${d.estatusCambioNombre == 1 ? 'lbl-gray' : 'lbl-green'}">${d.estatusProceso}</span>`;
                },
            },
            {
                data: function (d) {
                    return `<span class="label lbl-violetBoots">${d.tipoTramite}</span>`;
                },
            },
            {
                data: function (d) {
                    let comentario = (d.comentario=='' || d.comentario==null) ? '' : d.comentario;
                    return `${comentario}`;
                },
            },
            {
                data: function (d) {
                    let btns = '';
                    let btnBase = `<button class="btn-data btn-blueMaderas iniciarTramite" data-toggle="tooltip" 
                    data-placement="top" title= "Iniciar trámite para cambio de nombre" data-idLote="${d.idLote}" 
                    data-idCliente="${d.idCliente}" data-tipoTransaccion="${d.estatusCambioNombre}" 
                    data-nombreCteNuevo="${d.nombreCteNuevo}" data-apCteNuevo="${d.apCteNuevo}" 
                    data-amCteNuevo="${d.amCteNuevo}" data-idTipoTramite="${d.idTipoTramite}" 
                    data-idRegistro="${d.id_registro}"><i class="fas fa-user-edit"></i></button>`;
                    if (d.estatusCambioNombre == 1)
                        btns = btnBase;
                    else if (d.estatusCambioNombre == 2 || d.estatusCambioNombre == 5)
                        btns = btnBase + `<button class="btn-data btn-green btn-avanzar" data-toggle="tooltip" data-placement="top" 
                        title= "Enviar" data-idLote="${d.idLote}" data-idCliente="${d.idCliente}" 
                        data-tipoTransaccion="${d.estatusCambioNombre}" 
                        data-precioFinal="${d.precioFinalLote}" ><i class="fas fa-thumbs-up"></i></button>`;
                    return `<div class="d-flex justify-center">${btns}</div>`;
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
            url: `${general_base_url}Postventa/getListaClientes`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {
                "index_proyecto": index_proyecto,
                "index_condominio": index_condominio
            }
        },
        order: [
            [1, 'asc']
        ],
    });
    $('#table_cambio_nombre_cliente').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

$(document).on('click', '.iniciarTramite', function () {
    $('#idLote').val($(this).attr('data-idLote'));
    $('#idCliente').val($(this).attr('data-idCliente'));
    $('#tipoTransaccion').val($(this).attr('data-tipoTransaccion'));
    $('#idRegistro').val($(this).attr('data-idRegistro'));
    if ($(this).attr('data-tipoTransaccion') == 1) {
        $("#tipoTramite").val('').selectpicker('refresh');
        $('#txtNombre').val('');
        $('#txtApellidop').val('');
        $('#txtApellidom').val('');
    } 
    else if ($(this).attr('data-tipoTransaccion') == 2) {
        $("#tipoTramite").val($(this).attr('data-idTipoTramite')).selectpicker('refresh');
        $('#txtNombre').val($(this).attr('data-nombreCteNuevo'));
        $('#txtApellidop').val($(this).attr('data-apCteNuevo'));
        $('#txtApellidom').val($(this).attr('data-amCteNuevo'));
    }
    $('#inicioTramite').modal();
});

$(document).on("submit", "#formCambioNombre", function (e) {
    e.preventDefault();
    let data = new FormData($(this)[0]);
    //$('#spiner-loader').removeClass('hide');
    $.ajax({
        url: `${general_base_url}Postventa/setInformacionCliente`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (data) {
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data.message, "success");
            //$('#spiner-loader').addClass('hide');
            $('#table_cambio_nombre_cliente').DataTable().ajax.reload();
            $('#inicioTramite').modal('hide');
        },
        error: function (data) {
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
        }
    });
});

$(document).on('click', '.btn-avanzar', function () {
    $('#idLoteA').val($(this).attr('data-idLote'));
    $('#idClienteA').val($(this).attr('data-idCliente'));
    $('#tipoTransaccionA').val($(this).attr('data-tipoTransaccion'));
    $('#comentarioAvanzar').val('');
    $('#avance').modal();
})

$(document).on("submit", "#formAvanzarEstatus", function(e) {
    $('#spiner-loader').removeClass('hide');
    e.preventDefault();
    let data = new FormData($(this)[0]);
    $.ajax({
        url : `${general_base_url}Postventa/setAvance`,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            data = JSON.parse(data);
            alerts.showNotification("top", "right", data.message, "success");
            $('#table_cambio_nombre_cliente').DataTable().ajax.reload();
            $('#spiner-loader').addClass('hide');
            $('#avance').modal('hide');
        },
        error: function( data ){
            alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
            $('#avance').modal('hide');
        }
    });
});
