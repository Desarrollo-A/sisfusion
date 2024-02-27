<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h4 class="modal-title">¿Qué acción desea realizar?</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="card card-plain">
									<div class="card-content">
										<form method="post" id="form_rl">
    										<div class="row">
        										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            										<div class="form-group overflow-hidden">
                										<label class="control-label">OPCIÓN</label>
                										<select name="opciones" id="opciones" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group overflow-hidden">
														<select name="representante" id="representante" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group overflow-hidden">
														<select name="tipoVenta" id="tipoVenta" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<select name="sedes" id="sedes" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
													</div>
												</div>
												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<input class="form-control input-gral" id="impuesto" type="number" name="impuesto">
													</div>
												</div>
											</div>
											<!-- rep = Representante Legal CRUD-->
											<div class="row">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group overflow-hidden">
														<select name="repData" id="repData" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
													</div>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group overflow-hidden">
														<select name="repEstatus" id="repEstatus" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
															<option value="0">INACTIVO</option>
															<option value="1">ACTIVO</option>
														</select>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<input class="form-control input-gral m-0" placeholder="Ingrese el nombre" required value=''  id="nombre_rep" type="text" name="nombre_rep">
													</div>
												</div>
												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<input class="form-control input-gral m-0" placeholder="Ingrese el apellido paterno" required value='' id="paterno_rep" type="text" name="paterno_rep">
													</div>
												</div>
												<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<input class="form-control input-gral m-0" placeholder="Ingrese el apellido materno" required value='' id="materno_rep" type="text" name="materno_rep">
													</div>
												</div>
											</div>
										
											<input type="hidden" name="idCliente" id="idCliente" value="">
                            				<input type="hidden" name="idLote" id="idLote" value="">
										</form>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
						<button type="button" id="btn_upt" class="btn btn-gral-data">GUARDAR</button>
                    </div>
				</div>
			</div>
		</div>

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon fa-2x" data-background-color="goldMaderas"><i class="fas fa-box"></i></div>
							<div class="card-content">
								<h3 class="card-title center-align">Inventario de lotes</h3>
								<div class="toolbar">
									<div class="row">
										<div class="col-6 col-sm-6 col-md-4 col-lg-4">
											<div class="form-group">
												<label class="control-label label-gral">Lote</label>
												<input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
											</div>
										</div>
										<div class="col-6 col-sm-6 col-md-4 col-lg-4 mt-3">
											<div class="form-group">
												<button type="button" class="btn-gral-data find_doc"> Buscar </button>
											</div>
										</div>
										<div class="col-6 col-sm-6 col-md-4 col-lg-4 mt-3">
											<div class="form-group">
												<button class="btn-rounded btn-s-greenLight apply-action" id="moreOptions" name="moreOptions" title="Más opciones"><i class="fas fa-plus"></i></button>
											</div>
										</div>
									</div>				
								</div>
								<div class="material-datatables">
                                    <div class="form-group">
										<table class="table-striped table-hover hide" id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">
											<thead>
												<tr>
													<th>PROYECTO</th>
													<th>CONDOMINIO</th>
													<th>IDLOTE</th>
													<th>LOTE</th>
													<th>CLIENTE</th>
													<th>FECHA APARTADO</th>
													<th>REPRESENTANTE LEGAL</th>
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

		<div class="modal fade modal-alertas" id="myModalUpdate" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="title_option">¿Realmente desea actualizar el dato?</h4>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger btn-simple" id="cancelar" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary" id="actualizarBtn" data-dismiss="modal">ACEPTAR<div class="ripple-container"></div></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/administracion/master_view.js"></script>
</body>