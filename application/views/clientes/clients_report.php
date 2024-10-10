<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-user-friends fa-2x"></i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align" data-i18n="listado-marketing">Listado general de clientes marketing digital</h3>
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
											<table id="clients_report_datatable" class="table-striped table-hover hide">
												<thead>
													<tr>
														<th>proyecto</th>
														<th>condominio</th>
														<th>lote</th>
														<th>id-lote</th>
														<th>cliente</th>
														<th>telefono</th>
														<th>medio</th>
														<th>Plaza</th>
														<th>asesor</th>
														<th>coordinador</th>
														<th>gerente</th>
														<th>subdirector</th>
														<th>director-regional</th>
														<th>director-regional2</th>
														<th>total</th>
														<th>enganche</th>
														<th>plan-enganche</th>
														<th>estatus</th>
														<th>fecha-apartado</th>
														<th>fecha-estatus-15</th>
													</tr>
												</thead>
											</table>
											<?php include 'common_modals.php' ?>
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
	<?php $this->load->view('template/footer');?>
	<script src="<?=base_url()?>dist/js/controllers/clientes/clientesReport.js"></script>
	<script src="<?= base_url() ?>dist/js/modal-steps.min.js"></script>
	<script src="<?= base_url() ?>dist/js/moment.min.js"></script>
	<script src="<?= base_url() ?>dist/js/es.js"></script>
	<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
</body>