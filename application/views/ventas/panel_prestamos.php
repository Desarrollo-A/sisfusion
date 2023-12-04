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
							<button  type="button" id="updatePrestamo" class="btn btn-gral-data updatePrestamo">Aceptar</button>
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
							</div>
							<div class="form-group">
								<p></label><b id="texto" style="font-size:12px;"></b></p>
								<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="comentario" name="comentario" class="form-control input-gral" rows="3" required></textarea>
							</div>
							<div class="modal-footer">  
								<button type="button"  class="btn btn-danger btn-simple" data-dismiss="modal" >Cancelar</button>	
								<button type="button" id="btn_abonar" class="btn btn-primary">Guardar</button>
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
											<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                                <div class="form-group d-flex justify-center align-center">
													<button ype="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Agregar</button>
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
													<th>PAGO CORRESP.</th>
													<th>ABONADO</th>
													<th>PENDIENTE</th>
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
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
	</div>
	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/comisiones/panel_prestamos.js"></script>
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
</body>