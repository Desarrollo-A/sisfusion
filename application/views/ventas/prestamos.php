<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
	<div class="wrapper">
	<?php $this->load->view('template/sidebar'); ?>


		<!-- Modals -->
		<!--<div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					<form method="post" id="form_espera_uno">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
				</div>
			</div>
		</div>-->

		<div class="modal fade modal-alertas" id="miModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-red">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">PRESTAMOS</h4>
					</div>
					<form method="post" id="form_prestamos">
						<div class="modal-body">
							<div class="form-group">
								<label class="label">Puesto del usuario</label>
								<select class="selectpicker select-gral" name="roles" id="roles"
								 title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
									<option value="7">Asesor</option>
									<option value="9">Coordinador</option>
									<option value="3">Gerente</option>
									<option value="2">Sub director</option>      
								</select>
							</div>
							<div class="form-group" id="users"></div>
							<div class="form-group row">
								<div class="col-md-4">
									<label class="label">Monto prestado</label>
									<input class="form-control" type="text" onblur="verificar();" id="monto" name="monto">
								</div>
								<div class="col-md-4">
									<label class="label">Numero de pagos</label>
									<input class="form-control" id="numeroP" type="number" name="numeroP">
								</div>
								<div class="col-md-4">
									<label class="label">Pago</label>
									<input class="form-control" id="pago" type="text" name="pago" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="label">Comentario</label>
								<textarea id="comentario" name="comentario" class="form-control" rows="3"></textarea>
							</div>

							<div class="form-group">
								<center>
									<button type="submit" id="btn_abonar" class="btn btn-success">GUARDAR</button>
									<button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
								</center>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!--<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body"></div>
				</div>
			</div>
		</div>-->

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="material-icons">dashboard</i>
                            </div>
							<div class="card-content">
								<h3 class="card-title center-align">Préstamos</h3>
								<div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Préstamos activos:</h4>
                                                    <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                                </div>
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group d-flex justify-center align-center">
													<button ype="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Agregar</button>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
								<div class="material-datatables">
									<div class="form-group">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tabla_prestamos" name="tabla_prestamos">
												<thead>
													<tr>
														<th>USUARIO</th>
														<th>MONTO</th>
														<th>NUM. PAGOS</th>
														<th>PAGO CORRESPONDIENTE</th>
														<th>ESTATUS</th>
														<th>FECHA DE REGISTRO</th>
														<th>MÁS</th>
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
	</div>
	<?php $this->load->view('template/footer');?>
	<script>
		var url = "<?=base_url()?>";
		var url2 = "<?=base_url()?>index.php/";
		var totaPen = 0;
		var tr;

		function closeModalEng(){
			document.getElementById("form_prestamos").reset();
			$("#miModal").modal('toggle');	
		}

		$("#form_prestamos").on('submit', function(e){ 
			e.preventDefault();
			let formData = new FormData(document.getElementById("form_prestamos"));
			formData.append("dato", "valor");
			$.ajax({
				url: 'savePrestamo',
				data: formData,
				method: 'POST',
				contentType: false,
				cache: false,
				processData:false,
				success: function(data) {
					if (data == 1) {
						$('#tabla_prestamos').DataTable().ajax.reload(null, false);
						closeModalEng();
						$('#miModal').modal('hide');
						alerts.showNotification("top", "right", "Prestamo registrado con exito.", "success");
						document.getElementById("form_abono").reset();
					
					} else if(data == 2) {
						$('#tabla_prestamos').DataTable().ajax.reload(null, false);
						closeModalEng();
						$('#miModal').modal('hide');
						alerts.showNotification("top", "right", "Pago liquidado.", "warning");
					}else if(data == 3){
						closeModalEng();
						$('#miModal').modal('hide');
						alerts.showNotification("top", "right", "El usuario seleccionado ya tiene un prestamo activo.", "warning");
					}
				},
				error: function(){
					alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
				}
			});
		});

		$("#tabla_prestamos").ready( function(){
			let titulos = [];

			$('#tabla_prestamos thead tr:eq(0) th').each( function (i) {
				if(  i!=6){
					var title = $(this).text();
					titulos.push(title);
					$(this).html('<input type="text" class="textoshead" placeholder="'+title+'"/>' );
					$( 'input', this ).on('keyup change', function () {
						if (tabla_nuevas.column(i).search() !== this.value ) {
							tabla_nuevas.column(i).search(this.value).draw();

							var total = 0;
							var index = tabla_nuevas.rows({ selected: true, search: 'applied' }).indexes();
							var data = tabla_nuevas.rows( index ).data();
							$.each(data, function(i, v){
								total += parseFloat(v.monto);
							});
							var to1 = formatMoney(total);
							document.getElementById("totalp").textContent = total;
							console.log('fsdf'+total);
						}
					});
				}
			});

			$('#tabla_prestamos').on('xhr.dt', function ( e, settings, json, xhr ) {
				var total = 0;
				$.each(json.data, function(i, v){
					total += parseFloat(v.monto);
				});
				var to = formatMoney(total);
				document.getElementById("totalp").textContent = '$' + to;
			});


			tabla_nuevas = $("#tabla_prestamos").DataTable({
				dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
				buttons: [{
					extend: 'excelHtml5',
					text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
					className: 'btn buttons-excel',
					titleAttr: 'Descargar archivo de Excel',
					titleAttr: 'Excel',
					exportOptions: {
						columns: [0,1,2,3,4,5],
						format: {
							header:  function (d, columnIdx) {
								if(columnIdx >= 0){
									return ' '+titulos[columnIdx] +' ';
								}  
							}
						}
					}
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
					"width": "9%",
					"data": function( d ){
						return '<p class="m-0">'+d.nombre+'</p>';
					}
				},
				{
					"width": "9%",
					"data": function( d ){
						return '<p class="m-0">$'+formatMoney(d.monto)+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.num_pagos+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+formatMoney(d.pago)+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){

						if(d.estatus == 1){
							return '<span class="label label-danger" style="background:#27AE60">ACTIVO</span>';
						}else{
							return '<span class="label label-danger" style="background:#27AE60">LIQUIDADO</span>';
						}

						
					} 
				},
				{
					"width": "12%",
					"data": function( d ){
						return '<p class="m-0">'+d.fecha_creacion+'</p>';
					}
				},
				{
					"width": "6%",
					"orderable": false,
					"data": function( d ){
						return '';
					}
				}],
				ajax: {
					url: url2 + "Comisiones/getPrestamos",
					type: "POST",
					cache: false,
					data: function( d ){
					}
				},
			});
		});

		/*function mandar_espera(idLote, nombre) {
			idLoteespera = idLote;
			link_espera1 = "Comisiones/generar comisiones/";
			$("#myModalEspera .modal-footer").html("");
			$("#myModalEspera .modal-body").html("");
			$("#myModalEspera ").modal();
			$("#myModalEspera .modal-footer").append("<div class='btn-group'><button type='submit' class='btn btn-success'>GENERAR COMISIÓN</button></div>");
		}*/

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


		$("#roles").change(function() {
			var parent = $(this).val();
			document.getElementById("users").innerHTML ='';

			$('#users').append(` 
			<label class="label">Usuario</label>   
			<select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true">
			</select>
			`);
			$.post('getUsuariosRol/'+parent, function(data) {
				$("#usuarioid").append($('<option disabled>').val("default").text("Seleccione una opción"))
				var len = data.length;
				for( var i = 0; i<len; i++){
					var id = data[i]['id_usuario'];
					var name = data[i]['name_user'];
					$("#usuarioid").append($('<option>').val(id).attr('data-value', id).text(name));
				}

				if(len<=0){
				$("#usuarioid").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
				}
				
				$("#usuarioid").selectpicker('refresh');
			}, 'json'); 
		});

		$("#numeroP").blur(function(){
			let monto = parseFloat($('#monto').val());
			let cantidad = parseFloat($('#numeroP').val());
			let resultado=0;

			if (cantidad < 1 || isNaN(monto)) {
				alerts.showNotification("top", "right", "Debe ingresar una canitdad mayor a 0.", "warning");
				document.getElementById('btn_abonar').disabled=true;
				$('#pago').val(resultado);
			}
			else{
				resultado = monto /cantidad;
				$('#pago').val(formatMoney(resultado));
			}
		});

		function verificar(){
			let monto = parseFloat($('#monto').val());
			if(monto < 1 || isNaN(monto)){
				alerts.showNotification("top", "right", "Debe ingresar un monto mayor a 0.", "warning");
				document.getElementById('btn_abonar').disabled=true;
			}
			else{
				let cantidad = parseFloat($('#numeroP').val());
				resultado = monto /cantidad;
				$('#pago').val(formatMoney(resultado));
				document.getElementById('btn_abonar').disabled=false;
			}
		}
	</script>
</body>