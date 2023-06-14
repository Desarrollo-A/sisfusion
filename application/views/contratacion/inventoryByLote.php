<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
	<div class="wrapper">
		<?php
		if (in_array($this->session->userdata('id_rol'), array(19,20,28,50,58,18))){
			$this->load->view('template/sidebar');
		}
		else{
			echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
		}
		?>

		<!-- Modals -->
		<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Consulta de historial <b id="nomLoteHistorial"></b></h4>
					</div>
					<div class="modal-body">
						<div role="tabpanel">
							<ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
								<li role="presentation" class="active"><a href="#changeprocesTab" aria-controls="changeprocesTab" role="tab"
									onclick="javascript:$('#verDet').DataTable().ajax.reload();"	data-toggle="tab">Proceso de contratación</a>
								</li>
								<li role="presentation"><a href="#changelogTab" aria-controls="changelogTab" role="tab" data-toggle="tab"
								onclick="javascript:$('#verDetBloqueo').DataTable().ajax.reload();">Liberación</a>
								</li>
								<li role="presentation"><a href="#coSellingAdvisers" aria-controls="coSellingAdvisers" role="tab" data-toggle="tab"
									onclick="javascript:$('#seeCoSellingAdvisers').DataTable().ajax.reload();">Asesores venta compartida</a>
								</li>
								<?php 
								$id_rol = $this->session->userdata('id_rol');
								if($id_rol == 11){
								echo '<li role="presentation"><a href="#tab_asignacion" aria-controls="tab_asignacion" role="tab" data-toggle="tab"
									onclick="fill_data_asignacion();">Asignación</a>
								</li>';
								}
								?>
								<li role="presentation" class="hide" id="li_individual_sales"><a href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab" data-toggle="tab">Clausulas</a></li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="changeprocesTab">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<div class="table-responsive">
														<table id="verDet" class="table-striped table-hover">
															<thead>
																<tr>
																	<th>LOTE</th>
																	<th>STATUS</th>
																	<th>DETALLES</th>
																	<th>COMENTARIO</th>
																	<th>FECHA</th>
																	<th>USUARIO</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
															<tfoot>
																<tr>
																	<th>LOTE</th>
																	<th>STATUS</th>
																	<th>DETALLES</th>
																	<th>COMENTARIO</th>
																	<th>FECHA</th>
																	<th>USUARIO</th>
																</tr>
															</tfoot>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div role="tabpanel" class="tab-pane" id="changelogTab">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<div class="table-responsive">
														<table id="verDetBloqueo" class="table-striped table-hover" width="100%">
															<thead>
																<tr>
																	<th>LOTE</th>
																	<th>PRECIO</th>
																	<th>FECHA LIBERACIÓN</th>
																	<th>COMENTARIO LIBERACIÓN</th>
																	<th>USUARIO</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
															<tfoot>
																<tr>
																	<th>LOTE</th>
																	<th>PRECIO</th>
																	<th>FECHA LIBERACIÓN</th>
																	<th>COMENTARIO LIBERACIÓN</th>
																	<th>USUARIO</th>
																</tr>
															</tfoot>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="coSellingAdvisers">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<div class="table-responsive">
														<table id="seeCoSellingAdvisers" class="table-striped table-hover" width="100%">
															<thead>
																<tr>
																	<th>ASESOR</th>
																	<th>COORDINADOR</th>
																	<th>GERENTE</th>
																	<th>FECHA ALTA</th>
																	<th>USUARIO</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
															<tfoot>
																<tr>
																	<th>ASESOR</th>
																	<th>COORDINADOR</th>
																	<th>GERENTE</th>
																	<th>FECHA ALTA</th>
																	<th>USUARIO</th>
																</tr>
															</tfoot>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="tab_asignacion">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<div class="form-group">
														<label for="des">Desarrollo</label>
														<select name="sel_desarrollo" id="sel_desarrollo" class="selectpicker" 
														data-style="btn btn-second" data-show-subtext="true" 
														data-live-search="true"  title="" data-size="7" required>
														<option disabled selected>Selecciona un desarrollo</option></select>
													</div>
													<div class="form-group"></div>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="check_edo">
														<label class="form-check-label" for="check_edo">Intercambio</label>
													</div>
													<div class="form-group text-right">
														<button type="button" id="save_asignacion" class="btn btn-primary">ENVIAR</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="salesOfIndividuals">
									<div class="row">
										<div class="col-md-12">
											<div class="card card-plain">
												<div class="card-content">
													<h4 id="clauses_content"></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="prospecto_lbl" id="prospecto_lbl">
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
							<div class="card-header card-header-icon fa-2x" data-background-color="goldMaderas">
								<i class="fas fa-box"></i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align">Inventario de lotes</h3>
								<div class="toolbar">
									<div class="row">
										<div class="col-6 col-sm-6 col-md-4 col-lg-4">
											<div class="form-group label-floating">
												<label class="control-label label-gral">Lote</label>
												<input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
											</div>
										</div>
										<div class="col-6 col-sm-6 col-md-4 col-lg-4">
											<div class="form-group">
												<button type="button" class="btn-gral-data find_doc"> Buscar </button>
											</div>
										</div>
									</div>				
								</div>
								<div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
											<table class="table-striped table-hover" id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>ID LOTE</th>
														<th>SUP.</th>
														<th>TOTAL</th>
														<th>TOTAL DESCUENTO</th>
														<th>M2</th>
														<th>REFERENCIA</th>
														<th>MSI</th>
														<th>GERENTE</th>
														<th>COORDINADOR</th>
														<th>ASESOR</th>
														<th>ESTATUS</th>
														<th>APARTADO</th>
														<th>COMENTARIO</th>
														<th>LUGAR PROS.</th>
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
		var url2 = "<?=base_url()?>/index.php/";
		var urlimg = "<?=base_url()?>/img/";
		var idLote = 0;
		let titulos = [];

		$(".find_doc").click( function() {
			var idLote = $('#inp_lote').val();
			tabla_inventario = $("#tabla_inventario_contraloria").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				ajax:
				{
					"url": '<?=base_url()?>index.php/Contratacion/getInventoryByLote/'+idLote,
					"dataSrc": ""
				},
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					title: 'MADERAS_CRM_INVENTARIO',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
						format: {
							header: function (d, columnIdx) {
								switch (columnIdx) {
									case 0:
										return 'PROYECTO';
										break;
									case 1:
										return 'CONDOMINIO';
										break;
									case 2:
										return 'LOTE';
										break;
									case 3:
										return 'ID LOTE';
										break;
									case 4:
										return 'SUPERFICIE';
										break;
									case 5:
										return 'TOTAL';
										break;
									case 6:
										return 'TOTAL DESCUENTO';
										break;
									case 7:
										return 'M2';
										break;
									case 8:
										return 'REFERENCIA';
										break;
									case 9:
										return 'MSI';
										break;
									case 10:
										return 'GERENTE';
										break;
									case 11:
										return 'COORDINADOR';
										break;
									case 12:
										return 'ASESOR';
										break;
									case 13:
										return 'ESTATUS';
										break;
									case 14:
										return 'APARTADO';
										break;
									case 15:
										return 'COMENTARIO';
										break;
									case 16:
										return 'LUGAR PROSPECCIÓN';
										break;
									
								}
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
					"width": "10%",
					data: 'nombreResidencial'
				},
				{
					"width": "10%",
					"data": function(d){
						return '<p>'+(d.nombreCondominio).toUpperCase()+'</p>';
					}
				},
				{
					"width": "14%",
					"data": function(d){
						return '<p>'+(d.nombreLote).toUpperCase()+'</p>';
					}
				},
				{
					"width": "14%",
					"data": function(d){
						return '<p>'+ d.idLote +'</p>';
					}
				},
				{
					"width": "10%",
					"data": function(d){
						return '<p>'+d.superficie+'<b> m<sup>2</sup></b></p>';
					}
				},
				{
					"width": "10%",
					"data": function(d){
						var preciot;
						if(d.nombreResidencial == 'CCMP'){
							if(d.idStatusLote != 3){
								var stella;
								var aura;
								var terreno;

								if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
								d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
								d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
								d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
								d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
								
								d.nombreLote == 'CCMP-LIRIO-010' ||
								d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
								d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
								d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100'){
										stella = ( parseInt(d.total) + parseInt(2029185) );
										aura = ( parseInt(d.total) + parseInt(1037340) );
										terreno = parseInt(d.total);
										preciot = '<p>S: $ '+formatMoney(stella)+'</p>' +
												'<p>A: $ '+formatMoney(aura)+'</p>' +
												'<p>T: $ '+formatMoney(terreno)+'</p>';
								}
								else {
									stella = ( parseInt(d.total) + parseInt(2104340) );
									aura = ( parseInt(d.total) + parseInt(1075760) );
									terreno = parseInt(d.total);
									preciot = '<p>S: $ '+formatMoney(stella)+'</p>' +
											'<p>A: $ '+formatMoney(aura)+'</p>' +
											'<p>T: $ '+formatMoney(terreno)+'</p>';
								}
							} 
							else if(d.idStatusLote == 3 || d.idStatusLote == 2){
								preciot = '<p>$ '+formatMoney(d.total)+'</p>';
							}
						} 
						else {
							preciot = '<p>$ '+formatMoney(d.total)+'</p>';
						}
						return preciot;
					}
				},
				{
					"width": "10%",
					"data": function(d){
						return '<p class="m-0">$'+formatMoney(d.totalNeto2)+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function(d){
						var preciom2;					
						if(d.nombreResidencial == 'CCMP'){
							if(d.idStatusLote != 3){
								var stella;
								var aura;
								var terreno;
						
								if (d.nombreLote == 'CCMP-LAMAY-011' || d.nombreLote == 'CCMP-LAMAY-021' || d.nombreLote == 'CCMP-LAMAY-030' ||
								d.nombreLote == 'CCMP-LAMAY-031' || d.nombreLote == 'CCMP-LAMAY-032' || d.nombreLote == 'CCMP-LAMAY-045' ||
								d.nombreLote == 'CCMP-LAMAY-046' || d.nombreLote == 'CCMP-LAMAY-047' || d.nombreLote == 'CCMP-LAMAY-054' || 
								d.nombreLote == 'CCMP-LAMAY-064' || d.nombreLote == 'CCMP-LAMAY-079' || d.nombreLote == 'CCMP-LAMAY-080' ||
								d.nombreLote == 'CCMP-LAMAY-090' || d.nombreLote == 'CCMP-LIRIO-010' ||
								
								d.nombreLote == 'CCMP-LIRIO-010' ||
								d.nombreLote == 'CCMP-LIRIO-033' || d.nombreLote == 'CCMP-LIRIO-048' || d.nombreLote == 'CCMP-LIRIO-049' ||
								d.nombreLote == 'CCMP-LIRIO-067' || d.nombreLote == 'CCMP-LIRIO-089' || d.nombreLote == 'CCMP-LIRIO-091' ||
								d.nombreLote == 'CCMP-LIRIO-098' || d.nombreLote == 'CCMP-LIRIO-100') {
									stella = ( (parseInt(d.total) + parseInt(2029185)) / d.superficie);
									aura = ( (parseInt(d.total) + parseInt(1037340)) / d.superficie );
									terreno = (parseInt(d.total) / d.superficie);

									preciom2 = '<p>S: $ '+formatMoney(stella)+'</p>' +
											'<p>A: $ '+formatMoney(aura)+'</p>' +
											'<p>T: $ '+formatMoney(terreno)+'</p>';
								}
								else {
									
										stella = ( (parseInt(d.total) + parseInt(2104340)) / d.superficie );
										aura = ( (parseInt(d.total) + parseInt(1075760)) / d.superficie );
										terreno = (parseInt(d.total) / d.superficie);

										preciom2 = '<p>S: $ '+formatMoney(stella)+'</p>' +
												'<p>A: $ '+formatMoney(aura)+'</p>' +
												'<p>T: $ '+formatMoney(terreno)+'</p>';

								}
							} 
							else if(d.idStatusLote == 3 || d.idStatusLote == 2) {
								preciom2 = '<p>$ '+formatMoney(d.precio)+'</p>';
							}
						} 
						else {
							preciom2 = '<p>$ '+formatMoney(d.precio)+'</p>';
						}
						return preciom2;
					}
				},
				{
					"width": "10%",
					data: 'referencia'
				},
				{
					"width": "5%",
					data: 'msni'
				},
				{
					"data": function(d){
						var gerente;
						if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
						{
							if(d.id_rol == 9){
								gerente = myFunctions.validateEmptyField(d.coordinador2);
							} else {
								gerente = myFunctions.validateEmptyField(d.gerente2);
							}
						}
						else
						{
							gerente = myFunctions.validateEmptyField(d.gerente);
						}
						return gerente;
					}
				},
				{
					"data": function(d){
						var coordinador;
						if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
						{
							if(d.id_rol == 9){
								coordinador = myFunctions.validateEmptyField(d.asesor2);
							} else {
								coordinador = myFunctions.validateEmptyField(d.coordinador2);
							}
						}
						else
						{
							coordinador = myFunctions.validateEmptyField(d.coordinador);
						}

						coordinador = coordinador = '' ? 'Sin registro' : coordinador;
						return coordinador;
					}
				},
				{
					"data": function(d){
						var asesor;
						if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10)
						{
							asesor = myFunctions.validateEmptyField(d.asesor2);
						}
						else
						{
							asesor = myFunctions.validateEmptyField(d.asesor);
						}
						return asesor;
					}
				},
				{
					"width": "12%",
					"data": function(d){
						valTV = (d.tipo_venta == null) ? '<center><span class="label label-danger" style="background:#'+d.color+';">'+d.descripcion_estatus+'</span> <center>' :
						'<center><span class="label label-danger" style="background:#'+d.color+';">'+d.descripcion_estatus+'</span> <p><p> <span class="label label-warning";">'+d.tipo_venta+'</span> <center>';

						return valTV;
					}
				},
				{
					"width": "10%",
					"data": function(d){
						
						if(d.idStatusLote == 8 || d.idStatusLote == 9 || d.idStatusLote == 10){
							if(d.fecha_modst == null || d.fecha_modst == 'null') {
								return 'Sin registro';
							} else {
								return '<p>'+d.fecha_modst+'</p>';
							}
						} else {
							if(d.fechaApartado == null || d.fechaApartado == 'null') {
								return 'Sin registro';
							} else {
								return '<p>'+d.fechaApartado+'</p>';
							}
						}
					}
				},
				{
					"width": "16%",
					"data": function(d){
						if(d.comentario=='NULL'||d.comentario=='null'||d.comentario==null){
							return ' - ';
						}
						else
						{
							return '<p>'+d.comentario+'</p>';
						}
					}
				},
				{
					"width": "10%",
					data: 'lugar_prospeccion'
				},
				{
					"width": "8%",
					"data": function( d ){
						return '<button class="btn-data btn-sky ver_historial" value="' + d.idLote +'" data-nomLote="'+d.nombreLote+'" data-tipo-venta="'+d.tipo_venta+'"><i class="fas fa-history"></i></button>';
					}
				}]
			});
			$(window).resize(function(){
				tabla_inventario.columns.adjust();
			});
		});

		$(document).on("click", ".ver_historial", function(){
			var tr = $(this).closest('tr');
			var row = tabla_inventario.row( tr );
			idLote = $(this).val();
			var $itself = $(this);
			var element = document.getElementById("li_individual_sales");

			if ($itself.attr('data-tipo-venta') == 'Venta de particulares') {
				$.getJSON(url+"Contratacion/getClauses/"+idLote).done( function( data ){
					$('#clauses_content').html(data[0]['nombre']);
				});
				element.classList.remove("hide");
			} 
			else {
				element.classList.add("hide");
				$('#clauses_content').html('');
			}

			$("#seeInformationModal").on("hidden.bs.modal", function(){
				$("#changeproces").html("");
				$("#changelog").html("");
				$('#nomLoteHistorial').html("");
			});
			$("#seeInformationModal").modal();
			var urlTableFred = '';
			$.getJSON(url+"Contratacion/obtener_liberacion/"+idLote).done( function( data ){
				urlTableFred = url+"Contratacion/obtener_liberacion/"+idLote;
				fillFreedom(urlTableFred);
			});

			var urlTableHist = '';
			$.getJSON(url+"Contratacion/historialProcesoLoteOp/"+idLote).done( function( data ){
				$('#nomLoteHistorial').html($itself.attr('data-nomLote'));
					urlTableHist = url+"Contratacion/historialProcesoLoteOp/"+idLote;
					fillHistory(urlTableHist);
			});
			
			var urlTableCSA = '';
			$.getJSON(url+"Contratacion/getCoSallingAdvisers/"+idLote).done( function( data ){
				urlTableCSA = url+"Contratacion/getCoSallingAdvisers/"+idLote;
				fillCoSellingAdvisers(urlTableCSA);
			});	

			fill_data_asignacion();
		});

		function fillLiberacion (v) {
			$("#changelog").append('<li class="timeline-inverted">\n' +
				'<div class="timeline-badge success"></div>\n' +
				'<div class="timeline-panel">\n' +
				'<label><h5><b>LIBERACIÓN - </b>'+v.nombreLote+'</h5></label><br>\n' +
				'<b>ID:</b> '+v.idLiberacion+'\n' +
				'<br>\n' +
				'<b>Estatus:</b> '+v.estatus_actual+'\n' +
				'<br>\n' +
				'<b>Comentario:</b> '+v.observacionLiberacion+'\n' +
				'<br>\n' +
				'<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.nombre+' '+v.apellido_paterno+' '+v.apellido_materno+' - '+v.modificado+'</span>\n' +
				'</h6>\n' +
				'</div>\n' +
				'</li>');
		}

		function fillProceso (i, v) {
			$("#changeproces").append('<li class="timeline-inverted">\n' +
				'<div class="timeline-badge info">'+(i+1)+'</div>\n' +
				'<div class="timeline-panel">\n' +
				'<b>'+v.nombreStatus+'</b><br><br>\n' +
				'<b>Comentario:</b> \n<p><i>'+v.comentario+'</i></p>\n' +
				'<br>\n' +
				'<b>Detalle:</b> '+v.descripcion+'\n' +
				'<br>\n' +
				'<b>Perfil:</b> '+v.perfil+'\n' +
				'<br>\n' +
				'<b>Usuario:</b> '+v.usuario+'\n' +
				'<br>\n' +
				'<span class="small text-gray"><i class="fa fa-clock-o mr-1"></i> '+v.modificado+'</span>\n' +
				'</h6>\n' +
				'</div>\n' +
				'</li>');
		}


		function formatMoney( n ) {
			var c = isNaN(c = Math.abs(c)) ? 2 : c,
				d = d == undefined ? "." : d,
				t = t == undefined ? "," : t,
				s = n < 0 ? "-" : "",
				i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
				j = (j = i.length) > 3 ? j % 3 : 0;

				return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
			};

		function fillHistory(urlTableHist){
			tableHistorial = $('#verDet').DataTable( {
				dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				select: true,
				buttons: [
					{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
						className: 'btn buttons-excel',
						titleAttr: 'Descargar archivo de Excel',
					}
				],
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
					{ "data": "nombreLote" },
					{ "data": "nombreStatus" },
					{ "data": "descripcion" },
					{ "data": "comentario" },
					{ "data": "modificado" },
					{ "data": "usuario" }

				],
				ajax:
					{
						"url": urlTableHist,
						"dataSrc": ""
					},
			});
		}

		function fillFreedom(urlTableFred){
			tableHistorialBloqueo = $('#verDetBloqueo').DataTable( {
				dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				select: true,
				buttons: [
					{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
						className: 'btn buttons-excel',
						titleAttr: 'Descargar archivo de Excel',
					}
				],
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
					{ "data": "nombreLote" },
					{ "data": "precio" },
					{ "data": "modificado" },
					{ "data" : "observacionLiberacion"},
					{ "data": "userLiberacion" }

				],
				ajax:
					{
						"url": urlTableFred,
						"dataSrc": ""
					},
			});
		}
			
		function fillCoSellingAdvisers(urlTableCSA){
		tableCoSellingAdvisers = $('#seeCoSellingAdvisers').DataTable( {
			dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
			width: 'auto',
			select: true,
			buttons: [
				{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
				}
			],
			columnDefs: [{
					defaultContent: "",
					targets: "_all",
					searchable: true,
					orderable: false
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
				{ "data": "asesor" },
				{ "data": "coordinador" },
				{ "data": "gerente" },
				{ "data" : "fecha_creacion"},
				{ "data": "creado_por" }

			],
			ajax:
				{
					"url": urlTableCSA,
					"dataSrc": ""
				},
		});
	}


	function fill_data_asignacion(){
		$.getJSON(url+"Administracion/get_data_asignacion/"+idLote).done( function( data ){
			(data.id_estado == 1) ? $("#check_edo").prop('checked', true) : $("#check_edo").prop('checked', false);
			$('#sel_desarrollo').val(data.id_desarrollo_n);
			$("#sel_desarrollo").selectpicker('refresh');
		});
	}



		$(document).on('click', '#save_asignacion', function(e) {
			e.preventDefault();
			var id_desarrollo = $("#sel_desarrollo").val();
			var id_estado = ($('input:checkbox[id=check_edo]:checked').val() == 'on') ? 1 : 0;

			var data_asignacion = new FormData();
			data_asignacion.append("idLote", idLote);
			data_asignacion.append("id_desarrollo", id_desarrollo);
			data_asignacion.append("id_estado", id_estado);

			if (id_desarrollo == null) {
				alerts.showNotification("top", "right", "Debes seleccionar un desarrollo.", "danger");
			} 

			if (id_desarrollo != null) {
				$('#save_asignacion').prop('disabled', true);
					$.ajax({
					url : '<?=base_url()?>index.php/Administracion/update_asignacion/',
					data: data_asignacion,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST', 
					success: function(data){
					response = JSON.parse(data);
						if(response.message == 'OK') {
							$('#save_asignacion').prop('disabled', false);
							$('#seeInformationModal').modal('hide');
							alerts.showNotification("top", "right", "Asignado con éxito.", "success");
						} else if(response.message == 'ERROR'){
							$('#save_asignacion').prop('disabled', false);
							$('#seeInformationModal').modal('hide');
							alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
						}
					},
					error: function( data ){
							$('#save_asignacion').prop('disabled', false);
							$('#seeInformationModal').modal('hide');
							alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
					}
				});
			}
		});
	</script>
</body>