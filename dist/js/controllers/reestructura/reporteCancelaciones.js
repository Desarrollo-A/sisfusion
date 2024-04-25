$(document).ready(function () {
    cancelacionTable();
});

$('#catalogoLiberar').change(function () {
    let index_proyecto = $(this).val();
    $("#spiner-loader").removeClass('hide');
    $("#tabla_cancelacion").removeClass('hide');
    cancelacionTable(index_proyecto);
});

let titulos_intxt = [];
$('#tabla_cancelacion thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulos_intxt.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tabla_cancelacion').DataTable().column(i).search() !== this.value)
            $('#tabla_cancelacion').DataTable().column(i).search(this.value).draw();
    });
});

function cancelacionTable() {
    tabla_cancelacion = $("#tabla_cancelacion").DataTable({
        width: '100%',
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'CANCELACIÓN POR REESTRUCTURACIÓN',
            title: 'CANCELACIÓN POR REESTRUCTURACIÓN',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
            { data: 'nombreCliente' },
            { data: 'idLote' },
            { data: 'comentarioReubicacion' },
            { data: 'comentarioLiberacion' },
            {
                data: function (d) {
                    return `<span class='label lbl-violetBoots'>${d.tipoCancelacion}</span>`;
                }
            },
            {
                visible: (id_rol_general == 33) ? true : false,
                data: function (d) {
                    return `<span class='label ${d.solicitudCancelacion == 2 ? 'lbl-orange' : 'lbl-green'}'>${d.estatusCancelacion}</span>`;
                }
            },
            {
                visible: (id_rol_general == 33) ? true : false,
                data: function (d) {
                    return (d.solicitudCancelacion == 2 ) ? `<div class="d-flex justify-center"><button class="btn-data btn-warning cancel" data-toggle="tooltip" data-placement="top" title= "CANCELAR CONTRATO" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}"><i class="fas fa-user-times"></i></button><div class="d-flex justify-center"><button class="btn-data btn-sky returnBtn" data-toggle="tooltip" data-placement="top" title= "REGRESAR CONTRATO" data-idLote="${d.idLote}" data-nombreLote="${d.nombreLote}"><i class="fas fa-undo"></i></button>` : ``;                   
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
            url: `${general_base_url}Reestructura/getReporteCancelaciones`,
            dataSrc: "",
            type: "POST",
            cache: false,
            data: {}
        },
        initComplete: function () {
            $("#spiner-loader").addClass('hide');
        },
        order: [
            [1, 'asc']
        ],
    });

    $('#tabla_cancelacion').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
        });
    });
}

$(document).on('click', '.cancel', function () {
    $('#idLote').val($(this).attr('data-idLote'));
    $('#obsLiberacion').val('');
    $('#cancelarLote').modal();
});

$(document).on('click', '.returnBtn', function () {
    $('#idLoteR').val($(this).attr('data-idLote'));
    $('#obsLiberacion').val('');
    $('#return').modal();
});

$(document).on('click', '#saveCancel', function () {
    let idLote = $("#idLote").val();
    let obsLiberacion = $("#obsLiberacion").val();
    if (obsLiberacion.trim() == '') {
        alerts.showNotification("top", "right", "Asegúrate de ingresar una observación.", "warning");
        return false;
    }
    var datos = new FormData();
    $("#spiner-loader").removeClass('hide');
    datos.append("idLote", idLote);
    datos.append("obsLiberacion", obsLiberacion);
    datos.append("tipoLiberacion", 3);
    $.ajax({
        method: 'POST',
        url: `${general_base_url}Reestructura/aplicarLiberacion`,
        data: datos,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == 1) {
                $('#tabla_cancelacion').DataTable().ajax.reload(null, false);                $("#spiner-loader").addClass('hide');
                $('#cancelarLote').modal('hide');
                alerts.showNotification("top", "right", "Opcion editada correctamente.", "success");
                $('#idLote').val('');
                $('#obsLiberacion').val('');
            }
        },
        error: function () {
            $('#cancelarLote').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});


$(document).on('click', '#returnReestructura', function () {
    let idLote = $("#idLoteR").val();
    let observaciones = $("#observaciones").val();
    if (observaciones.trim() == '') {
        alerts.showNotification("top", "right", "Asegúrate de ingresar una observación", "warning");
        return false;
    }
    var datos = new FormData();
    $("#spiner-loader").removeClass('hide');
    datos.append("idLote", idLote);
    datos.append("observaciones", observaciones);
    $.ajax({
        method: 'POST',
        url: `${general_base_url}Reestructura/returnToRestructure`,
        data: datos,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == 1) {
                $('#tabla_cancelacion').DataTable().ajax.reload(null, false);
                $("#spiner-loader").addClass('hide');
                $('#return').modal('hide');
                alerts.showNotification("top", "right", "Opción editada correctamente.", "success");
                $('#idLote').val('');
                $('#obsLiberacion').val('');
            }
        },
        error: function () {
            $('#cancelarLote').modal('hide');
            $("#spiner-loader").addClass('hide');
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});