<html>
<head>
	<title>Ciudad Maderas | Depósito de Seriedad</title>
	<link rel="shortcut icon" href="<?=base_url()?>static/images/arbol_cm.png" />
	<link href="<?=base_url()?>dist/css/bootstrap.min.css" rel="stylesheet" />
	<!--  Material Dashboard CSS    -->
	<link href="<?=base_url()?>dist/css/material-dashboard.css" rel="stylesheet" />
	<!--  CSS for Demo Purpose, don't include it in your project     -->
	<link href="<?=base_url()?>dist/css/demo.css" rel="stylesheet" />
	<!--     Fonts and icons     -->
	<link href="<?=base_url()?>dist/css/font-awesome.css" rel="stylesheet" />
	<link href="<?=base_url()?>dist/css/google-roboto-300-700.css" rel="stylesheet" />
	<style>
		body{color: #084c94;}
		.espacio{padding: 5%;}
		.espaciodos{padding: 10%;}
		h2{font-weight: bold;color: #084c94;}
		.nuevo {display:scroll;position:fixed;bottom:270px;right:5px;z-index: 3;}
		.code {display:scroll;position:fixed;bottom:360px;right:17px;z-index: 3;}
		.imprime {display:scroll;position:fixed;bottom:315px;right:5px;z-index: 3;}
		.save {display:scroll;position:fixed;bottom:225px;right:17px;z-index: 3;}
		p{color: #084c94;}
		.form-cont{width:100%;height:25px;padding:2px 3px;font-size:12px;line-height:1.42857143;color:#555;background-color:#f1eacf;background-image:none;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
		table{font-size: 13px;}
		img{width: 60%;margin-bottom: 20%;}
		.col-xs-16 {width: 3px;float: left;}
		.col-xs-17 {width: 16%;float: left;}
		#imagenbg {position: relative;top:890px;z-index: -1;}
		#fichadeposito {position: absolute;z-index: 2;}



		section {
			counter-reset: total;
		}

		/*label {*/
		/*	position: relative;*/
		/*	display: block;*/
		/*	background: #f8f8f8;*/
		/*	border: 1px solid #f0f0f0;*/
		/*	border-radius: 2em;*/
		/*	padding: .5em 1em .5em 5em;*/
		/*	box-shadow: 0 1px 2px rgba(100, 100, 100, 0.5) inset, 0 0 10px rgba(100, 100, 100, 0.1) inset;*/
		/*	cursor: pointer;*/
		/*	text-shadow: 0 2px 2px #fff;*/
		/*}*/
		/*label::before {*/
		/*	content: '';*/
		/*	position: absolute;*/
		/*	top: 50%;*/
		/*	left: .7em;*/
		/*	width: 3em;*/
		/*	height: 1.2em;*/
		/*	border-radius: .6em;*/
		/*	background: #eee;*/
		/*	-webkit-transform: translateY(-50%);*/
		/*	transform: translateY(-50%);*/
		/*	box-shadow: 0 1px 3px rgba(100, 100, 100, 0.5) inset, 0 0 10px rgba(100, 100, 100, 0.2) inset;*/
		/*}*/
		/*label::after {*/
		/*	content: '';*/
		/*	position: absolute;*/
		/*	top: 50%;*/
		/*	left: .5em;*/
		/*	width: 1.4em;*/
		/*	height: 1.4em;*/
		/*	border: .25em solid #fafafa;*/
		/*	border-radius: 50%;*/
		/*	box-sizing: border-box;*/
		/*	background-color: #ddd;*/
		/*	background-image: -webkit-linear-gradient(bottom, #fff 0%, #fff 40%, transparent 100%);*/
		/*	background-image: linear-gradient(to top, #fff 0%, #fff 40%, transparent 100%);*/
		/*	-webkit-transform: translateY(-50%);*/
		/*	transform: translateY(-50%);*/
		/*	box-shadow: 0 3px 3px rgba(0, 0, 0, 0.5);*/
		/*}*/
		/*label, label::before, label::after {*/
		/*	-webkit-transition: all 0.2s cubic-bezier(0.165, 0.84, 0.44, 1);*/
		/*	transition: all 0.2s cubic-bezier(0.165, 0.84, 0.44, 1);*/
		/*}*/

		/*label:hover, input:focus + label {*/
		/*	color: black;*/
		/*}*/
		/*label:hover::after, input:focus + label::after {*/
		/*	background-color: #ccc;*/
		/*	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);*/
		/*}*/

		/*input:checked {*/
		/*	counter-increment: total;*/
		/*}*/
		/*input:checked + label::before {*/
		/*	background: #CD6155;*/
		/*}*/
		/*input:checked + label::after {*/
		/*	-webkit-transform: translateX(2em) translateY(-50%);*/
		/*	transform: translateX(2em) translateY(-50%);*/
		/*}*/

		/*.total::after {*/
		/*	content: counter(total);*/
		/*	font-weight: bold;*/
		/*}*/




		/*section {*/
		/*	margin: auto;*/
		/*	padding: 2em;*/
		/*	background: white;*/
		/*	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);*/
		/*}*/





		.form-group {
			/* padding-bottom: 10px; */
			margin: 20px 0 0 0;
		}
		.form-category {
			padding: 0px 0 0px;
		}
		.card .category:not([class*="text-"]) {
			color: #999999;
			font-size: 12px;
		}
	</style>
</head>
<body>
<!-- <div class="container"> -->
<!-- <div class="row"> -->
<!-- <div class="col-md-12"> -->

<form method="post" action="<?=base_url()?>index.php/registroCliente/query_ds/" target="_blank" enctype="multipart/form-data">

	<input type="hidden" name="idCliente" value="<?=$cliente->idCliente?>" />

	<div id="fichadeposito" name="fichadeposito" class="fichadeposito">
		<div id="guar"></div>
		<form method="post" id="formulario" name="formulario">
			<div id="muestra">
				<div class="container-fluid">
					<div class="card">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 40px 0px;">
							<div class="row">

									<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12  "><!--col-md-offset-7 col-lg-offset-7-->
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-left: 80px">
							 				<h2 style="text-align: left">DEPÓSITO DE SERIEDAD (versión anterior)</h2><br>
						                    	<h4 align="right"> <label>Fecha última modificación: <?php echo $cliente->fecha_modificacion;?></label> </h4> 

										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-md-offset-3 col-lg-offset-3">
											<div style="margin: 40px 55px 0px 0px">
												<div class="form-group label-floating ">
													<label class="control-label">
														FOLIO
													</label>
													<input type="text" class="form-control" name="clave" id="clave" readonly="readonly" style="color: #ff0000" value="<?=$cliente->clave?>"/>
													<input type="hidden" class="form-control" name="idCliente" id="idCliente" value="<?=$cliente->idCliente?>"/>
													<div id="resp"></div>
												</div>
											</div>

										</div>
									</div>

							</div>
							<table border="0" width="90%" align="center" align="">
								<tr>
									<th rowspan="4" style="text-align: left">
										<img src="<?=base_url()?>static/images/CMOF.png" alt="Servicios Condominales" title="Servicios Condominales" style="width:90%"/>
									</th>
									<td>
										<h5><p><strong>DESARROLLO:</strong></p></h5>
									</td>
								</tr>
								<tr>
									<td>
										<table border="0" width="100%">
											<tr>
												<td width="20%"></td>
												<td width="15%">
													<div class="checkbox-radios">
														<div class="radio">
															<label>
																<input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="1" <?php if($cliente->desarrollo=='1') echo "checked=true"?>> Querétaro
															</label>
														</div>
													</div>
												</td>
												<td width="15%">
													<div class="checkbox-radios">
														<div class="radio">
															<label>
																<input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="2" <?php if($cliente->desarrollo=='2') echo "checked=true"?>> León
															</label>
														</div>
													</div>
												</td>
												<td width="15%">
													<div class="checkbox-radios">
														<div class="radio">
															<label>
																<input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="3" <?php if($cliente->desarrollo=='3') echo "checked=true"?>> Celaya
															</label>
														</div>
													</div>
												</td>
												<td width="20%">
													<div class="checkbox-radios">
														<div class="radio">
															<label>
																<input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="4" <?php if($cliente->desarrollo=='4' OR $cliente->idResidencial=='14') echo "checked=true"?>> San Luis Potosí
															</label>
														</div>
													</div>
												</td>				
                                                <td width="20%">
													<div class="checkbox-radios">
														<div class="radio">
															<label>
																<input type="radio" id="desarrollo" name="desarrollo" onclick="return false;" value="5" <?php if($cliente->desarrollo=='5') echo "checked=true"?>> Mérida
															</label>
														</div>
													</div>
												</td>
												<td width="15%">
												</td>
											</tr>
											<tr>
												<td width="20%"></td>
												<td width="15%">
													<div class="checkbox-radios">
														<div class="radio">
															<label>
																<input type="radio" id="CAMPO04" name="CAMPO04" onclick="return false;" value="0" <?php if($cliente->tipo_lote=='0') echo "checked=true"?>> Lote
															</label>
														</div>
													</div>
												</td>
												<td width="15%">
													<div class="checkbox-radios">
														<div class="radio">
															<label>
																<input type="radio" id="CAMPO04" name="CAMPO04" onclick="return false;" value="1" <?php if($cliente->tipo_lote=='1') echo "checked=true"?>> Lote Comercial
															</label>
														</div>
													</div>
												</td>
												<td width="15%"></td>
												<td width="15%"></td>
												<td width="20%"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<h5><p><strong>DOCUMENTACIÓN ENTREGADA:</strong></p></h5>
									</td>
								</tr>
								<tr>
									<td>
										<table border="0" width="100%">
											<tr>
												<td width="20%"><p><strong>Personas&nbsp;Físicas</strong></p></td>
												<td width="25%">
													<div class="checkbox-radios">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="CAMPO05" onclick="return false;" name="CAMPO05" value="1" <?php if($cliente->idOficial_pf == 1){echo "checked";}  ?>> Identificación&nbsp;Oficial
															</label>
														</div>
													</div>
												</td>
												<td width="25%">
													<div class="checkbox-radios">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="CAMPO06" onclick="return false;" name="CAMPO06" value="1" <?php if($cliente->idDomicilio_pf == 1){echo "checked";}  ?>> Comprobante&nbsp;de&nbsp;Domicilio
															</label>
														</div>
													</div>
												</td>
												<td width="25%" colspan="2">
													<div class="checkbox-radios">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="CAMPO07" onclick="return false;" name="CAMPO07" value="1" <?php if($cliente->actaMatrimonio_pf == 1){echo "checked";}  ?>> Acta&nbsp;de&nbsp;Matrimonio
															</label>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td width="20%"><p><strong>Personas&nbsp;Morales</strong></p></td>
												<td width="25%">
													<div class="checkbox-radios">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="CAMPO08" onclick="return false;" name="CAMPO08" value="1" <?php if($cliente->actaConstitutiva_pm == 1){echo "checked";}  ?>> Acta&nbsp;Constitutiva
															</label>
														</div>
													</div>
												</td>
												<td width="25%">
													<div class="checkbox-radios">
														<div class="checkbox">
															<label>
																<input type="checkbox" id="CAMPO09" onclick="return false;" name="CAMPO09" value="1" <?php if($cliente->poder_pm == 1){echo "checked";}  ?>> Poder
															</label>
														</div>
													</div>
												</td>
												<td width="30%" colspan="2">
													<div class="checkbox-radios">
														<div class="checkbox">
															<label style="font-size: 0.9em;">
																<input type="checkbox" id="CAMPO10" onclick="return false;" name="CAMPO10" value="1" <?php if($cliente->idOficialApoderado_pm == 1){echo "checked";}  ?>> Identificación&nbsp;Oficial&nbsp;Apoderado
															</label>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td width="20%"></td>
												<td width="20%">
												</td>
												<td width="30%">
													<div class="checkbox-radios">
														<div class="checkbox">
															<label>
																RFC:
															</label>
														</div>
													</div>
												</td>
												<td width="30%">
													<input type="text" class="form-control" style="width: 205%;float: right" readonly id="rfc" name="rfc" value="<?=$cliente->rfc?>">
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<br>
										<hr style="border-top: 2px solid #aab5ca">
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<input name="nombre" id="nombre" type="text" class="col-xs-12 form-control" style="border-right: 0px #fff;" value="<?=$cliente->nombrecliente?>" readonly="readonly">
											<p>NOMBRE (<b><span style="color: red;">*</span></b>)</p>
										</div>
									</td>

								</tr>
								<tr>
									<td width="100%" colspan="2">
										<table border="0" width="100%">
											<tr>
												<td width="50%" colspan="2">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">TELÉFONO CASA</label>
															<input type="text" class="form-control" id="telefono1" readonly name="telefono1" value="<?=$cliente->telefono1?>">
															<div class="category form-category">
																&nbsp;
															</div>
														</div>
													</div>
												</td>
												<td width="50%" colspan="2">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">CELULAR </label>
															<input type="text" class="form-control" readonly id="telefono2" name="telefono2" value="<?=$cliente->telefono2?>">
															<div class="category form-category">
																<small  style="color: red;">*</small> Campo Requerido 
															</div>
														</div>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group label-floating">
												<label class="control-label">EMAIL </label>
												<input type="text" class="form-control" id="correo" readonly name="correo" value="<?=$cliente->correo?>">
												<div class="category form-category">
													<small  style="color: red;">*</small> Campo Requerido
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<table border="0" width="100%">
											<tr>
												<td width="40%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">FECHA NACIMIENTO </label>
															<input type="text" class="form-control" id="fechaNacimiento" name="fechaNacimiento" readonly value="<?=$cliente->fechaNacimiento?>">
															<div class="category form-category">
																<small  style="color: red;">*</small> Campo Requerido
															</div>
														</div>
													</div>
												</td>
												<td width="30%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">NACIONALIDAD </label>
															<input type="text" class="form-control" style="width: 95%;" id="CAMPO21" name="CAMPO21" readonly value="<?=$cliente->nacionalidad?>">
															<div class="category form-category">
															<small  style="color: red;">*</small> Campo Requerido
															</div>
														</div>
													</div>
												</td>
												<td width="30%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">ORIGINARIO DE </label>
															<input class="form-control" id="CAMPO22" name="CAMPO22"
															readonly value=" <?php echo $cliente->originario; ?>">

															<div class="category form-category">
																<small  style="color: red;">*</small> Campo Requerido
															</div>
														</div>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<table border="0" width="100%">
											<tr>
												<td width="20%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">ESTADO CIVIL </label>
															<select id="CAMPO23" name="CAMPO23" class="form-control"  style="width: 90%; heigt: 28px;display: none">
																<option value="CASADO" <?php if($cliente->estadoCivil=='CASADO') echo " SELECTED"?>>CASADO</option>
																<option value="SOLTERO" <?php if($cliente->estadoCivil=='SOLTERO') echo " SELECTED"?>>SOLTERO</option>
																<option value="VIUDO O DIVORCIADO" <?php if($cliente->estadoCivil=='VIUDO O DIVORCIADO') echo " SELECTED"?>>VIUDO O DIVORCIADO</option>
															</select>
															<input  id="CAMPO23" class="form-control" readonly name="CAMPO23" value="<?php echo $cliente->estadoCivil;?>"/>
															<div class="category form-category">
																<small  style="color: red;">*</small> Campo Requerido - Ej.Casado/Solero
															</div>
														</div>
													</div>
												</td>
												<td width="50%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">NOMBRE DEL CÓNYUGE </label>
															<input type="text" class="form-control" readonly style="width: 95%;" id="CAMPO24" name="CAMPO24" value="<?=$cliente->nombreConyuge?>">
															<div class="category form-category">
																<small  style="color: red;">&nbsp;</small> 
															</div>
														</div>
													</div>
												</td>
												<td width="30%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">RÉGIMEN </label>
															<input type="text" readonly class=form-control id="CAMPO25" name="CAMPO25" value="<?=$cliente->regimen?>">
															<div class="category form-category">
																<small  style="color: red;">*</small> Campo Requerido
															</div>
														</div>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group label-floating">
												<label class="control-label">DOMICILIO PARTICULAR </label>
												<input name="domicilio_particular" id="domicilio_particular" type="text" readonly class="form-control" style="border-right: 0px #fff; border-left : 2pt #fff;" value="<?=$cliente->domicilio_particular?>">
												<div class="category form-category">
													<small  style="color: red;">*</small> Campo Requerido
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<table border="0" width="100%">
											<tr>
												<td width="40%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">OCUPACIÓN </label>
															<input type="text" class="form-control" style="width: 90%;" id="CAMPO27" readonly name="CAMPO27" value="<?=$cliente->ocupacion?>">
															<div class="category form-category">
																<small  style="color: red;">*</small> Campo Requerido
															</div>
														</div>
													</div>
												</td>
												<td width="60%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">EMPRESA EN LA QUE TRABAJA </label>
															<input type="text" class="form-control" readonly id="CAMPO28" name="CAMPO28" value="<?=$cliente->empresaLabora?>">
															<div class="category form-category">
																<small  style="color: red;">*</small> Campo Requerido
															</div>
														</div>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<table border="0" width="100%">
											<tr>
												<td width="40%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">PUESTO </label>
															<input type="text" class="form-control" style="width: 90%;" id="CAMPO29" readonly name="CAMPO29" value="<?=$cliente->puesto?>">
															<div class="category form-category">
																<small  style="color: red;">*</small> Campo Requerido
															</div>
														</div>
													</div>
												</td>
												<td width="30%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<input type="text" class="form-control" readonly style="width: 35%; margin-left: 80px; margin-right: 5%; float: left;" id="CAMPO30" name="CAMPO30" value="<?=$cliente->antigueda?>"> años<p style="margin-left: 130px; float: left;">ANTIGÜEDAD</p>
													</div>
												</td>
												<td width="30%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<input type="text" class="form-control" readonly style="width: 35%; margin-left: 50px; margin-right: 5%; float: left;" id="CAMPO31" name="CAMPO31" required="required" value="<?=$cliente->edadFirma?>"> años (<b><span style="color: red;">*</span></b>)<p style="margin-left: 50px; float: left;">EDAD AL MOMENTO DE LA FIRMA
														</p>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group label-floating">
												<label class="control-label">DOMICILIO EMPRESA </label>
													<input type="text" class="form-control" readonly id="CAMPO32" name="CAMPO32" value="<?=$cliente->domicilioEmpresa?>">
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<table border="0" width="100%">
											<tr>
												<td width="50%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="form-group label-floating">
															<label class="control-label">TELÉFONO EMPRESA </label>
															<input type="text" class="form-control" readonly id="CAMPO34" name="CAMPO34" value="<?=$cliente->telefonoEmp?>">
														</div>
													</div>
												</td>
												<td width="10%">
													<p>VIVE EN CASA:</p>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="checkbox-radios">
															<div class="radio">
																<label>
																	<input type="radio" id="CAMPO35" onclick="return false;" name="CAMPO35" value="1" <?php if($cliente->casa=='1') echo "checked=true"?>> PROPIA
																</label>
															</div>
														</div>
													</div>
												</td>
												<td width="10%">
													<p>&nbsp;</p>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="checkbox-radios">
															<div class="radio">
																<label>
																	<input type="radio" id="CAMPO35" name="CAMPO35" onclick="return false;" value="2" <?php if($cliente->casa=='2') echo "checked=true"?>> RENTADA
																</label>
															</div>
														</div>
													</div>
												</td>
												<td width="10%">
													<p>&nbsp;</p>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="checkbox-radios">
															<div class="radio">
																<label>
																	<input type="radio" id="CAMPO35" name="CAMPO35" onclick="return false;" value="3" <?php if($cliente->casa=='3') echo "checked=true"?>> PAGÁNDOSE
																</label>
															</div>
														</div>
													</div>
												</td>
												<td width="10%">
													<p>&nbsp;</p>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="checkbox-radios">
															<div class="radio">
																<label>
																	<input type="radio" id="CAMPO35" name="CAMPO35" onclick="return false;" value="4" <?php if($cliente->casa=='4') echo "checked=true"?>> FAMILIAR
																</label>
															</div>
														</div>
													</div>
												</td>
												<td width="10%">
													<p>&nbsp;</p>
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="checkbox-radios">
															<div class="radio">
																<label>
																	<input type="radio" id="CAMPO35" name="CAMPO35" onclick="return false;" value="5" <?php if($cliente->casa=='5') echo "checked=true"?>> OTRO
																</label>
															</div>
														</div>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>

									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<table border="0" width="100%">
												<tr>
													<td width="5%">El Sr.(a) (<b><span style="color: red;">*</span></b>) </td>

													<td width="75%">
														<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="form-group label-floating">
																<label class="control-label">NOMBRE </label>
																<input name="nombre" id="nombre" type="text" class="form-control"  value="<?=$cliente->nombrecliente?>" readonly="readonly">
																<div class="category form-category">
																	<small  style="color: red;">*</small> Campo Requerido
																</div>
															</div>
														</div>
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2"><br></td>
								</tr>
								<tr>
									<td width="100%" colspan="2">


										<?php
										$proyecto = str_replace(' ', '',$cliente->nombreResidencial);
										$condominio = strtoupper($cliente->nombreCondominio);
										$numeroLote = preg_replace('/[^0-9]/','',$cliente->nombreLote);
										?>



										<p>
										<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
											Se compromete a adquirir el lote No. (<b><span style="color: red;">*</span></b>)

												<input type="text" class="form-control" style="width: 100%;" id="numeroLote" name="numeroLote"  onkeypress="return valida(event)" value="<?=$numeroLote?>" readonly="readonly">
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
											en el clúster (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 100%;"  id="CAMPO38" name="CAMPO38" value="<?=$condominio?>" readonly="readonly">
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
											de sup. aprox. (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 100%;" id="CAMPO39" name="CAMPO39" onkeypress="return valida(event)" value="<?=$cliente->sup?>" readonly="readonly">
										</div>
										<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
											No. de ref. de pago (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 100%;" id="CAMPO40" name="CAMPO40" value="<?=$cliente->referencia?>" readonly="readonly">
										</div>
										</p>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
											<p>costo por m2 lista (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 80%;" id="CAMPO41" name="CAMPO41" onkeypress="return valida(event)" value="<?=$cliente->precio?>" readonly></p>
										</div>
                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
											<p>costo por m2 final (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 80%;" id="CAMPO41_1" readonly name="CAMPO41_1" onkeypress="return valida(event)" value="<?=$cliente->costom2f?>"></p>
										</div>
                  </td>
                </tr>
                <tr>
                <td width="100%" colspan="2">
                  <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
										<p>una vez que sea autorizado el proyecto (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 80%;" id="CAMPO42" readonly name="CAMPO42" value="<?=$cliente->proyecto?>">
										</p>
										</div>
                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
											en el Municipio de (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 80%;" id="CAMPO43" name="CAMPO43" readonly value="<?=$cliente->municipioDS?>"></p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p>La ubicación del lote puede variar debido a ajustes del proyecto.</p>
										</div>
									</td>
								</tr>
								<tr>
									<td width="30%">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group label-floating">
												<label class="control-label">Importe de la oferta $ </label>
												<input type="text" class="form-control" style="width: 100%;" id="CAMPO44" readonly name="CAMPO44" onkeypress="return valida(event)" value="<?=$cliente->importOferta?>">
												<div class="category form-category">
													<small  style="color: red;">*</small> Campo Requerido
												</div>
											</div>
										</div>
									</td>
									<td width="70%">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
											<div class="form-group label-floating">
												<label class="control-label"> </label>
												<input type="text" class="form-cont" style="width: 93%;" id="CAMPO45" readonly name="CAMPO45" value="<?=$cliente->letraImport?>"> 00/100 M.N.)</p>
												<div class="category form-category">
													<small  style="color: red;">*</small> Campo Requerido
												</div>
											</div>
										</div>
									</td>

								</tr>
								<tr>
									<td width="20%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="row form-inline">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="col">
														<p >El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de $ (<b><span style="color: red;">*</span></b>) <input type="text"  readonly class="form-control" style="width: 100%;" id="CAMPO46" name="CAMPO46" onkeypress="return valida(event)" value="<?=$cliente->cantidad?>">
															(<input type="text" class="form-control" style="background: #fffs" id="CAMPO47" readonly name="CAMPO47" value="<?=$cliente->letraCantidad?>">), misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo.
														</p>
													</div>
												</div>

											</div>
										</div>

									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<p>El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma.</p>
										</div>


										<div class="col col-xs-6 col-sm-6 col-md-6 col-lg-6">

										<div class="col col-xs-6 col-sm-6 col-md-4 col-lg-4" style="text-align:right">
											<p>Saldo de depósito:  $ </p>        
										</div>

										<div class="col col-xs-6 col-sm-6 col-md-8 col-lg-8" style="margin-top: -30px;text-align:left;margin-left:-20px;">
                     <input type="text" class="form-control" style="width: 100%;" id="CAMPO48" name="CAMPO48" readonly  onkeypress="return valida(event)" value="<?=$cliente->saldoDeposito?>"> 
                    </div>
                  	</div>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<table border="0" width="100%">
											<tr>
												<td width="100%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="row">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="form-inline">
																<div class="col">
																	Aportación mensual a la oferta: $ (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 100%;" id="CAMPO49" name="CAMPO49" readonly onkeypress="return valida(event)" value="<?=$cliente->aportMensualOfer?>"> Fecha 1era. Aportación (<b><span style="color: red;">*</span></b>)
																	<input type="date" class="form-control" style="width: 100%;" id="CAMPO50" name="CAMPO50" readonly value="<?=$cliente->fecha1erAport?>">
																	Plazo (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" readonly style="width: 100%;" id="CAMPO51" name="CAMPO51" onkeypress="return valida(event)" value="<?=$cliente->plazo?>"> meses

															    	</div>
													    		</div>
													    	</div>
											    	  	</div>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<table border="0" width="100%">
											<tr>
												<td width="100%">
													<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<div class="row">
															<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																<div class="form-inline">
																	<div class="col">
																		Fecha liquidación de depósito  (<b><span style="color: red;">*</span></b>) <input type="date" class="form-control" style="width: 100%;" id="CAMPO52" readonly name="CAMPO52" value="<?=$cliente->fechaLiquidaDepo?>">
																		Fecha 2da. Aportación (<b><span style="color: red;">*</span></b>) <input type="date" class="form-control" style="width: 100%;" id="CAMPO53" readonly name="CAMPO53" value="<?=$cliente->fecha2daAport?>">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<p></p>
											<p style="text-align: justify;">Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, la empresa cobrará al ofertante únicamente  $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación. Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.</p>
										
											<p style="text-align: justify;">Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente. 
											Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. 
											De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. 
											Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.  
											</p>
										
										</div>
									</td>
								</tr>
								<tr>
									<td width="10%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-inline">
														<div class="col">
															<p>En el Municipio de (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 100%;display: inline-block" id="CAMPO54" name="CAMPO54" readonly value="<?=$cliente->municipio2?>">, a (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 100%;" id="CAMPO55" readonly name="CAMPO55" onkeypress="return valida(event)" value="<?=$cliente->dia?>"> del mes de (<b><span style="color: red;">*</span></b>) <input type="text" class="form-control" style="width: 100%;" id="CAMPO56" name="CAMPO56" readonly value="<?=$cliente->mes?>"> del año (<b><span style="color: red;">*</span></b>) <input type="text" readonly class="form-control" style="width: 100%;" id="CAMPO57" name="CAMPO57" onkeypress="return valida(event)" value="<?=$cliente->año?>">.</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td width="100%" colspan="2">
										<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<table border="0" width="100%">
											<tr>
												<td width="60%" align="center">
													<table border="0" width="100%">
														<tr>
															<td width="100%"><br><br><br><br></td>
														</tr>
														<tr>
															<td width="100%" align="center">
																<input type="text" readonly class="form-control" style="width: 60%;" id="CAMPO58" name="CAMPO58" value="<?=$cliente->nombrecliente?>">
																<p>Nombre y Firma / Ofertante (<b><span style="color: red;">*</span></b>) </p>
																<p>Acepto que se realice una verificación de mis datos, en los teléfonos<br> y correos que proporciono para el otorgamiento del crédito.</p>
															</td>
														</tr>
														<tr>
															</td>
														</tr>
													</table>
												</td>
												<br><br><br>
												<td width="40%">
													<table border="0" width="100%">
														<tr>

															<td width="100%" style="padding-left: 20px;">
																<div class="row" style="background-color:#D4DDEE;">
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<div class="col">
																			<div class="card" style="margin: 10px 0;">
																				<center>
																					<h5>
																						REFERENCIAS PERSONALES
																					</h5>
																				</center>
																				<div
																					class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
																					<div
																						class="form-group label-floating">
																						<label class="control-label">NOMBRE </label>
																						<input type="text"
																							   class="form-control"
																							   id="referencia1"
																							   name="referencia1" readonly
																							   value="<?= $cliente->referencia1 ?>">
																						<div
																							class="category form-category">
																							<small
																								style="color: red;"></small>
																						</div>
																					</div>
																					<div
																						class="form-group label-floating">
																						<label class="control-label">PARENTESCO </label>
																						<input type="text"
																							   class="form-control"
																							   id="CAMPO61"
																							   name="CAMPO61" readonly
																							   value="<?= $cliente->parentescoReferen ?>">
																						<div
																							class="category form-category">
																							<small
																								style="color: red;"></small>
																						</div>
																					</div>
																					<div
																						class="form-group label-floating">
																						<label class="control-label">TEL. </label>
																						<input type="text"
																							   class="form-control"
																							   id="telreferencia1"
																							   name="telreferencia1" readonly
																							   onkeypress="return valida(event)"
																							   value="<?= $cliente->telreferencia1 ?>">
																						<div
																							class="category form-category">
																							<small
																								style="color: red;"></small>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																		<div class="col">
																			<div class="card" style="margin: 10px 0;">
																				<center>
																					<h5>
																						REFERENCIAS PERSONALES
																					</h5>
																				</center>
																				<div
																					class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
																					<div
																						class="form-group label-floating">
																						<label class="control-label">NOMBRE </label>
																						<input type="text" class="form-control" readonly id="referencia2" name="referencia2" value="<?=$cliente->referencia2?>">
																						<div
																							class="category form-category">
																							<small
																								style="color: red;"></small>
																						</div>
																					</div>
																					<div
																						class="form-group label-floating">
																						<label class="control-label">PARENTESCO </label>
																						<input type="text" class="form-control" readonly id="CAMPO64" name="CAMPO64" value="<?=$cliente->parentescoReferen2?>">
																						<div
																							class="category form-category">
																							<small
																								style="color: red;"></small>
																						</div>
																					</div>
																					<div
																						class="form-group label-floating">
																						<label class="control-label">TEL. </label>
																						<input type="text" class="form-control" readonly id="telreferencia2" name="telreferencia2" onkeypress="return valida(event)" value="<?=$cliente->telreferencia2?>">
																						<div
																							class="category form-category">
																							<small
																								style="color: red;"></small>
																						</div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="row">

																</div>
															</td>
														</tr>
														<tr>
															<td colspan="2"><hr></td>
														</tr>
														<tr>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td width="100%" colspan="2">
													<br><br><br><br>
												</td>
											</tr>
											<tr>
											<td width="100%" colspan="2">

												<div class="form-group label-floating">
														<label class="control-label">OBSERVACIONES</label>
														<textarea id="CAMPO59" name="CAMPO59" readonly class="form-control" rows="5"><?php echo $cliente->observacion; ?></textarea> 
														<div class="category form-category">
															&nbsp;
														</div>
												</div>
											</td>
											</tr>
											<tr>
												<td width="100%" colspan="2">
													<br><br><br><br>
												</td>
											</tr>
											<tr>
												<td width="100%" colspan="2">
													<table border="0" width="100%">
														<td width="50%" align="center">
															<input type="text" class="form-control" style="width: 60%;" id="CAMPO66" readonly name="CAMPO66" value="<?=$cliente->asesor?> / <?=$cliente->asesor2?> / <?=$cliente->asesor3?>">
															<p>Nombre y Firma / Asesor (<b><span style="color: red;">*</span></b>) </p>
														</td>
														<td width="50%" align="center">
															<input type="text" readonly class="form-control" style="width: 60%;" id="CAMPO67" name="CAMPO67" value="<?=$cliente->gerente1?> / <?=$cliente->gerente2?> / <?=$cliente->gerente3?>">
															<p>Nombre y Firma / Autorización de operación (<b><span style="color: red;">*</span></b>) </p>
														</td>
													</table>
												</td>
											</tr>
											<tr>
												<td width="100%" colspan="2">
													<table border="0" width="100%">
														<tr>
															<td width="2%" align="center">
																E-mail:
															</td>
															<td width="40%">
																<input type="email" readonly class="form-control" style="width: 37%;" id="CAMPO68" name="CAMPO68" value="<?=$cliente->email2?>">
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td width="100%" colspan="2">
													<br><br>
												</td>
											</tr>

										</table>
										</div>
						</div>
						</div>
					</div>
				</div>
			<BR><BR>
			
			
			
						
			
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<!--<div class="col-sm-4">
						<section>
							<div>
								<div class="togglebutton">
									<label>
										<input id="especificar" name="especificar" type="checkbox" onclick="return false;" <?php if($cliente->especificar == 12){echo "checked";}  ?>/> Club Maderas
									</label>
								</div>
							</div>
						</section>
					</div>-->
					<div class="col-sm-12 checkbox-radios" style="text-align: left;padding: 0px;visibility: hidden;">
										<div class="col-md-2 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" id="especificar"  name="especificar"  
														<?php if ($cliente->especificar == 6 ) { echo "checked=true"; } ?>  value="6" style="font-size: 0.9em;"/> Marketing Digital
												</label>
											</div>
										</div>
										
										<div class="col-md-2 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" id="especificar"  name="especificar"  
														<?php if ($cliente->especificar == 12 ) {echo "checked=true";} ?>  value="12" style="font-size: 0.9em;"/> Club Maderas
												</label>
											</div>
										</div>

										
					</div>
				</div>
			</div>
			
			
			
			
			


			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="container">
							<center>
								<br>
								<button type="submit" class="btn btn-success btn-lg" style="width: 100%">IMPRIMIR PDF <span class="glyphicon glyphicon-save-file"></span></button>
                            </center>
						</div>
					</div>
				</div>
			</div>
			<BR><BR>



			<br><br>
			<br><br>
			<br><br>

	</div>






</body>
<!--   Core JS Files   -->
<script src="<?=base_url()?>dist/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/material.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>dist/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?=base_url()?>dist/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?=base_url()?>dist/js/moment.min.js"></script>
<!--  Charts Plugin -->
<script src="<?=base_url()?>dist/js/chartist.min.js"></script>
<!--  Plugin for the Wizard -->
<script src="<?=base_url()?>dist/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin    -->
<script src="<?=base_url()?>dist/js/bootstrap-notify.js"></script>
<!--   Sharrre Library    -->
<script src="<?=base_url()?>dist/js/jquery.sharrre.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?=base_url()?>dist/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin -->
<script src="<?=base_url()?>dist/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin -->
<script src="<?=base_url()?>dist/js/nouislider.min.js"></script>
<!-- Select Plugin -->
<script src="<?=base_url()?>dist/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin    -->
<script src="<?=base_url()?>dist/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?=base_url()?>dist/js/sweetalert2.js"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?=base_url()?>dist/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?=base_url()?>dist/js/fullcalendar.min.js"></script>
<!-- TagsInput Plugin -->
<script src="<?=base_url()?>dist/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?=base_url()?>dist/js/material-dashboard2.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?=base_url()?>dist/js/demo.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		demo.initDashboardPageCharts();
		demo.initVectorMap();
	});
</script>
</html>
