<style type="text/css">
	.input-group .bootstrap-select.form-control {
  z-index: inherit;
}
</style>
<body>

<div class="wrapper">
	<?php $this->load->view('template/asesor/sidebar'); ?>
<div class="content">
	<div class="container-fluid">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="card-header card-header-icon" data-background-color="gray" style=" background: linear-gradient(45deg, #AEA16E, #96843D);">
					<i class="material-icons">list</i>
				</div>

				<form method="post" class="form-horizontal" action="<?=base_url()?>index.php/Asesor/editar_ds/" target="_blank" enctype="multipart/form-data">
					<!-- <div class="card-content" style="background-image: url('<?=base_url()?>dist/img/ar4c.png'); background-repeat: no-repeat;"> -->
						<div class="card-content">
							<h4 class="card-title"><B>Depósito de seriedad</B> - Formato</h4>
							<div class="row">
								<div class="col-lg-12">
									<p align="right"><label for="proyecto">FOLIO: <label style="color: red;"><?php echo $cliente[0]->clave;?></label></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<img src="<?=base_url()?>static/images/CM.png" alt="Servicios Condominales" title="Servicios Condominales" style="width:100%;align-self: center;"/>
								</div>

								<div class="col-md-9">
									<label class="col-sm-2 label-on-left">DESARROLLO:</label>
									<div class="col-sm-10 checkbox-radios">
										<div class="col-md-2 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" id="desarrollo" name="desarrollo" required <?php if($cliente[0]->desarrollo==1) echo "checked=true"?>  value="1" style="font-size: 0.9em;"/> Querétaro
												</label>
											</div>
										</div>

										<div class="col-md-2 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" id="desarrollo" name="desarrollo" required <?php if($cliente[0]->desarrollo==2) echo "checked=true"?>  value="2" style="font-size: 0.9em;"/> León
												</label>
											</div>
										</div>

										<div class="col-md-2 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" id="desarrollo" name="desarrollo" required <?php if($cliente[0]->desarrollo==3) echo "checked=true"?>  value="3" style="font-size: 0.9em;"/> Celaya
												</label>
											</div>
										</div>

										<div class="col-md-2 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" id="desarrollo" name="desarrollo" required <?php if($cliente[0]->desarrollo==4) echo "checked=true"?>  value="4" style="font-size: 0.9em;"/> San Luis Potosí
												</label>
											</div>
										</div>

										<div class="col-md-2 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" id="desarrollo" name="desarrollo" required <?php if($cliente[0]->desarrollo==5) echo "checked=true"?>  value="5" style="font-size: 0.9em;"/> Mérida
												</label>
											</div>
										</div>
									</div>


									<label class="col-sm-2 label-on-left">TIPO LOTE:</label>
									<div class="col-sm-10 checkbox-radios">
										<div class="col-md-2 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" name="tipoLote" value="0" <?php if($cliente[0]->tipoLote==0) echo "checked=true"?>> LOTE
												</label>
											</div>
										</div>

										<div class="col-md-3 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.9em;">
													<input type="radio" name="tipoLote" value="1" <?php if($cliente[0]->tipoLote==1) echo "checked=true"?>> LOTE COMERCIAL
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>


							<div class="row">
								<label class="col-sm-2 label-on-left">DOCUMENTACIÓN:</label>
								<div class="col-sm-10 checkbox-radios">

									<div class="col-md-2 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<b>Persona Fisica</b>
										</label>
									</div>

									<div class="col-md-3 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<input type="checkbox" name="idOficial_pf" value="1" <?php if($cliente[0]->idOficial_pf == 1){echo "checked";}  ?>>Identificación Oficial
										</label>
									</div>

									<div class="col-md-3 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<input type="checkbox" name="idDomicilio_pf" value="1" <?php if($cliente[0]->idDomicilio_pf == 1){echo "checked";}  ?>>Comprobante de Domicilio
										</label>
									</div>

									<div class="col-md-3 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<input type="checkbox" name="actaMatrimonio_pf" value="1" <?php if($cliente[0]->actaMatrimonio_pf == 1){echo "checked";}  ?>>Acta de Matrimonio
										</label>
									</div>
								</div>


								<div class="col-sm-10 checkbox-radios">

									<div class="col-md-2 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<b>Persona Moral</b>
										</label>
									</div>

									<div class="col-md-3 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<input type="checkbox" name="poder_pm" value="1" <?php if($cliente[0]->poder_pm == 1){echo "checked";}  ?>>Poder
										</label>
									</div>

									<div class="col-md-3 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<input type="checkbox" name="actaConstitutiva_pm" value="1" <?php if($cliente[0]->actaConstitutiva_pm == 1){echo "checked";}  ?>>Acta Constitutiva
										</label>
									</div>

									<div class="col-md-3 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<input type="checkbox" name="idOficialApoderado_pm" value="1" <?php if($cliente[0]->idOficialApoderado_pm == 1){echo "checked";}  ?>>Ide. Oficial Apoderado
										</label>
									</div>
								</div>

								<label class="col-sm-2 label-on-left"></label>
								<div class="col-sm-10 checkbox-radios">
									<div class="col-md-2 checkbox checkbox-inline">
									</div>

									<div class="col-md-1 checkbox checkbox-inline">
										<label style="font-size: 0.9em;">
											<input type="checkbox" name="" value="1" <?php if($cliente[0]->rfc == 1){echo "checked";}  ?>>RFC
										</label>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control" name="rfc"  onKeyPress="if(this.value.length==13) return false;" style="font-size: 0.9em;" value="<?php if($cliente[0]->rfc == 1){echo "checked";}  ?>">
									</div>

								</div>

							</div>

							<hr>

							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group label-floating">
										<label class="control-label" style="font-size: 0.8em;">
											NOMBRE
											(<small style="color: red;">*</small>)
										</label>
										<input class="form-control" name="nombre" id="nombre" type="text" required="true" value="<?=$cliente[0]->nombre?>  <?=$cliente[0]->apellido_paterno?> <?=$cliente[0]->apellido_materno?>" style="font-size: 0.9em;"/>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group label-floating">
										<label class="control-label" style="font-size: 0.8em;">
											TELEÉFONO CASA
										</label>
										<input class="form-control" name="telefono1" id="telefono1" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="<?=$cliente[0]->telefono1?>" style="font-size: 0.9em;"/>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group label-floating">
										<label class="control-label" style="font-size: 0.8em;">
											CELULAR
											(<small style="color: red;">*</small>)
										</label>
										<input class="form-control" name="telefono2" id="telefono2" type="number" step="any" onKeyPress="if(this.value.length==10) return false;" value="<?=$cliente[0]->telefono2?>" style="font-size: 0.9em;"/>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group label-floating">
										<label class="control-label" style="font-size: 0.8em;">
											EMAIL
											(<small style="color: red;">*</small>)
										</label>
										<input class="form-control" name="correo" id="correo" type="email" value="<?=$cliente[0]->correo?>" style="font-size: 0.9em;"/>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group label-floating select-is-empty">
										<label class="control-label" style="font-size: 0.8em;">
											FECHA NACIMIENTO
											(<small style="color: red;">*</small>)
										</label>
										<input class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" type="date" value="<?=$cliente[0]->fecha_nacimiento?>" style="font-size: 0.9em;"/>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group label-floating select-is-empty">
										<label class="control-label" style="font-size: 0.8em;">
											NACIONALIDAD
											(<small style="color: red;">*</small>)
										</label>
										<select name="nacionalidad" id="nacionalidad" class="form-control" style="font-size: 0.9em;"><option value="">- Selecciona opción -</option></select>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group label-floating">
										<label class="control-label" style="font-size: 0.8em;">
											ORIGINARIO DE:
											(<small style="color: red;">*</small>)
										</label>
										<input class="form-control" name="originario" id="originario" type="text" value="<?=$cliente[0]->originario?>" style="font-size: 0.9em;"/>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group label-floating select-is-empty">
										<label class="control-label" style="font-size: 0.8em;">
											ESTADO CIVIL
											(<small style="color: red;">*</small>)
										</label>
										<select name="estado_civil" id="estado_civil" class="form-control" style="font-size: 0.9em;"><option value="">- Selecciona opción -</option></select>
									</div>
								</div>


								<div class="col-md-4">
									<div class="form-group label-floating select-is-empty">
										<label class="control-label" style="font-size: 0.8em;">
											RÉGIMEN
										</label>
										<select name="regimen_matrimonial" id="regimen_matrimonial" class="form-control" style="font-size: 0.9em;"><option value="">- Selecciona opción -</option></select>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group label-floating">
										<label class="control-label" style="font-size: 0.8em;">
											NOMBRE DE CÓNYUGE
										</label>
										<input class="form-control" name="nombre_conyuge" id="nombre_conyuge" type="text" value="<?=$cliente[0]->nombre_conyuge?>" style="font-size: 0.9em;"/>
									</div>
								</div>
								
							</div>


							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group label-floating">
										<label class="control-label" style="font-size: 0.8em;">
											DOMICILIO PARTICULAR
											(<small style="color: red;">*</small>)
										</label>
										<input class="form-control" name="domicilio_particular" id="domicilio_particular" type="text" value="<?=$cliente[0]->domicilio_particular?>" style="font-size: 0.9em;"/>
									</div>
								</div>


									<div class="col-md-3">
										<div class="form-group label-floating">
                                            <label class="control-label" style="font-size: 0.8em;">
                                                OCUPACIÓN
                                                (<small style="color: red;">*</small>)
                                            </label>
                                            <input class="form-control" name="ocupacion" id="ocupacion" type="text" value="<?=$cliente[0]->ocupacion?>" style="font-size: 0.9em;"/>
                                        </div>

									</div>


									<div class="col-md-4">
										<div class="form-group label-floating">
                                            <label class="control-label" style="font-size: 0.8em;">
                                                EMPRESA EN LA QUE TRABAJA
                                            </label>
                                            <input class="form-control" name="empresa" id="empresa" type="text" value="<?=$cliente[0]->empresa?>" style="font-size: 0.9em;"/>
                                        </div>
									</div>


									<div class="col-md-3">
										<div class="form-group label-floating">
                                            <label class="control-label" style="font-size: 0.8em;">
                                                PUESTO
                                                (<small style="color: red;">*</small>)
                                            </label>
                                            <input class="form-control" name="puesto" id="puesto" type="text" value="<?=$cliente[0]->puesto?>" style="font-size: 0.9em;"/>
                                        </div>
									</div>


									<div class="col-md-2">
										<div class="form-group label-floating">
                                            <label class="control-label" style="font-size: 0.8em;">
                                                ANTIGÜEDAD <small style="font-size: 0.7em;">(AÑOS)</small>
                                            </label>
                                            <input class="form-control" name="antiguedad" id="antiguedad" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="<?=$cliente[0]->antiguedad?>" style="font-size: 0.9em;"/>
                                        </div>
									</div>
								</div>


								<div class="row">
									<div class="col-md-3">
										<div class="form-group label-floating">
                                            <label class="control-label" style="font-size: 0.8em;">
                                                EDAD AL MOMENTO DE FIRMA
                                                (<small style="color: red;">*</small>) <small style="font-size: 0.7em;">(AÑOS)</small>
                                            </label>
                                            <input class="form-control" name="edadFirma" id="edadFirma" onKeyPress="if(this.value.length==2) return false;"  type="number" step="any" value="<?=$cliente[0]->edadFirma?>" style="font-size: 0.9em;"/>
                                        </div>
									</div>


									<div class="col-md-7">
										<div class="form-group label-floating">
                                            <label class="control-label" style="font-size: 0.8em;">
                                                DOMICILIO EMPRESA
                                            </label>
                                            <input class="form-control" name="domicilio_empresa" id="domicilio_empresa" type="text" value="<?=$cliente[0]->domicilio_empresa?>" style="font-size: 0.9em;"/>
                                        </div>
									</div>


									<div class="col-md-2">
										<div class="form-group label-floating">
                                            <label class="control-label" style="font-size: 0.8em;">
                                                TELÉFONO EMPRESA
                                                (<small style="color: red;">*</small>)
                                            </label>
                                            <input class="form-control" name="telefono_empresa" id="telefono_empresa" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?=$cliente[0]->telefono_empresa?>" style="font-size: 0.9em;"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                	<div class="col-md-2 checkbox-radios">
                                		<div class="radio"  style="color: gray;">
                                			COPROPIETARIO(S):
                                		</div>
                                	</div>
                                </div>


                                <div class="row"><br></div>



                                <div class="row">
                                	<div class="col-md-2 checkbox-radios">
                                		<div class="radio"  style="color: gray;">
                                			VIVE EN CASA:
                                		</div>
                                	</div>

                                	<div class="col-md-1 checkbox-radios required">
                                		<div class="radio">
                                			<label style="font-size: 0.8em;align-self: left;">
                                				<input type="radio" name="tipo_vivienda" <?php if($cliente[0]->tipo_vivienda==1) echo "checked=true"?>>PROPIA
                                			</label>
                                		</div>
                                	</div>

                                	<div class="col-md-1 checkbox-radios required">
                                		<div class="radio">
                                			<label style="font-size: 0.8em;">
                                				<input type="radio" name="tipo_vivienda" <?php if($cliente[0]->tipo_vivienda==2) echo "checked=true"?>>RENTADA
                                			</label>
                                		</div>
                                	</div>

                                	<div class="col-md-1 checkbox-radios required">
                                		<div class="radio">
                                			<label style="font-size: 0.8em;">
                                				<input type="radio" name="tipo_vivienda" <?php if($cliente[0]->tipo_vivienda==3) echo "checked=true"?>>
													PAGÁNDOSE
												</label>
											</div>
										</div>

										<div class="col-md-1 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.8em;">
													<input type="radio" name="tipo_vivienda" <?php if($cliente[0]->tipo_vivienda==4) echo "checked=true"?>>
													FAMILIAR
												</label>
											</div>
										</div>

										<div class="col-md-1 checkbox-radios required">
											<div class="radio">
												<label style="font-size: 0.8em;">
													<input type="radio" name="tipo_vivienda" <?php if($cliente[0]->tipo_vivienda==5) echo "checked=true"?>>OTRO
												</label>
											</div>
										</div>
									</div>



									<div class="row"><br></div>



									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													EL SR(A):
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="nombre" id="nombre" type="text" required="true" value="<?=$cliente[0]->nombre?>  <?=$cliente[0]->apellido_paterno?> <?=$cliente[0]->apellido_materno?>" style="font-size: 0.9em;"/>
											</div>
										</div>
									</div>

									<div class="row">

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													SE COMPROMETE A ADQUIRIR EL LOTE No.
<!-- 													(<small style="color: red;">*</small>)
 -->												</label>
												<input class="form-control" name="nombreLote" id="nombreLote" type="text" required="true" value="<?=$cliente[0]->nombreLote?>" readonly="readonly" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													EN EL CLÚSTER
													<!-- (<small style="color: red;">*</small>) -->
												</label>
												<input class="form-control" name="nombreCondominio" id="nombreCondominio" type="text" required="true" value="<?=$cliente[0]->nombreCondominio?>" readonly="readonly" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													DE SUP. APROXIMADA
													<!-- (<small style="color: red;">*</small>) -->
												</label>
												<input class="form-control" name="sup" id="sup" type="text" required="true" value="<?=$cliente[0]->sup?>" readonly="readonly" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													No. REFERENCIA DE PAGO
													<!-- (<small style="color: red;">*</small>) -->
												</label>
												<input class="form-control" name="referencia" id="referencia" type="text" required="true" value="<?=$cliente[0]->referencia?>" readonly="readonly" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													COSTO POR M<sup>2</sup> LISTA
													<!-- (<small style="color: red;">*</small>) -->
												</label>
												<input class="form-control" name="costoM2" id="costoM2" type="text" required="true" value="<?=$cliente[0]->costoM2?>" readonly="readonly" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													COSTO POR M<sup>2</sup> FINAL
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="costom2f" id="costom2f" type="number" step="any" required="true" value="<?=$cliente[0]->costom2f?>" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													UNA VEZ QUE SEA AUTORIZADO EL PROYECTO
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="proyecto" id="proyecto" type="number" step="any" required="true" value="<?=$cliente[0]->proyecto?>"  style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													EN EL MUNICIPIO DE:
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="municipioDS" id="municipioDS" type="text" required="true" value="<?=$cliente[0]->municipioDS?>" style="font-size: 0.9em;"/>
											</div>
										</div>
									</div>


									<div class="row"></div>


									<div class="row">

										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.7em;">
													<br> LA UBICACIÓN DE LOTE PUEDE VARIAR DEBIDO A AJUSTES DEL PROYECTO
												</label>
											</div>
										</div>

										<div class="col-md-2">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													IMPORTE DE LA OFERTA
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="importOferta" id="importOferta" type="number" step="any" required="true" value="<?=$cliente[0]->importOferta?>" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-10">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													IMPORTE EN LETRA
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="letraImport" id="letraImport" type="text" required="true" value="<?=$cliente[0]->letraImport?>" style="font-size: 0.9em;"/>
											</div>
										</div>
									</div>


									<div class="row">
										<div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="row form-inline">
												<div class="col">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
														<label>El ofertante como garantía de seriedad de la operación, entrega en este momento la cantidad de <b>$</b>
															(<b><span style="color: red;">*</span></b>)
															<input class="form-control" name="cantidad" id="cantidad" type="text" required="true" value="<?=$cliente[0]->cantidad?>" style="font-size: 0.9em; text-align: center;"/>
															(<input class="form-control" name="letraCantidad" id="letraCantidad" type="text" required="true" value="<?=$cliente[0]->letraCantidad?>" style="font-size: 0.9em; text-align: center;"/>)
															, misma que se aplicará a cuenta del precio al momento de celebrar el contrato definitivo. El ofertante manifiesta que es su voluntad seguir aportando cantidades a cuenta de la siguiente forma.
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>


									<div class="row"><BR></div>


									<div class="row">
										<div class="col-md-2">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													SALDO DE DEPÓSITO
												</label>
												<input class="form-control" name="saldoDeposito" id="saldoDeposito" type="number" step="any" required="true" value="<?=$cliente[0]->saldoDeposito?>" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-2">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													APORTACIÓN MENSUAL
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="aportMensualOfer" id="aportMensualOfer" type="number" step="any" required="true" value="<?=$cliente[0]->aportMensualOfer?>" step="any" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-2">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													FECHA 1° APORTACIÓN
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="fecha1erAport" id="fecha1erAport" type="date" required="true" value="<?=$cliente[0]->fecha1erAport?>" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-1">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													PLAZO
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="plazo" id="plazo" type="number" step="any" required="true" value="<?=$cliente[0]->plazo?>" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													FECHA LIQUIDACIÓN DE DEPÓSITO
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="fechaLiquidaDepo" id="fechaLiquidaDepo" type="date" required="true" value="<?=$cliente[0]->fechaLiquidaDepo?>" style="font-size: 0.9em;"/>
											</div>
										</div>

										<div class="col-md-2">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													FECHA 2° APORTACIÓN
													(<small style="color: red;">*</small>)
												</label>
												<input class="form-control" name="fecha2daAport" id="fecha2daAport" type="date" required="true" value="<?=$cliente[0]->fecha2daAport?>" style="font-size: 0.9em;"/>
											</div>
										</div>
									</div>


									<div class="row"><br></div>


									<div class="row">
										<div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="row form-inline">
												<div class="col">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="justify">
														<label style="font-size: 0.7em;">
															Esta oferta tendrá una vigencia de 180 (ciento ochenta) días naturales. Dicho lapso de tiempo será para la firma del contrato privado el cual contendrá entre otras cláusulas, los términos y condiciones suspensivas que regulan esta oferta. En caso de no llevarse a cabo la firma del contrato, todo compromiso u obligación quedará sin efectos. En caso de que el ofertante realizara alguna aportación con cheque, éste será recibido salvo buen cobro y en el supuesto de que no fuera cobrable el título, esta operación también quedará sin efectos. En caso de cancelarse la presente operación o de no firmarse el contrato en el lapso arriba mencionado, la empresa cobrará al ofertante únicamente $10,000.00 (Diez mil pesos 00/100 m.n.) que cubren parcialmente los gastos generados por la operación. Que el ofertante sabe que como consecuencia de la modificación del proyecto por parte del desarrollador o de las autorizaciones definitivas emitidas por el Municipio correspondiente, la ubicación, la superficie, medidas y colindancias del lote señalado en el presente documento, así como la nomenclatura o el número definitivo de lotes del Desarrollo Inmobiliario, en el que se encuentra, puede variar, así mismo con motivo de ello, el lote puede sufrir afectaciones y/o servidumbres libres de construcción.<BR>Durante el periodo de contingencia derivado de la prevención contra el virus denominado COVID-19, la suscripción de éste Depósito de Seriedad, será documento suficiente para la formalización de la compraventa con la empresa titular del inmueble que por este medio adquiere el cliente. Una vez que se decrete el término del periodo de contingencia a que se hace referencia en el párrafo anterior, el comprador se compromete a suscribir el contrato de compraventa respectivo, mismo que le será entregado impreso en un periodo máximo de 60 (sesenta) días naturales, contados a partir del término del periodo de contingencia. De acuerdo a lo estipulado en el contrato de compraventa que habrá de suscribirse entre el comprador y el vendedor, la pena convencional en caso de que el comprador incumpla con cualquiera de sus obligaciones es del 25% (veinticinco por ciento) del precio total pactado. Una vez formalizada la compraventa y en caso de que el comprador solicite el envío del contrato de compraventa en forma digital, éste podrá ser solicitado a través de su asesor de ventas.
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>


									<div class="row"><br></div>


									<div class="row">
										<div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="row form-inline">
												<div class="col">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" align="justify">
														<label style="font-size: 0.9em;">En el Municipio de 
															(<small style="color: red;">*</small>)
															<input class="form-control" name="municipio2" id="municipio2" type="text" required="true" value="<?=$cliente[0]->municipio2?>" style="font-size: 0.9em; text-align: center;"/>, a 
															(<small style="color: red;">*</small>) 
															<input class="form-control" name="dia" id="dia" type="text" required="true" value="<?=$cliente[0]->dia?>" style="font-size: 0.9em; text-align: center;"/>, del mes de
															(<small style="color: red;">*</small>)
															<input class="form-control" name="mes" id="mes" type="text" required="true" value="<?=$cliente[0]->mes?>" style="font-size: 0.9em; text-align: center;"/>, del año 
															(<small style="color: red;">*</small>) 
															<input class="form-control" name="anio" id="anio" type="text" required="true" value="<?=$cliente[0]->anio?>" style="font-size: 0.9em; text-align: center;"/>
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>


									<div class="row"><br></div><hr>


									<div class="row">
										<div class ="col-md-6">
											<div class="col-md-10" align="center">
												<div class="form-group label-floating">
													<br><br><br> 

													<input class="form-control" type="text" required="true" value="<?=$cliente[0]->nombre?>  <?=$cliente[0]->apellido_paterno?> <?=$cliente[0]->apellido_materno?>" style="font-size: 0.9em; text-align: center;"/>
												</div>
												<label class="control-label" style="font-size: 0.8em;">Nombre y Firma <b> Ofertante (*)</b></label><label style="font-size: 0.6em;">Acepto que se realice una verificación de mis datos, en los teléfonos y correos que proporciono para el otorgamiento del crédito.
												</label>
											</div>
										</div>

										<div class ="col-md-6">
											<div class="col-md-10" align="center">
												<label class="control-label" style="font-size: 0.8em;"><b>REFERENCIAS PERSONALES</b></label>
											</div>

											<div class="col-md-2"></div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><BR></div>

											<div class="col-xs-12 col-sm-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12" style="background: #C9D0E5;">
												<div class="col">
													<div class="card" style="margin: 10px 0;">

												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ><br>
													<div class="row">
														<div class="col-md-5">
															<div class="form-group label-floating">
																<label class="control-label" style="font-size: 0.7em;">
																	NOMBRE
																	(<small style="color: red;">*</small>)
																</label>
																<input class="form-control" name="nombre1" id="nombre1" type="text" value="<?=$referencias[0]->nombre?>" style="font-size: 0.7em;"/>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group label-floating select-is-empty">
																<label class="control-label" style="font-size: 0.7em;">
																	PARENTESCO
																	(<small style="color: red;">*</small>)
																</label>
																<select name="parentesco1" id="parentesco1" class="form-control" style="font-size: 0.9em;"><option value="">- Selecciona opción -</option></select>
															</div>
														</div>

														<div class="col-md-3">
															<div class="form-group label-floating">
																<label class="control-label" style="font-size: 0.7em;">
																	TELÉFONO
																	(<small style="color: red;">*</small>)
																</label>
																<input class="form-control" name="telefono_empresa1" id="telefono_empresa1" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?=$referencias[0]->telefono?>" style="font-size: 0.7em;"/>
															</div>
														</div>

													</div>
												</div>



												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ><br>
													<div class="row">
														<div class="col-md-5">
															<div class="form-group label-floating">
																<label class="control-label" style="font-size: 0.7em;">
																	NOMBRE
																	(<small style="color: red;">*</small>)
																</label>
																<input class="form-control" name="nombre2" id="nombre2" type="text" value="<?=$referencias[1]->nombre?>" style="font-size: 0.7em;"/>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group label-floating select-is-empty">
																<label class="control-label" style="font-size: 0.7em;">
																	PARENTESCO
																	(<small style="color: red;">*</small>)
																</label>
																<select name="parentesco2" id="parentesco2" class="form-control" style="font-size: 0.9em;"><option value="">- Selecciona opción -</option></select>
															</div>
														</div>

														<div class="col-md-3">
															<div class="form-group label-floating">
																<label class="control-label" style="font-size: 0.7em;">
																	TELÉFONO
																	(<small style="color: red;">*</small>)
																</label>
																<input class="form-control" name="telefono_empresa2" id="telefono_empresa2" pattern="/^-?\d+\.?\d*$/*" onKeyPress="if(this.value.length==10) return false;"  type="number" step="any" value="<?=$referencias[1]->telefono?>" style="font-size: 0.7em;"/>
															</div>
														</div>

													</div>
												</div>

 
												
											</div>
										</div>
									</div>
											<!-- termina div 12 -->
										</div>
									</div>


									<div class="row"><br></div>


									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group label-floating">
												<label class="control-label" style="font-size: 0.8em;">
													OBSERVACIONES
													(<small style="color: red;">*</small>)
												</label>
												<textarea class="form-control" id="observacion" name="observacion"><?php echo $cliente[0]->observacion;?></textarea>
											</div>
										</div>
									</div>


									<div class="row"><br><br></div>
 

									<div class="row">
										<div class ="col-md-6">
											<div class="col-md-10" align="center">
												<div class="form-group label-floating">
													<input class="form-control" type="text" required="true" />
												</div>
												<label class="control-label" style="font-size: 0.8em;">Nombre y Firma <b> Asesor (*)</b></label>
											</div>
										</div>

										<div class ="col-md-6">
											<div class="col-md-10" align="center">
												<div class="form-group label-floating">
													<input class="form-control" type="text" required="true" />
												</div>
												<label class="control-label" style="font-size: 0.8em;">Nombre y Firma <b> Autorización de operación (*)</b></label>
											</div>
										</div>
									</div>


									<div class="row">
										<div class ="col-md-6">
											<div class="col-md-10" align="center">
												<div class="input-group">
													<span class="input-group-addon" id="basic-addon1"><label>Email Asesor: </label></span>
													<input name="correo_asesor" id="correo_asesor" type="text" style="font-size: 0.8em;" class="form-control" width="auto" value="<?=$cliente[0]->correo?>">
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class ="col-md-6">
											<div class="col-md-10" align="center">
												<div class="input-group"><br>
													<section>
														<div>
															<div class="togglebutton">
																<label>
																	<input id="pdfOK" name="pdfOK" type="checkbox"/><b style="color: #0A548B">ENVIAR A CLIENTE VÍA EMAIL</b>
																</label>
															</div>
														</div>
													</section>
												</div>
											</div>
										</div>
									</div>

								</div>

								<div class="card-footer text-center">
									<button type="submit" class="btn btn-primary btn-fill">GUARDAR CAMBIOS</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->load->view('template/footer_legend');?>

        </div>
        <div id="mensaje"></div>
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
	<script src="<?=base_url()?>dist/js/controllers/asesor/prospects-list-1.1.0.js"></script>

	<!--script of the page-->
	<script type="text/javascript">
		var url = "<?=base_url()?>";
		var url2 = "<?=base_url()?>/index.php/";
		var urlimg = "<?=base_url()?>/img/";

		$(document).ready(function(){
			$.post(url + "Asesor/getNationality", function(data) {
				var len = data.length;

				for(var i = 0; i<len; i++){
					var id = data[i]['id_opcion'];
					var name = data[i]['nombre'];
					var nat = <?=$cliente[0]->nacionalidad?>;

					if(nat==id){
						$("#nacionalidad").append($('<option selected=true>').val(id).text(name.toUpperCase()));
					}
					else{
						$("#nacionalidad").append($('<option>').val(id).text(name.toUpperCase()));
					}
				}
				$(".select-is-empty").removeClass("is-empty"); $("#nacionalidad").select('refresh');
			}, 'json');


			$.post(url + "Asesor/getCivilStatus", function(data) {
				var len = data.length;
				for(var i = 0; i<len; i++){
					var id = data[i]['id_opcion'];
					var name = data[i]['nombre'];
					var nat = <?=$cliente[0]->estado_civil?>;

					if(nat==id){
						$("#estado_civil").append($('<option selected=true>').val(id).text(name.toUpperCase()));
					}
					else{
						$("#estado_civil").append($('<option>').val(id).text(name.toUpperCase()));
					}
				}
				$(".select-is-empty").removeClass("is-empty"); $("#estado_civil").select('refresh');
			}, 'json');


			$.post(url + "Asesor/getMatrimonialRegime", function(data) {
				var len = data.length;
				for(var i = 0; i<len; i++){
					var id = data[i]['id_opcion'];
					var name = data[i]['nombre'];
					var nat = <?=$cliente[0]->regimen_matrimonial?>;

					if(nat==id){
						$("#regimen_matrimonial").append($('<option selected=true>').val(id).text(name.toUpperCase()));
					}
					else{
						$("#regimen_matrimonial").append($('<option>').val(id).text(name.toUpperCase()));
					}
				}
				$(".select-is-empty").removeClass("is-empty"); $("#regimen_matrimonial").select('refresh');
			}, 'json');
		 

		$.post(url + "Asesor/getParentesco", function(data) {
				var len = data.length;
				for(var i = 0; i<len; i++){
					var id = data[i]['id_opcion'];
					var name = data[i]['nombre'];
					var nat = <?=$referencias[0]->parentezco?>;

					if(nat==id){
						$("#parentesco1").append($('<option selected=true>').val(id).text(name.toUpperCase()));
					}
					else{
						$("#parentesco1").append($('<option>').val(id).text(name.toUpperCase()));
					}
				}
				$(".select-is-empty").removeClass("is-empty"); $("#parentesco1").select('refresh');
			}, 'json');
		

			$.post(url + "Asesor/getParentesco", function(data) {
				var len = data.length;
				for(var i = 0; i<len; i++){
					var id = data[i]['id_opcion'];
					var name = data[i]['nombre'];
					var nat = <?=$referencias[1]->parentezco?>;

					if(nat==id){
						$("#parentesco2").append($('<option selected=true>').val(id).text(name.toUpperCase()));
					}
					else{
						$("#parentesco2").append($('<option>').val(id).text(name.toUpperCase()));
					}
				}
				$(".select-is-empty").removeClass("is-empty"); $("#parentesco2").select('refresh');
			}, 'json');

			});

		 
 
	</script>
	</html>
