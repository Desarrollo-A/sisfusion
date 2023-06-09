<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php  $this->load->view('template/sidebar'); ?>

		<!--Contenido de la página-->
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-bookmark fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
                                    <h3 class="card-title center-align">Reporte integración de expediente</h3>
                                    <p class="card-title pl-1" id="showDate"></p>
                                </div>
								<div class="material-datatables">
                                    <div class="form-group">
										<div class="material-datatables">
											<div class="form-group">
												<div class="table-responsive">
													<div id="external_filter_container18"><B> Filtrar por Fecha </B></div>
													<br>
													<div id="external_filter_container7"></div>
													<br>
													<table id="Jtabla" class="table-striped table-hover">
														<thead>
															<tr>
																<th>PROYECTO</th>
																<th>CONDOMINIO</th>
																<th>LOTE</th>
																<th>GERENTE</th>
																<th>COORDINADOR</th>
																<th>ASESOR</th>
																<th>USUARIO</th>
																<th>FECHA MOV.</th>
																<th>COMENTARIO </th>
																<th>FECHA MOVIMIENTO </th>
																<th>FECHA VENCIMIENTO </th>
															</tr>
														</thead>
														<tbody>
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

	<script>
		let titulos = [];
		$('#Jtabla thead tr:eq(0) th').each( function (i) {
			

			var title = $(this).text();
			titulos.push(title);

			$(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
			$( 'input', this ).on('keyup change', function () {
				if ($('#Jtabla').DataTable().column(i).search() !== this.value ) {
					$('#Jtabla').DataTable().column(i).search(this.value).draw();
				}
			});
		
		});

		$(document).ready(function(){
			$.ajax({
				post: "POST",
				url: "<?=site_url().'/registroLote/getDateToday/'?>"
			}).done(function(data){
				$('#showDate').append('(Expedientes integrados al día de hoy: ' + data +')');
			}).fail(function(){});

			var table = $('#Jtabla').dataTable( {
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
				ajax: {
					"url": '<?=base_url()?>index.php/contraloria/getRevision2',
					"dataSrc": ""
				},
				pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
				columnDefs: [{
					defaultContent: "-",
					targets: "_all"
				}],
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					exportOptions: {
						format: {
							header:  function (d, columnIdx) {
								return ' '+titulos[columnIdx] +' ';
							}
						}
					}
				},
				{
					extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                    className: 'btn buttons-pdf',
                    titleAttr: 'Descargar archivo PDF',
					orientation: 'landscape',
					pageSize: 'LEGAL',
					exportOptions: {
						format: {
							header:  function (d, columnIdx) {
								return ' '+titulos[columnIdx] +' ';		
							}
						}
					}
				}],
				columns: [{
					data: function (data){
						return myFunctions.validateEmptyField(data.nombreResidencial);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.nombreCondominio);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.nombreLote);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.gerente);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.coordinador);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.asesor);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.result);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.modificado);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.comentario);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.fechaApartado);
					}
				},
				{
					data: function (data){
						return myFunctions.validateEmptyField(data.fechaVenc);
					}
				}]
			}).yadcf([{
				column_number: 7,
				filter_container_id: 'external_filter_container7',
				filter_type: 'range_date',
				datepicker_type: 'bootstrap-datetimepicker',
				filter_default_label: ['Desde', 'Hasta'],
				date_format: 'YYYY-MM-DD',
				filter_plugin_options: {
					format: 'YYYY-MM-DD',
					showClear: true,
				}
			}]);
		});
	</script>
	<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>
</body>
