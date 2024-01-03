<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-expand fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
									<h3 class="card-title center-align">Reporte de lotes bloqueados</h3>
								</div>
								<div  class="toolbar">
									<div class="row">
									</div>
								</div>
								<div class="material-datatables">
									<table  id="tablaLotesBloqueados" name="tablaLotesBloqueados" class="table-striped table-hover">
										<thead>
											<tr>
												<th>PROYECTO</th>
												<th>CONDOMINIO</th>
												<th>LOTE</th>
												<th>ID LOTE</th>
												<th>SUPERFICIE</th>
												<th>PRECIO M2</th>
												<th>TOTAL</th>
												<th>REFERENCIA</th>
												<th>COMENTARIO</th>
												<th>FECHA DE BLOQUEO</th>
												<th>BLOQUEADO PARA</th>
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
		<?php $this->load->view('template/footer_legend');?> 
	</div>
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/caja/reporteLotesBloqueados.js"></script>