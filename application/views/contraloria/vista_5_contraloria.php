<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>

		<style>
			.bs-searchbox .form-group{
				padding-bottom: 0!important;
				margin: 0!important;
			}
		</style>
		<!-- modal para revision status 5 100% -->
		<div class="modal fade " id="envARevCE" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Registro estatus 5 - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label">Comentario</label>
								<input class="text-modal mb-1" name="comentario" id="comentarioenvARevCE" autocomplete="off">
								<br>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden" id="tipo-venta-options-div" hidden>
								<label class="control-label" id="tvLbl">Tipo de venta</label>
								<select required="required" name="tipo_venta" id="tipo_ventaenvARevCE" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body" data-size="4">
								</select>			
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"id="tipo-venta-particular-div" hidden>
								<h6><b>Tipo de venta particular</b></h6>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 overflow-hidden">
								<label class="control-label" id="tvLbl">Ubicación</label>
								<select required="required" name="ubicacion" id="ubicacion" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body" data-size="7">
								</select>
							</div>
							<input type="hidden" name="idLote" id="idLoteenvARevCE" >
							<input type="hidden" name="idCliente" id="idClienteenvARevCE" >
							<input type="hidden" name="idCondominio" id="idCondominioenvARevCE" >
							<input type="hidden" name="fechaVenc" id="fechaVencenvARevCE" >
							<input type="hidden" name="nombreLote" id="nombreLoteenvARevCE"  >
						</div>
					</div>
					<div class="modal-footer"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" id="enviarenvARevCE" onClick="preguntaenvARevCE()" class="btn btn-primary">Registrar</button>
					</div>
				</div>
			</div>
		</div>


		<!-- modal para rechazar estatus-->
		<div class="modal fade" id="rechazarStatus" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Rechazo estatus 5 - <b><span class="lote"></span></b></label></h4>	
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label">Comentario</label>
							<textarea class="text-modal" id="motivoRechazo" rows="3"></textarea>
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

		<!-- modal  ENVIA A ASESOR por rechazo 2-->
		<div class="modal fade" id="rechazarStatus_2" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" > 
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Rechazo estatus 5 - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
					<label>Comentario</label>
						<textarea class="text-modal" id="comentario2" rows="3"></textarea>
						<br>              
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" id="save2" class="btn btn-primary">Registrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal -->

		<!-- modal  ENVIA A JURIDICO por rechazo 1-->
		<div class="modal fade" id="envARev2" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" > 
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Registro estatus 5 - <b><span class="lote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<label>Comentario</label>
						<textarea class="text-modal" id="comentario1" rows="3"></textarea>
						<br>              
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" id="save1" class="btn btn-primary"> Registrar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- modal -->

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
									<h3 class="card-title center-align">Registro estatus 5</h3>
									<p class="card-title pl-1">(revisión 100%)</p>
								</div>
								<div  class="toolbar">
									<div class="row">
									</div>
								</div>
								<div class="material-datatables">
									<table  id="tabla_ingresar_5" name="tabla_ingresar_5" class="table-striped table-hover">
										<thead>
											<tr>
												<th></th>
												<th>TIPO</th>
												<th>PROYECTO</th>
												<th>CONDOMINIO</th>
												<th>LOTE</th>
												<th>REFERENCIA</th>
												<th>CLIENTE</th>
												<th>GERENTE</th>
												<th>FECHA DE MODIFICACIÓN</th>
												<th>FECHA DE VENCIMIENTO</th>
												<th>UC</th>
												<th>SEDE</th>
												<th>COMENTARIO</th>
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
	</div>
</body>
<?php $this->load->view('template/footer');?>

<script src="<?= base_url() ?>dist/js/controllers/contraloria/vista_5_contraloria.js"></script>