<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php
		if($this->session->userdata('id_usuario')=="2762" || $this->session->userdata('id_usuario')=="1" || $this->session->userdata('id_usuario')=="1297"){
			 $this->load->view('template/sidebar');
		}
		
		?>
		<!--Contenido de la página-->
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-user-friends fa-2x"></i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align">Remplazo contrato</h3>
								<div class="toolbar">
									<div class="container-fluid p-0">
										<div class="row">
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
												<div class="form-group">
													<label class="m-0" for="filtro3">Proyecto</label>
													<select name="filtro3" id="filtro3" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Proyecto" data-size="7" required>
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
													<label class="m-0" for="filtro4">Condominio</label>
													<select id="filtro4" name="filtro4" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Condominio" data-size="7"></select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
												<div class="form-group">
													<label class="m-0" for="filtro5">Lote</label>
													<select id="filtro5" name="filtro5" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Lote" data-size="7"></select>
												</div>
											</div>
										</div>
									</div>	
								</div>
								<div class="material-datatables">
									<div class="form-group">
										<div class="table-responsive">
											<table id="tableDoct" class="table-striped table-hover">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>CLIENTE</th>
														<th>NOMBRE DE DOCUMENTO</th>
														<th>HORA/FECHA</th>
														<th>DOCUMENTO</th>
														<th>RESPONSABLE</th>
														<th>UBICACIÓN</th>
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
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
	<script>var base_url = '<?php echo base_url() ?>';</script>
	<script type="text/javascript" src="<?=base_url()?>dist/js/addRemove.js"></script>

	<script>
		$(document).ready (function() {
			$(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
				var input = $(this).closest('.input-group').find(':text'),
					log = numFiles > 1 ? numFiles + ' files selected' : label;
				if (input.length) {
					input.val(log);
				} else {
					if (log) alert(log);
				}
			});

			$(document).on('change', '.btn-file :file', function() {
				var input = $(this),
					numFiles = input.get(0).files ? input.get(0).files.length : 1,
					label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [numFiles, label]);
				console.log('triggered');
			});

			$('#filtro3').change(function(){
				var valorSeleccionado = $(this).val();
				$("#filtro4").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>registroCliente/getCondominios/'+valorSeleccionado,
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
			});

			$('#filtro4').change(function(){
				var residencial = $('#filtro3').val();
				var valorSeleccionado = $(this).val();
				$("#filtro5").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>registroCliente/getLotesJuridico/'+valorSeleccionado+'/'+residencial,
					type: 'post',
					dataType: 'json',
					success:function(response){
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['idLote'];
							var name = response[i]['nombreLote'];
							$("#filtro5").append($('<option>').val(id).text(name));
						}
						$("#filtro5").selectpicker('refresh');

					}
				});
			});

			$('#filtro5').change(function(){
				var valorSeleccionado = $(this).val();
				console.log(valorSeleccionado);
				$('#tableDoct').DataTable({
					dom: 'rt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
					ajax:
						{
							"url": '<?=base_url()?>index.php/registroCliente/expedientesReplace/'+valorSeleccionado,
							"dataSrc": ""
						},
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
						"width": "8%",
						"data": function( d ){
							return '<p class="m-0">'+d.nombreResidencial+'</p>';
						}
					},

					{
						"width": "8%",
						"data": function( d ){
							return '<p class="m-0">'+d.nombre+'</p>';
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
							return '<p class="m-0">'+d.nomCliente +' ' +d.apellido_paterno+' '+d.apellido_materno+'</p>';
						}
					},

					{
						"width": "10%",
						"data": function( d ){
							return '<p class="m-0">'+d.movimiento+'</p>';
						}
					},
					{
						"width": "10%",
						"data": function( d ){
							return '<p class="m-0">'+d.modificado+'</p>';
						}
					},

					{
						"width": "10%",
						data: null,
						render: function ( data, type, row ){
							let deletePermission = '';
							let vdPermission = '';
							if (data.expediente == null) {
								vdPermission = '<button type="button" title= "Asociar a contrato" class="btn-data btn-sky addRemoveFile"  data-tableID="tableDoct" data-action="1" data-idLote="' + data.idLote + '" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-name="Contrato"><i class="fas fa-upload"></i></button>';
							} else {
								label = '';
								vdPermission = '<button type="button" title= "Ver contrato" class="btn-data btn-orangeYellow addRemoveFile" data-action="3" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-file="' + data.expediente + '" data-name="Contrato"><i class="far fa-eye"></i></button>';
								deletePermission = '<button type="button" title= "Eliminar contrato" class="btn-data btn-gray addRemoveFile" data-tableID="tableDoct" data-action="2" data-idLote="' + data.idLote + '" data-idDocumento="' + data.idDocumento + '" data-documentType="' + data.tipo_doc + '" data-name="Contrato"><i class="fas fa-trash"></i></button>';
							}
							return '<div class="d-flex justify-center">'+vdPermission + deletePermission + '</div>';
						}
					},
					{
						"width": "10%",
						"data": function( d ){
							return '<p class="m-0">'+ myFunctions.validateEmptyFieldDocs(d.primerNom) +' '+myFunctions.validateEmptyFieldDocs(d.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(d.apellidoMa)+'</p>';
						}
					},

					{
						"width": "10%",
						"data": function( d ){
							var validaub = (d.ubic == null) ? '' : d.ubic;

							return '<p class="m-0">'+ validaub +'</p>';
						}
					}]
				});


				$.post( "<?=base_url()?>index.php/registroCliente/expedientesReplace/"+valorSeleccionado, function( data_json ) {
					var data = jQuery.parseJSON(data_json);
					if(data.length>0){
						$('#btnFilesGral').removeClass('hide');
						$('#btnFilesGral').attr('data-idLote', valorSeleccionado);
					}
					else
					{
						$('#btnFilesGral').addClass('hide');
						$('#btnFilesGral').attr('data-idLote', valorSeleccionado);
					}
				});
			});
		});

		// $(document).on('click', '.pdfLink3', function () {
		// 	var $itself = $(this);
		// 	Shadowbox.open({
		// 		content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
		// 		player:     "html",
		// 		title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
		// 		width:      985,
		// 		height:     660
		// 	});
		// });
	</script>
