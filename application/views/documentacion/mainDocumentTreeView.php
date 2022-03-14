<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/documentTree.css" rel="stylesheet"/>
<body id="mainBody">
    <div class="wrapper ">
        
        <?php
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;
        $this->load->view('template/sidebar', $datos);
        ?>

        <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center">Detalle de movimientos</h3>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addDeleteFileModal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="mainLabelText"></h5>
                        <p id="secondaryLabelDetail"></p>
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
                                <select class="selectpicker" data-style="btn btn-primary btn-round" title="Selecciona un motivo de rechazo" data-size="7" id="rejectionReasons" data-live-search="true" multiple></select>
                            </div>
                        </div>
                        <input type="text" class="hide" id="idLote">
                        <input type="text" class="hide" id="idDocumento">
                        <input type="text" class="hide" id="documentType">
                        <input type="text" class="hide" id="docName">
                        <input type="text" class="hide" id="action">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card mb-0 cardDocument">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title text-center">Documentación</h3>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                <select class="selectpicker select-gral" data-style="btn btn-primary btn-round" title="Selecciona un proyecto" data-size="7" id="residenciales" data-live-search="true"></select>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                <select class="selectpicker select-gral" data-style="btn btn-primary btn-round" title="Selecciona un condominio" data-size="7" id="condominios" data-live-search="true"></select>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                                <select class="selectpicker select-gral" data-style="btn btn-primary btn-round" title="Selecciona un lote" data-size="7" id="lotes" data-live-search="true"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid realBox pt-1 hide">
                                    <div class="row">
                                        <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 pr-0">
                                            <div class="panel panel-info">
                                                    <div id="documentsList" class="list-group scrollDocumentTree">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                            <div class="boxDocument hide">
                                                <div class="container-fluid p-0">
                                                    <div class="row aligned-row pr-3 pl-3 pt-1">
                                                        <div class="col-6 col-sm-6 col-md-9 col-lg-9 d-flex align-center">
                                                            <div id="documentName" class="w-100"></div>
                                                        </div>
                                                        <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                                                            <div id="boxOptions" class="d-flex justify-end"></div>
                                                        </div>
                                                    </div>
                                                    <div id="documentContent" class="panel-body p-0">
                                                        <div class="fileOPtions"></div>
                                                        <iframe id="documentFile" class="border-none w-100 scroll-styles"></iframe>
                                                        <div class="iframeEmpty hide"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container-fluid p-0">
                                                <div class="w-100 h-100 d-flex justify-center align-center boxDocumentEmpty hide">
                                                    <div class="boxEmpty">
                                                        <center><i class="fas fa-search"></i></center>
                                                        <br>
                                                        <p>Aún no se ha seleccionado ningún archivo<p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid fakeBox pt-1">
                                    <div class="row h-100">
                                        <div class="col-md-3 col-lg-3 col-xl-3 h-100 documentsList">
                                            <div class="container-fluid">
                                                <div class="row aligned-row pb-2">
                                                    <div class="col-3 col-md-3 text-center">
                                                        <i class="fas fa-folder fa-lg"></i>
                                                    </div>
                                                    <div class="col-9 col-md-9">
                                                    </div>
                                                </div>
                                                <div class="row aligned-row pb-2">
                                                    <div class="col-3 col-md-3 text-center">
                                                        <i class="fas fa-folder fa-lg"></i>
                                                    </div>
                                                    <div class="col-9 col-md-9">
                                                    </div>
                                                </div>
                                                <div class="row aligned-row pb-2">
                                                    <div class="col-3 col-md-3 text-center">
                                                        <i class="fas fa-folder fa-lg"></i>
                                                    </div>
                                                    <div class="col-9 col-md-9">
                                                    </div>
                                                </div>
                                                <div class="row aligned-row pb-2">
                                                    <div class="col-3 col-md-3 text-center">
                                                        <i class="fas fa-folder fa-lg"></i>
                                                    </div>
                                                    <div class="col-9 col-md-9">
                                                    </div>
                                                </div>
                                                <div class="row aligned-row pb-2">
                                                    <div class="col-3 col-md-3 text-center">
                                                        <i class="fas fa-folder fa-lg"></i>
                                                    </div>
                                                    <div class="col-9 col-md-9">
                                                    </div>
                                                </div>
                                                <div class="row aligned-row pb-2">
                                                    <div class="col-3 col-md-3 text-center">
                                                        <i class="fas fa-folder fa-lg"></i>
                                                    </div>
                                                    <div class="col-9 col-md-9">
                                                    </div>
                                                </div>
                                                <div class="row aligned-row pb-2">
                                                    <div class="col-3 col-md-3 text-center">
                                                        <i class="fas fa-folder fa-lg"></i>
                                                    </div>
                                                    <div class="col-9 col-md-9">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-lg-9 col-xl-9 h-100">
                                            <div class="w-100 h-100 d-flex justify-center align-center boxContentDoc">
                                                <div class="boxEmpty">
                                                    <center><i class="fas fa-folder-open"></i></center>
                                                    <p>Aún no se ha seleccionado ningún lote<p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div><!--main-panel close-->

    <?php $this->load->view('template/footer'); ?>

    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services_dr.js"></script>
    <script>
        let url = "<?=base_url()?>";
        let typeTransaction = 1; // MJ: SELECTS MULTIPLES
        var allDocuments = [];
        $(document).ready(function () {
            var allDocuments = [];
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
            getResidenciales();
            //getRejectionReasons();

            // $("#mainBody").addClass("sidebar-mini");
            // $("#sidebarWrapper").removeClass("ps-container ps-theme-default ps-active-x");
            // $("#mainPanel").removeClass("ps-container ps-theme-default ps-active-y");
        });

        $(document).on('change', "#residenciales", function() {
            getCondominios($(this).val());
            $(".boxDocument").removeClass("hide");
        });

        $(document).on('change', "#condominios", function() {
            getLotes($(this).val());
            $(".boxDocument").addClass("hide");
            $(".boxDocumentEmpty").removeClass("hide");
        });

        $('#lotes').change(function (e) {
            e.preventDefault();
            getDocumentsInformation($(this).val());
            $(".boxDocument").addClass("hide");
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
            $(".fakeBox").addClass("hide");
            $(".realBox").removeClass("hide");
            $('#spiner-loader').removeClass('hide');
            $.ajax({
                type: 'POST',
                url: 'getDocumentsInformation',
                data: {
                    'idLote': idLote
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data['documentation'], function (i, v) {
                        fillDocumentsList(v, i);
                        allDocuments.push(v);
                        $('#spiner-loader').addClass('hide');
                    });
                }, error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                    $('#spiner-loader').addClass('hide');
                }
            });
        }

        function fillDocumentsList(v, i) {
                $("#documentsList").append('<a class="list-group-item viewDocument border-none" data-file="' + v.fileName + '" data-type="' + v.documentType + '" data-name="' + v.name + '" data-idCliente="' + v.idCliente + '" data-lp="' + v.lugar_prospeccion + '" data-idDocumento="' + v.idDocumento + '" data-indice="'+i+'">\n' +
                '        <h4 class="list-group-item-heading m-0 w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="' + v.name + '">\n' + '<i class="fas fa-folder mr-1"></i>' + v.name + '</h4></a>');

                $('[data-toggle="tooltip"]').tooltip();
                $(".boxDocumentEmpty").removeClass("hide");
        }
        
        function cleanElement(e) {
            let element = document.getElementById(e);
            element.innerHTML = '';
        }

        $(document).on("click", ".viewDocument", function () {
            $(".boxDocumentEmpty").addClass("hide");
            cleanElement("documentName");
            cleanElement("boxOptions");
            let indice = $(this).attr("data-indice");
            const { documentType, estatus_validacion, fileName, idCliente, idDocumento, idLote, lastModify, lugar_prospeccion, name, userName, userPermissions} = allDocuments[indice];
            if(fileName == "0"){
                $("#documentFile").addClass("hide");
                $(".boxDocument").removeClass("hide");
                $(".iframeEmpty").addClass("stylesEmpty");
                $(".iframeEmpty").removeClass("hide");
                $(".iframeEmpty").html("<div class='container-fluid h-100 p-0'><div class='w-100 h-100 d-flex justify-center align-center boxDocumentEmptyD'><div class='boxEmpty'><center><i class='fas fa-search'></i></center><br><p>Todavía no se carga ningún documento<p></div></div></div>");
            }else{
                $("#documentFile").removeClass("hide");
                $(".iframeEmpty").addClass("hide");
                $(".boxDocument").removeClass("hide");
                let url = getDocumentPath(documentType, fileName, idDocumento, idCliente, lugar_prospeccion);
                $('#documentFile').attr('src', url);
            }

            $('#documentName').append('<h4 class="m-0 overflow-text" data-toggle="tooltip" data-placement="top" title="'+name+'">' + name + '</h4>');

            
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
            let mainPath = "<?=base_url()?>";

            if (type == 7) folder = "static/documentos/cliente/corrida/"; // CORRIDA
            else if (type == 8) folder = "static/documentos/cliente/contrato/"; // CONTRATO
            else if (type == 30) folder = "asesor/deposito_seriedad/" + idCliente + "/1/"; // DS NEW AND ACTUAL VERSIÓN
            else if (type == 31) folder = "asesor/deposito_seriedad_ds/" + idCliente + "/1/"; // DS OLD VERSION
            else if (type == 33) folder = prospecting_place == "6" ? "clientes/printProspectInfoMktd/" + idDocumento : "clientes/printProspectInfo/" + idDocumento; // LEAD
            else if (type == 34) folder = "static/documentos/evidencia_mktd/" + idCliente; // MKTD EVIDENCE
            else folder = "expediente/";
            if(type != 30 && type != 31 && type != 33)
                url = mainPath + folder + file;
            else
                url = mainPath + folder;
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
    </script>
</body>


