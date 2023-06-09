<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-user-friends fa-2x"></i>
							</div>
							<div class="card-content">
								<h3 class="card-title center-align">Listado general de clientes marketing digital</h3>
								<div class="toolbar">
									<div class="row">
										<div class="col-12 col-sm-6 col-md-6 col-lg-6">
										</div>
										<div class="col-12 col-sm-6 col-md-6 col-lg-6">
											<div class="container-fluid p-0">
												<div class="row">
													<div class="col-md-12 p-r">
														<div class="form-group d-flex">
															<input type="text" class="form-control datepicker"
																id="beginDate" value="01/01/2021"/>
															<input type="text" class="form-control datepicker" id="endDate"
																value="01/01/2021"/>
															<button class="btn btn-success btn-round btn-fab btn-fab-mini"
																	id="searchByDateRange">
																<span class="material-icons update-dataTable">search</span>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="material-datatables">
									<div class="form-group">
										<div class="table-responsive">
											<table id="clients_report_datatable" class="table-striped table-hover">
												<thead>
													<tr>
														<th data-toggle="tooltip" data-placement="right" title="Proyecto">PROYECTO</th>
														<th data-toggle="tooltip" data-placement="right" title="Condominio">CONDOMINIO</th>
														<th data-toggle="tooltip" data-placement="right" title="Lote">LOTE</th>
														<th data-toggle="tooltip" data-placement="right" title="ID lote">ID LOTE</th>
														<th data-toggle="tooltip" data-placement="right" title="Cliente">CLIENTE</th>
														<th data-toggle="tooltip" data-placement="right" title="Teléfono">TELÉFONO</th>
														<th data-toggle="tooltip" data-placement="right" title="Medio">MEDIO</th>
														<th data-toggle="tooltip" data-placement="left" title="Plaza">PLAZA</th>
														<th data-toggle="tooltip" data-placement="left" title="Asesor">ASESOR</th>
														<th data-toggle="tooltip" data-placement="left" title="Gerente">GERENTE</th>
														<th data-toggle="tooltip" data-placement="left" title="Total">TOTAL</th>
														<th data-toggle="tooltip" data-placement="left" title="Enganche">ENGANCHE</th>
														<th data-toggle="tooltip" data-placement="left" title="Plan enganche">PLAN ENGANCHE</th>
														<th data-toggle="tooltip" data-placement="left" title="Plan enganche">ESTATUS</th>
														<th data-toggle="tooltip" data-placement="left" title="Fecha apartado">FECHA APARTADO</th>
														<th data-toggle="tooltip" data-placement="left" title="Fecha estatus 15">FECHA ESTATUS 15</th>
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
	<script>
		$(document).ready(function () {
			sp.initFormExtendedDatetimepickers();
			$('.datepicker').datetimepicker({locale: 'es'});
			/*
			fillTable(typeTransaction, beginDate, endDate, where) PARAMS;
				typeTransaction:
					1 = ES LA PRIMERA VEZ QUE SE LLENA LA TABLA O NO SE SELECCIONÓ UN RANGO DE FECHA (MUESTRA LO DEL AÑO ACTUAL)
					2 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL ID DE LOTE INGRESADO)
					3 = ES LA SEGUNDA VEZ QUE SE LLENA LA TABLA (MUESTRA INFORMACIÓN CON BASE EN EL RANGO DE FECHA SELECCIONADO)
				beginDate
					FECHA INICIO
				endDate
					FECHA FIN
				where
					ID LOTE (WHEN typeTransaction VALUE IS 2 WE SEND ID LOTE VALUE)
			*/

			setInitialValues();
		});

		sp = { // MJ: SELECT PICKER
			initFormExtendedDatetimepickers: function () {
				$('.datepicker').datetimepicker({
					format: 'MM/DD/YYYY',
					icons: {
						time: "fa fa-clock-o",
						date: "fa fa-calendar",
						up: "fa fa-chevron-up",
						down: "fa fa-chevron-down",
						previous: 'fa fa-chevron-left',
						next: 'fa fa-chevron-right',
						today: 'fa fa-screenshot',
						clear: 'fa fa-trash',
						close: 'fa fa-remove',
						inline: true
					}
				});
			}
		}

		$('#clients_report_datatable thead tr:eq(0) th').each( function (i) {
			var title = $(this).text();
			$(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
			$( 'input', this ).on('keyup change', function () {
				if ($('#clients_report_datatable').DataTable().column(i).search() !== this.value ) {
					$('#clients_report_datatable').DataTable().column(i).search(this.value).draw();
				}
			});
		});

		function fillDataTable(typeTransaction, beginDate, endDate, where){
			var clients_report_datatable = $('#clients_report_datatable').dataTable({
				dom: 'Brt'+ "<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
						format: {
							header: function (d, columnIdx) {
								switch (columnIdx) {
									case 1:
										return 'Proyecto';
										break;
									case 2:
										return 'Condominio';
										break;
									case 3:
										return 'Lote'
									case 4:
										return 'ID lote';
										break;
									case 5:
										return 'Teléfono';
										break;
									case 6:
										return 'Medio';
										break;
									case 7:
										return 'Plaza';
										break;
									case 8:
										return 'Asesor';
										break;
									case 9:
										return 'Gerente';
										break;
									case 10:
										return 'Total';
										break;
									case 11:
										return 'Enganche';
										break;
									case 12:
										return 'Plan de enganche';
										break;
									case 13:
										return 'Estatus';
										break;
									case 14:
										return 'Fecha apartado';
										break;
									case 15:
										return 'Fecha estatus 15';
										break;
								}
							}
						}
					},
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
				columns: [{ 
					data: function (d) {
						return d.nombreResidencial;
					}
				},
				{ 
					data: function (d) {
						return d.nombreCondominio;
					}
				},
				{ 
					data: function (d) {
						return d.nombreLote;
					}
				},
				{ 
					data: function (d) {
						return d.idLote;
					}
				},
				{ 
					data: function (d) {
						return d.nombreCliente;
					}
				},
				{ 
					data: function (d) {
						return d.telefono;
					}
				},
				{ 
					data: function (d) {
						return d.medioProspeccion;
					}
				},
				{ 
					data: function (d) {
						return d.plaza;
					}
				},
				{ 
					data: function (d) {
						return d.nombreAsesor;
					}
				},
				{ 
					data: function (d) {
						return d.nombreGerente;
					}
				},
				{ 
					data: function (d) {
						return formatMoney(d.totalNeto2);
					}
				},
				{ 
					data: function (d) {
						return formatMoney(d.enganche);
					}
				},
				{ 
					data: function (d) {
						return d.planEnganche;
					}
				},
				{ 
					data: function (d) {
						if (d.idStatusLote == 2) { // MJ: CONTRATADO
							return "<small class='label bg-green' style='background-color: #2ECC71'>CONTRATADO</small>";
						} else if (d.idStatusLote == 3) { // MJ: APARTADO+
							return "<small class='label bg-green' style='background-color: #F1C40F'>APARTADO</small>";
						}
					}
				},
				{
					data: function (d) {
						return d.fechaApartado;
					}
				},
				{ 
					data: function (d) {
						return d.fechaEstatusQuince;
					}
				}],
				ajax: {
					url: 'getClientsReportMktd',
					type: "POST",
					cache: false,
					data: {
						"typeTransaction": typeTransaction,
						"beginDate": beginDate,
						"endDate": endDate,
						"where": where
					}
				}
			});
		}

		$(document).on("click", "#searchByDateRange", function () {
			let finalBeginDate = $("#beginDate").val();
			let finalEndDate = $("#endDate").val();
			fillDataTable(3, finalBeginDate, finalEndDate, 0);
		});

		function setInitialValues() {
			// BEGIN DATE
			const fechaInicio = new Date();
			// Iniciar en este año, este mes, en el día 1
			const beginDate = new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);
			// END DATE
			const fechaFin = new Date();
			// Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
			const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);
			finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
			finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
			fillDataTable(1, finalBeginDate, finalEndDate, 0);
		}

		function formatMoney( n ){
			var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;

			return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		};

	</script>
</body>