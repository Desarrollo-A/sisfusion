
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
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
                                    <label class="upload-btn m-0" for="fileElm"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
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
        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <?php
                                    if(in_array($this->session->userdata('id_rol'), array(7, 9, 3, 2, 1, 6, 5, 4))) {
                                ?>
                                    <a href="https://youtu.be/1zcshxE2nP4" class="align-center justify-center u2be" target="_blank">
                                        <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                    </a>
                                <?php
                                    } else {
                                ?>
                                    <i class="fas fa-user-friends fa-2x"></i>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="card-content">
                                <?php if (!isset($tipoFiltro)) { ?>
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
                                                <select id="idCondominio" name="idCondominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required></select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group select-is-empty overflow-hidden">
                                                <label class="control-label">Lote</label>
                                                <select id="idLote" name="idLote" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required></select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                <?php } ?>
                                <?php if ($tipoFiltro == 1) { ?>
                                    <div class="toolbar">
                                        <h3 class="card-title center-align">Documentación por lote</h3>
                                        <div class="row">
                                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Proyecto</label>
                                                    <select name="idResidencial" id="idResidencial" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un proyecto" data-size="7" required>
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
                                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Condominio</label>
                                                    <select id="idCondominio" name="idCondominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un condominio" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Lote</label>
                                                    <select id="idLote" name="idLote" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un lote" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label">Cliente</label>
                                                    <select id="idCliente" name="idCliente" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un cliente" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($tipoFiltro == 2) { ?>
                                    <div class="toolbar">
                                        <h3 class="card-title center-align">Documentación por lote</h3>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label label-gral">ID lote</label>
                                                    <input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <div class="form-group">
                                                    <button type="submit" class="btn-gral-data find_doc">Buscar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
    <?php $this->load->view('template/footer');?>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script type="text/javascript">
        const tieneAcciones = <?=$tieneAcciones?>;
        const funcionVista = "<?=$funcionVista ?? ''?>";
    </script>
    <script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/documentacion/documentacion.js"></script>
</body>