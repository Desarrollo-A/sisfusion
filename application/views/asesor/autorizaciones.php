<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" type="text/css"/>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>
		<div class="modal fade" id="envARevCE" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title">Revisión Status (6. Corrida elaborada)</h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label>Lote:</label>
								<input type="text" class="form-control" id="nomLoteFakeenvARevCE" disabled>
								<br><br>
								<label>Status Contratación</label>
								<select required="required" name="idStatusContratacion" id="idStatusContratacionenvARevCE" class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7"><option value="6">  6. Corrida elaborada (Contraloría) </option></select>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label>Comentario:</label>
								<input type="text" class="form-control" name="comentario" id="comentarioenvARevCE">
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
						<button type="button" id="enviarenvARevCE" onClick="preguntaenvARevCE()" class="btn btn-primary"><span class="material-icons" >send</span> </i> Enviar a Revisión</button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="solicitarAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content" >
					<form id="my_authorization_form" name="my_authorization_form" method="post">
						<div class="modal-header">
							<h4 class="modal-title center-align">Solicitar autorización</h4>
						</div>
						<div class="modal-body">
							<div class="row aligned-row">
								<div class="col-sm-10 col-md-10 col-lg-10">
									<label>Autoriza (<span class="isRequired">*</span>)</label>
									<select name="id_aut" id="dirAutoriza" class="selectpicker select-gral m-0" data-style="btn btn-round" data-live-search="true" title="Selecciona una opción" data-size="7"></select>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2 d-flex align-end">
									<button	type="button" class="btn-data btn-blueMaderas m-0" onclick="agregarAutorizacion()" data-toggle="tooltip"  data-placement="right" title="AGREGAR OBSERVACIÓN"><i class="fas"><span class="material-icons">note_add</span></i></button>
								</div>
							</div>
							<div class="row">
								<div id="functionAdd" class="col-sm-12 col-md-12 col-lg-12 mt-2">
									<label>Observaciones: (<span class="isRequired">*</span>)</label>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<textarea	class="text-modal " id="comentario_0" name="comentario_0" rows="3" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
									</textarea>
									<input type="hidden" id="tamanocer" name="tamanocer" value="1" style="color: black">
									<input type="hidden" name="idCliente" id="idCliente">
									<input type="hidden" name="idLote" id="idLote">
									<input type="hidden" name="nombreCondominio" id="nombreCondominio">
									<input type="hidden" name="nombreResidencial" id="nombreResidencial">
									<input type="hidden" name="nombreLote" id="nombreLote">
									<input type="hidden" name="idCondominio" id="idCondominio">
									<input type="hidden" name="id_sol" id="id_sol">
								</div>
								<div id="autorizacionesExtra" class="col-sm-12 col-md-12 col-lg-12"></div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button><a type="submit"class="btn btn-success hidden" style="margin: 0px;" onclick="validateEmptyFields()" id="btnSubmitEnviar" data-dismiss="modal">Enviar</a>
							<button type="submit"   ></button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="verAutorizacionesAsesor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title">Ver autorizaciones en proceso</h4>
					</div>
					<div class="modal-body pl-0 pr-0">
						<div class="scroll-styles" id="auts-loads" style="max-height: 450px; overflow:auto; padding: 0 20px"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CERRAR</button>
					</div>
				</div>
			</div>
		</div>

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<ul class="nav nav-tabs nav-tabs-cm">
							<li class="active"><a href="#soli" data-toggle="tab" onclick="javascript:$('#sol_aut').DataTable().ajax.reload();">Solicitud</a></li>
							<li><a href="#aut" data-toggle="tab" onclick="javascript:$('#addExp').DataTable().ajax.reload();">Autorizaciones</a></li>
						</ul>
						<div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
										<div class="active tab-pane" id="soli">
											<h3 class="card-title center-align">Solicitud</h3>
											<p class="center-align">A través de este panel(Solicitud) podrás realizar lo siguiente; consulta de las solicitudes previas a su autorización, envió de correo electrónico a usuarios con rol "Subdirector" que se encuentren activos (seleccionar usuario según sea el caso) con una solicitud de autorización (dependiendo del estatus de la misma), descarga de información en formatos: PDF y XLSX.</p>
											<table id="sol_aut" class="table-striped table-hover">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>CLIENTE</th>
														<th>COORDINADOR</th>
														<th>GERENTE</th>
														<th>SUBDIRECTOR</th>
														<th>DIRECTOR REGIONAL</th>
														<th>DIRECTOR REGIONAL 2</th>
														<th>FECHA DE APARTADO</th>
														<th>ACCIONES</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
										<div class="tab-pane" id="aut">
											<h3 class="card-title center-align">Autorizaciones</h3>
											<p class="center-align">A través de este panel(Autorizaciones) podrás realizar lo siguiente; consulta de las solicitudes autorizadas, visualización de los estatus correspondientes por cada una de las autorizaciones en proceso, descarga de información en formatos: PDF y XLSX.<br></p>
											<table id="addExp" class="table-striped table-hover">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>CLIENTE</th>
														<th>SOLICITANTE/ASESOR</th>
														<th>COORDINADOR</th>
														<th>GERENTE</th>
														<th>SUBDIRECTOR</th>
														<th>DIRECTOR REGIONAL</th>
														<th>DIRECTOR REGIONAL 2</th>
														<th>AUTORIZA</th>
														<th>ACCIONES</th>
													</tr>
												</thead>
												<tbody></tbody>
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
	<?php $this->load->view('template/footer');?>
	<script src="<?=base_url()?>dist/js/controllers/asesores/autorizaciones.js"></script>
</body>