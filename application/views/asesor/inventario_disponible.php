<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar');?>
		
		<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" data-i18n="clausulas">Cláusulas</h4>
					</div>
					<div class="modal-body"> 
						<h4 id="clauses_content" class="modal-title">  <b id="nomLoteHistorial"></b></h4>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR</button>
					</div>
				</div>
			</div>
		</div>
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<?php
                                    if(in_array($this->session->userdata('id_rol'), array(7, 9, 3, 2, 1, 6, 5, 4))) {
                                ?>
                                    <a href="https://youtu.be/cfRUmAdELkU" class="align-center justify-center u2be" target="_blank">
                                        <i class="fab fa-youtube p-0" rel="tooltip" data-placement="top" title="Tutorial" style="font-size:25px!important"></i>
                                    </a>
                                <?php
                                    } else {
                                ?>
                                    <i class="fas fa-box"></i>
                                <?php
                                    }
                                ?>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
									<h3 class="card-title center-align" data-i18n="inventario-disponible">Inventario disponible</h3>
									<p class="card-title pl-1"></p>
								</div>
								<div class="toolbar">
									<div class="row">
										<form id="formFilters">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 overflow-hidden">
												<div class="form-group">
													<label class="control-label" data-i18n="proyecto">Proyecto</label>
													<select name="filtro3" id="filtro3" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  data-live-search="true" data-size="7" data-container="body" required>
														<option value="0" data-i18n="selecciona-todo">SELECCIONA TODO</option>
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden">
												<div class="form-group  ">
													<label class="control-label" data-i18n="condominio-2">Condominio</label>
													<select id="filtro4" name="filtro4" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  data-live-search="true" multiple data-size="7" data-container="body" required></select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden">
												<div class="form-group">
													<label class="control-label" data-i18n="grupo">Grupo</label>
													<select name="filtro5" id="filtro5" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" data-size="7" data-container="body" required>	
														<option value="1"> < 200m2 </option>
														<option value="2"> >= 200 y < 300 </option>
														<option value="3"> >= 300m2 </option>
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 overflow-hidden">
												<div class="form-group ">
													<label class="control-label" data-i18n="superficie-2">Superficie</label>
													<select class="selectpicker select-gral m-0" id="filtro6" name="filtro6[]" data-style="btn btn-primary" data-show-subtext="true" data-live-search="true" data-size="7" data-container="body" required multiple>
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 overflow-hidden">
												<div class="form-group ">
													<label class="control-label" data-i18n="precio-m2">Precio por m<sup>2</sup></label>
													<select	class="selectpicker select-gral m-0"  id="filtro7" name="filtro7[]" data-style="btn btn-primary" data-show-subtext="true" data-live-search="true" data-size="7" data-container="body" required multiple></select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 overflow-hidden">
												<div class="form-group ">
													<label class="control-label" data-i18n="precio-total">Precio total</label>
													<select	class="selectpicker select-gral m-0"  id="filtro8" name="filtro8[]" data-style="btn btn-primary" data-show-subtext="true" data-live-search="true" data-size="7" data-container="body" required multiple></select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3 overflow-hidden">
												<div class="form-group ">
													<label class="control-label" data-i18n="meses-sin-intereses">Meses S/N</label>
													<select	class="selectpicker select-gral m-0" id="filtro9" name="filtro9[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" data-size="7" data-container="body" required multiple></select>
												</div>
											</div>
										</form>
									</div>
								</div>
								<table id="addExp" class="table-striped table-hover hide">
									<thead>
										<tr>
											<th>proyecto</th>
											<th>condominio-2</th>
											<th>lote</th>
											<th>superficie-2</th>
											<th>precio-m2</sup></th>
											<th>precio-total</th>
											<th>meses-sin-intereses</th>
											<th>tipo-de-venta</th>
											<th>acciones</th>
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
	<script src="<?=base_url()?>dist/js/controllers/asesores/inventario_disponible.js"></script>
</body>