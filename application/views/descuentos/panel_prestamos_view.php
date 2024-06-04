<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<body>
<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>
<?php $this->load->view('descuentos/complementos/estilosPrestamos_comple'); ?>
<?php $this->load->view('descuentos/complementos/panel_prestamos_modal'); ?>

	<div class="content boxContent">
		
		<div class="container-fluid">
			<div class="row "  style="margin-bottom: 2px">
			
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
					<div class="card">
					
						<div class="right-align" 
								style="text-align: right; padding-top:12px; padding-right: 15px; padding-left: 20px " >
								<i class="fas fa-gear fa-2x "id="confiMotivo" name="configMotivo"  onclick="configMotivo()"
									style=" color: #103f75;" title="Ajuste Evidencia">
								</i>
						</div>
						<h3 class="h3 card-title center-align">Préstamos y penalizaciones</h3>	
						
						<div class="row">
						<?php $this->load->view('descuentos/complementos/dash_panel_prestamos_comple'); ?>
						
						</div>
						<div class="card-content">
							<div class="toolbar">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 m-0">
                                            <div class="form-group d-flex justify-center align-center">
                                            </div>
											
                                        </div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-1">
                                            <div class="form-group d-flex justify-center align-center">
                                            </div>
                                        </div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-1">
                                            <div class="form-group d-flex justify-center align-center">
                                            </div>
                                        </div>
                                    </div>
									
									<div class="row">
										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group d-flex justify-center align-center">
												<button Type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">
												<i class="fas fa-coins"></i>	
												Agregar Préstamo</button>
											</div>
										</div>

										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <div class="form-group d-flex justify-center align-center">
												<button Type="button"  class="btn-gral-data" 
													id="abrir_modal_plantillas" name="abrir_modal_plantillas"
													data-toggle="modal" data-target="#modal_plantilla_descuentos">
												<i class="fas fa-folder-open"></i>	
												Plantilla Préstamos</button>
											</div>
										</div>
										<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <div class="form-group d-flex justify-center align-center">
												<button Type="button"  class="btn-gral-data" 
													id="abrir_ejecutar" name="modal_ejecutar"
													data-toggle="modal" data-target="#modal_ejecutar">
												
												<i class="fas fa-terminal"></i>	
												Ejecutar función</button>
											</div>
										</div>
										


										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <div class="form-group d-flex justify-center align-center">
												<buttons Type="button"  class="data" data-toggle="modal" data-target="#ModalAddMotivo"><i class="fas fa-plus"></i> Nuevo motivo de préstamo</buttons>
											</div>
										</div>
									</div>	
									<div class="row">
										<?php $this->load->view('descuentos/complementos/rangoFechas'); ?>
									</div>	
                                </div>
                            </div>
							<div class="material-datatables">
								<div class="form-group">
									<table class="table-striped table-hover" id="tabla_prestamos" name="tabla_prestamos">
										<thead>
												<tr>
													<th>ID PRÉSTAMO</th>
													<th>ID USUARIO</th>
													<th>USUARIO</th>
													<th>MONTO</th>
													<th>NÚMERO</th>
													<th>PAGO CORRESPONDIENTE</th>
													<th>ABONADO</th>
													<th>PENDIENTE</th>
													<th>COMENTARIO</th>
													<th>COMENTARIO</th>
													<th>ESTATUS</th>
													<th>TIPO</th>
													<th>FECHA DE REGISTRO</th>
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
		</div>
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
		
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
	</div>
	<?php $this->load->view('template/footer');?>
	
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/comisiones/general/funcionesGeneralesComisiones.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/descuentos/panel_prestamos.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/descuentos/complementos/dash_panel_prestamos_comple.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>dist/js/xlsx/xlsx.full.min.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/general/main_services.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/descuentos/complementos/plantilla_prestamos.js"></script>
	<script type="text/javascript">
		Shadowbox.init();
		var fechaServer = '<?php echo date('Y-m-d H:i:s')?>';
	</script>
	
</body>