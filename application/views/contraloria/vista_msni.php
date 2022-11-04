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
								Seleccionar archivo&hellip;<input type="file" name="file_msni" id="file_msni" style="display: none;">
								</span>
							</label>
							<input type="text" class="form-control" id= "txtexp" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="sendFile" class="btn btn-primary"><span
								class="material-icons" >send</span> Actualizar M/S </button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
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
								<h3 class="card-title center-align" >Meses sin intereses</h3>
								<div class="toolbar">
									<div class="container-fluid p-0">
										<div class="row aligned-row d-flex align-end">
											<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
												<label class="m-0" for="filtro3">Proyecto</label>
												<select name="filtro3" id="filtro3" class="selectpicker select-gral mb-0" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Proyecto" data-size="7" required>
													<?php
													if($residencial != NULL) :
														foreach($residencial as $fila) : ?>
															<option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
														<?php endforeach;
													endif;
													?>
												</select>
											</div>
											<div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4 mt-2">
												<button type="button" id="loadFile" class="btn-data-gral btn-success d-flex justify-center align-center">Cargar información<i class="fas fa-paper-plane pl-1"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="material-datatables">
								<div class="form-group">
                                        <div class="table-responsive">
											<table class="table-striped table-hover" id="tabla_msni" name="tabla_msni_name">
												<thead>
													<tr>
														<th>CONDOMINIO</th>
														<th>MSNI</th>
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


		});

		$('#tabla_msni thead tr:eq(0) th').each( function (i) {
			var title = $(this).text();
			$(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
			$( 'input', this ).on('keyup change', function () {
				if ($('#tabla_msni').DataTable().column(i).search() !== this.value ){
					$('#tabla_msni').DataTable()
					.column(i)
					.search(this.value)
					.draw();
				}
			}); 
        });

		$('#filtro3').change(function(){
			var idProyecto = $(this).val();
			$('#tabla_msni').DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				buttons: [{
						className: 'btn buttons-excel',
						text: 'DESCARGAR PLANTILLA',
						extend: 'csvHtml5',
						titleAttr: 'CSV',
						exportOptions: {
                        columns: [0, 1],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'CONDOMINIO';
                                }else if(columnIdx == 1){
                                    return 'MSNI';
                                }
                            }
                        }
                    },
					}],
				ajax: {
					"url": '<?=base_url()?>index.php/Contraloria/getMsni/'+idProyecto,
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
					data: 'nombre'
				},
				{
					data: 'msni'
				}]
			})
		});

		var getInfo3 = new Array(1);
		$(document).on("click", "#loadFile", function(e){

			var res = $('#filtro3').val();
			var validares = ($("#filtro3").val().length == 0) ? 0 : 1;
			if (validares == 0) {
				alerts.showNotification("top", "right", "Seleccione el proyecto.", "danger");
			} else {
				getInfo3[0] = res;
				$('#addFile').modal('show');
			}
		});


		$(document).on('click', '#sendFile', function(e) {
			e.preventDefault();
			var idproy = getInfo3[0];

			var file_msni = $("#file_msni")[0].files[0];
			var validaFile = (file_msni == undefined) ? 0 : 1;
			var dataFile = new FormData();

			dataFile.append("idResidencial", idproy);
			dataFile.append("file_msni", file_msni);

			if (validaFile == 0) {
				alerts.showNotification('top', 'right', 'Debes seleccionar un archivo', 'danger');
			}

			if (validaFile == 1) {
				$('#sendFile').prop('disabled', true);
				$.ajax({
					url: "<?=base_url()?>index.php/Contraloria/update_msni",
					data: dataFile,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					success : function (response) {
						response = JSON.parse(response);
						if(response.message == 'OK') {
							alerts.showNotification('top', 'right', '¡Información registrada!', 'success');
							$('#sendFile').prop('disabled', false);
							$('#addFile').modal('hide');
							$("#filtro3").selectpicker('refresh');
							$('#tabla_msni').DataTable().ajax.reload();
						} else if(response.message == 'FALSE'){
							alerts.showNotification('top', 'right', '¡Error al enviar la solicitud!', 'danger');
							$('#sendFile').prop('disabled', false);
							$('#addFile').modal('hide');
							$("#filtro3").selectpicker('refresh');
							$('#tabla_msni').DataTable().ajax.reload();
						}
					}
				});
			}
		});



	jQuery(document).ready(function(){
		jQuery('#addFile').on('hidden.bs.modal', function (e) {
			jQuery(this).removeData('bs.modal');
			jQuery(this).find('#file_msni').val('');
			jQuery(this).find('#txtexp').val('');
		})
	})
	</script>
</body>