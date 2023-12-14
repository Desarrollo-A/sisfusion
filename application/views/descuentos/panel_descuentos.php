<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<style>
    .modal-backdrop{
        z-index:9;
    }
</style>
	<!-- estilo para los lotes de origen -->
		<style type="text/css">
            .msj{
                z-index: 9999999;
            }
        </style>
<!-- fin para los estilos de lote de origen -->


<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

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

<!-- inicio de modal boton 3  -->
        <div class="modal fade modal-alertas" id="miModal3" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos2">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label control-label">Puesto del usuario</label>
                                <select class="selectpicker m-0 select-gral roles2" title="SELECCIONA UNA OPCIÓN" data-container="body" data-width="100%" data-live-search="true" name="roles2" id="roles2" required>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 
                                </select>
                            </div>
                            <div class="form-group hide usuario_seleccionar" id="users">
                                <label class="label control-label">Usuario</label>
                                <select id="usuarioid2" name="usuarioid2" class="selectpicker m-0 select-gral directorSelect ng-invalid ng-invalid-required" data-container="body" data-width="100%" data-live-search="true" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
                            </div>
                            <div class="form-group" id="loteorigen2">
                                <label class="label control-label">Lote origen</label>
                                <select id="idloteorigen2"  name="idloteorigen2[]" multiple="multiple" class="form-control directorSelect3 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj" style="color: red;"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label control-label d-flex justify-left">Monto disponible</label>
                                        <input class="form-control input-gral" type="text" id="idmontodisponible2" name="idmontodisponible2" value="" readonly>
                                    </div>
                                    <div id="montodisponible2"></div> 
                                    <b id="sumaReal2"></b>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label control-label d-flex justify-left">Monto a descontar</label>
                                        <input class="form-control input-gral" type="text" id="monto2" data-type="currency" onblur="verificar2();" name="monto2" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label control-label">Mótivo de descuento</label>
                                <textarea id="comentario2" name="comentario2" class="text-modal" rows="3" required></textarea>
                            </div>
                            <div class="form-group d-flex justify-end">
                                <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                                <button type="submit" id="btn_abonar2" class="btn btn-primary">GUARDAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- fin de modal boton 3  --> 
<!-- inicio de modal boton 2 -->
				<div class="modal fade modal-alertas" id="miModal2" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-red">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Descuentos</h4>
							</div>
							<form method="post" id="form_descuentosModal2">
								<div class="modal-body">
									<div class="form-group">
										<label class="label control-label">Puesto del usuario</label>
										<select class="selectpicker select-gral m-0 roles" name="roles" id="roles" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
											<option value="7">Asesor</option>
											<option value="38">MKTD</option>
											<option value="9">Coordinador</option>
											<option value="3">Gerente</option>
											<option value="2">Sub director</option>  
											<option value="1">Director</option> 
										</select>
									</div>
									<div class="form-group hide" id="usersM2">
										<label class="label control-label" id="label_usuario">Usuario</label>
										<select id="usuarioid" name="usuarioid" class="selectpicker m-0 select-gral directorSelect ng-invalid ng-invalid-required" data-container="body" data-width="100%" data-live-search="true" title="SELECCIONA UNA OPCIÓN" required></select>
									</div>
									<div class="form-group" id="loteorigen">
										<label class="label control-label">Lote origen</label>
										<select id="idloteorigen" name="idloteorigen[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple" 
												style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
									</div>
									<b id="msj2" style="color: red;"></b>
									<b id="sumaReal"></b>
									<div class="form-group row">
										<div class="col-md-6">
											<div class="form-group" >
												<label class="label control-label d-flex justify-left">Monto disponible</label>
												<input class="form-control input-gral" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
											</div>
											<div id="montodisponible"></div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="label control-label d-flex justify-left">Monto a descontar</label>
												<input class="form-control input-gral" type="text" data-type="currency" id="montoContraloria" onblur="verificar();" name="montoContraloria" value="">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="label control-label">Mótivo de descuento</label>
										<textarea id="comentarioDescuentoM2" name="comentarioDescuentoM2" class="text-modal" rows="3" required></textarea>
									</div>
									<div class="form-group d-flex justify-end">
										<button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
										<button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>  
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
<!-- fin del modal boton 2 -->

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
								<select class="selectpicker select-gral " name="tipoD" id="tipoD" title="SELECCIONA UNA OPCIÓN" data-container="body" data-width="100%"  data-live-search="true" required>
									<?php foreach($descuentos as $descuento){ ?>
									<option value="<?= $descuento['id_opcion']; ?>"><?= $descuento['nombre'] ?> </option>
									<?php } ?>
								</select>
							</div> 
							<div class="col-md-4">
								<label class="control-label">Monto prestado (<b class="text-danger">*</b>)</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69" maxlength="2" type="number" step="any" required  id="montoPagos" name="montoPagos" min="1">
							</div>
							<div class="col-md-4">
								<label class="control-label">Número de pagos (<b class="text-danger">*</b>)</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69" id="numeroPagos" required  type="number"  maxlength="2" name="numeroP" min="1">
							</div>
							<div class="col-md-4">
								<label class="control-label">Pago</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69"  id="pagoEdit" required type="text" name="pagoEdit" min="1" readonly>
							</div>
								<div class="col-md-12" style="display:block;">
								<input class="form-control input-gral" id="prestamoId" style="display:none;" required type="text" name="prestamoId" readonly>
							</div>
							<div class="col-md-12">
								<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="informacionText" name="informacionText" class="form-control input-gral" rows="3"></textarea>
							</div>	
						</div>
						<div class="modal-footer">     
							<button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>	
							<button  type="submit" id="updatePrestamo" class="btn btn-primary updatePrestamo">Aceptar</button>
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
						<h4 class="modal-title">PRÉST AM OS Y PENALIZACIONES</h4>
					</div>
					<form method="post" id="form_prestamos">
						<div class="modal-body">
						<div class="form-group">
								<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral" name="tipo" id="tipo" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
							</div> 
							<div class="form-group">
								<label class="control-label">Puesto del usuario(<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral" name="rolesDescuento" id="rolesDescuento" title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
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
									<input class="form-control input-gral" type="number" step="any" required onblur="verificar();" id="montoDescuentos"  min="1" name="montoDescuentos">
								</div>
								<div class="col-md-4">
									<label class="control-label">Número de pagos (<b class="text-danger">*</b>)</label>
									<input class="form-control input-gral" id="numeroP" onblur="verificar();" type="number"  min="1" name="numeroP" required>
								</div>
								<div class="col-md-4">
									<label class="control-label">Pago</label>
									<input class="form-control input-gral" id="pagoDescuento" type="text"  min="1" name="pagoDescuento" readonly required>
								</div>
							</div>
							<div class="form-group">
								<p></label><b id="texto" style="font-size:12px;"></b></p>
								<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="comentarioDescuento" name="comentarioDescuento" class="form-control input-gral" rows="3" required></textarea>
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
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
								<i class="material-icons">dashboard</i>
                            </div>
							<div class="card-content">
								<h3 class="card-title center-align">Préstamos y penalizaciones</h3>
								<div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 m-0">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Préstamos activos:</h4>
                                                    <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
                                                </div>
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-1">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Abonado :</h4>
                                                    <p class="input-tot pl-1" name="totalAbonado" id="totalAbonado">$0.00</p>
                                                </div>
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-1">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Pendiente :</h4>
                                                    <p class="input-tot pl-1" name="totalPendiente" id="totalPendiente">$0.00</p>
                                                </div>
                                            </div>
                                        </div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="form-group d-flex justify-center align-center">
													<button ype="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Prestamos</button>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12  col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <button type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal2">Descuento nuevos sin solicitar</button>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12  col-md-4 col-lg-4">
                                                <div class="form-group">
                                                    <button type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal3">Descuento revisión contraloria</button>
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
													<th>NUMERO</th>
													<th>PAGO CORRESPONDIENTE</th>
													<th>ABONADO</th>
													<th>PENDIENTE</th>
													<th>COMENTARIO</th>
													<!-- fila escondida -->
													<th>COMENTARIO</th>
													<!-- fila escondida -->
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
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
	</div>
	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/descuentos/panel_descuentos.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/descuentos/panel_descuentos_v2.js"></script>
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
</body>