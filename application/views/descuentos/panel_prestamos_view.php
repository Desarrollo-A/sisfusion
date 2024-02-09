<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/reportDasboard.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">



<body>
<div class="wrapper">
<?php $this->load->view('template/sidebar'); ?>
<?php $this->load->view('descuentos/complementos/estilosPrestamos_comple'); ?>

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

		
		<div class="modal fade" id="ModalAddMotivo" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
						<h4 class="modal-title">Agregar nuevos motivos</h4>
					</div>
					<form nombre="claveNuevoMotivo" id="claveNuevoMotivo" >
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-md-12">
								<label class="control-label">Nuevo motivo (<b class="text-danger">*</b>)</label>
								<input class="form-control input-gral" type="text" step="any" required  id="MotivoAlta" name="MotivoAlta">
							</div>
							<div class="col-md-2" style="padding-top:18px;">
							<!-- <div class="boxOnOff">
								<input type="checkbox" id="nombreSwitch" class="switch-input d-none" onclick="turnOnOff(this)">
								<label for="nombreSwitch" class="switch-label"></label>
		
							</div> -->
								<div class="col-md-4">
									<label class="switch">
									<input class="nombreSwitch" id="nombreSwitch" name="nombreSwitch" type="checkbox">
									<span class="slider"></span>
									</label>
								</div>
							</div>
							<div id="textoSwitch" name="textoSwitch" class="col-md-10 " style="padding-top:15px;">
									<span class="small text-gray textDescripcion hide" style="font-style: italic;" id="siTextoDescripcion" name="siTextoDescripcion">
											Al generar un nuevo préstamo será solicitada la evidencia.
										</span>
									<span class="small text-gray textDescripcion" style="font-style: italic;" id="noTextoDescripcion" name="noTextoDescripcion">
											Es necesario subir la evidencia para el nuevo motivo.
									</span>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="control-label">Elige el color nuevo (<b class="text-danger">*</b>)</label>
									<input type="color" id="body" name="body" value="#f6b73c" style=" height: 20px; width: 50px; border: none;" />
								</div>
								<div class="col-md-6">
									<p style="padding-top:12px;"><span class="label"  style="color: #f6b73c; border: none; background-color:rgba(14, 98, 81, 0.0941176471); " id="textoPruebas" name="textoPruebas"  > 
										TEXTO DE PRUEBA</span></p>
								</div>
							</div>
							<br>
							<br>
							<div class="col-md-12" id="evidenciaSwitchDIV" name="evidenciaSwitchDIV" style="padding-top:30px;" >
								<div class="file-gph">
									<input class="d-none" type="file" id="evidenciaSwitch" onchange="changeName(this)" name="evidenciaSwitch"  >
									<input class="file-name overflow-text" id="evidenciaSwitch" type="text" placeholder="No has seleccionada nada aún" readonly="">
									<label class="upload-btn w-auto" for="evidenciaSwitch"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
								</div>
								
								<!-- <label class="input-group-btn">
                                    <span class="btn btn-blueMaderas btn-file">Seleccionar archivo&hellip;
                                        <input type="file" name="evidenciaSwitch" id="evidenciaSwitch" style="visibility: hidden" >
                                    </span>
								</label>
									<input type="text" class="form-control" readonly> -->
							</div>

							<div class="col-md-12">
								<label class="control-label">Descripción(<b class="text-danger">*</b>)</label>
								<textarea id="descripcionAlta" name="descripcionAlta" class="text-modal" rows="3"></textarea>
							</div>	
						</div>
					</div>
						<div class="modal-footer">     
							<button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>	
							<button  type="button" id="addMotivos" class="btn btn-primary addMotivos">Aceptar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
						<h4 class="modal-title">PRÉSTAMOS Y PENALIZACIONES</h4>
					</div>
					<form >
						<div class="form-group row">
							<div class="col-md-12">
								<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral " name="tipoD" id="tipoD" title="SELECCIONA UNA OPCIÓN" data-container="body" data-width="100%"  data-live-search="true" readonly required>
									<?php foreach($descuentos as $descuento){ ?>
									<option value="<?= $descuento['id_opcion']; ?>"><?= $descuento['nombre'] ?> </option>
									<?php } ?>
								</select>
							</div> 
							<div class="col-md-4">
								<label class="control-label">Monto prestado (<b class="text-danger">*</b>)</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69" maxlength="2" type="number" step="any" required  id="montoPagos" name="monto" min="1">
							</div>
							<div class="col-md-4">
								<label class="control-label">Número de pagos (<b class="text-danger">*</b>)</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69" id="numeroPagos" required  type="number"  maxlength="2" name="numeroP" min="1">
							</div>
							<div class="col-md-4">
								<label class="control-label">Pago</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69"  id="pagoEdit" required type="text" name="pago" min="1" readonly>
							</div>
								<div class="col-md-12" style="display:block;">
								<input class="form-control input-gral" id="prestamoId" style="display:none;" required type="text" name="pago" readonly>
							</div>
							<div class="col-md-12">
								<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="informacionText" name="informacionText" class="form-control input-gral" rows="3"></textarea>
							</div>	
						</div>
						<div class="modal-footer">     
							<button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>	
							<button  type="button" id="updatePrestamo" class="btn btn-primary updatePrestamo">Aceptar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade modal-alertas" name="miModal" id="miModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-red">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">PRÉSTAMOS Y PENALIZACIONES</h4>
					</div>
					<form method="post" id="form_prestamos">
						<div class="modal-body">
						<div class="form-group">
								<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral" name="tipo" id="tipo" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
							</div> 
							<div class="form-group">
								<label class="control-label">Puesto del usuario(<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral" name="roles" id="roles" title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
									<option value="7">Asesor</option>
									<option value="9">Coordinador</option>
									<option value="3">Gerente</option>
									<option value="2">Sub director</option>      
								</select>
							</div>
							<div class="form-group" id="users"></div>
							<div class="form-group row">
								<div class="col-md-4">
									<label class="control-label">Monto prestado (<b class="text-danger">*</b>)</label>
									<input class="form-control input-gral" type="number" step="any" required onblur="verificar();" id="monto"  min="1" name="monto">
								</div>
								<div class="col-md-4">
									<label class="control-label">Número de pagos (<b class="text-danger">*</b>)</label>
									<input class="form-control input-gral" id="numeroP" onblur="verificar();" type="number"  min="1" name="numeroP" required>
								</div>
								<div class="col-md-4">
									<label class="control-label">Pago</label>
									<input class="form-control input-gral" id="pago" type="text"  min="1" name="pago" readonly required>
								</div>
								<input class="form-control input-gral hide" id="banderaEvidencia" type="text" name="banderaEvidencia" readonly required>
							</div>
 
							<div class="form-group input-group evidenciaDIVarchivo hide" id="evidenciaDIVarchivo" name="evidenciaDIVarchivo">
								<label class="input-group-btn">
                                    <span class="btn btn-blueMaderas btn-file">Seleccionar archivo&hellip;
                                        <input type="file" name="evidencia" id="evidencia" style="visibility: hidden" >
                                    </span>
								</label>
									<input type="text" class="form-control" readonly>
							</div>
							<div class="form-group">
								<p></label><b id="texto" style="font-size:12px;"></b></p>
								<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="comentario" name="comentario" class="form-control input-gral" rows="3" required></textarea>
							</div>
							<div class="modal-footer">  
								<button type="button"  class="btn btn-danger btn-simple" data-dismiss="modal" >Cancelar</button>	
								<button type="submit" id="btn_abonar" class="btn btn-primary">Guardar</button>
            				</div>
						</div>
					</form>
				</div>
			</div>
		</div>

        <div class="modal fade modal-alertas" id="detalle-prestamo-modal" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>4
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
		
	
		<div class="content boxContent">
			
			<div class="container-fluid">
				<div class="row "  style="margin-bottom: 2px">
				
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0"><
						<div class="card">
							<br>
						<h3 class="h3 card-title center-align">Préstamos y penalizaciones</h3>		
						<div class="row">
				<?php $this->load->view('descuentos/complementos/dash_panel_prestamos_comple'); ?>
							
				</div>
							<div class="card-content">
													
								<div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 m-0">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <!-- <h4 class="title-tot center-align m-0">Préstamos activos:</h4> -->
                                                    <!-- <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p> -->
                                                </div>
												
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-1">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <!-- <h4 class="title-tot center-align m-0">Abonado :</h4> -->
                                                    <!-- <p class="input-tot pl-1" name="totalAbonado" id="totalAbonado">$0.00</p> -->
                                                </div>
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-1">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <!-- <h4 class="title-tot center-align m-0">Pendiente :</h4> -->
                                                    <!-- <p class="input-tot pl-1" name="totalPendiente" id="totalPendiente">$0.00</p> -->
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
													<button Type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Agregar</button>
												</div>
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
													<buttons Type="button"  class="data" data-toggle="modal" data-target="#ModalAddMotivo"><i class="fas fa-plus"></i> Nuevo motivo de préstamo</buttons>
												</div>
											</div>
										</div>
									

                                    </div>
                                </div>
								<div class="material-datatables">
									<div class="form-group">
										<table class="table-striped table-hover" id="tabla_prestamos" name="tabla_prestamos">
											<thead>
												<tr>
													<th>ID PRÉSTAMO</th>
													<th>ID USUARIO</th>
													<th>USUARIO</th>
													<th>MONTO</th>
													<th>NÚMERO</th>
													<th>PAGO CORRESPONDIENTE</th>
													<th>ABONADO</th>
													<th>PENDIENTE</th>
													<th>COMENTARIO</th>
													<th>COMENTARIO</th>
													<th>ESTATUS</th>
													<th>TIPO</th>
													<th>FECHA DE REGISTRO</th>
													<th>ACCIONES</th>
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
		<div class="spiner-loader hide" id="spiner-loader">
            <div class="backgroundLS">
                <div class="contentLS">
                    <div class="center-align">
                        Este proceso puede demorar algunos segundos
                    </div>
                    <div class="inner">
                        <div class="load-container load1">
                            <div class="loader">
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
	
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>

	<script src="<?= base_url() ?>dist/js/controllers/descuentos/panel_prestamos.js"></script>
	
	<script src="<?= base_url() ?>dist/js/controllers/descuentos/complementos/dash_panel_prestamos_comple.js"></script>
	<script type="text/javascript">
		Shadowbox.init();
	</script>
</body>