$('#evidenceTable thead tr:eq(0) th').each(function (i) {
    const title = $(this).text();
    $(this).html('<input type="text" class="textoshead"  placeholder="' + title + '"/>');
    $('input', this).on('keyup change', function () {
        if ($("#evidenceTable").DataTable().column(i).search() !== this.value) {
            $("#evidenceTable").DataTable()
                .column(i)
                .search(this.value)
                .draw();
        }
    });

});

function fillevidenceTable() {
    let current_rol_user;
    evidenceTable = $("#evidenceTable").dataTable({
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
                    let tipo;
                    if (d.type == 1) // MJ: EVIDENCIA TOKEN BBVA
                        tipo = `<span class="label" style="background: #AED6F1; color: #1F618D">${d.tipoEvidencia}</span>`;
                    else if (d.type == 2) // MJ: EVIDENCIA VIDEO CLIENTE
                        tipo = `<span class="label" style="background:#A2D9CE; color: #117A65">${d.tipoEvidencia}</span>`;
                    return tipo;
                }
            },
            {
                data: function (d) {
                    let lote;
                    if(d.id_lote != null){
                        lote = d.id_lote;
                    }else{
                        lote = "--";
                    }
                    return lote;
                }
            },
            {
                data: function (d) {
                    let nombreLote;
                    if(d.nombreLote != null){
                        nombreLote = d.nombreLote;
                    }else{
                        nombreLote = "--";
                    }
                    return nombreLote;
                }
            },
            {
                data: function (d) {
                    let cliente;
                    if(d.nombreCliente != "  "){
                        cliente = d.nombreCliente;
                    }else{
                        cliente = "--";
                    }
                    return cliente;
                }
            },
            {
                data: function (d) {
                    let fecha_apartado;
                    if(d.fechaApartado != null){
                        fecha_apartado = d.fechaApartado;
                    }else{
                        fecha_apartado = "--";
                    }
                    return fecha_apartado;
                }
            },
            {
                data: function (d) {
                    return d.asesor;
                }
            },
            {
                data: function (d) {
                    return d.gerente;
                }
            },
            {
                data: function (d) {
                    return d.fecha_creacion;
                }
            },
            {
                data: function (d) {
                    let estatus;
                    switch (d.estatus) {
                        case 0:
                            estatus = `<span class="label" style="background: #CCD1D1; color: #616A6B">No validada</span>`;
                            break;
                        case 1:
                            estatus = `<span class="label" style="background: #A9DFBF; color: #1E8449">Aceptada</span>`;
                            break;
                        case 2:
                            estatus = `<span class="label" style="background: #E6B0AA; color: #922B21">Rechazada</span>`;
                            break;
                    }
                    return estatus;
                }
            },
            {
                data: function (d) {
                    let btns = `<div class="d-flex align-center justify-center">`;
                    btns += `<button class="btn-data btn-gray reviewEvidence" data-lote ="${d.nombreLote}" data-type="${d.type}" data-nombre-archivo="${d.nombre_archivo}" title="Ver evidencia"></body><i class="fas fa-eye"></i></button>`;
                    if (d.currentRol == 3 && d.type == 1)
                        btns += `<button class="btn-data btn-green setToken" data-token-name="${d.token}" title="Copiar token"><i class="fas fa-copy"></i></button>`;
                    if (d.currentRol != 3){
                        if (d.estatus == 1)
                            btns += `<button class="btn-data btn-warning validateEvidence" data-type="${d.type}" data-action="2" data-id="${d.id}" title="Rechazar"><i class="fas fa-minus"></i></button>`;
                        if (d.estatus == 2 || d.estatus == 0)
                            btns += `<button class="btn-data btn-green validateEvidence" data-type="${d.type}" data-action="1" data-id="${d.id}" title="Aceptar"><i class="fas fa-check"></i></button>`;
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
            url: "getEvidencesInformation",
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
                        $("#evidenceTable").DataTable().ajax.reload(null, false);
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

$(document).on('click', '.reviewEvidence', function () {
    let type = $(this).attr("data-type");
    let fileName = $(this).attr("data-nombre-archivo");
    let lote = $(this).attr("data-lote");
    if (type == 1) { // MJ: TOKEN BBVA
        $("#img_actual").empty();
        let path = general_base_url + "static/documentos/evidence_token/" + fileName;
        let img_cnt = '<img src="' + path + '" class="img-responsive zoom m-auto">';
        $("#token_name").text($(this).attr("data-token-name"));
        $("#img_actual").append(img_cnt);
        $("#reviewTokenEvidence").modal();
    } else // MJ: EVIDENCIA VIDEO
        verEvidencia(fileName, lote);
});

$(document).on('click', '.setToken', function () {
    $("#generatedToken").val($(this).attr("data-token-name"));
    copyToClipBoard();
});

$(document).on('click', '.validateEvidence', function () {
    let action = $(this).attr("data-action");
    $.ajax({
        type: 'POST',
        url: 'validateEvidence',
        data: {
            'action': action,
            'id': $(this).attr("data-id"),
            'type': $(this).attr("data-type")
        },
        dataType: 'json',
        success: function (data) {
            $("#evidenceTable").DataTable().ajax.reload(null, false);
            alerts.showNotification("top", "right", action == 2 ? "La evidencia ha sido marcada como rechazada." : "La evidencia ha sido marcada como aceptada.", "success");
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function verEvidencia(fileName, lote){
    $.ajax({
        url: "viewDropboxFile",
        type: 'POST',
        data: {videoNombre: fileName},
        dataType: 'json',
        success: function (response) {
            let url = formatVideoURL(JSON.parse(response)); 
            var video = document.getElementById('video_preview');
            var source = document.createElement('source');
            source.setAttribute('src', url);
            source.setAttribute('type', 'video/mp4');
            video.appendChild(source);
            $("#nombre_lote").text(lote);
            $('#videoPreview').modal();
            $('#spiner-loader').addClass('hide');
        }, error: function () {
            $("#sendRequestButton").prop("disabled", false);
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

function formatVideoURL(response){
    let url;
    if(response.error){
        url = response.error.shared_link_already_exists.metadata.url;
        url = url.replace("dl=0", "raw=1");
    }else{
        url = response.url;
        url = url.replace("dl=0", "raw=1");
    }
    return url;
}
