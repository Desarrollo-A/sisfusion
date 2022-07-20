<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/planes.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<body>
	<div class="wrapper">
		<?php
		$datos = array();
		$datos = $datos4;
		$datos = $datos2;
		$datos = $datos3;
		$this->load->view('template/sidebar', $datos);
		?>

		<!-- Modals -->
		<!-- <div class="modal fade modal-alertas" id="ModalMsi" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<form method="post" id="formMsi">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
				</div>
			</div>
		</div> -->

		<div class="modal fade modal-alertas" id="ModalAlert" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content text-center">
					<div class="modal-header">
						<h4>Una vez guardados los planes <br> ya no se podrá modificar la información</h4>
					</div>
					<div class="row">
						<div class="col-md-6 text-right">
							<button type="button" data-toggle="tooltip" data-placement="right" title="Guardar" class="btn btn-success btn-circle btn-lg" onclick="SavePaquete();" name=""  id="">
								<i class="fas fa-check"></i>
							</button>
						</div>
						<div class="col-md-6 text-left">
							<button type="button" data-toggle="tooltip" data-placement="right" title="Cancelar" class="btn btn-danger btn-circle btn-lg" data-dismiss="modal">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade modal-alertas" id="ModalRemove" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content text-center">
					<div class="modal-header">
						<h4>¿Desea remover este plan?</h4>
					</div>
					<div class="row">
						<div class="col-md-6 text-right">
							<input type="hidden" value="0" id="iddiv">
							<button type="button" data-toggle="tooltip" data-placement="right" title="Guardar" class="btn btn-success btn-circle btn-lg" onclick="RemovePackage();" name=""  id=""><i class="fas fa-check"></i></button>
						</div>
						<div class="col-md-6 text-left">
							<button type="button" data-toggle="tooltip" data-placement="right" title="Cancelar" class="btn btn-danger btn-circle btn-lg" data-dismiss="modal"><i class="fas fa-times"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade modal-alertas" id="myModalDelete" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<form method="post" id="form_delete">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade modal-alertas" id="myModalListaDesc" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content"></div>
			</div>
		</div>
		
		<div class="modal fade modal-alertas" id="exampleModal" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="tabbable-panel">
						<div class="tabbable-line">
							<ul class="nav nav-tabs ">
								<li class="active">
									<a href="#tab_default_1" data-toggle="tab">
									precio total </a>
								</li>
								<li>
									<a href="#tab_default_2" data-toggle="tab">
									Enganche </a>
								</li>
								<li>
									<a href="#tab_default_3" data-toggle="tab">
									Precio por M2 </a>
								</li>
								<li>
									<a href="#tab_default_4" data-toggle="tab">
									Precio por bono </a>
								</li>
								<li>
									<a href="#tab_default_5" data-toggle="tab">
									MSI </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_default_1">
									<h4>Descuentos al total</h4>
									<p>
										<a class="btn btn-success" href="#" onclick="OpenModal(1,'tab_default_1');" >
											Agregar nuevo descuento
										</a>
									</p>
									<div class="material-datatables">
										<div class="form-group">
											<div class="table-responsive">
												<table class="table-striped table-hover" id="table_total" name="table_total">
													<thead>
														<tr>
															<th>ID DESCUENTO</th>
															<th>PORCENTAJE</th>
															<th>DESCUENTO A</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_default_2">
									<h4>Descuentos al enganche</h4>
									<p>
										<a class="btn btn-success" href="#" onclick="OpenModal(2,'tab_default_2');">
											Agregar nuevo descuento
										</a>
									</p>
									<div class="material-datatables">
										<div class="form-group">
											<div class="table-responsive">
												<table class="table-striped table-hover" id="table_enganche" name="table_enganche">
													<thead>
														<tr>
															<th>ID DESCUENTO</th>
															<th>PORCENTAJE</th>
															<th>DESCUENTO A</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_default_3">
									<h4>Descuentos por M2</h4>
									<p>
										<a class="btn btn-success" href="#" onclick="OpenModal(4,'tab_default_3');">
											Agregar nuevo descuento
										</a>
									</p>
									<div class="material-datatables">
										<div class="form-group">
											<div class="table-responsive">
												<table class="table-striped table-hover" id="table_m2" name="table_m2">
													<thead>
														<tr>
															<th>ID DESCUENTO</th>
															<th>PORCENTAJE</th>
															<th>DESCUENTO A</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_default_4">
									<h4>Descuentos por bono</h4>
									<p>
										<a class="btn btn-success" href="#" onclick="OpenModal(12,'tab_default_4');">
											Agregar nuevo descuento
										</a>
									</p>
									<div class="material-datatables">
										<div class="form-group">
											<div class="table-responsive">
												<table class="table-striped table-hover" id="table_bono" name="table_bono">
													<thead>
														<tr>
															<th>ID DESCUENTO</th>
															<th>PORCENTAJE</th>
															<th>DESCUENTO A</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_default_5">
									<h4>Descuentos MSI</h4>
									<p>
										<a class="btn btn-success" href="#" onclick="OpenModal(13,'tab_default_5');">
											Agregar nuevo descuento
										</a>
									</p>
									<div class="material-datatables">
										<div class="form-group">
											<div class="table-responsive">
												<table class="table-striped table-hover" id="table_msi" name="table_msi">
													<thead>
														<tr>
															<th>ID DESCUENTO</th>
															<th>PORCENTAJE</th>
															<th>DESCUENTO A</th>
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

		<div class="modal fade modal-alertas" id="ModalFormAddDescuentos" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Cargar nuevo descuento</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="addNewDesc">
						<input type="hidden" value="0" name="tdescuento" id="tdescuento">
						<input type="hidden" value="0" name="id_condicion" id="id_condicion">
						<input type="hidden" value="0" name="eng_top" id="eng_top">
						<input type="hidden" value="0" name="apply" id="apply">
						<input type="hidden" value="0" name="boton" id="boton">
						<input type="hidden" value="0" name="tipo_d" id="tipo_d">
						<div class="form-group">
							<label id="label_descuento"></label>
							<input type="text"  class="input-gral" required  data-type="currency"   id="descuento" name="descuento">
						</div>
						<div class="row">
							<div class="col-md-3">
							</div>
							<div class="col-md-3">
								<input type="submit" class="btn btn-success" name="disper_btn"  id="dispersar" value="Guardar">
							</div>
							<div class="col-md-3">
								<input type="button" class="btn btn-danger" data-dismiss="modal" value="CANCELAR">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="content cargarPlan">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
						<ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active">
								<a href="#nuevas-1" role="tab" data-toggle="tab">CARGAR PLAN</a>
							</li>
                            <li>
								<a href="#proceso-1" role="tab" data-toggle="tab">VER PLANES</a>
							</li>
                        </ul>

						<div class="card no-shadow m-0">
                            <div class="card-content p-0">
								<div class="tab-content">
									<div class="tab-pane active" id="nuevas-1">
										<form id="form-paquetes" class="formulario">
											<div class="d-flex justify-center align-center">
												<button type="button" data-toggle="modal" onclick="llenarTables();" data-target="#exampleModal" id="btn_open_modal" class="btn-descuentos" rel="tooltip" data-placement="left" title="Ver descuentos"><i class="fas fa-tags" ></i></button>
											</div>
											<div class="container-fluid">
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
														<div class="form-group">
															<label class="m-0" for="sede">Sede (<b class="text-danger">*</b>)</label>
															<select name="sede" id="sede" class="select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
														<div class="form-group">
															<label class="mb-1" for="residencial">Proyecto (<b class="text-danger">*</b>)</label> 
															<select id="residencial" name="residencial[]" multiple="multiple" class="form-control multiSelect"  data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">          
														<div class="form-group">
															<label class="mb-1" for="sede">Rango fechas (<b class="text-danger">*</b>)</label>
															<div class="d-flex" style="height:40px">
																<input class="form-control dates" name="fechainicio" id="fechainicio" type="date" required="true">
																<input class="form-control dates" name="fechafin" id="fechafin" type="date" required="true">
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<label class="mb-1">Tipo de Lote (<b class="text-danger">*</b>):</label>
														<div class="radio-container">
															<input type="radio" id="customRadioInline1" value="1" name="tipoLote">
															<label class="custom-control-label" for="customRadioInline1">Habitacional</label>
															<input type="radio" id="customRadioInline2" value="2" name="tipoLote">
															<label class="custom-control-label" for="customRadioInline2">Comercial</label>
															<input type="radio" id="customRadioInline3" value="3" name="tipoLote">
															<label class="custom-control-label" for="customRadioInline3">Ambos</label>	
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<label class="mb-1">Superficie (<b class="text-danger">*</b>):</label>
														<div class="d-flex w-100">
															<div class="radio-container w-100">
																<input type="radio" id="customRadio1" value="1" name="superficie" onclick="selectSuperficie(1)">
																<label class="custom-control-label" for="customRadio1">Mayor a</label>
																<input type="radio" id="customRadio2" value="2" name="superficie" onclick="selectSuperficie(2)">
																<label class="custom-control-label" for="customRadio2">Rango</label>
																<input type="radio" id="customRadio3" value="3" name="superficie" onclick="selectSuperficie(3)">
																<label class="custom-control-label" for="customRadio3">Cualquiera</label>
															</div>
															<div id="printSuperficie"></div>
														</div>
													</div>
												</div>
												<div class="row mt-4 mb-4" id="showPackage"></div>
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<button type="button" class="btn btn-success btn-circle" onclick="GenerarCard()">Agregar plan<i class="fas fa-plus"></i></button>
														<input type="hidden" value="0" name="index" id="index">
														<button type="submit" id="btn_save" class="btn btn-success">Guardar</button>
													</div>
												</div>
											</div>
										</form>
									</div>
									<div class="tab-pane" id="proceso-1">
										<div class="text-center">
											<h3 class="card-title center-align">Planes cargados</h3>
										</div>
										<div class="toolbar">
											<div class="table-responsive">
												<table class="table-striped table-hover" id="table_planes" name="table_planes">
													<thead>
														<tr>
															<th>SUPERFICIE</th>
															<th>PLAN</th>
															<th>TOTAL</th>
															<th>ENGANCHE</th>
															<th>M2</th>
															<th>BONO</th>
															<th>MSI</th>
															<th>DESARROLLO</th>
															<th>TOT. COM.</th>
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
		<!-- <div id="snackbar"><i class="fas fa-check"></i> ¡MSI agregado con éxito!</div> -->
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
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
		$('[data-toggle="tooltip"]').tooltip();
		const arr = [];
		function OpenModal(tipo,boton){
			if(tipo == 1){
				$('#descuento').val('');
				$('#tdescuento').val(1);
				$('#id_condicion').val(1);
				$('#eng_top').val(0);
				$('#apply').val(1);
				$('#boton').val(boton);
				$('#tipo_d').val(1);
				document.getElementById('label_descuento').innerHTML = 'Agregar descuento al precio total (<b class="text-danger">*</b>):';
			}else if(tipo == 2){
				$('#descuento').val('');
				$('#tdescuento').val(2);
				$('#id_condicion').val(2);
				$('#eng_top').val(0);
				$('#apply').val(0);
				$('#boton').val(boton);
				$('#tipo_d').val(2);
				document.getElementById('label_descuento').innerHTML = 'Agregar descuento al enganche(<b class="text-danger">*</b>):';
			}else if(tipo == 4){
				$('#descuento').val('');
				$('#tdescuento').val(1);
				$('#id_condicion').val(4);
				$('#eng_top').val(0);
				$('#apply').val(1);
				$('#boton').val(boton);
				$('#tipo_d').val(4);
				document.getElementById('label_descuento').innerHTML = 'Agregar descuento al total por M2(<b class="text-danger">*</b>):';
			}else if(tipo == 12){
				$('#descuento').val('');
				$('#tdescuento').val(1);
				$('#id_condicion').val(12);
				$('#eng_top').val(1);
				$('#apply').val(1);
				$('#boton').val(boton);
				$('#tipo_d').val(12);
				document.getElementById('label_descuento').innerHTML = 'Agregar descuento por bono(<b class="text-danger">*</b>):';
			}
			else if(tipo == 13){
				$('#descuento').val('');
				$('#tdescuento').val(1);
				$('#id_condicion').val(13);
				$('#eng_top').val(1);
				$('#apply').val(1);
				$('#boton').val(boton);
				$('#tipo_d').val(13);
				document.getElementById('label_descuento').innerHTML = 'Agregar descuento Meses sin intereses(<b class="text-danger">*</b>):';
			}
			$('#ModalFormAddDescuentos').modal();
		}

		$("input[data-type='currency']").on({
			keyup: function() {
				let tipo_d = $('#tipo_d').val();
					if(tipo_d == 12 || tipo_d == 4){
						formatCurrency($(this));
					}
			},
			blur: function() { 
				let tipo_d = $('#tipo_d').val();
				if(tipo_d == 12 || tipo_d == 4){
					formatCurrency($(this), "blur");
				}
			}
		});

		function formatNumber(n) {
			return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
		}

		function formatCurrency(input, blur) {
			var input_val = input.val();
			if (input_val === "") { return; }
			var original_len = input_val.length;
			var caret_pos = input.prop("selectionStart");
			if (input_val.indexOf(".") >= 0) {
				var decimal_pos = input_val.indexOf(".");
				var left_side = input_val.substring(0, decimal_pos);
				var right_side = input_val.substring(decimal_pos);
				left_side = formatNumber(left_side);
				right_side = formatNumber(right_side);
				if (blur === "blur") {
					right_side += "00";
				}
				right_side = right_side.substring(0, 2);
				input_val = "$" + left_side + "." + right_side;
			} else {
				input_val = formatNumber(input_val);
				input_val = "$" + input_val;
				if (blur === "blur") {
					input_val += ".00";
				}
			}

			input.val(input_val);
			var updated_len = input_val.length;
			caret_pos = updated_len - original_len + caret_pos;
			input[0].setSelectionRange(caret_pos, caret_pos);
		}

		function CloseModalSave(boton){
			$('#ModalFormAddDescuentos').modal('toggle');
			$(`#btn_open_modal#${boton}`).trigger("click");
			document.getElementById('addNewDesc').reset();
			table_total.ajax.reload();
			table_enganche.ajax.reload();
			table_m2.ajax.reload();
			table_bono.ajax.reload();
			table_msi.ajax.reload();
		}

		$("#addNewDesc").on('submit', function(e){ 
			e.preventDefault();
			let boton = $('#boton').val();
			let formData = new FormData(document.getElementById("addNewDesc"));
			$.ajax({
				url: 'SaveNewDescuento',
				data: formData,
				method: 'POST',
				contentType: false,
				cache: false,
				processData:false,
				success: function(data) {	
					if(data == 1){
						CloseModalSave(boton);
						alerts.showNotification("top", "right", "Descuento almacenado correctamente.", "success");	
					}else if(data ==2 ){
						alerts.showNotification("top", "right", "El descuento ingresado, ya existe.", "warning");	
					}
					else{
						alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
					}
				},
				error: function(){
					alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
				},
				async: false
			});
		});

		/**-------------------------TABLAS----------- */
		$('#table_total thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (table_total.column(i).search() !== this.value ) {
						table_total.column(i).search(this.value).draw();
                    }
                });
            }
        });

		$('#table_enganche thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (table_enganche.column(i).search() !== this.value ) {
                        table_enganche.column(i).search(this.value).draw();
                    }
                });
            }
        });

		$('#table_m2 thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (table_m2.column(i).search() !== this.value ) {
                        table_m2.column(i).search(this.value).draw();
                    }
                });
            }
        });

		$('#table_bono thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (table_bono.column(i).search() !== this.value ) {
                        table_bono.column(i).search(this.value).draw();
                    }
                });
            }
        });

		$('#table_msi thead tr:eq(0) th').each( function (i) {
            if(i != 0){
                var title = $(this).text();
                $(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
                $( 'input', this ).on('keyup change', function () {
                    if (table_msi.column(i).search() !== this.value ) {
                        table_msi.column(i).search(this.value).draw();
                    }
                });
            }
        });
		
		function llenarTables(){
			table_total = $("#table_total").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: "auto",
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					title: 'DESCUENTOS AL PRECIO TOTAL',
				}],
				pagingType: "full_numbers",
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
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0"><b>'+d.id_descuento+'</b></p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">'+d.porcentaje+'%</p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">'+d.descripcion+'</p>';
					}
				}],
				columnDefs: [{
					orderable: false,
					className: 'select-checkbox',
					targets:   0,
					searchable:false,
					className: 'dt-body-center'
				}],
				ajax: {
					url: url2 + "PaquetesCorrida/getDescuentos/"+1+"/"+1+"/"+0+"/"+1,
					type: "POST",
					cache: false,
					data: function( d ){}
				},
			});

			//DESCUENTO AL ENGANCHE
			table_enganche = $("#table_enganche").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: "auto",
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					title: 'DESCUENTOS AL ENGANCHE',
				}],
				pagingType: "full_numbers",
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
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0"><b>'+d.id_descuento+'</b></p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						
						return '<p class="m-0">'+d.porcentaje+'%</p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">'+d.descripcion+'</p>';
					}
				}],
				columnDefs: [{
					orderable: false,
					className: 'select-checkbox',
					targets:   0,
					searchable:false,
					className: 'dt-body-center'
				}],
				ajax: {
					url: url2 + "PaquetesCorrida/getDescuentos/"+2+"/"+2+"/"+0+"/"+0,
					type: "POST",
					cache: false,
					data: function( d ){}
				},
			});

			//DESCUENTO AL M2
			table_m2 = $("#table_m2").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: "auto",
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					title: 'DESCUENTOS AL TOTAL POR M2',
				}],
				pagingType: "full_numbers",
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
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0"><b>'+d.id_descuento+'</b></p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">$'+formatMoney(d.porcentaje)+'</p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">'+d.descripcion+'</p>';
					}
				}],
				columnDefs: [{
					orderable: false,
					className: 'select-checkbox',
					targets:   0,
					searchable:false,
					className: 'dt-body-center'
				}],
				ajax: {
					url: url2 + "PaquetesCorrida/getDescuentos/"+1+"/"+4+"/"+0+"/"+1,
					type: "POST",
					cache: false,
					data: function( d ){}
				},
			});

			//DESCUENTO POR BONO
			table_bono = $("#table_bono").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: "auto",
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					title: 'DESCUENTOS POR BONO',
				}],
				pagingType: "full_numbers",
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
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0"><b>'+d.id_descuento+'</b></p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">$'+formatMoney(d.porcentaje)+'</p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">'+ d.descripcion+'</p>';
					}
				}],
				columnDefs: [{
					orderable: false,
					className: 'select-checkbox',
					targets:   0,
					searchable:false,
					className: 'dt-body-center'
				}],
				ajax: {
					url: url2 + "PaquetesCorrida/getDescuentos/"+1+"/"+12+"/"+1+"/"+1,
					type: "POST",
					cache: false,
					data: function( d ){}
				},
			});

			///DESCUENTO MSI
			table_msi = $("#table_msi").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
				width: "auto",
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					title: 'DESCUENTOS MSI',
				}],
				pagingType: "full_numbers",
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
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0"><b>'+d.id_descuento+'</b></p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">'+d.porcentaje+'%</p>';
					}
				},
				{
					"width": "30%",
					"data": function( d ){
						return '<p class="m-0">'+ d.descripcion+'</p>';
					}
				}],
				columnDefs: [{
					orderable: false,
					className: 'select-checkbox',
					targets:   0,
					searchable:false,
					className: 'dt-body-center'
				}],
				ajax: {
					url: url2 + "PaquetesCorrida/getDescuentos/"+1+"/"+13+"/"+1+"/"+1,
					type: "POST",
					cache: false,
					data: function( d ){}
				},
			});
		}

		$('[data-toggle="tooltip"]').tooltip();

		var url = "<?=base_url()?>";
		var url2 = "<?=base_url()?>index.php/";
		var totaPen = 0;
		var tr;

		function formatMoney( n ) {
			var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;
			return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		};

		// function myFunction() {
		// 	// Get the snackbar DIV
		// 	var x = document.getElementById("snackbar");
		// 	// Add the "show" class to DIV
		// 	x.className = "show";
		// 	// After 3 seconds, remove the show class from DIV
		// 	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
		// }

		$(document).ready(function() {
			$.post("<?=base_url()?>index.php/PaquetesCorrida/lista_sedes", function (data) {
				$('[data-toggle="tooltip"]').tooltip()
                var len = data.length;
				$("#sede").append($('<option>').val("").text("Seleccione una opción"));
                for (var i = 0; i < len; i++) {
                    var id = data[i]['id_sede']+','+data[i]['abreviacion'];
                    var name = data[i]['nombre'];
                    $("#sede").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#sede").selectpicker('refresh');
            }, 'json');
			setInitialValues();
        });

		$("#sede").change(function() {
			$('#residencial option').remove();
			var parent = $(this).val();
			var	datos = parent.split(',')
			var	id_sede = datos[0];
			console.log("parent", parent);
			console.log("datos", datos);
			console.log("id_sede", id_sede);

			$.post('getResidencialesList/'+id_sede, function(data) {
                $("#residencial").append($('<option disabled>').val("default").text("Seleccione una opción"));
                var len = data.length;
                for( var i = 0; i<len; i++){
                    var name = data[i]['nombreResidencial'];
                    var id = data[i]['idResidencial'];
                    var descripcion = data[i]['descripcion'];
                    $("#residencial").append(`<option value='${id}'>${name}</option>`);
                }   
                if(len<=0){
                    $("#residencial").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#residencial").selectpicker('refresh');
            }, 'json'); 
		});
		
		$("#residencial").select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown"});
		var id_paquete=0;
		var descripcion='';
		var id_descuento=0;

		function SavePaquete(){
			let formData = new FormData(document.getElementById("form-paquetes"));
			$.ajax({
				url: 'SavePaquete',
				data: formData,
				method: 'POST',
				contentType: false,
				cache: false,
				processData:false,
				success: function(data) {	
					if(data == 1){
						ClearAll();
						alerts.showNotification("top", "right", "Planes almacenados correctamente.", "success");	
					}else{
						alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
					}
				
				},
				error: function(){
					alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
				},
				async: false
			});
		}
		
		$("#form-paquetes").on('submit', function(e){ 
			e.preventDefault();
			$("#ModalAlert").modal();
		});

		function ClearAll(){
			$("#ModalAlert").modal('toggle');
			document.getElementById('form-paquetes').reset();
			$("#sede").selectpicker("refresh");
			$('#residencial option').remove();
			document.getElementById('showPackage').innerHTML = '';
			$('#index').val(0);	
		}
	
		function GenerarCard(){
			// if($('#sede').val() != '' && $('#residencial').val() != '' && $('input[name="tipoLote"]').is(':checked') && $('#fechainicio').val() != '' && $('#fechafin').val() != '' && $('input[name="superficie"]').is(':checked') ){
				var indexActual = document.getElementById('index');
				var indexNext = (document.getElementById('index').value - 1) + 2;
				indexActual.value = indexNext;
				$('#showPackage').append(`
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
					<div class="cardPlan m-0 scroll-styles" id="card_${indexNext}">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="title d-flex justify-center align-center">
										<h3 class="card-title">Plan</h3>
										<button type="button" class="btn-trash" data-toggle="tooltip" data-placement="top" title="Eliminar plan" id="btn_delete_${indexNext}" onclick="removeElementCard('card_${indexNext}')"><i class="fas fa-trash"></i></button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<input type="text" class="inputPlan" required name="descripcion_${indexNext}" id="descripcion_${indexNext}" placeholder="Descripción del plan (*)">
									<div id="checks_${indexNext}">
									</div>						
									<div class="form-group col-md-12" id="tipo_descuento_select_${indexNext}" hidden>
								</div>
							</div>
						</div>
					</div>
				</div>`);

				$('[data-toggle="tooltip"]').tooltip();
				$.post('getResidencialesList', function(data) {
					$("#idResidencial_"+indexNext).append($('<option disabled>').val("default").text("Seleccione una opción"));
					var len = data.length;
			
					for( var i = 0; i<len; i++){
						var name = data[i]['nombreResidencial'];
						var id = data[i]['idResidencial'];
						var descripcion = data[i]['descripcion'];
						$("#idResidencial_"+indexNext).append(`<option value='${id}'>${name}</option>`);
					}

					if(len<=0){
						$("#idResidencial_"+indexNext).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
					}
					$("#idResidencial_"+indexNext).selectpicker('refresh');
				}, 'json');
					
				$("#idResidencial_"+indexNext).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",});

				/**-----------TIPO DESCUENTO------------------ */
				$.post('getTipoDescuento', function(data) {
					$("#tipo_descuento_"+indexNext).append($('<option>').val("default").text("Seleccione una opción"));
					var len = data.length;

					// $('#checks_'+indexNext).append(`<div class="w-100"><label class="mt-2">Descuento a</label></div>`);
					
					for( var i = 0; i<len; i++){
						var id = data[i]['id_tcondicion'];
						var descripcion = data[i]['descripcion'];
						$("#tipo_descuento_"+indexNext).append(`<option value='${id}'>${descripcion}</option>`);
						$("#checks_"+indexNext).append(`
						<div class="row boxAllDiscounts">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="check__item" for="inlineCheckbox1">
									<label>
										<input type="checkbox" class="default__check d-none" id="inlineCheckbox1_${indexNext}_${i}" value="${id}" onclick="PrintSelectDesc(${id},${i},${indexNext})">
										${descripcion}
										<span class="custom__check"></span>
									</label>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="boxDetailDiscount">
									<div class="w-100 mb-1" id="selectDescuentos_${indexNext}_${i}"></div>
									<div class="container-fluid">
										<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"></div>
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pr-0"><p class="m-0 txtMSI">msi</p></div>
									</div>
									<div class="container-fluid rowDetailDiscount" id="listamsi_${indexNext}_${i}">
									</div>
								</div>
							</div>
						</div>`);
					}

					if(len<=0){
						$("#tipo_descuento_"+indexNext).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
					}
					$("#tipo_descuento_"+indexNext).selectpicker('refresh');
				}, 'json');

				$('.popover-dismiss').popover({
					trigger: 'focus'
				});
			// }
			// else{
			// 	alerts.showNotification("top", "left", "Debe llenar todos los campos requeridos.", "warning");
			// }
		}

		function ValidarOrden(indexN,i){
			let seleccionado = $(`#orden_${indexN}_${i}`).val();	
			for (let m = 0; m < 4; m++) {
				if(m != i){
					if( $(`#orden_${indexN}_${m}`).val() == seleccionado && seleccionado != ""){
						$(`#orden_${indexN}_${i}`).val("");
						alerts.showNotification("top", "left", "Este número ya se ha seleccionado.", "warning");
					}	
				}
			}
		}

		function validarMsi(indexN,i){
			let valorIngresado = $(`#input_msi_${indexN}_${i}`).val();
			if(valorIngresado < 1){
				$(`#btn_save_${indexN}_${i}`).prop( "disabled", true );
			}
			else{
				$(`#btn_save_${indexN}_${i}`).prop( "disabled", false );
			}
		}

		function ModalMsi(indexN,i,select,id,text,pesos = 0){
			const Modalbody = $('#ModalMsi .modal-body');
			const Modalfooter = $('#ModalMsi .modal-footer');
			Modalbody.html('');
			Modalfooter.html('');
			Modalbody.append(`
			<h4>¿Este descuento tiene meses sin intereses?</h4>
			<div class="row text-center">
				<div class="col-md-12 text-center"></div>
				<div class="col-md-10 text-center">
					<div class="form-group text-center">
						<input type="number" placeholder="Cantidad" onkeyup="validarMsi(${indexN},${i})" class="input-descuento" id="input_msi_${indexN}_${i}">
					</div>
				</div>
			</div>`);

			Modalbody.append(`
			<div class="row text-center">
				<div class="col-md-6">
					<button class="btn btn-success btn-circle btn-lg" data-toggle="tooltip" data-placement="left" title="Agregar MSI"  disabled onclick="AddMsi(${indexN},${i},'${select}',${id},${text},${pesos});" name="disper_btn"  id="btn_save_${indexN}_${i}"><i class="fas fa-check"></i></button>
				</div>
				<div class="col-md-6">
					<button class="btn btn-danger btn-circle btn-lg" data-toggle="tooltip" data-placement="right" title="No tiene MSI" data-dismiss="modal"><i class="fas fa-times"></i></button>
				</div>
			</div>`);

			$("#ModalMsi").modal();
			$('[data-toggle="tooltip"]').tooltip()
		}

		function otra(indexN,i,select,id,text2){
			$(`#${select}${indexN}_${i}`).on(async function (evt){
				var s = document.getElementById(id);
			});
		}

		function AddMsi(indexN,i,select,id,text2,pesos = 0){
			let valorMsi = $(`#input_msi_${indexN}_${i}`).val();
			let selecdes = $(`#${select}${indexN}_${i}`);
			let texto = pesos != 0 ? '$'+formatMoney(text2) : text2;
			$(`#listamsi_${indexN}_${i}`).append(`
			<span class="label label-success color_span" id="${indexN}_${id}_span" >${texto}% + ${valorMsi} MSI</span>
			<input type="hidden" name="${indexN}_${id}_msi" id="${indexN}_${id}_msi" value="${id},${valorMsi}">`);

			// CloseModalMsi();
			// myFunction();
			
			let idDescuentoSeleccionado = $(`#${select}${indexN}_${i} option:selected`).val();
			let TextDescuentoSeleccionado = $(`#${select}${indexN}_${i} option:selected`).text();
		}


		// function CloseModalMsi(){
		// 	const Modalbody = $('#ModalMsi .modal-body');
		// 	const Modalfooter = $('#ModalMsi .modal-footer');
		// 	Modalbody.html('');
		// 	Modalfooter.html('');
		// 	$("#ModalMsi").modal('toggle');
		// }

		function PrintSelectDesc(id,index,indexGral){
			let tdescuento=0;
			let id_condicion=0;
			let eng_top=0;
			let apply=0;

			if(id == 1){
				if($(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked')){	
					$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
					tdescuento=1;
					id_condicion=1;
					apply=1;			
					///TOTAL DE LOTE
					$(`#selectDescuentos_${indexGral}_${index}`).append(`
					<div class="w-100 d-flex justify-center align-center">
						<div id="divmsi_${indexGral}_${index}"></div>
						<select id="ListaDescuentosTotal_${indexGral}_${index}" required name="${indexGral}_${index}_ListaDescuentosTotal_[]" multiple class="form-control" required data-live-search="true"></select>
					</div>`);

					$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
						$(`#ListaDescuentosTotal_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
						var len = data.length;
						for( var i = 0; i<len; i++){
							var name = data[i]['porcentaje'];
							var id = data[i]['id_descuento'];
							$(`#ListaDescuentosTotal_${indexGral}_${index}`).append(`<option value='${id}' label="${name}">${name}%</option>`);
						}
						if(len<=0){
							$(`#ListaDescuentosTotal_${indexGral}_${index}`).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
						}
						$(`#ListaDescuentosTotal_${indexGral}_${index}`).selectpicker('refresh');
					}, 'json');

					$(`#ListaDescuentosTotal_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown", tags: false, tokenSeparators: [',', ' '], closeOnSelect : false, placeholder : "Seleccione una opción", allowHtml: true, allowClear: true});

					$(`#ListaDescuentosTotal_${indexGral}_${index}`).on("select2:select", function (evt){
						var element = evt.params.data.element;
						var $element = $(element);
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
						crearBoxDetailDescuentos(indexGral,index,'ListaDescuentosTotal_',$element[0].value,$element[0].label);
					});

					$(`#ListaDescuentosTotal_${indexGral}_${index}`).on("select2:unselecting", function (evt){
						var element = evt.params.args.data.element;
						var $element = $(element);
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
						var classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
						if(classnameExists == true){
							document.getElementById(`${indexGral}_${$element[0].value}_msi`).outerHTML = "";
							document.getElementById(`${indexGral}_${$element[0].value}_span`).outerHTML = "";
						}
					});
				}
				else{
					$(`#orden_${indexGral}_${index}`).val("");
					$(`#orden_${indexGral}_${index}`).prop( "disabled", true );
					document.getElementById(`selectDescuentos_${indexGral}_${index}`).innerHTML = "";
					document.getElementById(`listamsi_${indexGral}_${index}`).innerHTML = "";
				}
			}
			else if(id == 2){
				if( $(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked') ) {	
					$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
					tdescuento=2;
					id_condicion=2;		
				
					///TOTAL DE ENGANCHE
					$(`#selectDescuentos_${indexGral}_${index}`).append(`
					<div class="w-100 d-flex justify-center align-center">
						<select id="ListaDescuentosEnganche_${indexGral}_${index}" required  name="${indexGral}_${index}_ListaDescuentosEnganche_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
					</div>`);

					$(`#ListaDescuentosEnganche_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",	});
					$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
						$(`#ListaDescuentosEnganche_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
						var len = data.length;
						for( var i = 0; i<len; i++){
							var name = data[i]['porcentaje'];
							var id = data[i]['id_descuento'];
							$(`#ListaDescuentosEnganche_${indexGral}_${index}`).append(`<option value='${id}' label="${name}">${name}%</option>`);
						}
						if(len<=0){
							$(`#ListaDescuentosEnganche_${indexGral}_${index}`).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
						}
						$(`#ListaDescuentosEnganche_${indexGral}_${index}`).selectpicker('refresh');
					}, 'json');
				
					$(`#ListaDescuentosEnganche_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true });
					$(`#ListaDescuentosEnganche_${indexGral}_${index}`).on("select2:select", function (evt) {
						var element = evt.params.data.element;
						var $element = $(element);
						
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
						crearBoxDetailDescuentos(indexGral,index,'ListaDescuentosEnganche_',$element[0].value,$element[0].label);
					});

					$(`#ListaDescuentosEnganche_${indexGral}_${index}`).on("select2:unselecting", function (evt){
						var element = evt.params.args.data.element;
						var $element = $(element);
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
						var classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
						if(classnameExists == true){
							document.getElementById(`${indexGral}_${$element[0].value}_msi`).outerHTML = "";
							document.getElementById(`${indexGral}_${$element[0].value}_span`).outerHTML = "";
						}
					});
				}
				else{
					$(`#orden_${indexGral}_${index}`).val("");
					$(`#orden_${indexGral}_${index}`).prop( "disabled", true );
					document.getElementById(`selectDescuentos_${indexGral}_${index}`).innerHTML = "";
					document.getElementById(`listamsi_${indexGral}_${index}`).innerHTML = "";
				}
			}else if(id == 5){
				//Descuentos m2
				if( $(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked') ) {
					$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
			
					tdescuento=1;
					id_condicion=4;
					apply=1;			
				
					$(`#selectDescuentos_${indexGral}_${index}`).append(`
					<div class="w-100 d-flex justify-center align-center">
						<select id="ListaDescuentosM2_${indexGral}_${index}" required name="${indexGral}_${index}_ListaDescuentosM2_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
					</div>`);

					$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
						$(`#ListaDescuentosM2_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
						var len = data.length;
						for( var i = 0; i<len; i++){
							var name = data[i]['porcentaje'];
							var id = data[i]['id_descuento'];
							$(`#ListaDescuentosM2_${indexGral}_${index}`).append(`<option value='${id}' label="${name}">$${formatMoney(name)}</option>`);
						}
						if(len<=0){
							$(`#ListaDescuentosM2_${indexGral}_${index}`).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
						}
						$(`#ListaDescuentosM2_${indexGral}_${index}`).selectpicker('refresh');
					}, 'json');

					$(`#ListaDescuentosM2_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true	});
					$(`#ListaDescuentosM2_${indexGral}_${index}`).on("select2:select", function (evt) {
						var element = evt.params.data.element;
						var $element = $(element);
						
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
						crearBoxDetailDescuentos(indexGral,index,'ListaDescuentosM2_',$element[0].value,$element[0].label,1);
					});

					$(`#ListaDescuentosM2_${indexGral}_${index}`).on("select2:unselecting", function (evt){
						var element = evt.params.args.data.element;
						var $element = $(element);
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
						var classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
						if(classnameExists == true){
							document.getElementById(`${indexGral}_${$element[0].value}_msi`).outerHTML = "";
							document.getElementById(`${indexGral}_${$element[0].value}_span`).outerHTML = "";
						}
					});
				}else{
					$(`#orden_${indexGral}_${index}`).val("");
					$(`#orden_${indexGral}_${index}`).prop( "disabled", true );
					document.getElementById(`selectDescuentos_${indexGral}_${index}`).innerHTML = "";
					document.getElementById(`listamsi_${indexGral}_${index}`).innerHTML = "";
				}
			}
			else if(id == 12){
				//Bono
				if( $(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked') ) {	
					$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
					tdescuento=1;
					id_condicion=12;
					eng_top=1;
					apply=1;			
					
					///TOTAL DE ENGANCHE
					$(`#selectDescuentos_${indexGral}_${index}`).append(`
					<div class="w-100 d-flex justify-center align-center">
						<select id="ListaDescuentosBono_${indexGral}_${index}" required name="${indexGral}_${index}_ListaDescuentosBono_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
					</div>`);

					$(`#ListaDescuentosBono_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true});
					$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
						$(`#ListaDescuentosBono_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
						var len = data.length;
						for( var i = 0; i<len; i++){
							var name = data[i]['porcentaje'];
							var id = data[i]['id_descuento'];
							$(`#ListaDescuentosBono_${indexGral}_${index}`).append(`<option value='${id}' label="${name}">$${formatMoney(name)}</option>`);
						}
						if(len<=0){
							$(`#ListaDescuentosBono_${indexGral}_${index}`).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
						}
						$(`#ListaDescuentosBono_${indexGral}_${index}`).selectpicker('refresh');
					}, 'json');

					$(`#ListaDescuentosBono_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true });
					$(`#ListaDescuentosBono_${indexGral}_${index}`).on("select2:select", function (evt) {
						var element = evt.params.data.element;
						var $element = $(element);
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
						crearBoxDetailDescuentos(indexGral,index,'ListaDescuentosBono_',$element[0].value,$element[0].label,1);
					});

					$(`#ListaDescuentosBono_${indexGral}_${index}`).on("select2:unselecting", function (evt){
						var element = evt.params.args.data.element;
						var $element = $(element);
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
						var classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
						if(classnameExists == true){
							document.getElementById(`${indexGral}_${$element[0].value}_msi`).outerHTML = "";
							document.getElementById(`${indexGral}_${$element[0].value}_span`).outerHTML = "";
						}
					});
				}else{
					$(`#orden_${indexGral}_${index}`).val("");
					$(`#orden_${indexGral}_${index}`).prop( "disabled", true );
					document.getElementById(`selectDescuentos_${indexGral}_${index}`).innerHTML = "";
					document.getElementById(`listamsi_${indexGral}_${index}`).innerHTML = "";
				}
			}
			else if(id == 13){
				//MSI
				if( $(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked') ) {	
					$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
					tdescuento=1;
					id_condicion=13;
					eng_top=1;
					apply=1;			
					
					///TOTAL DE ENGANCHE
					$(`#selectDescuentos_${indexGral}_${index}`).append(`
					<div class="w-100 d-flex justify-center align-center">
						<select id="ListaDescuentosMSI_${indexGral}_${index}" required name="${indexGral}_${index}_ListaDescuentosMSI_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
					</div>`);
					
					$(`#ListaDescuentosMSI_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true});
					$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
						$(`#ListaDescuentosMSI_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
						var len = data.length;
						for( var i = 0; i<len; i++){
							var name = data[i]['porcentaje'];
							var id = data[i]['id_descuento']+','+data[i]['porcentaje'];
							$(`#ListaDescuentosMSI_${indexGral}_${index}`).append(`<option value='${id}' label="${name}">${name}%</option>`);
						}
						if(len<=0){
							$(`#ListaDescuentosMSI_${indexGral}_${index}`).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
						}
						$(`#ListaDescuentosMSI_${indexGral}_${index}`).selectpicker('refresh');
					}, 'json');
					$(`#ListaDescuentosMSI_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true	});
					$(`#ListaDescuentosMSI_${indexGral}_${index}`).on("select2:select", function (evt) {
						var element = evt.params.data.element;
						var $element = $(element);
						$element.detach();
						$(this).append($element);
						$(this).trigger("change");
					});
				}else{
					$(`#orden_${indexGral}_${index}`).val("");
					$(`#orden_${indexGral}_${index}`).prop( "disabled", true );
					document.getElementById(`selectDescuentos_${indexGral}_${index}`).innerHTML = "";
					document.getElementById(`listamsi_${indexGral}_${index}`).innerHTML = "";
				}
			}
		}

		function changeTipoDescuento(index){
			let tipoDescuento = $('#tipo_descuento_'+index).val();
			document.getElementById("tipo_descuento_select_"+index).innerHTML ='';
			if(tipoDescuento == 1){
				//TOTAL LOTE
				$('#tipo_descuento_select_'+index).append(`cacacac`);
			}else if(tipoDescuento == 2){
				//ENGANCHE
			}else if(tipoDescuento == 4){
				//M2
			}else if(tipoDescuento == 12){
				//BONO
			}
		}	 

		function selectSuperficie(tipoSup){
			document.getElementById("printSuperficie").innerHTML ='';
			if(tipoSup == 1){
				$('#printSuperficie').append(`
					<input type="number" class="form-control input-gral" name="fin" placeholder="Mayor a">
					<input type="hidden" class="form-control" value="0" name="inicio">`);
				}
			else if(tipoSup == 2){
				$('#printSuperficie').append(`
				<input type="number" class="form-control input-gral" name="fin" placeholder="Menor a">
					<input type="hidden" class="form-control" value="0" name="inicio">`);
			}
			else if(tipoSup == 3){
				$('#printSuperficie').append(`
				<input type="hidden" class="form-control" name="inicio" value="0">
				<input type="hidden" class="form-control" name="fin" value="0">`);
			}	
		}

		function RemovePackage(){
			let divNum = $('#iddiv').val();
			$('#ModalRemove').modal('toggle');
			$("#" + divNum + "").remove();
			$('#iddiv').val(0);
			return false;
		}

		function removeElementCard(divNum) {
			$('#iddiv').val(divNum);
			$('#ModalRemove').modal('show');
		}

		function crearBoxDetailDescuentos(indexN,i,select,id,text,pesos = 0){
			// let valorMsi = $(`#input_msi_${indexN}_${i}`).val();
			// let selecdes = $(`#${select}${indexN}_${i}`);
			let texto = pesos == 2 ? text : (pesos == 1 ? '$'+formatMoney(text) : text + '%');
			$(`#listamsi_${indexN}_${i}`).append(`
				<div class="row d-flex align-center mb-1" id="${indexN}_${id}_span">
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 d-flex align-center">
						<i class="fas fa-tag mr-1"></i><p class="m-0">${texto}</p>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="boxOnOff">
							<input type="checkbox" id="${indexN}_${id}_msi" name="${indexN}_${id}_msi" class="switch-input d-none">
							<label for="${indexN}_${id}_msi" class="switch-label"></label>
							<input type="" value="0" id="iddiv" class="inputMSI">
						</div>
					</div>
				</div>`);

			// CloseModalMsi();
			// myFunction();
			
			// let idDescuentoSeleccionado = $(`#${select}${indexN}_${i} option:selected`).val();
			// let TextDescuentoSeleccionado = $(`#${select}${indexN}_${i} option:selected`).text();
		}

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
			finalBeginDate2 = [('0' + beginDate.getDate()).slice(-2), ('0' + (beginDate.getMonth() + 1)).slice(-2), beginDate.getFullYear()].join('/');
			finalEndDate2 = [('0' + endDate.getDate()).slice(-2), ('0' + (endDate.getMonth() + 1)).slice(-2), endDate.getFullYear()].join('/');

			$('#beginDate').val(finalBeginDate2);
			$('#endDate').val(finalEndDate2);
			$('#beginDate2').val(finalBeginDate2);
			$('#endDate2').val(finalEndDate2);
		}
	</script>
</body>