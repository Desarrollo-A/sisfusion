
<body class="">
<div class="wrapper ">
	<?php
	if($this->session->userdata('id_rol')=="16")//contratacion
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 1,
			'contrato' => 0,
			'documentacion' => 0,
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
			'corridasElaboradas'	=>	0
		);
//		$this->load->view('template/contratacion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	else if($this->session->userdata('id_rol')=="6")//ventasAsistentes
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 1,
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
			'disponibles' => 0,
			'asesores' => 0,
			'nuevasComisiones' => 0,
			'histComisiones' =>0,
			'prospectos' =>0,
			'prospectosAlta' => 0
		);
		//$this->load->view('template/ventas/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="11")//administracion
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 1,
			'documentacion' => 0,
			'inventario' => 0,
			'status11' => 0
		);
		//$this->load->view('template/administracion/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="15")//juridico
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 1,
			'documentacion' => 0,
			'contrato' => 0,
			'inventario' => 0,
			'status3' => 0,
			'status7' => 0,
			'lotesContratados' => 0,
		);
		//$this->load->view('template/juridico/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="13")//contraloria
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 1,
			'expediente' => 0,
			'corrida' => 0,
			'documentacion' => 0,
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
			'tablaPorcentajes' => 0,
			'comnuevas' => 0,
			'comhistorial' => 0,
			'integracionExpediente' => 0,
			'expRevisados' => 0,
			'estatus10Report' => 0,
			'rechazoJuridico' => 0
		);
		//$this->load->view('template/contraloria/sidebar', $dato);
		$this->load->view('template/sidebar', $dato);
	}
	elseif($this->session->userdata('id_rol')=="12")//caja
	{
		$dato= array(
			'home' => 0,
			'listaCliente' => 1,
			'documentacion' => 0,
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
	else
	{
		echo '<script>alert("ACCESSO DENEGADO"); window.location.href="'.base_url().'";</script>';
	}
	?>
	<!--Contenido de la página-->

	<style type="text/css">
		::-webkit-input-placeholder
		{ /* Chrome/Opera/Safari */
			color: white;
			opacity: 0.4;

		::-moz-placeholder { /* Firefox 19+ */
			color: white;
			opacity: 0.4;
		}
		:-ms-input-placeholder { /* IE 10+ */
			color: white;
			opacity: 0.4;
		}
		:-moz-placeholder { /* Firefox 18- */
			color: white;
			opacity: 0.4;
		}


		}


	</style>

	<div class="modal fade" id="modal_cancelar_11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Rechazar</b> estatus.</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class=""></h5>
				</div>
				<form id="my-edit-form" name="my-edit-form" method="post">
					<div class="modal-body">
					</div>
				</form>
			</div>
		</div>
	</div>

	
<div class="content">
		<div class="container-fluid">
 
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">

                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="material-icons">reorder</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title ">Registro clientes</h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">

								<div class="form-group">
									<div class="table-responsive">
										<!-- 	 Registro de todos los clientes con y sin expediente.  -->

										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_clientes" name="tabla_clientes">
											<thead>
											<tr>
												<th></th>
												<th style="font-size: .9em;">ID</th>
												<th style="font-size: .9em;">PROYECTO</th>
												<th style="font-size: .9em;">CONDOMINIO</th>
												<th style="font-size: .9em;">LOTE</th>
												<th style="font-size: .9em;">CLIENTE</th>
												<th style="font-size: .9em;">NO. RECIBO</th>
												<th style="font-size: .9em;">TIPO PAGO</th>
												<th style="font-size: .9em;">FECHA APARTADO</th>
												<!-- <th style="font-size: .9em;">FECHA +45</th> -->
												<th style="font-size: .9em;">ENGANCHE</th>
												<th style="font-size: .9em; ">FECHA ENGANCHE</th>
												<!--style="font-size: .8em;color:black;"></th>-->
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
<script>
	var url = "<?=base_url()?>";
	var url2 = "<?=base_url()?>index.php/";
	$("#tabla_clientes").ready( function(){
		$('#tabla_clientes thead tr:eq(0) th').each( function (i) {
			if(i != 0 && i != 11){
				var title = $(this).text();
				$(this).html('<input type="text" style="width:100%; background:#003D82; color:white; border: 0; font-weight: 500"  placeholder="'+title+'"/>' );
				$( 'input', this ).on('keyup change', function () {
					if (tabla_valores_cliente.column(i).search() !== this.value ) {
						tabla_valores_cliente
							.column(i)
							.search(this.value)
							.draw();
					}
				} );
			}
		});


		tabla_valores_cliente = $("#tabla_clientes").DataTable({
			// dom: 'Brtip',
			width: 'auto',
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
			"processing": true,
			"pageLength": 10,
			"bAutoWidth": false,
			"bLengthChange": false,
			"scrollX": true,
			"bInfo": true,
			"searching": true,
			"ordering": false,
			"fixedColumns": true,
			"ordering": false,
			"columns": [
				{
					"width": "3%",
					"className": 'details-control',
					"orderable": false,
					"data" : null,
					"defaultContent": '<i class="material-icons" style="color:#003D82;" title="Click para más detalles">add_circle</i>'
				},


				{
					"width": "5%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.id_cliente+'</p>';
					}
				},
				{
					"width": "7%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
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
						return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
					}
				},

				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.noRecibo+'</p>';
					}
				},

				{
					"width": "8%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.tipo+'</p>';
					}
				},

				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.fechaApartado+'</p>';
					}
				},

				{
					"width": "8%",
					"data": function( d ){
						return '<p style="font-size: .8em">$ '+myFunctions.number_format(d.engancheCliente,2,'.',',')+'</p>';
					}
				},

				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.fechaEnganche+'</p>';
					}
				}

			],

			columnDefs: [
				{
					"searchable": false,
					"orderable": false,
					"targets": 0
				},

			],

			"ajax": {
				"url": url2 + "registroCliente/getregistrosClientes",
				"dataSrc": "",
				"type": "POST",
				cache: false,
				"data": function( d ){
				}
			},
			"order": [[ 1, 'asc' ]]

		});



		$('#tabla_clientes tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = tabla_valores_cliente.row( tr );

			if ( row.child.isShown() ) {
				row.child.hide();
				tr.removeClass('shown');
				$(this).parent().find('.animacion').removeClass("fa-caret-down").addClass("fa-caret-right");
			}
			else {

				var informacion_adicional = '<table class="table text-justify">'+
					'<tr>INFORMACIÓN: <b>'+row.data().nombre+' '+row.data().apellido_paterno+' '+row.data().apellido_materno+'</b>'+
					'<td style="font-size: .8em"><strong>CORREO: </strong>'+myFunctions.validateEmptyField(row.data().correo)+'</td>'+
					'<td style="font-size: .8em"><strong>TELEFONO: </strong>'+myFunctions.validateEmptyField(row.data().telefono1)+'</td>'+
					'<td style="font-size: .8em"><strong>RFC: </strong>'+myFunctions.validateEmptyField(row.data().rfc)+'</td>'+
					'<td style="font-size: .8em"><b>FECHA +45:</b> '+myFunctions.validateEmptyField(row.data().fechaVecimiento)+'</td>'+
					'<td style="font-size: .8em"><strong>FECHA NACIMIENTO: </strong>'+myFunctions.validateEmptyField(row.data().fechaNacimiento)+'</td>'+
					'</tr>'+
					'<tr>'+
					'<td style="font-size: .8em" colspan="4"><b>DOMICILIO PARTICULAR:</b> '+myFunctions.validateEmptyField(row.data().domicilio_particular)+'</td>'+
					'<td style="font-size: .8em"><b>ENTERADO:</b> '+myFunctions.validateEmptyField(row.data().enterado)+'</td>'+
					'</tr>'+
					'<tr>'+
					'<td style="font-size: .8em"><b>REFERENCIA I:</b> '+myFunctions.validateEmptyField(row.data().referencia1)+'</td>'+
					'<td style="font-size: .8em"><b>TEL. REFERENCIA I:</b> '+myFunctions.validateEmptyField(row.data().telreferencia1)+'</td>'+
					'<td style="font-size: .8em"><b>REFERENCIA II:</b> '+myFunctions.validateEmptyField(row.data().referencia2)+'</td>'+
					'<td style="font-size: .8em"><b>TEL. REFERENCIA II:</b> '+myFunctions.validateEmptyField(row.data().telreferencia2)+'</td>'+
					'<td style="font-size: .8em"><b>PRIMER CONTACTO:</b> '+myFunctions.validateEmptyField(row.data().primerContacto)+'</td>'+
					'</tr>'+
					'<tr>'+
					'<td style="font-size: .8em"><b>GERENTE :</b> '+myFunctions.validateEmptyField(row.data().gerente)+'</td>'+
					'<td style="font-size: .8em"><b>GERENTE II:</b> '+myFunctions.validateEmptyField(row.data().gerente2)+'</td>'+
					'<td style="font-size: .8em"><b>GERENTE III:</b> '+myFunctions.validateEmptyField(row.data().gerente3)+'</td>'+
					'</tr>' +
					'<tr>'+
					'<td style="font-size: .8em"><b>ASESOR I:</b> '+myFunctions.validateEmptyField(row.data().asesor)+'</td>'+
					'<td style="font-size: .8em"><b>ASESOR II:</b> '+myFunctions.validateEmptyField(row.data().asesor2)+'</td>'+
					'<td style="font-size: .8em"><b>ASESOR III:</b> '+myFunctions.validateEmptyField(row.data().asesor3)+'</td>'+
					'<td style="font-size: .8em"></td>'+
					'</tr>' +
					'</table>';

				row.child( informacion_adicional ).show();
				tr.addClass('shown');
				$(this).parent().find('.animacion').removeClass("fa-caret-right").addClass("fa-caret-down");
			}
		});


	});

	$(window).resize(function(){
		tabla_valores_cliente.columns.adjust();
	});

</script>

