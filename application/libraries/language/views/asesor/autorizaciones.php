
<body class="">
<div class="wrapper ">
	<?php
	$dato= array(
		'home' => 0,
		'listaCliente' => 0,
		'corridaF' => 0,
		'inventario' => 0,
		'prospectos' => 0,
		'prospectosAlta' => 0,
		'statistic' => 0,
		'comisiones' => 0,
		'DS'    => 0,
		'DSConsult' => 0,
		'documentacion' => 0,
		'inventarioDisponible'  =>  0,
		'manual'    =>  0,
		'nuevasComisiones'     => 0,
		'histComisiones'       => 0,
		'sharedSales' => 0,
		'coOwners' => 0,
		'references' => 0,
		'autoriza'=>	1,
        'clientsList' => 0
	);
	//$this->load->view('template/asesor/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
	?>

	<!-- modal para enviar a revision status corrida elborada -->
	<div class="modal fade" id="envARevCE" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Revisión Status (6. Corrida elaborada)</h4>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Lote:</label>
							<input type="text" class="form-control" id="nomLoteFakeenvARevCE" disabled>

							<br><br>

							<label>Status Contratación</label>
							<select required="required" name="idStatusContratacion" id="idStatusContratacionenvARevCE"
									class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7">
								<option value="6">  6. Corrida elaborada (Contraloría) </option>
							</select>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<label>Comentario:</label>
							<input type="text" class="form-control" name="comentario" id="comentarioenvARevCE">
							<br><br>
						</div>
						<input type="hidden" name="idLote" id="idLoteenvARevCE" >
						<input type="hidden" name="idCliente" id="idClienteenvARevCE" >
						<input type="hidden" name="idCondominio" id="idCondominioenvARevCE" >
						<input type="hidden" name="fechaVenc" id="fechaVencenvARevCE" >
						<input type="hidden" name="nombreLote" id="nombreLoteenvARevCE"  >
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="enviarenvARevCE" onClick="preguntaenvARevCE()" class="btn btn-primary"><span
							class="material-icons" >send</span> </i> Enviar a Revisión
					</button>
					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- insertar autorización modal 1-5-->
	<div class="modal fade" id="solicitarAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" >
				<form id="my_authorization_form" name="my_authorization_form" method="post">
					<div class="modal-header">
						<center><h4 class="modal-title">Solicitar autorización</h4></center>
					</div>
					<div class="modal-body">
						<label>Autoriza:</label><br>
						<select name="id_aut" id="dirAutoriza" class="selectpicker" data-style="btn btn-primary" title="TIPO USUARIO" data-size="7">
							<option value="0">--SELECCIONA--</option>
							<!--<option value="2400">Arq. Rigel Silva</option>-->
							<option value="2401">Ing. Jesús Torre</option>
							<option value="2402">Lic. Emilio Fernandez</option>
							<option value="2403">Lic. Francisco Martínez</option>
							<option value="2404">Lic. Adriana Mañas</option>
						</select><br><br><br>
						<label>Observaciones : </label>
						<textarea class="form-control" id="comentario_0" name="comentario_0" rows="3" style="width:100%;"
								  placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
						<input type="hidden" id="tamanocer" name="tamanocer" value="1" style="color: black">
						<input type="hidden" name="idCliente" id="idCliente">
						<input type="hidden" name="idLote" id="idLote">
						<input type="hidden" name="nombreCondominio" id="nombreCondominio">
						<input type="hidden" name="nombreResidencial" id="nombreResidencial">
						<input type="hidden" name="nombreLote" id="nombreLote">
						<input type="hidden" name="idCondominio" id="idCondominio">
						<input type="hidden" name="id_sol" id="id_sol">
						<br>
						<div id="autorizacionesExtra">

						</div>
						<div id="functionAdd">
							<a onclick="agregarAutorizacion()" style="float: right; color: black; cursor: pointer; " title="Agregar observación">
								<span class="material-icons">add</span>
							</a>
						</div>

						<br>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-primary" onclick="return validateEmptyFields()" id="btnSubmit"> Enviar autorización
						</a>

						<button type="submit" id="btnSubmitEnviar" class="btn btn-success hide"> Enviar autorización</button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- insertar autorización modal 1-5-->
	<div class="modal fade" id="verAutorizacionesAsesor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
		<div class="modal-dialog">
			<div class="modal-content" >
				<div class="modal-header">
					<h4 class="modal-title">Ver autorizaciones en proceso</h4>
				</div>
				<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div id="auts-loads">

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-simple" data-dismiss="modal">Aceptar</button>
				</div>
			</div>
		</div>
	</div>



	<div class="content">
		<div class="container-fluid">
			<!-- 			<h5 style="text-align: center">REGISTRO ESTATUS 6 (Corrida elaborada)</h5>-->
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content">
							<h4 class="card-title center-align">Autorizaciones</h4><br><br>
							<div class="toolbar">
							</div>
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#soli" data-toggle="tab">Solicitud</a></li>
									<li><a href="#aut" data-toggle="tab" onclick="javascript:$('#addExp').DataTable().ajax.reload();">Autorizaciones</a></li>
									<!--        <li><a href="#history" data-toggle="tab">Hitorial de Autorizaciones</a></li>-->
								</ul>

								<div class="tab-content">

									<div class="active tab-pane" id="soli">
										<div class="post">
											<div class="user-block">
												<table id="sol_aut" class="table table-bordered table-hover" style="text-align:center;width: 100%">
													<thead>
													<tr>
														<th>
															<center>Proyecto</center>
														</th>
														<th>
															<center>Condominio</center>
														</th>
														<th>
															<center>Lote</center>
														</th>
														<th>
															<center>Fecha/Hora</center>
														</th>
														<th>
															<center>Acciones</center>
														</th>
													</tr>
													</thead>
													<tfoot>
													<tr>
														<th>
															<center>Proyecto</center>
														</th>
														<th>
															<center>Condominio</center>
														</th>
														<th>
															<center>Lote</center>
														</th>
														<th>
															<center>Fecha/Hora</center>
														</th>
														<th>
															<center>Acciones</center>
														</th>
													</tr>
													</tfoot>
													<tbody></tbody>
												</table>
											</div>
										</div>
									</div>


									<div class="tab-pane" id="aut">
										<div class="post">
											<div class="user-block">
												<div class="table-responsive">
													<table id="addExp" class="table display table-bordered table-hover" style="text-align:center;width: 100%">
													<thead>
													<tr>
														<th>
															<center>Proyecto</center>
														</th>
														<th>
															<center>Condominio</center>
														</th>
														<th>
															<center>Lote</center>
														</th>
														<!--<th>
															<center>Estatus</center>
														</th>
														<th>
															<center>Detalle</center>
														</th>-->
														<th>
															<center>Solicita</center>
														</th>
														<th>
															<center>Autoriza</center>
														</th>
														<th>
															<center>Autorización</center>
														</th>
													</tr>
													</thead>
													<tfoot>
													<tr>
														<th>
															<center>Proyecto</center>
														</th>
														<th>
															<center>Condominio</center>
														</th>
														<th>
															<center>Lote</center>
														</th>
														<!--<th>
															<center>Estatus</center>
														</th>
														<th>
															<center>Detalle</center>
														</th>-->
														<th>
															<center>Solicita</center>
														</th>
														<th>
															<center>Autoriza</center>
														</th>
														<th>
															<center>Autorización</center>
														</th>
													</tr>
													</tfoot>
													<tbody></tbody>
												</table>
												</div>

											</div>
										</div>
									</div>

									<div class="tab-pane" id="history">
										<div class="post">
											<div class="user-block">
												<div class="form-group">
													<div class="col-md-4">
														<label>Proyecto</label>
														<select required="required" name="residencial" id="residencial"
																class="form-control select2">
															<option value="0" disabled selected>-SELECCIONA-</option>
															<?php foreach ($residencial as $row): ?>
																<option
																	value="<?= $row['idResidencial'] ?>"><?= $row['nombreResidencial'] ?></option>
															<?php endforeach; ?>
														</select>
													</div>
													<div class="col-md-4">
														<label>Condominio</label>
														<select class="form-control" id="filtro4" name="filtro4" required></select>
													</div>

													<div class="col-md-4">
														<label>Lote</label>
														<select class="form-control" id="filtro5" name="filtro5"></select>
													</div>

													<div class="col-md-12">
														<div class="block-title">
															<h2 style="color:#FFF">.</h2>
															<div class="block-options pull-right"></div>
														</div>
														<div class="table-responsive"></div>
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

	function validateEmptyFields(){
		var miArray = [];
		console.log("entró a la function "+ $("#tamanocer").val());
		for (i = 0; i < $("#tamanocer").val(); i++) {
			if ($("#comentario_"+i).val() == "") {
				$("#comentario_"+i).focus();
				console.log("no tiene nada ---- "+ $("#comentario_"+i).val());
				toastr.error("Asegúrate de haber llenado todos los campos mínimos requeridos");
				miArray.push(0);
				return false;
			}
			else {
				console.log("lo que sea" + $("#comentario_"+i).val());
				miArray.push(1);
				//$('#btnSubmitEnviar').click();
			}
		}
		$('#btnSubmitEnviar').click();
	}

	$("#my_authorization_form").on('submit', function(e){
		e.preventDefault();

		$.ajax({
			type: 'POST',
			url: '<?=base_url()?>index.php/asesor/addAutorizacionSbmt',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				$('#btnSubmit').attr("disabled","disabled");
				$('#btnSubmit').css("opacity",".5");

			},
			success: function(data) {
				if (data == 1) {
					$('#btnSubmit').prop('disabled', false);
					$('#btnSubmit').css("opacity","1");
					$('#solicitarAutorizacion').modal("hide");
					//toastr.success("Se enviaron las autorizaciones correctamente");
					$('#addExp').DataTable().ajax.reload();
					$('#sol_aut').DataTable().ajax.reload();
					alerts.showNotification('top', 'right', 'Se enviaron las autorizaciones correctamente', 'success');
				} else {
					$('#btnSubmit').prop('disabled', false);
					$('#btnSubmit').css("opacity","1");
					//toastr.error("Asegúrate de haber llenado todos los campos mínimos requeridos");
					alerts.showNotification('top', 'right', 'Asegúrate de haber llenado todos los campos mínimos requeridos', 'danger');
				}
			},
			error: function(){
				$('#btnSubmit').prop('disabled', false);
				$('#btnSubmit').css("opacity","1");
				//toastr.error("ops, algo salió mal.");
				alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
			}
		});
	});

	$('#residencial').change(function(){
		var valorSeleccionado = $(this).val();
		$('#filtro4').load("<?= site_url('registroCliente/getCondominioDesc') ?>/"+valorSeleccionado, function(){
		});
	});

	$('#filtro4').change(function(){
		var residencial = $('#filtro3').val()
		var valorSeleccionado = $(this).val();
		$('#filtro5').load("<?= site_url('registroCliente/getLotesAsesor') ?>/"+valorSeleccionado+'/'+residencial);
	});

	$('#filtro5').change(function(){
		var valorSeleccionado = $(this).val();
		$('.table-responsive').load("<?= site_url('registroCliente/get_log_aut') ?>/"+valorSeleccionado);
	});



	var miArray = new Array(6);
	var miArrayAddFile = new Array(6);

	var getInfo2A = new Array(7);
	var getInfo2_2A = new Array(7);
	var getInfo5A = new Array(7);
	var getInfo6A = new Array(7);
	var getInfo2_3A = new Array(7);
	var getInfo2_7A = new Array(7);


	var aut;

	$(document).ready (function() {
		var table;
		table = $('#addExp').DataTable( {
			dom: 'Bfrtip',
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
			"scrollX": true,
			'fixedHeader': true,
			"pageLength": 10,
			'width':'100%',
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			"order": [[4, "desc"]],

			columns: [
				{ "data": "nombreResidencial" },
				{ "data": "nombreCondominio" },
				{ "data": "nombreLote" },
				/*{
				  "data": function( d ){
					 aut =  d.estatus == 1 ?  "<small class='label bg-red'>En proceso</small>":
								d.estatus == 2 ?  '<a href="" class="getInfo" data-idCliente="'+d.idCliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'"><i class="fa fa-key fa-2x" aria-hidden="true"></i></a> <br> <small class="label bg-red">Denegada</small>':
							d.estatus == 0 ?  '<a href="" class="getInfo" data-idCliente="'+d.idCliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'"><i class="fa fa-key fa-2x" aria-hidden="true"></i></a> <br> <small class="label bg-green">Autorizado</small>':
							 '<a href="" class="getInfo" data-idCliente="'+d.idCliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'"><i class="fa fa-key fa-2x" aria-hidden="true"></i></a>';
							return aut;

				   }
				},
				{ "data": "autorizacion" },*/
				{ "data": "sol" },
				{ "data": "aut" },
				// { "data": "fecha_creacion" },
				{
					// "data": "fecha_creacion"
					"data": function( d )
					{
						return "<a href='#' class='seeAuts' data-id_autorizacion='"+d.id_autorizacion+"' data-idLote='"+d.idLote+"'><i class='fa fa-eye'></i> Ver autorizaciones</a>";
					}
				}
			],

			"ajax": {
				"url": "<?=base_url()?>index.php/asesor/getAutorizacionAs/",
				"type": "POST",
				cache: false
			},
		});



	});





	////////////////////////////// TABLE SOL AUT ///////////////////////////////////

	$(document).ready (function() {
		var table2;

		table2 = $('#sol_aut').DataTable( {
			dom: 'Bfrtip',
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
			"scrollX": true,
			"pageLength": 10,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			"order": [[4, "desc"]],

			columns: [
				{ "data": "nombreResidencial" },
				{ "data": "nombreCondominio" },
				{ "data": "nombreLote" },
				{ "data": "fechaApartado" },
				{
					"data": function( d ){
						aut = '<a href="#" class="addAutorizacionAsesor" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" data-idLote="'+d.idLote+'"><i class="fa fa-handshake-o fa-2x" aria-hidden="true" title="Solicitar Autorización"></i></a>';
						return aut;
					}
				}
			],
			"ajax": {
				"url": "<?=base_url()?>index.php/asesor/get_sol_aut/",
				"type": "POST",
				cache: false
			},
		});



	});


	$(document).on('click', '.addAutorizacionAsesor', function(e) {
		e.preventDefault();
		var $itself = $(this);
		console.log('diste click en abrir modal alv pa añadir una autorización');
		$('#idCliente').val($itself.attr('data-idCliente'));
		$('#idLote').val($itself.attr('data-idLote'));
		$('#nombreCondominio').val($itself.attr('data-nombreCondominio'));
		$('#nombreResidencial').val($itself.attr('data-nombreResidencial'));
		$('#nombreLote').val($itself.attr('data-nombreLote'));
		$('#idCondominio').val($itself.attr('data-idCondominio'));
		$('#id_sol').val(<?=$this->session->userdata('id_usuario')?>);
		$('#solicitarAutorizacion').modal('show');
	});

	$(document).on('click', '.seeAuts', function (e) {
		e.preventDefault();
		var $itself = $(this);
		var idLote=$itself.attr('data-idLote');
		$.post( "<?=base_url()?>index.php/asesor/get_auts_by_lote/"+idLote, function( data ) {
			console.log("Las autorizaciones de este lote son: ");
			console.log(data);
			/*var obj = JSON.parse(data);
			var length = Object.keys(obj).length;*/
			$('#auts-loads').empty();
			var statusProceso;
			$.each(JSON.parse(data), function(i, item) {
				console.log(item['estatus']);
				// console.log(item['autorizacion']);
				// console.log(item['id_autorizacion']);
				if(item['estatus'] == 0)
				{
					statusProceso="<small class='label bg-green' style='background-color: #00a65a;border-radius: 0px'>ACEPTADA</small>";
				}
				else if(item['estatus'] == 1)
				{
					statusProceso="<small class='label bg-orange' style='background-color: #ffaa00;border-radius: 0px'>En proceso</small>";
				}
				else if(item['estatus'] == 2)
				{
					statusProceso="<small class='label bg-red' style='background-color: #ff0000;border-radius: 0px'>DENEGADA</small>";
				}
				else if(item['estatus'] == 3)
				{
					statusProceso="<small class='label bg-blue' style='background-color: #002a80;border-radius: 0px'>En DC</small>";
				}
				else
				{
					statusProceso="<small class='label bg-gray' style='background-color: #a0a0a0;border-radius: 0px'>N/A</small>";
				}
				$('#auts-loads').append('<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-7"><label>Solicitud de autorización:  '+statusProceso+'</label></div><div class="col col-xs-12 col-sm-12 col-md-12 col-lg-5" style="font-size: 0.8em;text-align: right"><small>'+item['fecha_creacion']+'</small></div>');
				$('#auts-loads').append('<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"><p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +
					'<br><hr style="border-top: 1px solid #565656;"></div>');

			});
			// $('#auts-loads')
			// <label>Autorizaciones para:</label><br>

			$('#verAutorizacionesAsesor').modal('show');
		});
	});


	var contador = 1;
	function agregarAutorizacion ()
	{
		/*autorizacionesExtra*/
		// var contador = 2;
		$("#autorizacionesExtra").append('<div id="cnt-'+contador+'"><hr><label>Observación: </label><br>' +
			'<a onclick="eliminaAutorizacion('+contador+')" style="float: right; color: red; cursor:pointer" title="Eliminar observación"><span class="material-icons">delete</span></a><br>' +
			'<textarea type="text" name="comentario_' + contador + '" placeholder="comentario" ' +
			'class="form-control" id="comentario_'+ contador +'" rows="3" style="width:100%;" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea></div>');
		contador = contador + 1;
		$('#tamanocer').val(contador);

		validateNumsOfAutorizacion();


	}

	function eliminaAutorizacion(contenedor)
	{
		console.log(contenedor);
		$('#cnt-'+contenedor).remove();
		contador = contador - 1;
		$('#tamanocer').val(contador);

		validateNumsOfAutorizacion();
	}

	function validateNumsOfAutorizacion()
	{
		if($('#tamanocer').val() == 5)
		{
			console.log('YA SON 5 ALV: ' + contador);
			$('#functionAdd').html('');
		}
		else
		{
			if(contador<=4 && $('#functionAdd').is(':empty'))
			{
				$('#functionAdd').append('<a onclick="agregarAutorizacion()"  style="float: right; color: black; cursor: pointer; " title="Agregar observación"><span class="material-icons">add</span></a>');
			}
		}
	}

	$(document).ready(function () {
		validateNumsOfAutorizacion();

		<?php
		if($this->session->userdata('success') == 1)
		{
			echo 'toastr.success("Se enviaron las autorizaciones correctamente");';
			echo 'console.log("logrado correctamente");';
			$this->session->unset_userdata('success');

		}
		elseif($this->session->userdata('error') == 99)
		{
			echo 'toastr.error("Ocurrio un error al enviar la autorización	");';
			echo 'console.log("OCURRIO UN ERROR");';
			$this->session->unset_userdata('error');
		}
		?>

		$("#dirAutoriza").empty().selectpicker('refresh');
		$.ajax({
			url: '<?=base_url()?>registroCliente/getActiveDirs/',
			type: 'post',
			dataType: 'json',
			success:function(response){
				var len = response.length;
				for( var i = 0; i<len; i++)
				{
					var id = response[i]['id_usuario'];
					var name = response[i]['nombre']+' '+response[i]['apellido_paterno']+' '+response[i]['apellido_materno'];
					$("#dirAutoriza").append($('<option>').val(id).text(name));
				}
				$("#dirAutoriza").selectpicker('refresh');

			}
		});

	});


</script>
