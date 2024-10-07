
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <?php  $this->load->view('documentacion/documentosModales'); ?> <!--Modales para el manejo de los documentos-->

        <div class="modal fade" id="verAutorizacionesAsesor">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center" data-i18n="autorizaciones">Autorizaciones</h3>
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
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" data-i18n="cerrar"> Cerrar </button>
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
                                        <h3 class="card-title center-align" data-i18n="documentacion-lote">Documentación por lote</h3>
                                        <div class="row">
                                            <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group select-is-empty overflow-hidden">
                                                    <label class="control-label" data-i18n="proyecto">Proyecto</label>
                                                    <select name="idResidencial" data-i18n-label="selecciona-una-opcion" id="idResidencial" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required>
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
                                                <label class="control-label" data-i18n="condominio">Condominio</label>
                                                <select id="idCondominio" data-i18n-label="selecciona-una-opcion" name="idCondominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required></select>
                                            </div>
                                        </div>
                                        <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <div class="form-group select-is-empty overflow-hidden">
                                                <label class="control-label" data-i18n="lote">Lote</label>
                                                <select id="idLote" data-i18n-label="selecciona-una-opcion" name="idLote" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container='body' required></select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                <?php } ?>
                                <?php if (isset($tipoFiltro)) { ?>
                                <?php if ($tipoFiltro == 1) { ?>
                                    <div class="toolbar">
                                        <h3 class="card-title center-align" data-i18n="documentacion-lote">Documentación por lote</h3>
                                        <div class="row">
                                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label" data-i18n="proyecto">Proyecto</label>
                                                    <select name="idResidencial" data-i18n-label="selecciona-una-opcion" id="idResidencial" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un proyecto" data-size="7" required>
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
                                                    <label class="control-label" data-i18n="condominio">Condominio</label>
                                                    <select data-i18n-label="selecciona-una-opcion" id="idCondominio" name="idCondominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un condominio" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label" data-i18n="lote">Lote</label>
                                                    <select id="idLote" data-i18n-label="selecciona-una-opcion" name="idLote" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un lote" data-size="7" required></select>
                                                </div>
                                            </div>
                                            <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group select-is-empty">
                                                    <label class="control-label" data-i18n="cliente">Cliente</label>
                                                    <select id="idCliente" data-i18n-label="selecciona-una-opcion" name="idCliente" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un cliente" data-size="7" required></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($tipoFiltro == 2) { ?>
                                    <div class="toolbar">
                                        <h3 class="card-title center-align" data-i18n="documentacion-lote">Documentación por lote</h3>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label label-gral" data-i18n="id-lote">ID lote</label>
                                                    <input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <div class="form-group">
                                                    <button type="submit" class="btn-gral-data find_doc" data-i18n="buscar">Buscar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } } ?>
                                <table id="tableDoct" class="table-striped table-hover hide">
                                    <thead>
                                        <tr>
                                            <th>proyecto</th>
                                            <th>condominio</th>
                                            <th>lote</th>
                                            <th>id-lote</th>
                                            <th>cliente</th>
                                            <th>asesor</th>
                                            <th>coordinador</th>
                                            <th>gerente</th>
                                            <th>subdirector</th>
                                            <th>director-regional</th>
                                            <th>director-regional2</th>
                                            <th>nombre-documento</th>
                                            <th>hora-fecha</th>
                                            <th>responsable</th>
                                            <th>ubicacion</th>
                                            <th>acciones</th>
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
    <script src="<?= base_url() ?>dist/js/controllers/documentacion/documentacion.js?=1.1.2"></script>
</body>