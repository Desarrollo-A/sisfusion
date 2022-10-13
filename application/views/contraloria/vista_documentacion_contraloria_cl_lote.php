<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper">
		<?php
			//se debe validar que tipo de perfil esta sesionado para poder asignarle el tipo de sidebar
			if($this->session->userdata('id_rol')=="16" || $this->session->userdata('id_rol')=="6" || $this->session->userdata('id_rol')=="11"  || $this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="32" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_rol')=="47" || $this->session->userdata('id_rol')=="15" || $this->session->userdata('id_rol')=="7" || $this->session->userdata('id_rol')=="12" || $this->session->userdata('id_rol')=="18")//contratacion
				{
					
					$datos = array();
					$datos = $datos4;
					$datos = $datos2;
					$datos = $datos3;  
					$this->load->view('template/sidebar', $datos);
				}
			else{
				echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
			}
		?>

		<!-- Modals -->
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
									<div id="auts-loads"></div>
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
						<button type="button" id="aceptoDelete" class="btn btn-primary"> Si, borrar </button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
					</div>
				</div>
			</div>
		</div>
		<!--termina el modal de cuestion-->

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
								<h3 class="card-title center-align" >Documentación por cliente</h3>
								<div class="toolbar">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label className="m-0" for="filtro3">Proyecto</label>
												<select name="filtro3" id="filtro3" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Proyecto" data-size="7" required>
													<?php
													if($residencial != NULL) :
														foreach($residencial as $fila) : ?>
															<option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> - <?=$fila['descripcion']?></option>
														<?php endforeach;
													endif;
													?>
												</select>
											</div>
										</div>
										<div class="col-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label className="m-0" for="filtro4">Condominio</label>
												<select id="filtro4" name="filtro4" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Condominio" data-size="7"></select>
											</div>
										</div>
										<div class="col-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label className="m-0" for="filtro5">Lote</label>
												<select id="filtro5" name="filtro5" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Lote" data-size="7"></select>
											</div>
										</div>
										<div class="col-12 col-sm-12 col-md-6 col-lg-3">
                                            <div class="form-group">
                                                <label className="m-0" for="filtro6">Cliente</label>
												<select id="filtro6" name="filtro6" class="selectpicker select-gral" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona un cliente" data-size="7"></select>
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
														<th>HORA / FECHA</th>
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
	<script type="text/javascript">
		Shadowbox.init();
	</script>
	<script>
		$(document).ready (function() {
			$(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
				var input = $(this).closest('.input-group').find(':text'),
					log = numFiles > 1 ? numFiles + ' files selected' : label;
				if (input.length) {
					input.val(log);
				} 
				else {
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
				$.ajax({
					url: '<?=base_url()?>registroCliente/getLotesAll/'+valorSeleccionado+'/'+residencial,
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
				var lote = $(this).val();
				console.log(lote);
				$("#filtro6").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>registroCliente/getClientByLote/'+lote,
					type: 'post',
					dataType: 'json',
					success:function(response){
						var len = response.length;
						if(len>0){
                            for( var i = 0; i<len; i++)
                            {
                                var id = response[i]['id_cliente'];
                                var name = response[i]['nombre']+' '+response[i]['apellido_paterno']+' '+response[i]['apellido_materno'] ;
                                let status = response[i]['status'];
                                let labelStatus='';

                                if(status==1){
                                    labelStatus=' [ACTIVO]'
                                }
                                $("#filtro6").append($('<option>').val(id).text(name+labelStatus));
                            }
                        }else{
                                $("#filtro6").append($('<option selected>').val(0).text('SIN CLIENTE'));

                        }
                        $("#filtro6").selectpicker('refresh');

                    }
				});
			});

			let titulos = [];
			$('#tableDoct thead tr:eq(0) th').each( function (i) {
				if( i!=0 && i!=13){
					var title = $(this).text();
					titulos.push(title);

					$(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
					$( 'input', this ).on('keyup change', function () {
                        if ($('#tableDoct').DataTable().column(i).search() !== this.value ) {
                            $('#tableDoct').DataTable().column(i).search(this.value).draw();
                        }
                    });
				}
			});

			$('#filtro6').change(function(){
				var cliente = $(this).val();
				var lote = $('#filtro5').val();
				$('#tableDoct').DataTable({
					dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                	width: 'auto',
					ajax: {
						"url": '<?=base_url()?>index.php/registroCliente/expedientesWS/'+lote+'/'+cliente,
						"dataSrc": ""
					},
					buttons: [{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
						className: 'btn buttons-excel',
						titleAttr: 'Descargar archivo de Excel',
						exportOptions: {
							columns: [0,1,2,3,4,5,7,8],
							format: {
								header:  function (d, columnIdx) {
									if(columnIdx == 0){
										return ' '+d +' ';
									}
						
									return ' '+titulos[columnIdx-1] +' ';	
								}
							}
						}
					},
					{
						extend: 'pdfHtml5',
						text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
						className: 'btn buttons-pdf',
						titleAttr: 'Descargar archivo PDF',
						orientation: 'landscape',
						pageSize: 'LEGAL',
						exportOptions: {
							columns: [0,1,2,3,4,5,7,8],
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
					columns:[{
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
							if (getFileExtension(data.expediente) == "pdf") {
								if(data.tipo_doc == 8){
									file = '<a class="pdfLink3 btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo"  data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
								} else if(data.tipo_doc == 66){
									file = '<a class="verEVMKTD btn-data btn-warning" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-file-pdf"></i></a>';
								}else {
									file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" title= "Ver archivo"  data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a>';
								}
							}
							else if (getFileExtension(data.expediente) == "xlsx") {
								if(data.idMovimiento == 35 || data.idMovimiento == 22 || data.idMovimiento == 62 || data.idMovimiento == 75 || data.idMovimiento == 94){
									file = '<a href="../../static/documentos/cliente/corrida/' + data.expediente + '" class="btn-data btn-green-excel"><i class="fas fa-file-excel"></i><src="../../static/documentos/cliente/corrida/"' + data.expediente + '"></a><button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button>';
								}
								else {
									file = '<a href="../../static/documentos/cliente/corrida/' + data.expediente + '" class="btn-data btn-green-excel"><i class="fas fa-file-excel"></i><src="../../static/documentos/cliente/corrida/"' + data.expediente + '"></a>';
								}
							}
							else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
								if(data.tipo_doc == 7){
									if(data.idMovimiento == 35 || data.idMovimiento == 22 || data.idMovimiento == 62 || data.idMovimiento == 75 || data.idMovimiento == 94){
										file = '<button type="button" id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="fas fa-upload"></i></button>';
									}
									else {
										file = '<button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green" disabled><i class="fas fa-upload"></i></button>';
									}
								}
								else if(data.tipo_doc == 8){
									file = '<button type="button" title= "Contrato inhabilitado" class="btn-data btn-orangeYellow" disabled><i class="fas fa-clipboard"></i></button>';
								}
								else {
									file = '<button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green" disabled><i class="fas fa-upload"></i></button>';
								}
							}
							else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
								file = '<a class="btn-data btn-blueMaderas pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
							}
							else if (getFileExtension(data.expediente) == "Depósito de seriedad versión anterior") {
								file = '<a class="btn-data btn-blueMaderas pdfLink22" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
							}
							else if (getFileExtension(data.expediente) == "Autorizaciones") {
								file = '<a href="#" class="btn-data btn-sky seeAuts" title= "Autorizaciones" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a>';
							}
							else if (getFileExtension(data.expediente) == "Prospecto") {
								file = '<a href="#" class="btn-data btn-sky verProspectos" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'" data-lp="'+data.lugar_prospeccion+'"><i class="material-icons">record_voice_over</i></a>';
							}
							else{
								if(data.tipo_doc == 66){
									file = '<a class="verEVMKTD btn-data btn-violetChin" data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-image"></i></a>';
								}
								else{
									file = '<a class="pdfLink btn-data btn-warning" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></a>';
								}
							}
							return '<div class="d-flex justify-center">'+file+'</div>';
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
			});
		});/*document Ready*/

		function getFileExtension(filename) {
			validaFile =  filename == null ? 'null':
				filename == 'Depósito de seriedad' ? 'Depósito de seriedad':
					filename == 'Autorizaciones' ? 'Autorizaciones':
						filename.split('.').pop();
			return validaFile;
		}

		$(document).on('click', '.pdfLink', function () {
			var $itself = $(this);
			Shadowbox.open({
				content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>static/documentos/cliente/expediente/'+$itself.attr('data-Pdf')+'"></iframe></div>',
				player:     "html",
				title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
				width:      985,
				height:     660
			});
		});

		$(document).on('click', '.pdfLink2', function () {
			var $itself = $(this);
			Shadowbox.open({
				content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>asesor/deposito_seriedad/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
				player:     "html",
				title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
				width:      1600,
				height:     900
			});
		});

		$(document).on('click', '.pdfLink22', function () {
			var $itself = $(this);
			Shadowbox.open({
				content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/1/"></iframe></div>',
				player:     "html",
				title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
				width:      1600,
				height:     900
			});
		});

		$(document).on('click', '.pdfLink3', function () {
			var $itself = $(this);
			Shadowbox.open({
				content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>static/documentos/cliente/contrato/'+$itself.attr('data-Pdf')+'"></iframe></div>',
				player:     "html",
				title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
				width:      985,
				height:     660
			});
		});

		$(document).on('click', '.verProspectos', function () {
			var $itself = $(this);
			if ($itself.attr('data-lp') == 6) { // IS MKTD SALE
				Shadowbox.open({
					/*verProspectos*/
					content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>clientes/printProspectInfoMktd/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
					player:     "html",
					title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
					width:      985,
					height:     660
				});
			} else {
				Shadowbox.open({
					/*verProspectos*/
					content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute" src="<?=base_url()?>clientes/printProspectInfo/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
					player:     "html",
					title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
					width:      985,
					height:     660
				});
			}
		});


		/*evidencia MKTD PDF*/
		$(document).on('click', '.verEVMKTD', function () {
			var $itself = $(this);
			var cntShow = '';

			if(checaTipo($itself.attr('data-expediente')) == "pdf"){
				cntShow = '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>';
			}
			else{
				cntShow = '<div><img src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" class="img-responsive"></div>';
			}

			Shadowbox.open({
				content:    cntShow,
				player:     "html",
				title:      "Visualizando Evidencia MKTD: " + $itself.attr('data-nombreCliente'),
				width:      985,
				height:     660

			});
		});

		function checaTipo(archivo){
			archivo.split('.').pop();
				return validaFile;
		}

		var miArrayAddFile = new Array(8);
		var miArrayDeleteFile = new Array(1);

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
				alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
			}

			if (validaFile == 1) {
				$('#sendFile').prop('disabled', true);
				$.ajax({
					url: "<?=base_url()?>index.php/registroCliente/addFileCorrida",
					data: dataFile,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					success : function (response) {
						response = JSON.parse(response);
						if(response.message == 'OK') {
							alerts.showNotification('top', 'right', 'Corrida enviada', 'success');
							$('#sendFile').prop('disabled', false);
							$('#addFile').modal('hide');
							$('#tableDoct').DataTable().ajax.reload();
						} 
						else if(response.message == 'ERROR'){
							alerts.showNotification('top', 'right', 'Error al enviar corrida y/o formato no válido', 'danger');
							$('#sendFile').prop('disabled', false);
						}
					}
				});
			}
		});
		
		$(document).on("click", ".delete", function (e) {
			e.preventDefault();
			var iddoc = $(this).data("iddoc");
			var tipodoc = $(this).data("tipodoc");

			miArrayDeleteFile[0] = iddoc;

			$(".tipoA").html(tipodoc);
			$('#cuestionDelete').modal('show');
		});

		$(document).on('click', '#aceptoDelete', function(e) {
			e.preventDefault();
			var id = miArrayDeleteFile[0];
			var dataDelete = new FormData();
			dataDelete.append("idDocumento", id);

			$('#aceptoDelete').prop('disabled', true);
			$.ajax({
				url: "<?=base_url()?>index.php/registroCliente/deleteCorrida",
				data: dataDelete,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST',
				success : function (response) {
					response = JSON.parse(response);
					if(response.message == 'OK') {
						alerts.showNotification('top', 'right', 'Archivo eliminado', 'success');
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

		$(document).on('click', '.seeAuts', function (e) {
			e.preventDefault();
			var $itself = $(this);
			var idLote=$itself.attr('data-idLote');
			$.post( "<?=base_url()?>index.php/registroLote/get_auts_by_lote/"+idLote, function( data ) {
				$('#auts-loads').empty();
				var statusProceso;
				$.each(JSON.parse(data), function(i, item) {
					if(item['estatus'] == 0){
						statusProceso="<small class='label bg-green' style='background-color: #00a65a'>ACEPTADA</small>";
					}
					else if(item['estatus'] == 1){
						statusProceso="<small class='label bg-orange' style='background-color: #FF8C00'>En proceso</small>";
					}
					else if(item['estatus'] == 2){
						statusProceso="<small class='label bg-red' style='background-color: #8B0000'>DENEGADA</small>";
					}
					else if(item['estatus'] == 3){
						statusProceso="<small class='label bg-blue' style='background-color: #00008B'>En DC</small>";
					}
					else{
						statusProceso="<small class='label bg-gray' style='background-color: #2F4F4F'>N/A</small>";
					}
					$('#auts-loads').append('<h4>Solicitud de autorización:  '+statusProceso+'</h4><br>');
					$('#auts-loads').append('<h4>Autoriza: '+item['nombreAUT']+'</h4><br>');
					$('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' + '<br><hr>');

				});
				$('#verAutorizacionesAsesor').modal('show');
			});
		});
	</script>
</body>