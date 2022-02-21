<body class="">
<div class="wrapper ">
	<?php
	$dato= array(
		'home' => 0,
		'listaCliente' => 0,
		'documentacion' => 0,
		'contrato' => 0,
		'inventario' => 0,
		'status3' => 0,
		'status7' => 0,
		'lotesContratados' => 1,
	);
	//$this->load->view('template/juridico/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
	?>
	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!--Eltitulo se carga por un servicio-->
					<div id="showDate"></div>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content" style="padding: 50px 20px;">
							<h4 class="card-title"></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">
								<div class="form-group">
									<div class="table-responsive">
										<div id="external_filter_container18"><B> Busqueda de Lotes por Fecha de Contratación </B></div>
										<br>
										<div id="external_filter_container7"></div>
										<br>
										<table id="Jtabla" class="table table-bordered table-hover" width="100%"
											   style="text-align:center;">
											<thead>
											<tr>
												<th>
													<center> Lote</center>
												</th>
												<th>
													<center> Gerente(s)</center>
												</th>
												<th>
													<center>Asesor(es)</center>
												</th>
												<th>
													<center> Status</center>
												</th>
												<th>
													<center> Detalles</center>
												</th>
												<th>
													<center> Comentario</center>
												</th>
												<th>
													<center>Fecha</center>
												</th>
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
	<?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
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
	$(document).ready(function()
	{
		$.ajax(
			{
				post: "POST",
				url: "<?=site_url().'/registroLote/getDateToday/'?>"
			}).done(function(data)
				{
					$('#showDate').append('<center><h3>Lotes contratados al: '+data+'</h3></center>');
				}).fail(function()
				{
					// $('#showDate').append('<center><h3>Lotes contratados al: '+new Date().getDay()+new Date().getMonth()+new Date().getFullYear()'</h3></center>');
				});
		var table = $('#Jtabla').dataTable( {
			"ajax":
				{
					"url": '<?=base_url()?>index.php/registroLote/getReportData',
					"dataSrc": ""
				},
			"select": true,
			"scrollX":        true,
			"pageLength": '10',
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			columnDefs: [{
				defaultContent: "-",
				targets: "_all"
			}],
			dom: 'Bfrtip',
			buttons: [
				{
					extend:    'copyHtml5',
					text:      '<i class="fa fa-files-o"></i>',
					titleAttr: 'Copy'
				},
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'csvHtml5',
					text:      '<i class="fa fa-file-text-o"></i>',
					titleAttr: 'CSV'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF'
				},
			],
			"columns":
				[
					{data: 'nombreLote'},
					{
						data: function (data)
						{
							var ge1, ge2, ge3, ge4, ge5;
							if(data.gerente == undefined){ge1="";}else{ge1=data.gerente;};
							if(data.gerente2 == undefined){ge2="";}else{ge2=data.gerente2;};
							if(data.gerente3 == undefined){ge3="";}else{ge3=data.gerente3;};
							if(data.gerente4 == undefined){ge4="";}else{ge4=data.gerente4;};
							if(data.gerente5 == undefined){ ge5=""; }else{ge5=data.gerente5;};

							return ge1 ;

						}
					},
					{
						data: function (data)
						{
							var as1, as2, as3, as4, as5;
							if(data.asesor == undefined){as1="";}else{as1=data.asesor};
							if(data.asesor2 == undefined){as2="";}else{as2=data.asesor2;};
							if(data.asesor3 == undefined){as3="";}else{as3=data.asesor3};
							if(data.asesor4 == undefined){as4="";}else{ as4=data.asesor4;};
							if(data.asesor5 == undefined){as5="";}else{ as5=data.asesor5;};
							return as1 ;
						}
					},
					{
						data: function (data)
						{
							//idStatusContratacion
							var status;
							if(data.idStatusContratacion==15){status="Lote Contratado"}else{status="Status no definido [303]"}
							return status;
						}
					},
					{
						data: function (data)
						{
							//idStatusContratacion
							var details;
							if(data.idStatusContratacion==15 && data.idMovimiento==45){details="15. Acuse entregado (Contraloría)"}
							return details;
						}
					},
					{data: 'comentario'},
					{data: 'fechaVenc'},
				]
		} ).yadcf([
			{
				column_number: 6,
				filter_container_id: 'external_filter_container7',
				filter_type: 'range_date',
				datepicker_type: 'bootstrap-datetimepicker',
				date_format: 'yyyy-mm-dd',
				filter_plugin_options: {
					format: 'YYYY-MM-DD',
					showClear: true,
				}
			},
		]);

	});
</script>
<script src="<?= base_url() ?>static/yadcf/jquery.dataTables.yadcf.js"></script>
