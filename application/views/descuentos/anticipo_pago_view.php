<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<style>
    .modal-backdrop {
        z-index: 9;
    }
    .msj {
        z-index: 9999999;
    }
</style>

<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="content boxContent">
                <div class="container-fluid">

                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<ul class="nav nav-tabs nav-tabs-cm" role="tablist">
							<li class="active"><a href="#anticipo_pago" role="tab" data-toggle="tab">Tabla</a></li>
							<li ><a href="#anticipo_adelantos" role="tab" data-toggle="tab">Enviar evidencia</a></li>
						</ul>

                        <div class="card no-shadow m-0 border-conntent__tabs">
                            <div class="card-content p-0">
								<div class="nav-tabs-custom">
									<div class="tab-content p-2">
										<div class="tab-pane active" id="anticipo_pago">
										<div class="text-center">
                                            <h3 class="card-title center-align">Historial Adelantos</h3>
                                        </div>
											<div class="material-datatables">
												<div class="form-group">
													<table class="table-striped table-hover" id="tabla-anticipo" name="tabla-anticipo">
														<thead>
															<tr>
																<th>ID</th>
																<th>USUARIO</th>
																<th>PUESTO</th>
																<th>SEDE</th>
															</tr>
														</thead>
													</table>
												</div>
											</div>
										</div>
										<?php $this->load->view('descuentos/anticipo_pago_evidencia_view'); ?>
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
    <script src="<?= base_url() ?>dist/js/controllers/descuentos/anticipo_pago.js"></script>
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
</body>

