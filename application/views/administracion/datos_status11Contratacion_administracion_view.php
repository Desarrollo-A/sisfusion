<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php
		/*-------------------------------------------------------*/
		$datos = array();
		$datos = $datos4;
		$datos = $datos2;
		$datos = $datos3;  
				$this->load->view('template/sidebar', $datos);
		/*--------------------------------------------------------*/
		?>

		<!-- Modals -->
		<div class="modal fade" id="modal_registrar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><b>Validación</b> de enganche.</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class=""></h5>
					</div>
					<form id="my-edit-form" name="my-edit-form" method="post">
						<div class="modal-body">
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal_cancelar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><b>Rechazar</b> estatus.</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h5 class=""></h5>
					</div>
					<form id="my-edit-form" name="my-edit-form" method="post">
						<div class="modal-body">
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- modal  ENVIA A CONTRALORIA 7-->
		<div class="modal fade" id="editReg" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<center><h4 class="modal-title"><label>Registro estatus 11 - <b><span class="lote"></span></b></label></h4></center>
					</div>
					<div class="modal-body">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
								<label>Comentario:</label>
								<textarea class="form-control" id="comentario" rows="3"></textarea>
								<br>
							</div>

							<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label id="tvLbl">Total a validar:</label>
								<input class="form-control" name="totalNeto" id="totalNeto" oncopy="return false" onpaste="return false" readonly
                                       type="tel" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency">
							</div>


							<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label id="tvLbl">Total validado:</label>
								<input type="tel" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" class="form-control" name="totalValidado" id="totalValidado" oncopy="return false" onpaste="return false" onkeypress="return SoloNumeros(event)">

							</div>
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar</button>
						<button type="button" id="save1" class="btn btn-primary"> Registrar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- modal  rechazar A CONTRALORIA 7-->
		<div class="modal fade" id="rechReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="material-icons">clear</i>
						</button>
						<h4 class="modal-title"><center>Rechazo estatus 11 - <b><span class="lote"></span></b></center></h4>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-12">
										<label id="tvLbl">Comentario:</label>
										<select name="comentario3" id="comentario3" class="selectpicker select-gral m-0" data-style="btn btn-round" required="required" />
											<option value="0">Selecciona una opción</option>
											<option value="Transferencia no reflejada en Banco">Transferencia no reflejada en Banco</option>
											<option value="Cheque rebotado">Cheque rebotado</option>
											<option value="Rechazo por falta de dinero">Rechazo por falta de dinero</option>
											<option value="Otro">Otro</option>
										</select>
										<div id="valida_otro" style="display:none">
											<br>
											<label>Observaciones:</label>
											<textarea class="form-control input-gral" id="observaciones" rows="3" style="text-align:center"></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="save3" class="btn btn-primary">Registrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END Modals -->

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-box fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
									<h3 class="card-title center-align">Registro estatus 11</h3>
									<p class="card-title pl-1">(Validación de enganche)</p>
								</div>
								<div class="material-datatables"> 
									<div class="form-group">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tabla_ingresar_11" name="tabla_ingresar_11">
												<thead>
													<tr>
														<th></th>
														<th></th>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>GERENTE</th>
														<th>CLIENTE</th>
														<th>TOTAL NETO</th>
														<th>FECHA REALIZADO</th>
														<th>FECHA VENC</th>
														<th>DÍAS TRANSC</th>
														<th>ESTATUS ACTUAL</th>
														<th></th>
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
		var url = "<?=base_url()?>";
		var url2 = "<?=base_url()?>index.php/";
		var getInfo1 = new Array(7);
		var getInfo3 = new Array(6);


		$("#tabla_ingresar_11").ready( function(){
			$('#tabla_ingresar_11 thead tr:eq(0) th').each( function (i) {
				if(i != 0 && i != 12){
					var title = $(this).text();
					$(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
					$( 'input', this ).on('keyup change', function () {
						if (tabla_9.column(i).search() !== this.value ) {
							tabla_9
							.column(i)
							.search(this.value)
							.draw();
						}
					} );
				}
			});

			let titulos = [];
			$('#tabla_ingresar_11 thead tr:eq(0) th').each( function (i) {
				if( i!=0 && i!=13){
				var title = $(this).text();

				titulos.push(title);
				}
			});

			tabla_9 = $("#tabla_ingresar_11").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				buttons: [{
					extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
						format: {
							header:  function (d, columnIdx) {
								if(columnIdx == 0){
									return ' '+d +' ';
								}
								return ' '+titulos[columnIdx-1] +' ';
									
							}
						}
					}
				}],
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
				columns: [{
					"width": "3%",
					"className": 'details-control',
					"orderable": false,
					"data" : null,
					"defaultContent": '<div class="toggle-subTable"><i class="animacion fas fa-chevron-down fa-lg"></i>'
				},
				{
					"data": function( d ){
						var lblStats;
						if(d.tipo_venta==1) {
							lblStats ='<span class="label label-danger">Venta Particular</span>';
						}
						else if(d.tipo_venta==2) {
							lblStats ='<span class="label label-success">Venta normal</span>';
						}
						else if(d.tipo_venta==3) {
							lblStats ='<span class="label label-warning">Bono</span>';
						}
						else if(d.tipo_venta==4) {
							lblStats ='<span class="label label-primary">Donación</span>';
						}
						else if(d.tipo_venta==5) {
							lblStats ='<span class="label label-info">Intercambio</span>';
						}
						else if(d.tipo_venta==6) {
							lblStats ='<span class="label label-secondary">Reubicación</span>';
						}
						else if(d.tipo_venta==7) {
							lblStats ='<span class="label label-secondary">Venta especial</span>';
						}
						else if(d.tipo_venta== null) {
							lblStats ='<span class="label label-info"></span>';
						}

						return lblStats;
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombreResidencial+'</p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
						return '<p class="m-0">'+(d.nombreCondominio).toUpperCase();+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombreLote+'</p>';

					}
				}, 
				{
					"width": "12%",
					"data": function( d ){
						return '<p class="m-0">'+d.gerente+'</p>';
					}
				}, 
				{
					"width": "12%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombreCliente+'</p>';
					}
				}, 
				{
					"width": "6%",
					"data": function( d ){
						var a = (d.totalNeto == null || d.totalNeto == .00) ? formatMoney(0) : formatMoney(d.totalNeto);
						return '<p class="m-0">' + a + '</p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
						return '<p class="m-0">'+d.modificado+'</p>';

					}
				}, 
				{
					"width": "10%",
					"data": function( d ){
						var fechaVenc;
						if (d.idStatusContratacion == 10 && d.idMovimiento == 40 || d.idStatusContratacion == 8 && d.idMovimiento == 67 ||
						d.idStatusContratacion == 12 && d.idMovimiento == 42 || d.idStatusContratacion == 7 && d.idMovimiento == 37 ||
						d.idStatusContratacion == 7 && d.idMovimiento == 7 || d.idStatusContratacion == 7 && d.idMovimiento == 64 ||
						d.idStatusContratacion == 7 && d.idMovimiento == 77 ||
						d.idStatusContratacion == 8 && d.idMovimiento == 38 || d.idStatusContratacion == 8 && d.idMovimiento == 65) {
							fechaVenc = d.fechaVenc2;
						} 
						else {
							fechaVenc='N/A';
						}
						
						return '<p class="m-0">' + fechaVenc + '</p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
						
						/*var date_r =  new Date();
						var hoy= date_r.toISOString().substring(0, 10);
						var dateH =  new Date(hoy);
						
						var date_fv= new Date(d.fechaVenc2);
						var venc= date_fv.toISOString().substring(0, 10);
						var dateV = new Date(venc);

						var diasasml = 86400000;
						var difinml = dateV - dateH;
						var dif_dias = difinml / diasasml;
						
						var res = (dif_dias < 1) ? 'Vencido' : dif_dias;
						
						return '<p class="m-0">'+ res +'</p>';*/

                        if(d.fechaVenc2=='N/A'){
                            return '<p class="m-0">N/A</p>';
                        }else{
                            var dateFuture = new Date(d.fechaVenc2);
                            var dateNow = new Date();

                            /*console.log("TF: " + dateFuture);
                            console.log(dateNow);*/

                            var seconds = Math.floor((dateFuture - (dateNow))/1000);
                            var minutes = Math.floor(seconds/60);
                            var hours = Math.floor(minutes/60);
                            var days = Math.floor(hours/24);

                            hours = hours-(days*24);
                            minutes = minutes-(days*24*60)-(hours*60);
                            seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);

                            if(days < 0){
                                return 'Vencido';
                            }
                            else{
                                return '<p style="font-size: .9em">Vence en:' + days + ' día(s), ' + hours + ' hora(s), ' + minutes + ' minuto(s)</p>';
                            }
                        }
					}
				}, 
				{
					"width": "8%",
					"data": function( d ){
						return '<p class="m-0">'+d.descripcion+'</p>';

					}
				},
				{ 
					"width": "30%",
					"orderable": false,
					"data": function( data ){
						var cntActions;

						if(data.vl == '1') {
							cntActions = 'En proceso de Liberación';
						} 
						else {
							if(data.idStatusContratacion == 10 && data.idMovimiento == 40 ||
								data.idStatusContratacion == 8 && data.idMovimiento == 67 ||
								data.idStatusContratacion == 12 && data.idMovimiento == 42 ||
								data.idStatusContratacion == 7 && data.idMovimiento == 37 ||
								data.idStatusContratacion == 7 && data.idMovimiento == 7 ||
								data.idStatusContratacion == 7 && data.idMovimiento == 64 ||
								data.idStatusContratacion == 7 && data.idMovimiento == 77 ||
								data.idStatusContratacion == 8 && data.idMovimiento == 38 ||
								data.idStatusContratacion == 8 && data.idMovimiento == 65
								){
									cntActions = '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
									'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'" data-tot="'+data.totalNeto+'" ' +
									'class="btn-data btn-green editReg" title="Registrar estatus">' +
									'<i class="far fa-thumbs-up"></i></button>';

									cntActions += '<button href="#" data-idLote="'+data.idLote+'" data-nomLote="'+data.nombreLote+'" data-idCond="'+data.idCondominio+'"' +
									'data-idCliente="'+data.id_cliente+'" data-fecVen="'+data.fechaVenc+'" data-ubic="'+data.ubicacion+'"  ' +
									'class="btn-data btn-warning cancelReg" title="Rechazo/regreso estatus (Juridico)">' +
									'<i class="far fa-thumbs-down"></i></button>';
							}
							else{
								cntActions ='N/A';
							}
						}

						return '<div class="d-flex justify-center">'+cntActions+'</div>';
					} 
				}],
				columnDefs: [{
					"searchable": false,
					"orderable": false,
					"targets": 0
				}],
				ajax: {
					"url": '<?=base_url()?>index.php/Administracion/datos_estatus_11_datos',
					"dataSrc": "",
					"type": "POST",
					cache: false,
					"data": function( d ){
					}
				},
			});

			$('#tabla_ingresar_11 tbody').on('click', 'td.details-control', function () {
				var tr = $(this).closest('tr');
				var row = tabla_9.row(tr);

				if (row.child.isShown()) {
					row.child.hide();
					tr.removeClass('shown');
					$(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
				} 
				else {
					var status;
					var fechaVenc;

					status = row.data().descripcion;
					
					var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Estatus: </b>' +status+ '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Comentario: </b>' + row.data().comentario + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>' +row.data().coordinador+ '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>' + row.data().asesor + '</label></div></div></div>';

					row.child(informacion_adicional).show();
					tr.addClass('shown');
					$(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
				}
			});





		$("#tabla_ingresar_11 tbody").on("click", ".editReg", function(e){
				e.preventDefault();

				getInfo1[0] = $(this).attr("data-idCliente");
				getInfo1[1] = $(this).attr("data-nombreResidencial");
				getInfo1[2] = $(this).attr("data-nombreCondominio");
				getInfo1[3] = $(this).attr("data-idcond");
				getInfo1[4] = $(this).attr("data-nomlote");
				getInfo1[5] = $(this).attr("data-idLote");
				getInfo1[6] = $(this).attr("data-fecven");
				getInfo1[7] = $(this).attr("data-tot");

				nombreLote = $(this).data("nomlote");
				$(".lote").html(nombreLote);

				let val = getInfo1[7];
				if(val=='.00' || val=='null'){
                    val = 0;
                }
                document.getElementById("totalNeto").value = val;
                $('#totalNeto').click();
				$('#editReg').modal('show');

				});


				$("#tabla_ingresar_11 tbody").on("click", ".cancelReg", function(e){
				e.preventDefault();

				getInfo3[0] = $(this).attr("data-idCliente");
				getInfo3[1] = $(this).attr("data-nombreResidencial");
				getInfo3[2] = $(this).attr("data-nombreCondominio");
				getInfo3[3] = $(this).attr("data-idcond");
				getInfo3[4] = $(this).attr("data-nomlote");
				getInfo3[5] = $(this).attr("data-idLote");
				getInfo3[6] = $(this).attr("data-fecven");
				getInfo3[7] = $(this).attr("data-code");

				nombreLote = $(this).data("nomlote");
				$(".lote").html(nombreLote);

				$('#rechReg').modal('show');

				});



	});



	$(document).on('click', '#save1', function(e) {
	e.preventDefault();

	var comentario = $("#comentario").val();
	var totalValidado = $("#totalValidado").val();


	var validaComent = ($("#comentario").val().length == 0) ? 0 : 1;
	var totalValidado_v = ($("#totalValidado").val().length == 0) ? 0 : 1;


	var dataExp1 = new FormData();

	dataExp1.append("idCliente", getInfo1[0]);
	dataExp1.append("nombreResidencial", getInfo1[1]);
	dataExp1.append("nombreCondominio", getInfo1[2]);
	dataExp1.append("idCondominio", getInfo1[3]);
	dataExp1.append("nombreLote", getInfo1[4]);
	dataExp1.append("idLote", getInfo1[5]);
	dataExp1.append("comentario", comentario);
	dataExp1.append("fechaVenc", getInfo1[6]);
	dataExp1.append("totalValidado", totalValidado);


		if (validaComent == 0 || totalValidado_v == 0) {
					alerts.showNotification("top", "right", "Todos los campos son obligatorios.", "danger");
		}
		
		if (validaComent == 1 && totalValidado_v == 1) {

			$('#save1').prop('disabled', true);
				$.ajax({
				url : '<?=base_url()?>index.php/Administracion/editar_registro_lote_administracion_proceceso11/',
				data: dataExp1,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				success: function(data){
				response = JSON.parse(data);

					if(response.message == 'OK') {
						$('#save1').prop('disabled', false);
						$('#editReg').modal('hide');
						$('#tabla_ingresar_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Estatus enviado.", "success");
					} else if(response.message == 'FALSE'){
						$('#save1').prop('disabled', false);
						$('#editReg').modal('hide');
						$('#tabla_ingresar_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
					} else if(response.message == 'ERROR'){
						$('#save1').prop('disabled', false);
						$('#editReg').modal('hide');
						$('#tabla_ingresar_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
					}
				},
				error: function( data ){
						$('#save1').prop('disabled', false);
						$('#editReg').modal('hide');
						$('#tabla_ingresar_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
				}
				});
			
		}

	});



	$(document).on('click', '#save3', function(e) {
	e.preventDefault();

			var comentario = $("#comentario3").val();

		if(comentario != 'Otro'){
			
			var comentario = $("#comentario3").val();
			var validaComent = ($("#comentario3").val() == 0) ? 0 : 1;

			
		} else {
			
			var comentario = $("#observaciones").val();
			var validaComent = ($("#observaciones").val().length == 0) ? 0 : 1;
			
		}



	var dataExp3 = new FormData();

	dataExp3.append("idCliente", getInfo3[0]);
	dataExp3.append("nombreResidencial", getInfo3[1]);
	dataExp3.append("nombreCondominio", getInfo3[2]);
	dataExp3.append("idCondominio", getInfo3[3]);
	dataExp3.append("nombreLote", getInfo3[4]);
	dataExp3.append("idLote", getInfo3[5]);
	dataExp3.append("comentario", comentario);
	dataExp3.append("fechaVenc", getInfo3[6]);

		if (validaComent == 0) {
					alerts.showNotification("top", "right", "Selecciona un comentario.", "danger");
		}
		
		if (validaComent == 1) {

			$('#save3').prop('disabled', true);
				$.ajax({
				url : '<?=base_url()?>index.php/Administracion/editar_registro_loteRechazo_administracion_proceceso11/',
				data: dataExp3,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				success: function(data){
				response = JSON.parse(data);

					if(response.message == 'OK') {
						$('#save3').prop('disabled', false);
						$('#rechReg').modal('hide');
						$('#tabla_ingresar_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Estatus enviado.", "success");
					} else if(response.message == 'FALSE'){
						$('#save3').prop('disabled', false);
						$('#rechReg').modal('hide');
						$('#tabla_ingresar_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
					} else if(response.message == 'ERROR'){
						$('#save3').prop('disabled', false);
						$('#rechReg').modal('hide');
						$('#tabla_ingresar_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
					}
				},
				error: function( data ){
						$('#save3').prop('disabled', false);
						$('#rechReg').modal('hide');
						$('#tabla_ingresar_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
				}
				});
			
		}

	});


	jQuery(document).ready(function(){
		

		$('#comentario3').change(function() {
			if(document.getElementById('comentario3').value == "Otro") {
				document.getElementById('valida_otro').style.display='block';
			} else {
				document.getElementById('valida_otro').style.display='none';
			}
		}); 



		jQuery('#editReg').on('hidden.bs.modal', function (e) {
		jQuery(this).removeData('bs.modal');
		jQuery(this).find('#comentario').val('');
		jQuery(this).find('#totalNeto').val('');
		jQuery(this).find('#totalValidado').val('');
		})

		jQuery('#rechReg').on('hidden.bs.modal', function (e) {
		jQuery(this).removeData('bs.modal');
		jQuery(this).find('#comentario3').val('0');
		jQuery(this).find('#observaciones').val('');
		document.getElementById('valida_otro').style.display='none';
		})

	})



	function SoloNumeros(evt){
		if(window.event){
		keynum = evt.keyCode; 
		}
		else{
		keynum = evt.which;
		} 

		if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
		return true;
		}
		else{
			alerts.showNotification("top", "right", "Recuerda sólo ingresar números", "danger");
		return false;
		}
	}



	function formatMoney(number) {
		return '$'+ number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

        // Jquery Dependency
        $("input[data-type='currency']").on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            },
            click: function() {
                formatCurrency($(this));
            },
        });

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }
        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") { return; }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = "$" + left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = "$" + input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
	</script>
</body>