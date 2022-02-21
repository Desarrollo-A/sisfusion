<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
	<div class="wrapper">
		<?php
		/*-------------------------------------------------------*/
			$datos = array();
			$datos = $datos4;
			$datos = $datos2;
			$datos = $datos3;  
			$this->load->view('template/sidebar', $datos);
		?>

		<!-- Modals -->
		<div class="modal fade" id="verDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<center><b><h4 class="card-title ">Ventas compartidas</h4></b></center>
						<div class="table-responsive">
							<table id="verDet" class="table-striped table-hover">
								<thead>
								<tr>
									<th>GERENTE</th>
									<th>COORDINADOR</th>
									<th>ASESOR</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
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
								<i class="fas fa-user-friends fa-2x"></i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align">Búsqueda detallada de clientes</h3>
								<div class="toolbar">
									<div class="row">
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating">
												<label class="control-label label-gral">Nombre</label>
												<input type="text" class="form-control input-gral" name="nombre" id="nombre">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating">
												<label class="control-label label-gral">Apellido Paterno</label>
												<input type="text" class="form-control input-gral" name="apellido_paterno" id="apellido_paterno">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating">
												<label class="control-label label-gral">Apellido Materno</label>
												<input type="text" class="form-control input-gral" name="apellido_materno" id="apellido_materno">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating">
												<label class="control-label label-gral">Correo</label>
												<input type="email" class="form-control input-gral" name="correo" id="correo">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating">
												<label class="control-label label-gral">Teléfono</label>
												<input type="text" class="form-control input-gral" name="telefono" id="telefono">
											</div>
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<div class="form-group label-floating">
												<button class="btn-gral-data d-flex justify-center align-center" id="buscarBtn"><span class="material-icons">search</span>Buscar</button>
											</div>
										</div>
									</div>
								</div>
								<br>
								<div class="material-datatables">
									<div class="form-group">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tabla_clientes" name="tabla_clientes">
												<thead>
													<tr>
														<th></th>
														<th>ID LOTE</th>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>CLIENTE</th>
														<th>NO. RECIBO</th>
														<th>TIPO PAGO</th>
														<th>FECHA APARTADO</th>
														<th>ENGANCHE</th>
														<th>FECHA ENGANCHE</th>
														<th>ASESOR</th>
														<th>ACCIONES</th>
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
	<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
	<script>
		userType = <?= $this->session->userdata('id_rol') ?> ;
		typeTransaction = 1;
	</script>

	<!-- MODAL WIZARD -->
	<?php
	if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5)
	{
	?>
		<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>
	<?php
	} 
	?>

	<script>
		$('#tabla_clientes thead tr:eq(0) th').each( function (i) {
			var title = $(this).text();
			if ( i != 0 && i != 12) {
				$(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
				$( 'input', this ).on('keyup change', function () {
					if (tabla_valores_cliente.column(i).search() !== this.value ) {
						tabla_valores_cliente
						.column(i)
						.search(this.value)
						.draw();
					}
				});
			}
		});

		$('#verDet thead tr:eq(0) th').each( function (i) {
			var title = $(this).text();
			$(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
			$( 'input', this ).on('keyup change', function () {
				if (verDet.column(i).search() !== this.value ) {
					verDet
					.column(i)
					.search(this.value)
					.draw();
				}
			});
		});

		$(document).ready(function (){
			var url='';
			$(document).on('click', '#buscarBtn', function (){
				var nombreField = $('#nombre').val();
				var correoField = $('#correo').val();
				var telefonoField = $('#telefono').val();
				var apellido_paterno = $('#apellido_paterno').val();
				var apellido_materno = $('#apellido_materno').val();

				//correo y telefono vacío    ---- NOMBRE
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && apellido_paterno.length <= 0 && apellido_materno.length <= 0){
					let busquedaParams = {nombre: nombreField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//nombre y telefono vacio  --- CORREO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && apellido_paterno.length <= 0 && apellido_materno.length <= 0){
					let busquedaParams = {correo: correoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);

				}
				//nombre y correo vacio  ---- TELEFONO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && apellido_paterno.length <= 0 && apellido_materno.length <= 0){
					let busquedaParams = {telefono: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//*actualizacion 021020*/
				//nombre, correo y telefono, ap_materno vacio  ---- AP_PATERNO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && apellido_materno.length <= 0
				&& apellido_paterno.length > 0){
					let busquedaParams = {apellido_paterno: apellido_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//nombre, correo y telefono, ap_paterno vacio  ---- AP_MATERNO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && apellido_materno.length > 0
					&& apellido_paterno.length <= 0){
					let busquedaParams = {apellido_materno: apellido_materno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				/************/
				//telefono vacío   ----- NOMBRE + CORREO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0  && apellido_paterno.length <= 0 && apellido_materno.length <= 0){
					let busquedaParams = {nombre: nombreField, correo: correoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//correo vacío    ------ NOMBRE + TELEFONO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0  && apellido_paterno.length <= 0 && apellido_materno.length <= 0){
					let busquedaParams = {nombre: nombreField, telefono: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				/**nuevos en nombre***/
				//correo, telefono, ap_materno vacío    ------ NOMBRE + AP_PATERNO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && apellido_paterno.length > 0 && apellido_materno.length <= 0){
					let busquedaParams = {nombre: nombreField, apellido_paterno: apellido_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//correo, telefono, ap_paterno vacío    ------ NOMBRE + AP_MATERNO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && apellido_paterno.length <= 0 && apellido_materno.length > 0){
					let busquedaParams = {nombre: nombreField, apellido_materno: apellido_materno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				/*****correo*****/
				//nombre, telefono, ap_materno vacío    ------ correo + AP_PATERNO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && apellido_paterno.length > 0 && apellido_materno.length <= 0){
					let busquedaParams = {correo: correoField, apellido_paterno: apellido_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//nombre, telefono, ap_paterno vacío    ------ correo + AP_MATERNO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && apellido_paterno.length <= 0 && apellido_materno.length > 0){
					let busquedaParams = {correo: correoField, apellido_materno: apellido_materno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				/******telefono**********/
				//correo, , nombre, , ap_materno vacío    ------ AP_PATERNO + TELEFONO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0  && apellido_paterno.length > 0 && apellido_materno.length <= 0){
					let busquedaParams = {apellido_paterno: apellido_paterno, telefono: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//correo, , nombre, , ap_paterno vacío    ------ AP_MATERNO + TELEFONO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0  && apellido_paterno.length <= 0 && apellido_materno.length > 0){
					let busquedaParams = {apellido_materno: apellido_materno, telefono: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				/*****************NOMBRE más 2**********************/
				//correo, telefono vacío    ------ NOMBRE + AP_PATERNO + AP_MATERNO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && apellido_paterno.length > 0 && apellido_materno.length > 0){
					let busquedaParams = {nombre: nombreField, apellido_paterno: apellido_paterno, apellido_materno:apellido_materno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//ap_materno, telefono vacío    ------ NOMBRE + AP_PATERNO + CORREO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && apellido_paterno.length > 0 && apellido_materno.length <= 0){ 26
					let busquedaParams = {nombre: nombreField, apellido_paterno: apellido_paterno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				//ap_materno, correo vacío    ------ NOMBRE + AP_PATERNO + TELEFONO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && apellido_paterno.length > 0 && apellido_materno.length <= 0){
					let busquedaParams = {nombre: nombreField, apellido_paterno: apellido_paterno, telefono:telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				/************NOMBRE más 3**************/
				// telefono vacío    ------ NOMBRE + AP_PATERNO + AP_MATERNO + CORREO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && apellido_paterno.length > 0 && apellido_materno.length > 0){
					let busquedaParams = {nombre: nombreField, apellido_paterno: apellido_paterno, apellido_materno:apellido_materno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// correo vacío    ------ NOMBRE + AP_PATERNO + AP_MATERNO + TELEFONO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && apellido_paterno.length > 0 && apellido_materno.length > 0){
					let busquedaParams = {nombre: nombreField, apellido_paterno: apellido_paterno, apellido_materno:apellido_materno, telefono:telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				/**acabe nuevos en nombre***/
				//nombre vacío    ------- CORREO + TELEFONO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && apellido_paterno.length <= 0 && apellido_materno.length <= 0){				
					let busquedaParams = {correo: correoField, telefono: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				/*******convinaciones ap_paterno*******/
				// nombre, correo, telefono vacío    ------ AP_PATERNO + AP_MATERNO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && 
				apellido_paterno.length > 0 && apellido_materno.length > 0){
					let busquedaParams = {apellido_paterno: apellido_paterno, apellido_materno:apellido_materno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// nombre, telefono vacío    ------ AP_PATERNO + AP_MATERNO + CORREO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && apellido_paterno.length > 0 && apellido_materno.length > 0){
					let busquedaParams = {apellido_paterno: apellido_paterno, apellido_materno:apellido_materno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// nombre, telefono vacío    ------ AP_PATERNO + AP_MATERNO + CORREO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && apellido_paterno.length > 0 && apellido_materno.length > 0){
					let busquedaParams = {apellido_paterno: apellido_paterno, apellido_materno:apellido_materno, telefono:telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// apellido_paterno, correo vacío    ------ NOMBRE + AP_MATERNO + TELEFONO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && apellido_paterno.length <= 0 && apellido_materno.length > 0){
					let busquedaParams = {nombre: nombreField, apellido_materno:apellido_materno, telefono:telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// apellido_paterno, telefono vacío    ------ NOMBRE + AP_MATERNO + CORREO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && apellido_paterno.length <= 0 && apellido_materno.length > 0){
					let busquedaParams = {nombre: nombreField, apellido_materno:apellido_materno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// apellido_paterno, apellido_materno vacío    ------ NOMBRE + TELEFONO + CORREO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && apellido_paterno.length <= 0 && apellido_materno.length <= 0){
					let busquedaParams = {nombre: nombreField, telefono:telefonoField, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// apellido_paterno vacío    ------ NOMBRE + TELEFONO + CORREO + AP_MATERNO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && apellido_paterno.length <= 0 && apellido_materno.length > 0){
					let busquedaParams = {nombre: nombreField, telefono:telefonoField, correo:correoField, apellido_materno:apellido_materno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// apellido_paterno vacío    ------ NOMBRE + TELEFONO + CORREO + AP_PATERNO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && apellido_paterno.length > 0 && apellido_materno.length <= 0){
					let busquedaParams = {nombre: nombreField, telefono:telefonoField, correo:correoField, apellido_paterno:apellido_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// nombre, apellido_materno vacío    ------  TELEFONO + CORREO + AP_PATERNO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && apellido_paterno.length > 0 && apellido_materno.length <= 0){
					let busquedaParams = {telefono:telefonoField, correo:correoField, apellido_paterno:apellido_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}
				// nombre, apellido_paterno vacío    ------  TELEFONO + CORREO + AP_MATERNO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && apellido_paterno.length <= 0 && apellido_materno.length > 0){
					let busquedaParams = {telefono:telefonoField, correo:correoField, apellido_materno:apellido_materno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}

				// nombre vacío    ------  TELEFONO + CORREO + AP_MATERNO + AP_PATERNO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && apellido_paterno.length > 0 && apellido_materno.length > 0){
					let busquedaParams = {telefono:telefonoField, correo:correoField, apellido_materno:apellido_materno, apellido_paterno:apellido_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}

				//all ingresados    ----- NOMBRE + CORREO + TELEFONO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && apellido_paterno.length > 0 && apellido_materno.length > 0){
					let busquedaParams = {nombre:nombreField, correo: correoField, telefono: telefonoField, apellido_paterno:apellido_paterno, apellido_materno:apellido_materno};
					var urlBusqueda = '<?=base_url()?>index.php/registroCliente/getResultsClientsSerch';
					updateTable(busquedaParams, urlBusqueda);
				}

				//all vacío
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <=0 && apellido_paterno.length <= 0 && apellido_materno.length <= 0){
					alerts.showNotification('top', 'right', 'Ups, asegurate de colocar al menos un criterío de búsqueda', 'warning');
					$('#nombre').focus();
				}
			});
		});

		let titulos = [];
		$('#tabla_clientes thead tr:eq(0) th').each( function (i) {
			if( i!=0 && i!=13){
				var title = $(this).text();
				titulos.push(title);
			}
		});

		function updateTable(busquedaParams, urlBusqueda){
			tabla_valores_cliente = $("#tabla_clientes").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					exportOptions: {
						columns: [1,2,3,4,5,6,9,10],
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
					"width": "5%",
					"data": function( d ){
						return '<p class="m-0">'+d.idLote+'</p>';
					}
				},
				{
					"width": "7%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombreResidencial+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombreCondominio+'</p>';
					}
				},
				{
					"width": "12%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombreLote+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.noRecibo+'</p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
						return '<p class="m-0">'+ myFunctions.validateEmptyField(d.tipo) +'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.fechaApartado+'</p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
						return '<p class="m-0">$ '+myFunctions.number_format(d.engancheCliente,2,'.',',')+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.fechaEnganche+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.asesor+'</p>';
					}
				},
				{
					"width": "8%",
					"data": function( d ){
						return '<button class="btn-data btn-gray to-comment cop" title= "Ventas compartidas" data-idcliente="'+d.id_cliente+'"><i class="fas fa-user-friends"></i></button>';

					}
				}],
				columnDefs: [{
					"searchable": false,
					"orderable": false,
					"targets": 0
				}],
				ajax: {
					"url": urlBusqueda,
					"method": 'POST',
					data:busquedaParams//parameter to search and the action to perform
				},
				order: [[ 1, 'asc' ]]
			});

			$('#tabla_clientes tbody').on('click', 'td.details-control', function () {
				var tr = $(this).closest('tr');
				var row = tabla_valores_cliente.row( tr );

				if ( row.child.isShown() ) {
					row.child.hide();
					tr.removeClass('shown');
					$(this).parent().find('.animacion').removeClass("fas fa-chevron-up").addClass("fas fa-chevron-down");
				}
				else {
					var informacion_adicional = '<div class="container subBoxDetail"><div class="row"><div class="col-12 col-sm-12 col-sm-12 col-lg-12" style="border-bottom: 2px solid #fff; color: #4b4b4b; margin-bottom: 7px"><label><b>'+row.data().nombre+' '+row.data().apellido_paterno+' '+row.data().apellido_materno+'</b></label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Correo: </b>'+myFunctions.validateEmptyField(row.data().correo)+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Teléfono: </b>'+myFunctions.validateEmptyField(row.data().telefono1)+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>RFC: </b>'+myFunctions.validateEmptyField(row.data().rfc)+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha +45: </b>'+myFunctions.validateEmptyField(row.data().fechaVecimiento)+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Fecha nacimiento: </b>'+myFunctions.validateEmptyField(row.data().fechaNacimiento)+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Domicilio particular: </b>'+myFunctions.validateEmptyField(row.data().domicilio_particular)+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Enterado: </b>'+myFunctions.validateEmptyField(row.data().enterado)+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Gerente titular: </b>'+myFunctions.validateEmptyField(row.data().gerente)+'</label></div><div class="col-12 col-sm-12 col-md-12 col-lg-12"><label><b>Asesor titular: </b>'+myFunctions.validateEmptyField(row.data().asesor)+'</label></div></div></div>';
					row.child( informacion_adicional ).show();
					tr.addClass('shown');
					$(this).parent().find('.animacion').removeClass("fas fa-chevron-down").addClass("fas fa-chevron-up");
				}
			});
		}

		var id_cliente_global = 0;
		$(document).on('click', '.cop', function(e) {
			e.preventDefault();
			var $itself = $(this);
			var id_cliente= $itself.attr('data-idcliente');

			id_cliente_global = id_cliente;
			loadDetalle(id_cliente)
			$('#verDetalles').modal('show');
		});

		function loadDetalle(id){
			var tableHistorial = $('#verDet').DataTable({
				dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				select: true,
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
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
					{ "data": "nombreGerente" },
					{ "data": "nombreCoordinador" },
					{ "data": "nombreAsesor" }
				],
				ajax: {
					"url": "<?=base_url()?>index.php/registroCliente/getcop/",
					"type": "POST",
					cache: false,
					"data": function( d ){
						d.id_cliente = id;
					}
				},
			});
		}
	</script>
</body>