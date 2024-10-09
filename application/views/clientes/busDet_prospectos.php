<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-address-book fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="row">
									<h3 class="card-title center-align" data-i18n="busqueda-detallda-de-prospectos" >Búsqueda detallada de prospectos</h3>
									<div class="toolbar">
										<div class="container-fluid">
											<div class="row">
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group is-empty m-0">
														<label class="control-label label-gral" data-i18n  ="nombre" >Nombre</label>
														<input type="text" class="form-control input-gral" name="nombre" id="nombre">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group is-empty m-0">
														<label class="control-label label-gral" data-i18n = "apellido-paterno" >Apellido Paterno</label>
														<input type="text" class="form-control input-gral" name="ap_paterno" id="ap_paterno">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group is-empty m-0">
														<label class="control-label label-gral" data-i18n  ="apellido-materno" >Apellido Materno</label>
														<input type="text" class="form-control input-gral" name="ap_materno" id="ap_materno">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group is-empty m-0">
														<label class="control-label label-gral" data-i18n  ="correo">Correo</label>
														<input type="email" class="form-control input-gral" name="correo" id="correo">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group is-empty m-0">
														<label class="control-label label-gral" data-i18n  = "telefono" >Teléfono</label>
														<input type="text" class="form-control input-gral" name="telefono" id="telefono">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group mt-3">
														<div class="row">
															<div class="col-12 col-sm-12 col-md-6 col-lg-6">
																<button class="btn-data-gral btn-s-blue" id="buscarBtn" data-i18n="buscar"><i class="fas fa-search"></i>Buscar</button>
															</div>
															<div class="col-12 col-sm-12 col-md-6 col-lg-6">
																<button class="btn-data-gral btn-s-deepGray"id="ResetForm" type="reset" data-i18n="limpiar-campos"><i class="fas fa-eraser" ></i>Limpiar campos</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>									
								</div>
								<div class="material-datatables">
									<div class="form-group">
										<table id="prospects-datatable_dir" class="table-striped table-hover hide">
											<thead>
												<tr>
													<th>id-prospecto</th>
													<th>estado</th>
													<th>medio</th>
													<th>nombre</th>
													<th>apellido-paterno</th>
													<th>apellido-materno</th>
													<th>asesor</th>
													<th>coordinador</th>
													<th>gerente</th>
													<th>creacion</th>
													<th>vencimiento</th>
													<th>acciones</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
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
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
	<?php $this->load->view('template/footer');?>
	<script>userType = <?= $this->session->userdata('id_rol') ?> ; typeTransaction = 1;</script>
	<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
	<?php if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5 || $this->session->userdata('id_usuario') == 826 || $this->session->userdata('id_usuario') == 1297) { ?>
		<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>
	<?php } ?>
	<script src="<?=base_url()?>dist/js/controllers/clientes/busDet_prospectos.js"></script>
</body>