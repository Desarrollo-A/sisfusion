<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>

		<style>
		.form-group{
			padding-bottom: 0!important;
    		margin: 0!important;
		}
	</style>

	<!-- MODALS-->
		<!-- modal para registrar corrida elaborada-->
		<div class="modal fade " id="regCorrElab" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title"><label>Registro estatus 6 - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label">Comentario</label>
								<textarea class="text-modal" name="comentario" id="comentarioregCor" rows="3"></textarea>
								<br>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label  class="control-label" id="tvLbl">Enganche / Cantidad traspaso</label>
								<input class="form-control input-gral m-0" name="totalNeto" id="totalNeto" oncopy="return false" onpaste="return false" type="tel" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" autocomplete="off">
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden">
								<label class="control-label" id="tvLbl">Tipo de Enganche</label>
								<select required="required" name="tipo_enganche" id="tipo_enganche" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body" data-size="3">
								</select>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden">
								<label class="control-label" id="tvLbl">Estatus del Enganche</label>
								<select required="required" name="estatus_enganche" id="estatus_enganche" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body" data-size="2">
								</select>
							</div>
							<input type="hidden" name="idLote" id="idLoteregCor" >
							<input type="hidden" name="idCliente" id="idClienteregCor" >
							<input type="hidden" name="idCondominio" id="idCondominioregCor" >
							<input type="hidden" name="fechaVenc" id="fechaVencregCor" >
							<input type="hidden" name="nombreLote" id="nombreLoteregCor"  >
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" onClick="closeWindow()" data-dismiss="modal">Cancelar</button>
						<button type="button" id="enviarAContraloriaGuardar" onClick="preguntaRegCorr()" class="btn btn-primary">Registrar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade " id="rechazarStatus" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Rechazo estatus 6 - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label">Comentario</label>
								<textarea class="text-modal" name="motivoRechazo" id="motivoRechazo" rows="3"></textarea>
								<br>
							</div>
							<input type="hidden" name="idCliente" id="idClienterechCor" >
							<input type="hidden" name="idCondominio" id="idCondominiorechCor" >
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" id="guardar" class="btn btn-primary">Registrar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- modal para informar que no hay corrida-->
		<div class="modal fade" id="infoNoCorrida" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h4 class="modal-title text-center"><label>No se ha adjuntado corrida del lote: <b><span class="lote"></span></b></label></h4>
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade " id="regRevCorrElab" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Registro estatus 6 - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label">Comentario</label>
								<textarea class="text-modal" name="comentario1" id="comentario1" rows="3"></textarea>
								<br>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label" id="tvLbl">Enganche / Cantidad traspaso</label>
								<input class="form-control input-gral" name="totalNeto" id="totalNetoR" oncopy="return false" onpaste="return false" type="tel" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" onClick="closeWindow()" data-dismiss="modal">Cancelar</button>
						<button type="button" id="save1" class="btn btn-primary">Registrar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade " id="regRevA7" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Registro estatus 6 - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label">Comentario</label>
								<textarea class="text-modal" name="comentario2" id="comentario2" rows="3"></textarea>
								<br>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label" id="tvLbl">Enganche / Cantidad traspaso</label>
								<input class="form-control input-gral" name="totalNeto" id="totalNetoRevA7" oncopy="return false" onpaste="return false" type="tel" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" onClick="closeWindow()" data-dismiss="modal">Cancelar</button>
						<button type="button" id="save2" class="btn btn-primary"> Registrar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- modal para enviar a revision status corrida elborada -->
		<div class="modal fade" id="envARevCE" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title">Revisión Status (6. Corrida elaborada)</h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label class="control-label">Lote:</label>
								<input type="text" class="form-control" id="nomLoteFakeenvARevCE" disabled>
								<br><br>
								<label class="control-label">Status Contratación</label>
								<select required="required" name="idStatusContratacion" id="idStatusContratacionenvARevCE" class="selectpicker" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7">
									<option value="6">  6. Corrida elaborada (Contraloría) </option>
								</select>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label class="control-label">Comentario</label>
								<input type="text" class="text-modal" name="comentario" id="comentarioenvARevCE">
								<br><br>
							</div>
							<input type="hidden" name="idLote" id="idLoteenvARevCE" >
							<input type="hidden" name="idCliente" id="idClienteenvARevCE" >
							<input type="hidden" name="idCondominio" id="idCondominioenvARevCE" >
							<input type="hidden" name="fechaVenc" id="fechaVencenvARevCE" >
							<input type="hidden" name="nombreLote" id="nombreLoteenvARevCE"  >
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" id="enviarenvARevCE" onClick="preguntaenvARevCE()" class="btn btn-primary"><span
							class="material-icons" >send</span> </i> Enviar a Revisión
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade " id="modal_return1" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Registro estatus 6 - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label">Comentario</label>
								<textarea class="text-modal" name="comentario3" id="comentario3" rows="3"></textarea>
								<br>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label" id="tvLbl">Enganche / Cantidad traspaso</label>
								<input class="form-control input-gral" name="totalNeto" id="totalReturn1" oncopy="return false" onpaste="return false" type="tel" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" onClick="closeWindow()" data-dismiss="modal">Cancelar</button>
						<button type="button" id="b_return1" class="btn btn-primary"> Registrar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- modal change sede-->
		<div class="modal fade" id="change_s" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Modificación de sede - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 overflow-hidden">
								<label class="control-label" id="tvLbl">Sede</label>
								<select required="required" name="ubicacion" id="ubicacion" class="selectpicker select-gral" data-live-search="true" data-container="body" data-style="btn" title="SELECCIONA UNA OPCIÓN" data-size="7">
								</select>
							</div>
						</div>
						<div class="modal-footer"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
							<button type="button" id="savecs" class="btn btn-primary">Registrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- END MODALS -->

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="fas fa-expand fa-2x"></i>
							</div>
							<div class="card-content">
								<div class="encabezadoBox">
									<h3 class="card-title center-align">Registro estatus 6 </h3>
									<p class="card-title pl-1">(Corrida elaborada)</p>
								</div>
								<div class="material-datatables">
									<table  id="tabla_ingresar_6" name="tabla_ingresar_6" class="table-striped table-hover">
										<thead>
											<tr>
												<th></th>
												<th>TIPO DE VENTA</th>
												<th>TIPO DE PROCESO</th>
												<th>PROYECTO</th>
												<th>CONDOMINIO</th>
												<th>LOTE</th>
												<th>CLIENTE</th>
												<th>GERENTE</th>
												<th>FECHA DE MODIFICACIÓN</th>
												<th>FECHA DE VENCIMIENTO</th>
												<th>UC</th>
												<th>UBICACIÓN</th>
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
		<?php $this->load->view('template/footer_legend');?>
	</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<script src="<?= base_url() ?>dist/js/controllers/contraloria/vista_6_contraloria.js?v=1.1.1"></script>