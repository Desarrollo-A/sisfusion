<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>
		
		<!--Contenido de la página-->
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-bookmark fa-2x"></i>
                            </div>
							<div class="card-content">
								<h3 class="card-title center-align" id="showDate">Contratos recibidos</h3>
								<div class="toolbar">
									<div class="row">
										<div class="col-12 col-sm-6 col-md-6 col-lg-6">
										</div>
										<div class="col-12 col-sm-6 col-md-6 col-lg-6">
											<div class="container-fluid p-0">
												<div class="row">
													<div class="col-md-12 p-r">
														<div class="form-group d-flex">
															<input type="text" class="form-control datepicker" id="beginDate"/>
                                                            <input type="text" class="form-control datepicker" id="endDate"/>
															<button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange"><span class="material-icons update-dataTable">search</span></button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="material-datatables">
									<table id="Jtabla" class="table-striped table-hover">
										<thead>
											<tr>
												<th>LOTE</th>
												<th>GERENTE(S)</th>
												<th>ASESOR(ES)</th>
												<th>ESTATUS</th>
												<th>DETALLES</th>
												<th>COMENTARIO</th>
												<th>TOTAL NETO</th>
												<th>TOTAL VALIDADO</th>
												<th>FECHA</th>
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
	<script src="<?= base_url() ?>dist/js/modal-steps.min.js"></script>
	<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
	<script src="<?= base_url() ?>dist/js/es.js"></script>
	<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
	<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/contratacion/report_historial.js"></script>
</body>