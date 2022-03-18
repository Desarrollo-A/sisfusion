$('#tokensTable thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($("#tokensTable").DataTable().column(i).search() !== this.value) {
            $("#tokensTable").DataTable()
                .column(i)
                .search(this.value)
                .draw();
        }
    });

});

function fillTokensTable() {
    tokensTable = $('#tokensTable').dataTable({
        dom: 'Brt' + "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
        width: "auto",
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                    format: {
                        header: function (d, columnIdx) {
                            switch (columnIdx) {
                                case 0:
                                    return "ID";
                                    break;
                                case 1:
                                    return "TOKEN";
                                    break;
                                case 2:
                                    return "GENERADO PARA"
                                case 3:
                                    return "FECHA ALTA";
                                    break;
                                case 4:
                                    return "CREADO POR";
                                    break;
                            }
                        }
                    }
                }
            }
        ],
        pagingType: "full_numbers",
        fixedHeader: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        language: {
            url: "../static/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        destroy: true,
        ordering: false,
        columns: [
            {
                data: function (d) {
                    return d.id_token;
                }
            },
            {
                data: function (d) {
                    return d.token;
                }
            },
            {
                data: function (d) {
                    return d.generado_para;
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {
                    return d.creado_por;
                }
            }
        ],
        columnDefs: [{
            visible: false,
            searchable: false
        }],
        ajax: {
            url: "getTokensInformation",
            type: "POST",
            cache: false,
        }
    });
}

$(document).on("click", "#generateToken", function () {
    $("#generateTokenModal").modal("show");
    $("#asesoresList").val("").selectpicker("refresh");
});

function generateToken() {
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        url: general_base_url + 'Api/generateToken',
        type: 'post',
        dataType: 'json',
        data: {
            "id_asesor": $("#asesoresList").val(),
            "id_gerente": id_gerente
        },
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            alerts.showNotification("top", "right", response["message"], response["status"] == 500 ? "danger" : "success");
            if (response["status"] == 200) { // MJ: TOKEN GENERADO CON EXITO
                $(".generated-token").val("https://ciudadmaderas.com/apartado/token.html?token=" + response["id_token"]);
                $("#generateTokenModal").modal("hide");
                $("#tokensTable").DataTable().ajax.reload(null, false);
            }
        }
    });
}

function cleanSelects() {
    $("#asesoresList").val("").selectpicker('refresh');
}

function copyToClipBoard() {
    /* Get the text field */
    let copyText = document.getElementById("generatedToken");
    if (copyText.value == "")
        alerts.showNotification("top", "right", "No hay ningún token que copiar.", "warning");
    else {
        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /*setTimeout(function () {
            $( "#copyToken" ).fadeOut( "slow", function() {
                $('#copyToken').popover('hide');
            });
        }, 1500);*/
    }
}

