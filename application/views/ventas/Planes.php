<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/planes.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
	<style>
		.select2-container {
			width: 100%!important;
		}
	</style>
	<div class="wrapper">
		<?php
			if (in_array($this->session->userdata('id_rol'), array(17,5)))
				$this->load->view('template/sidebar');
			else
				echo '<script>alert("ACCESSO DENEGADO"); window.location.href="' . base_url() . '";</script>';
		?>

		<div class="modal fade" id="modalView" role="dialog">
			<div class="modal-dialog" style="width: 500px">
				<div class="modal-content text-center">
					<div class="container-fluid">
						<div id="contentView" class="pt-2 pb-2"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="ModalAlert" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content text-center">
					<div class="modal-header">
						<h5>¿Estas seguro de guardar tus cambios?</h5>
					</div>
					<div class="container-fluid">
						<div class="row mb-1 mt-1">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">	
								<button type="button" class="btn btn-danger btn-simple m-0" data-dismiss="modal">CANCELAR
								</button>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<button type="button" class="btn btn-primary" onclick="SavePaquete();">GUARDAR
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade modal-alertas" id="ModalRemove" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content text-center">
					<div class="modal-header">
						<h4>¿Desea remover este plan?</h4>
					</div>
					<div class="container-fluid">
						<div class="row mb-1 mt-1">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<button type="button" class="btn btn-danger btn-simple pt-1" data-dismiss="modal">Cancelar</button>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<input type="hidden" value="0" id="iddiv">
								<button type="button" class="btn btn-primary" onclick="RemovePackage();">Aceptar</button>
							</div>
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
									<!-- Precio total -->
									<div class="material-datatables p-2">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tableTotal" name="tableTotal">
												<thead>
													<tr>
														<th>ID DESCUENTO</th>
														<th>PORCENTAJE</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_default_2">
									<!-- Enganche -->
									<div class="material-datatables p-2">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tableEnganche" name="tableEnganche">
												<thead>
													<tr>
														<th>ID DESCUENTO</th>
														<th>PORCENTAJE</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_default_3">
									<!-- Precio por M2 -->
									<div class="material-datatables p-2">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tableEfectivoporm" name="tableEfectivoporm">
												<thead>
													<tr>
														<th>ID DESCUENTO</th>
														<th>PORCENTAJE</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_default_4">
									<!-- Precio por bono -->
									<div class="material-datatables p-2">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tableBono" name="tableBono">
												<thead>
													<tr>
														<th>ID DESCUENTO</th>
														<th>PORCENTAJE</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab_default_5">
									<!-- MSI -->
									<div class="material-datatables p-2">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tableMSI" name="tableMSI">
												<thead>
													<tr>
														<th>ID DESCUENTO</th>
														<th>PORCENTAJE</th>
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

		<div class="modal fade modal-alertas" id="ModalFormAddDescuentos" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-center">Cargar nuevo descuento</h5>
					</div>
					<form id="addNewDesc">
						<input type="hidden" value="0" name="id_condicion" id="id_condicion">
						<input type="hidden" value="0" name="boton" id="nombreCondicion">
						<div class="form-group d-flex justify-center">
							<div class="">
								<p class="m-0" id="label_descuento"></p>
								<input type="text" class="input-gral border-none w-100" required  data-type="currency" id="descuento" name="descuento">
							</div>
						</div>
						<div class="container-fluid">
							<div class="row mt-1 mb-1">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<input type="button" class="btn btn-danger btn-simple m-0" data-dismiss="modal" value="CANCELAR">
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<input type="submit" class="btn-gral-data" name="disper_btn"  id="dispersar" value="GUARDAR">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="cargarPlan">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
						<ul class="nav nav-tabs nav-tabs-cm" role="tablist">
							<li class="active" id="li-aut">
								<a href="#nuevas-1" role="tab" onclick="verificarEdicion()" data-toggle="tab">AUTORIZACIONES</a>
							</li>
                            <li id="li-plan" class="">
								<a href="#nuevas-2" role="tab" data-toggle="tab">CARGAR PLAN</a>
							</li>
                        </ul>

						<div class="card no-shadow m-0">
                            <div class="card-content p-0">
								<div class="tab-content">
									<!------->
									<div class="tab-pane active" id="nuevas-1">
										<div class="toolbar">
											<div class="container-fluid">
												<div class="row aligned-row">
													<div class="col-12 col-sm-3 col-md-3 col-lg-3 overflow-hidden">
														<div class="d-flex justify-between">
															<label class="label-gral">
																<span class="isRequired">*</span>Estatus autorización
															</label>                                                </div>
														<select class="selectpicker select-gral m-0" id="estatusAut" name="estatusAut" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body"></select>
													</div>
													<div class="col-12 col-sm-3 col-md-3 col-lg-3 overflow-hidden">
														<label class="label-gral"><span class="isRequired">*</span>Año</label>
														<select class="selectpicker select-gral m-0" id="anio" name="anio" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body">
															<?php
															setlocale(LC_ALL, 'es_ES');
															for ($i=2023; $i<=2026; $i++) {
																$yearName  = $i;
																echo '<option value="'.$i.'">'.$yearName.'</option>';
															} 
															?>
															</select>
													</div>
													<div class="col-12 col-sm-1 col-md-1 col-lg-1 d-flex align-end p-0">
														<button class="btn-data btn-gray m-0 d-flex align-center justify-center" id="searchByEstatus">
															<i class="fas fa-search fa-xs"></i>
														</button>
													</div>
												</div>
											</div>
                                		</div>
                                		<br> 
										<div class="material-datatables" id="box-autorizacionesPVentas">
											<div class="form-group">
												<table class="table-striped table-hover"
													id="autorizacionesPVentas" name="autorizacionesPVentas">
													<thead>
														<tr>
															<th>ID</th>
															<th>SEDE</th>
															<th>PROYECTO</th>
															<th>FECHA INICIO</th>
															<th>FECHA FIN</th>
															<th>TIPO LOTE</th>
															<th>TIPO DE SUPERFICIE</th>
															<th>ESTATUS AUTORIZACIÓN</th>
															<th>FECHA CREACIÓN</th>
															<th>CREADO POR</th>
															<th>ACCIONES</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div> 
									<div class="tab-pane" id="nuevas-2">
										<form id="form-paquetes" class="formulario">
											<div class="container-fluid">
												<div class="row">
													<div class="boxInfoGral">
														<button type="button" data-toggle="modal" onclick="construirTablas();" data-target="#exampleModal" id="btn_open_modal" class="btnDescuento" rel="tooltip" data-placement="top" title="Ver descuentos"><i class="fas fa-tags" ></i></button>
														<button type="submit" id="btn_save" class="btnAction d-none" rel="tooltip" data-placement="top" title="Guardar planes">Guardar todo</button>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
														<div class="container-fluid dataTables_scrollBody" id="boxMainForm">
															<div class="row">
																<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">          
																	<div class="form-group">
																		<label class="mb-0" for="">Rango fechas (<b class="text-danger">*</b>)</label>
																		<div class="d-flex">
																			<input class="form-control dates" name="fechainicio" id="fechainicio" type="date" required="true" onchange="validateAllInForm()">
																			<input class="form-control dates" name="fechafin" id="fechafin" type="date" required="true" onchange="validateAllInForm()">
																		</div>
																	</div>
																</div>
																<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
																	<div class="form-group">
																		<label class="mb-0" for="sede">Sede (<b class="text-danger">*</b>)</label>
																		<select name="sede" id="sede" class="select-gral mt-0" data-style="btn " data-show-subtext="true" data-live-search="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" required onchange="validateAllInForm()">
																		</select>
																	</div>
																</div> 
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
																	<div class="form-group">
																		<label class="mb-0" for="residencial">Proyecto (<b class="text-danger">*</b>)</label> 
																		<select id="residencial" name="residencial[]" multiple="multiple" class="form-control multiSelect"  data-style="btn " data-show-subtext="true" data-live-search="true"  title="Selecciona una opción" data-size="7" required onchange="validateAllInForm()">
																		</select>
																	</div>
																</div>
																<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
																	<div class="form-group">
																		<label class="mb-0">Tipo de lote (<b class="text-danger">*</b>):</label>
																		<div class="radio-container boxTipoLote">
																			<input type="radio" id="customRadioInline1" value="0" name="tipoLote" onclick="validateAllInForm(0,1)">
																			<label class="custom-control-label" for="customRadioInline1">Habitacional</label>
																			<input type="radio" id="customRadioInline2" value="1" name="tipoLote" onclick="validateAllInForm(1,1)">
																			<label class="custom-control-label" for="customRadioInline2">Comercial</label>
																			<input type="radio" id="customRadioInline3" value="2" name="tipoLote" onclick="validateAllInForm(2,1)">
																			<label class="custom-control-label" for="customRadioInline3">Ambos</label>	
																			<input type="hidden" id="tipo_l" name="tipo_l" >
																		</div>
																	</div>
																</div>
																<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
																	<div class="form-group">
																		<label class="mb-0">Superficie (<b class="text-danger">*</b>):</label>
																		<div class="">
																			<div class="radio-container boxSuperficie">
																				<input type="radio" id="customRadio1" value="1" name="superficie"  onclick="selectSuperficie(1)">
																				<label class="custom-control-label" for="customRadio1">Menor a 200</label>
																				<input type="radio" id="customRadio2" value="2" name="superficie" onclick="selectSuperficie(2)">
																				<label class="custom-control-label" for="customRadio2">Mayor a 200</label>
																				<input type="radio" id="customRadio3" value="3" name="superficie" onclick="selectSuperficie(3)">
																				<label class="custom-control-label" for="customRadio3">Cualquiera</label>	
																				<input type="hidden" id="super" name="super" value="0">
																			</div>
																			<div id="printSuperficie"></div>
																		</div>
																	</div>
																</div>
																<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 boxActionsCards">
																<button type="button" id="btn_consultar" class="btnAction d-none" onclick="ConsultarPlanes()" rel="tooltip" data-placement="top" title="Consultar planes"><p class="mb-0 mr-1">Consultar</p><i class="fas fa-database"></i></button>
																	<button type="button" id="btn_generate" class="btnAction d-none" onclick="GenerarCard()" rel="tooltip" data-placement="top" title="Agregar plan"><p class="mb-0 mr-1">Agregar</p><i class="fas fa-plus"></i></button>
																	<input type="hidden" value="0" name="index" id="index">
																	<input type="hidden" value="1" name="accion" id="accion">
																	<input type="hidden" name="idSolicitudAut" id="idSolicitudAut">
																	<input type="hidden" name="paquetes" id="paquetes">
																</div>
															</div>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-2">
														<p class="m-0 d-none leyendItems">Plan(es) añadido(s) (<span class="items"></span>)</p>
														<div class="row dataTables_scrollBody" id="showPackage"></div>
													</div>
												</div>
											</div>
										</form>
									</div>
									<?php include 'modalsPventas.php' ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
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
	<script src="<?= base_url() ?>dist/js/funciones-generales.js"></script>
	<script src="<?=base_url()?>dist/js/controllers/ventas/autorizacionesPlanes.js"></script>
</body>