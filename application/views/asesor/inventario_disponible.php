<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
	<div class="wrapper">
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
		<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">Venta de particulares <b id="nomLoteHistorial"></b></h4>
					</div>

					<div class="modal-body">
						<div role="tabpanel">
							<ul class="nav nav-tabs" role="tablist" style="background: #003d82;">
								<li role="presentation" class="active" id="li_individual_sales"><a href="#salesOfIndividuals" aria-controls="salesOfIndividuals" role="tab" data-toggle="tab">Cláusulas</a></li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="salesOfIndividuals">
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
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR</button>
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
								<div class="encabezadoBox">
									<h3 class="card-title center-align">Inventario disponible</h3>
									<p class="card-title pl-1"></p>
								</div>
								<div class="toolbar">
									<div class="row">
										<form id="formFilters">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Proyecto</label>
													<select name="filtro3" id="filtro3" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona un proyecto" data-size="7" required>
														<option value="0">-SELECCIONA TODO-</option>
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Condominio</label>
													<select id="filtro4" name="filtro4[]" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" multiple title="Selecciona un condominio" data-size="7" required>
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Grupo</label>
													<select name="filtro5" id="filtro5" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona grupo" data-size="7" required>
														<option disabled selected>-SELECCIONA GRUPO-</option>
														<option value="1"> < 200m2 </option>
														<option value="2"> >= 200 y < 300 </option>
														<option value="3"> >= 300m2 </option>
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Superficie</label>
														<select  class="selectpicker select-gral m-0" id="filtro6" name="filtro6[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" title="Selecciona superficie" data-size="7" required multiple/></select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Precio m<sup>2</sup></label>
													<select  class="selectpicker select-gral m-0" id="filtro7" name="filtro7[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" title="Precio metro cuadrado" data-size="7" required multiple/></select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Precio total</label>
													<select  class="selectpicker select-gral m-0" id="filtro8" name="filtro8[]" data-style="btn btn-primary " data-show-subtext="true" data-live-search="true" title="Precio total" data-size="7" required multiple/></select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
												<div class="form-group label-floating select-is-empty">
													<label class="control-label">Meses S/N</label>
													<select  class="selectpicker select-gral m-0" id="filtro9" name="filtro9[]"
															data-style="btn btn-primary " data-show-subtext="true"
															data-live-search="true" title="Meses sin intereses"
															data-size="7" required multiple/></select>
												</div>
											</div>
											<button class="btn btn-body" type="submit"style="display:none;"></button>
										</form>
									</div>
								</div>
								<div class="table-responsive pdt-30">
									<table id="addExp" class="table-striped table-hover">
										<thead>
											<tr>
												<th>PROYECTO</th>
												<th>CONDOMINIO</th>
												<th>LOTE</th>
												<th>SUP</th>
												<th>PRECIO M<sup>2</sup></th>
												<th>PRECIO TOTAL</th>
												<th>MESES MSI</th>
												<th>TIPO VENTA</th>
												<th>ACCIONES</th>
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

		<div class="content hide">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<center>
							<h3>INVENTARIO DISPONIBLE</h3>
						</center>
						<hr>
						<br>
					</div>
				</div>
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<style>
							.fileUpload {
								position: relative;
								overflow: hidden;
								margin: 10px;
							}
							.fileUpload input.upload {
								position: absolute;
								top: 0;
								right: 0;
								margin: 0;
								padding: 0;
								font-size: 20px;
								cursor: pointer;
								opacity: 0;
								filter: alpha(opacity=0);
							}
						</style>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" >
							<form id="formFilters">
								<div class="card">
									<div class="container-fluid" style="padding:20px">
									</div>
								</div>
								<button class="btn btn-body" type="submit"style="display:none;"></button>
							</form>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="card">
								<div class="container-fluid">
									<div class="form-group">
										<div class="table-responsive">
											<table id="addExp" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>SUP</th>
														<th>PRECIO M<sup>2</sup></th>
														<th>PRECIO TOTAL</th>
														<th>MESES MSI</th>
														<th>TIPO VENTA</th>
														<th>ACCIONES</th>
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
	<!--script of the page-->
	<script>
		// $('.select2').select2();
		$(document).ready(function() {
			var url = "<?=base_url()?>/index.php/";
			$.post("<?=base_url()?>index.php/Contratacion/lista_proyecto", function (data) {
				var len = data.length;
				for (var i = 0; i < len; i++) {
					var id = data[i]['idResidencial'];
					var name = data[i]['descripcion'];
					$("#filtro3").append($('<option>').val(id).text(name.toUpperCase()));
				}
				$("#filtro3").selectpicker('refresh');
			}, 'json');
		});
		var residencial;
		var grupo;
		var clusterSelect;
		var clusterSelect2;

		var supSelect;
		var supSelect2;

		var preciomSelect;
		var preciomSelect2;

		var totalSelect;
		var totalSelect2;

		var mesesSelect;
		var mesesSelect2;
		$('#filtro3').change(function(ruta){
			console.log($('#filtro3').val());
			residencial = $('#filtro3').val();
			grupo = $('#filtro5').val();


			if(residencial == 0){
				ruta = "<?= site_url('Asesor/getLotesInventarioGralTodosc') ?>";
				$("#filtro4").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getCondominioDescTodos/',
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

				$("#filtro6").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getSupOneTodos/',
					type: 'post',
					dataType: 'json',
					success:function(response){
						console.log(response);
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['sup'];
							var name = response[i]['sup'];
							$("#filtro6").append($('<option>').val(id).text(name+" m2"));
						}
						$("#filtro6").selectpicker('refresh');

					}
				});
				$("#filtro7").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getPrecioTodos/',
					type: 'post',
					dataType: 'json',
					success:function(response){
						console.log(response);
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['precio'];
							var name = response[i]['precio'];
							$("#filtro7").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
						}
						$("#filtro7").selectpicker('refresh');

					}
				});
				$("#filtro8").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getTotalTodos/',
					type: 'post',
					dataType: 'json',
					success:function(response){
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['total'];
							var name = response[i]['total'];
							$("#filtro8").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
						}
						$("#filtro8").selectpicker('refresh');

					}
				});
				$("#filtro9").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getMesesTodos/',
					type: 'post',
					dataType: 'json',
					success:function(response){
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['msni'];
							var name = response[i]['msni'];
							$("#filtro9").append($('<option>').val(id).text(name + " MSI"));
						}
						$("#filtro9").selectpicker('refresh');

					}
				});
			} else if (residencial > 0){
				$("#filtro4").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getCondominioDesc/'+residencial,
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
				$("#filtro6").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getSupOne/'+residencial,
					type: 'post',
					dataType: 'json',
					success:function(response){
						console.log(response);
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['sup'];
							var name = response[i]['sup'];
							$("#filtro6").append($('<option>').val(id).text(name+" m2"));
						}
						$("#filtro6").selectpicker('refresh');

					}
				});
				$("#filtro7").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getPrecio/'+residencial,
					type: 'post',
					dataType: 'json',
					success:function(response){
						console.log(response);
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['precio'];
							var name = response[i]['precio'];
							$("#filtro7").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
						}
						$("#filtro7").selectpicker('refresh');

					}
				});
				$("#filtro8").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getTotal/'+residencial,
					type: 'post',
					dataType: 'json',
					success:function(response){
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['total'];
							var name = response[i]['total'];
							$("#filtro8").append($('<option>').val(id).text("$ "+ alerts.number_format(name, '2', '.', ',')));
						}
						$("#filtro8").selectpicker('refresh');

					}
				});
				$("#filtro9").empty().selectpicker('refresh');
				$.ajax({
					url: '<?=base_url()?>Asesor/getMeses/'+residencial,
					type: 'post',
					dataType: 'json',
					success:function(response){
						var len = response.length;
						for( var i = 0; i<len; i++)
						{
							var id = response[i]['msni'];
							var name = response[i]['msni'];
							$("#filtro9").append($('<option>').val(id).text(name + " MSI"));
						}
						$("#filtro9").selectpicker('refresh');

					}
				});

			}

		});


		$('.selectpicker').on('change', function(event){
			var form = $(this).closest('form');
			form.submit();
		});

		$('#formFilters').on('submit', function(event){
			event.preventDefault();
			var data = $('#formFilters').serializeArray();
			$.ajax({
				url: '<?=base_url()?>Asesor/get_info_tabla/',
				type: 'post',
				dataType: 'json',
				data: data,
				beforeSend:function(){
					$('#spiner-loader').removeClass('hide');
					console.log('cargando...');
				},
				success:function(response){
					dataTable(response);
					$('#spiner-loader').addClass('hide');
					console.log('cargado!');
				}
			})
		});


		function dataTable(ruta) {
			var table = $('#addExp').DataTable({
				dom: "<'row'<'col-xs-6 col-sm-6 col-md-6 col-lg-6'B><'col-xs-6 col-sm-6 col-md-6 col-lg-6 p-0'f>rt><'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: 'auto',
				language: {
					url: "<?=base_url()?>/static/spanishLoader_v2.json",
					paginate: {
						previous: "<i class='fa fa-angle-left'>",
						next: "<i class='fa fa-angle-right'>"
					}
				},
				buttons: [
					{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
						className: 'btn buttons-excel',
						titleAttr: 'Descargar archivo de Excel',
						title: 'Reporte Inventario',
						exportOptions: {
							columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
						},
					} ,
					{
						extend: 'pdfHtml5',
						text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
						className: 'btn buttons-pdf',
						titleAttr: 'PDF',
						orientation: 'landscape',
						pageSize: 'LEGAL',
						exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
						}
					}
				],
				destroy: true,
				columnDefs: [{
					defaultContent: "",
					targets: "_all",
					searchable: true,
				}],
				columns: [
					{ data: 'nombreResidencial' },
					{ data: 'nombreCondominio' },
					{ data: 'nombreLote' },
					{ data: 'sup' },
					{ data: function(data){return "$ " + alerts.number_format(data.precio, '2', '.', ',')} },
					{ data: function(data){return "$ " + alerts.number_format(data.total, '2', '.', ',')} },
					{ data: 'mesesn' },
					{ data: function(data){ if(data.tipo_venta == 1) { return "<small class='label bg-green' style='background-color: #00a65a'>VENTA DE PARTICULARES</small>" } else { return "<small class='label bg-green' style='background-color: #566573'>VENTA NORMAL</small>" } } },
					{ data: 
						function(data){ 
							if(data.tipo_venta == 1) { 
								return '<center><button class="btn-data btn-details-grey ver_historial" value="' + data.idLote +'" data-nomLote="'+data.nombreLote+'" data-tipo-venta="'+data.tipo_venta+'"><i class="fas fa-info"></i></button></center>';
							} else { 
								return "" 
							} 
						} 
					}
				],
				"data": ruta
			});
		}

		$(document).on("click", ".ver_historial", function(){
			idLote = $(this).val();
			$.getJSON('<?=base_url()?>Contratacion/getClauses/'+idLote).done( function( data ){
				$('#clauses_content').html(data[0]['nombre']);
			});	
			$("#seeInformationModal").modal();
		});

	</script>
</body>