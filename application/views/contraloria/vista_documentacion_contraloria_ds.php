
<body class="">
<div class="wrapper ">
	<?php
	//se debe validar que tipo de perfil esta sesionado para poder asignarle el tipo de sidebar
	if($this->session->userdata('id_rol')=="16")//contratacion
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'contrato' => 0,
			'documentacion' => 0,
            'documentacion_ds' => 1,
			'corrida' => 0,
			'inventario' => 0,
			'inventarioDisponible' => 0,
			'status8' => 0,
			'status14' => 0,
			'lotesContratados' => 0,
			'ultimoStatus' => 0,
			'lotes45dias' => 0,
			'consulta9Status' => 0,
			'consulta12Status' => 0,
			'DS' => 0,
			'DSConsult' => 0,
			'autoriza' => 0,
			'inventarioDisponible' => 0,
			'gerentesAsistentes' => 0,
			'expedientesIngresados'	=>	0,
			'asignarVentas' => 0,
			'corridasElaboradas'	=>	0,
			'clientsList' => 0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0
		);
		//$this->load->view('template/contratacion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else if($this->session->userdata('id_rol')=="6" || $this->session->userdata('id_rol')=="33" || $this->session->userdata('id_rol')=="4" || $this->session->userdata('id_rol')=="9")//ventasAsistentes
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'corridaF' => 0,
			'documentacion' => 0,
            'documentacion_ds' => 0,
			'autorizacion' => 0,
			'contrato' => 0,
			'inventario' => 0,
			'estatus8' => 0,
			'estatus14' => 0,
			'estatus7' => 0,
			'reportes' => 0,
			'DS' => 0,
			'DSConsult' => 0,
			'autoriza' => 0,
			'inventarioDisponible' => 0,
			'prospectosMktd' => 0,
			'bulkload' => 0,
			'clientsList' => 0,
			'manual' => 0,
			'aparta' => 0,
			'aparta' => 0,
			'aparta' => 0,
			'asignarVentas' => 0,
			'estatus9' => 0,
			'disponibles' => 0,
			'asesores' => 0,
			'nuevasComisiones' => 0,
			'histComisiones' => 0,
			'prospectos' => 0,
			'prospectosAlta' => 0,
         	'consDepositoSeriedad' => 1,
         	'altaUsuarios' => 0,
         	'listaUsuarios' => 0



		);
		//$this->load->view('template/ventas/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="11")//administracion
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 0,
            'documentacion_ds' => 1,
            'asignarVentas' => 0,
			'inventario' => 0,
			'clientsList' => 0,
			'status11' => 0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0
		);
		//$this->load->view('template/administracion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="15")//juridico
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 0,
            'documentacion_ds' => 1,
			'contrato' => 0,
			'inventario' => 0,
			'asignarVentas' => 0,
			'clientsList' => 0,
			'DS' => 0,
			'DSConsult' => 0,
			'autoriza' => 0,
			'inventarioDisponible' => 0,
			'status3' => 0,
			'status7' => 0,
			'lotesContratados' => 0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0
		);
		//$this->load->view('template/juridico/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="32")//contraloria
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'expediente' => 0,
			'corrida' => 0,
			'documentacion' => 0,
            'documentacion_ds' => 1,
			'historialpagos' => 0,
			'inventario' => 0,
			'estatus20' => 0,
			'estatus2' => 0,
			'estatus5' => 0,
			'clientsList' => 0,
			'estatus6' => 0,
			'asignarVentas' => 0,
			'estatus9' => 0,
			'estatus10' => 0,
			'estatus13' => 0,
			'DS' => 0,
			'DSConsult' => 0,
			'autoriza' => 0,
			'inventarioDisponible' => 0,
			'estatus15' => 0,
			'enviosRL' => 0,
			'estatus12' => 0,
			'acuserecibidos' => 0,
			'comnuevas' => 0,
			'comhistorial' => 0,
			'tablaPorcentajes' => 0,
			'nuevasComisiones'	=>	0,
			'histComisiones'	=>	0,
			'integracionExpediente' => 0,
			'expRevisados' => 0,
			'estatus10Report' => 0,
			'rechazoJuridico' => 0
		);
		if($this->session->userdata("id_usuario") == 2752 || $this->session->userdata('id_usuario') == 2826)
		{
			$dato['DSContraloriaSU'] = 0;
		}
		//$this->load->view('template/contraloria/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="7")//asesor
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'corridaF' => 0,
			'inventario' => 0,
			'prospectos' => 0,
			'prospectosAlta' => 0,
			'statistic' => 0,
			'comisiones' => 0,
			'DS'    => 0,
			'DSConsult' => 0,
			'documentacion' => 0,
			'clientsList' => 0,
            'documentacion_ds' => 1,
            'consDepositoSeriedad' => 0,
			'inventarioDisponible'  =>  0,
			'manual'    =>  0,
			'nuevasComisiones'     => 0,
			'histComisiones'       => 0,
			'sharedSales' => 0,
			'coOwners' => 0,
			'asignarVentas' => 0,
			'DS' => 0,
			'DSConsult' => 0,
			'autoriza' => 0,
			'inventarioDisponible' => 0,
			'references' => 0,
			'autoriza'	=>	0
		);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="12")//caja
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 0,
            'documentacion_ds' => 1,
			'cambiarAsesor' => 0,
			'historialPagos' => 0,
			'pagosCancelados' => 0,
			'asignarVentas' => 0,
			'altaCluster' => 0,
			'DS' => 0,
			'DSConsult' => 0,
			'autoriza' => 0,
			'inventarioDisponible' => 0,
			'clientsList' => 0,
			'altaLote' => 0,
			'inventario' => 0,
			'actualizaPrecio' => 0,
			'actualizaReferencia' => 0,
			'liberacion' => 0
		);
		//$this->load->view('template/contraloria/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else
	{
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
	}
	?>

	<script>

        userType = <?= $this->session->userdata('id_rol') ?> ;

    </script>

	<!--Contenido de la página-->
	<div class="content">
		<div class="container-fluid">
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
							<button type="button" id="aceptoDelete" class="btn btn-primary"> Si, borrar </button>
							<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> Cancelar </button>
						</div>
					</div>
				</div>
			</div>
			<!--termina el modal de cuestion-->
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<!--						<h3>DOCUMENTACIÓN</h3>-->
					</center>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content">
							<h4 class="card-title" style="text-align: center">Depósitos de seriedad (consulta)</h4>
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
									<label>Proyecto:</label><br>
									<select name="filtro3" id="filtro3" class="selectpicker" data-show-subtext="true" data-live-search="true"  data-style="btn" title="Selecciona Proyecto" data-size="7" required>
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
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<!--						<div class="card-header card-header-icon" data-background-color="goldMaderas">-->
						<!--							<i class="material-icons">reorder</i>-->
						<!--						</div>-->
						<div class="card-content" style="padding: 50px 20px;">
							<h4 class="card-title"></h4>
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
												<th class="text-center">Proyecto</th>
												<th class="text-center">Condominio</th>
												<th class="text-center">Lote</th>
												<th class="text-center">Cliente</th>
												<th class="text-center">Nombre de Documento</th>
												<th class="text-center">Hora/Fecha</th>
												<th class="text-center">Documento</th>
												<th class="text-center">Responsable</th>
												<th class="text-center">Ubicación</th>
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

			// console.log(valorSeleccionado);
			//build select condominios
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
			// console.log(valorSeleccionado);
			//$('#filtro5').load("<?//= site_url('registroCliente/getLotesAll') ?>///"+valorSeleccionado+'/'+residencial);
			$("#filtro5").empty().selectpicker('refresh');
			$.ajax({
				url: '<?=base_url()?>registroCliente/getLotesAll_DS/'+valorSeleccionado,
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
				destroy: true,
				lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
				"ajax":
					{
						"url": '<?=base_url()?>index.php/registroCliente/expedientesWS_DS/'+valorSeleccionado,
						"dataSrc": ""
					},
				"dom": "Bfrtip",
                "ordering": false,
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

						{data: 'nombreResidencial'},
						{data: 'nombre'},
						{data: 'nombreLote'},
						{
							data: null,
							render: function ( data, type, row )
							{
								return data.nomCliente +' ' +data.apellido_paterno+' '+data.apellido_materno;
							},
						},
						{data: 'movimiento'},
						{data: 'modificado'},
						{
							data: null,
							render: function ( data, type, row )
							{
                                file = '<a class="btn btn-primary btn-round btn-fab btn-fab-mini pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad versión anterior"><i class="material-icons">file_copy</i></a>';
								return file;
							}
						},
						{
							data: null,
							render: function ( data, type, row )
							{
								return myFunctions.validateEmptyFieldDocs(data.primerNom) +' '+myFunctions.validateEmptyFieldDocs(data.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(data.apellidoMa);

							},
						},
						{data: 'ubic'},
					]
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

	$(document).on('click', '.pdfLink2', function () {
		var $itself = $(this);
		Shadowbox.open({
			content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>asesor/deposito_seriedad_ds/'+$itself.attr('data-idc')+'/0/"></iframe></div>',
			player:     "html",
			title:      "Visualizando archivo: " + $itself.attr('data-nomExp'),
			width:      1600,
			height:     900
		});
	});

</script>

