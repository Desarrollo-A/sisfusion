<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
	<?php
	//se debe validar que tipo de perfil esta sesionado para poder asignarle el tipo de sidebar
	if($this->session->userdata('id_rol')=="16" || $this->session->userdata('id_rol')=="6" || $this->session->userdata('id_rol')=="11"  || $this->session->userdata('id_rol')=="13" || $this->session->userdata('id_rol')=="32" || $this->session->userdata('id_rol')=="17" || $this->session->userdata('id_rol')=="47" || $this->session->userdata('id_rol')=="15" || $this->session->userdata('id_rol')=="7" || $this->session->userdata('id_rol')=="12" || $this->session->userdata('id_rol')=="70"|| $this->session->userdata('id_rol') == "71")//contratacion
		$this->load->view('template/sidebar', "");
	else
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
	?>



    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <div class="encabezadoBox">
                                <h3 class="card-title center-align">Documentación por lote</h3>
                                <p class="card-title pl-1"></p>
                            </div>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="filtro3" id="filtro3"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un proyecto" data-size="7" required>
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
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select id="filtro4" name="filtro4"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un condominio" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Lote</label>
                                            <select id="filtro5" name="filtro5"
                                                    class="selectpicker select-gral m-0"
                                                    data-show-subtext="true"
                                                    data-live-search="true"
                                                    data-style="btn" data-show-subtext="true"
                                                    data-live-search="true"
                                                    title="Selecciona un lote" data-size="7" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="tableDoct"
                                               class="table-striped table-hover" style="text-align:center;">
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


	<!--Contenido de la página-->
	<div class="content hide    ">
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
c                                    </span>
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
									<select name="filtro3" id="filtro3" class="selectpicker" data-show-subtext="true"
                                            data-live-search="true"  data-style="btn" title="Selecciona Proyecto" data-size="7" required>
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
									<select id="filtro4" name="filtro4" class="selectpicker" data-show-subtext="true"
                                            data-live-search="true"  data-style="btn" title="Selecciona Condominio" data-size="7"></select>
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
						<div class="card-content" style="padding: 50px 20px;">
							<div class="material-datatables">
										<table id="tableDoct" class="table table-bordered table-hover" width="100%" style="text-align:center;">
											<thead>
											<tr>
												<th style="font-size: .9em;" class="text-center">Proyecto</th>
												<th style="font-size: .9em;" class="text-center">Condominio</th>
												<th style="font-size: .9em;" class="text-center">Lote</th>
												<th style="font-size: .9em;" class="text-center">Cliente</th>
												<th style="font-size: .9em;" class="text-center">Nombre de Documento</th>
												<th style="font-size: .9em;" class="text-center">Hora/Fecha</th>
												<th style="font-size: .9em;" class="text-center">Documento</th>
												<th style="font-size: .9em;" class="text-center">Responsable</th>
												<th style="font-size: .9em;" class="text-center">Ubicación</th>
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
                beforeSend:function(){
                    $('#spiner-loader').removeClass('hide');
                },
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['idCondominio'];
						var name = response[i]['nombre'];
						$("#filtro4").append($('<option>').val(id).text(name));
					}
					$("#filtro4").selectpicker('refresh');
                    $('#spiner-loader').addClass('hide');
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
                beforeSend:function(){
                    $('#spiner-loader').removeClass('hide');
                },
				success:function(response){
					var len = response.length;
					for( var i = 0; i<len; i++)
					{
						var id = response[i]['idLote'];
						var name = response[i]['nombreLote'];
						$("#filtro5").append($('<option>').val(id).text(name));
					}
					$("#filtro5").selectpicker('refresh');
                    $('#spiner-loader').addClass('hide');
                }
			});
		});


        $('#tableDoct thead tr:eq(0) th').each(function (i) {

            if (i != 6) {
            var title = $(this).text();
            $(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500;" class="textoshead"  placeholder="' + title + '"/>');
            $('input', this).on('keyup change', function () {
                if ($('#tableDoct').DataTable().column(i).search() !== this.value) {
                    $('#tableDoct').DataTable()
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
            }
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
                dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
				"pageLength": 10,
				"ordering": false,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                        className: 'btn buttons-excel',
                        titleAttr: 'Lista de documentación por lote',
                        title: "Lista de documentación por lote",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 7, 8]
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf" aria-hidden="true"></i>',
                        className: 'btn buttons-pdf',
                        titleAttr: 'Lista de documentación por lote',
                        title: "Lista de documentación por lote",
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                          columns: [0,1,2,3,4,5,7,8],
                          format: {
                                header: function (d, columnIdx) {
                                    switch (columnIdx) {
                                        case 0:
                                            return 'PROYECTO';
                                            break;
                                        case 1:
                                            return 'CONDOMINIO';
                                            break;
                                        case 2:
                                            return 'LOTE';
                                        case 3:
                                            return 'CLIENTE';
                                            break;
                                        case 4:
                                            return 'NOMBRE DE DOCUMENTO';
                                            break;
                                        case 5:
                                            return 'HORA/FECHA';
                                            break;
                                        case 7:
                                            return 'RESPONSABLE';
                                            break;
                                        case 8:
                                            return 'UBICACIÓN';
                                            break;
                                    }
                                }
                            }
                        }
                    }
                ],
				"language":{ "url": "<?=base_url()?>/static/spanishLoader.json" },
				"columns":
					[
						{
						"width": "8%",
						"data": function( d ){
							return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
						}
						},
		
						{
						"width": "8%",
						"data": function( d ){
							return '<p style="font-size: .8em">'+d.nombre+'</p>';
						}
						},
						{
						"width": "12%",
						"data": function( d ){
							return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
						}
						},
						{
						"width": "10%",
						"data": function( d ){
							return '<p style="font-size: .8em">'+d.nomCliente +' ' +d.apellido_paterno+' '+d.apellido_materno+'</p>';
						}
						},
							
						{
						"width": "10%",
						"data": function( d ){
							return '<p style="font-size: .8em">'+d.movimiento+'</p>';
						}
						},
						{
						"width": "10%",
						"data": function( d ){
							return '<p style="font-size: .8em">'+d.modificado+'</p>';
						}
						},
						{
							"width": "10%",
							data: null,
							render: function ( data, type, row )
							{
							    var disabled_option = myFunctions.revisaObservacionUrgente(data.observacionContratoUrgente);

								if (getFileExtension(data.expediente) == "pdf") {
									if(data.tipo_doc == 8){
										file = '<center><a class="pdfLink3 btn-data btn-warning" '+disabled_option+' data-Pdf="'+data.expediente+'" title= "Ver archivo"  data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a></center>';
									} else if(data.tipo_doc == 66){
										file = '<center><a class="verEVMKTD btn-data btn-warning" '+disabled_option+' data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-file-pdf"></i></a></center>';
									}else {
										file = '<center><a class="pdfLink btn-data btn-warning" '+disabled_option+' data-Pdf="'+data.expediente+'" title= "Ver archivo"  data-nomExp="'+data.expediente+'"><i class="fas fa-file-pdf"></i></a></center>';
									}
								}

								else if (getFileExtension(data.expediente) == "xlsx") {

									if(data.idMovimiento == 35 || data.idMovimiento == 22 || data.idMovimiento == 62 || data.idMovimiento == 75 || data.idMovimiento == 94){
										file = '<center><a href="../../static/documentos/cliente/corrida/' + data.expediente + '" '+disabled_option+' class="btn-data btn-green-excel"> <i class="fas fa-file-excel"></i><src="../../static/documentos/cliente/corrida/"' + data.expediente + '"></a> | <button type="button" title= "Eliminar archivo" id="deleteDoc" class=" btn-data btn-warning delete" data-tipodoc="'+data.movimiento+'" data-iddoc="'+data.idDocumento+'" ><i class="fas fa-trash"></i></button></center>';
									} else {
										file = '<center><a href="../../static/documentos/cliente/corrida/' + data.expediente + '" '+disabled_option+' class="btn-data btn-green-excel"><i class="fas fa-file-excel"></i><src="../../static/documentos/cliente/corrida/"' + data.expediente + '"></a></center>';
									}

								}

								else if (getFileExtension(data.expediente) == "NULL" || getFileExtension(data.expediente) == 'null' || getFileExtension(data.expediente) == "") {

									if(data.tipo_doc == 7){
										if(data.idMovimiento == 35 || data.idMovimiento == 22 || data.idMovimiento == 62 || data.idMovimiento == 75 || data.idMovimiento == 94){
											file = '<button type="button" id="updateDoc" title= "Adjuntar archivo" class="btn-data btn-green update" ' +
                                                'data-iddoc="'+data.idDocumento+'" data-tipodoc="'+data.tipo_doc+'" ' +
                                                'data-descdoc="'+data.movimiento+'" data-idCliente="'+data.idCliente+'" data-nombreResidencial="'+data.nombreResidencial+'" ' +
                                                'data-nombreCondominio="'+data.nombre+'" data-nombreLote="'+data.nombreLote+'" data-idCondominio="'+data.idCondominio+'" ' +
                                                'data-idLote="'+data.idLote+'" '+disabled_option+'><i class="fa fa-upload" aria-hidden="true"></i></button>';
										} else {
											file = '<center><button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fa fa-upload" aria-hidden="true"></i></button></center>';
										}

									} else if(data.tipo_doc == 8){
										file = '<center><button type="button" title= "Contrato inhabilitado" class="btn-data btn-warning disabled" disabled><i class="fa fa-clipboard" aria-hidden="true"></i></button></center>';
									} else {
										file = '<center><button type="button" id="updateDoc" title= "No se permite adjuntar archivos" class="btn-data btn-green disabled" disabled><i class="fa fa-upload" aria-hidden="true"></i></button></center>';
									}
								}

								else if (getFileExtension(data.expediente) == "Depósito de seriedad") {
									file = '<center><a class="btn-data btn-blueMaderas pdfLink2" '+disabled_option+' data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a></center>';
								}
                                else if (getFileExtension(data.expediente) == "Depósito de seriedad versión anterior") {
                                    file = '<a class="btn-data btn-blueMaderas pdfLink22" '+disabled_option+' data-idc="'+data.id_cliente+'" data-nomExp="'+data.expediente+'" title= "Depósito de seriedad"><i class="fas fa-file"></i></a>';
                                }
								else if (getFileExtension(data.expediente) == "Autorizaciones") {
									file = '<a href="#" class="btn-data btn-warning seeAuts" '+disabled_option+' title= "Autorizaciones" data-id_autorizacion="'+data.id_autorizacion+'" data-idLote="'+data.idLote+'"><i class="fas fa-key"></i></a>';
								}
								else if (getFileExtension(data.expediente) == "Prospecto") {
									file = '<a href="#" class="btn-data btn-blueMaderas verProspectos" '+disabled_option+' title= "Prospección" data-id-prospeccion="'+data.id_prospecto+'" data-nombreProspecto="'+data.nomCliente+' '+data.apellido_paterno+' '+data.apellido_materno+'" data-lp="'+data.lugar_prospeccion+'"><i class="fas fa-user-check"></i></a>';
								}
								else
								{
									if(data.tipo_doc == 66){
										file = '<center><a class="verEVMKTD btn-data btn-acidGreen" '+disabled_option+' data-expediente="'+data.expediente+'" title= "Ver archivo" style="cursor:pointer;" data-nomExp="'+data.movimiento+'" data-nombreCliente="'+data.primerNom+'"><i class="fas fa-image"></i></a></center>';
										}
										else{
											file = '<center><a class="pdfLink btn-data btn-acidGreen" '+disabled_option+' data-Pdf="'+data.expediente+'" data-nomExp="'+data.expediente+'"><i class="fas fa-image"></i></a></center>';
										}
									
								}
								return file;
							}
						},
						{
						"width": "10%",
						"data": function( d ){
							return '<p style="font-size: .8em">'+ myFunctions.validateEmptyFieldDocs(d.primerNom) +' '+myFunctions.validateEmptyFieldDocs(d.apellidoPa)+' '+myFunctions.validateEmptyFieldDocs(d.apellidoMa)+'</p>';
						}
						},						
						
						{
						"width": "10%",
						"data": function( d ){
							var validaub = (d.ubic == null) ? '' : d.ubic;
							
							return '<p style="font-size: .8em">'+ validaub +'</p>';
						}
						},										
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

		if(checaTipo($itself.attr('data-expediente')) == "pdf")
		{
			cntShow = '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>';
		}else{
			cntShow = '<div><img src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" class="img-responsive"></div>';
		}
		/*content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/evidencia_mktd/'+$itself.attr('data-expediente')+'" allowfullscreen></iframe></div>',*/
		Shadowbox.open({
			content:    cntShow,
			player:     "html",
			title:      "Visualizando Evidencia MKTD: " + $itself.attr('data-nombreCliente'),
			width:      985,
			height:     660

		});
	});

	function checaTipo(archivo)
	{
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
			//toastr.error('Debes seleccionar un archivo.', '¡Alerta!');
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
						//toastr.success('Corrida enviada.', '¡Alerta de Éxito!');
						alerts.showNotification('top', 'right', 'Corrida enviada', 'success');
						$('#sendFile').prop('disabled', false);
						$('#addFile').modal('hide');
						$('#tableDoct').DataTable().ajax.reload();
					} else if(response.message == 'ERROR'){
						//toastr.error('Error al enviar corrida y/o formato no válido.', '¡Alerta de error!');
						alerts.showNotification('top', 'right', 'Error al enviar corrida y/o formato no válido', 'danger');
						$('#sendFile').prop('disabled', false);
					}
				}
			});
		}

	});
	
	
	$(document).on("click", ".delete", function (e) {
	    console.log('this is de plan');
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
					//toastr.success('Archivo eliminado.', '¡Alerta de Éxito!');

					alerts.showNotification('top', 'right', 'Archivo eliminado', 'success');
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
				$('#auts-loads').append('<h4>Autoriza: '+item['nombreAUT']+'</h4><br>');
				$('#auts-loads').append('<p style="text-align: justify;"><i>'+item['autorizacion']+'</i></p>' +
					'<br><hr>');

			});
			$('#verAutorizacionesAsesor').modal('show');
		});
	});


</script>

