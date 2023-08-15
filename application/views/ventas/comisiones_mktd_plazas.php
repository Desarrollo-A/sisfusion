<body>
<div class="wrapper">

	<?php $this->load->view('template/sidebar'); ?>



	<style type="text/css">
		::-webkit-input-placeholder { /* Chrome/Opera/Safari */
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



	<div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">

				<form method="post" id="form_espera_uno">
					<div class="modal-body"></div>
					<div class="modal-footer"></div>
				</form>
			</div>
		</div>
	</div>




	<!--<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-red">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">DETALLES COMISIÓN</h4>
				</div>
				<form method="post" id="form_interes">
					<div class="modal-body"></div>
				</form>
			</div>
		</div>
	</div>-->


	<!--<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body"></div>
			</div>
		</div>
	</div>-->




	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-content">
							<div class="row">
								<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="nav-center">
										<ul class="nav nav-pills nav-pills-info nav-pills-icons" role="tablist">
											<!--  <li class="active" style="margin-right: 50px;">
												 <a href="#nuevas-1" role="tab" data-toggle="tab">
													 <i class="fa fa-file-text-o" aria-hidden="true"></i> Nuevas
												 </a>
											 </li> -->
											<!--
																					<li style="margin-right: 50px;">
																						<a href="#dispersadas-1" role="tab" data-toggle="tab">
																							<i class="fa fa-indent" aria-hidden="true"></i> DISPERSADAS
																						</a>
																					</li> -->


										</ul>
									</div>

									<div class="tab-content">

										<div class="tab-pane active" id="nuevas-1">
											<div class="content">
												<div class="container-fluid">
													<div class="row">
														<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="card">
																<div class="card-header">

																	<div class="col xol-xs-6 col-sm-6 col-md-6 col-lg-6">
																		<h4 class="card-title">COMISIONES NUEVAS</h4>
																		<!--  <p class="category">Las comisiones se encuentran disponibles para enviar a contraloría.</p>
		  -->                                                            </div>



																</div>
																<div class="card-content">
																	<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<div class="material-datatables">
																			<div class="form-group">
																				<div class="table-responsive">
																					<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones">
																						<thead>
																						<tr>
																							<th style="font-size: .9em;">PROYECTO</th>
																							<th style="font-size: .9em;">CONDOMINIO</th>
																							<th style="font-size: .9em;">LOTE</th>
																							<th style="font-size: .9em;">PRECIO LOTE</th>
																							<th style="font-size: .9em;">TIPO VENTA</th>
																							<th style="font-size: .9em;">MÁS</th>
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
											</div>
										</div>

										<!-- ///////////////// -->



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
	var totaPen = 0;
	var tr;

	$("#tabla_nuevas_comisiones").ready( function(){

		$('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
			if( i!=0 && i!=10){
				var title = $(this).text();


				$(this).html('<input type="text" style="width:100%; background: #003D82; color: white; border: 0; font-weight: 500;"  placeholder="'+title+'"/>' );

			}
		});


		tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
			dom: 'none',
			width: 'auto',


			"language":{ "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
			"processing": true,
			"pageLength": 10,
			"bAutoWidth": false,
			"bLengthChange": false,
			"scrollX": true,
			"bInfo": false,
			"searching": true,
			"ordering": false,
			"fixedColumns": true,
			"ordering": false,
			"columns": [

				{
					"width": "9%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.proyecto+'</p>';
					}
				},
				{
					"width": "9%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+(d.condominio).toUpperCase();+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.lote+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p style="font-size: .8em">$'+formatMoney(d.total)+'</p>';
					}
				},
				{
					"width": "12%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.lugar_prosp+'</p>';
					}
				},


				{
					"width": "6%",
					"orderable": false,
					"data": function( data ){
						opciones = '<div class="btn-group" role="group">';
						opciones += '<button class="btn btn-just-icon btn-round btn-warning"  onClick="mandar_espera('+data.idLote+')""><i class="material-icons">apps</i></button>';


						return opciones + '</div>';
					}
				}],
			columnDefs: [

				{

					orderable: false,
					className: 'select-checkbox',
					targets:   0,
					'searchable':false,
					'className': 'dt-body-center',

					select: {
						style:    'os',
						selector: 'td:first-child'
					},
				}],



			"ajax": {
				"url": url2 + "Comisiones/getDatosComisioneEnviar",
				/*registroCliente/getregistrosClientes*/
				"type": "POST",
				cache: false,
				"data": function( d ){}},
			"order": [[ 1, 'asc' ]]
		});




	});

	//FIN TABLA NUEVA


	// FIN TABLA PAGADAS



	function mandar_espera(idLote, nombre) {
		idLoteespera = idLote;
		// link_post2 = "Cuentasxp/datos_para_rechazo1/";
		link_espera1 = "Comisiones/generar comisiones/";
		$("#myModalEspera .modal-footer").html("");
		$("#myModalEspera .modal-body").html("");
		$("#myModalEspera ").modal();

		// $("#myModalEspera .modal-body").append("<div class='btn-group'>LOTE: "+nombre+"</div>");
		$("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");


	}






	// FUNCTION MORE

	$(window).resize(function(){
		tabla_nuevas.columns.adjust();
		tabla_proceso.columns.adjust();
		tabla_pagadas.columns.adjust();
		tabla_otras.columns.adjust();
	});

	function formatMoney( n ) {
		var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};



</script>

