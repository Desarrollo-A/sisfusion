
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
        <?php
		    //se debe validar que tipo de perfil esta sesionado para poder asignarle el tipo de sidebar
		    if(in_array($this->session->userdata('id_rol'), array(2, 3, 4, 5, 6, 7, 9, 11, 12, 13, 15, 16, 28, 32, 33, 34, 39, 50, 40, 53, 58, 65, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 55, 17, 73, 70, 71, 47)))
                $this->load->view('template/sidebar');
            else
                echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
		?>
        <!-- Modals -->
        <div class="modal fade" id="addDeleteFileModal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body text-center">
                        <h5 id="mainLabelText"></h5>
                        <p id="secondaryLabelDetail"></p>
                        <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                            <div class="hide" id="selectFileSection">
                                <div class="file-gph">
                                    <input class="d-none" type="file" id="fileElm">
                                    <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                                    <label class="upload-btn m-0" for="fileElm">
                                        <span>Seleccionar</span>
                                        <i class="fas fa-folder-open"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <input type="text" class="hide" id="idLoteValue">
                        <input type="text" class="hide" id="idDocumento">
                        <input type="text" class="hide" id="tipoDocumento">
                        <input type="text" class="hide" id="nombreDocumento">
                        <input type="text" class="hide" id="tituloDocumento">
                        <input type="text" class="hide" id="accion">
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="sendRequestButton" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- autorizaciones-->
        <div class="modal fade" id="verAutorizacionesAsesor">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center">Autorizaciones</h3>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div id="auts-loads">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cerrar </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modals -->
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Documentación por lote</h3>
                                    <div class="row">
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group select-is-empty overflow-hidden">
                                                <label class="control-label">Proyecto</label>
                                                <select name="idResidencial" id="idResidencial" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required>
                                                    <?php
													if ($residencial != NULL) :
														foreach ($residencial as $fila) : ?>
                                                    <option value=<?= $fila['idResidencial'] ?>>
                                                        <?= $fila['nombreResidencial'] ?> </option>
                                                    <?php endforeach;
													endif;
													?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group select-is-empty overflow-hidden">
                                                <label class="control-label">Condominio</label>
                                                <select id="idCondominio" name="idCondominio" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group select-is-empty overflow-hidden">
                                                <label class="control-label">Lote</label>
                                                <select id="idLote" name="idLote" class="selectpicker select-gral m-0"
                                                    data-style="btn" data-show-subtext="true" data-live-search="true"
                                                    title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table id="tableDoct" class="table-striped table-hover hide">
                                    <thead>
                                        <tr>
                                            <th>PROYECTO</th>
                                            <th>CONDOMINIO</th>
                                            <th>LOTE</th>
                                            <th>ID LOTE</th>
                                            <th>CLIENTE</th>
                                            <th>ASESOR</th>
                                            <th>COORDINADOR</th>
                                            <th>GERENTE</th>
                                            <th>SUBDIRECTOR</th>
                                            <th>DIRECTOR REGIONAL</th>
                                            <th>DIRECTOR REGIONAL 2</th>
                                            <th>NOMBRE DE DOCUMENTO</th>
                                            <th>HORA/FECHA</th>
                                            <th>RESPONSABLE</th>
                                            <th>UBICACIÓN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    <!--main-panel close-->

    <?php $this->load->view('template/footer');?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/documentacion/documentacion.js"></script>
</body>