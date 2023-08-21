<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
					</div>
					<div class="modal-body">
						<div role="tabpanel">
							<ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
								<li role="presentation" class="active"><a href="#changeprocesTab" aria-controls="changeprocesTab" role="tab" onclick="javascript:$('#verDet').DataTable().ajax.reload();"	data-toggle="tab">Proceso de contratación</a></li>
								<li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab" onclick="javascript:$('#verDetBloqueo').DataTable().ajax.reload();">Liberación</a></li>
								<li role="presentation"><a href="#coSellingAdvisers" aria-controls="coSellingAdvisers" role="tab" data-toggle="tab" onclick="javascript:$('#seeCoSellingAdvisers').DataTable().ajax.reload();">Asesores venta compartida</a></li>
								<?php 
								$id_rol = $this->session->userdata('id_rol');
								if($id_rol == 11){
								echo '<li role="presentation"><a href="#tab_asignacion" aria-controls="tab_asignacion" role="tab" data-toggle="tab" onclick="fill_data_asignacion();">Asignación</a></li>';
								}
								?>
								<li role="presentation" class="hide" id="li_individual_sales"><a href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab" data-toggle="tab">Clausulas</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="changeprocesTab">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<table id="verDet" class="table-striped table-hover">
														<thead>
															<tr>
																<th>LOTE</th>
																<th>STATUS</th>
																<th>DETALLES</th>
																<th>COMENTARIO</th>
																<th>FECHA</th>
																<th>USUARIO</th>
															</tr>
														</thead>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="changelogTab">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<table id="verDetBloqueo" class="table-striped table-hover">
														<thead>
															<tr>
																<th>LOTE</th>
																<th>PRECIO</th>
																<th>FECHA DE LIBERACIÓN</th>
																<th>COMENTARIO DE LIBERACIÓN</th>
																<th>USUARIO</th>
															</tr>
														</thead>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="coSellingAdvisers">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<table id="seeCoSellingAdvisers" class="table-striped table-hover">
														<thead>
															<tr>
																<th>ASESOR</th>
																<th>COORDINADOR</th>
																<th>GERENTE</th>
																<th>FECHA DE ALTA</th>
																<th>USUARIO</th>
															</tr>
														</thead>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="tab_asignacion">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<div class="form-group">
														<label for="des">Desarrollo</label>
														<select name="sel_desarrollo" id="sel_desarrollo" class="selectpicker" data-style="btn btn-second" data-show-subtext="true" data-live-search="true"  title="" data-size="7" required>
														<option disabled selected>Selecciona un desarrollo</option></select>
													</div>
													<div class="form-group"></div>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="check_edo">
														<label class="form-check-label" for="check_edo">Intercambio</label>
													</div>
													<div class="form-group text-right">
														<button type="button" id="save_asignacion" class="btn btn-primary">ENVIAR</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="salesOfIndividuals">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<h4 id="clauses_content"></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
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
									</div>				
								</div>
								<div class="material-datatables">
                                    <div class="form-group">
										<table class="table-striped table-hover hide" id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">
											<thead>
												<tr>
													<th>PROYECTO</th>
													<th>CONDOMINIO</th>
													<th>LOTE</th>
													<th>ID LOTE</th>
													<th>SUPERFICIE</th>
													<th>TOTAL</th>
													<th>TOTAL DESCUENTO</th>
													<th>PRECIO M<sup>2</sup></th>
													<th>REFERENCIA</th>
													<th>MESES SIN INTERESES</th>
													<th>ASESOR</th>
													<th>COORDINADOR</th>
													<th>GERENTE</th>
													<th>ESTATUS</th>
													<th>APARTADO</th>
													<th>COMENTARIO</th>
													<th>LUGAR DE PROSPECCIÓN</th>
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
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/contratacion/inventarioByLote.js"></script>
</body>