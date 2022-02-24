<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php
        $datos = array();
        $datos = $datos4;
        $datos = $datos2;
        $datos = $datos3;
        $this->load->view('template/sidebar', $datos);
        ?>

        <style>
            #documentFile {
                max-width: 100%;
                max-height: 100%;
                width: 100%;
                height: 700px;
            }
        </style>

        <!-- Modals -->
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
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title text-center">Documentación</h3>
                                <div class="toolbar">
                                <?php $this->load->view('template/filterLotes'); ?>
                                </div>
                                <!--chris es el mejor de todos-->
                                <div class="row">
                                    <div class="well">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"></div>
                                                    <div id="documentsList" class="list-group"></div>
                                                </div> <!-- navPanel -->
                                            </div> <!-- left column -->
                                            <div class="col-md-9"> <!-- right column -->
                                                <div class="panel panel-info">
                                                    <div id="documentName" class="panel-heading"></div>
                                                    <div id="documentContent" class="panel-body">
                                                        <iframe id="documentFile"></iframe>
                                                    </div>
                                                </div> <!-- contentViewer -->
                                            </div> <!-- rightCol -->
                                        </div> <!-- row -->
                                    </div> <!-- container -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
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
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services_dr.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script>
        let url = "<?=base_url()?>";
        let typeTransaction = 1; // MJ: SELECTS MULTIPLES
    </script>
    <script>
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

            getRejectionReasons();
        });

        function getRejectionReasons() {
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

        $('#selectLotes').change(function (e) {
            e.preventDefault();
            getDocumentsInformation($(this).val());
        });

        function getDocumentsInformation(idLote) {
            cleanElement("documentsList");
            $.ajax({
                type: 'POST',
                url: 'getDocumentsInformation',
                data: {
                    'idLote': idLote
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data['documentation'], function (i, v) {
                        fillDocumentsList(v);
                    });
                }, error: function () {
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }

        function fillDocumentsList(v) {
            let deletePermission = '';
            let vdPermission = '';
            let validatePermission = '';
            let label = '';
            let detail = '';
            let rejectReasons = '';
            if (v.documentType == 7) {
                if (v.fileName == "0") {
                    vdPermission = '<i class="material-icons addRemoveFile" data-action="1" data-idLote="' + v.idLote + '" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-name="' + v.name + '">file_upload</i>';
                } else {
                    label = '';
                    vdPermission = '<i class="material-icons addRemoveFile" data-action="3" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-file="' + v.fileName + '" data-name="' + v.name + '">file_download</i>';
                    if (v.userPermissions == 1) deletePermission = '<i class="material-icons addRemoveFile" data-action="2" data-idLote="' + v.idLote + '" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-name="' + v.name + '">delete</i>';
                }
            } else {
                if (v.fileName != "0") vdPermission = '<i class="material-icons viewDocument" data-file="' + v.fileName + '" data-type="' + v.documentType + '" data-name="' + v.name + '" data-idCliente="' + v.idCliente + '" data-lp="' + v.lugar_prospeccion + '" data-idDocumento="' + v.idDocumento + '">visibility</i>';
            }

            if (v.documentType != 7 && v.documentType != 8 && v.fileName != "0") {
                if (v.estatus_validacion == 0) { // SIN VALIDAR
                    validatePermission = '<i class="material-icons addRemoveFile" data-action="5" data-idLote="' + v.idLote + '" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-name="' + v.name + '">thumb_up</i><i class="material-icons addRemoveFile" data-action="4" data-idLote="' + v.idLote + '" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-name="' + v.name + '">thumb_down</i>';
                } else if (v.estatus_validacion == 1) { // ACEPTADO
                    validatePermission = '<i class="material-icons addRemoveFile" data-action="5" style="color:#28B463" data-idLote="' + v.idLote + '" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-name="' + v.name + '">thumb_up</i><i class="material-icons addRemoveFile" data-action="4" data-idLote="' + v.idLote + '" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-name="' + v.name + '">thumb_down</i>';
                } else if (v.estatus_validacion == 2) { // RECHAZADO
                    $.each(v.rejectReasons, function (i, v) {
                        rejectReasons += '<small><i class="material-icons">close</i>' + v.motivo + '</small><br>';
                    });
                    validatePermission = '<i class="material-icons addRemoveFile" data-action="5" data-idLote="' + v.idLote + '" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-name="' + v.name + '">thumb_up</i><i class="material-icons addRemoveFile" style="color: #CB4335" data-action="4" data-idLote="' + v.idLote + '" data-idDocumento="' + v.idDocumento + '" data-documentType="' + v.documentType + '" data-name="' + v.name + '">thumb_down</i>';
                }
            }

            if (v.fileName != "0")
                detail = '<i class="material-icons" data-toggle="collapse" data-target="#information' + v.idDocumento + '">expand_more</i>' +
                    '<div id="information' + v.idDocumento + '" class="collapse">' +
                    '<span><b><i class="material-icons">face</i></b>' + v.userName + '</span><br>' +
                    '<span><b><i class="material-icons">schedule</i></b>' + v.lastModify + '</span>' +
                    '<div>' +
                    rejectReasons +
                    '<div>'+
                    '</div>';
            else label = 'Documento no cargado';

            $("#documentsList").append('<a class="list-group-item">\n' +
                '        <h4 class="list-group-item-heading">\n' +
                '        <span class="glyphicon glyphicon-file" aria-hidden="true"></span>' + v.name + '</h4>\n' +
                '    <p class="list-group-item-text text-right">\n' +
                label +
                vdPermission +
                deletePermission +
                validatePermission +
                detail +
                '</p>\n' +
                '</a>');
        }

        function cleanElement(e) {
            let element = document.getElementById(e);
            element.innerHTML = '';
        }

        $(document).on("click", ".viewDocument", function () {
            cleanElement("documentName");
            let idDocumento = $(this).attr("data-idDocumento");
            let idCliente = $(this).attr("data-idCliente");
            let name = $(this).attr("data-name");
            let file = $(this).attr("data-file");
            let type = $(this).attr("data-type");
            let lp = $(this).attr("data-lp");
            $('#documentName').append('<h4>' + name + '</h4>');
            let url = getDocumentPath(type, file, idDocumento, idCliente, lp);
            $('#documentFile').attr('src', url);
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

    </script>
</body>
