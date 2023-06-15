<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>
		
		<!--Contenido de la página-->
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="fas fa-bookmark fa-2x"></i>
                            </div>
							<div class="card-content">
								<h3 class="card-title center-align" id="showDate">Contratos recibidos</h3>
								<div class="toolbar">
									<div class="row">
										<div class="col-12 col-sm-6 col-md-6 col-lg-6">
										</div>
										<div class="col-12 col-sm-6 col-md-6 col-lg-6">
											<div class="container-fluid p-0">
												<div class="row">
													<div class="col-md-12 p-r">
														<div class="form-group d-flex">
															<input type="text" class="form-control datepicker" id="beginDate" />
															<input type="text" class="form-control datepicker" id="endDate" />
															<button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
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
									<div class="table-responsive">
										<table id="Jtabla" class="table-striped table-hover">
											<thead>
												<tr>
													<th>LOTE</th>
													<th>GERENTE(s)</th>
													<th>ASESOR(es)</th>
													<th>ESTATUS</th>
													<th>DETALLES</th>
													<th>COMENTARIO</th>
													<th>TOTAL NETO</th>
													<th>TOTAL VALIDADO</th>
													<th>FECHA</th>
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
			<?php $this->load->view('template/footer_legend');?>
		</div>
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
	<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
	<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
	<script>
		$(document).ready(function(){
			sp.initFormExtendedDatetimepickers();
			$('.datepicker').datetimepicker({locale: 'es'});
			setInitialValues();

			// $.ajax({
			// 		post: "POST",
			// 		url: "<?=site_url().'/registroLote/getDateToday/'?>"
			// }).done(function(data){
			// 	$('#showDate').append('Contratos recibidos al: ' + data);
			// }).fail(function(){});

			$('#Jtabla thead tr:eq(0) th').each( function (i) {
                var title = $(this).text();
                if(i != 0 && i != 8){
                    $(this).html('<input type="text" class="textoshead"  placeholder="'+title+'"/>' );
                    $( 'input', this ).on('keyup change', function () {
                        if ($('#Jtabla').DataTable().column(i).search() !== this.value ) {
                            $('#Jtabla').DataTable()
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    });
                }
            });

			function fillTable(typeTransaction, beginDate, endDate, where) {
				
				var table = $('#Jtabla').dataTable({
					dom: "<'row'<'col-xs-12 col-sm-6 col-md-6 col-lg-6'B><'col-xs-12 col-sm-6 col-md-6 col-lg-6 d-flex justify-end p-0'lr>t><'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
					buttons: [{
						extend: 'excelHtml5',
						text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
						className: 'btn buttons-excel',
						titleAttr: 'Descargar archivo de Excel',
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
					columnDefs: [{
						defaultContent: "-",
						targets: "_all"
					}],
					columns: [{
						data: function (d) {
							return d.nombreLote;
						}
					},
					{
						data: function (d){
							var ge1, ge2, ge3, ge4, ge5;
							if(d.gerente == undefined){ge1="";}else{ge1=d.gerente;};
							return ge1;

						}
					},
					{
						data: function (d){
							var as1, as2, as3, as4, as5;
							if(d.asesor == undefined){as1="";}else{as1=d.asesor};
							return as1 ;
						}
					},
					{
						data: function (d){
							var status;
							if(d.idStatusContratacion==9){
								status="9. Contrato recibido con firma de cliente (Contraloría) ";
							}
							else{
								status="Status no definido [303]";
							}
							return status;
						}
					},
					{
						data: function (d){
							var details;
							if(d.idStatusContratacion==9 && d.idMovimiento==39){details="Status 9 listo (Contraloría)    ";}
							return details;
						}
					},
					{
						data: function (d) {
							return d.comentario;
						}
					},
					{
						data:function(d){
							return "$"+alerts.number_format(d.totalNeto2, 2, ".", ",")
						}
					},
					{
						data:function(d){
							return "$"+alerts.number_format(d.totalValidado, 2, ".", ",")
						}
					},
					{
						data: function (d) {
							return d.modificado;
						}
					}],
					ajax:{
						url: '<?=base_url()?>index.php/registroLote/getHistProcData',
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
				fillTable(3, finalBeginDate, finalEndDate, 0);
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
				$("#beginDate").val(convertDate(beginDate));
				$("#endDate").val(convertDate(endDate));
				finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
				finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');
				fillTable(1, finalBeginDate, finalEndDate, 0);
			}
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
	</script>
</body>