<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<body>
	<style>
		.bkIcon{
			background-repeat: no-repeat;
			background-size: auto 70%;
			background-position-x: 100%;
			background-position-y: bottom;
		}
		.iconUno{
			background-image: url(../dist/img/iconUno.png);
		}

		.iconDos{
			background-image: url(../dist/img/iconDos.png);
		}

		.iconTres{
			background-image: url(../dist/img/iconTres.png);
		}
		</style>
<div class="wrapper" id="chartsAmount">
<?php $this->load->view('template/sidebar'); ?>
<?php $this->load->view('descuentos/complementos/estilosPrestamos_comple'); ?>
<?php $this->load->view('descuentos/complementos/panel_prestamos_modal'); ?>

	<div class="content boxContent">
		<div class="container-fluid">
		<div class="row m-auto rowCarousel">
		<div class="w-100 scrollCharts">
			<div class="card p-0 cardMiniChart" id="cardMiniChart">
				<div class="container-fluid bkIcon iconUno">
					<div class="row pl-2 pt-2 pr-2">
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
							<p class="m-0">préstamos<br> <span class="str">ACTIVOS</span></p>
						</div>
					</div>
					<div class="row pl-2 pr-2">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
							<p class="mt-1 money" name="totalp" id="totalp" 
							class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0.00</p>
						</div>
					</div>
					<div class="row">
						<div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
							<div class="boxMiniCharts d-flex justify-center align-start" id="ventasTotales">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card p-0 cardMiniChart" id="cardMiniChart">
				<div class="container-fluid bkIcon iconDos">
					<div class="row pl-2 pt-2 pr-2">
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
							<p class="m-0">total<br> <span class="str">ABONADO</span></p>
						</div>
					</div>
					<div class="row pl-2 pr-2">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
							<p class="mt-1 money" name="totalAbonado" id="totalAbonado" 
							class="h5 totalAbonado mb-0 font-weight-bold text-gray-800 center-align">$0.00</p>
						</div>
					</div>
					<div class="row">
						<div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
							<div class="boxMiniCharts d-flex justify-center align-start" id="ventasContratadas">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card p-0 cardMiniChart" id="cardMiniChart">
				<div class="container-fluid bkIcon iconTres">
					<div class="row pl-2 pt-2 pr-2">
						<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 p-0 info">
							<p class="m-0">total<br> <span class="str">PENDIENTE</span></p>
						</div>
					</div>
					<div class="row pl-2 pr-2">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
							<p class="mt-1 money" name="totalPendiente" id="totalPendiente" 
							class="h5 totalPendiente mb-0 font-weight-bold text-gray-800 center-align">$0.00</p>
						</div>
					</div>
					<div class="row">
						<div class="p-0 col-12 col-sm-12 col-md-12 col-lg-12">
							<div class="boxMiniCharts d-flex justify-center align-start" id="ventasContratadas">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="gradientLeft d-none"></div>
        <div class="gradientRight"></div>
	</div>
			<div class="row">
			
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0">
					<div class="card">
					
						<div class="right-align text-right mt-2 mr-2" style="color:#b9b9b9">
								<i class="fas fa-gear fa-2x "id="confiMotivo" name="configMotivo"  onclick="configMotivo()" title="Ajuste Evidencia">
								</i>
						</div>
						<h3 class="h3 card-title center-align">Préstamos y penalizaciones</h3>	
						
						<div class="card-content">
							<div class="toolbar">
                                <div class="container-fluid p-0">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="form-group d-flex justify-center align-center">
												<button Type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">
												<i class="fas fa-coins"></i>	
												Agregar préstamo</button>
											</div>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="form-group d-flex justify-center align-center">
												<button Type="button"  class="btn-gral-data" 
													id="abrir_modal_plantillas" name="abrir_modal_plantillas"
													data-toggle="modal" data-target="#modal_plantilla_descuentos">
												<i class="fas fa-folder-open"></i>	
												Plantilla préstamos</button>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                            <div class="form-group d-flex justify-center align-center">
												<button Type="button"  class="btn-gral-data" 
													id="abrir_ejecutar" name="modal_ejecutar"
													data-toggle="modal" data-target="#modal_ejecutar">
												
												<i class="fas fa-terminal"></i>	
												Ejecutar función</button>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group d-flex justify-center align-center">
												<buttons Type="button"  class="data" data-toggle="modal" data-target="#ModalAddMotivo"><i class="fas fa-plus"></i> Nuevo motivo de préstamo</buttons>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
											<div class="form-group d-flex">
												<input type="text" class="form-control datepicker" id="beginDate" value="" autocomplete='off' />
												<input type="text" class="form-control datepicker" id="endDate" value="" autocomplete='off' />
												<button class="btn btn-success btn-round btn-fab btn-fab-mini" id="btnTable"><span class="material-icons update-dataTable">search</span></button>
											</div>
										</div>
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

		$(".scrollCharts").scroll(function() {
			var scrollDiv = $(".scrollCharts").scrollLeft();

			if (scrollDiv > 0){
				$(".gradientLeft").removeClass("d-none");
				$(".gradientLeft").addClass("fading");
			}
			else{
				$(".gradientLeft").addClass("d-none");
			}
		});
	</script>
	
</body>