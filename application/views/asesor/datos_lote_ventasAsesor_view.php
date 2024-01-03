<body>
<div class="wrapper">
<?php $this->load->view('template/asesor/sidebar'); ?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<h3>Inventario de terrenos</h3>
					</center>
					<br>
					<hr style=" border-top: 1px solid #d6d5d5;">

				</div>
			</div>
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="form-group">
							<label>Proyecto</label>
<!--							<span class="input-group-addon"><img src="--><?//=base_url()?><!--static/images/proyecto.png" height="30" width="40"></span>-->
							<select name="filtro3" id="filtro3"  required class="selectpicker" data-style="btn btn-primary btn-round" title="Proyecto" data-size="7"/>
							<option value=""> --PROYECTO-- </option>
							<option value="all"> --TODO-- </option>
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
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="form-group">
							<label>Condominio</label>
							<select  id="filtro4" name="filtro4"  class="selectpicker" data-style="btn btn-primary btn-round" title="Selecciona Condomimnio" data-size="7"/>

							</select>
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="form-group">
							<label>Estatus</label>
							<select  id="filtro5" name="filtro5" required  class="selectpicker" data-style="btn btn-primary btn-round" title="Selecciona Estatus" data-size="7"/>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="block full">
							<div class="card">
								<div class="card-header card-header-icon" data-background-color="blue">
									<i class="material-icons">assignment</i>
								</div>
								<div class="block-title">

									<h2 style="color:#FFF">.</h2>

									<div class="block-options pull-right">

									</div>

								</div>
								<div class="card-content">
									<h4 class="card-title">Terrenos</h4>
									<div class="toolbar">
										<!--        Here you can write extra buttons/actions for the toolbar              -->
									</div>
										<div class="table-responsive">
											<div class="material-datatables">
												<table id="exmaple" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
													<thead>
													<tr>
														<th><center>Proyecto</center></th>
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
														<th><center>FechaApartado</center></th>
														<th><center>Usuario</center></th>
														<th><center>Acciones</center></th>

													</tr>
													</thead>
													<tbody>
													</tbody>
													<tfoot>
													<tr>
														<th><center>Proyecto</center></th>
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
														<th><center>FechaApartado</center></th>
														<th><center>Usuario</center></th>
														<th><center>Acciones</center></th>
													</tr>
													</tfoot>
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
			<!--Data Modal Historial de Contratacion Terrenos-->
				<div class="modal fade bd-example-modal-lg" id="verDetalles" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content" style="padding: 40px;background-color: rgba(255,255,255,1);color:  #333;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 8%;top: 3%;color: #333">
								<span class="material-icons">close</span>
								<span class="sr-only">Cerrar</span>
							</button>
							<h3 class="modal-title" style="color: #333;text-align: center">Historial Contratación de Terrenos</h3>
						</div>
						<div class="modal-body">
							<div class="material-datatables">
								<table id="verDet" class="table table-striped table-bordered table-hover" width="100%" style="text-align:center;">
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
								<tfoot>
								<tr>
									<th><center>Lote</center></th>
									<th><center>Status</center></th>
									<th><center>Detalles</center></th>
									<th><center>Comentario</center></th>
									<th><center>Fecha</center></th>
									<th><center>Usuario</center></th>
								</tr>
								</tfoot>
							</table>
							</div>
						</div>
						<div class="modal-footer center-align">
<!--							<button type="button" class="btn btn-warning" data-dismiss="modal">¡Entendido!</button>-->
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
			<!--status de lote Modal-->
			<div class="modal fade bd-example-modal-lg" id="verBloqueo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content" style="padding: 40px;background-color: rgba(255,255,255,1);color:  #333;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 8%;top: 3%;color: #333">
								<span class="material-icons">close</span>
								<span class="sr-only">Cerrar</span>
							</button>
							<h3 class="modal-title" style="color:#333;text-align: center">Status de lote Contratación de Terrenos</h3>
						</div>
						<div class="modal-body">
							<table id="verDetBloqueo" class="table table-striped table-bordered table-hover" width="100%" style="text-align:center;">
								<thead>
								<tr>
									<th><center>Lote</center></th>
									<th><center>Gerente</center></th>
									<th><center>Asesor</center></th>
									<th><center>Gerente</center></th>
									<th><center>Asesor</center></th>
									<th><center>Usuario</center></th>
									<th><center>Fecha</center></th>

								</tr>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
								<tr>
									<th><center>Lote</center></th>
									<th><center>Gerente</center></th>
									<th><center>Asesor</center></th>
									<th><center>Gerente</center></th>
									<th><center>Asesor</center></th>
									<th><center>Usuario</center></th>
									<th><center>Fecha</center></th>
								</tr>
								</tfoot>
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
	</div>
	<?php $this->load->view('template/footer_legend');?>
</div>
</div>
</body>
<?php $this->load->view('template/footer');?>
<script>
	$(document).ready(function(){
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
		$('.card .material-datatables label').addClass('form-group');

	});

	$('#filtro3').change(function(){
		var entra = 0;
		var residencial = $('#filtro3').val();
		var valorSeleccionado = $('#filtro4').val();

		var table = $('#exmaple').DataTable();

		table
			.clear()
			.draw();

		if(residencial == 0){
			var ruta = "<?= site_url('registroLote/getLotesInventarioGralTodos') ?>";
			$("#filtro4").html( "" ).append( "" );
			entra = 1;
		} else if(residencial == 'all'){
			var ruta = "<?= site_url('registroLote/getLotesInventarioGralAll') ?>";
			$("#filtro4").html( "" ).append( "" );
			entra = 'all';

		}
		else{
			entra = 0;
			$("#filtro4").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>registroCliente/getCondominios/'+residencial,
				type: 'post',
				dataType: 'json',
				success:function(response){
					var len = response.length;
					$("#filtro4").append($('<option>').val(1000).text('TODOS'));
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

		if(entra == 1){
			var table = $('#exmaple').DataTable({


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
				responsive: true,


				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				},
				destroy: true,
				columns: [
					{ data: 'nombreResidencial' },
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
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){

								var icon = '<i class="glyphicon glyphicon-user"></i>';

								if(d.gerenteL == null){ var gerenteL = " "; }else{ var gerenteL = icon + ' ' + d.gerenteL; }
								if(d.gerenteL2 == null){ var gerenteL2 = " "; }else{ var gerenteL2 = icon + ' ' + d.gerenteL2; }
								return gerenteL + ' ' + gerenteL2;

							} else {
								if(d.gerente1 == null){ var gerente1 = " "; }else{ var gerente1 = d.gerente1; }
								if(d.gerente2 == null){ var gerente2 = " "; }else{ var gerente2 = d.gerente2; }
								if(d.gerente3 == null){ var gerente3 = " "; }else{ var gerente3 = d.gerente3; }
								return gerente1 + ' ' + gerente2 + ' ' + gerente3;
							}
						}
					},
					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.asesorL;
							} else {
								return d.asesor;
							}
						}
					},

					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.asesorL2;
							} else {
								return d.asesor2;
							}
						}
					},
					{ data: 'asesor3' },
					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.fecha_modst;
							} else {
								return d.fechaApartado;
							}
						}
					},

					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.userLote;
							} else {
								return d.userApartado;
							}
						}
					},
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
				//   initComplete: function () {
				//     this.api().columns().every( function () {
				//     var column = this;
				//     var select = $('<select><option value=""></option></select>')
				//       .appendTo( $(column.footer()).empty() )
				//       .on( 'change', function () {
				//         var val = $.fn.dataTable.util.escapeRegex(
				//           $(this).val()
				//         );

				//         column
				//         .search( val ? '^'+val+'$' : '', true, false )
				//         .draw();
				//       });

				//     column.data().unique().sort().each( function ( d, j ) {
				//       select.append( '<option value="'+d+'">'+d+'</option>' );
				//     });
				//   });
				// }
			});
		}else if (entra == 'all'){
			var table = $('#exmaple').DataTable({

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
				responsive: true,
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				},
				destroy: true,
				columns: [
					{ data: 'nombreResidencial' },
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
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){

								var icon = '<i class="glyphicon glyphicon-user"></i>';

								if(d.gerenteL == null){ var gerenteL = " "; }else{ var gerenteL = icon + ' ' + d.gerenteL; }
								if(d.gerenteL2 == null){ var gerenteL2 = " "; }else{ var gerenteL2 = icon + ' ' + d.gerenteL2; }
								return gerenteL + ' ' + gerenteL2;

							} else {
								if(d.gerente1 == null){ var gerente1 = " "; }else{ var gerente1 = d.gerente1; }
								if(d.gerente2 == null){ var gerente2 = " "; }else{ var gerente2 = d.gerente2; }
								if(d.gerente3 == null){ var gerente3 = " "; }else{ var gerente3 = d.gerente3; }
								return gerente1 + ' ' + gerente2 + ' ' + gerente3;
							}
						}
					},
					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.asesorL;
							} else {
								return d.asesor;
							}
						}
					},

					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.asesorL2;
							} else {
								return d.asesor2;
							}
						}
					},
					{ data: 'asesor3' },
					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.fecha_modst;
							} else {
								return d.fechaApartado;
							}
						}
					},

					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.userLote;
							} else {
								return d.userApartado;
							}
						}
					},
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
				//   initComplete: function () {
				//     this.api().columns().every( function () {
				//     var column = this;
				//     var select = $('<select><option value=""></option></select>')
				//       .appendTo( $(column.footer()).empty() )
				//       .on( 'change', function () {
				//         var val = $.fn.dataTable.util.escapeRegex(
				//           $(this).val()
				//         );

				//         column
				//         .search( val ? '^'+val+'$' : '', true, false )
				//         .draw();
				//       });

				//     column.data().unique().sort().each( function ( d, j ) {
				//       select.append( '<option value="'+d+'">'+d+'</option>' );
				//     });
				//   });
				// }
			});
		}
	});

	$('#filtro4').change(function(){
		var residencial = $('#filtro3').val();
		var valorSeleccionado = $('#filtro4').val();
		var ruta;
		var table = $('#exmaple').DataTable();
		if(valorSeleccionado == 1000){
			ruta = "<?= site_url('registroLote/getLotesInventarioXproyecto') ?>/"+residencial;
		}else{
			ruta = "<?= site_url('registroLote/getLotesInventarioGralCM') ?>/"+valorSeleccionado+'/'+residencial;
		}


		var table = $('#exmaple').DataTable({

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
					titleAttr: 'PDF',
					orientation: 'landscape',
					pageSize: 'LEGAL'
				}
			],

			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
			},
			destroy: true,
			columns: [
				{ data: 'nombreResidencial' },
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
						if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){

							var icon = '<i class="glyphicon glyphicon-user"></i>';

							if(d.gerenteL == null){ var gerenteL = " "; }else{ var gerenteL = icon + ' ' + d.gerenteL; }
							if(d.gerenteL2 == null){ var gerenteL2 = " "; }else{ var gerenteL2 = icon + ' ' + d.gerenteL2; }
							return gerenteL + ' ' + gerenteL2;

						} else {
							if(d.gerente1 == null){ var gerente1 = " "; }else{ var gerente1 = d.gerente1; }
							if(d.gerente2 == null){ var gerente2 = " "; }else{ var gerente2 = d.gerente2; }
							if(d.gerente3 == null){ var gerente3 = " "; }else{ var gerente3 = d.gerente3; }
							return gerente1 + ' ' + gerente2 + ' ' + gerente3;
						}
					}
				},
				{ data: function (d) {
						if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
							return d.asesorL;
						} else {
							return d.asesor;
						}
					}
				},

				{ data: function (d) {
						if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
							return d.asesorL2;
						} else {
							return d.asesor2;
						}
					}
				},
				{ data: 'asesor3' },
				{ data: function (d) {
						if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
							return d.fecha_modst;
						} else {
							return d.fechaApartado;
						}
					}
				},

				{ data: function (d) {
						if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
							return d.userLote;
						} else {
							return d.userApartado;
						}
					}
				},
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
		var table = $('#exmaple').DataTable();
		if(status > 0){
			if(residencial == 0){
				ruta = "<?= site_url('registroLote/getLotesInventarioXproyectoTodosStatus') ?>/"+status;
			}
			else if(condominio == 1000){
				ruta = "<?= site_url('registroLote/getLotesInventarioXproyectoStatus') ?>/"+residencial+'/'+status;
			}else{
				ruta = "<?= site_url('registroLote/getLotesInventarioGralproyectoYcondominioXstatus') ?>/"+residencial+'/'+condominio+'/'+status;
			}


			var table = $('#exmaple').DataTable({

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
					{ data: 'nombreResidencial' },
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
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){

								var icon = '<i class="glyphicon glyphicon-user"></i>';

								if(d.gerenteL == null){ var gerenteL = " "; }else{ var gerenteL = icon + ' ' + d.gerenteL; }
								if(d.gerenteL2 == null){ var gerenteL2 = " "; }else{ var gerenteL2 = icon + ' ' + d.gerenteL2; }
								return gerenteL + ' ' + gerenteL2;

							} else {
								if(d.gerente1 == null){ var gerente1 = " "; }else{ var gerente1 = d.gerente1; }
								if(d.gerente2 == null){ var gerente2 = " "; }else{ var gerente2 = d.gerente2; }
								if(d.gerente3 == null){ var gerente3 = " "; }else{ var gerente3 = d.gerente3; }
								return gerente1 + ' ' + gerente2 + ' ' + gerente3;
							}
						}
					},
					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.asesorL;
							} else {
								return d.asesor;
							}
						}
					},

					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.asesorL2;
							} else {
								return d.asesor2;
							}
						}
					},
					{ data: 'asesor3' },
					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.fecha_modst;
							} else {
								return d.fechaApartado;
							}
						}
					},

					{ data: function (d) {
							if(d.idstatuslote == 8 || d.idstatuslote == 9 || d.idstatuslote == 10){
								return d.userLote;
							} else {
								return d.userApartado;
							}
						}
					},
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

	function createActions(data, method, row) {
		return '<a href="#" class="see" data-idLote="' + row.idLote +'" title="Historial Contratación de Terrenos"><i class="fa fa-file-text-o" aria-hidden="true"></i></a> | <a href="#" class="seeBlock" data-idLote="' + row.idLote +'" title="Status de lote Contratación de Terrenos"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>' ;

	}
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
	$(document).on('click', '.seeBlock', function(e) {
		e.preventDefault();
		var $itself = $(this);
		var idLote= $itself.attr('data-idLote');

		$.post('historialBloqueos', {idLote: $itself.attr('data-idLote')}, function(data) {
			idlote_global2 = idLote;
			tableHistorialBloqueo.ajax.reload();
			$('#verBloqueo').modal('show');
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
					titleAttr: 'PDF',
					orientation: 'landscape',
					pageSize: 'LEGAL'
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
	var tableHistorialBloqueo;
	var idlote_global2 = 0;
	$(document).ready (function() {
		var idLote;
		tableHistorialBloqueo = $('#verDetBloqueo').DataTable( {
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
				{ "data": "gerente1" },
				{ "data": "asesor" },
				{ "data": "gerente2" },
				{ "data": "asesor2" },
				{ "data": "userstatus" },
				{ "data": "fecha_modst" }

			],
			"ajax": {
				"url": "<?=base_url()?>index.php/registroLote/historialBloqueos/",
				"type": "POST",
				cache: false,
				"data": function( d ){

					d.idLote = idlote_global2;

				}
			},
		});
	});
</script>
</html>
