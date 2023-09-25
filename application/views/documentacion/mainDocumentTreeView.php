<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/documentTree.css" rel="stylesheet"/>
<body id="mainBody">
    <div class="wrapper ">  
        <?php $this->load->view('template/sidebar'); ?>

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
                            <div class="card-content">
                                <h3 class="card-title text-center">Documentación</h3>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden">
                                                <select class="selectpicker select-gral m-0" id="residenciales_escrituracion" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un proyecto" data-size="7" data-container="body"></select>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden">
                                                <select class="selectpicker select-gral m-0" id="condominios_escrituracion" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un condominio" data-size="7" data-container="body"></select>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 overflow-hidden">
                                                <select class="selectpicker select-gral m-0" id="lotes_escrituracion" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un lote" data-size="7" data-container="body"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid realBox pt-2 hide">
                                    <div class="row aligned-row">
                                        <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 pr-0">
                                            <div class="panel panel-info">
                                                    <div id="documentsList" class="list-group scrollDocumentTree">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9 pl-0">
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
                                            <div class="w-100 h-100 d-flex justify-center align-center boxDocumentEmpty">
                                                <div class="boxEmpty text-center">
                                                    <i class="fas fa-search"></i>
                                                    <p class="mt-2">Aún no se ha seleccionado ningún archivo<p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid fakeBox pt-2">
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
    <script src="<?= base_url() ?>dist/js/controllers/documentacion/mainDocumentTree.js"></script>
</body>


