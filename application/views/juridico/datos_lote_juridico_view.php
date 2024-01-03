<body class="">
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>

	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<h3>Registros de Terrenos</h3>
					</center>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="container-fluid" style="padding: 50px 50px;">
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Proyecto:</label><br>
									<select name="filtro3" id="filtro3" class="selectpicker" data-style="btn " title="Selecciona Proyecto" data-size="7" required>
										<option value="all"> TODO </option>
										<?php
										if($residencial != NULL) :
											foreach($residencial as $fila) : ?>
												<option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
											<?php endforeach;
										endif;
										?>
									</select>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Condominio:</label><br>
									<select id="filtro4" name="filtro4" class="selectpicker" data-style="btn " title="Selecciona Condominio" data-size="7"></select>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Estatus:</label><br>
									<select id="filtro5" name="filtro5" class="selectpicker" data-style="btn " title="Selecciona Lote" data-size="7"></select>
								</div>
							</div>

						</div>
					</div>
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
										<table id="tableTerrenos" class="table table-bordered table-hover" style="text-align:center;">
											<thead>
											<tr>
												<th><center>Nombre</center></th>
												<th><center>Superficie</center></th>
												<th><center>Precio</center></th>
												<th><center>Total</center></th>
												<th><center>Porcentaje</center></th>
												<th><center>Enganche</center></th>
												<th><center>Saldo</center></th>
												<th><center>Al 0%</center></th>
												<th><center>Al 1%</center></th>
												<th><center>Referencia</center></th>
												<th><center>Status</center></th>
												<th><center>Liberación</center></th>
												<th><center>Fecha Liberación</center></th>
												<th><center>Gerente(s)</center></th>
												<th><center>Aseseor</center></th>
												<th><center>Aseseor</center></th>
												<th><center>Aseseor</center></th>
												<th><center>Acciones</center></th>
											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="modal fade" id="verDetalles" >
								<div class="modal-dialog modal-lg">
									<div class="modal-content" >
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 8%;top: 3%;color: #333">
												<span class="material-icons">close</span>
												<span class="sr-only">Cerrar</span>
											</button>
											<h3 class="modal-title">Historial Contratación de Terrenos</h3>
										</div>
										<div class="modal-body">
											<table id="verDet" class="table table-bordered table-hover" width="100%" style="text-align:center;">
												<thead>
												<tr>
													<th><center>Lote</center></th>
													<th><center>Status</center></th>
													<th><center>Detalles</center></th>
													<th><center>Comentario</center></th>
													<th><center>Fecha</center></th>
													<th><center>Usuario</center></th>
												</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div>
										<div class="modal-footer center-align">
											<button class="btn btn-success btn-lg" data-dismiss="modal">
													<span class="btn-label">
														<i class="material-icons">check</i>
													</span>
												¡Entendido!
											</button>
										</div>
									</div>
								</div>
							</div>
							<!-- modal -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('template/footer_legend');?>
</div>
</div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<script>
	$(document).ready(function(){
		//build select condominios
		$("#filtro5").empty().selectpicker('refresh');
		$.ajax({
			url: '<?=base_url()?>registroLote/getStatus',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				for( var i = 0; i<len; i++)
				{
					var id = response[i]['idStatusLote'];
					var name = response[i]['nombre'];
					$("#filtro5").append($('<option>').val(id).text(name));
				}
				$("#filtro5").selectpicker('refresh');

			}
		});
	});
	function createActions(data, method, row) {
		return '<a href="#" class="see" data-idLote="' + row.idLote +'"><i class="fa fa-file-text-o" aria-hidden="true" title = "Historial Proceso de contratación"></i></a>' ;
	}

	$('#filtro3').change(function(){
		var entra = 0;
		var residencial = $('#filtro3').val();
		var valorSeleccionado = $('#filtro4').val();

		var table = $('#tableTerrenos').DataTable();

		table
			.clear()
			.draw();

		if(residencial == 0)
		{
			var ruta = "<?= site_url('registroLote/getLotesInventarioGralTodos') ?>";
			$("#filtro4").html( "" ).append( "" );
			entra = 1;
		}
		else if(residencial == 'all')
		{
			var ruta = "<?= site_url('registroLote/getLotesInventarioGralAll') ?>";
			$("#filtro4").html( "" ).append( "" );
			entra = 'all';

		}
		else
		{
			entra = 0;
			$("#filtro4").empty().selectpicker('refresh');
			$('#filtro4').append($('<option>').val('1000').text('TODOS'));
			$.ajax({
				url: '<?=base_url()?>registroLote/getCondominio/'+residencial,
				type: 'post',
				dataType: 'json',
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['idCondominio'];
						var name = response[i]['nombre'];
						$("#filtro4").append($('<option>').val(id).text(name));
					}
					$("#filtro4").selectpicker('refresh');

				}
			});
			//$('#filtro4').load("<?//= site_url('registroLote/getCondominio') ?>///"+residencial);
		}

		if(entra == 1)
		{
			var table = $('#tableTerrenos').DataTable({
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
					}
				],


				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				},
				destroy: true,
				columns: [
					{ data: 'nombreLote' },
					{ data: 'sup' },
					{ data: 'precio' },
					{ data: 'total' },
					{ data: 'porcentaje' },
					{ data: 'enganche' },
					{ data: 'saldo' },
					{ data: 'modalidad_1' },
					{ data: 'modalidad_2' },
					{ data: 'referencia' },
					{ data: 'nombre' },
					{ data: 'comentarioLiberacion' },
					{ data: 'fechaLiberacion' },
					{ data: function (d) {
							if(d.gerente1 == null){ var gerente1 = " "; }else{ var gerente1 = d.gerente1; }
							if(d.gerente2 == null){ var gerente2 = " "; }else{ var gerente2 = d.gerente2; }
							if(d.gerente3 == null){ var gerente3 = " "; }else{ var gerente3 = d.gerente3; }

							return gerente1 + ' ' + gerente2 + ' ' + gerente3;
						}
					},
					{ data: 'asesor' },
					{ data: 'asesor2' },
					{ data: 'asesor3' },
					{ data: 'idLote', render: createActions }

				],
				"ajax": {
					"url": ruta,
					"type": "POST",
					cache: false,
					"data": function( d ){
						d.proyecto = $('#empresa').val();
						d.idproyecto = $('#proyecto').val();
					}
				},
			});
		}
		else if (entra == 'all')
		{
			var table = $('#tableTerrenos').DataTable({

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
					}
				],

				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				},
				destroy: true,
				columns: [
					{ data: 'nombreLote' },
					{ data: 'sup' },
					{ data: 'precio' },
					{ data: 'total' },
					{ data: 'porcentaje' },
					{ data: 'enganche' },
					{ data: 'saldo' },
					{ data: 'modalidad_1' },
					{ data: 'modalidad_2' },
					{ data: 'referencia' },
					{ data: 'nombre' },
					{ data: 'comentarioLiberacion' },
					{ data: 'fechaLiberacion' },
					{ data: function (d) {
							if(d.gerente1 == null){ var gerente1 = " "; }else{ var gerente1 = d.gerente1; }
							if(d.gerente2 == null){ var gerente2 = " "; }else{ var gerente2 = d.gerente2; }
							if(d.gerente3 == null){ var gerente3 = " "; }else{ var gerente3 = d.gerente3; }

							return gerente1 + ' ' + gerente2 + ' ' + gerente3;
						}
					},
					{ data: 'asesor' },
					{ data: 'asesor2' },
					{ data: 'asesor3' },
					{ data: 'idLote', render: createActions }

				],
				"ajax": {
					"url": ruta,
					"type": "POST",
					cache: false,
					"data": function( d ){
						d.proyecto = $('#empresa').val();
						d.idproyecto = $('#proyecto').val();
					}
				},
			});
		}
	});

	$('#filtro4').change(function()
	{
		var residencial = $('#filtro3').val();
		var valorSeleccionado = $('#filtro4').val();
		var ruta;
		var table = $('#exmaple').DataTable();
		if(valorSeleccionado == 1000){
			ruta = "<?= site_url('registroLote/getLotesInventarioXproyecto') ?>/"+residencial;
		}else{
			ruta = "<?= site_url('registroLote/getLotesInventarioGralCM') ?>/"+valorSeleccionado+'/'+residencial;
		}
		var table = $('#tableTerrenos').DataTable({

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
				}
			],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
			},
			destroy: true,
			columns: [
				{ data: 'nombreLote' },
				{ data: 'sup' },
				{ data: 'precio' },
				{ data: 'total' },
				{ data: 'porcentaje' },
				{ data: 'enganche' },
				{ data: 'saldo' },
				{ data: 'modalidad_1' },
				{ data: 'modalidad_2' },
				{ data: 'referencia' },
				{ data: 'nombre' },
				{ data: 'comentarioLiberacion' },
				{ data: 'fechaLiberacion' },
				{ data: function (d) {
						if(d.gerente1 == null){ var gerente1 = " "; }else{ var gerente1 = d.gerente1; }
						if(d.gerente2 == null){ var gerente2 = " "; }else{ var gerente2 = d.gerente2; }
						if(d.gerente3 == null){ var gerente3 = " "; }else{ var gerente3 = d.gerente3; }

						return gerente1 + ' ' + gerente2 + ' ' + gerente3;
					}
				},
				{ data: 'asesor' },
				{ data: 'asesor2' },
				{ data: 'asesor3' },
				{ data: 'idLote', render: createActions }
			],
			"ajax": {
				"url": ruta,
				"type": "POST",
				cache: false,
				"data": function( d ){
					d.proyecto = $('#empresa').val();
					d.idproyecto = $('#proyecto').val();
				}
			},
		});
	});

	$('#filtro5').change(function(){
		var residencial = $('#filtro3').val();
		var condominio = $('#filtro4').val();
		var status = $('#filtro5').val();

		var ruta;
		var table = $('#tableTerrenos').DataTable();
		if(status > 0){
			if(residencial == 0){
				ruta = "<?= site_url('registroLote/getLotesInventarioXproyectoTodosStatus') ?>/"+status;
			}
			else if(condominio == 1000){
				ruta = "<?= site_url('registroLote/getLotesInventarioXproyectoStatus') ?>/"+residencial+'/'+status;
			}else{
				ruta = "<?= site_url('registroLote/getLotesInventarioGralproyectoYcondominioXstatus') ?>/"+residencial+'/'+condominio+'/'+status;
			}


			var table = $('#tableTerrenos').DataTable({

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
					}
				],


				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				},
				destroy: true,
				columns: [
					{ data: 'nombreLote' },
					{ data: 'sup' },
					{ data: 'precio' },
					{ data: 'total' },
					{ data: 'porcentaje' },
					{ data: 'enganche' },
					{ data: 'saldo' },
					{ data: 'modalidad_1' },
					{ data: 'modalidad_2' },
					{ data: 'referencia' },
					{ data: 'nombre' },
					{ data: 'comentarioLiberacion' },
					{ data: 'fechaLiberacion' },
					{ data: function (d) {
							if(d.gerente1 == null){ var gerente1 = " "; }else{ var gerente1 = d.gerente1; }
							if(d.gerente2 == null){ var gerente2 = " "; }else{ var gerente2 = d.gerente2; }
							if(d.gerente3 == null){ var gerente3 = " "; }else{ var gerente3 = d.gerente3; }

							return gerente1 + ' ' + gerente2 + ' ' + gerente3;
						}
					},
					{ data: 'asesor' },
					{ data: 'asesor2' },
					{ data: 'asesor3' },
					{ data: 'idLote', render: createActions }

				],
				"ajax": {
					"url": ruta,
					"type": "POST",
					cache: false,
					"data": function( d ){
						d.proyecto = $('#empresa').val();
						d.idproyecto = $('#proyecto').val();
					}
				}
			});
		}
	});

	$(document).on('click', '.see', function(e) {
		e.preventDefault();
		var $itself = $(this);
		var idLote= $itself.attr('data-idLote');
		$.post('historialProcesoLoteOp', {idLote: $itself.attr('data-idLote')}, function(data) {
			idlote_global = idLote;
			tableHistorial.ajax.reload();
			$('#verDetalles').modal('show');
		}, 'json');
	});
	var tableHistorial;
	var idlote_global = 0;

	$(document).ready (function() {
		tableHistorial = $('#verDet').DataTable( {
			responsive: true,
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
				}
			],

			"pageLength": 10,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			columns: [
				{ "data": "nombreLote" },
				{ "data": "nombreStatus" },
				{ "data": "descripcion" },
				{ "data": "comentario" },
				{ "data": "modificado" },
				{ "data": "user" }

			],
			"ajax": {
				"url": "<?=base_url()?>index.php/registroLote/historialProcesoLoteOp/",
				"type": "POST",
				cache: false,
				"data": function( d ){
					d.idLote = idlote_global;
				}
			},
		});
	});

</script>
