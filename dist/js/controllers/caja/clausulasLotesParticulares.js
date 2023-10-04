let titulosClausulasLotesParticulares = [];
$('#tablaClausulasLotesParticulares thead tr:eq(0) th').each(function (i) {
    var title = $(this).text();
    titulosClausulasLotesParticulares.push(title);
    $(this).html(`<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="${title}" placeholder="${title}"/>`);
    $('input', this).on('keyup change', function () {
        if ($('#tablaClausulasLotesParticulares').DataTable().column(i).search() !== this.value)
            $('#tablaClausulasLotesParticulares').DataTable().column(i).search(this.value).draw();
    });
});

$("#tablaClausulasLotesParticulares").ready(function () {
    tabla_5 = $("#tablaClausulasLotesParticulares").DataTable({
        dom: 'Brt' + "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: '100%',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Reporte de lotes bloqueados',
                title: "Reporte de lotes bloqueados",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                    format: {
                        header: function (d, columnIdx) {
                            return ' ' + titulosClausulasLotesParticulares[columnIdx] + ' ';
                        }
                    }
                }
            }
        ],
        language: {
            url: `${general_base_url}static/spanishLoader_v2.json`,
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pageLength: 11,
        fixedColumns: true,
        ordering: false,
        scrollX: true,
        columns: [
            {data: 'nombreResidencial'},
            {data: 'nombreCondominio'},
            {data: 'nombreLote'},
            {data: 'idLote'},
            {data: 'sup'},
            {data: 'precioM2'},
            {data: 'total'},
            {data: 'referencia'},
            {
                data: function (d) {
                    return `<center><span class="label" style="background:#${d.background_sl}18; color:#${d.color};">${d.nombreEstatusLote}</span> <p><p> <span class="label lbl-green">${d.tipo_venta}</span><center>`;
                }
            },
            {data: 'clausulas'},
            {
                data: function (d) {
                    return `<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas addEditClausulas" value="${d.id_clausula}" data-clausulas="${d.clausulas}" data-idlote="${d.idLote}" data-nombrelote="${d.nombreLote}" data-toggle="tooltip" data-placement="left" title="AGREGAR/EDITAR CLÁUSULAS"><i class="fas fa-edit"></i></button>
                    <button class="btn-data btn-warning btn-delete addVentaParticular" data-idlote="${d.idLote}" data-nombrelote="${d.nombreLote}" data-toggle="tooltip" data-placement="left" title="REMOVER VENTA PARTICULAR"><i class="fas fa-trash"></i></button></div>`;
                }
            }
        ],
        initComplete: function() {
            $('[data-toggle="tooltip"]').tooltip();
        },
        ajax: {
            url: "getLotesParticulares",
            dataSrc: "",
            type: "POST",
            cache: false,
            data: function (d) {}
        },
        order: [[1, 'asc']]
    });
});

$(document).on('click', '.addEditClausulas', function () {
    $('#clausulas').val($(this).data("clausulas"));
    $('#idLote').val($(this).data("idlote"));
    $(".nombreLote").html($(this).data("nombrelote"));
    $('#id_clausula').val($(this).val());
    $('#addEditClausulasModal').modal();
});

$(document).on('click', '.addVentaParticular', function () {
    $(".nombreLote").html($(this).data("nombrelote"));
    $('#idLote').val($(this).data("idlote"));
    $('#addVentaParticularModal').modal();
});

function addEditClausulas() {
    let id_clausula = $("#id_clausula").val();
    let idLote = $("#idLote").val();
    let clausulas = $("#clausulas").val();
    if (clausulas == '')
        alerts.showNotification('top', 'right', 'Ingresa las cláusulas para continuar.', 'danger')
    else {
        $.ajax({
            type: 'POST',
            url: 'addEditClausulas',
            data: {
                'id_clausula': id_clausula,
                'clausulas': clausulas,
                'idLote': idLote
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == 1) {
                    $('#addEditClausulasModal').modal('hide');
                    $('#tablaClausulasLotesParticulares').DataTable().ajax.reload();
                    alerts.showNotification("top", "right", data.message, "success");
                } else if (data.status == -1)
                    alerts.showNotification("top", "right", data.message, "danger");
            },
            error: function (data) {
                alerts.showNotification("top", "right", "Oops, algo salió mal. Vuelve a interntarlo más tarde.", "danger");
            }
        });
    }
}

function addVentaParticular() {
    var dataExp = new FormData();
    let idLote = $("#idLote").val();
    let tipo_venta = $("#tipo_venta").val();
    dataExp.append("idLote", idLote);
    dataExp.append("tipo_venta", tipo_venta);

    $("#spiner-loader").removeClass("hide");
    $("#btnVentaParticular").prop("disabled", true);
    
        $.ajax({
            type: 'POST',
            url: 'EditVentaParticular',
            data: dataExp,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: function (data) {
                response = JSON.parse(data);
                if (response.message == "OK") {
                    $("#btnVentaParticular").prop("disabled", false);
                    $('#addVentaParticularModal').modal('hide');
                    $('#tablaClausulasLotesParticulares').DataTable().ajax.reload();
                    alerts.showNotification(
                      "top",
                      "right",
                      "Representante Legal Actualizado",
                      "success"
                    );
                    $("#spiner-loader").addClass("hide");
                  }
                },
                error: function (data) {
                    $("#btnVentaParticular").prop("disabled", false);
                    $('#addVentaParticularModal').modal('hide');
                    $('#tablaClausulasLotesParticulares').DataTable().ajax.reload();
                  alerts.showNotification(
                    "top",
                    "right",
                    "Error al enviar la solicitud.",
                    "danger"
                  );
                  $("#spiner-loader").addClass("hide");
                }
        });
}
