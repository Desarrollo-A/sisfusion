
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
			'documentacion' => 1,
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
			'gerentesAsistentes' => 0,
			'expedientesIngresados'	=>	0,
			'corridasElaboradas'	=>	0,
            'nuevasComisiones'	=>	0,
            'histComisiones'	=>	0
        );
		//$this->load->view('template/contratacion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else if($this->session->userdata('id_rol')=="6")//ventasAsistentes
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'corridaF' => 0,
			'documentacion' => 1,
			'autorizacion' => 0,
			'contrato' => 0,
			'inventario' => 0,
			'estatus8' => 0,
			'estatus14' => 0,
			'estatus7' => 0,
			'reportes' => 0,
			'estatus9' => 0,
			'disponibles' => 0,
			'asesores' => 0,
			'nuevasComisiones' => 0,
			'histComisiones' => 0,
			'prospectos' => 0,
			'prospectosAlta' => 0,
            'nuevasComisiones'	=>	0,
            'histComisiones'	=>	0



		);
		//$this->load->view('template/ventas/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="11")//administracion
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 1,
			'inventario' => 0,
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
			'documentacion' => 1,
			'contrato' => 0,
			'inventario' => 0,
			'status3' => 0,
			'status7' => 0,
			'lotesContratados' => 0,
            'nuevasComisiones'	=>	0,
            'histComisiones'	=>	0
		);
		//$this->load->view('template/juridico/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="13")//contraloria
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'expediente' => 0,
			'corrida' => 0,
			'documentacion' => 1,
			'historialpagos' => 0,
			'inventario' => 0,
			'estatus20' => 0,
			'estatus2' => 0,
			'estatus5' => 0,
			'estatus6' => 0,
			'estatus9' => 0,
			'estatus10' => 0,
			'estatus13' => 0,
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
                    'documentacion' => 1,
                    'inventarioDisponible'  =>  0,
                    'manual'    =>  0,
                    'nuevasComisiones'     => 0,
                    'histComisiones'       => 0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'references' => 0,
					'autoriza'	=>	0,
					'clientsList' => 0
                );
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="12")//caja
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 0,
			'documentacion' => 1,
			'cambiarAsesor' => 0,
			'historialPagos' => 0,
			'pagosCancelados' => 0,
			'altaCluster' => 0,
			'altaLote' => 0,
			'inventario' => 0,
			'actualizaPrecio' => 0,
			'actualizaReferencia' => 0,
			'liberacion' => 0
		);
		//$this->load->view('template/contraloria/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="28")//MKT
	{
		$dato= array(
			'home'	=> 0,
			'prospectos' => 0,
			'prospectosMktd' => 0,
			'prospectosAlta' => 0,
			'statistics' => 0,
			'sharedSales' => 0,
			'coOwners' => 0,
			'references' => 0,
			'bulkload' => 0,
			'listaAsesores' => 0,
			'manual'	=>	0,
			'aparta' => 0,
			'mkt_digital' => 0,
			'prospectPlace' => 0,
			'documentacionMKT' => 1,
			'inventarioMKT' => 0
		);
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
			<!-- modal  INSERT FILE-->
			<div class="modal fade" id="addFile" >
				<div class="modal-dialog">
					<div class="modal-content" >
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<center><h3 class="modal-title" id="myModalLabel"><span class="lote"></span></h3></center>
						</div>
						<div class="modal-body">
							<!--<div class="input-group">
								<label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        Seleccionar archivo&hellip; <input type="file" name="expediente" id="expediente" style="display: none;">
                                    </span>
								</label>
								<input type="text" class="form-control" id= "txtexp" name="txtexp" readonly>
							</div>-->
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
                            <h4 class="card-title" style="text-align: center">Documentación por lote</h4>
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
												<th class="text-center">Nombre de documento</th>
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
			<?php
			if($this->session->userdata('id_rol') == 7)
			{
				$metodoToExc = 'getLotesAsesor';
			}
			else
			{
				$metodoToExc = 'getLotesAll';
			}
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

			console.log(valorSeleccionado);
			$('#tableDoct').DataTable({
				destroy: true,
				lengthMenu: [[15, 25, 50, -1], [10, 25, 50, "All"]],
				"ajax":
					{
						"url": '<?=base_url()?>index.php/registroCliente/expedientesWS/'+valorSeleccionado,
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
						/*{
							data: null,
							render: function(data, type, row)
							{
								var myLinkConst = '<a href="<?=base_url()?>static/documentos/cliente/expediente/'+data.expediente+'" target="_blank"><span class="material-icons">attach_file</span></a>';
								return myLinkConst;
							}
						},*/
						{
							data: null,
							render: function ( data, type, row )
							{

								if (getFileExtension(data.expediente) == "pdf") {
									if(data.tipo_doc == 8){
										file = '<a class="pdfLink3" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><img src=\'<?=base_url()?>static/images/pdf.png\' style="width:30%"></a>';
									} else {
										<?php if($this->session->userdata('id_rol') == 7){?>
										if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 && id_rol_current==7){
											file = '<a class="pdfLink" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><img src=\'<?=base_url()?>static/images/pdf.png\' style="width:30%"></a> | <button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn btn-danger btn-round btn-fab btn-fab-mini delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="material-icons">delete</i></i></button>';
										} else {
											file = '<a class="pdfLink" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><img src=\'<?=base_url()?>static/images/pdf.png\' style="width:30%"></a>';
										}
										<?php } else {?>file = '<a class="pdfLink" data-Pdf="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.expediente+'"><img src=\'<?=base_url()?>static/images/pdf.png\' style="width:30%"></a>';<?php } ?>
									}
								}
								else if (getFileExtension(data.expediente) == "xlsx" || getFileExtension(data.expediente) == "XLSX") {
									file = "<a href='../../static/documentos/cliente/corrida/" + data.expediente + "'><img src='<?=base_url()?>static/images/excel.png' style='width:27%'/><src='../../static/documentos/cliente/corrida/" + data.expediente + "'> </a> ";
								}
								else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {
									if(data.tipo_doc == 7){
										file = '<button type="button" title= "Corrida inhabilitada" class="btn btn-round btn-fab btn-fab-mini btn-warning disabled"><i class="material-icons">grid_on</i></button>';
									} else if(data.tipo_doc == 8){
										file = '<button type="button" title= "Contrato inhabilitado" class="btn btn-round btn-fab btn-fab-mini btn-warning disabled"><i class="material-icons">insert_drive_file</i></button>';
									} else {
										<?php if($this->session->userdata('id_rol') == 7){?>
										if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 && id_rol_current == 7){
											file = '<button type="button" id="updateDoc" title= "Adjuntar archivo" class="btn btn-success btn-round btn-fab btn-fab-mini update" data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" data-idLote="'+data.idLote+'"><i class="material-icons">cloud_upload</i></button>';
										} else {
											file = '<button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn btn-success btn-round btn-fab btn-fab-mini disabled"><i class="material-icons">cloud_upload</i></button>';
										}
										<?php } else {?> file = '<button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn btn-success btn-round btn-fab btn-fab-mini disabled"><i class="material-icons">cloud_upload</i></button>'; <?php } ?>
									}
								}
								else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
									file = '<a class="btn btn-primary pdfLink2" data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="material-icons">insert_drive_file</i></a>';
								}
								else if (getFileExtension(data.expediente) == "Autorizaciones") {
									file = '<a href="#" class="btn btn-danger seeAuts" title= "Autorizaciones" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="material-icons">vpn_key</i></a>';
								}
								else if (getFileExtension(data.expediente) == "Prospecto") {
									file = '<a href="#" class="btn btn-primary verProspectos" title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'"><i class="material-icons">record_voice_over</i></a>';
								}
								else
								{
									<?php if($this->session->userdata('id_rol') == 7){?>
									if(data.idMovimiento == 31 || data.idMovimiento == 85 || data.idMovimiento == 20 || data.idMovimiento == 63 || data.idMovimiento == 73 || data.idMovimiento == 82 || data.idMovimiento == 92 && id_rol_current == 7){
										file = '<a class="pdfLink" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><img src="<?=base_url()?>static/documentos/cliente/expediente/'+data.expediente+'" style="cursor:pointer;" width="25" height="23"/></a> | <button type="button" title= "Eliminar archivo" id="deleteDoc" class="btn btn-danger btn-round btn-fab btn-fab-mini delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="material-icons">delete</i></i></button>';
									} else {
										file = '<a class="pdfLink" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><img src="<?=base_url()?>static/documentos/cliente/expediente/'+data.expediente+'" style="cursor:pointer;" width="25" height="23"/></a>';
									}
									<?php } else {?> file = '<a class="pdfLink" data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><img src="<?=base_url()?>static/documentos/cliente/expediente/'+data.expediente+'" style="cursor:pointer;" width="25" height="23"/></a>'; <?php }?>

								}
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



	});/*document Ready*/

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
			/*verProspectos*/
			content:    '<div><iframe style="overflow:hidden;width: 100%;height: -webkit-fill-available;" src="<?=base_url()?>clientes/printProspectInfo/'+$itself.attr('data-id-prospeccion')+'"></iframe></div>',
			player:     "html",
			title:      "Visualizando Prospecto: " + $itself.attr('data-nombreProspecto'),
			width:      985,
			height:     660

		});
	});
	<?php if($this->session->userdata('id_rol') == 7){?>
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
			console.log('alcuishe');

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
			//toastr.error('Debes seleccionar un archivo.', '¡Alerta!');
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
						//toastr.success('Expediente enviado.', '¡Alerta de Éxito!');
						alerts.showNotification('top', 'right', 'Expediente enviado', 'success');
						$('#sendFile').prop('disabled', false);
						$('#addFile').modal('hide');
						$('#tableDoct').DataTable().ajax.reload();
					} else if(response.message == 'ERROR'){
						//toastr.error('Error al enviar expediente y/o formato no válido.', '¡Alerta de error!');
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
					//toastr.success('Archivo eliminado.', '¡Alerta de Éxito!');
					alerts.showNotification('top', 'right', 'Archivo eliminado', 'danger');
					$('#aceptoDelete').prop('disabled', false);
					$('#cuestionDelete').modal('hide');
					$('#tableDoct').DataTable().ajax.reload();
				} else if(response.message == 'ERROR'){
					//toastr.error('Error al eliminar el archivo.', '¡Alerta de error!');
					alerts.showNotification('top', 'right', 'Error al eliminar el archivo', 'danger');
					$('#tableDoct').DataTable().ajax.reload();
				}
			}
		});

	});

	<?php } ?>
</script>

