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
<div class="modal fade modal-alertas" id="ModalMsi" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form method="post" id="formMsi">
				<div class="modal-body"></div>
				<div class="modal-footer"></div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade modal-alertas" id="ModalAlert" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content text-center">
			<div class="modal-header">
			<h4>Una vez guardados los planes <br> ya no se podrá modificar la información</h4>
			</div>
					<div class="row">
						<div class="col-md-6 text-right">
						<button type="button" data-toggle="tooltip" data-placement="right" title="Guardar" class="btn btn-success btn-circle btn-lg" onclick="SavePaquete();" name=""  id=""><i class="fas fa-check"></i></button>
					</div>
					<div class="col-md-6 text-left">
						<button type="button" data-toggle="tooltip" data-placement="right" title="Cancelar" class="btn btn-danger btn-circle btn-lg" data-dismiss="modal"><i class="fas fa-times"></i></button>
					</div>
				</div>
				<br>
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
				<br>
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
		<div class="modal-content">
			
		</div>
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
<!------------------> 
  <!--<div class="row">
    <div class="col-6">
      <div class="">
        <div class="">
			<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">Precio total</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Enganche</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">M2</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="four" aria-selected="false">Bono</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="five-tab" data-toggle="tab" href="#five" role="tab" aria-controls="five" aria-selected="false">MSI</a>
				</li>
			</ul>
        </div>

        <div class="tab-content1" id="myTabContent">
          <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
            <h5 class="card-title">Descuentos al total</h5>
            <p class="card-text">Descuentos registrados</p>
            <a href="#" class="btn btn-primary"></a>    
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
          <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
            <h5 class="card-title">Tab Card Two</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>              
          </div>
          <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
            <h5 class="card-title">Tab Card Three</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>              
          </div>
		  <div class="tab-pane fade p-3" id="four" role="tabpanel" aria-labelledby="four-tab">
            <h5 class="card-title">Tab Card Three</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>              
          </div>
		  <div class="tab-pane fade p-3" id="five" role="tabpanel" aria-labelledby="five-tab">
            <h5 class="card-title">Tab Card Three</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>              
          </div>

        </div>
      </div>
    </div>
  </div>
-->

<!----------------> 

		</div>
	</div>
</div>
<!------------------------------------------------------------------------>
<!--<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card">
					<form id="form-paquetes" class="formulario">
						<div class="card-content">
							<h3 class="card-title center-align">Planes Corrida Financiera</h3>
							<div class="text-right"><button type="button" data-toggle="modal" onclick="llenarTables();" data-target="#exampleModal" id="btn_open_modal" class="btn btn-maderas">Ver descuentos</button></div>
							<div class="container-fluid p-0">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form1">
													<h4 class="card-title left-align">Datos generales</h4>
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
														<div class="form-group">
															<label class="m-0" for="sede">Sede (<b class="text-danger">*</b>)</label>
															<select name="sede" id="sede" class="selectpicker select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
															</select>
														</div>
													</div>
										
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
														<div class="form-group">
															<label class="m-0" for="sede">Proyecto (<b class="text-danger">*</b>)</label> 
															<select id="residencial"  name="residencial[]" multiple="multiple" class="form-control select-gral "  data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required></select>
															</select>
														</div>
													</div>
													
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 mb-1">          
														<div class="form-group">
															<label class="m-0" for="sede">Fecha Inicio (<b class="text-danger">*</b>)</label>
															<input class="form-control" name="fechainicio" id="fechainicio" type="date" required="true">
														</div>
													</div>

													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 mb-1">          
														<div class="form-group">
															<label class="m-0" for="sede">Fecha Fin (<b class="text-danger">*</b>)</label>
															<input class="form-control" name="fechafin" id="fechafin" type="date" required="true">
														</div>
													</div>
										
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form1">
												
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 mb-1">
																	<div class="form-group">
																		<label>Tipo de Lote (<b class="text-danger">*</b>):</label>
																				<div class="col-md-12"><br></div>
																							<div class="row">
																								<div class="col-md-12">
																									<div class="custom-control custom-radio custom-control-inline col-md-4">
																										<input type="radio" id="customRadioInline1" value="1" name="tipoLote">
																										<label class="custom-control-label" for="customRadioInline1">Habitacional</label>
																									</div>
																									<div class="custom-control custom-radio custom-control-inline col-md-4">
																										<input type="radio" id="customRadioInline2" value="2" name="tipoLote">
																										<label class="custom-control-label" for="customRadioInline2">Comercial</label>
																									</div>
																									<div class="custom-control custom-radio custom-control-inline col-md-4">
																										<input type="radio" id="customRadioInline3" value="3" name="tipoLote">
																										<label class="custom-control-label" for="customRadioInline3">Ambos</label>
																									</div>
																								</div>
																							</div>
																			</div>
																</div>

											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">          
														<div class="form-group">
															<label>Superficie (<b class="text-danger">*</b>):</label>
																		<div class="col-md-12"><br></div>
																			<div class="row">
																					<div class="col-md-12">
																						<div class="custom-control custom-radio custom-control-inline col-md-4">
																							<input type="radio" id="customRadio1" value="1" name="superficie" onclick="selectSuperficie(1)">
																							<label class="custom-control-label" for="customRadio1">Mayor a</label>
																						</div>
																						<div class="custom-control custom-radio custom-control-inline col-md-4">
																							<input type="radio" id="customRadio2" value="2" name="superficie" onclick="selectSuperficie(2)">
																							<label class="custom-control-label" for="customRadio2">Rango</label>
																						</div>
																						<div class="custom-control custom-radio custom-control-inline col-md-4">
																							<input type="radio" id="customRadio3" value="3" name="superficie" onclick="selectSuperficie(3)">
																							<label class="custom-control-label" for="customRadio3">Cualquiera</label>
																						</div>
																					</div>
																			</div>
																		</div>
														</div>

															<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
																<div class="form-group">
																	<div id="printSuperficie">
																	</div>
																</div>
															</div>

											<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form1">
										 
											<div class="form-group d-flex justify-left align-center col-md-12">
												<button type="button" class="btn btn-success btn-circle btn-lg" data-toggle="tooltip" data-placement="top" title="Agregar paquete" onclick="GenerarCard()"><i class="fas fa-plus"></i></button>
												<input type="hidden" value="0" name="index" id="index">
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row rowCards" id="showPackage"></div>
						</div>
						
						<div class="text-right">
							<button type="submit" id="btn_save" class="btn btn-success">Guardar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>---> 
<div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">        
                        <ul class="nav nav-tabs nav-tabs-cm" role="tablist">
                            <li class="active"><a href="#nuevas-1" role="tab" data-toggle="tab">CARGAR PLAN</a></li>
                            <li><a href="#proceso-1" role="tab" data-toggle="tab">VER PLANES</a></li>
                        </ul>
                        
                        <div class="card no-shadow m-0 border-conntent__tabs">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas-1">
										<form id="form-paquetes" class="formulario">




                                            <div class="text-center">
                                                <h3 class="card-title center-align">Planes Corrida Financiera</h3>
                                                <!--<p class="card-title pl-1">(Pagos ya validados por el área de cobranza MKTD, actualmente se encuentran en espera de dispersión por parte de dirección)</p>-->
												<div class="text-right"><button type="button" data-toggle="modal" onclick="llenarTables();" data-target="#exampleModal" id="btn_open_modal" class="btn btn-maderas">Ver descuentos</button></div>
                                            </div>
                                            <!-------------------------------------------------------> 
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form1">
															<h4 class="card-title left-align">Datos generales</h4>
															<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
																<div class="form-group">
																	<label class="m-0" for="sede">Sede (<b class="text-danger">*</b>)</label>
																	<select name="sede" id="sede" class="select-gral" data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required>
																	</select>
																</div>
															</div>
										
															<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">
																<div class="form-group">
																	<label class="m-0" for="sede">Proyecto (<b class="text-danger">*</b>)</label> 
																	<select id="residencial"  name="residencial[]" multiple="multiple" class="form-control select-gral "  data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required></select>
																	</select>
																</div>
															</div>
															
															<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 mb-1">          
																<div class="form-group">
																	<label class="m-0" for="sede">Fecha Inicio (<b class="text-danger">*</b>)</label>
																	<input class="form-control" name="fechainicio" id="fechainicio" type="date" required="true">
																</div>
															</div>

																<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 mb-1">          
																	<div class="form-group">
																		<label class="m-0" for="sede">Fecha Fin (<b class="text-danger">*</b>)</label>
																		<input class="form-control" name="fechafin" id="fechafin" type="date" required="true">
																	</div>
																</div>
										
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form1">
												
												<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 mb-1">
																		<div class="form-group">
																			<label>Tipo de Lote (<b class="text-danger">*</b>):</label>
																								<div class="col-md-12"><br></div>
																								<div class="row">
																									<div class="col-md-12">
																										<div class="custom-control custom-radio custom-control-inline col-md-4">
																											<input type="radio" id="customRadioInline1" value="1" name="tipoLote">
																											<label class="custom-control-label" for="customRadioInline1">Habitacional</label>
																										</div>
																										<div class="custom-control custom-radio custom-control-inline col-md-4">
																											<input type="radio" id="customRadioInline2" value="2" name="tipoLote">
																											<label class="custom-control-label" for="customRadioInline2">Comercial</label>
																										</div>
																										<div class="custom-control custom-radio custom-control-inline col-md-4">
																											<input type="radio" id="customRadioInline3" value="3" name="tipoLote">
																											<label class="custom-control-label" for="customRadioInline3">Ambos</label>
																										</div>
																									</div>
																								</div>
																		</div>
												</div>

											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 mb-1">          
																	<div class="form-group">
																		<label>Superficie (<b class="text-danger">*</b>):</label>
																					<div class="col-md-12"><br></div>
																						<div class="row">
																								<div class="col-md-12">
																									<div class="custom-control custom-radio custom-control-inline col-md-4">
																										<input type="radio" id="customRadio1" value="1" name="superficie" onclick="selectSuperficie(1)">
																										<label class="custom-control-label" for="customRadio1">Mayor a</label>
																									</div>
																									<div class="custom-control custom-radio custom-control-inline col-md-4">
																										<input type="radio" id="customRadio2" value="2" name="superficie" onclick="selectSuperficie(2)">
																										<label class="custom-control-label" for="customRadio2">Rango</label>
																									</div>
																									<div class="custom-control custom-radio custom-control-inline col-md-4">
																										<input type="radio" id="customRadio3" value="3" name="superficie" onclick="selectSuperficie(3)">
																										<label class="custom-control-label" for="customRadio3">Cualquiera</label>
																									</div>
																								</div>
																						</div>
																					</div>
																	</div>

																		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 mb-1">
																			<div class="form-group">
																				<div id="printSuperficie">
																				</div>
																			</div>
																		</div>

																		<div class="row">
																				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form1">
																			
																						<div class="form-group d-flex justify-left align-center col-md-12">
																							<button type="button" class="btn btn-success btn-circle btn-lg" data-toggle="tooltip" data-placement="top" title="Agregar plan" onclick="GenerarCard()"><i class="fas fa-plus"></i></button>
																							<input type="hidden" value="0" name="index" id="index">
																						</div>
																				</div>
																		</div>
												</div>
							
													<div class="row rowCards" id="showPackage"></div>
						</div>
						
													<div class="text-right">
														<button type="submit" id="btn_save" class="btn btn-success">Guardar</button>
													</div>
					</div>
											<!-------------------------------------------------------> 




										</form>
                                        </div>
                                        <div class="tab-pane" id="proceso-1">
                                            <div class="text-center">
                                                <h3 class="card-title center-align">Planes cargados</h3>
                                                <!--<p class="card-title pl-1">(Lotes correspondientes a comisiones solicitadas para pago por el área de MKTD, en espera de validación contraloría y pago de internomex)</p>-->
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                   
                                                </div>
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
        </div>
<!------------------------------------------------------------------>


<div id="snackbar"><i class="fas fa-check"></i> ¡MSI agregado con éxito!</div>
</div>

<?php $this->load->view('template/footer_legend');?>
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
/**-------------------------------------------------------------------------------------------------------------------------------------------------- */
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
  // format number 1000000 to 1,234,567
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
/**-------------------------------------------------------------------------------------------------------------------------------------------------- */

function CloseModalSave(boton){
	$('#ModalFormAddDescuentos').modal('toggle');
	//$('#exampleModal').modal('toggle');
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
                        table_total
                        .column(i)
                        .search(this.value)
                        .draw();
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
                        table_enganche
                        .column(i)
                        .search(this.value)
                        .draw();
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
                        table_m2
                        .column(i)
                        .search(this.value)
                        .draw();
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
                        table_bono
                        .column(i)
                        .search(this.value)
                        .draw();
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
                        table_msi
                        .column(i)
                        .search(this.value)
                        .draw();
                    }
                });
            }
        });
		
function llenarTables(){
	/**TB TOTAL */


        table_total = $("#table_total").DataTable({
            dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
            width: "auto",
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className: 'btn buttons-excel',
                titleAttr: 'Descargar archivo de Excel',
                title: 'DESCUENTOS AL PRECIO TOTAL',
                /*exportOptions: {
                    columns: [0,1,2],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID USUARIO';
                                }
                                else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'SEDE USUARIO';
                                }
                            }
                        }
                },*/
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
            columns: [
				
				{
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
                /*exportOptions: {
                    columns: [0,1,2],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID USUARIO';
                                }
                                else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'SEDE USUARIO';
                                }
                            }
                        }
                },*/
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
                /*exportOptions: {
                    columns: [0,1,2],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID USUARIO';
                                }
                                else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'SEDE USUARIO';
                                }
                            }
                        }
                },*/
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
                /*exportOptions: {
                    columns: [0,1,2],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID USUARIO';
                                }
                                else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'SEDE USUARIO';
                                }
                            }
                        }
                },*/
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
                /*exportOptions: {
                    columns: [0,1,2],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID USUARIO';
                                }
                                else if(columnIdx == 1){
                                    return 'USUARIO';
                                }else if(columnIdx == 2){
                                    return 'SEDE USUARIO';
                                }
                            }
                        }
                },*/
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

	/** */
	console.log(arr);
}
/**------------------------------------------ */

		$('[data-toggle="tooltip"]').tooltip()

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
	function myFunction() {
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.className = "show";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
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
        });
		$("#sede").change(function() {
			$('#residencial option').remove();
			var parent = $(this).val();
			var	datos = parent.split(',')
			var	id_sede = datos[0];
			$.post('getResidencialesList/'+id_sede, function(data) {
                $("#residencial").append($('<option disabled>').val("default").text("Seleccione una opción"));
				console.log(data.length);
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
		function ShowAlert(){

		}

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
	/**
	 * 
	 * <div class="form-group col-md-12" id="">
														<label class="label">Lote origen</label>
														<select id="idResidencial_${indexNext}"  name="${indexNext}_idResidencial[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
												</div>
												<div class="form-group col-md-12 form-inline">
														<div class="custom-control custom-radio custom-control-inline col-md-4">
														<input type="radio" id="customRadioInline4" name="customRadioInline1" class="custom-control-input radio_container">
														<label class="custom-control-label" for="customRadioInline4">Habitacional</label>
														</div>
														<div class="custom-control custom-radio custom-control-inline col-md-4">
														<input type="radio" id="customRadioInline6" name="customRadioInline1" class="custom-control-input radio_container">
														<label class="custom-control-label" for="customRadioInline6">Comercial</label>
														</div>
														<div class="custom-control custom-radio custom-control-inline col-md-4">
														<input type="radio" id="customRadioInline6" name="customRadioInline1" class="custom-control-input radio_container">
														<label class="custom-control-label" for="customRadioInline6">Ambos</label>
														</div>
													</div>
	 * 
	 */
	
		function GenerarCard(){
			if($('#sede').val() != '' && $('#residencial').val() != '' && $('input[name="tipoLote"]').is(':checked') && $('#fechainicio').val() != '' && $('#fechafin').val() != '' && $('input[name="superficie"]').is(':checked') ){
			var indexActual = document.getElementById('index');
			var indexNext = (document.getElementById('index').value - 1) + 2;
			indexActual.value = indexNext;
			console.log(indexNext);
			$('.rowCards').append(`	
							<div class="card border-primary mb-3 boxCard" style="max-width: 45rem;" id="card_${indexNext}">
							<div class="row">
								<div class="col-md-8 text-center">
									<h4 class="card-title title-plan"><b>Plan</b></h4>
								</div>
								<div class="col-md-4">
									<div class="text-right">
										<button type="button" class="btn btn-lg btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Eliminar plan" id="btn_delete_${indexNext}" onclick="removeElementCard('card_${indexNext}')"><i class="fas fa-trash"></i></button>
									</div>
								</div>
							</div>
								
								<div class="card-body text-primary myCard">
									
												<div class="form-group col-md-12" id="">
														<label class="">Descripción plan(<b class="text-danger">*</b>):</label>
														<input type="text" class="form-control input-gral" required name="descripcion_${indexNext}" id="descripcion_${indexNext}">
														
														</div>
													<div  id="checks_${indexNext}">
													</div>						
												<div class="form-group col-md-12" id="tipo_descuento_select_${indexNext}">
												</div>
</div>`);
$('[data-toggle="tooltip"]').tooltip()
/**
 * 
 * <div class="form-group col-md-12" id="">
														<label class="label">Descuento a</label>
														<select id="tipo_descuento_${indexNext}" onchange="changeTipoDescuento(${indexNext})"  name="${indexNext}_tipo_descuento[]" class="form-control directorSelect2"  required data-live-search="true"></select>
												</div>
 */
$.post('getResidencialesList', function(data) {
                $("#idResidencial_"+indexNext).append($('<option disabled>').val("default").text("Seleccione una opción"));
				console.log(data.length);
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
			$("#idResidencial_"+indexNext).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",
});
			/**-----------TIPO DESCUENTO------------------ */
			$.post('getTipoDescuento', function(data) {
                $("#tipo_descuento_"+indexNext).append($('<option>').val("default").text("Seleccione una opción"));
				console.log(data.length);
                var len = data.length;

				$('#checks_'+indexNext).append(`
				<div class="row">

						<div class="col-md-4">
						<b>Descuento a</b>
						</div>
						<div class="col-md-8 text-center">
						<b>Descuentos</b>
						</div>
					</div>
				`);
				/**
				 * 
				 * <div class="col-md-2">
						<div class="form-group">
							<select class="select-gral-number text-center" name="${indexNext}_${i}_orden" disabled id="orden_${indexNext}_${i}" onchange="ValidarOrden(${indexNext},${i})" >
							<option value=""></option>
							<option value="1"><b>1</b></option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							</select>
						</div>
					</div>
				 */
                for( var i = 0; i<len; i++){
                    var id = data[i]['id_tcondicion'];
                    var descripcion = data[i]['descripcion'];
                    $("#tipo_descuento_"+indexNext).append(`<option value='${id}'>${descripcion}</option>`);
					$("#checks_"+indexNext).append(`
					
					<div class="row" >
					
						<div class="col-md-4" >
								<label class="check-box1" for="inlineCheckbox1">
								<input class="check-box__switcher" type="checkbox" onclick="PrintSelectDesc(${id},${i},${indexNext})" id="inlineCheckbox1_${indexNext}_${i}" value="${id}">
								${descripcion}</label>
						</div>
						<div class="col-md-8"  id="selectDescuentos_${indexNext}_${i}">
						</div>
						<div class="row" >
						<div class="col-md-1"></div>
						<div class="col-md-10" id="listamsi_${indexNext}_${i}"></div>
						<div class="col-md-1"></div>
						</div>
					</div>
					`);
                }
                if(len<=0){
                    $("#tipo_descuento_"+indexNext).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#tipo_descuento_"+indexNext).selectpicker('refresh');
            }, 'json');
			/**--------------------------------------------- */



			$('.popover-dismiss').popover({
  trigger: 'focus'
})
//}else{
				
			}else{
				alerts.showNotification("top", "left", "Debe llenar todos los campos requeridos.", "warning");

			}
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
			}else{
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
				<div class="col-md-12 text-center">
				</div>
				<div class="col-md-10 text-center">
					<div class="form-group text-center">
					<input type="number" placeholder="Cantidad" onkeyup="validarMsi(${indexN},${i})" class="input-descuento" id="input_msi_${indexN}_${i}">
					</div>
				</div>
				</div>

			`);
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
			console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');

			// document.getElementById(id).value = 122;
			var s = document.getElementById(id);
			console.log('este es el id '+id)

				});
		}

		function AddMsi(indexN,i,select,id,text2,pesos = 0){
			console.log(indexN)
			console.log(i)
			console.log(select)
			console.log(id)
			console.log(text2)

			let valorMsi = $(`#input_msi_${indexN}_${i}`).val();
			console.log(id)
			console.log(text2)
			console.log(select)
			console.log('-------------b-----------');
			//console.log($(`#${select}${indexN}_${i}`).select2('text'));
			console.log($(`#${select}${indexN}_${i}`).select2('val'));
			console.log('-------------b-----------');
			let selecdes = $(`#${select}${indexN}_${i}`);
			console.log(selecdes)
			console.log(selecdes[0].length)
			//console.log(selecdes.options[0])
			console.log(selecdes[0][19]);
			let texto = pesos != 0 ? '$'+formatMoney(text2) : text2;
			$(`#listamsi_${indexN}_${i}`).append(`
			<span class="label label-success color_span" id="${indexN}_${id}_span" >${texto}% + ${valorMsi} MSI</span>
			<input type="hidden" name="${indexN}_${id}_msi" id="${indexN}_${id}_msi" value="${id},${valorMsi}"> 
			`)
			/*for (i = 0; i < selecdes[0].length; i++) {
				if (selecdes[0][i].value = id) {
					// Realizar acciones
					selecdes[0][i].text = text2 + ' + '+ valorMsi + ' MSI';
				}
			}*/
			CloseModalMsi();
			//alerts.showNotification("buttom", "right", "MSI agregado con éxito.", "success");
			myFunction();
		// otra(indexN,i,select,id,text2);
	/*	$(`#${select}${indexN}_${i}`).on("select2:unselect",function (evt){
			console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');

					var element = evt.params.data.element;
					var $element = $(element);
					$element.detach();
					$(this).append($element);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					console.log($element[0]);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					$(this).trigger("change");
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].value);
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].label);

				});*/
			
		let idDescuentoSeleccionado = $(`#${select}${indexN}_${i} option:selected`).val();
		let TextDescuentoSeleccionado = $(`#${select}${indexN}_${i} option:selected`).text();
		console.log(idDescuentoSeleccionado);
		console.log(TextDescuentoSeleccionado);
		console.log($(`#${select}${indexN}_${i}`).select2('val'));
		console.log('------------------------');
		//$(`#ListaDescuentosTotal_${indexN}_${i}`).data();
		//$(`#ListaDescuentosTotal_${indexN}_${i}`).find('data-select2-id:25').attr('custom-attribute');//(`${text} + ${valorMsi} MSI `);
		//console.log($(`#ListaDescuentosTotal_${indexN}_${i}`).on('select2:selected').text('454'));
		
		
		}


		function CloseModalMsi(){
			const Modalbody = $('#ModalMsi .modal-body');
			const Modalfooter = $('#ModalMsi .modal-footer');
			Modalbody.html('');
			Modalfooter.html('');
			$("#ModalMsi").modal('toggle');
		}
function PrintSelectDesc(id,index,indexGral){
	let tdescuento=0;
	let id_condicion=0;
	let eng_top=0;
	let apply=0;


//onchange="ModalMsi(${indexGral},${index},'ListaDescuentosTotal_')"
	if(id == 1){
		if($(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked')){	
			$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
			tdescuento=1;
			id_condicion=1;
			apply=1;			
			///TOTAL DE LOTE
			$(`#selectDescuentos_${indexGral}_${index}`).append(`
		<div class="form-group d-flex justify-center align-center">
		<div id="divmsi_${indexGral}_${index}">
		</div>
		<label>Descuento(<b class="text-danger">*</b>):</label>
		<select id="ListaDescuentosTotal_${indexGral}_${index}" required   name="${indexGral}_${index}_ListaDescuentosTotal_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
		</div>`);
		$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
					$(`#ListaDescuentosTotal_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
					console.log(data.length);
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
				$(`#ListaDescuentosTotal_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true,tokenSeparators: [',', ' ']	});
				$(`#ListaDescuentosTotal_${indexGral}_${index}`).on("select2:select", function (evt){

					var element = evt.params.data.element;
					var $element = $(element);
					$element.detach();
					$(this).append($element);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					console.log($element[0]);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					$(this).trigger("change");
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].value);
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].label);
					ModalMsi(indexGral,index,'ListaDescuentosTotal_',$element[0].value,$element[0].label);
				});
				$(`#ListaDescuentosTotal_${indexGral}_${index}`).on("select2:unselecting", function (evt){
					console.log(evt);
					var element = evt.params.args.data.element;
					var $element = $(element);
					$element.detach();
					$(this).append($element);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					console.log($element[0]);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					$(this).trigger("change");
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].value);
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].label);
					var classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
					console.log(classnameExists);
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
	}else if(id == 2){
		if( $(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked') ) {	
			$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
		tdescuento=2;
		id_condicion=2;		
		///TOTAL DE ENGANCHE
		$(`#selectDescuentos_${indexGral}_${index}`).append(`
	<div class="form-group d-flex justify-center align-center">
	<label>Descuento(<b class="text-danger">*</b>):</label>
	<select id="ListaDescuentosEnganche_${indexGral}_${index}" required  name="${indexGral}_${index}_ListaDescuentosEnganche_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
	</div>`);
	$(`#ListaDescuentosEnganche_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",	});
	$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
                $(`#ListaDescuentosEnganche_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
				console.log(data.length);
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
			$(`#ListaDescuentosEnganche_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true	});
			$(`#ListaDescuentosEnganche_${indexGral}_${index}`).on("select2:select", function (evt) {
					var element = evt.params.data.element;
					var $element = $(element);
					
					$element.detach();
					$(this).append($element);
					$(this).trigger("change");
					ModalMsi(indexGral,index,'ListaDescuentosEnganche_',$element[0].value,$element[0].label);
				});
				$(`#ListaDescuentosEnganche_${indexGral}_${index}`).on("select2:unselecting", function (evt){
					console.log(evt);
					var element = evt.params.args.data.element;
					var $element = $(element);
					$element.detach();
					$(this).append($element);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					console.log($element[0]);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					$(this).trigger("change");
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].value);
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].label);
					var classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
					console.log(classnameExists);
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

	}else if(id == 5){
		if( $(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked') ) {
			$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
	
		tdescuento=1;
		id_condicion=4;
		apply=1;			
		
		///TOTAL DE ENGANCHE
		$(`#selectDescuentos_${indexGral}_${index}`).append(`
	<div class="form-group d-flex justify-center align-center">
	<label>Descuento(<b class="text-danger">*</b>):</label>
	<select id="ListaDescuentosM2_${indexGral}_${index}" required name="${indexGral}_${index}_ListaDescuentosM2_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
	</div>`);
	$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
                $(`#ListaDescuentosM2_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
				console.log(data.length);
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
					ModalMsi(indexGral,index,'ListaDescuentosM2_',$element[0].value,$element[0].label,1);

				});
				$(`#ListaDescuentosM2_${indexGral}_${index}`).on("select2:unselecting", function (evt){
					console.log(evt);
					var element = evt.params.args.data.element;
					var $element = $(element);
					$element.detach();
					$(this).append($element);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					console.log($element[0]);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					$(this).trigger("change");
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].value);
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].label);
					var classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
					console.log(classnameExists);
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
		if( $(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked') ) {	
			$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
		tdescuento=1;
		id_condicion=12;
		eng_top=1;
		apply=1;			
		///TOTAL DE ENGANCHE
		$(`#selectDescuentos_${indexGral}_${index}`).append(`
	<div class="form-group d-flex justify-center align-center">
	<label>Descuento(<b class="text-danger">*</b>):</label>
	<select id="ListaDescuentosBono_${indexGral}_${index}" required name="${indexGral}_${index}_ListaDescuentosBono_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
	</div>`);
	$(`#ListaDescuentosBono_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true});
	$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
                $(`#ListaDescuentosBono_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
				console.log(data.length);
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
			$(`#ListaDescuentosBono_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true	});
			$(`#ListaDescuentosBono_${indexGral}_${index}`).on("select2:select", function (evt) {
					var element = evt.params.data.element;
					var $element = $(element);
					$element.detach();
					$(this).append($element);
					$(this).trigger("change");
					ModalMsi(indexGral,index,'ListaDescuentosBono_',$element[0].value,$element[0].label,1);

				});
				$(`#ListaDescuentosBono_${indexGral}_${index}`).on("select2:unselecting", function (evt){
					console.log(evt);
					var element = evt.params.args.data.element;
					var $element = $(element);
					$element.detach();
					$(this).append($element);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					console.log($element[0]);
					console.log('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
					$(this).trigger("change");
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].value);
					console.log('zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz');
					console.log($element[0].label);
					var classnameExists = !!document.getElementById(`${indexGral}_${$element[0].value}_msi`);
					console.log(classnameExists);
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

	}else if(id == 13){
		if( $(`#inlineCheckbox1_${indexGral}_${index}`).is(':checked') ) {	
			$(`#orden_${indexGral}_${index}`).prop( "disabled", false );
		tdescuento=1;
		id_condicion=13;
		eng_top=1;
		apply=1;			
		///TOTAL DE ENGANCHE
		$(`#selectDescuentos_${indexGral}_${index}`).append(`
	<div class="form-group d-flex justify-center align-center">
	<label>Descuento(<b class="text-danger">*</b>):</label>
	<select id="ListaDescuentosMSI_${indexGral}_${index}" required name="${indexGral}_${index}_ListaDescuentosMSI_[]" multiple="multiple" class="form-control"  required data-live-search="true"></select>
	</div>`);
	$(`#ListaDescuentosMSI_${indexGral}_${index}`).select2({containerCssClass: "select-gral",dropdownCssClass: "custom-dropdown",tags: true});
	$.post('getDescuentosPorTotal',{ tdescuento: tdescuento, id_condicion: id_condicion,eng_top:eng_top,apply:apply }, function(data) {
                $(`#ListaDescuentosMSI_${indexGral}_${index}`).append($('<option disabled>').val("default").text("Seleccione una opción"));
				console.log(data.length);
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

			console.log(tipoDescuento);
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
			//alert(tipoDescuento);
		}
			 

		function selectSuperficie(tipoSup){
	document.getElementById("printSuperficie").innerHTML ='';
	if(tipoSup == 1){
		$('#printSuperficie').append(`
		<div class="form-group">
		<div class="form-group col-md-12">
		<input type="number" class="form-control input-gral" name="fin" placeholder="Mayor a">
		</div>

		<div class="form-group col-md-0">
		
		<input type="hidden" class="form-control" value="0" name="inicio">

		</div>
		</div>`);

	}else if(tipoSup == 2){
		$('#printSuperficie').append(`<div class="row">
		<div class="form-group col-md-6">
		<input type="number" class="form-control input-gral" name="inicio" placeholder="Inicio">
		</div>

		<div class="form-group col-md-6">
		<input type="number" class="form-control input-gral" name="fin" placeholder="Fin">
		</div>

		</div>`);

	}else if(tipoSup == 3){
		$('#printSuperficie').append(`	
		<div class="form-group col-md-6">
		<input type="hidden" class="form-control" name="inicio" value="0">
		</div>
		<div class="form-group col-md-6">
		<input type="hidden" class="form-control" name="fin" value="0">
		</div>`);
	}	
}
/*function selectSuperficie(tipoSup,index){
	document.getElementById("printSuperficie_"+index).innerHTML ='';
	if(tipoSup == 1){
		$('#printSuperficie_'+index).append(`	
	<div class="form-group">
	<input type="hidden" class="form-control" value="" name="inicio_${index}">
		<input type="number" class="form-control input-gral" name="fin_${index}" placeholder="mayor a">
	</div>
	`);
	}else if(tipoSup == 2){
		$('#printSuperficie_'+index).append(`	
	<div class="form-group col-md-6">
		<input type="number" class="form-control input-gral" name="inicio_${index}" placeholder="inicio">
	</div>
	<div class="form-group col-md-6">
		<input type="number" class="form-control input-gral" name="fin_${index}" placeholder="fin">
	</div>
	`);
	}else if(tipoSup == 3){
		$('#printSuperficie_'+index).append(`	
	<div class="form-group col-md-6">
		<input type="hidden" class="form-control" name="inicio_${index}" value="">
	</div>
	<div class="form-group col-md-6">
		<input type="hidden" class="form-control" name="fin_${index}" value="">
	</div>
	`);
	}	
}*/

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
    /*var result = window.confirm("¿Desea remover este elemento?");
    if (result == true) {
        $("#" + divNum + "").remove();
        $("#" + gral + "").remove();
    }
    return false;*/
}
function aver(){
	var indexActual = document.getElementById('index');
			var indexNext = (document.getElementById('index').value - 1) + 2;
			indexActual.value = indexNext;
	$('#myTab').append(`<li class="">
										<a href="#home_${indexNext}" data-toggle="tab" title="welcome">
										<span class="round-tabs one">
												<i class="glyphicon glyphicon-list-alt"></i>
										</span> 
										</a>
									</li>`);
	$('.tab-content').append(`<div class="tab-pane fade in" id="home_${indexNext}">

<h3 class="head text-center">Welcome ${indexNext}<sup>™</sup> <span style="color:#f48260;">♥</span></h3>


	<p class="text-center">
<a href="#" onclick="aver();" class="btn btn-success btn-outline-rounded green"> start using bootsnipp <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></a>
	</p>
</div>`);
}

function AddPackage(){

	var indexActual = document.getElementById('index');
			var indexNext = (document.getElementById('index').value - 1) + 2;
			indexActual.value = indexNext;
			let sede = $('#sede').val(); 
			let inicio = $('#inicio').val(); 
			let fin =$('#fin').val(); 
			console.log(sede)
	//		if(sede == '' || inicio == '' || fin == ''){
	//			alerts.showNotification("top", "right", "Debe llenar todos los campos.", "warning");
		//	}else{
				//CREAR EL FORM
				$('.rowCards').append(`
                <div class="board">
                    <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
              		<div class="board-inner">
						<ul class="nav nav-tabs" id="myTab">
							<div class="liner"></div>
									<li class="active">
										<a href="#home" data-toggle="tab" title="welcome">
										<span class="round-tabs one">
												<i class="glyphicon glyphicon-list-alt"></i>
										</span> 
										</a>
									</li>

						</ul>
					</div>
                     <div class="tab-content">
						<div class="tab-pane fade in active" id="home">

							<h3 class="head text-center">Welcome to Bootsnipp<sup>™</sup> <span style="color:#f48260;">♥</span></h3>
							<p class="narrow text-center">
								Lorem ipsum dolor sit amet, his ea mollis fabellas principes. Quo mazim facilis tincidunt ut, utinam saperet facilisi an vim.
							</p>  
								<p class="text-center">
							<a href="#" onclick="aver();" class="btn btn-success btn-outline-rounded green"> start using bootsnipp <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></a>
								</p>
						</div>
                  
					</div>
			<div class="clearfix"></div>
			</div>
			</div>
          `);
		//	}
		}
		/*function Llamar(i){
			$.post('getResidencialesList', function(data) {
                $("#idResidencial_"+i).append($('<option disabled>').val("default").text("Seleccione una opción"));
				console.log(data.length);
                var len = data.length;
				
                for( var i = 0; i<len; i++){
                    var name = data[i]['nombreResidencial'];
                    var id = data[i]['idResidencial'];
                    var descripcion = data[i]['descripcion'];

                    
                    $("#idResidencial_"+i).append(`<option value='${id}'>${name}</option>`);
                }

                if(len<=0){
                    $("#idResidencial_"+i).append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#idResidencial_"+i).selectpicker('refresh');
            }, 'json');
		}*/

/**----------------------------DATA TABLES--------------------------------- */

/**------------------------------------------------------------------------ */
		
	</script>
</body>