<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar', $datos); ?>

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
									<h3 class="card-title center-align">Reporte rechazos </h3>
								</div>
								<div class="material-datatables"> 
									<div class="form-group">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tabla_reporte_11" name="tabla_reporte_11">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>ID LOTE</th>
														<th>CLIENTE</th>
														<th>FECHA APARTADO</th>
														<th>ESTATUS CONTRATACIÓN</th>
														<th>ESTATUS LOTE</th>
														<th>QUIEN RECHAZO</th>
														<th>FECHA RECHAZO</th>
                                                        <th>MOTIVO RECHAZO</th>
                                                        <th>MOVIMIENTO</th>
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


		$("#tabla_reporte_11").ready( function(){
			$('#tabla_reporte_11 thead tr:eq(0) th').each( function (i) {
				if(i != 0 && i != 10){
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
			$('#tabla_reporte_11 thead tr:eq(0) th').each( function (i) {
				if( i!=0 && i!=10){
				var title = $(this).text();

				titulos.push(title);
				}
			});

			tabla_9 = $("#tabla_reporte_11").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				buttons: [{
					extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
					exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8,9,10],
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
				columns: [
				{
					"width": "8%",
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
					"width": "6%",
					"data": function( d ){
						return '<p class="m-0">'+d.idLote+'</p>';
					}
				}, 
				{
					"width": "8%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombreCliente+'</p>';
					}
				}, 
				{
					"width": "6%",
					"data": function( d ){
						return '<p class="m-0">'+d.fechaApartado+'</p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
						return '<p class="m-0">'+d.estatusActual+'</p>';

					}
				}, 
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.estatusLote+'</p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
					    return '<p class="m-0">'+d.usuario+'</p>';
					}
				}, 
				{ 
					"width": "15%",
					"orderable": false,
					"data": function( d ){
						return '<p class="m-0">'+d.fechaRechazo+'</p>';
					} 
				}, 
				{ 
					"width": "15%",
					"orderable": false,
					"data": function( d ){
						return '<p class="m-0">'+d.motivoRechazo+'</p>';
					} 
				},
                {
                    "width": "15%",
                    "orderable": false,
                    "data": function( d ){
                        return '<p class="m-0">'+d.movimiento+'</p>';
                    }
                }],
				columnDefs: [{
					"searchable": false,
					"orderable": false,
					"targets": 0
				}],
				ajax: {
					"url": '<?=base_url()?>index.php/RegistroLote/getReporteRechazos',
					"dataSrc": "",
					"type": "POST",
					cache: false,
					"data": function( d ){
					}
				},
			});

			$('#tabla_reporte_11 tbody').on('click', 'td.details-control', function () {
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
					if (row.data().idStatusContratacion == 10 && row.data().idMovimiento == 40) {
						status = 'Status 10 listo (Contraloría)';
					}
					else if (row.data().idStatusContratacion == 8 && row.data().idMovimiento == 67 ) {
						status = 'Status 11 enviado a Revisión (Asistentes de Gerentes)';
					}
					else if (row.data().idStatusContratacion == 12 && row.data().idMovimiento == 42 ) {
						status = 'Status 12 Listo (Contraloría)';
					}
					else{
						status='N/A';
					}
					
					var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>Información colaboradores</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Estatus: </b>' +status+ '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Comentario: </b>' + row.data().comentario + '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Coordinador: </b>' +row.data().coordinador+ '</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor: </b>' + row.data().asesor + '</label></div></div></div>';


					row.child(informacion_adicional).show();
					tr.addClass('shown');
					$(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
				}
			});





		$("#tabla_reporte_11 tbody").on("click", ".editReg", function(e){
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

				document.getElementById("totalNeto").value = getInfo1[7];

				$('#editReg').modal('show');

				});


				$("#tabla_reporte_11 tbody").on("click", ".cancelReg", function(e){
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
						$('#tabla_reporte_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Estatus enviado.", "success");
					} else if(response.message == 'FALSE'){
						$('#save1').prop('disabled', false);
						$('#editReg').modal('hide');
						$('#tabla_reporte_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
					} else if(response.message == 'ERROR'){
						$('#save1').prop('disabled', false);
						$('#editReg').modal('hide');
						$('#tabla_reporte_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
					}
				},
				error: function( data ){
						$('#save1').prop('disabled', false);
						$('#editReg').modal('hide');
						$('#tabla_reporte_11').DataTable().ajax.reload();
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
						$('#tabla_reporte_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Estatus enviado.", "success");
					} else if(response.message == 'FALSE'){
						$('#save3').prop('disabled', false);
						$('#rechReg').modal('hide');
						$('#tabla_reporte_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "El status ya fue registrado.", "danger");
					} else if(response.message == 'ERROR'){
						$('#save3').prop('disabled', false);
						$('#rechReg').modal('hide');
						$('#tabla_reporte_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
					}
				},
				error: function( data ){
						$('#save3').prop('disabled', false);
						$('#rechReg').modal('hide');
						$('#tabla_reporte_11').DataTable().ajax.reload();
						alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
				}
				});
			
		}

	});


	jQuery(document).ready(function(){
		

		$('#comentario3').change(function() {
			if(document.getElementById('comentario3').value == "4") {
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
			alerts.showNotification("top", "left", "Solo Numeros.", "danger");
		return false;
		}
	}



	function formatMoney(number) {
		return '$'+ number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	$(document).ready(function(){
		$("#comentario3").empty().selectpicker('refresh');
		$.post(url + "RegistroLote/lista_rechazos", function(data) {
			var len = data.length;
			$("#comentario3").append($('<option disabled selected>SELECCIONA UNA OPCIÓN</option>'))
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['id_motivo'];
				var name = data[i]['motivo'];
				$("#comentario3").append($('<option>').val(id).text(name.toUpperCase()));
			}
			$("#comentario3").selectpicker('refresh');
		}, 'json');
	});

	</script>
</body>