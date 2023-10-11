<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-user-friends fa-2x"></i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align">Remplazo contrato</h3>
								<div class="toolbar">
									<div class="container-fluid p-0">
										<div class="row">
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden">
												<div class="form-group">
													<label class="m-0" for="filtro3">Proyecto</label>
													<select name="filtro3" id="filtro3" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
														<?php
														if($residencial != NULL) :
															foreach($residencial as $fila) : ?>
																<option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
															<?php endforeach;
														endif;
														?>
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden ">
												<div class="form-group">
													<label class="m-0" for="filtro4">Condominio</label>
													<select id="filtro4" name="filtro4" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body"></select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4 overflow-hidden ">
												<div class="form-group">
													<label class="m-0" for="filtro5">Lote</label>
													<select id="filtro5" name="filtro5" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body"></select>
												</div>
											</div>
										</div>
									</div>	
								</div>
								<div class="material-datatables">
									<div class="form-group">
										<table id="tableDoct" class="table-striped table-hover hide">
											<thead>
												<tr>
													<th>PROYECTO</th>
													<th>CONDOMINIO</th>
													<th>LOTE</th>
													<th>CLIENTE</th>
													<th>NOMBRE DE DOCUMENTO</th>
													<th>HORA/FECHA</th>
													<th>DOCUMENTO</th>
													<th>RESPONSABLE</th>
													<th>UBICACIÓN</th>
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
	</body>
	<?php $this->load->view('template/footer');?>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/juridico/vista_documentacion_juridico.js"></script>


