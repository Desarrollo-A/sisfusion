let typeTransaction = 0; // MJ: SELECTS MULTIPLES
var allDocuments = [];
$(document).ready(function () {
    $(document).on('fileselect', '.btn-file :file', function (event, numFiles, label) {
        var input = $(this).closest('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    getResidenciales_escrituracion();
});

$(document).on('change', "#residenciales_escrituracion", function() {
    $('#lotes_escrituracion').val();
    getCondominios_escrituracion($(this).val());
    $(".boxDocument").removeClass("hide");
    mostrarVisualizadorDocumentos();
});

$(document).on('change', "#condominios_escrituracion", function() {
    var idResidencial = $("#residenciales_escrituracion").val();
    getLotes_escrituracion($(this).val(), idResidencial);
    $(".boxDocument").addClass("hide");
    $(".boxDocumentEmpty").removeClass("hide");
    mostrarVisualizadorDocumentos();
});

$('#lotes_escrituracion').change(function (e) {
    e.preventDefault();
    getDocumentsInformation($(this).val());
    $(".boxDocument").addClass("hide");
    mostrarVisualizadorDocumentos();
});

function getRejectionReasons() {
    alert("IN");
    $("#rejectionReasons").empty().selectpicker('refresh');
    $("#rejectionReasons").append($('<option disabled>').val("0").text("Selecciona un motivo de rechazo"));
    $.ajax({
        url: 'getRejectionReasons',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['id_motivo'];
                var name = response[i]['motivo'];
                var tipo_documento = response[i]['tipo_documento'];
                $("#rejectionReasons").append($('<option>').val(id).attr('data-type', tipo_documento).text(name));
            }
            $("#rejectionReasons").selectpicker('refresh');
        }
    });
}

function getDocumentsInformation(idLote) {
    cleanElement("documentsList");
    $('#spiner-loader').removeClass('hide');
    $.ajax({
        type: 'POST',
        url: `${general_base_url}registroCliente/expedientesWS/${idLote}`,
        dataType: 'json',
        success: function (data) {
            if(data.length > 0){
                $.each(data, function (i, v) {
                    fillDocumentsList(v, i);
                    allDocuments.push(v);
                });
            }
            else{
                alerts.showNotification("top", "right", "No hay documentos que mostrar.", "warning");
            }
            $('#spiner-loader').addClass('hide');

        }, error: function () {
            alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            $('#spiner-loader').addClass('hide');
        }
    });
}

function fillDocumentsList2(v, i) {
    console.log("test 22");
}

function fillDocumentsList(v, i) {
    if (getFileExtension(v.expediente) == "NULL" || getFileExtension(v.expediente) == 'null' || getFileExtension(v.expediente) == "") {
        if( id_rol_general == 6 ){
            if( ( v.idMovimiento == 37 || v.idMovimiento == 7 || v.idMovimiento == 64 || v.idMovimiento == 66 || v.idMovimiento == 77 || v.idMovimiento == 41) && (id_rol_current==6) && (v.tipo_doc==26 || v.tipo_doc==29)){
                botonDocumento = `<a class="list-group-item viewDocument border-none" data-file="${v.expediente}" data-type="${v.tipo_documento}" data-name="${v.expediente}" data-idSolicitud="${v.idSolicitud}" data-idDocumento="${v.idDocumento}" data-indice="${i}">
                    <button type="button" title= "Adjuntar archivo" class="btn-data btn-warning upload" data-indice="${i}">
                        <i class="fas fa-upload"></i>
                    </button>
                    <h4 class="list-group-item-heading m-0 w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="${v.movimiento}">${v.movimiento}</h4>
                </a>`;
            }
        }
        else if(id_rol_general == 7 || id_rol_general == 9 || id_rol_general == 3 || id_rol_general == 2 && ())
        
            
        
            <?php }elseif($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 /*&& $this->session->userdata('id_usuario') == $this->session->userdata('datauserjava')*/){?>
            // 
            if((data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96) && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3 || id_rol_current==2) && (ventaC == 1)){
                file = '<button type="button" '+disabled_option+' id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-cloud-upload-alt"></i></button>';
            } else {
                file = '<button id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>';
            }
            <?php } else {?> file = '<button id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fas fa-cloud-upload-alt"></i></button>'; <?php } ?>
        
    }
    else{
        if((data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96) && (id_rol_general==7 || id_rol_general==9 || id_rol_general==3 || id_rol_general==2) && (ventaC == 1) ){
            botonDocumento = `<a class="list-group-item viewDocument border-none" data-file="${v.expediente}" data-type="${v.tipo_documento}" data-name="${v.expediente}" data-idSolicitud="${v.idSolicitud}" data-idDocumento="${v.idDocumento}" data-indice="${i}">
                <button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="${v.movimiento}" data-iddoc="${v.idDocumento}">
                    <i class="fas fa-trash"></i>
                </button>
                <h4 class="list-group-item-heading m-0 w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="${v.movimiento}">
                    <i class="fas fa-trash"></i>${v.movimiento}
                </h4>
            </a>`;
        }
        else {
            botonDocumento = `<a class="list-group-item viewDocument border-none" data-file="${v.expediente}" data-type="${v.tipo_documento}" data-name="${v.expediente}" data-idSolicitud="${v.idSolicitud}" data-idDocumento="${v.idDocumento}" data-indice="${i}">
                <h4 class="list-group-item-heading m-0 w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="${v.movimiento}">
                    <i class="fas fa-trash"></i>${v.movimiento}
                </h4>
            </a>`;
        }
    }
    
        else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
            file = '<a class="btn-data btn-blueMaderas pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
        }
        else if (getFileExtension(data.expediente) == "Depósito de seriedad versión anterior") {
            file = '<a class="btn-data btn-blueMaderas pdfLink22" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
        }
        else if (getFileExtension(data.expediente) == "Autorizaciones") {
            file = '<a href="#" class="btn-data btn-blueMaderas seeAuts" title= "Autorizaciones" data-idCliente="'+data.idCliente+'" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a>';
        }
        else if (getFileExtension(data.expediente) == "Prospecto") {
            file = '<a href="#" class="btn-data btn-blueMaderas verProspectos" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-lp="'+data.lugar_prospeccion+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'"><i class="fas fa-user-check"></i></a>';
        }
        /*generar funcion para ver Evidencia MKTD*/
        else
        {
            <?php if($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 9 || $this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 2 /*&& $this->session->userdata('id_usuario') == $this->session->userdata('datauserjava')*/){?>
            if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96 && (id_rol_current==7 || id_rol_current==9 || id_rol_current==3 || id_rol_current==2) ){

                if(data.tipo_doc == 66){
                file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fas-folder-open"></i></a>' +
                    '';
            }else{
                file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>' +
                    '';
                }
            } else {

                if(data.tipo_doc == 66){
                file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fas-folder-open"></i></a>';
                }else{
                    file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';
                }
                
            }
            <?php } else {?> 

                if(data.tipo_doc == 66){
                file = '<a class="verEVMKTD btn-data btn-acidGreen" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-image"></i></a>';
                }else{
                    file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';
                    if((data.tipo_doc==26 || data.tipo_doc==29) && id_rol_current==6 ){
                        if((data.idMovimiento == 37 || data.idMovimiento == 7 || data.idMovimiento == 64 || data.idMovimiento == 66 || data.idMovimiento == 77 || data.idMovimiento == 41) && (id_rol_current==6) && (data.tipo_doc==26 || data.tipo_doc==29)){
                            file+= '<button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
                        }
                    }else{
                        file = '<a class="pdfLink btn-data btn-acidGreen" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a>';

                    }

                }

            <?php }?>

        }
        $("#documentsList").append('<a class="list-group-item viewDocument border-none" data-file="' + v.expediente + '" data-type="' + v.tipo_documento + '" data-name="' + v.expediente + '" data-idSolicitud="' + v.idSolicitud + '" data-idDocumento="' + v.idDocumento + '" data-indice="'+i+'">\n' +
        '        <h4 class="list-group-item-heading m-0 w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="' + v.movimiento + '">\n' + '<i class="fas fa-folder mr-1"></i>' + v.movimiento + '</h4></a>');

        $('[data-toggle="tooltip"]').tooltip();
        $(".boxDocumentEmpty").removeClass("hide");
}



function cleanElement(e) {
    let element = document.getElementById(e);
    element.innerHTML = '';
}

$(document).on("click", ".viewDocument", function () {
    $(".boxDocumentEmpty").removeClass("d-flex");
    $(".boxDocumentEmpty").addClass("d-none");
    cleanElement("documentName");
    cleanElement("boxOptions");
    let indice = $(this).attr("data-indice");
    
    const { tipo_doc, estatus_validacion, expediente, idCliente, idDocumento, idLote, lastModify, lugar_prospeccion, name, userName, userPermissions} = allDocuments[indice];
    if(expediente == "0"){
        $("#documentFile").addClass("hide");
        $(".boxDocument").removeClass("hide");
        $(".iframeEmpty").addClass("stylesEmpty");
        $(".iframeEmpty").removeClass("hide");
        $(".iframeEmpty").html("<div class='container-fluid h-100 p-0'><div class='w-100 h-100 d-flex justify-center align-center boxDocumentEmptyD'><div class='boxEmpty'><center><i class='fas fa-search'></i></center><br><p>Todavía no se carga ningún documento<p></div></div></div>");
    }else{
        $("#documentFile").removeClass("hide");
        $(".iframeEmpty").addClass("hide");
        $(".boxDocument").removeClass("hide");
        let url = getDocumentPath(tipo_doc, expediente, idDocumento, idCliente, lugar_prospeccion);
        $('#documentFile').attr('src', url);
    }

    $('#documentName').append('<h4 class="m-0 overflow-text" data-toggle="tooltip" data-placement="top" title="'+name+'">' + expediente + '</h4>');

    
    let deletePermission = '';
    let vdPermission = '';
    let validatePermission = '';
    let label = '';
    let detail = '';
    let rejectReasons = '';

    if (documentType != 7 && documentType != 8 && fileName != "0") {
        if (estatus_validacion == 0) { // SIN VALIDAR
            validatePermission = '<button type="button" class="btnDocuments addRemoveFile" data-action="5" data-idLote="' + idLote + '" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-name="' + name + '"><i class="fas fa-thumbs-up"></i></button><button type="button" class="btnDocuments addRemoveFile" data-action="4" data-idLote="' + idLote + '" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-name="' + name + '"><i class="fas fa-thumbs-down"></i></button>';
        } else if (estatus_validacion == 1) { // ACEPTADO
            validatePermission = '<button type="button" class="btnDocuments addRemoveFile" data-action="5" style="color:#28B463" data-idLote="' + idLote + '" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-name="' + name + '"><i class="fas fa-thumbs-up"></i></button><button class="btnDocuments addRemoveFile" type="button" data-action="4" data-idLote="' + idLote + '" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-name="' + name + '"><i class="fas fa-thumbs-down"></i></button>';
        } else if (estatus_validacion == 2) { // RECHAZADO
            $.each(rejectReasons, function (i, v) {
                rejectReasons += '<small><i class="material-icons">close</i>' + v.motivo + '</small><br>';
            });
            validatePermission = '<button type="button" class="btnDocuments addRemoveFile" data-action="5" data-idLote="' + idLote + '" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-name="' + name + '"><i class="fas fa-thumbs-up"></i></button><button type="button" class="btnDocuments addRemoveFile" style="color: #CB4335" data-action="4" data-idLote="' + idLote + '" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-name="' + name + '"><i class="fas fa-thumbs-down"></i></button>';
        }
    }

    if (fileName != "0")
        detail = '<button type="button" class="btnDocuments modalInfo" data-toggle="modal" data-target="#modalInfo" data-username="' + userName + '" data-lastmodify="' + lastModify + '" data-rejections="' + rejectReasons + '"><i class="fas fa-info"></i></button>';
    else label = '<label class="lbl-gral lbl-gray small">Documento no cargado<label>';

    if (documentType == 7) {
        if (fileName == "0") {
            vdPermission = '<button type="button" class="btnDocuments addRemoveFile" data-action="1" data-idLote="' + idLote + '" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-name="' + name + '"><i class="fas fa-cloud-upload-alt"></i></button>';
        } else {
            label = '';
            vdPermission = '<button type="button" class="btnDocuments addRemoveFile" data-action="3" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-file="' + fileName + '" data-name="' + name + '"><i class="fas fa-cloud-download-alt"></i></button>';
            if (userPermissions == 1) deletePermission = '<button type="button" class="btnDocuments addRemoveFile" data-action="2" data-idLote="' + idLote + '" data-idDocumento="' + idDocumento + '" data-documentType="' + documentType + '" data-name="' + name + '"><i class="fas fa-trash-alt"></i></button>';
        }
    }
    
    $("#boxOptions").append('' +
        label +
        vdPermission +
        deletePermission +
        validatePermission +
        detail +'');
        
    $('[data-toggle="tooltip"]').tooltip();
});

function getDocumentPath(type, file, idDocumento, idCliente, prospecting_place) {
    let folder = "";
    let url = "";

    if (type == 7) folder = "static/documentos/cliente/corrida/"; // CORRIDA
    else if (type == 8) folder = "static/documentos/cliente/contrato/"; // CONTRATO
    else if (type == 30) folder = "asesor/deposito_seriedad/" + idCliente + "/1/"; // DS NEW AND ACTUAL VERSIÓN
    else if (type == 31) folder = "asesor/deposito_seriedad_ds/" + idCliente + "/1/"; // DS OLD VERSION
    else if (type == 33) folder = prospecting_place == "6" ? "clientes/printProspectInfoMktd/" + idDocumento : "clientes/printProspectInfo/" + idDocumento; // LEAD
    else if (type == 34) folder = "static/documentos/evidencia_mktd/" + idCliente; // MKTD EVIDENCE
    else folder = "static/documentos/cliente/expediente/";
    if(type != 30 && type != 31 && type != 33)
        url = general_base_url + folder + file;
    else
        url = general_base_url + folder;
    return url;
}

$(document).on("click", ".addRemoveFile", function (e) {
    e.preventDefault();
    let idDocumento = $(this).attr("data-idDocumento");
    let documentType = $(this).attr("data-documentType");
    let action = $(this).data("action");
    let documentName = $(this).data("name");
    $("#idLote").val($(this).attr("data-idLote"));
    $("#idDocumento").val(idDocumento);
    $("#documentType").val(documentType);
    $("#docName").val(documentName);
    $("#action").val(action);
    if (action == 1 || action == 2 || action == 4) {
        document.getElementById("mainLabelText").innerHTML = action == 1 ? "Selecciona el archivo que desees asociar a <b>" + documentName + "</b>" : action == 2 ? "¿Estás seguro de aliminar el archivo <b>" + documentName + "</b>?" : "Selecciona los motivos de rechazo que asociarás al documento <b>" + documentName + "</b>.";
        document.getElementById("secondaryLabelDetail").innerHTML = action == 1 ? "El documento que hayas elegido se almacenará de manera automática una vez que des clic en <i>Guardar</i>." : action == 2 ? "El documento se eliminará de manera permanente una vez que des clic en <i>Guardar</i>." : "Los motivos de rechazo que selecciones se registrarán de manera permanente una vez que des clic en <i>Guardar</i>.";
        if(action == 1) { // ADD FILE
            $("#selectFileSection").removeClass("hide");
            $("#rejectReasonsSection").addClass("hide");
            $("#txtexp").val("");
        } else if(action == 2) { // REMOVE FILE
            $("#selectFileSection").addClass("hide");
            $("#rejectReasonsSection").addClass("hide");
        } else { // REJECT FILE
            filterSelectOptions(documentType);
            $("#selectFileSection").addClass("hide");
            $("#rejectReasonsSection").removeClass("hide");
        }

        $("#addDeleteFileModal").modal("show");
    } else if(action == 3) {
        let fileName = $(this).attr("data-file");
        let url = getDocumentPath(documentType, fileName, 0, 0, 0);
        window.location.href = url;
        alerts.showNotification("top", "right", "El documento <b>" + documentName + "</b> se ha descargado con éxito.", "success");
    } else if(action == 5) {
        $("#sendRequestButton").click();
    }
});

$(document).on("click", "#sendRequestButton", function (e) {
    e.preventDefault();
    let action = $("#action").val();
    let sendRequestPermission = 0;
    if (action == 1){ // UPLOAD FILE
        let uploadedDocument = $("#uploadedDocument")[0].files[0];
        let validateUploadedDocument = (uploadedDocument == undefined) ? 0 : 1;
        // SE VALIDA QUE HAYA SELECCIONADO UN ARCHIVO ANTES DE LLEVAR A CABO EL REQUEST
        if (validateUploadedDocument == 0) alerts.showNotification("top", "right", "Asegúrate de haber seleccionado un archivo antes de guardar.", "warning");
        else sendRequestPermission = 1; // PUEDE MANDAR EL REQUEST PORQUE SÍ HAY ARCHIVO SELECCIONADO
    } else if (action == 4){
        let rejectionReasons = $("#rejectionReasons").val();
        if (rejectionReasons == ''){ // THERE ARE NO OPTIONS
            alerts.showNotification("top", "right", "Asegúrate de haber seleccionado al menos un motivo de rechazo", "warning");
        } else sendRequestPermission = 1;
    }else sendRequestPermission = 1; // DELETE FILE

    if (sendRequestPermission == 1) {
        let idLote = $("#idLote").val();
        let data = new FormData();
        data.append("idLote", idLote);
        data.append("idDocumento", $("#idDocumento").val());
        data.append("documentType", $("#documentType").val());
        data.append("uploadedDocument", $("#uploadedDocument")[0].files[0]);
        data.append("rejectionReasons", $("#rejectionReasons").val());
        data.append("action", action);
        let documentName = $("#docName").val();
        $('#uploadFileButton').prop('disabled', true);
        $.ajax({
            url: action == 1 ? "uploadFile" : action == 2 ? "deleteFile" : "validateFile",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (response) {
                $("#sendRequestButton").prop("disabled", false);
                if (response == 1) {
                    getDocumentsInformation(idLote);
                    alerts.showNotification("top", "right", action == 1 ? "El documento " + documentName + " se ha cargado con éxito." : action == 2 ? "El documento " + documentName + " se ha eliminado con éxito." : action == 4 ? "Los motivos de rechazo se han asociado de manera exitosa para el documento " + documentName + "." : "El documento " + documentName + " se ha sido validado correctamente.", "success");
                    $("#addDeleteFileModal").modal("hide");
                } else if (response == 0) alerts.showNotification("top", "right", "Oops, algo salió mal.", "warning");
                else if (response == 2) alerts.showNotification("top", "right", "No fue posible almacenar el archivo en el servidor.", "warning");
                else if (response == 3) alerts.showNotification("top", "right", "El archivo que se intenta subir no cuenta con la extención .xlsx", "warning");
            }, error: function () {
                $("#sendRequestButton").prop("disabled", false);
                alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
            }
        });
    }
});

function filterSelectOptions(documentType) {
    $("#rejectionReasons option").each(function() {
        if ($(this).attr("data-type") === documentType) {
            $(this).show();
        } else {
            $(this).hide();
        }
        $('select').val(documentType);
    });
    $("#rejectionReasons option:selected").prop("selected", false);
    $("#rejectionReasons").trigger('change');
    $("#rejectionReasons").selectpicker('refresh');
}

$(document).on("click", ".list-group-item", function () {
    $('#documentsList a').removeClass('activeSB');
    $(this).addClass('activeSB');
});

$(document).on("click", ".modalInfo", function (e) {
    $("#modalInfo .modal-body").html('');
    let userName =  $(this).attr("data-username");
    let lastModify = $(this).attr("data-lastModify");
    let rejections = $(this).attr("data-rejections");
    
    $("#modalInfo .modal-body").append('<div class="container-fluid"><div class="row"><div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex mb-1"><i class="fas fa-user fa-lg"></i><p class="m-0 mr-2 ml-2">'+userName+'</p></div><div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex mb-1"><i class="fas fa-clock fa-lg"></i><p class="m-0 mr-2 ml-2">'+lastModify+'</p></div></div></div>');
});

function getLotes_escrituracion(idCondominio, idResidencial){
    $('#spiner-loader').removeClass('hide');
    $("#lotes_escrituracion").empty().selectpicker('refresh');
    $.ajax({
        url: `${general_base_url}registroCliente/getLotesAsesor/${idCondominio}/${idResidencial}`,
        type: 'post',
        dataType: 'json',
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#lotes_escrituracion").append($('<option>').val(response[i]['idLote']).text(response[i]['nombreLote']));
            }
            $("#lotes_escrituracion").selectpicker('refresh');
        }
    });
}

function getResidenciales_escrituracion() {
    $('#spiner-loader').removeClass('hide');
    $("#residenciales_escrituracion").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getResidencialesList',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#residenciales_escrituracion").append($('<option>').val(response[i]['idResidencial']).attr('data-empresa', response[i]['empresa']).text(response[i]['descripcion']));
            }
            $("#residenciales_escrituracion").selectpicker('refresh');
        }
    });
}

function getCondominios_escrituracion(idResidencial) {
    $('#spiner-loader').removeClass('hide');
    $("#condominios_escrituracion").empty().selectpicker('refresh');
    $.ajax({
        url: general_base_url + 'General/getCondominiosList',
        type: 'post',
        dataType: 'json',
        data: {
            "idResidencial": idResidencial
        },
        success: function (response) {
            $('#spiner-loader').addClass('hide');
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $("#condominios_escrituracion").append($('<option>').val(response[i]['idCondominio']).text(response[i]['nombre']));
            }
            $("#condominios_escrituracion").selectpicker('refresh');
        }
    });
}

function mostrarVisualizadorDocumentos(){
    if($("#residenciales_escrituracion").val() != '' && $("#condominios_escrituracion").val() != '' && $("#lotes_escrituracion").val() != ''){
        $(".fakeBox").addClass("hide");
        $(".realBox").removeClass("hide");
    }
    else{
        $(".fakeBox").removeClass("hide");
        $(".realBox").addClass("hide");
    }
}