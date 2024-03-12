
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<style>
.form-check.form-switch {
    display: flex;
    align-items: center;
}

.checkbox {
    position: relative;
    display: inline-block;
	cursor: pointer;
}

.checkbox input[type="checkbox"] {
    position: absolute;
    opacity: 0;
}

#divSwitch{
	/*cursor: not-allowed !important;*/
}

.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
    background-color: #e6e6e6;
    border-radius: 20px;
    transition: background-color 0.3s;
}
.switch:before {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    background-color: #fff;
    border-radius: 50%;
    box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s;
    top: 50%;
    transform: translateY(-50%);
}

.checkbox input[type="checkbox"]:checked + .switch {
    background-color: #007bff;
}

.checkbox input[type="checkbox"]:checked + .switch:before {
    transform: translateX(20px) translateY(-50%);
}

.checkbox input[type="checkbox"]:not(:checked) + .switch:before {
    transform: translateY(-50%);
}
</style>	



<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>
		<?php  $this->load->view('documentacion/documentosModales'); ?> <!--Modales para el manejo de los documentos-->

		<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h4 class="modal-title">¿Qué acción desea realizar?</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="card card-plain">
									<div class="card-content">
										<form method="post" id="form_rl">
    										<div class="row" id="opcionesRow">
        										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            										<div class="form-group overflow-hidden">
                										<label class="control-label">OPCIÓN</label>
														<!--title="SELECCIONA UNA OPCIÓN"-->
                										<select name="opciones" id="opciones" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-size="7" data-live-search="true" data-container="body" data-toggle="tooltip" data-placement="top">
															<option value="">SELECCIONA UNA OPCIÓN</option>
														</select>
													</div>
												</div>
											</div>
											<div class="row rowHide">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group overflow-hidden">
														<select name="representante" id="representante" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" ></select>
													</div>
												</div>
											</div>
											<div class="row rowHide">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group overflow-hidden">
														<select name="tipoVenta" id="tipoVenta" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" ></select>
													</div>
												</div>
											</div>
											<div class="row rowHide">
												<div class="col-xs-4 col-sm-6 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<select name="sedes" id="sedes" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" ></select>
													</div>
												</div>
												<div class="col-xs-4 col-sm-6 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<input class="form-control input-gral" id="impuesto" type="number" name="impuesto">
													</div>
												</div>
											</div>
											<!-- rep = Representante Legal CRUD-->
											<div class="row rowHide">
												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group overflow-hidden">
														<select name="repData" id="repData" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" ></select>
													</div>
												</div>
												<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group overflow-hidden">
														<select name="repEstatus" id="repEstatus" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" >
															<option value="0">INACTIVO</option>
															<option value="1">ACTIVO</option>
														</select>
													</div>
												</div>
											</div>
											
											<div class="row rowHide">
												<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<input class="form-control input-gral m-0" placeholder="Ingrese el nombre"  value=''  id="nombre_rep" type="text" name="nombre_rep">
													</div>
												</div>
												<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<input class="form-control input-gral m-0" placeholder="Ingrese el apellido paterno"  value='' id="paterno_rep" type="text" name="paterno_rep">
													</div>
												</div>
												<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
													<div class="form-group overflow-hidden">
														<input class="form-control input-gral m-0" placeholder="Ingrese el apellido materno"  value='' id="materno_rep" type="text" name="materno_rep">
													</div>
												</div>
											</div>
											<div class="row rowHide" id="rowArchivo"></div>
											<div class="row rowHide" id="rowComentario">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<textarea class="text-modal" rows="3" placeHolder="Ingrese el comentario." id="comentarioLote" name="comentarioLote"></textarea>
												</div>
											</div>
											<div class="row rowHide" id="rowCheck">
                                                <div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
                                                    <div class="form-check form-switch" data-bs-toggle="tooltip" data-placement="top" title="">
                                                        <label class="checkbox" for="switchCheckbox">
                                                            <input type="checkbox" id="switchCheckbox" name="switchCheckbox">
                                                            <div class="switch"  id="divSwitch"></div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-10 col-sm-8 col-md-8 col-lg-4">
                                                    <label class="control-label overflow-hidden" for="switchChekbox" id="lblSwitch">CAMBIAR LOTE DE INTERCAMBIO A CONTRATADO</label>
                                                </div>
                                            </div>											
										
											<input type="hidden" name="idCliente" id="idCliente" value="">
                            				<input type="hidden" name="idLoteValue" id="idLoteValue" value="">
											<input type="hidden" name="docTipo" id="docTipo" value="">
										</form>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
						<button type="button" id="btn_upt" class="btn btn-gral-data">GUARDAR</button>
                    </div>
				</div>
			</div>
		</div>

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon fa-2x" data-background-color="goldMaderas"><i class="fas fa-box"></i></div>
							<div class="card-content">
								<h3 class="card-title center-align">Inventario de lotes</h3>
								<div class="toolbar">
									<div class="row">
										<div class="col col-xs-6 col-sm-5 col-md-4 col-lg-4">
											<div class="form-group">
												<label class="control-label label-gral">Lote</label>
												<input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
											</div>
										</div>
										<div class="col col-xs-4 col-sm-5 col-md-4 col-lg-4 mt-3">
											<div class="form-group">
												<button type="button" class="btn-gral-data find_doc"> Buscar </button>
											</div>
										</div>
										<div class="col col-xs-2 col-sm-2 col-md-4 col-lg-4 mt-3">
											<div class="form-group">
												<button class="btn-rounded btn-s-greenLight apply-action" id="moreOptions" name="moreOptions" title="Más opciones"><i class="fas fa-plus"></i></button>
											</div>
										</div>
									</div>				
								</div>
								<div class="material-datatables">
                                    <div class="form-group">
										<table class="table-striped table-hover hide" id="tableDoct" name="tableDoct">
											<thead>
												<tr>
													<th>PROYECTO</th>
													<th>CONDOMINIO</th>
													<th>CLIENTE</th>
													<th>FECHA APARTADO</th>
													<th>REPRESENTANTE LEGAL</th>
													<th>TIPO VENTA</th>
													<th>LOTE</th>
													<th>ID LOTE</th>
													<th>ESTATUS CONTRATACIÓN</th>
													<th>MOVIMIENTO</th>
													<th>ESTATUS LOTE</th>
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

		<div class="modal fade modal-alertas" id="myModalUpdate" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="title_option">¿Realmente desea actualizar el dato?</h4>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger btn-simple" id="cancelar" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary" id="actualizarBtn" data-dismiss="modal">ACEPTAR<div class="ripple-container"></div></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div>
	<?php $this->load->view('template/footer');?>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/administracion/master_view.js"></script>
	<script src="<?= base_url() ?>dist/js/controllers/documentacion/documentacion.js"></script>
</body>