<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">

        <?php $this->load->view('template/sidebar'); ?>
    
        <div class="modal" tabindex="-1" role="dialog" id="uploadModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="text-center">Selección de archivo a cargar</h5>
                        <div class="file-gph">
                            <input class="d-none" type="file" id="archivo">
                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                            <label class="upload-btn m-0" for="archivo"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="cargaCoincidencias" data-toggle="modal">Cargar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editMontoInternomex" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                        <h4 class="modal-title">Monto internomex</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group label-floating div_name">
                                        <input id="monto" name="monto"  onchange="validateInputs(this);" type="text" class="form-control input-gral" required>
                                    </div>
                                    <div class="form-group label-floating div_name" hidden>
                                        <input id="id_pago" name="id_pago"  onchange="validateInputs(this);" type="text" class="form-control input-gral" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-end">
                                    <button type="button" class="btn btn-danger btn-simple mt-1" data-dismiss="modal">Cancelar</button>
                                    <button id="aceptarMonto" name="aceptarMonto" class="btn btn-primary mt-1">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="changesBitacora" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons" onclick="cleanComments()">clear</i></button>
                        <h4 class="modal-title">Consulta información</h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
                                <li role="presentation" class="active">
                                    <a href="#changelogUsersTab" aria-controls="changelogUsersTab" role="tab" data-toggle="tab">Bitácora de cambios</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active"
                                    id="changelogUsersTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content">
                                                    <ul class="timeline timeline-simple" id="changelogUsers"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

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
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">PROYECTO</label>
                                                    <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0"
                                                            data-style="btn" data-show-subtext="true"  title="Selecciona un proyecto"
                                                            data-size="7" data-live-search="true" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="form-group label-floating select-is-empty">
                                                    <label class="control-label">CONDOMINIO</label>
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
    <script type="text/javascript" src="<?= base_url() ?>dist/js/xlsx/xlsx.full.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/jwt/hmac-sha256.js"></script>
    <script src="<?= base_url() ?>dist/js/jwt/enc-base64-min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/Contabilidad/cargaFolios.js"></script>
</body>