<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>
        <!-- BEGUIN Modals -->
        <div class="modal" tabindex="-1" role="dialog" id="uploadModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5 class="text-center">Selección de archivo a cargar</h5>
                        <div class="file-gph">
                            <input class="d-none" type="file" id="fileElm">
                            <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                            <label class="upload-btn m-0" for="fileElm">
                                <span>Seleccionar</span>
                                <i class="fas fa-folder-open"></i>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="cargaCoincidencias" data-toggle="modal">Cargar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- INICIO Modal editar monto internomex -->
        <div class="modal fade" id="editMontoInternomex" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
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
                                    <button type="button" class="btn btn-danger btn-simple mt-1" data-dismiss="modal">Cancelar
                                    </button>
                                    <button id="aceptarMonto" name="aceptarMonto" class="btn btn-primary mt-1">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN Modal editar monto internomex -->

        <!-- INICIO Modal para bitácora -->
        <div class="modal fade" id="changesBitacora" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">
                            <i class="material-icons" onclick="cleanComments()">clear</i>
                        </button>
                        <h4 class="modal-title">Consulta información</h4>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist"
                                style="background: #003d82;">
                                <li role="presentation" class="active">
                                    <a href="#changelogUsersTab" aria-controls="changelogUsersTab" role="tab" data-toggle="tab">Bitácora de cambios</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
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
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-coins fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <?php if ($this->session->userdata('id_rol') == 31) { ?>
                                        <h3 class="card-title center-align">Asignación de monto final pagado</h3>
                                        <p class="center-align">A través de este panel podrás descargar una plantilla que agrupara por comisionista los n pagos enviados para cobro. De los cuales, se tendrá que ingresar el monto final pagado.</p>
                                    <?php } else { ?>
                                        <h3 class="card-title center-align">Consulta pago final</h3>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h7>A través de este panel podrás consultar el monto final pagado en cada corte de comisiones. Por mes se guardará un solo registro, el módulo precargará la información encontrada en el año corriente. En caso de querer consultar una fecha en particular, podrás hacerlo a través de los filtros situados en la parte superior derecha (a partir del corte del mes de diciembre del 2022 se podrá acceder a esta información).</h7>
                                        </div>
                                        <?php } ?>

                                    <?php if($this->session->userdata('id_rol') == 31){?>
                                        <div class="row aligned-row pb-3" id="tipo_pago_selector">
                                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label class="control-label">Tipo de pago (<span class="isRequired">*</span>)</label>
                                                <select class="selectpicker select-gral m-0" title="SELECCIONA UNA OPCIÓN"
                                                        id="tipo_accion" onchange="validaTipoPago(this.value)">
                                                    <option value="1">PAGO DE LOTES</option>
                                                    <option value="2">PAGO SUMA</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }?>

                                    <div class="row aligned-row">
                                        <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="radio_container w-100">
                                                <?php if ($this->session->userdata('id_rol') == 31) { ?>
                                                    <input class="d-none generate" type="radio" disabled="true" id="one" checked>
                                                    <label for="one" class="w-50" disabled="true" id="cargarLabel" style="background: #bfbfbf !important;cursor: not-allowed">Cargar</label>
                                                    <input class="d-none find-results" type="radio" disabled="true" id="two">
                                                    <label for="two" class="w-50">Consultar</label>
                                                <?php } else { ?>
                                                    <input class="d-none" type="radio" name="radio" id="one" disabled>
                                                    <label for="one" class="w-50" disabled>Cargar</label>
                                                    <input class="d-none find-results" type="radio" name="radio" id="two">
                                                    <label for="two" class="w-50" checked>Consultar</label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class=" form-group d-flex col-xs-12 col-sm-6 col-md-6 col-lg-6 align-center justify-evenly  box-table hide">
                                            <input type="text" class="form-control datepicker text-center pl-1 beginDate box-table hide" id="beginDate" />
                                            <input type="text" class="form-control datepicker text-center pl-1 endDate box-table hide" id="endDate" />
                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini searchByDateRange box-table hide" name="searchByDateRange" id="searchByDateRange">
                                                <span class="material-icons update-dataTable">search</span>
                                            </button>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 d-flex align-center justify-evenly  row-load hide ">
                                            <button class="btn-rounded btn-s-greenLight row-load hide " id="downloadFile" name="downloadFile" title="Download">
                                                <i class="fas fa-download"></i>
                                            </button> <!-- DOWNLOAD -->
                                            <button class="btn-rounded btn-s-blueLight row-load hide" name="uploadFile" id="uploadFile" title="Upload" data-toggle="modal" data-target="#uploadModal">
                                                <i class="fas fa-upload"></i>
                                            </button> <!-- UPLOAD -->
                                        </div>
                                        
                                    </div>
                                    <div class="row pt-2 hide">
                                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                            <div class="form-group label-floating select-is-empty m-0 p-0">
                                                <select id="columns" name="columns" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona las columnas que se requieran" data-size="10" required multiple>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-table hide">
                                    <table id="tableLotificacion" name="tableLotificacion" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID DEL REGISTRO</th>
                                                <th>NOMBRE</th>
                                                <th>ROL</th>
                                                <th>FORMA DE PAGO</th>
                                                <th>SEDE</th>
                                                <th>MONTO SIN DESCUENTO</th>
                                                <th>MONTO CON DESCUENTO</th>
                                                <th>MONTO DE INTERNOMEX</th>
                                                <th>FECHA DE CAPTURA DEL REGISTRO</th>
                                                <th>COMENTARIO</th>
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
    </div>
    </div>

    <?php $this->load->view('template/footer'); ?>
    <script type="text/javascript" src="<?= base_url() ?>dist/js/xlsx/xlsx.full.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/jwt/hmac-sha256.js"></script>
    <script src="<?= base_url() ?>dist/js/jwt/enc-base64-min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/internomex/internomex.js"></script>
</body>