<body>
<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>
    <div class="content">
        <div class="container-fluid">

            <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="block full">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                    <i class="material-icons">list</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Bonificaciones</h4>
                                    <div class="header text-center">
                                        </p>
                                    </div>
									<div class="container-fluid">
										<form name="formBonificaciones" id="formBonificaciones" method="POST" action="<?=base_url()?>index.php/clientes/saveBonificacion">
											<div class="row">
												<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 frmDivCliente">
													<label id="lblDataCl">DATOS CLIENTE RECOMENDADO</label>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="form-group label-floating">
																<label class="control-label">
																	Nombre
																	<small>*</small>
																</label>
																<input type="text" required class="form-control"
																	   name="nombreClienteRecomendado" id="nombreClienteRecomendado" required>
															</div>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="form-group label-floating">
																<label class="control-label">
																	Apellido Paterno
																	<small>*</small>
																</label>
																<input type="text" required class="form-control"
																	   name="apellidoPaterno" id="apellidoPaterno" required>
															</div>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="form-group label-floating">
																<label class="control-label">
																	Apellido Materno
																	<small>*</small>
																</label>
																<input type="text" required class="form-control"
																	   name="apellidoMaterno" id="apellidoMaterno" required>
															</div>
														</div>
													</div>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 pdt-30">
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<select required="required" data-live="search" name="proyectoRecomendado" id="proyectoRecomendado"
																	class="selectpicker" data-show-subtext="true" data-live-search="true"
																	data-style="btn" title="PROYECTO" data-size="7" required>
															</select>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<select required="required" data-live="search" name="condominioRecomendado" id="condominioRecomendado"
																	class="selectpicker" data-show-subtext="true" data-live-search="true"
																	data-style="btn" title="Comdominio" data-size="7" required>
															</select>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<select required="required" data-live="search" name="loteRecomendado" id="loteRecomendado"
																	class="selectpicker" data-show-subtext="true" data-live-search="true"
																	data-style="btn" title="Lote" data-size="7">
															</select>
														</div>
														<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 pdt-30">
															<label>Motivo de la compra</label>
															<br>
															<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
																<div class="checkbox">
																	<label>
																		<input type="checkbox" name="motivoCompra"
																			   value="inversion"> Inversión
																	</label>
																</div>
															</div>
															<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
																<div class="checkbox">
																	<label>
																		<input type="checkbox" name="motivoCompra"
																			   value="contruirCasa"> Contruir mi casa
																	</label>
																</div>
															</div>
															<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
																<div class="form-group">
																	<label>
																		Otro:
																	</label>
																	<input type="text" class="form-control"
																		   name="motivoCompraOtro">
																</div>
															</div>

														</div>
													</div>
												</div>
											</div>
											<div class="row pdt-50">
												<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 frmDivCliente">
													<label id="lblDataCl2">DATOS DE PROCESO</label>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<label>¿Lo está recomendando alguna persona que ya es cliente de Ciudad Maderas?</label>
														<div class="checkbox-radios">
															<div class="radio">
																<label>
																	<input type="radio" name="recomendaCionClMaderas" id="recomendaCionClMaderas" value="1"> Si
																</label>
															</div>
															<div class="radio">
																<label>
																	<input type="radio" name="recomendaCionClMaderas" id="recomendaCionClMaderas2" value="0"> No
																</label>
															</div>
														</div>
													</div>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="siClienteMaderas">
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="form-group label-floating">
																<label class="control-label">
																	Nombre
																	<small>*</small>
																</label>
																<input type="text" required class="form-control"
																	   name="nombreClienteBonificar" id="nombreClienteBonificar" >
															</div>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="form-group label-floating">
																<label class="control-label">
																	Apellido Paterno
																	<small>*</small>
																</label>
																<input type="text" required class="form-control"
																	   name="apellidoPaternoBonificar" id="apellidoPaternoBonificar" >
															</div>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="form-group label-floating">
																<label class="control-label">
																	Apellido Materno
																	<small>*</small>
																</label>
																<input type="text" required class="form-control"
																	   name="apellidoMaternoBonificar" id="apellidoMaternoBonificar" >
															</div>
														</div>

														<!--Preguntar si sabe que Lote compro-->
														<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<label>¿Sabe que lote compró?</label>
															<div class="checkbox-radios">
																<div class="radio">
																	<label>
																		<input type="radio" name="sabeLoteDelRecomendador" id="sabeLoteDelRecomendadorsi" value="1"> Si
																	</label>
																</div>
																<div class="radio">
																	<label>
																		<input type="radio" name="sabeLoteDelRecomendador" id="sabeLoteDelRecomendadorno" value="0"> No
																	</label>
																</div>
															</div>
														</div>

														<!--Introducir datos del lote-->
														<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="dataLoteDelReocmendador">
															<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 pdt-30">
																<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
																	<select required="required" name="proyectoRecomendador" id="proyectoRecomendador"
																			class="selectpicker" data-show-subtext="true" data-live-search="true"
																			data-style="btn" title="PROYECTO" data-size="7">
																	</select>
																</div>
																<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
																	<select required="required" name="condominioRecomendador" id="condominioRecomendador"
																			class="selectpicker" data-show-subtext="true" data-live-search="true"
																			data-style="btn" title="Comdominio" data-size="7">
																	</select>
																</div>
																<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
																	<select required="required" name="loteRecomendador" id="loteRecomendador"
																			class="selectpicker" data-show-subtext="true" data-live-search="true"
																			data-style="btn" title="Lote" data-size="7">
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 pdt-50 hide" id="noClienteMaderas">
														<label>¿Por cuál medio se enteró del desarrollo?</label><br><br>
														<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado" value="volante"> Volante
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado" value="periodico"> Periódico
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado" value="revista"> Revista
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado" value="evento"> Evento
																</label>
															</div>
														</div>
														<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado" value="plazasComeciales"> Plazas Comerciales
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado" value="redesSociales"> Redes Sociales
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado" value="paginaWeb"> Página web
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado" value="senalizacion"> Señalización
																</label>
															</div>
														</div>
														<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
															<div class="checkbox">
																<label>
																	<input type="checkbox" name="medioEnterado"> Espectacular
																</label>
															</div>
															<div class="form-group label-floating">
																<label class="control-label">
																	Otro
																	<small>*</small>
																</label>
																<input type="text" required class="form-control"
																	   name="medioEnteradoOtro" id="medioEnteradoOtro" >
															</div>
														</div>
													</div>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 pdt-50">
														<label>¿Tiene alguna duda respecto al producto, o comentarui
															que nos pueda ayudar a mejorar el servicio o expereicia de
															la compra?</label>
														<textarea class="form-control" rows="3" width="100%" name="dudaComentariosProcesoCompra"4
														id="dudaComentariosProcesoCompra" required placeholder="Escriba su comentario"></textarea>
													</div>
												</div>
											</div>
											<div class="row text-center pdt-30">
												<button class="btn btn-primary">Guardar</button> &nbsp;&nbsp;&nbsp;
												<a class="btn"  target="_blank"
												   href="<?=base_url()?>index.php/clientes/concentradoBonificaciones">Ver PDF</a>
											</div>
										</form>
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
</body>
<?php $this->load->view('template/footer');?>
<!--<script src="<?=base_url()?>dist/js/controllers/asesor/prospects-list-1.1.0.js"></script>-->

<script>
    $(document).ready(function() {
		var respYes = $('#recomendaCionClMaderas').val();
		var respNo = $('#recomendaCionClMaderas2').val();
		var siClMaderas = $('#siClienteMaderas');
		var noClMaderas = $('#noClienteMaderas');
		var sabeLotRecsi = $('#sabeLoteDelRecomendadorsi').val();
		var sabeLotRecno = $('#sabeLoteDelRecomendadorno').val();
		var dataDelRec = $('#dataLoteDelReocmendador');

        $('#recomendaCionClMaderas').on('change', function () {
        	if(respYes == 1)
			{
				console.log('elejiste SI');
				siClMaderas.removeClass('hide');
				noClMaderas.addClass('hide');

				$('#sabeLoteDelRecomendadorsi').on('change', function () {
					if(sabeLotRecsi == 1) {
						console.log(sabeLotRecsi);
						dataDelRec.removeClass('hide');

						/*llenar selects si sabe el lote del cl de maderas*/
						$("#proyectoRecomendador").empty().selectpicker('refresh');
						$.post('<?=base_url()?>index.php/registroLote/getResidencialesGeneral/', function(data) {
							var len = data.length;
							for( var i = 0; i<len; i++)
							{
								var id = data[i]['idResidencial'];
								var name = data[i]['descripcion'] + " (" +data[i]['nombreResidencial'] + ")";
								$("#proyectoRecomendador").append($('<option>').val(id).text(name));
							}
							if(len<=0)
							{
								$("#proyectoRecomendador").append('<option selected="selected" disabled>NINGUN PROYECTO ENCONTRADO</option>');
							}
							$("#proyectoRecomendador").selectpicker('refresh');
						}, 'json');

						$('#proyectoRecomendador').on('change', function () {
							var valorSeleccionado = $(this).val();
							$("#condominioRecomendador").empty().selectpicker('refresh');
							$.post('<?=base_url()?>index.php/registroLote/getCondominio/'+valorSeleccionado, function(data) {
								var len = data.length;
								for( var i = 0; i<len; i++)
								{
									var id = data[i]['idCondominio'];
									var name = data[i]['nombre'] ;
									$("#condominioRecomendador").append($('<option>').val(id).text(name));
								}
								if(len<=0)
								{
									$("#condominioRecomendador").append('<option selected="selected" disabled>NINGUN CONDOMINIO ENCONTRADO</option>');
								}
								$("#condominioRecomendador").selectpicker('refresh');
							}, 'json');
						});

						$('#condominioRecomendador').on('change', function () {
							var valorSeleccionado = $(this).val();
							var residencial = $('#proyectoRecomendador').val();
							console.log(valorSeleccionado);
							console.log(residencial);

							$("#loteRecomendador").empty().selectpicker('refresh');
							$.post('<?=base_url()?>index.php/registroCliente/getLotesAll/'+valorSeleccionado+'/'+residencial, function(data) {
								var len = data.length;
								for( var i = 0; i<len; i++)
								{
									var id = data[i]['idLote'];
									var name = data[i]['nombreLote'] ;
									$("#loteRecomendador").append($('<option>').val(id).text(name));
								}
								if(len<=0)
								{
									$("#loteRecomendador").append('<option selected="selected" disabled>NINGUN LOTE ENCONTRADO</option>');
								}
								$("#loteRecomendador").selectpicker('refresh');
							}, 'json');
						});
					}
				});
				$('#sabeLoteDelRecomendadorno').on('change', function () {
					if(sabeLotRecno == 0) {
						console.log(sabeLotRecno);
						dataDelRec.addClass('hide');
						$("#proyectoRecomendador").empty().selectpicker('refresh');
						$("#condominioRecomendador").empty().selectpicker('refresh');
						$("#loteRecomendador").empty().selectpicker('refresh');
					}
				});
			}

		});
		$('#recomendaCionClMaderas2').on('change', function () {
			if(respNo == 0)
			{
				console.log('elejiste NO');
				siClMaderas.addClass('hide');
				noClMaderas.removeClass('hide');
			}
		});

		$("#proyectoRecomendado").empty().selectpicker('refresh');
		$.post('<?=base_url()?>index.php/registroLote/getResidencialesGeneral/', function(data) {
			var len = data.length;
			for( var i = 0; i<len; i++)
			{
				var id = data[i]['idResidencial'];
				var name = data[i]['descripcion'] + " (" +data[i]['nombreResidencial'] + ")";
				$("#proyectoRecomendado").append($('<option>').val(id).text(name));
			}
			if(len<=0)
			{
				$("#proyectoRecomendado").append('<option selected="selected" disabled>NINGUN GERENTE ENCONTRADO</option>');
			}
			$("#proyectoRecomendado").selectpicker('refresh');
		}, 'json');

		$('#proyectoRecomendado').on('change', function () {
			var valorSeleccionado = $(this).val();
			$("#condominioRecomendado").empty().selectpicker('refresh');
			$.post('<?=base_url()?>index.php/registroLote/getCondominio/'+valorSeleccionado, function(data) {
				var len = data.length;
				for( var i = 0; i<len; i++)
				{
					var id = data[i]['idCondominio'];
					var name = data[i]['nombre'] ;
					$("#condominioRecomendado").append($('<option>').val(id).text(name));
				}
				if(len<=0)
				{
					$("#condominioRecomendado").append('<option selected="selected" disabled>NINGUN CONDOMINIO ENCONTRADO</option>');
				}
				$("#condominioRecomendado").selectpicker('refresh');
			}, 'json');
		});

		$('#condominioRecomendado').on('change', function () {
			var valorSeleccionado = $(this).val();
			var residencial = $('#proyectoRecomendado').val();
			console.log(valorSeleccionado);
			console.log(residencial);

			$("#loteRecomendado").empty().selectpicker('refresh');
			$.post('<?=base_url()?>index.php/registroCliente/getLotesAll/'+valorSeleccionado+'/'+residencial, function(data) {
				var len = data.length;
				for( var i = 0; i<len; i++)
				{
					var id = data[i]['idLote'];
					var name = data[i]['nombreLote'] ;
					$("#loteRecomendado").append($('<option>').val(id).text(name));
				}
				if(len<=0)
				{
					$("#loteRecomendado").append('<option selected="selected" disabled>NINGUN LOTE ENCONTRADO</option>');
				}
				$("#loteRecomendado").selectpicker('refresh');
			}, 'json');
		});


		/*
		* proyectoRecomendador
condominioRecomendador
loteRecomendador
		* */
    });
</script>

</html>
