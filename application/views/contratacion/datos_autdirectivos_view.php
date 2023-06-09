	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
	<link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet" />
	<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>

		<style>
			#addFile .radio-with-Icon input[type="radio"]:checked ~ label .iAccepted {
				color: #4caf50;
			}

			#addFile .radio-with-Icon input[type="radio"]:checked ~ label .iDenied {
				color: #929292;
			}

			#addFile .radio-with-Icon input[type="radio"]:checked ~ label .iSend {
				color: #103f75;
			}

			#addFile .radio-with-Icon i {
				color: #eaeaea;
			}

			#addFile .radio-with-Icon i:hover {
				color: #929292;
			}
		</style>

		<!-- Modals -->
		<!-- modal  INSERT COMENTARIOS-->
		<div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<form method="POST" name="sendAutsFromD" id="sendAutsFromD" enctype="multipart/form-data" action="<?=base_url()?>registroCliente/updateAutsFromsDC">
						<div class="modal-header d-flex justify-between align-center">
							<h3 class="modal-title" id="myModalLabel">Autorizaciones</h3>
							<label class="m-0">(<span class="items"></span>) autorizaciones pendientes</label>
						</div>
						<div class="modal-body pl-0 pr-0">
							<div class="scroll-styles" id="loadAuts" style="max-height:450px; padding:0 20px; overflow:auto"></div>
							<input hidden name="numeroDeRow" id="numeroDeRow">
							<input hidden name="idCliente" id="idCliente">
							<input hidden name="idCondominio" id="idCondominio">
							<input hidden name="idLote" id="idLote">
							<input hidden name="id_autorizacion" id="id_autorizacion">
							<input hidden name="nombreResidencial" id="nombreResidencial">
							<input hidden name="nombreCondominio" id="nombreCondominio">
							<input hidden name="nombreLote" id="nombreLote">						
						</div>
						<div class="modal-footer">
							<button type="submit"  class="btn btn-primary">Enviar autorización</button>
							<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						</div>
					</form>
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
								<i class="material-icons">verified_user</i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align">Tus autorizaciones</h3>
								<div class="table-responsive">
									<table id="addExp" class="table-striped table-hover">
										<thead>
											<tr>
												<th>PROYECTO</th>
												<th>LOTE</th>
												<th>CLIENTE</th>
												<th>ASESOR(es)</th>
												<th>GERENTE</th>
												<th>AUTORIZACIÓN</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
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
	<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
	<script>	
		$(document).ready(function() {
			$(document).on('fileselect', '.btn-file :file', function(event, numFiles, label) {
				var input = $(this).closest('.input-group').find(':text'),
					log = numFiles > 1 ? numFiles + ' files selected' : label;
				if (input.length) {
					input.val(log);
				} else {
					if (log) alert(log);
				}
			});
		});

		function changeName(e){
			var fileName = e.files[0].name;
			var relatedTarget = $( e ).closest( '.file-gph' ).find( '.file-name' );
			relatedTarget[0].value = fileName;
		}

		$(document).on('change', '.btn-file :file', function() {
			var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
		});

		let titulos = [];
		$('#addExp thead tr:eq(0) th').each( function (i) {
			if( i!=5){
				var title = $(this).text();
				titulos.push(title);
				$(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>');
				$( 'input', this ).on('keyup change', function () {
					if ($('#addExp').DataTable().column(i).search() !== this.value ) {
						$('#addExp').DataTable().column(i).search(this.value).draw();
					}
				});
			}
		});

		var miArray = new Array(6)
		$(document).ready (function() {
			var table;
			var funcionToGetData;
			<?php
			if($this->session->userdata('id_rol') == 1){
			?>
				funcionToGetData = 'autsByDC';
			<?php
			}
			else{
			?>
				funcionToGetData = 'tableAut';
			<?php
			}
			?>

			table = $('#addExp').DataTable( {
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
				buttons: [{
					extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
					exportOptions: {
						columns: [0,1,2,3,4],
						format: {
							header:  function (d, columnIdx) {								
								if(columnIdx == 0){
                                    return 'PROYECTO'
                                }else if(columnIdx == 1){
                                    return 'LOTE';
                                }else if(columnIdx == 2){
                                    return 'CLIENTE';
                                }else if(columnIdx == 3){
                                    return 'ASESOR(es)';
                                }else if(columnIdx == 4){
                                    return 'GERENTE ';
                                }
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
						columns: [0,1,2,3,4],
						format: {
							header:  function (d, columnIdx) {								
								if(columnIdx == 0){
                                    return 'PROYECTO'
                                }else if(columnIdx == 1){
                                    return 'LOTE';
                                }else if(columnIdx == 2){
                                    return 'CLIENTE';
                                }else if(columnIdx == 3){
                                    return 'ASESOR(es)';
                                }else if(columnIdx == 4){
                                    return 'GERENTE ';
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
				ajax: "<?=base_url()?>index.php/registroCliente/"+funcionToGetData+"/",
				columns: [{
					"data": "nombreResidencial"
				},
				{ 
					"data": "nombreLote" 
				},
				{
					"data": function( d ){
						var cliente = (d.cliente == null ? "" : d.cliente);
						return cliente;
					}
				},
				{
					"data": function( d ){
						var as1 = (d.asesor == null ? "" : d.asesor + '<br>');
						var as2 = (d.asesor2 == null ? "" : d.asesor2 + '<br>');
						var as3 = (d.asesor3 == null ? "" : d.asesor3 + '<br>');

						return as1 ;
					}
				},
				{
					"data": function( d ){
						var gerente = (d.gerente == null ? "" : d.gerente);
						return gerente;
					}
				},
				{
					"data": function( d ){
						return '<div class="d-flex justify-center"><a href="" class="btn-data btn-blueMaderas getInfo" data-id_autorizacion="'+d.id_autorizacion+'" data-idCliente="'+d.id_cliente+'" data-nombreResidencial="'+d.nombreResidencial+'" ' + 'data-nombreCondominio="'+d.nombreCondominio+'" data-nombreLote="'+d.nombreLote+'" data-idCondominio="'+d.idCondominio+'" ' + 'data-idLote="'+d.idLote+'"><i class="fas fa-key"></i></a></div>';
					}
				}]
			});


			$("#addExp tbody").on("click", ".getInfo", function(e){
				e.preventDefault();

				var $itself = $(this);
				var idCliente = $itself.attr("data-idCliente");
				var nombreResidencial=$itself.attr('data-nombreresidencial');
				var nombreCondominio=$itself.attr('data-nombrecondominio');
				var idCondominio = $itself.attr("data-idCondominio");
				var nombreLote = $itself.attr("data-nombrelote");
				var idLote=$itself.attr('data-idLote');
				var id_aut = $itself.attr('data-id_autorizacion');
				$('#idCliente').val(idCliente);
				$('#idCondominio').val(idCondominio);
				$('#idLote').val(idLote);
				$('#id_autorizacion').val(id_aut);
				$('#nombreResidencial').val(nombreResidencial);
				$('#nombreCondominio').val(nombreCondominio);
				$('#nombreLote').val(nombreLote);

				$.post( "<?=base_url()?>index.php/registroLote/get_auts_by_lote_directivos/"+idLote, function( data ) {
					$('#loadAuts').empty();
					var ctn;
					var p = 0;
					var opcionDenegado;
					$.each(JSON.parse(data), function(i, item) {
						<?php if( $this->session->userdata('id_rol') == 1 ) { ?>
							opcionDenegado = '';
						<?php } else { ?>
							opcionDenegado = `<p class="radioOption-Item m-0 pl-1">
												<input type="radio" name="accion${i}" id="send${i}" value="3" class="d-none" aria-invalid="false">
												<label for="send${i}" class="cursor-point m-0">
													<i class="fas fa-paper-plane iSend" style="font-size:15px" data-toggle="tooltip" data-placement="bottom" title="Enviar a DC"></i>
												</label>
											</p>`;
						<?php } ?>

						ctn = `
							<div class="boxContent" style="margin-bottom:20px; padding: 10px; background: #f7f7f7; border-radius:15px">
								<div class="d-flex">
									<div class="w-80">
										<small>
											<label class="m-0" style="font-size: 11px; font-weight: 100;">Solicitud asesor ( ${ item['fecha_creacion'].substr(0,10) })</label>
										</small>
									</div>
									<div class="w-20">
										<div class="radio-with-Icon d-flex justify-end">
											<p class="radioOption-Item m-0">
												<input type="radio" name="accion${i}" id="accept${i}" value="0" class="d-none" aria-invalid="false" checked>
												<label for="accept${i}" class="cursor-point m-0">
													<i class="fas fa-thumbs-up iAccepted" style="font-size:15px" data-toggle="tooltip" data-placement="bottom" title="Aceptar"></i>
												</label>
											</p>
											<p class="radioOption-Item m-0 pl-1">
												<input type="radio" name="accion${i}" id="denied${i}" value="2" class="d-none" aria-invalid="false">
												<label for="denied${i}" class="cursor-point m-0">
													<i class="fas fa-thumbs-down iDenied" style="font-size:15px" data-toggle="tooltip" data-placement="bottom" title="Rechazar"></i>
												</label>
											</p>
											${opcionDenegado}
										</div>
									</div>
								</div>
								<label>${ item['autorizacion'] }</label>
								<div class="file-gph">
									<input class="d-none" type="file" id="expediente${i}" name="docArchivo${i}" onchange="changeName(this)">
									<input class="file-name" type="text" placeholder="No has seleccionada nada aún" >
									<label class="upload-btn m-0" for="expediente${i}">
										<span>Buscar</span>
										<i class="fas fa-search"></i>
									</label>
								</div>
								<div class="form-group label-floating is-empty">
									<label class="control-label">Comentario</label>
									<input type="text" name="observaciones${i}" class="form-control" style="border-radius:27px; border: 1px solid #cdcdcd; background-image: none; padding: 0 20px;">
								</div>
								<input type="hidden" name="idAutorizacion${i}"  value="${item['id_autorizacion']}">
							</div>
						`;
						$('#loadAuts').append(ctn);
						p++;
					});
					introJs().start();
					$(".items").text(p);
					$('#numeroDeRow').val(p);
				});
				$('#addFile').modal('show');
			});
		});

		$(document).on('click', '#save', function(e) {
			e.preventDefault();

			var idCliente = miArray[0];
			var nombreResidencial = miArray[1];
			var nombreCondominio = miArray[2];
			var idCondominio = miArray[3];
			var nombreLote = miArray[4];
			var idLote = miArray[5];
			var expediente = $("#expediente")[0].files[0];
			var motivoAut = $("#motivoAut").val();
			var data = new FormData();

			data.append("idCliente", idCliente);
			data.append("nombreResidencial", nombreResidencial);
			data.append("nombreCondominio", nombreCondominio);
			data.append("idCondominio", idCondominio);
			data.append("nombreLote", nombreLote);
			data.append("idLote", idLote);
			data.append("expediente", expediente);
			data.append("motivoAut", motivoAut);

			var file = (expediente == undefined) ? 0 : 1;
			if (motivoAut.length <= 10 || file == 0) {
				alerts.showNotification('top', 'right', 'Todos los campos son obligatorios y/o mayores a 10 caracteres.', 'danger');
			}

			if (motivoAut.length > 10 && file == 1) {
				$.ajax({
					url: "addFileVentas",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					method: 'POST',
					type: 'POST',
					success: function(data){
						$('#addExp').DataTable().ajax.reload( );
						alerts.showNotification('top', 'right', 'Autorización enviada', 'success');
						$('#addFile').modal('hide');					
					},
					error: function( data ){
						alerts.showNotification('top', 'right', 'Error al enviar autorización', 'danger');
					}
				});
			}
		});

		jQuery(document).ready(function(){
			jQuery('#addFile').on('hidden.bs.modal', function (e) {
				jQuery(this).removeData('bs.modal');
				jQuery(this).find('#expediente').val('');
				jQuery(this).find('#txtexp').val('');
				jQuery(this).find('#motivoAut').val('');

			})
		})

		$("#filtro4").on("change", function(){
			$('#addExp').DataTable().ajax.reload();
		});

		$("#guardarImagen").click(function() {
			let tr = $(this).closest('tr');
			var comentario = $("#observaciones").val();
			var archivos = $("#fotoAlumno")[0].files;
    
			if (archivos.length > 0) {
				//Sólo queremos la primera imagen, ya que el usuario pudo seleccionar más
				var foto = archivos[0]; 
				var lector = new FileReader();
				var formData = new FormData();

				//Ojo: En este caso 'foto' será el nombre con el que recibiremos el archivo en el servidor
				formData.append('foto', foto);
				formData.append('comentario', comentario);
			}
		});

		$("#sendAutsFromD").on('submit', function(e){
			e.preventDefault();	
			var formData = new FormData(this);
			$.ajax({
				type: 'POST',
				url: general_base_url + 'RegistroCliente/updateAutsFromsDC',
				data: formData,
				dataType: "json",
				contentType: false,
				processData:false,
				success: function(data) {
						alerts.showNotification("top", "right", ""+data.mensaje+"", ""+data.code+"");
						$('#addExp').DataTable().ajax.reload(null, false );
						$('#addFile').modal('hide');
					
				},
				error: function(){
					alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
				}
			});
		});
	</script>
</body>