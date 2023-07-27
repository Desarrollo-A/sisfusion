<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>
		<div class="modal fade" id="change_u" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Cambio de lugar de prospección</label></h4>
					</div>
					<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
						<label class="modal-title" id="tvLbl">Lugar</label>
							<select id="lp" name="lp" class="form-control selectpicker select-gral" title="Selecciona una opción" data-container="body" data-live-search="true" required data-size="7">
								<option value="01 800">01 800</option>
								<option value="Chat">Chat</option>
								<option value="Contacto web">Contacto web</option>
								<option value="Facebook">Facebook</option>
								<option value="Instagram">Instagram</option>
								<option value="Recomendado">Recomendado</option>
								<option value="WhatsApp">WhatsApp</option>
							</select>
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
						<button type="button" id="btn_change_lp" class="btn btn-primary"><span class="material-icons">send</span> </i> Guardar</button>
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
								<i class="fas fa-address-book fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
                                    <h3 class="card-title center-align">Listado de prospectos</h3>
                                    <p class="card-title pl-1">(Cambio de LP)</p>
                                </div>
								<div class="toolbar">
									<div class="container-fluid p-0">
										<div class="row">
											<div class="col-12 col-sm-6 col-md-6 col-lg-6">
												<label class="m-0" for="sede">Sede</label>
												<select name="sede" id="sede" class="selectpicker select-gral" data-live-search="true" data-style="btn " title="SELECCIONA UNA OPCIÓN" data-size="7"></select>
											</div>
											<div class="col-12 col-sm-6 col-md-6 col-lg-6">
												<label class="m-0" for="asesor">Asesor</label>
												<select name="asesor" id="asesor" class="selectpicker select-gral" data-live-search="true" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7"></select>
											</div>
										</div>
									</div>
								</div>
								<div class="material-datatables">
									<div class="form-group">
										<table id="prospects-datatable_dir" class="table-striped table-hover hide">
											<thead>
												<tr>
													<th>ESTADO</th>
													<th>ETAPA</th>
													<th>PROSPECTO</th>
													<th>ASESOR</th>
													<th>COORDINADOR</th>
													<th>GERENTE</th>
													<th>LP</th>
													<th>DETALLE</th>
													<th>CREACIÓN</th>
													<th>VENCIMIENTO</th>
													<th>ACCIÓN</th>
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
	<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
	<script src="<?=base_url()?>dist/js/controllers/clientes/change_lp.js"></script>
</body>