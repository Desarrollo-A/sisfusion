<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar', $datos); ?>

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
									<h3 class="card-title center-align">Reporte rechazos </h3>
								</div>
								<div class="material-datatables"> 
									<div class="form-group">
										<table class="table-striped table-hover" id="tabla_reporte_11" name="tabla_reporte_11">
											<thead>
												<tr>
													<th>PROYECTO</th>
													<th>CONDOMINIO</th>
													<th>LOTE</th>
													<th>ID LOTE</th>
													<th>CLIENTE</th>
													<th>FECHA DE APARTADO</th>
													<th>ESTATUS DE CONTRATACIÓN</th>
													<th>ESTATUS DEL LOTE</th>
													<th>QUIEN RECHAZO</th>
													<th>FECHA DE RECHAZO</th>
													<th>MOTIVO DE RECHAZO</th>
													<th>MOVIMIENTO</th>
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
	<script src="<?= base_url() ?>dist/js/controllers/administracion/vista_rechazos.js"></script>

</body>