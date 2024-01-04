<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>

		<!-- Modals -->
		<!-- modal  INSERT FILE-->
		<div class="modal fade" id="addFile" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary btn-file">
								Seleccionar archivo&hellip;<input type="file" name="expediente" id="expediente" style="display: none;">
								</span>
							</label>
							<input type="text" class="form-control" id= "txtexp" readonly>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" id="sendFile" class="btn btn-primary"><span
								class="material-icons" >send</span> Guardar documento </button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal INSERT-->

		<!--modal que pregunta cuando se esta borrando un archivo-->
		<div class="modal fade" id="cuestionDelete" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<center><h3 class="modal-title">¡Eliminar archivo!</h3></center>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row centered center-align">
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-2">
									<h1 class="modal-title"> <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i></h1>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-10">
									<h4 class="modal-title">¿Está seguro de querer eliminar definivamente este archivo (<b><span class="tipoA"></span></b>)? </h4>
									<h5 class="modal-title"><i> Esta acción no se puede deshacer.</i> </h5>
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<br><br>
						<button type="button" id="aceptoDelete" class="btn btn-primary"> Sí, borrar </button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
					</div>
				</div>
			</div>
		</div>
		<!--termina el modal de cuestion-->

		<!-- autorizaciones-->
		<div class="modal fade" id="verAutorizacionesAsesor" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<center><h3 class="modal-title">Autorizaciones <span class="material-icons">vpn_key</span></h3></center>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div id="auts-loads">
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Aceptar </button>
					</div>
				</div>
			</div>
		</div>
		<!-- autorizaciones end-->
		<!-- END Modals -->


		<!--Contenido de la página-->
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="material-icons">next_week</i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align">Documentación</h3>
								<div class="toolbar">
									<div class="container-fluid p-0">
										<div class="row">
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
												<div class="form-group">
													<label class="m-0" for="filtro3">Proyecto:</label>
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
	<?php $this->load->view('template/footer');?>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
	<script type="text/javascript">
		Shadowbox.init();
	</script>
	<script>
		var id_rol_current = <?php echo $this->session->userdata('id_rol')?>;
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
						for( var i = 0; i<len; i++){
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
				<?php
					$metodoToExc = 'getLotesAllAssistant';
				?>
				$.ajax({
					url: '<?=base_url()?>registroCliente/<?php echo $metodoToExc;?>/'+valorSeleccionado+'/'+residencial,
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
				$('#tableDoct').DataTable({
					ajax:
						{
							"url": '<?=base_url()?>index.php/registroCliente/expedientesWS/'+valorSeleccionado,
							"dataSrc": ""
						},
					dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
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
					columns: [{
						data: 'nombreResidencial'
					},
					{
						data: 'nombre'
					},
					{
						data: 'nombreLote'
					},
					{
						data: null,
						render: function ( data, type, row ){
							return data.nomCliente +' ' +data.apellido_paterno+' '+data.apellido_materno;
						},
					},
					{
						data: 'movimiento'
					},
					{
						data: 'modificado'
					},
					{
						data: null,
						render: function ( data, type, row ){
							if (getFileExtension(data.expediente) == "pdf") {
								if(data.tipo_doc == 8){
									file = '<a class="pdfLink3 btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
								} else {
									<?php if($this->session->userdata('id_rol') == 6){?>
									if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96){
										file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-gray delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
									} else {
										file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
									}
									<?php } else {?>file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';<?php } ?>
								}
							}
							else if (getFileExtension(data.expediente) == "xlsx" || getFileExtension(data.expediente) == "XLSX") {
								file = "<a href='../../static/documentos/cliente/corrida/" + data.expediente + "' class='btn-data btn-green-excel'><i class='fas fa-file-excel'></i><src='../../static/documentos/cliente/corrida/" + data.expediente + "'> </a> ";
							}
							else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
								if(data.tipo_doc == 7){
									file = '<button type="button" title= "Corrida inhabilitada" class="btn-data btn-orangeYellow" disabled><i class="fas fa-th"></i></button>';
								} else if(data.tipo_doc == 8){
									file = '<button type="button" title= "Contrato inhabilitado" class="btn-data btn-sky" disabled><i class="fas fa-file"></i></button>';
								} else {
									<?php if($this->session->userdata('id_rol') == 6){?>
									if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96){
										file = '<button type="button" id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-cloud-upload-alt"></i></button>';
									} else {
										file = '<button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green" disabled><i class="fas fa-cloud-upload-alt"></i></button>';
									}
							
									<?php } else {?> file = '<button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green" disabled><i class="fas fa-cloud-upload-alt"></i></button>'; <?php } ?>
								}
							}
							else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
								file = '<a class="btn-data btn-sky pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
							}
							else if (getFileExtension(data.expediente) == "Autorizaciones") {
								file = '<a href="#" class="btn-data btn-warning seeAuts" title= "Autorizaciones" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a>';
							}
							else if (getFileExtension(data.expediente) == "Prospecto") {
								file = '<a href="#" class="btn-data btn-blueMaderas verProspectos" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'"><i class="fas fa-user-plus"></i></a>';
							}
							else{
								<?php if($this->session->userdata('id_rol') == 6){?>
								if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 || data.idMovimiento == 96){
									file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-gray delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
								} else {
									file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
								}
								<?php } else {?> file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>'; <?php }?>

							}
							return '<div class="d-flex justify-center">'+file+'</div>';
						}
					},
					{
						data: null,
						render: function ( data, type, row ){
							return myFunctions.validateEmptyFieldDocs(data.primerNom) +' '+myFunctions.validateEmptyFieldDocs(data.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(data.apellidoMa);
						},
					},
					{
						data: 'ubic'
					}]
				});
			});

			$('.btn-documentosGenerales').on('click', function () {
				$('#modalFiles').modal('show');
			});

			function getFileExtension(filename) {
				validaFile =  filename == null ? 'null':
					filename == 'Depósito de seriedad' ? 'Depósito de seriedad':
						filename == 'Autorizaciones' ? 'Autorizaciones':
							filename.split('.').pop();
				return validaFile;
			}
		});

		$(document).on('click', '.pdfLink', function () {
			var $itself = $(this);
			Shadowbox.open({
				content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>static/documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
				player:     "html",
				title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
				width:      985,
				height:     660
			});
		});

		$(document).on('click', '.pdfLink2', function () {
			var $itself = $(this);
			Shadowbox.open({
				content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
				player:     "html",
				title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
				width:      1600,
				height:     900
			});
		});


		$(document).on('click', '.pdfLink3', function () {
			var $itself = $(this);
			Shadowbox.open({
				content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
				player:     "html",
				title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
				width:      985,
				height:     660
			});
		});

		$(document).on('click', '.verProspectos', function () {
			var $itself = $(this);
			Shadowbox.open({
				content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>clientes/printProspectInfo/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
				player:     "html",
				title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
				width:      985,
				height:     660

			});
		});


		$(document).on('click', '.seeAuts', function (e) {
			e.preventDefault();
			var $itself = $(this);
			var idLote=$itself.attr('data-idLote');
			$.post( "<?=base_url()?>index.php/registroLote/get_auts_by_lote/"+idLote, function( data ) {
				$('#auts-loads').empty();
				var statusProceso;
				$.each(JSON.parse(data), function(i, item) {
					if(item['estatus'] == 0)
					{
						statusProceso="<small class='label bg-green' style='background-color: #00a65a'>ACEPTADA</small>";
					}
					else if(item['estatus'] == 1)
					{
						statusProceso="<small class='label bg-orange' style='background-color: #FF8C00'>En proceso</small>";
					}
					else if(item['estatus'] == 2)
					{
						statusProceso="<small class='label bg-red' style='background-color: #8B0000'>DENEGADA</small>";
					}
					else if(item['estatus'] == 3)
					{
						statusProceso="<small class='label bg-blue' style='background-color: #00008B'>En DC</small>";
					}
					else
					{
						statusProceso="<small class='label bg-gray' style='background-color: #2F4F4F'>N/A</small>";
					}
					$('#auts-loads').append('<h4>Solicitud de autorización:  '+statusProceso+'</h4><br>');
					$('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +
						'<br><hr>');

				});
				$('#verAutorizacionesAsesor').modal('show');
			});
		});
		
		<?php if($this->session->userdata('id_rol') == 6){?>
		/*más querys alv*/
		var miArrayAddFile = new Array(8);
		var miArrayDeleteFile = new Array(1);

		$(document).ready (function() {
			$(document).on("click", ".update", function(e){
				e.preventDefault();

				var descdoc= $(this).data("descdoc");
				var idCliente = $(this).attr("data-idCliente");
				var nombreResidencial = $(this).attr("data-nombreResidencial");
				var nombreCondominio = $(this).attr("data-nombreCondominio");
				var idCondominio = $(this).attr("data-idCondominio");
				var nombreLote = $(this).attr("data-nombreLote");
				var idLote = $(this).attr("data-idLote");
				var tipodoc = $(this).attr("data-tipodoc");
				var iddoc = $(this).attr("data-iddoc");

				miArrayAddFile[0] = idCliente;
				miArrayAddFile[1] = nombreResidencial;
				miArrayAddFile[2] = nombreCondominio;
				miArrayAddFile[3] = idCondominio;
				miArrayAddFile[4] = nombreLote;
				miArrayAddFile[5] = idLote;
				miArrayAddFile[6] = tipodoc;
				miArrayAddFile[7] = iddoc;

				$(".lote").html(descdoc);
				$('#addFile').modal('show');
			});
		});

		$(document).on('click', '#sendFile', function(e) {
			e.preventDefault();
			var idCliente = miArrayAddFile[0];
			var nombreResidencial = miArrayAddFile[1];
			var nombreCondominio = miArrayAddFile[2];
			var idCondominio = miArrayAddFile[3];
			var nombreLote = miArrayAddFile[4];
			var idLote = miArrayAddFile[5];
			var tipodoc = miArrayAddFile[6];
			var iddoc = miArrayAddFile[7];
			var expediente = $("#expediente")[0].files[0];
			var validaFile = (expediente == undefined) ? 0 : 1;
			tipodoc = (tipodoc == 'null') ? 0 : tipodoc;
			var dataFile = new FormData();

			dataFile.append("idCliente", idCliente);
			dataFile.append("nombreResidencial", nombreResidencial);
			dataFile.append("nombreCondominio", nombreCondominio);
			dataFile.append("idCondominio", idCondominio);
			dataFile.append("nombreLote", nombreLote);
			dataFile.append("idLote", idLote);
			dataFile.append("expediente", expediente);
			dataFile.append("tipodoc", tipodoc);
			dataFile.append("idDocumento", iddoc);

			if (validaFile == 0) {
				alerts.showNotification('top', 'right', 'Debes seleccionar un archivoo', 'danger');
			}

			if (validaFile == 1) {
				$('#sendFile').prop('disabled', true);
				$.ajax({
					url: "<?=base_url()?>index.php/registroCliente/addFileAsesor",
					data: dataFile,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					success : function (response) {
						response = JSON.parse(response);
						if(response.message == 'OK') {
							alerts.showNotification('top', 'right', 'Expediente enviado', 'success');
							$('#sendFile').prop('disabled', false);
							$('#addFile').modal('hide');
							$('#tableDoct').DataTable().ajax.reload();
						} else if(response.message == 'ERROR'){
							alerts.showNotification('top', 'right', 'Error al enviar expediente y/o formato no válido', 'danger');
							$('#sendFile').prop('disabled', false);
						}
					}
				});
			}
		});

		$(document).ready (function() {
			$(document).on("click", ".delete", function(e){
				e.preventDefault();
				var iddoc= $(this).data("iddoc");
				var tipodoc= $(this).data("tipodoc");
				miArrayDeleteFile[0] = iddoc;

				$(".tipoA").html(tipodoc);
				$('#cuestionDelete').modal('show');
			});
		});

		$(document).on('click', '#aceptoDelete', function(e) {
			e.preventDefault();
			var id = miArrayDeleteFile[0];
			var dataDelete = new FormData();
			dataDelete.append("idDocumento", id);

			$('#aceptoDelete').prop('disabled', true);
			$.ajax({
				url: "<?=base_url()?>index.php/registroCliente/deleteFile",
				data: dataDelete,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST',
				success : function (response) {
					response = JSON.parse(response);
					if(response.message == 'OK') {
						alerts.showNotification('top', 'right', 'Archivo eliminado', 'danger');
						$('#aceptoDelete').prop('disabled', false);
						$('#cuestionDelete').modal('hide');
						$('#tableDoct').DataTable().ajax.reload();
					} 
					else if(response.message == 'ERROR'){
						alerts.showNotification('top', 'right', 'Error al eliminar el archivo', 'danger');
						$('#tableDoct').DataTable().ajax.reload();
					}
				}
			});

		});

		jQuery(document).ready(function(){
			jQuery('#addFile').on('hidden.bs.modal', function (e) {
			jQuery(this).removeData('bs.modal');
			jQuery(this).find('#expediente').val('');
			jQuery(this).find('#txtexp').val('');
			})
		})
		<?php } ?>
	</script>
</body>