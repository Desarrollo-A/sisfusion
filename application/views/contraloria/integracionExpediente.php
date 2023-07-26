<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php  $this->load->view('template/sidebar'); ?>
		<!--Contenido de la página-->
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-bookmark fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
									<div class="row">
										<h3 class="card-title center-align">Reporte integración de expediente</h3>
										<p class="card-title pl-1" id="showDate"></p>
									</div>
                                </div>
								<div class="toolbar">
									<div class ="row">
										<div class="col-sm-12 col-md-12 col-lg-12">
											<div class="container-fluid p-0">
												<div class="row d-flex justify-end">
													<div class="col-md-6 p-r">
														<div class="form-group d-flex is-empty ">
															<input type="text" class="form-control datepicker" id="beginDate" />
															<input type="text" class="form-control datepicker" id="endDate"/>
															<button class="btn btn-success btn-round btn-fab btn-fab-mini"id="searchByDateRange">
																<span class="material-icons update-dataTable">search</span>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
                                </div>
								<div class="material-datatables">
                                    <div class="form-group">
										<div class="form-group">
											<table id="Jtabla" class="table-striped table-hover">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>GERENTE</th>
														<th>COORDINADOR</th>
														<th>ASESOR</th>
														<th>USUARIO</th>
														<th>FECHA MOV.</th>
														<th>COMENTARIO </th>
														<th>FECHA DE MOVIMIENTO </th>
														<th>FECHA DE VENCIMIENTO </th>
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
		</div>
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div><!--main-panel close-->
	<?php $this->load->view('template/footer');?>
	<!--DATATABLE BUTTONS DATA EXPORT-->
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
	<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/contraloria/integracionExpediente.js"></script>
	<script src="<?=base_url()?>dist/js/funciones-generales.js"></script>
	<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
	<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
	<script src="<?= base_url() ?>dist/js/es.js"></script>
	<!-- DateTimePicker Plugin -->
	<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>

</body>
