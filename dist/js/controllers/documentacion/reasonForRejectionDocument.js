$(document).ready(function () {
    $("#spiner-loader").removeClass('hide');
    $("#documentos").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'Documentacion/getCatalogOptions',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#documentos").append($('<option>').val(response[i]['id_opcion']).attr('data-catalogo', response[i]['id_catalogo']).text(response[i]['nombre']));
            }
            $("#documentos").append($('<option>').val(0).attr('data-catalogo', 0).text('POR SOLICITUD'));
            $("#documentos").selectpicker('refresh');
            $("#spiner-loader").addClass('hide');
        }
    });
});

$('#reasonsForRejectionTable thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    if (i != 4) {
        $(this).html('<input type="text" class="textoshead" data-toggle="tooltip" data-placement="top" title="' + title + '" placeholder="' + title + '"/>');
        $('input', this).on('keyup change', function () {
            if ($("#reasonsForRejectionTable").DataTable().column(i).search() !== this.value) {
                $("#reasonsForRejectionTable").DataTable().column(i).search(this.value).draw();
            }
        });
    }
});

function fillTable(id_documento) {
    console.log(id_documento);
    generalDataTable = $('#reasonsForRejectionTable').dataTable({
        dom: 'rt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        bAutoWidth: true,
        scrollX: true,
        pagingType: "full_numbers",
        fixedHeader: true,
        language: {
            url: general_base_url + "/static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [{
            data: function (d) {
                return d.id_motivo;
            }
        },
        {
            data: function (d) {
                return d.motivo;
            }
        },    
        {
            data: function (d) {
                return d.motivo;
            }
        },
        {
            data: function (d) {
                return d.estatus_motivo;
            }
        },
        {
            data: function (d) {
                let btns = '<div class="d-flex justify-center"><button class="btn-data btn-blueMaderas apply-action" data-action="1" data-id-motivo="' + d.id_motivo + '" data-nombre-documento="' + d.nombre_documento + '" data-motivo="' + d.motivo + '" data-toggle="tooltip" data-placement="left" title="EDITAR"><i class="fas fa-pen"></i></button>';
                btns += `<button class="btn-data btn-${d.estatus == 1 ? 'warning' : 'green'} apply-action" data-action="${d.estatus == 1 ? 2 : 3}" data-id-motivo="${d.id_motivo}" data-nombre-documento="${d.nombre_documento}" data-motivo="${d.motivo}"  data-toggle="tooltip" data-placement="left" title="${d.estatus == 1 ? 'DESACTIVAR' : 'ACTIVAR'}"><i class="fas fa-${d.estatus == 1 ? 'lock' : 'unlock'}"></i></button>`;
                btns += '</div>';
                $('[data-toggle="tooltip"]').tooltip();
                return btns;
            }
        }],
        columnDefs: [{
            visible: false
        }],
        ajax: {
            url: 'getReasonsForRejectionByDocument',
            type: "POST",
            cache: false,
            data: {
                "id_documento": id_documento,
                "tipo_proceso": id_documento == 0 ? 3 : 2
            }
        }
    });
}

$(document).on("change", "#documentos", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    fillTable($("#documentos").val());
});

function saveRejectReason() {
    $('#btn_save').prop('disabled', true);
    $('#spiner-loader').removeClass('hidden');
    let id_documento = $("#id_documento").val();
    let id_motivo = $("#id_motivo").val();
    let action = $("#action").val();
    let reject_reason = $("#rejectReason").val();
    let documentName = $("#documentos option:selected").text();
    if ((action == 0 && (reject_reason == '' || id_documento == '')) || (action == 1 && (reject_reason == '' || id_motivo == ''))){
        alerts.showNotification("top", "right", "Asegúrate de ingresar un motivo de rechazo para el documento <b>" + documentName + "</b>.", "warning");
        $('#btn_save').prop('disabled', false);
        $('#spiner-loader').addClass('hidden');
    }else {
        $.ajax({
            type: 'POST',
            url: general_base_url + 'Documentacion/saveRejectReason',
            data: {
                "id_documento": id_documento,
                "reject_reason": reject_reason,
                "id_motivo": id_motivo,
                "action": action
            },
            dataType: 'json',
            success: function (response) {
                alerts.showNotification("top", "right", response["message"], response["status"] == 200 ? "success" : response["status"] == 400 ? "warning" : "error");
                if (response["status"] == 200) {
                    $("#reasonsForRejectionTable").DataTable().ajax.reload(null, false);
                    $("#addRejectReasonModal").modal("hide");
                }
                $('#btn_save').prop('disabled', false);
                $('#spiner-loader').addClass('hidden');
            },
            error: function () {
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                $('#btn_save').prop('disabled', false);
                $('#spiner-loader').addClass('hidden');
            }
        });
    }
}

$(document).on("click", ".apply-action", function () {
    let action = $(this).data("action");
    if (action == 0) {
        let id_documento = $("#documentos").val();
        if (id_documento == '')
            $("#notification").modal("show");
        else {
            $("#rejectReason").val("");
            $("#id_documento").val(id_documento);
            $("#action").val(0);
            document.getElementById("documentName").innerHTML = $("#documentos option:selected").text();
            $("#addRejectReasonModal").modal();
        }
    } else if (action == 1) {
        $("#main_div").addClass("clasecss");
        document.getElementById("documentName").innerHTML = $(this).attr("data-nombre-documento");
        $("#rejectReason").val($(this).attr("data-motivo"));
        $("#id_documento").val(id_documento);
        $("#id_motivo").val($(this).attr("data-id-motivo"));
        $("#action").val(action);
        $("#addRejectReasonModal").modal();
    } else if (action == 2 || action == 3)
        updateStatus(action, $(this).attr("data-id-motivo"));
});

function updateStatus(action, id_motivo) {
    $.ajax({
        type: 'POST',
        url: general_base_url + 'Documentacion/changeStatus',
        data: {"action": action, "id_motivo": id_motivo},
        dataType: 'json',
        success: function (response) {
            alerts.showNotification("top", "right", response["message"], response["status"] == 200 ? "success" : response["status"] == 400 ? "warning" : "error");
            if (response["status"] == 200)
                $("#reasonsForRejectionTable").DataTable().ajax.reload(null, false);
        },
        error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
}

$('body').tooltip({
    selector: '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])',
    trigger: 'hover',
    container: 'body'
}).on('click mousedown mouseup', '[data-toggle="tooltip"], [title]:not([data-toggle="popover"])', function () {
    $('[data-toggle="tooltip"], [title]:not([data-toggle="popover"])').tooltip('destroy');
});