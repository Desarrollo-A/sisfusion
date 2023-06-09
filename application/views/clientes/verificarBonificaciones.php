<body>
<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>

	<div class="content">
		<div class="container-fluid">

			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="block full">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header card-header-icon" data-background-color="goldMaderas">
									<i class="material-icons">list</i>
								</div>
								<div class="card-content">
                                    <h4 class="card-title">Verificar bonificaciones</h4>
                                    <div class="header text-center">
<!--										<h3 class="title">Verificar Bonificaciones</h3>-->
<!--										<p class="category hide">Lorem ipsue honasg juklas fumpos llorsma asiup miupn aubc-->
										</p>
									</div>
									<div class="container-fluid">
										<div class="row">
											<table id="tableDoct" class="table table-bordered table-hover" width="100%"
												   style="text-align:center;">
												<thead>
												<tr>
													<th class="text-center"></th>
													<th class="text-center">Gestor</th>
													<th class="text-center">Titular</th>
													<th class="text-center">Recomendado</th>
													<th class="text-center">Observaciones</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>
														<a href="#">
															<span class="material-icons">control_point</span>
														</a>
													</td>
													<td>MARÍA DE JESÚS GARDUÑO</td>
													<td>JESSICA SOFÍA MORALES BUSTAMANTE</td>
													<td>MARÍA JOSÉ MARTÍNEZ</td>
													<td>EL CLIENTE HA SIDO RECOMENDADO</td>
												</tr>
												</tbody>

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
</body>
<?php $this->load->view('template/footer');?>
<!--<script src="<?=base_url()?>dist/js/controllers/asesor/prospects-list-1.1.0.js"></script>-->

<script>
	$(document).ready(function() {
		$('#tableDoct').DataTable({
			destroy: true,
			/*"ajax":
				{
					"url": '<?=base_url()?>index.php/registroCliente/#',
					"dataSrc": ""
				},*/
			"dom": "Bfrtip",
			"buttons": [
				{
					extend: 'copyHtml5',
					text: '<i class="fa fa-files-o"></i>',
					titleAttr: 'Copy'
				},
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'csvHtml5',
					text: '<i class="fa fa-file-text-o"></i>',
					titleAttr: 'CSV'
				},
				{
					extend: 'pdfHtml5',
					text: '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					orientation: 'landscape',
					pageSize: 'LEGAL'
				}
			],
			"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"columns":
				[
					{},
					{data: 'nombreLote'},
					{data: 'nombreResidencial'},
					{data: 'nombre'},
					{}
				]
		});
	});
</script>

</html>
