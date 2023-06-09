<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar');?>

		<!-- Modals -->
		<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Venta de particulares <b id="nomLoteHistorial"></b></h4>
					</div>

					<div class="modal-body">
						<div role="tabpanel">
							<ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
								<li role="presentation" class="active" id="li_individual_sales"><a href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab" data-toggle="tab">Cláusulas</a></li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="salesOfIndividuals">
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
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END Modals -->

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-box fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
									<h3 class="card-title center-align">Inventario disponible</h3>
									<p class="card-title pl-1"></p>
								</div>
								<div class="toolbar">
									<div class="row">
										<form id="formFilters">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Proyecto</label>
													<select name="filtro3"
															id="filtro3" 
															class="selectpicker select-gral m-0" 
															data-style="btn"
															data-show-subtext="true" 
															data-live-search="true" 
															title="Selecciona una opción" 
															data-size="7"
															required>
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Condominio</label>
													<select id="filtro4"
															name="filtro4[]"
															class="selectpicker select-gral m-0"
															data-style="btn"
															data-show-subtext="true"
															data-live-search="true"
															multiple
															title="Selecciona una opción" 
															data-size="7"
															required>
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Grupo</label>
													<select name="filtro5"
															id="filtro5"
															class="selectpicker select-gral m-0"
															data-style="btn"
															data-show-subtext="true"
															title="Selecciona una opción"
															data-size="7"
															required>
														<option value="1"> < 200m2 </option>
														<option value="2"> >= 200 y < 300 </option>
														<option value="3"> >= 300m2 </option>
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Superficie</label>
														<select class="selectpicker select-gral m-0"
																id="filtro6"
																name="filtro6[]"
																data-style="btn btn-primary"
																data-show-subtext="true"
																data-live-search="true"
																title="Selecciona superficie"
																data-size="7"
																required multiple>
														</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Precio m<sup>2</sup></label>
													<select	class="selectpicker select-gral m-0" 
															id="filtro7"
															name="filtro7[]"
															data-style="btn btn-primary"
															data-show-subtext="true"
															data-live-search="true"
															title="Selecciona una opción"
															data-size="7"
															required
															multiple>
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Precio total</label>
													<select	class="selectpicker select-gral m-0" 
															id="filtro8"
															name="filtro8[]"
															data-style="btn btn-primary"
															data-show-subtext="true"
															data-live-search="true"
															title="Precio total"
															data-size="7"
															required
															multiple></select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Meses S/N</label>
													<select	class="selectpicker select-gral m-0" 
															id="filtro9"
															name="filtro9[]"
															data-style="btn btn-primary "
															data-show-subtext="true"
															data-live-search="true"
															title="Meses sin intereses"
															data-size="7"
															required
															multiple></select>
												</div>
											</div>
											<button class="btn btn-body" type="submit"style="display:none;"></button>
										</form>
									</div>
								</div>
								<div class="table-responsive pdt-30">
									<table id="addExp" class="table-striped table-hover">
										<thead>
											<tr>
												<th>PROYECTO</th>
												<th>CONDOMINIO</th>
												<th>LOTE</th>
												<th>SUP</th>
												<th>PRECIO M<sup>2</sup></th>
												<th>PRECIO TOTAL</th>
												<th>MESES MSI</th>
												<th>TIPO VENTA</th>
												<th>ACCIONES</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
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
	<!--script of the page-->
	<script src="<?=base_url()?>dist/js/controllers/asesores/inventario_disponible.js"></script>
</body>