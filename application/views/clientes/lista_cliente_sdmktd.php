<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />

<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<div class="modal fade" id="verDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<b><h4 class="card-title text-center">Ventas compartidas</h4></b>
						<table id="verDet" class="table-striped table-hover">
							<thead>
								<tr>
									<th>ASESOR</th>
									<th>COORDINADOR</th>
									<th>GERENTE</th>
									<th>SUBDIRECTOR</th>
									<th>DIRECTOR REGIONAL</th>
									<th>DIRECTOR REGIONAL 2</th>
									<th>FECHA DE ALTA</th>
									<th>USUARIO</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
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
								<h3 class="card-title center-align">Búsqueda detallada de clientes</h3>
								<div class="toolbar">
									<div class="row">
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group">
												<label class="control-label label-gral">Nombre</label>
												<input type="text" class="form-control input-gral" name="nombre" id="nombre">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group">
												<label class="control-label label-gral">Apellido Paterno</label>
												<input type="text" class="form-control input-gral" name="apellido_paterno" id="apellido_paterno">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group">
												<label class="control-label label-gral">Apellido Materno</label>
												<input type="text" class="form-control input-gral" name="apellido_materno" id="apellido_materno">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group">
												<label class="control-label label-gral">Correo</label>
												<input type="email" class="form-control input-gral" name="correo" id="correo">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group">
												<label class="control-label label-gral">Teléfono</label>
												<input type="text" class="form-control input-gral" name="telefono" id="telefono">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-3">
											<div class="form-group">
												<button class="btn-gral-data d-flex justify-center align-center" id="buscarBtn"><span class="material-icons">search</span>Buscar</button>
											</div>
										</div>
									</div>
								</div>
								<br>
								<div class="material-datatables">
									<div class="form-group">
										<table class="table-striped table-hover" id="tabla_clientes" name="tabla_clientes">
											<thead>
												<tr>
													<th>MÁS</th>
													<th>ID LOTE</th>
													<th>PROYECTO</th>
													<th>CONDOMINIO</th>
													<th>LOTE</th>
													<th>CLIENTE</th>
													<th>NÚMERO DE RECIBO</th>
													<th>TIPO DE PAGO</th>
													<th>FECHA DE APARTADO</th>
													<th>ENGANCHE</th>
													<th>FECHA DE ENGANCHE</th>
													<th>ASESOR</th>
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
		<?php $this->load->view('template/footer_legend'); ?>
	</div>
	</div>
	<?php $this->load->view('template/footer'); ?>
	<script src="<?= base_url() ?>dist/js/modal-steps.min.js"></script>
	<?php if ($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5) { ?>
		<script src="<?= base_url() ?>dist/js/controllers/general-1.1.0.js"></script>
	<?php } ?>
	<script src="<?=base_url()?>dist/js/controllers/clientes/lista_cliente_sdmktd.js"></script>
</body>