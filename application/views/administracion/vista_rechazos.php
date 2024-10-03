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
								<i class="fas fa-box fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
									<h3 class="card-title center-align" data-i18n="reporte-rechazos">Reporte rechazos </h3>
								</div>
								<div class="material-datatables"> 
									<div class="form-group">
										<table class="table-striped table-hover" id="tabla_reporte_11" name="tabla_reporte_11">
											<thead>
												<tr>
													<th>proyecto</th>
													<th>condominio</th>
													<th>lote</th>
													<th>id-lote</th>
													<th>cliente</th>
													<th>fecha-apartado</th>
													<th>estatus-contratacion</th>
													<th>estatus-lote</th>
													<th>quien-rechazo</th>
													<th>fecha-rechazo</th>
													<th>motivo-rechazo</th>
													<th>movimiento</th>
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
	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/administracion/vista_rechazos.js"></script>
</body>