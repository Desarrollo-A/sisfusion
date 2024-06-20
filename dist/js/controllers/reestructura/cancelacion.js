$(document).ready(function () {
    $("#tabla_lotes").addClass('hide');
    $('#spiner-loader').removeClass('hide');
    $.post(`${general_base_url}Reestructura/lista_proyecto`, function (data) {
        const ids = data.map((row) => {
            return row.idResidencial;
        }).join(',');
        $("#proyecto").append($('<option>').val(ids).text('SELECCIONAR TODOS'));
        for (var i = 0; i < data.length; i++) {
            $("#proyecto").append($('<option>').val(data[i]['idResidencial']).text(data[i]['descripcion'].toUpperCase()));
        }
        $("#proyecto").selectpicker('refresh');
        $('#spiner-loader').addClass('hide');
    }, 'json');

     //OBTIENE LOS TIPOS DE CANCELACIONES
     $.post(`${general_base_url}General/getOpcionesPorCatalogo/117`, function (data) {
        for (var i = 0; i < data.length; i++) {
            $("#tipoCancelacion").append($('<option>').val(data[i]['id_opcion']).text(data[i]['nombre']));
        }
        $("#tipoCancelacion").selectpicker('refresh');
    }, 'json');
});

$('#proyecto').change(function () {
    let index_proyecto = $(this).val();
    $("#spiner-loader").removeClass('hide');
    $("#tabla_lotes").removeClass('hide');
    fillTable(index_proyecto);
});

let titulos_intxt = [];
$('#tabla_lotes thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tabla_lotes').DataTable().column(i).search() !== this.value)
            $('#tabla_lotes').DataTable().column(i).search(this.value).draw();
    });
});

$(document).on('click', '.cancel', function () {
    $('#idLote').val($(this).attr('data-idLote'));
    $('#nombreLote').val($(this).attr('data-nombreLote'));
    $('#obsSolicitudCancel').val('');
    $('#tipoCancelacion').val('').selectpicker('refresh');
    $('#cancelarLote').modal();
});

$(document).on('click', '#saveCancel', function () {
    let idLote = $("#idLote").val();
    let nombreLote = $("#nombreLote").val();
    let obsSolicitudCancel = $("#obsSolicitudCancel").val();
    let tipoCancelacion = $("#tipoCancelacion").val();
    let tipoCancelacionNombre = $('select[name="tipoCancelacion"] option:selected').text();
    if (obsSolicitudCancel.trim() == '' || tipoCancelacion == '') {
        alerts.showNotification("top", "right", "Asegúrate de ingresar una observación y seleccionar el tipo de liberación..", "warning");
        return false;
    }
    var datos = new FormData();
    $("#spiner-loader").removeClass('hide');
    datos.append("idLote", idLote);
    datos.append("nombreLote", nombreLote);
    datos.append("obsSolicitudCancel", obsSolicitudCancel);
    datos.append("tipoCancelacion", tipoCancelacion);
    datos.append("tipoCancelacionNombre", tipoCancelacionNombre);
    $.ajax({
        method: 'POST',
        url: `${general_base_url}Reestructura/setSolicitudCancelacion`,
        data: datos,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == 1) {
                $('#tabla_lotes').DataTable().ajax.reload(null, false);
                $("#spiner-loader").addClass('hide');
                $('#cancelarLote').modal('hide');
                alerts.showNotification("top", "right", "Opción editada correctamente.", "success");
                $('#idLote').val('');
                $('#obsSolicitudCancel').val('');
            }
        },
        error: function () {
            $('#cancelarLote').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function fillTable(index_proyecto) {
    tabla_valores_cliente = $("#tabla_lotes").DataTable({
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
                            return ' ' + titulos_intxt[columnIdx] + ' ';
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
            { data: 'superficie' },
            { data: 'precio' },
            { data: 'nombreCliente' },
            { data: 'comentarioReubicacion' },
            { data: 'comentarioLiberacion' },
            {
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipoCancelacion}</span>`;
                }
            },
            {
                data: function (d) {
                    return `<span class='label ${d.estatusCancelacion == 'CANCELADA' ? 'lbl-orange' : 'lbl-green'}'>${d.estatusCancelacion}</span>`;
                }
            },
            {
                data: function (d) {
                    if (d.consulta == 1) {
                        return `<div class="d-flex justify-center"><button class="btn-data btn-yellow cancel" data-toggle="tooltip" data-placement="top" title= "SOLICITUD DE CANCELACIÓN" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}"><i class="fas fa-comment-dots"></i></button>`;
                    }
                    return ``;
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

    $('#tabla_lotes').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}
