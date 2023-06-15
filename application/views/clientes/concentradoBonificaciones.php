<body>
<div class="wrapper">
	<?php $this->load->view('template/ventas_pr/sidebar'); ?>
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
									<div class="header text-center">
										<h3 class="title">Concentrado de Bonificaciones</h3>
										<p class="category hide">Lorem ipsue honasg juklas fumpos llorsma asiup miupn aubc
										</p>
									</div>
									<div class="container-fluid">
										<div class="row">
											<table id="tableDoct" class="table table-bordered table-hover" width="100%"
												   style="text-align:center;">
												<thead>
												<tr>
													<th class="text-center"></th>
													<th class="text-center"><small style="font-size: small">Recomendado por:</small><br>Cliente </th>
													<th class="text-center">Lote</th>
													<th class="text-center">Fecha Primer Pago</th>
													<th class="text-center"><small style="font-size: small">Recomendado:</small><br>Cliente </th>
													<th class="text-center">Lote</th>
													<th class="text-center">Fecha Primer Pago</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>
														<a href="#">
															<span class="material-icons">control_point</span>
														</a>
													</td>
													<td>jlkk</td>
													<td>lkjlk</td>
													<td>lkjlk</td>
													<td>ljllkjl</td>
													<td>asdpo</td>
													<td>zcbnfds</td>
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
