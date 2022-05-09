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
    tokensTable = $("#tokensTable").dataTable({
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
                                    return "GENERADO PARA"
                                case 2:
                                    return "FECHA ALTA";
                                    break;
                                case 3:
                                    return "CREADO POR";
                                    break;
                                case 4:
                                    return "ETATUS";
                                    break;
                            }
                        }
                    }
                }
            }
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
            },
            {
                data: function (d) {
                    return d.estatus;
                }
            },
            {
                data: function (d) {
                    let btns = '<div class="d-flex align-center justify-center">' +
                        '<button class="btn-data btn-gray reviewEvidenceToken" data-nombre-archivo="' + d.nombre_archivo + '" title="Ver evidencia"></body><i class="fas fa-eye"></i></button>' +
                        '<button class="btn-data btn-green setToken" data-token-name="' + d.token + '" title="Copiar token"><i class="fas fa-copy"></i></button>';
                    if (current_rol_user != 3){
                        if (d.estatus == 1)
                            btns += '<button class="btn-data btn-warning validateToken" data-action="2" data-token-id="' + d.id_token + '" title="Rechazar token"><i class="fas fa-minus"></i></button>';
                        if (d.estatus == 2 || d.estatus == 0)
                            btns += '<button class="btn-data btn-green validateToken" data-action="1" data-token-id="' + d.id_token + '" title="Validar token"><i class="fas fa-check"></i></button>';
                    }
                    btns += '</div>';
                    return btns;
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
            cache: false
        }
    });
}

$(document).on("click", "#generateToken", function () {
    document.getElementById("fileElm").value = "";
    document.getElementById("file-name").value = "";
    $("#generateTokenModal").modal("show");
    $("#asesoresList").val("").selectpicker("refresh");
});

function generateToken() {
    fileElm = document.getElementById("fileElm");
    file = fileElm.value;
    if (file == "" || $("#asesoresList").val() == "")
        alerts.showNotification("top", "right", "Asegúrate de seleccionar un asesor y cargar un archivo para generar el token.", "warning");
    else {
        let extension = file.substring(file.lastIndexOf("."));
        let statusValidateExtension = validateExtension(extension, ".jpg, .jpeg, .png");
        if (statusValidateExtension == false) // MJ: ARCHIVO VÁLIDO PARA CARGAR
            alerts.showNotification("top", "right", "El archivo que has intentado cargar con la extensión <b>" + extension + "</b> no es válido. Recuerda seleccionar un archivo de imagen.", "warning");
        else {
            $('#spiner-loader').removeClass('hide');
            let data = new FormData();
            data.append("id_asesor", $("#asesoresList").val());
            data.append("id_gerente", id_gerente);
            data.append("uploaded_file", $("#fileElm")[0].files[0]);
            $.ajax({
                url: general_base_url + 'Api/generateToken',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", response["message"], response["status"] != 200 ? "danger" : "success");
                    if (response["status"] == 200) { // MJ: TOKEN GENERADO CON EXITO
                        $(".generated-token").val("https://ciudadmaderas.com/apartado/token.html?token=" + response["id_token"]);
                        $("#generateTokenModal").modal("hide");
                        $("#tokensTable").DataTable().ajax.reload(null, false);
                    }
                }, error: function () {
                    $('#spiner-loader').addClass('hide');
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }
    }
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
        alerts.showNotification("top", "right", "Token copiado al portapapeles.", "success");
    }
}

$(document).on('click', '.reviewEvidenceToken', function () {
    $("#img_actual").empty();
    let path = general_base_url + "static/documentos/evidence_token/" + $(this).attr("data-nombre-archivo");
    let img_cnt = '<img src="' + path + '" class="img-responsive zoom m-auto">';
    $("#token_name").text($(this).attr("data-token-name"));
    $("#img_actual").append(img_cnt);
    $("#reviewTokenEvidence").modal()
});

$(document).on('click', '.setToken', function () {
    $("#generatedToken").val($(this).attr("data-token-name"));
    copyToClipBoard();
});

$(document).on('click', '.validateToken', function () {
    let action = $(this).attr("data-action");
    $.ajax({
        type: 'POST',
        url: 'validarToken',
        data: {
            'action': action,
            'id': $(this).attr("data-token-id")
        },
        dataType: 'json',
        success: function (data) {
            $("#tokensTable").DataTable().ajax.reload(null, false);
            alerts.showNotification("top", "right", action == 2 ? "El token ha sido marcado como rechazado." : "El token ha sido marcado como aprobado.", "success");
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});