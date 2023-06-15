<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<style>
	.modal-backdrop{
		z-index:9;
	}
</style>

<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<!-- Modals -->
		<div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					<form method="post" id="form_espera_uno">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
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
<!-- --- -->

<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
						<h4 class="modal-title">PRÉSTAMOS, DESCUENTOS Y PENALIZACIONES</h4>
            </div>
            <form >
			<div class="form-group row">
				<div class="col-md-12">
					<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
					<select class="selectpicker select-gral " name="tipoD" id="tipoD" 
					 required data-live-search="true">
					<option disabled default >SELECCIONA UNA OPCIÓN</option>
                                            <?php foreach($descuentos as $descuento){ ?>

                                                <option value="<?= $descuento['id_opcion']; ?>"><?= $descuento['nombre'] ?> </option>
                                            <?php } ?>
					</select>
				</div> 
				<div class="col-md-4">
					<label class="control-label">Monto prestado (<b class="text-danger">*</b>)</label>
					<input class="form-control input-gral"
					onkeydown="return event.keyCode !== 69" maxlength="2" type="number" step="any" 
					required  id="montoPagos" name="monto" min="1">
				</div>
				<div class="col-md-4">
					<label class="control-label">Número de pagos (<b class="text-danger">*</b>)</label>
					<input class="form-control input-gral" onkeydown="return event.keyCode !== 69"
					 id="numeroPagos" required  type="number"  maxlength="2" name="numeroP" min="1">
				</div>
				<div class="col-md-4">
					<label class="control-label">Pago</label>
					<input class="form-control input-gral" 
					onkeydown="return event.keyCode !== 69"  id="pagoEdit" required type="text" name="pago" min="1" readonly>
				</div>
				<div class="col-md-12" style="display:block;">
					<input class="form-control input-gral" id="prestamoId" style="display:none;" required type="text" name="pago" readonly>
				</div>
				<div class="col-md-12">
					<!-- <p>Nota:</label><b id="texto" style="font-size:12px;"></b></p> -->
					<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
					<textarea id="informacionText" name="informacionText" class="form-control input-gral" rows="3"></textarea>
				</div>	
			</div>
			
            <div class="modal-footer">     
					<button type="button"  class="btn btn-danger btn-simple " 
							data-dismiss="modal" >Cerrar</button>	
					<button  type="button" id="updatePrestamo" class="btn btn-gral-data updatePrestamo">Aceptar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- --- -->
		<div class="modal fade" name="ModalEdits" id="ModalEdits" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">PRÉSTAMOS, DESCUENTOS Y PENALIZACIONES</h4>
					</div>
						<div class="modal-body">
							<div class="form-group row">
								<!-- <div class="col-md-12">
									<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
									<select class="selectpicker" name="tipo" id="tipo" title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
									</select>
								</div>  -->
								<div class="col-md-4">
									<label class="label">Monto prestado (<b class="text-danger">*</b>)</label>
							
									<input class="form-control input-gral" type="number" step="any" required  id="montoPagos" name="monto" min="1">
								</div>
								<div class="col-md-4">
									<label class="label">Número de pagos (<b class="text-danger">*</b>)</label>
									<input class="form-control input-gral" id="numeroPagoss" required  type="number" name="numeroP" min="1">
								</div>
								<div class="col-md-4">
									<label class="label">Pago</label>
									<input class="form-control input-gral" id="pagoEdit" required type="text" name="pago" min="1" readonly>
								</div>
								<div class="col-md-12" style="display:block;">
									<input class="form-control input-gral" id="prestamoId" style="display:none;" required type="text" name="pago" readonly>
								</div>
								<div class="col-md-12">
									<!-- <p>Nota:</label><b id="texto" style="font-size:12px;"></b></p> -->
									<label class="label">Comentario(<b class="text-danger">*</b>)</label>
									<textarea id="informacionText1" name="informacionText1" class="form-control input-gral" rows="3"></textarea>
								</div>	
							</div>
						</div>
						<div class="footer-model" >
                                <button type="button"  class="btn btn-danger btn-simple " 
                                    data-dismiss="modal" >Cerrar
                                </button>	
							    <button type="submit" id="updatePrestamo" class="btn btn-gral-data updatePrestamo">Aceptar
                                </button>
						</div>
				</div>
			</div>
		</div>

		<!-- INICIO MODALES PRINCIPALES ALTA -->


		<div class="modal fade modal-alertas" name="modalPrestamosPenalizaciones" id="modalPrestamosPenalizaciones" role="dialog">
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
								<select class="selectpicker select-gral" name="tipo" id="tipo" title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
								</select>
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
									<input class="form-control input-gral" id="numeroP" required onblur="verificar();" type="number"  min="1" name="numeroP">
								</div>
								<div class="col-md-4">
									<label class="control-label">Pago</label>
									<input class="form-control input-gral" id="pago" required type="text"  min="1" name="pago" readonly>
								</div>
							</div>
							<div class="form-group">
								<p></label><b id="texto" style="font-size:12px;"></b></p>
								<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="comentario" name="comentario" required  class="form-control input-gral" rows="3"></textarea>
							</div>
							<div class="modal-footer">  
									<button type="button"  class="btn btn-danger btn-simple " 
											data-dismiss="modal" >Cancelar</button>	
									<button  type="submit" id="btn_abonar" class="btn btn-gral-data ">Guardar</button>
            				</div>

						</div>
					</form>
				</div>
			</div>
		</div>


		<div class="modal fade modal-alertas" id="miModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker roles" name="roles" id="roles" required></select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>
                            <div class="form-group" id="loteorigen">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen"  name="idloteorigen[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj2" style="color: red;"></b>
                            <b id="sumaReal"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
                                    </div>
                                    <div id="montodisponible"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control" type="text" id="monto" onblur="verificar();" name="monto" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mótivo de descuento</label>
                                <textarea id="comentario" name="comentario" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <center>
                                    <button type="submit" id="btn_abonar" class="btn btn-success">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos2">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker roles2" name="roles2" id="roles2" required></select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>

                            <div class="form-group" id="loteorigen2">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen2"  name="idloteorigen2[]" multiple="multiple" class="form-control directorSelect3 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj" style="color: red;"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control" type="text" id="idmontodisponible2" readonly name="idmontodisponible2" value="">
                                    </div>
                                    <div id="montodisponible2"></div> 
                                    <b id="sumaReal2"></b>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control" type="text" id="monto2" onblur="verificar2();" name="monto2" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mótivo de descuento</label>
                                <textarea id="comentario2" name="comentario2" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <center>
                                    <button type="submit" id="btn_abonar2" class="btn btn-success">GUARDAR</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


		<!-- FIN MODALES PRINCIPALES ALTA -->

        <div class="modal fade modal-alertas"
             id="detalle-prestamo-modal"
             role="dialog">
            <div class="modal-dialog modal-lg" style="width:70% !important;height:70% !important;">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>4

                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

		<div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-body"></div>
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
								<h3 class="card-title center-align">Préstamos, descuentos y penalizaciones</h3>
								<div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Saldo activos:</h4>
                                                    <p class="input-tot pl-1" name="saldoActivos" id="saldoActivos">$0.00</p>
                                                </div>
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Abonado :</h4>
                                                    <p class="input-tot pl-1" name="saldoAbonado" id="saldoAbonado">$0.00</p>
                                                </div>
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Pendiente :</h4>
                                                    <p class="input-tot pl-1" name="saldoPendiente" id="saldoPendiente">$0.00</p>
                                                </div>
                                            </div>
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
                                                <div class="form-group d-flex justify-center align-center">
													<button ype="button" class="btn-gral-data" data-toggle="modal" data-target="#modalPrestamosPenalizaciones">Préstamos / Penalizaciones</button>
												</div>
											</div>

											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
                                                <div class="form-group d-flex justify-center align-center">
													<button ype="button" class="btn-gral-data btn-s-orangeLight" data-toggle="modal" data-target="#miModal">Descuento Nuevos Pagos</button>
												</div>
											</div>

											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
                                                <div class="form-group d-flex justify-center align-center">
													<button ype="button" class="btn-gral-data btn-s-acidGreen" data-toggle="modal" data-target="#miModal2">Descuento Pagos en Revisión</button>
												</div>
											</div>
                                        </div>
                                    </div>
                                </div>
								<div class="material-datatables">
									<div class="form-group">
										<div class="table-responsive">
											<table class="table-striped table-hover" id="tabla_prestamos" name="tabla_prestamos">
												<thead>
													<tr>
														<th>ID PRÉSTAMO</th>
														<th>ID USUARIO</th>
														<th>USUARIO</th>
														<th>MONTO</th>
														<th>N°</th>
														<th>PAGO CORRESP.</th>
														<th>ABONADO</th>
														<th>PENDIENTE</th>
														<th>COMENTARIO</th>
														<th>ESTATUS</th>
														<th>TIPO</th>
														<th>FECHA DE REGISTRO</th>
														<th>MÁS</th>
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
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
	</div><!--main-panel close-->
	<?php $this->load->view('template/footer');?>
	<!--DATATABLE BUTTONS DATA EXPORT-->
	<script src="<?= base_url() ?>dist/js/controllers/prestamos/activos.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

</body>