<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
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
								<select class="selectpicker" name="roles" id="roles" required>
									<option value="">----Seleccionar-----</option>
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
									<input class="form-control" type="text" required onblur="verificar();" id="monto" name="monto">
								</div>
								<div class="col-md-4">
									<label class="label">Número de pagos</label>
									<input class="form-control" id="numeroP" required onblur="verificar();" type="number" name="numeroP">
								</div>
								<div class="col-md-4">
									<label class="label">Pago</label>
									<input class="form-control" id="pago" required type="text" name="pago" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="label">Comentario</label>
								<textarea id="comentario" name="comentario" required class="form-control" rows="3"></textarea>
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

        <div class="modal fade modal-alertas"
             id="detalle-prestamo-modal"
             role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

		<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body"></div>
				</div>
			</div>
		</div>

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
														<th>ID USUARIO</th>
														<th>USUARIO</th>
														<th>MONTO</th>
														<th>NUM. PAGOS</th>
														<th>PAGO CORRESPONDIENTE</th>
														<th>ABONADO</th>
														<th>PENDIENTE</th>
														<th>COMENTARIO</th>
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
		var url = "<?=base_url()?>";
		var url2 = "<?=base_url()?>index.php/";
		var totaPen = 0;
		var tr;

		function closeModalEng(){
			document.getElementById("form_prestamos").reset();
			$("#miModal").modal('toggle');	
		}

		function replaceAll(text, busca, reemplaza) {
            while (text.toString().indexOf(busca) != -1)
                text = text.toString().replace(busca, reemplaza);
            return text;
        }

		$("#form_prestamos").on('submit', function(e){ 
			e.preventDefault();
			let formData = new FormData(document.getElementById("form_prestamos"));
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
				if(  i!=10){
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
							document.getElementById("totalp").textContent = '$' + to1;
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
						columns: [0,1,2,3,4,5,6,7,8,9],
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
				columns: [
					
					{
					"width": "3%",
					"data": function( d ){
						return '<p class="m-0">'+d.id_usuario+'</p>';
					}
				},	
					{
					"width": "13%",
					"data": function( d ){
						return '<p class="m-0"><b>'+d.nombre+'</b></p>';
					}
				},
				{
					"width": "7%",
					"data": function( d ){
						return '<p class="m-0"><b>$'+formatMoney(d.monto)+'</b></p>';
					}
				},
				{
					"width": "2%",
					"data": function( d ){
						return '<p class="m-0">'+d.num_pagos+'</p>';
					}
				},
				{
					"width": "5%",
					"data": function( d ){
						return '<p class="m-0">$'+formatMoney(d.pago_individual)+'</p>';
					}
				},
				{
					"width": "7%",
					"data": function( d ){
						return '<p class="m-0">$'+formatMoney(d.total_pagado)+'</p>';
					}
				},
				{
					"width": "7%",
					"data": function( d ){
						let color = 'black';
						let resultado  = d.monto - d.total_pagado;
						if(resultado > 0.5){
							color='orange';
						}
						if(resultado < 0.0){
							resultado=0;
						}
						return '<p class="m-0" style="color:'+color+'">$'+formatMoney(resultado)+'</p>';
					}
				},
				{
					"width": "10%",
					"data": function( d ){
						return '<p class="m-0">'+d.comentario+'</p>';
					}
				},
				{
					"width": "6%",
					"data": function( d ){

						if(d.estatus == 1){
							return '<span class="label label-danger" style="background:dodgerblue">ACTIVO</span>';
						}else{
							return '<span class="label label-danger" style="background:#27AE60">LIQUIDADO</span>';
						}

						
					} 
				},
				{
					"width": "12%",
					"data": function( d ){

						let f = d.fecha_creacion.split('.');
						//let fecha = new Date(f[0].replace(/-/g,"/"));

						return '<p class="m-0">'+f[0]+'</p>';
					}
				},
				{
					"width": "6%",
					"orderable": false,
					"data": function( d ){
                        return '<button href="#" value="'+d.id_prestamo+'" class="btn-data btn-blueMaderas detalle-prestamo" title="Hitorial"><i class="fas fa-info"></i></button>';
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

            $('#tabla_prestamos tbody').on('click', '.detalle-prestamo', function () {
                const idPrestamo = $(this).val();

                $.getJSON(`${url}Comisiones/getDetallePrestamo/${idPrestamo}`).done(function (data) {
                    const { general, detalle } = data;

                    if (general.length === 0) {
                        alerts.showNotification("top", "right", "No hay préstamos.", "warning");
                    } else {
                        const detalleHeaderModal = $('#detalle-prestamo-modal .modal-header');
                        const detalleBodyModal = $('#detalle-prestamo-modal .modal-body');

                        detalleHeaderModal.html('');
                        detalleBodyModal.html('');

                        detalleHeaderModal.append('<h4 class="card-title"><b>Detalle del préstamo</b></h4>');
                        detalleBodyModal.append(`
                            <div class="row">
                                <div class="col col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <h6>USUARIO: <b>${ general.nombre_completo }</b></h6>
                                </div>
                                <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <h6>PAGO MENSUAL: <b>$${formatMoney(general.pago_individual)}</b></h6>
                                </div>
                                <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <h6>PAGOS: <b>${general.num_pago_act} / ${general.num_pagos}</b></h6>
                                </div>
                                <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <h6>MONTO PRESTADO: <b>$${formatMoney(general.monto_prestado)}</b></h6>
                                </div>
                                <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <h6>ABONADO: <b style="color:green;">$${formatMoney(general.total_pagado)}</b></h6>
                                </div>
                                <div class="col col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <h6>PENDIENTE: <b style="color:orange;">$${formatMoney(general.pendiente)}</b></h6>
                                </div>
                            </div>
                        `);

                        let htmlTableBody = '';
                        for (let i = 0; i < detalle.length; i++) {
                            htmlTableBody += '<tr>';
                            htmlTableBody += `<td scope="row">${detalle[i].np}</td>`;
                            htmlTableBody += `<td>${detalle[i].nombreLote}</td>`;
                            htmlTableBody += `<td>${detalle[i].comentario}</td>`;
                            htmlTableBody += `<td>${detalle[i].fecha_pago}</td>`;
                            htmlTableBody += `<td>$${formatMoney(detalle[i].abono_neodata)}</td>`;
                            htmlTableBody += '</tr>';
                        }

                        detalleBodyModal.append(`
                            <div style="margin-top: 20px;" class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Lote</th>
                                            <th>Comentario</th>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${htmlTableBody}
                                    </tbody>
                                </table>
                            </div>
                        `);

                        $("#detalle-prestamo-modal").modal();
                    }
                });
            });
		});


		$(window).resize(function(){
			tabla_nuevas.columns.adjust();
		});

		function formatMoney( n ) {
			var c = isNaN(c = Math.abs(c)) ? 2 : c,
				d = d == undefined ? "." : d,
				t = t == undefined ? "," : t,
				s = n < 0 ? "-" : "",
				i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
				j = (j = i.length) > 3 ? j % 3 : 0;
			return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		}


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

	/*	$("#numeroP").blur(function(){
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
		});*/

		function verificar(){
			
			console.log($('#monto').val());
			let monto = parseFloat(replaceAll($('#monto').val(), ',','')); 
			
			if($('#numeroP').val() != '')
			{
					if(monto < 1 || isNaN(monto))
					{
						alerts.showNotification("top", "right", "Debe ingresar un monto valido.", "warning");
						document.getElementById('btn_abonar').disabled=true;
					}
					else
					{
						console.log($('#numeroP').val());

						let cantidad = parseFloat(replaceAll($('#numeroP').val(), ',',''));
						console.log(cantidad);
						resultado = parseFloat(monto /cantidad);
						$('#pago').val(formatMoney(parseFloat(resultado)));
						console.log(resultado);
						document.getElementById('btn_abonar').disabled=false;
					}
			}
			
		}
	</script>
</body>