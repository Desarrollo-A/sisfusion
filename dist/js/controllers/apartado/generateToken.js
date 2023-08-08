let evidenceTable;

$(document).ready(function () {
    fillevidenceTable();
    getAsesoresList();
    $("input:file").on("change", function () {
        var target = $(this);
        var relatedTarget = target.siblings(".file-name");
        var fileName = target[0].files[0].name;
        relatedTarget.val(fileName);
    });
    $('[data-toggle="tooltip"]').tooltip();
});

let titulosEvidence = [];
$('#evidenceTable thead tr:eq(0) th').each( function (i) {
    var title = $(this).text();
    titulosEvidence.push(title);
    $(this).html(`<input data-toggle="tooltip" data-placement="top" placeholder="${title}" title="${title}"/>` );
    $( 'input', this ).on('keyup change', function () {
        if ($('#evidenceTable').DataTable().column(i).search() !== this.value ) {
            $('#evidenceTable').DataTable().column(i).search(this.value).draw();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    })

function fillevidenceTable() {
    evidenceTable = $("#evidenceTable").dataTable({
        dom: 'Brt'+ "<'container-fluid pt-1 pb-1'<'row'<'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'i><'col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-center'p>>>",
        width: "100%",
        scrollX: true,
        bAutoWidth:true,
        buttons:[{
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o" aria-hidden="true" title="DESCARGAR ARCHIVO DE EXCEL"></i>',
            className: 'btn buttons-excel',
            titleAttr: 'DESCARGAR ARCHIVO DE EXCEL',
            title: 'Consulta BBVA',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                format: {
                    header: function (d, columnIdx) {
                        return ' ' + titulosEvidence[columnIdx] + ' ';
                    }
                }
            }
        }],
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
                        tipo = `<span class="label lbl-blueMaderas">${d.tipoEvidencia}</span>`;
                    else if (d.type == 2) // MJ: EVIDENCIA VIDEO CLIENTE
                        tipo = `<span class="label lbl-green">${d.tipoEvidencia}</span>`;
                    return tipo;
                }
            },
            {
                data: function (d) {
                    let lote;
                    if(d.id_lote != null){
                        lote = d.id_lote;
                    }else{
                        lote = "SIN ESPECIFICAR";
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
                        nombreLote = "SIN ESPECIFICAR";
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
                        cliente = "SIN ESPECIFICAR";
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
                        fecha_apartado = "SIN ESPECIFICAR";
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
                            estatus = `<span class="label lbl-deepGray">No validada</span>`;
                            break;
                        case 1:
                            estatus = `<span class="label lbl-green">Aceptada</span>`;
                            break;
                        case 2:
                            estatus = `<span class="label lbl-warning">Rechazada</span>`;
                            break;
                    }
                    return estatus;
                }
            },
            {
                data: function (d) {
                    let btns = `<div class="d-flex align-center justify-center">`;
                    btns += `<button class="btn-data btn-blueMaderas reviewEvidence" data-lote ="${d.nombreLote}" data-type="${d.type}" data-nombre-archivo="${d.nombre_archivo}" data-toggle="tooltip"  data-placement="top" title="VER EVIDENCIA"></body><i class="fas fa-eye"></i></button>`;
                    if (d.currentRol == 3 && d.type == 1)
                        btns += `<button class="btn-data btn-green setToken" data-token-name="${d.token}" data-toggle="tooltip"  data-placement="top" title="COPIAR TOKEN"><i class="fas fa-copy"></i></button>`;
                    if (d.currentRol != 3){
                        if (d.estatus == 1 || d.estatus == 0)
                            btns += `<button class="btn-data btn-warning validateEvidence" data-type="${d.type}" data-action="2" data-id="${d.id}" data-toggle="tooltip"  data-placement="top" title="RECHAZAR"><i class="fas fa-minus"></i></button>`;
                        if (d.estatus == 2 || d.estatus == 0)
                            btns += `<button class="btn-data btn-green validateEvidence" data-type="${d.type}" data-action="1" data-id="${d.id}" data-toggle="tooltip"  data-placement="top" title="ACEPTAR"><i class="fas fa-check"></i></button>`;
                    }
                    btns += '</div>';
                    return btns;
                }
            }
        ],
        columnDefs: [{
            orderable: false,
            searchable: true,
            target: 0,
        }],
        ajax: {
            url: "getEvidencesInformation",
            type: "POST",
            cache: false
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
            data.append("id_gerente", id_usuario_general);
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
                        $(".generated-token").val("http://pagosciudadmaderas.com/apartado/token.html?token=" + response["id_token"]);
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
            alerts.showNotification("top", "right", action == 2 ? "La evidencia ha sido marcada como rechazada."  : "La evidencia ha sido marcada como aceptada.", action == 2 ? "danger" : "success");
        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
        }
    });
});

function verEvidencia(fileName, lote){
    $('#spiner-loader').removeClass('hide');
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


$(window).resize(function(){
    evidenceTable.columns.adjust();
});