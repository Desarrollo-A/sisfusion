<body class="">
<div class="wrapper ">
	<?php $this->load->view('template/sidebar'); ?>

	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
					</center>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content" style="padding: 50px 0px;">
							<h4 class="card-title" style="text-align: center">Contrato</h4>
							<div class="container-fluid" >
								<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<label>Proyecto:</label><br>
										<select name="filtro3" id="filtro3" class="selectpicker" data-style="btn" data-show-subtext="true" data-live-search="true"  title="Selecciona Proyecto" data-size="7" required>
											<?php
											if($residencial != NULL) :
												foreach($residencial as $fila) : ?>
													<option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
												<?php endforeach;
											endif;
											?>
										</select>
									</div>
									<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<label>Condominio:</label><br>
										<select id="filtro4" name="filtro4" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Condominio" data-size="7"></select>
									</div>
									<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
										<label>Lote:</label><br>
										<select id="filtro5" name="filtro5" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Lote" data-size="7"></select>
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon hide" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content" style="padding: 50px 20px;">
							<h3 class="card-title hide" style="text-align: center">Contrato</h3>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">
								<div class="form-group">
									<div class="table-responsive">
										<table id="tableDoct" class="table table-bordered table-hover" width="100%"
											   style="text-align:center;">
											<thead>
											<tr>
												<th class="text-center">Lote</th>
												<th class="text-center">Proyecto</th>
												<th class="text-center">Condominio</th>
												<th class="text-center">Cliente</th>
												<th class="text-center">Nombre de Contrato</th>
												<th class="text-center">Contrato</th>
											</tr>
											</thead>

										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- modal -->
					<div class="modal fade" id="fileViewer">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<!-- Modal body -->
								<div class="modal-body">
									<a style="position: absolute;top:3%;right:3%; cursor:pointer;" data-dismiss="modal">
										<span class="material-icons">
											close
										</span>
									</a>
									<div id="cnt-file">
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
</div>

</div>
</body>
<?php $this->load->view('template/footer');?>
<script>
	$(document).ready (function() {
		$('#filtro3').change(function(){
			var valorSeleccionado = $(this).val();
			// console.log(valorSeleccionado);
			//build select condominios
			$("#filtro4").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>registroCliente/getCondominio/'+valorSeleccionado,
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
			// console.log(valorSeleccionado);
			//$('#filtro5').load("<?//= site_url('registroCliente/getLotesAll') ?>///"+valorSeleccionado+'/'+residencial);
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

			var valorSeleccionado = $(this).val();
			$('#cnt-file').html('');
			console.log(valorSeleccionado);
			$('#tableDoct').DataTable({
				destroy: true,
				"ajax":
					{
						"url": '<?=base_url()?>index.php/registroCliente/getContrato/'+valorSeleccionado,
						"dataSrc": ""
					},
				"dom": "Bfrtip",
				"buttons": [
					{
						extend: 'copyHtml5',
						text: '<i class="fa fa-files-o"></i>',
						titleAttr: 'Copy'
					},
					{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel-o"></i>',
						titleAttr: 'Excel'
					},
					{
						extend: 'csvHtml5',
						text: '<i class="fa fa-file-text-o"></i>',
						titleAttr: 'CSV'
					},
					{
						extend: 'pdfHtml5',
						text: '<i class="fa fa-file-pdf-o"></i>',
						titleAttr: 'PDF',
						orientation: 'landscape',
						pageSize: 'LEGAL'
					}
				],
				"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
				"columns":
					[
						{data: 'nombreLote'},
						{data: 'nombreResidencial'},
						{data: 'nombre'},
						{
							data: null,
							render: function(data, type, row)
							{
								return data.nombre_cliente + " " + data.apellido_paterno + " " + data.apellido_materno;
							}
						},
						{data: 'contratoArchivo'},
						{
							data: null,
							render: function(data, type, row)
							{
								$('#cnt-file').html('<h3 style="font-weight:100">Visualizando <b>'+data.contratoArchivo+'</b></h3><embed src="<?=base_url()?>static/documentos/cliente/contrato/'+data.contratoArchivo+'" frameborder="0" width="100%" height="500" style="height: 60vh;"></embed >');
								var myLinkConst = '<a type="button" data-toggle="modal" data-target="#fileViewer"><span class="material-icons" style="cursor: pointer">attach_file</span></a>'
								return myLinkConst;
								//var myLinkConst = '<a href="<?//=base_url()?>//static/documentos/cliente/contrato/'+data.contratoArchivo+'">' +
								//	'<span class="material-icons">attach_file</span><src="<?//=base_url()?>//static/documentos/cliente/contrato/'+data.contrato+'"></a>';
								//return myLinkConst;
							}
						},
					]
			});
		});
	});
</script>
