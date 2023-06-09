<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<!-- Modals -->
		<div class="modal fade" id="change_u" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content" >
						<div class="modal-header">
							<center><h4 class="modal-title"><label>Cambio de lugar de prospección</label></h4></center>
						</div>
						<div class="modal-body">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label id="tvLbl">Lugar</label>
									<select id="lp" name="lp" class="form-control selectpicker" data-live-search="true" required data-size="7">
										<option disabled selected value="0"> SELECCIONA UN LUGAR</option>
										<option value="0" id="sm" disabled selected>Seleccione una opción</option>
										<option value="01 800">01 800</option>
										<option value="Chat">Chat</option>
										<option value="Contacto web">Contacto web</option>
										<option value="Facebook">Facebook</option>
										<option value="Instagram">Instagram</option>
										<option value="Recomendado">Recomendado</option>
										<option value="WhatsApp">WhatsApp</option>
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer"></div>
						<div class="modal-footer">
							<button type="button" id="btn_change_lp" class="btn btn-success"><span class="material-icons" >send</span> </i> Guardar</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
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
								<i class="fas fa-address-book fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
                                    <h3 class="card-title center-align" >Listado de prospectos</h3>
                                    <p class="card-title pl-1">(Cambio de LP)</p>
                                </div>
								<div class="toolbar">
									<div class="container-fluid p-0">
										<div class="row">
											<div class="col-12 col-sm-6 col-md-6 col-lg-6">
												<label class="m-0" for="sede">Sede</label>
												<select name="sede" id="sede" class="selectpicker select-gral" data-live-search="true"
														data-style="btn " title="SEDE" data-size="7">
												</select>
											</div>
											<div class="col-12 col-sm-6 col-md-6 col-lg-6">
												<label class="m-0" for="asesor">Asesor</label>
												<select name="asesor" id="asesor" class="selectpicker select-gral" data-live-search="true"
														data-style="btn" title="ASESOR" data-size="7">
												</select>
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
														<th>ESTADO</th>
														<th>ETAPA</th>
														<th>PROSPECTO</th>
														<th>ASESOR</th>
														<th>COORDINADOR</th>
														<th>GERENTE</th>
														<th>LP</th>
														<th>DETALLE</th>
														<th>CREACIÓN</th>
														<th>VENCIMIENTO</th>
														<th>ACCIÓN</th>
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
	<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
	<script>
		userType = <?= $this->session->userdata('id_rol') ?> ;

		$('#prospects-datatable_dir thead tr:eq(0) th').each( function (i) {
			var title = $(this).text();
			if(i != 10 ){
				$(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
				$( 'input', this ).on('keyup change', function () {
					if ($('#prospects-datatable_dir').DataTable().column(i).search() !== this.value ) {
						$('#prospects-datatable_dir').DataTable().column(i).search(this.value).draw();
					}
				});
			}
		});
	</script>

	<script>
		$(document).ready(function () {
			$.post('<?=base_url()?>index.php/Clientes/getSedes/', function(data) {
				var len = data.length;
				for( var i = 0; i<len; i++){
					var id = data[i]['id_sede'];
					var name = data[i]['nombre'];
					$("#sede").append($('<option>').val(id).text(name));
				}
				if(len<=0){
					$("#sede").append('<option selected="selected" disabled>SELECCIONA UNA SEDE</option>');
				}
				$("#sede").selectpicker('refresh');
			}, 'json');
		});

		$('#sede').on('change', function () {
			var sede = $("#sede").val();
			$("#asesor").empty().selectpicker('refresh');
			$.post('<?=base_url()?>index.php/Clientes/getAdvisers/'+sede, function(data) {
				var len = data.length;
				for( var i = 0; i<len; i++){
					var id = data[i]['id_usuario'];
					var name = data[i]['nombre'];
					$("#asesor").append($('<option>').val(id).text(name));
				}
				if(len<=0){
					$("#asesor").append('<option selected="selected" disabled>NINGUN ASESOR</option>');
				}
				$("#asesor").selectpicker('refresh');
			}, 'json');
		});

		$('#asesor').on('change', function () {				
			var asesor = $("#asesor").val();
			var url = "<?=base_url()?>index.php/Clientes/getProspectsListByAsesor/"+asesor;
			updateTable(url);
		});

		function updateTable(url){
			var prospectsTable = $('#prospects-datatable_dir').dataTable({
				dom: 'rt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
				destroy: true,
				columns: [{ 
					data: function (d) {
						if (d.estatus == 1) {
							return '<center><span class="label label-danger" style="background:#27AE60">Vigente</span><center>';
						} else {
							return '<center><span class="label label-danger" style="background:#E74C3C">Sin vigencia</span><center>';
						}
					}
				},
				{ 
					data: function (d) {
						let b='';
						if(d.estatus_particular == 1) { // DESCARTADO
							b = '<center><span class="label" style="background:#E74C3C">Descartado</span><center>';
						} else if(d.estatus_particular == 2) { // INTERESADO SIN CITA
							b = '<center><span class="label" style="background:#B7950B">Interesado sin cita</span><center>';
						} else if (d.estatus_particular == 3){ // CON CITA
							b = '<center><span class="label" style="background:#27AE60">Con cita</span><center>';
						} else if (d.estatus_particular == 4){ // SIN ESPECIFICAR
							b = '<center><span class="label" style="background:#5D6D7E">Sin especificar</span><center>';
						} else if (d.estatus_particular == 5){ // PAUSADO
							b = '<center><span class="label" style="background:#2E86C1">Pausado</span><center>';
						} else if (d.estatus_particular == 6){ // PREVENTA
							b = '<center><span class="label" style="background:#8A1350">Preventa</span><center>';
						}
						return b;
					}
				},
				{ 
					data: function (d) {
						return d.nombre;
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
						return d.nombre_lp;
					}
				},
				{ 
					data: function (d) {
						return d.otro_lugar;
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
				},
				{
					"orderable": false,
					data: function( data ){
						return '<button title= "Cambio de lp" data-pros="'+data.id_prospecto+'" class="btn-data btn-gray change_lp"><i class="fas fa-map-marker-alt"></i></button>';
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
					"url": url,
					"type": "POST",
					cache: false,
					"data": function( d ){
					}
				}
			})
		}

		var id_pros = 0;
		$("#prospects-datatable_dir tbody").on("click", ".change_lp", function(e){
			e.preventDefault();
			id_pros = $(this).attr("data-pros");
			$('#change_u').modal('show');
		});

		$(document).on('click', '#btn_change_lp', function(e){
			e.preventDefault();
			var lugar = $('#lp').val();
			$('#btn_change_lp').prop('disabled', true);
			$.ajax({
				url : '<?=base_url()?>index.php/Clientes/change_lp/',
				data: {id: id_pros, lugar_p: lugar},
				dataType: 'json',
				type: 'POST', 
				success: function(data){
					alerts.showNotification("top", "right", "Solicitud enviada.", "success");
					$('#prospects-datatable_dir').DataTable().ajax.reload();
					$('#change_u').modal('hide');
					$('#btn_change_lp').prop('disabled', false);
				},
				error: function( data ){
					alerts.showNotification("top", "right", "Error al enviar la solicitud.", "danger");
					$('#btn_change_lp').prop('disabled', false);
				}
			});
		})

		jQuery(document).ready(function(){
			jQuery('#change_u').on('hidden.bs.modal', function (e){
			jQuery(this).removeData('bs.modal');
			jQuery(this).find('#lp').val(null).trigger('change');
			})
		})
	</script>
</body>