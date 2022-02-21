
<body class="">
<div class="wrapper ">
	<?php
	$dato= array(
		'home' => 0,
		'listaCliente' => 0,
		'contrato' => 0,
		'documentacion' => 0,
		'corrida' => 0,
		'inventario' => 0,
		'inventarioDisponible' => 0,
		'status8' => 0,
		'status14' => 0,
		'lotesContratados' => 1,
		'ultimoStatus' => 0,
		'lotes45dias' => 0,
		'consulta9Status' => 0,
		'consulta12Status' => 0,
		'gerentesAsistentes' => 0,
		'expedientesIngresados'	=>	0,
		'corridasElaboradas'	=>	0
	);
	//$this->load->view('template/contratacion/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
	?>
	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!--Eltitulo se carga por un servicio-->
<!--					<div id="showDate"></div>-->
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
						<div class="card-content">
							<h4 class="card-title" id="showDate" style="text-align: center"></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">
								<div class="form-group">
									<div class="table-responsive">
										<table id="Jtabla" class="table table-bordered table-hover" width="100%"
											   style="text-align:center;">
											<thead>
											<tr>
												<th>
													<center> Proyecto</center>
												</th>
												<th>
													<center> Condominio</center>
												</th>
												<th>
													<center> Lote</center>
												</th>
												<th>
													<center> Gerente</center>
												</th>
												<th>
													<center> Asesor(es)</center>
												</th>
												<th>
													<center> Proceso contratación</center>
												</th>
												<th>
													<center>Comentario</center>
												</th>
												<th>
													<center>Fecha Contrtado</center>
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
	$(document).ready(function() {
		$.ajax(
			{
				post: "POST",
				url: "<?=site_url() . '/registroLote/getDateToday/'?>"
			}).done(function (data) {
			$('#showDate').append('Lotes contratados al: ' + data);
		}).fail(function () {
			// $('#showDate').append('<center><h3>Lotes contratados al: '+new Date().getDay()+new Date().getMonth()+new Date().getFullYear()'</h3></center>');
		});

		$('#Jtabla').DataTable({
			"ajax": {
				"url": '<?=base_url()?>index.php/registroLote/getLotesContratados/',
				"dataSrc": ""
			},
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
			// "responsive":true,
			"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"columns": [
				{data: 'nombreResidencial'},
				{data: 'nombreCondominio'},
				{data: 'nombreLote'},
				{
					// data: 'gerente1'
					data: function(data)
					{
						var ge1, ge2, ge3, ge4, ge5;
						if(data.gerente!="" && data.gerente!=null){ge1="- "+data.gerente}else{ge1="";}
						if(data.gerente2!="" && data.gerente2!=null){ge2="- "+data.gerente2}else{ge2="";}
						if(data.gerente3!="" && data.gerente3!=null){ge3="- "+data.gerente3}else{ge3="";}
						if(data.gerente4!="" && data.gerente4!=null){ge4="- "+data.gerente4}else{ge4="";}
						if(data.gerente5!="" && data.gerente5!=null){ge5="- "+data.gerente5}else{ge5="";}
						return ge1;
					}
				},//gerente(s)
				{
					// data: 'asesor'
					data: function(data)
					{
						var as1, as2, as3, as4, as5;
						if(data.asesor!="" && data.asesor!=null){as1="- "+data.asesor}else{as1="";}
						if(data.asesor2!="" && data.asesor2!=null){as2="- "+data.asesor2}else{as2="";}
						if(data.asesor3!="" && data.asesor3!=null){as3="- "+data.asesor3}else{as3="";}
						if(data.asesor4!="" && data.asesor4!=null){as4="- "+data.asesor4}else{as4="";}
						if(data.asesor5!="" && data.asesor5!=null){as5="- "+data.asesor5}else{as5="";}
						return as1;
					}
				},//asesor(es)
				{
					data: function(data)
					{
						if(data.idStatusContratacion==15){return "LOTE CONTRATADO"}else{return "N/A"};
					}
				},
				{data: 'comentario'},
				{data: 'modificado'},


			]
		});

	});
</script>
