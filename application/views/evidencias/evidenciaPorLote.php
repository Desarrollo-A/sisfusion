<link href="<?= base_url() ?>dist/css/evidenciasRecisiones.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">


<body class="">
<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="content recisiones">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <div class="toolbar">
                                <h3 class="card-title center-align">Generar link para cargar evidencia</h3>
                                <div class="row">
									<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<div class="form-group label-floating select-is-empty">
											<label class="control-label">Proyectos</label>
											<select name="residenciales" id="residenciales" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
										</div>
									</div>
								    <div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									    <div class="form-group label-floating select-is-empty">
											<label class="control-label">Condominios</label>
											<select id="condominios" name="condominios" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
										</div>
									</div>
									<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<div class="form-group label-floating select-is-empty">
											<label class="control-label">Lotes</label>
										    <select id="lotes" name="lotes" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
										</div>
									</div>
								</div>
                                <div id="basic_info" class="row hide">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="card miniCard">
                                            <div class="container-fluid">
                                                <div class="boxInfo">
                                                    <p class="m-0">Evidencia <span class="evidencia enfatize"></span></p>
                                                    <div id="evidencia" class="mb-2 hide">
                                                        <p id="view" class="mb-1">Ver evidencia <i class="fas fa-eye"></i></p>
                                                        <span id="evidencia_validacion" class="estatus"><span>
                                                    </div>
                                                    <div id="generate" class="row hide">
                                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                            <button><i class="fas fa-link"></i>&nbsp;Generar URL</button>
                                                        </div>
                                                        <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                                                            <input id="url" type="text" disabled></input>
                                                        </div>
                                                        <div id="copy_button" class="col-12 col-sm-12 col-md-2 col-lg-2 p-0 hide">
                                                            <i class="fas fa-copy iconCopy" title="Copiar" data-toggle="tooltip" data-placement="right"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="card miniCard">
                                            <div class="container-fluid">
                                                <div class="boxInfo">
                                                    <p class="titleMini m-0">Nombre</p>
                                                    <p class="nombreCl data"></p>
                                                    <input id="nombreCl" type="hidden"></input>
                                                    <p class="titleMini m-0">Asesor</p>
                                                    <p class="nombreAs data"></p>
                                                    <input id="nombreAs" type="hidden"></input>
                                                    <p class="titleMini m-0">Fecha apartado</p>
                                                    <p class="fechaApartado data"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="card miniCard">
                                            <div class="container-fluid">
                                                <div class="boxInfo">
                                                    <div class="montos d-flex justify-between">
                                                        <div class="w-50">
                                                            <p class="titleMonto m-0">Precio de lote</p>
                                                            <p class="monto w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="$1,051,193.47"></p>
                                                        </div>
                                                        <div class="w-50">
                                                            <p class="titleMonto m-0">Enganche validado</p>
                                                            <p class="enganche w-100 overflow-text" data-toggle="tooltip" data-placement="top" title="$95,563.04"></p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="mb-1 w-50">
                                                            <p class="titleMini m-0 mt-1">Estatus lote</p>
                                                            <p class="estatus_lote w-90 overflow-text"></p>
                                                        </div>
                                                        <div class="mb-1 w-50">
                                                            <p class="titleMini m-0 mt-1">Estatus comisión</p>
                                                            <p class="estatus_comision w-90 overflow-text"></p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-1">
                                                        <p class="titleMini m-0">Estatus contratación</p>
                                                        <p class="estatus_contratacion w-100 overflow-text"></p>
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="idLote"></input>
                                <input type="hidden" id="idCliente"></input>
                                <input type="hidden" id="nombreResidencial"></input>
                                <input type="hidden" id="nombreCondominio"></input>
                                <input type="hidden" id="nombreLote"></input>
                                <input type="hidden" id="fechaApartado"></input>
                                <input type="hidden" id="videoNombre"></input>
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
<?php include 'common_modals.php' ?>
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<script>
    let typeTransaction = 0; // MJ: SELECTS MULTIPLES
</script>
<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/evidencias/evidencias.js"></script>
</body>