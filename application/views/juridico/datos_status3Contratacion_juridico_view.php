<body class="">
<div class="wrapper ">
<?php $this->load->view('template/sidebar'); ?>

	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<h3>REGISTRO STATUS (3. Revisión Jurídico)</h3>
					</center>
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
														<center>Gerente(s)</center>
													</th>
													<th>
														<center>Asesor(es)</center>
													</th>
													<th>
														<center> Cliente</center>
													</th>
													<th>
														<center> Status</center>
													</th>
													<th>
														<center> Comentario</center>
													</th>
													<th>
														<center> Fecha Apartado</center>
													</th>
													<th>
														<center>Fecha Vencimiento</center>
													</th>
													<th>
														<center> Fecha Realizado</center>
													</th>
													<th>
														<center> Acción</center>
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
					<!--modal de editar registros-->
					<div class="modal fade" id="editReg" >
						<div class="modal-dialog modal-md">
							<div class="modal-content" >
								<form method="post" action="<?= base_url() ?>index.php/registroLote/editar_registro_lote_juridico_proceceso3/"
									  enctype="multipart/form-data" name="status">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 5%;top: 7%;color: #333">
											<span class="material-icons">close</span>
											<span class="sr-only">Cerrar</span>
										</button>
										<h3 class="modal-title" style="padding-left: 26px;">Editar Registro</h3>
									</div>
									<div class="modal-body">
										<input type="hidden" name="idLote"/>
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<div class="row">
													<label class="col-sm-2 label-on-left">Lote: </label>
													<div class="col-sm-10">
														<div class="form-group label-floating is-empty">
															<label class="control-label"></label>
															<input type="text" class="form-control" id="nombreLotefake" disabled="disabled" value>
															<span class="help-block">Lote seleccionado</span>
														</div>
													</div>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<div class="row">
													<select class="selectpicker" name="idStatusContratacion" id="idStatusContratacion" data-style="btn btn-primary btn-round" title="" data-size="7" required>
														<option disabled selected>Estatus de contratación</option>
													</select>
													</div>
												</div>
											</div>

											<div class="col col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offfset-2">
												<div class="row">
													<br>
													<label class="col-sm-12 label-on-left">Comentario: </label>
													<div class="col-sm-12">
														<div class="form-group label-floating is-empty">
															<label class="control-label"></label>
															<textarea type="text" class="form-control" width="100%"  name="comentario" id="comentario" required>
															</textarea>
															<span class="help-block">Ingresa el comentario</span>
														</div>
												</div>
											</div>
											<input type="hidden" name="nombreLote" id="nombreLote" class="form-control"/>
											<input type="hidden" name="idLote" id="idLote" class="form-control"/>

										</div>
								</div>
									<div class="modal-footer center-align">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<button type="submit" class="btn btn-primary" onclick="pregunta(event);"
													value="Enviar" id="idRegistrar2">Registrar Status</button>
										</div>
										<input type="hidden" name="idCliente" id="idCliente" class="form-control"/>
										<input type="hidden" name="idCondominio" id="idCondominio" class="form-control"/>
										<input type="hidden" name="fechaVenc" id="fechaVenc" class="form-control"/>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- modal para rechazar registros -->
					<div class="modal fade" id="rechReg" >
						<div class="modal-dialog modal-md">
							<div class="modal-content" >
								<form method="post" action="<?= base_url() ?>index.php/registroLote/editar_registro_loteRechazo_juridico_proceceso3/"
									  enctype="multipart/form-data" name="status">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 5%;top: 7%;color: #333">
											<span class="material-icons">close</span>
											<span class="sr-only">Cerrar</span>
										</button>
										<h3 class="modal-title" style="padding-left: 26px;">Rechazo Status (3. Revisión Jurídico)</h3>
									</div>
									<div class="modal-body">
										<!--<input type="hidden" name="idLote"/>-->
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<div class="row">
													<label class="col-sm-2 label-on-left">Lote: </label>
													<div class="col-sm-10">
														<div class="form-group label-floating is-empty">
															<label class="control-label"></label>
															<input type="text" class="form-control" id="nombreLoteF" disabled="disabled">
														</div>
													</div>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<div class="row">
													<label class="col-sm-2 label-on-left">Comentario: </label>
													<div class="col-sm-10">
														<div class="form-group label-floating is-empty">
															<label class="control-label"></label>
															<input type="text" class="form-control" name="comentario" id="comentarioR" required="required">
														</div>
													</div>
												</div>
											</div>
											<input type="hidden" name="nombreLote" id="nombreLoteR" class="form-control" value=""/>
											<input type="hidden" name="idLote" id="idLoteR" class="form-control" value=""/>
											<input type="hidden" name="idCliente" id="idClienteR" class="form-control" value=""/>
											<input type="hidden" name="idCondominio" id="idCondominioR" class="form-control" value=""/>
										</div>
									</div>
									<div class="modal-footer center-align">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<button type="submit" class="btn btn-primary" onclick="pregunta(event);"
													value="Enviar" id="idRegistrarR">Rechazar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!--modal para ver documentos-->
					<div class="modal fade" id="docReg" >
						<div class="modal-dialog modal-lg" style="width: 90%">
							<div class="modal-content" >
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 2%;top: 9%;;color: #333">
										<span class="material-icons">close</span>
										<span class="sr-only">Cerrar</span>
									</button>
									<h3 class="modal-title">Visualización de Documentos</h3>
								</div>
								<div class="modal-body">
									<div class="table-responsive">
										<table id="verDocs" class="table table-bordered table-hover" width="100%" style="text-align:center;">
											<thead>
											<tr>
												<th><center>Cliente</center></th>
												<th><center>Hora / Fecha</center></th>
												<th><center>Documento</center></th>
												<th><center>Élite</center></th>
												<th><center>Ubicación</center></th>
											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
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
	var idlote_global = 0;

	$(document).ready(function()
	{
		$('#Jtabla').dataTable( {
			initComplete: function () {
				this.api().columns().every( function () {
					var column = this;
					var select = $('<select><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
					column.data().unique().sort().each( function ( d, j ) {

						select.append( '<option value="'+d+'">'+d+'</option>' )

					} );

				} );

			},
			"ajax":
				{
					"url": '<?=base_url()?>index.php/registroLote/getStatus3Docs',
					"dataSrc": ""
				},
			"scrollX":        true,
			"pageLength": '10',
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
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
			"columns":
				[
					{
						//data: 'nombreResidencial'
						data : function(data)
						{
							var tagSell;
							if(data.tipo_venta==1){tagSell = '<br><button class="btn btn-danger btn-xs">Venta Particular</button>'}
							if(data.tipo_venta==2){tagSell = '<br><button class="btn btn-primary btn-xs">Venta normal</button>'}
							if(data.tipo_venta==3){tagSell = '<br><button class="btn btn-warning btn-xs">Bono</button>'}
							if(data.tipo_venta==4){tagSell = '<br><button class="btn btn-success btn-xs" style="background-color: #4caf50;">Donación</button>'}
							if(data.tipo_venta==5){tagSell = '<br><button class="btn btn-xs">Intercambio</small>'}
							return data.nombreResidencial+tagSell;
						}
					},
					{data: 'nombreCondominio'},
					{data: 'nombreLote'},
					{data: 'gerente'},
					{data: 'asesor'},
					{
						data: function(data)
						{
							var nom1, nom2, app, apm;
							if(data.nombre!="" && data.nombre!=null){nom1= data.nombre;}else {nom1="";}
							if(data.apellido_paterno!="" && data.apellido_paterno!=null){app= data.apellido_paterno;}else{app="";}
							if(data.apellido_materno!="" && data.apellido_materno!=null){apm=data.apellido_materno;}else{apm="";}
							 return nom1 + " " + app + " " + apm;
						}
					},
					{
						data: function(data)
						{
							var status;
							if(data.idStatusContratacion==2 && data.idMovimiento==32){status="Status 2 listo (Asistentes Gerentes)";}
							if(data.idStatusContratacion==2 && data.idMovimiento==2){status="Status 2 enviado a Revisión (Asistentes Gerentes)";}
							if(data.idStatusContratacion==2 && data.idMovimiento==78){status="Status 2 enviado a Revisión (Contraloría)";}
							return status;
						}
					},
					{data: 'comentario'},
					{data: 'fechaApartado'},
					{data: 'fechaVenc'},
					{data: 'modificado'},
					{
						 data: function(data)
						 {
							 if(data.idStatusContratacion==2 && data.idMovimiento==32 && data.perfil=='contraloria' ||
								 data.idStatusContratacion==2 && data.idMovimiento==2 && data.perfil=='contraloria')
							 {
								 return'<a href="#" style="color:#2a942e" class="editReg" data-idLote="' + data.idLote +'" ><span class="material-icons">edit</span></a>'+'<a href="#" class="cancelReg" style="color:#ec4343" data-idLote="' + data.idLote +'" ><span class="material-icons">cancel</span></a>'+'<a href="#"  class="docReg" data-idLote="' + data.idLote +'" ><span class="material-icons">file_copy</span></a>';
							 }
						 }
					}
				]
		} );
	} );
	$(document).on('click', '.editReg', function(e)
	{
		$("#idStatusContratacion").empty().selectpicker('refresh');
		e.preventDefault();
		var $itself = $(this);
		var idLote= $itself.attr('data-idLote');
		$.post('editarLoteJuridicoStatusContratacion3/'+ $itself.attr('data-idLote'), function(data) {
			// idlote_global = idLote;
			// tableHistorial.ajax.reload();
			$('#idLote').val(data['lotes'].idLote);
			$('#nombreLote').val(data);
			$('#comentario').val(data['lotes'].comentario);
			// $('#idStatusContratacion').val(data['lotes'].idStatusContratacion);
			$('#nombreLote').val(data['lotes'].nombreLote);
			$('#idLote').val(data['lotes'].idLote);
			$('#idCliente').val(data['lotes'].idCliente);
			$('#idCondominio').val(data['lotes'].idCondominio);
			$('#fechaVenc').val(data['lotes'].fechaVenc);
			$('#nombreLotefake').val(data['lotes'].nombreLote);
			$('#comentario').text(data['lotes'].nombreLote);


			var len = data['juridicoStatus3'].length;
			for( var i = 0; i<len; i++)
			{
				var id = data['juridicoStatus3'][i]['idStatusContratacion'];
				var name = data['juridicoStatus3'][i]['nombreStatus'];
				$("#idStatusContratacion").append($('<option>').val(id).text(name));
			}
			$("#idStatusContratacion").selectpicker('refresh');

			$('#editReg').modal('show');
		}, 'json');
	});
	$(document).on('click', '.cancelReg', function(e)
	{
		e.preventDefault();
		var $itself = $(this);
		var idLote= $itself.attr('data-idLote');
		$.post('editarLoteRechazoJuridicoStatusContratacion3/'+ $itself.attr('data-idLote'), function(data)
		{
				idlote_global = idLote;
				$('#nombreLoteF').val(data.nombreLote);
			// 	// tableHistorial.ajax.reload();
				$('#nombreLoteR').val(data.nombreLote);
				$('#idLoteR').val(data.idLote);
				$('#idClienteR').val(data.idCliente);
				$('#idCondominioR').val(data.idCondominio);
			$('#rechReg').modal('show');
			console.log(data);
		}, 'json');
	});
	$(document).on('click', '.docReg', function(e) {
		e.preventDefault();
		var $itself = $(this);
		var idLote= $itself.attr('data-idLote');
		$.post('historialDocumentos/', {idLote: $itself.attr('data-idLote')}, function(data) {
			idlote_global = idLote;
			tableHistorial.ajax.reload();
			$('#docReg').modal('show');
		}, 'json');

		// $('#docReg').modal('show');
	});
	var tableHistorial;
	// var idlote_global = 0;
	$(document).ready (function() {
		tableHistorial = $('#verDocs').DataTable( {
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
				{
					data: function (data) {
						return data.primerNombre + " " + data.segundoNombre + " " + data.apellidoPaterno + " " + data.apellidoMaterno;
					}
				},
				{ "data": "modificado" },
				{
					data: function(data)
					{
						var mylinkDoc = '<a href="<?=base_url()?>static/documentos/cliente/expediente/'+data.expediente +'" target="_blank">'+data.expediente+'</a>';
						return mylinkDoc;
					}
				},
				{
					data: function(data)
					{
						return data.primerNom + " " + data.segundoNom + " " + data.apellidoPa + " " + data.apellidoMa;
					}
				},
				{ "data": "ubic" },

			],
			"ajax": {
				"url": '<?=base_url()?>index.php/registroLote/historialDocumentos/',
				"type": "POST",
				cache: false,
				"data": function( d ){
					d.idLote = idlote_global;
				}
			},
		});
	});
</script>
<script type="text/javascript">
	function pregunta(e)
	{
		if (confirm('¿Estas seguro de registrar el status?'))
		{
			if($('#comentario').val()!="")
			{
				var botonEnviar = document.getElementById('idRegistrar');
				botonEnviar.disabled = true;
				document.status.submit();
				alerts.showNotification('top','right','¡Status registrado!', 'success');
			}
			else
			{
				alerts.showNotification('top','right','¡Debes completar todos los campos!', 'warning');
				return false;
			}


		} else {

			e.preventDefault();

			alerts.showNotification('top','right','¡Se cancelo la operación!', 'danger');
			return false;
			//window.location = '<?//=base_url()?>//index.php/registroLote/registroStatus3ContratacionJuridico';

		}

	}
</script>
