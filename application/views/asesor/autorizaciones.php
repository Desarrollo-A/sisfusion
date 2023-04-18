<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/><link href="<?=base_url()?>dist/js/controllers/files/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<body class="">
	<div class="wrapper ">
		<?php
		/*-------------------------------------------------------*/
		$datos = array();
		$datos = $datos4;
		$datos = $datos2;
		$datos = $datos3;  
		$this->load->view('template/sidebar', $datos);
		/*--------------------------------------------------------*/
		?>

		<!-- Modals -->
		<!-- modal para enviar a revision status corrida elborada -->
		<div class="modal fade" id="envARevCE" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title">Revisión Status (6. Corrida elaborada)</h4>
					</div>
					<div class="modal-body">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<label>Lote:</label>
								<input type="text" class="form-control" id="nomLoteFakeenvARevCE" disabled>

								<br><br>

								<label>Status Contratación</label>
								<select required="required" name="idStatusContratacion" id="idStatusContratacionenvARevCE"
										class="selectpicker" data-style="btn" title="Estatus contratación" data-size="7">
									<option value="6">  6. Corrida elaborada (Contraloría) </option>
								</select>
							</div>
							<div class="col col-xs-12 col-sm-12 col-md-6 col-lg-6">
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
						<button type="button" id="enviarenvARevCE" onClick="preguntaenvARevCE()" class="btn btn-primary"><span
								class="material-icons" >send</span> </i> Enviar a Revisión
						</button>
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>

		<!-- insertar autorización modal 1-5-->
		<div class="modal fade" id="solicitarAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content" >
					<form id="my_authorization_form" name="my_authorization_form" method="post">
						<div class="modal-header">
							<center><h4 class="modal-title">Solicitar autorización</h4></center>
						</div>
						<div class="modal-body">
							<label>Autoriza: </label><br>
							<select name="id_aut" id="dirAutoriza" class="selectpicker select-gral" data-style="btn btn-round" title="TIPO USUARIO" data-size="7">
							</select><br><br><br>
							<label>Observaciones: *</label>
							<textarea class="form-control" id="comentario_0" name="comentario_0" rows="3" style="width:100%;"
									placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
							<input type="hidden" id="tamanocer" name="tamanocer" value="1" style="color: black">
							<input type="hidden" name="idCliente" id="idCliente">
							<input type="hidden" name="idLote" id="idLote">
							<input type="hidden" name="nombreCondominio" id="nombreCondominio">
							<input type="hidden" name="nombreResidencial" id="nombreResidencial">
							<input type="hidden" name="nombreLote" id="nombreLote">
							<input type="hidden" name="idCondominio" id="idCondominio">
							<input type="hidden" name="id_sol" id="id_sol">
							<br>
							<div id="autorizacionesExtra"></div>
							<div id="functionAdd">
								<a onclick="agregarAutorizacion()" style="float: right; color: black; cursor: pointer; " title="Agregar observación">
									<span class="material-icons">add</span>
								</a>
							</div>
							<br>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn btn-primary" onclick="return validateEmptyFields()" id="btnSubmit"> Enviar autorización</a>
							<button type="submit" id="btnSubmitEnviar" class="btn btn-success hide"> Enviar autorización</button>
							<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- insertar autorización modal 1-5-->
		<div class="modal fade" id="verAutorizacionesAsesor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title">Ver autorizaciones en proceso</h4>
					</div>
					<div class="modal-body pl-0 pr-0">
						<div class="scroll-styles" id="auts-loads" style="max-height: 450px; overflow:auto; padding: 0 20px">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-simple" data-dismiss="modal">Aceptar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
						<ul class="nav nav-tabs nav-tabs-cm">
							<li class="active"><a href="#soli" data-toggle="tab">Solicitud</a></li>
							<li><a href="#aut" data-toggle="tab" onclick="javascript:$('#addExp').DataTable().ajax.reload();">Autorizaciones</a></li>
						</ul>
						<div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
										<div class="active tab-pane" id="soli">
											<h3 class="card-title center-align">Solicitud</h3>
											<table id="sol_aut" class="table-striped table-hover">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>FECHA/HORA</th>
														<th>ACCIONES</th>
													</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>
										<div class="tab-pane" id="aut">
											<h3 class="card-title center-align">Autorizaciones</h3>
											<table id="addExp" class="table-striped table-hover">
												<thead>
													<tr>
														<th>PROYECTO</th>
														<th>CONDOMINIO</th>
														<th>LOTE</th>
														<th>SOLICITA</th>
														<th>AUTORIZA</th>
														<th>AUTORIZACIÓN</th>
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
	<script src="https://cdn.bootcdn.net/ajax/libs/intro.js/5.1.0/intro.min.js"></script>
	<script src="<?=base_url()?>dist/js/controllers/asesores/autorizaciones.js"></script>
</body>