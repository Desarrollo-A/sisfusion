<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
<div class="wrapper">

    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal" tabindex="-1" role="dialog" id="notificacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="p-0 text-center" id="mainLabelText">Asegúrate que los campos <b>Proyecto</b>, <b>Condominio</b> y <b>Lote</b> tengan al menos un valor seleccionado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="uploadModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="text-center">Selección de archivo a cargar</h5>
                    <div class="file-gph">
                        <input class="d-none" type="file" id="fileElm">
                        <input class="file-name" id="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                        <label class="upload-btn m-0" for="fileElm"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" id="cargaCoincidencias" data-toggle="modal">Cargar</button>
                </div>
            </div>
        </div>
    </div>

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
                                <h3 class="card-title center-align">Reporte por lotes (CRM)</h3>
                                <div class="row aligned-row">
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group label-floating select-is-empty m-0 p-0">
                                            <select id="residenciales" name="residenciales" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group label-floating select-is-empty m-0 p-0">
                                            <select id="condominios" name="condominios" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" data-actions-box="true" title="SELECCIONA UNA OPCIÓN" data-container="body" data-size="7" required multiple></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="form-group label-floating select-is-empty m-0 p-0">
                                            <select id="lotes" name="lotes" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" data-actions-box="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required multiple onchange="cleanSelects(3)"></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                        <div class="radio_container w-100">
                                            <input class="d-none generate" type="radio" name="radio" id="one">
                                            <label for="one" class="w-50">Cargar</label>
                                            <input class="d-none find-results" type="radio" name="radio" id="two">
                                            <label for="two" class="w-50">Consultar</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-2 row-load hide">
                                    <div class="col col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                        <div class="form-group label-floating select-is-empty m-0 p-0">
                                            <select id="columns" name="columns" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona las columnas que se requieran" data-size="10" required multiple></select>
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-center justify-evenly">
                                        <button class="btn-rounded btn-s-greenLight" id="downloadFile" name="downloadFile" title="Download"><i class="fas fa-download"></i></button>
                                        <button class="btn-rounded btn-s-blueLight" name="uploadFile" id="uploadFile" title="Upload" data-toggle="modal" data-target="#uploadModal"><i class="fas fa-upload"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group closeTable" id="closeTable" name="closeTable">
                                <table id="tableLotificacion" name="tableLotificacion" class="table-striped table-hover hide">
                                    <thead>
                                        <tr>
                                            <th>CLIENTE</th>
                                            <th>LOTE</th>
                                            <th>SUPERFICIE</th>
                                            <th>PRECIO POR M2</th>
                                            <th>TOTAL</th>
                                            <th>FECHA DE CONTRATO</th>
                                            <th>FECHA DE FIRMA</th>
                                            <th>ADENDUM</th>
                                            <th>SUPERFICIE CONTRATO</th>
                                            <th>COSTO POR M2</th>
                                            <th>PARCELA</th>
                                            <th>SUPERFICIE PROYECTOS</th>
                                            <th>PRESUPUESTO DE OBRA</th>
                                            <th>PRESUPUESTO A PLAZOS</th>
                                            <th>$ M2 TERRENO</th>
                                            <th>COSTO TERRENO</th>
                                            <th>UNIDAD</th>
                                            <th>CALLE EXACTA</th>
                                            <th># EXTERIOR</th>
                                            <th>CODIGO POSTAL</th>
                                            <th>COLONIA</th>
                                            <th>FOLIO REAL</th>
                                            <th>OBSERVACIONES</th>
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

<?php $this->load->view('template/footer'); ?>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services_dr.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/contabilidad/contabilidad.js"></script>
</body>