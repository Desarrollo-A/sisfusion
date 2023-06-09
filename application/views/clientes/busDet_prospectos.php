<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-address-book fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="row">
									<h3 class="card-title center-align">Búsqueda detallada de prospectos</h3>
									<div class="toolbar">
										<div class="container-fluid">
											<div class="row">
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group label-floating is-empty">
														<label class="control-label label-gral">Nombre</label>
														<input type="text" class="form-control input-gral" name="nombre" id="nombre">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group label-floating is-empty">
														<label class="control-label label-gral">Apellido Paterno</label>
														<input type="text" class="form-control input-gral" name="ap_paterno" id="ap_paterno">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group label-floating is-empty">
														<label class="control-label label-gral">Apellido Materno</label>
														<input type="text" class="form-control input-gral" name="ap_materno" id="ap_materno">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group label-floating is-empty">
														<label class="control-label label-gral">Correo</label>
														<input type="email" class="form-control input-gral" name="correo" id="correo">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group label-floating is-empty">
														<label class="control-label label-gral">Teléfono</label>
														<input type="text" class="form-control input-gral" name="telefono" id="telefono">
													</div>
												</div>
												<div class="col-12 col-sm-12 col-md-6 col-lg-6">
													<div class="form-group">
														<div class="row">
															<div class="col-12 col-sm-12 col-md-6 col-lg-6">
																<button class="btn-data-gral btn-s-blue" id="buscarBtn">
																<i class="fas fa-search"></i> Buscar
																</button>
															</div>
															<div class="col-12 col-sm-12 col-md-6 col-lg-6">
																<button class="btn-data-gral btn-s-deepGray"id="ResetForm" type="reset">
																<i class="fas fa-eraser"></i> Limpiar campos
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>									
								</div>
								<div class="material-datatables">
									<div class="form-group">
										<div class="table-responsive">
											<table id="prospects-datatable_dir" class="table-striped table-hover">
												<thead>
													<tr>
														<th>ID PROSPECTO</th>
														<th>ESTADO</th>
														<th>MEDIO</th>
														<th>NOMBRE</th>
														<th>APELLIDO PATERNO</th>
														<th>APELLIDO MATERNO</th>
														<th>ASESOR</th>
														<th>COORDINADOR</th>
														<th>GERENTE</th>
														<th>CREACIÓN</th>
														<th>VENCIMIENTO</th>
														<th>ACCIONES</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
											<?php include 'common_modals.php' ?>
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
		userType = <?= $this->session->userdata('id_rol') ?> ;
		typeTransaction = 1;
	</script>
	<!-- MODAL WIZARD -->
	<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
	<?php
	if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5 || $this->session->userdata('id_usuario') == 826 || $this->session->userdata('id_usuario') == 1297)
	{
	?>
		<script src="<?=base_url()?>dist/js/controllers/general-1.1.0.js"></script>
	<?php
	} 
	?>

	<script>
		$('#prospects-datatable_dir thead tr:eq(0) th').each( function (i) {
			var title = $(this).text();
			if(i != 11 ){
				$(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
				$( 'input', this ).on('keyup change', function () {
					if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value ) {
						$('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
					}
				});
			}
		});

		$(document).ready(function () {
			var url='';
			$(document).on('click', '#buscarBtn', function () {
				var nombreField = $('#nombre').val();
				var correoField = $('#correo').val();
				var telefonoField = $('#telefono').val();
				var ap_paterno = $('#ap_paterno').val();
				var ap_materno = $('#ap_materno').val();

				//correo y telefono vacío    ---- NOMBRE
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length<=0 && ap_materno.length<=0){
					let busquedaParams = {nombre: nombreField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//nombre y telefono vacio  --- CORREO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length<=0 && ap_materno.length<=0){
					let busquedaParams = {correo: correoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//nombre y correo vacio  ---- TELEFONO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length<=0 && ap_materno.length<=0){
					let busquedaParams = {telefono: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//nombre, ap_materno, telefono y correo vacio  ---- AP PATERNO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length>0 && ap_materno.length<=0){
					let busquedaParams = {ap_paterno: ap_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//nombre, ap_paterno, telefono y correo vacio  ---- AP MATERNO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length<=0 && ap_materno.length > 0){
					let busquedaParams = {ap_materno: ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}

				/****/
				//telefono, ap_paterno, ap_materno vacío   ----- NOMBRE + CORREO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length<=0 && ap_materno.length<=0){
					let busquedaParams = {nombre: nombreField, correo: correoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//correo, ap_paterno, ap_materno vacío     ------ NOMBRE + TELEFONO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length<=0 && ap_materno.length<=0){
					let busquedaParams = {nombre: nombreField, telefono: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//correo, telefono, ap_materno vacío     ------ NOMBRE + AP_PATERNO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length<=0){
					let busquedaParams = {nombre: nombreField, ap_paterno: ap_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//correo, telefono, ap_paterno vacío     ------ NOMBRE + AP_MATERNO
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
					let busquedaParams = {nombre: nombreField, ap_materno: ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//correo, telefono, nombre vacío     ------ AP_PATERNO + AP_MATERNO
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length > 0){
					let busquedaParams = {ap_paterno: ap_paterno, ap_materno: ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//AP_MATERNO, telefono, nombre vacío     ------ AP_PATERNO + correo
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
					let busquedaParams = {ap_paterno: ap_paterno, ap_materno: ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//AP_MATERNO, correo, nombre vacío     ------ AP_PATERNO +  telefono
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
					let busquedaParams = {ap_paterno: ap_paterno, telefonoField: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//AP_PATERNO, telefono, nombre vacío     ------  AP_MATERNO +  correo
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
					let busquedaParams = {correo: correoField, ap_materno: ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//AP_PATERNO, correo, nombre vacío     ------  AP_MATERNO + telefono
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
					let busquedaParams = {telefono: telefonoField, ap_materno: ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				/*************************/
				//nombre, ap_paterno, ap_materno vacío     ------- CORREO + TELEFONO
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length<=0 && ap_materno.length<=0){
					let busquedaParams = {correo: correoField, telefono: telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//all ingresados    ----- NOMBRE + CORREO + TELEFONO + AP_PATERNO + AP_MATERNO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length > 0){
					let busquedaParams = {nombre:nombreField, correo: correoField, telefono: telefonoField, ap_paterno:ap_paterno, ap_materno:ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}

				/**********************************************************/

				// CORREO + TELEFONO vacío     -------  nombre, ap_paterno, ap_maternov
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length>0 && ap_materno.length>0){
					let busquedaParams = {nombre: nombreField, ap_paterno: ap_paterno, ap_materno:ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}

				// CORREO + TELEFONO vacío     -------  nombre, ap_paterno, ap_maternov
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length <= 0 && ap_paterno.length>0 && ap_materno.length>0){
					let busquedaParams = {nombre: nombreField, ap_paterno: ap_paterno, ap_materno:ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				// TELEFONO vacío     -------  nombre, ap_paterno, ap_materno, CORREO
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length>0 && ap_materno.length>0){
					let busquedaParams = {nombre: nombreField, ap_paterno: ap_paterno, ap_materno:ap_materno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}

				/**combs de telefono**/
				//nombre, ap_paterno vacío     ------- TELEFONO + CORREO  + ap_materno
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length<=0 && ap_materno.length > 0){
					let busquedaParams = {correo: correoField, telefono: telefonoField, ap_materno:ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//nombre, ap_materno  vacío     ------- TELEFONO + CORREO  +  ap_paterno
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
					let busquedaParams = {correo: correoField, telefono: telefonoField, ap_paterno:ap_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//ap_paterno, ap_materno  vacío     ------- TELEFONO + CORREO  +   nombre
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length <= 0 && ap_materno.length <= 0){
					let busquedaParams = {correo: correoField, telefono: telefonoField, nombre:nombreField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//nombre vacío     ------- TELEFONO + CORREO  + ap_materno + ap_paterno
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length > 0){
					let busquedaParams = {correo: correoField, telefono: telefonoField, ap_materno:ap_materno, ap_paterno:ap_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				// CORREO vacío     ------- TELEFONO +  nombre + ap_materno + ap_paterno
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length > 0){
					let busquedaParams = {correo: correoField, nombre: nombreField, ap_materno:ap_materno, ap_paterno:ap_paterno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}

				//ap_paterno, telefono  vacío     ------- nombre + ap_materno + correo
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
					let busquedaParams = {correo: correoField, nombre: nombreField, ap_materno:ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//ap_paterno,  correo vacío     ------- nombre + ap_materno + telefono
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
					let busquedaParams = {telefono: telefonoField, nombre: nombreField, ap_materno:ap_materno};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//ap_paterno, vacío     ------- nombre + ap_materno + telefono + correo
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length <= 0 && ap_materno.length > 0){
					let busquedaParams = {telefono: telefonoField, nombre: nombreField, ap_materno:ap_materno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}

				//ap_materno, vacío     ------- nombre +  ap_paterno + telefono + correo
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
					let busquedaParams = {telefono: telefonoField, nombre: nombreField, ap_paterno:ap_paterno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//ap_materno, telefono vacío     ------- nombre +  ap_paterno  + correo
				if(nombreField.length > 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
					let busquedaParams = {nombre: nombreField, ap_paterno:ap_paterno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//ap_materno, correo vacío     ------- nombre +  ap_paterno  +  telefono
				if(nombreField.length > 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length <= 0){
					let busquedaParams = {nombre: nombreField, ap_paterno:ap_paterno, telefono:telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}
				//nombre, telefono  vacío     -------  ap_materno +  ap_paterno  +   correo
				if(nombreField.length <= 0 && correoField.length > 0 && telefonoField.length <= 0 && ap_paterno.length > 0 && ap_materno.length > 0){
					let busquedaParams = {ap_materno: ap_materno, ap_paterno:ap_paterno, correo:correoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}

				//nombre, correo   vacío     -------  ap_materno +  ap_paterno  +   telefono
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length > 0 && ap_paterno.length > 0 && ap_materno.length > 0){
					let busquedaParams = {ap_materno: ap_materno, ap_paterno:ap_paterno, telefono:telefonoField};
					var urlBusqueda = '<?=base_url()?>index.php/clientes/getResultsProspectsSerch';
					updateTable(typeTransaction, busquedaParams, urlBusqueda);
				}

				//all vacío
				if(nombreField.length <= 0 && correoField.length <= 0 && telefonoField.length <=0 && ap_paterno.length<=0 && ap_materno.length<=0){
					alerts.showNotification('top', 'right', 'Ups, asegurate de colocar al menos un criterío de búsqueda', 'warning');
					$('#nombre').focus();
				}
			});
		});

		function updateTable(typeTransaction, busquedaParams, urlBusqueda){
			var prospectsTable_dir = $('#prospects-datatable_dir').dataTable({
				dom: 'rt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
				columns: [{ 
					data: function (d) {
						return d.id_prospecto;
					}
				},
				{ 
					data: function (d) {
						if (d.estatus == 1) {
							return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
						} else {
							return '<center><span class="label label-danger" style="background:#E74C3C">No vigente</span><center>';
						}
					}
				},
				{ 
					data: function (d) {
						if( d.lugar_prospeccion == 'MKT digital (especificar)'){
							if(d.otro_lugar != '0'){
								return '<center><span class="label label-danger" style="background:#2081a7">'+d.lugar_prospeccion+'</span><br><br><span class="label label-danger" style="background:#494e54">'+d.otro_lugar+'</span><center>';
							}
							else{
								return '<center><span class="label label-danger" style="background:#2081a7">'+d.lugar_prospeccion+'</span><center>';
							}
						}
						else{
							return '<center><span class="label label-danger" style="background:#2081a7">'+d.lugar_prospeccion+'</span><center>';
						}
					}
				},
				{ 
					data: function (d) {
						return d.nombre;
					}
				},
				{ 
					data: function (d) {
						return d.apellido_paterno;
					}
				},
				{ 
					data: function (d) {
						return d.apellido_materno;
					}
				},
				{ 
					data: function (d) {
						return d.asesor;
					}
				},
				{ 
					data: function (d) {
						return d.coordinador;
					}
				},
				{ 
					data: function (d) {
						return d.gerente;
					}
				},
				{ 
					data: function (d) {
						return d.fecha_creacion;
					}
				},
				{ 
					data: function (d) {
						return d.fecha_vencimiento;
					}
				}
				,
				{ 
					data: function (d) {
						return '<button class="btn-data btn-sky see-information" data-id-prospecto="' + d.id_prospecto + '"><i class="material-icons">remove_red_eye</i></button>';
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
				ajax: {
					"url": urlBusqueda,
					"method": 'POST',
					data:busquedaParams//parameter to search and the action to perform
				}	
			})
		}

		$(document).on('click', '.see-information', function(e) {
			id_prospecto = $(this).attr("data-id-prospecto");
			$("#seeInformationModal").modal();
			$("#prospecto_lbl").val(id_prospecto);

			$.getJSON("getInformationToPrint/" + id_prospecto).done(function(data) {
				$.each(data, function(i, v) {
					fillFields(v, 1);
				});
			});

			$.getJSON("getComments/" + id_prospecto).done(function(data) {
				counter = 0;
				$.each(data, function(i, v) {
					counter++;
					fillTimeline(v, counter);
				});
			});

			$.getJSON("getChangelog/" + id_prospecto).done(function(data) {
				$.each(data, function(i, v) {
					fillChangelog(v);
				});
			});

		});


		$(document).on('click', "#ResetForm", function() {
			// Reset the form
			$('#nombre').val('');
			$('#correo').val('');
			$('#telefono').val('');
			$('#ap_paterno').val('');
			$('#ap_materno').val('');
		});

		function fillFields(v, type) {
		/*
		* 0 update prospect
		* 1 see information modal
		* 2 update reference
		*/
			if (type == 0) {
				$("#nationality").val(v.nacionalidad);
				$("#legal_personality").val(v.personalidad_juridica);
				$("#curp").val(v.curp);
				$("#rfc").val(v.rfc);
				$("#name").val(v.nombre);
				$("#last_name").val(v.apellido_paterno);
				$("#mothers_last_name").val(v.apellido_materno);
				$("#date_birth").val(v.fecha_nacimiento);
				$("#email").val(v.correo);
				$("#phone_number").val(v.telefono);
				$("#phone_number2").val(v.telefono_2);
				$("#civil_status").val(v.estado_civil);
				$("#matrimonial_regime").val(v.regimen_matrimonial);
				$("#spouce").val(v.conyuge);
				$("#from").val(v.originario_de);
				$("#home_address").val(v.domicilio_particular);
				$("#occupation").val(v.ocupacion);
				$("#company").val(v.empresa);
				$("#position").val(v.posicion);
				$("#antiquity").val(v.antiguedad);
				$("#company_antiquity").val(v.edadFirma);
				$("#company_residence").val(v.direccion);
				$("#prospecting_place").val(v.lugar_prospeccion);
				$("#advertising").val(v.medio_publicitario);
				$("#sales_plaza").val(v.plaza_venta);
				//document.getElementById("observations").innerHTML = v.observaciones;
				$("#observation").val(v.observaciones);
				if (v.tipo_vivienda == 1) {
					document.getElementById('own').setAttribute("checked", "true");
				} else if (v.tipo_vivienda == 2) {
					document.getElementById('rented').setAttribute("checked", "true");
				} else if (v.tipo_vivienda == 3) {
					document.getElementById('paying').setAttribute("checked", "true");
				} else if (v.tipo_vivienda == 4) {
					document.getElementById('family').setAttribute("checked", "true");
				} else {
					document.getElementById('other').setAttribute("checked", "true");
				}

				pp = v.lugar_prospeccion;
				console.log(pp);
				if (pp == 3 || pp == 7 || pp == 9 || pp == 10) { // SPECIFY OPTION
					$("#specify").val(v.otro_lugar);
				} else if (pp == 6) { // SPECIFY MKTD OPTION
					document.getElementById('specify_mkt').value = v.otro_lugar;
				} else if (pp == 21) { // RECOMMENDED SPECIFICATION
					document.getElementById('specify_recommends').value = v.otro_lugar;
				} else { // WITHOUT SPECIFICATION
					$("#specify").val("");
				}

			} 
			else if (type == 1) {
				$("#nationality-lbl").val(v.nacionalidad);
				$("#legal-personality-lbl").val(v.personalidad_juridica);
				$("#curp-lbl").val(v.curp);
				$("#rfc-lbl").val(v.rfc);
				$("#name-lbl").val(v.nombre);
				$("#last-name-lbl").val(v.apellido_paterno);
				$("#mothers-last-name-lbl").val(v.apellido_materno);
				$("#email-lbl").val(v.correo);
				$("#phone-number-lbl").val(v.telefono);
				$("#phone-number2-lbl").val(v.telefono_2);
				$("#prospecting-place-lbl").val(v.lugar_prospeccion);
				$("#specify-lbl").html(v.otro_lugar);
				//$("#advertising-lbl").val(v.medio_publicitario);
				$("#sales-plaza-lbl").val(v.plaza_venta);
				$("#comments-lbl").val(v.observaciones);
				$("#asesor-lbl").val(v.asesor);
				$("#coordinador-lbl").val(v.coordinador);
				$("#gerente-lbl").val(v.gerente);
				$("#phone-asesor-lbl").val(v.tel_asesor);
				$("#phone-coordinador-lbl").val(v.tel_coordinador);
				$("#phone-gerente-lbl").val(v.tel_gerente);

			} 
			else if (type == 2) {
				$("#prospecto_ed").val(v.id_prospecto).trigger('change');
				$("#prospecto_ed").selectpicker('refresh');
				$("#kinship_ed").val(v.parentesco).trigger('change');
				$("#kinship_ed").selectpicker('refresh');
				$("#name_ed").val(v.nombre);
				$("#phone_number_ed").val(v.telefono);
			}
		}

		function fillTimeline(v) {
			$("#comments-list").append('<li class="timeline-inverted">\n' +
				'    <div class="timeline-badge info"></div>\n' +
				'    <div class="timeline-panel">\n' +
				'            <label><h6>' + v.creador + '</h6></label>\n' +
				'            <br>' + v.observacion + '\n' +
				'        <h6>\n' +
				'            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + '</span>\n' +
				'        </h6>\n' +
				'    </div>\n' +
				'</li>');
		}

		function fillChangelog(v) {
			$("#changelog").append('<li class="timeline-inverted">\n' +
				'    <div class="timeline-badge success"></div>\n' +
				'    <div class="timeline-panel">\n' +
				'            <label><h6>' + v.parametro_modificado + '</h6></label><br>\n' +
				'            <b>Valor anterior:</b> ' + v.anterior + '\n' +
				'            <br>\n' +
				'            <b>Valor nuevo:</b> ' + v.nuevo + '\n' +
				'        <h6>\n' +
				'            <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> ' + v.fecha_creacion + ' - ' + v.creador + '</span>\n' +
				'        </h6>\n' +
				'    </div>\n' +
				'</li>');
		}

		function cleanComments() {
			var myCommentsList = document.getElementById('comments-list');
			myCommentsList.innerHTML = '';

			var myChangelog = document.getElementById('changelog');
			myChangelog.innerHTML = '';
		}

		function printProspectInfo() {
			id_prospecto = $("#prospecto_lbl").val();
			window.open("printProspectInfo/" + id_prospecto, "_blank")
		}

		function printProspectInfoMktd() {
			id_prospecto = $("#prospecto_lbl").val();
			window.open("printProspectInfoMktd/" + id_prospecto, "_blank")
		}
	</script>
</body>