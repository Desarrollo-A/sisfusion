<body class="">
<div class="wrapper ">
	<?php
	if($this->session->userdata('id_rol') == "16")
		//CONTRATACION
	{
		$dato = array(
			'home' => 0,
			'listaCliente' => 0,
			'contrato' => 0,
			'documentacion' => 0,
			'corrida' => 0,
			'inventario' => 0,
			'inventarioDisponible' => 1,
			'status8' => 0,
			'status14' => 0,
			'lotesContratados' => 0,
			'ultimoStatus' => 0,
			'lotes45dias' => 0,
			'consulta9Status' => 0,
			'consulta12Status' => 0,
			'gerentesAsistentes' => 0,
			'expedientesIngresados'	=>	0,
			'corridasElaboradas'	=>	0
		);
		//$this->load->view('template/contratacion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else if($this->session->userdata('id_rol') == "6")
		//ASISTENTE GERENTE
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'corridaF' => 0,
			'documentacion' => 0,
			'autorizacion' => 0,
			'contrato' => 0,
			'inventario' => 0,
			'estatus8' => 0,
			'estatus14' => 0,
			'estatus7' => 0,
			'reportes' => 0,
			'estatus9' => 0,
			'disponibles' => 1,
			'asesores' => 0,
			'nuevasComisiones' => 0,
			'histComisiones' => 0,
			'prospectos' => 0,
			'prospectosAlta' => 0

		);
		//$this->load->view('template/ventas/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else
	{
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
	}
	?>
	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<!--<h3>Registros de Terrenos</h3>-->
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
						<div class="container-fluid" style="padding: 50px 10px;">
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<h4 class="card-title" style="text-align: center">Registros de Terrenos</h4><br><br>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<label>Proyecto:</label><br>
									<select name="filtro3" id="filtro3" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn " title="Selecciona Proyecto" data-size="7" required>
										<?php
										if($residencial != NULL) :
											foreach($residencial as $fila) : ?>
												<option value= <?=$fila['idResidencial']?> > <?=$fila['nombreResidencial']?> </option>
											<?php endforeach;
										endif;
										?>
										<option value= "InventarioCompleto"> Inventario Completo </option>
									</select>
								</div>
								<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<label>Condominio:</label><br>
									<select id="filtro4" name="filtro4" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Condominio" data-size="7"></select>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">

						<div class="card-content" style="padding: 50px 20px;">
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">
								<div class="form-group">
									<div class="table-responsive">
										<table id="tableTerrenos" class="table table-bordered table-hover" style="text-align:center;">
											<thead>
											<tr>
												<th><center>Proyecto</center></th>
												<th><center>Condominio</center></th>
												<th><center>Lote</center></th>
												<th><center>Superficie</center></th>
												<th><center>Total</center></th>
												<th><center>Enganche</center></th>
												<th><center>A Financiar</center></th>
												<th><center>Meses S/I</center></th>
											</tr>
											</thead>
											<tbody>
											</tbody>
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
<script>
	$('#filtro3').change(function(){
		var entra = 0;
		var residencial = $('#filtro3').val();
		var valorSeleccionado = $('#filtro4').val();

		var table = $('#tableTerrenos').DataTable();

		table
			.clear()
			.draw();

		if(residencial == 'InventarioCompleto')
		{
			var ruta = "<?= site_url('registroLote/getLotesDventasAll') ?>";
			$("#filtro4").html( "" ).append( "" );
			entra = 1;
		}
		else
		{
			entra = 0;
			$("#filtro4").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>registroLote/getCondominio/'+residencial,
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
			//$('#filtro4').load("<?//= site_url('registroLote/getCondominio') ?>///"+residencial);
		}

		if(entra == 1)
		{
			var table = $('#tableTerrenos').DataTable({
				dom: 'Bfrtip',
				buttons: [
					{
						extend:    'copyHtml5',
						text:      '<i class="fa fa-files-o"></i>',
						titleAttr: 'Copy'
					},
					{
						extend:    'excelHtml5',
						text:      '<i class="fa fa-file-excel-o"></i>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<i class="fa fa-file-text-o"></i>',
						titleAttr: 'CSV'
					},
					{
						extend:    'pdfHtml5',
						text:      '<i class="fa fa-file-pdf-o"></i>',
						titleAttr: 'PDF'
					}
				],


				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				},
				destroy: true,
				columns: [
					{ data: 'nombreResidencial' },
					{ data: 'nombreCondominio' },
					{ data: 'nombreLote' },
					{ data: 'sup' },
					{
						// data: 'total'
						data: function(d)
						{
							return "$"+alerts.number_format(d.total, 2, ".", ",")
						}
					},
					{
						// data: 'enganche'
						data: function(d)
						{
							return "$"+alerts.number_format(d.enganche,2, ".", ",");
						}
					},
					{
						// data: 'saldo'
						data: function(d)
						{
							return "$"+alerts.number_format(d.saldo, 2, ".", ",");
						}
					},
					{ data: 'msni' },
				],
				"ajax": {
					"url": ruta,
					"type": "POST",
					"dataSrc": "",
					cache: false,
					"data": function( d ){
						d.proyecto = $('#empresa').val();
						d.idproyecto = $('#proyecto').val();
					}
				},
			});
		}
	});

	$('#filtro4').change(function()
	{
		var residencial = $('#filtro3').val();
		var valorSeleccionado = $('#filtro4').val();
		var ruta;
		var table = $('#exmaple').DataTable();

		ruta = "<?= site_url('registroLote/getLotesDventas') ?>/"+valorSeleccionado+'/'+residencial;

		var table = $('#tableTerrenos').DataTable({

			dom: 'Bfrtip',
			buttons: [
				{
					extend:    'copyHtml5',
					text:      '<i class="fa fa-files-o"></i>',
					titleAttr: 'Copy'
				},
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'csvHtml5',
					text:      '<i class="fa fa-file-text-o"></i>',
					titleAttr: 'CSV'
				},
				{
					extend:    'pdfHtml5',
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF'
				}
			],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
			},
			destroy: true,
			columns: [
				{ data: 'nombreResidencial' },
				{ data: 'nombreCondominio' },
				{ data: 'nombreLote' },
				{ data: 'sup' },
				{
					// data: 'total'
					data: function(d)
					{
						return "$"+alerts.number_format(d.total, 2, ".", ",")
					}
				},
				{
					// data: 'enganche'
					data: function(d)
					{
						return "$"+alerts.number_format(d.enganche,2, ".", ",");
					}
				},
				{
					// data: 'saldo'
					data: function(d)
					{
						return "$"+alerts.number_format(d.saldo, 2, ".", ",");
					}
				},
				{ data: 'msni' },
			],
			"ajax": {
				"url": ruta,
				"dataSrc": "",
				"type": "POST",
				cache: false,
				"data": function( d ){
					d.proyecto = $('#empresa').val();
					d.idproyecto = $('#proyecto').val();
				}
			},
		});
	});

</script>
