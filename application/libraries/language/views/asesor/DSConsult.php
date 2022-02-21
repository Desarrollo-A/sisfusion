<body>
<div class="wrapper">
	<?php
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
                    'DSConsult' => 1,
                    'documentacion' => 0,
                    'inventarioDisponible'  =>  0,
                    'manual'    =>  0,
                    'nuevasComisiones'     => 0,
                    'histComisiones'       => 0,
                    'sharedSales' => 0,
                    'coOwners' => 0,
                    'references' => 0,
					'autoriza' => 0,
        'clientsList' => 0
                );
	//$this->load->view('template/asesor/sidebar', $dato);
	$this->load->view('template/sidebar', $dato);
	?>
	<div class="content">
		<div class="container-fluid">

			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">

						<div class="card-header card-header-icon" data-background-color="gray" style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
                                        <i class="material-icons">list</i>
                                    </div>

						<div class="card-content">

							 <h4 class="card-title"><B>Depósito de seriedad</B> - Consulta</h4>
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
												<th style="font-size: .9em;">FECHA APARTADO</th>
												<th style="font-size: .9em;">DEPÓSITO DE SERIEDAD</th>
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
					"width": "7%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.id_cliente+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.nombreResidencial+'</p>';
					}
				},
				{
					"width": "15%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+(d.nombreCondominio).toUpperCase();+'</p>';
					}
				},

				{
					"width": "15%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.nombreLote+'</p>';
					}
				},

				{
					"width": "20%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.nombre+" "+d.apellido_paterno+" "+d.apellido_materno+'</p>';
					}
				},

				{
					"width": "15%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.fechaApartado+'</p>';
					}
				},

				{
					"width": "15%",
					"data": function( d ){

						return '<center><a href="<?=base_url()?>index.php/Asesor/imprimir_ds/'+d.id_cliente+'" class="btn btn-black btn-round btn-fab btn-fab-mini to-comment" title="Imprimir Depósito" style="margin-right: 10px;color:#fff;background-color:#2A4DB4;" target="_blank"><i class="material-icons">print</i></a></center>';

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
				"url": url2 + "Asesor/getregistrosClientes",
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
					'<tr>CLIENTE: <b>'+row.data().nombre+' '+row.data().apellido_paterno+' '+row.data().apellido_materno+'</b>'+
					'</tr>'+
					'<tr>'+
					'<td style="font-size: .8em"><b>GERENTE I:</b> '+myFunctions.validateEmptyField(row.data().gerente)+'</td>'+
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

