
$(document).ready(function(){
    Shadowbox.init();
    var newDiv = document.createElement("div");
    newDiv.setAttribute("id", "modalRemove");
    document.body.appendChild(newDiv); 
    newDiv.innerHTML += `<div class="modal fade" id="addDeleteFileModal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body text-center">
                <h5 id="mainLabelText"></h5>
                <p style="font-size: 0.8em" id="secondaryLabelDetail"></p>
                <div class="input-group hide" id="selectFileSection">
                    <label class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            Seleccionar archivo&hellip;<input type="file" name="uploadedDocument" id="uploadedDocument" style="display: none;">
                        </span>
                    </label>
                    <input type="text" class="form-control" id="txtexp" readonly>
                </div>
                <div class="input-group hide" id="rejectReasonsSection">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 pr-0">
                        <select class="selectpicker" data-style="btn btn-primary btn-round"
                                title="Selecciona un motivo de rechazo" data-size="7" id="rejectionReasons"
                                data-live-search="true" multiple></select>
                    </div>
                </div>
                <input type="text" class="hide" id="idLote">
                <input type="text" class="hide" id="idDocumento">
                <input type="text" class="hide" id="documentType">
                <input type="text" class="hide" id="docName">
                <input type="text" class="hide" id="action">
                <input type="text" class="hide" id="tableID">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                <button type="button" id="sendRequestButton" class="btn btn-primary"></button>
            </div>
        </div>
    </div>
    </div>`;
 }); 

$(document).on("click", ".addRemoveFile", function (e) {
        e.preventDefault();

        let idDocumento = $(this).attr("data-idDocumento");
        let documentType = $(this).attr("data-documentType");
        let action = $(this).data("action");
        let documentName = $(this).data("name");
        let tableID = $(this).attr("data-tableID");
        console.log(tableID);

        $("#idLote").val($(this).attr("data-idLote"));
        $("#idDocumento").val(idDocumento);
        $("#documentType").val(documentType);
        $("#docName").val(documentName);
        $("#action").val(action);
        $("#tableID").val(tableID);

        var get = document.getElementById('sendRequestButton');
        action == 1 ? get.innerHTML = 'Cargar':action == 2 ? get.innerHTML = 'Eliminar' :action == 4 ? get.innerHTML = 'Agregar':'';
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
            Shadowbox.open({
                content:    '<div style="height:100%"><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="'+base_url+'static/documentos/cliente/contrato/'+fileName+'"></iframe></div>',
                player:     "html",
                title:      "Visualizando archivo: Contrato",
                width:      985,
                height:     660
            });
            // let url = getDocumentPath(documentType, fileName, 0, 0, 0);
            // window.location.href = url;
            // alerts.showNotification("top", "right", "El documento <b>" + documentName + "</b> se ha descargado con éxito.", "success");
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
            console.log(base_url);
            $.ajax({
                url: action == 1 ? `${base_url}index.php/Documentacion/uploadFile` : action == 2 ? `${base_url}index.php/Documentacion/deleteFile` : `${base_url}index.php/Documentacion/validateFile`,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (response) {
                    $("#sendRequestButton").prop("disabled", false);
                    if (response == 1) {
                        // getDocumentsInformation(idLote);
                        var tableID = $("#tableID").val();
                        console.log();
                        $(`#${tableID}`).DataTable().ajax.reload();
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

    


