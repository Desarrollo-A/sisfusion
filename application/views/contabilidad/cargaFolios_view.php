<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">

        <?php $this->load->view('template/sidebar'); ?>
    
        <!-- Modal para subir archivos -->
        <div class="modal" tabindex="-1" role="dialog" id="uploadModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="text-center">Selección de archivo a cargar</h5>
                        <div class="file-gph">
                            <input class="d-none" type="file" id="archivo" accept=".xlsx, .xls">
                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionado nada aún" readonly="">
                            <label class="upload-btn m-0" for="archivo"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
                        </div>
                        <span class='pl-1'><b>NOTA:</b> Los lotes ya registrados se omitirán.</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="btnCargaFolios" data-toggle="modal">Cargar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de cambios -->
        <div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Bitácora de cambios</h4>
                    </div>
                    <div class="modal-body">                      
                        <div class="container-fluid" id="changelogTab">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll-styles" style="height: 350px; overflow: auto">
                                    <ul class="timeline-3" id="changelog">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card del datatable -->
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-coins fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Carga de folios</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="col-md-4 form-group">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Proyecto</label>
                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral mt-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un proyecto"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Condominio</label>
                                                    <select name="condominio" id="condominio"  class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un condominio"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-table hide">
                                    <table id="foliosTable" name="foliosTable" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID DEL REGISTRO</th>
                                                <th>ID LOTE</th>
                                                <th>NOMBRE LOTE</th>
                                                <th>CALLE</th>
                                                <th>COLONIA</th>
                                                <th>EXTERIOR</th>
                                                <th>CÓDIGO POSTAL</th>
                                                <th>SUPERFICIE</th>
                                                <th>SUPERFICIE CRM</th>
                                                <th>RÉGIMEN</th>
                                                <th>FOLIO REAL</th>
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
        </div>

    <?php $this->load->view('template/footer_legend'); ?>
    </div>

    <!-- ANIMACIÓN DE CARGA EN TODA LA VISTA -->
    <div class="spiner-loader hide" id="spiner-loader">
        <div class="backgroundLS">
            <div class="contentLS">
                <div class="center-align">
                    Este proceso puede demorar algunos segundos
                </div>
                <div class="inner">
                    <div class="load-container load1">
                        <div class="loader">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer'); ?>

    <!-- OBTENER LA FECHA Y HORA DEL SERVIDOR -->
    <script>
        function fechaServidor() {
            return '<?php echo date('Y-m-d H:i:s')?>';
        }
    </script>
    <script type="text/javascript" src="<?= base_url() ?>dist/js/xlsx/xlsx.full.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/jwt/hmac-sha256.js"></script>
    <script src="<?= base_url() ?>dist/js/jwt/enc-base64-min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script src="<?= base_url() ?>dist/js/core/modal-general.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/Contabilidad/cargaFolios.js"></script>
</body>