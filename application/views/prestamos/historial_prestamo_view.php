<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="<?= base_url() ?>dist/css/commonModals.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">

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
					</form>
					<div class="modal-footer"></div>
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
								<label class="label">Tipo descuento (<b class="text-danger">*</b>)</label>
								<select class="selectpicker" name="tipo" id="tipo" required>
								<option value="">----Seleccionar-----</option>
								</select>
							</div> 
							<div class="form-group">
								<label class="label">Puesto del usuario(<b class="text-danger">*</b>)</label>
								<select class="selectpicker" name="roles" id="roles" required>
									<option value="">----Seleccionar-----</option>
									<option value="7">Asesor</option>
									<option value="9">Coordinador</option>
									<option value="3">Gerente</option>
									<option value="2">Sub director</option>      
								</select>
							</div>
							<div class="form-group" id="users"></div>
							<div class="form-group row">
								<div class="col-md-4">
									<label class="label">Monto prestado (<b class="text-danger">*</b>)</label>
									<input class="form-control" type="number" step="any" required onblur="verificar();" id="monto" name="monto">
								</div>
								<div class="col-md-4">
									<label class="label">Número de pagos (<b class="text-danger">*</b>)</label>
									<input class="form-control" id="numeroP" required onblur="verificar();" type="number" name="numeroP">
								</div>
								<div class="col-md-4">
									<label class="label">Pago</label>
									<input class="form-control" id="pago" required type="text" name="pago" readonly>
								</div>
							</div>
							<div class="form-group">
								<p>Nota:</label><b id="texto" style="font-size:12px;"></b></p>
								<label class="label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="comentario" name="comentario" required  class="form-control" rows="3"></textarea>
							</div>
							<div class="form-group input-group">
								<label class="input-group-btn">
                                    <span class="btn btn-outline btn-file">Seleccionar archivo&hellip;
                                        <input type="file" name="evidencia" id="evidencia" style="visibility: hidden" accept="image/x-png,image/gif,image/jpeg, image/jpg">
                                    </span>
								</label>
									<input type="text" class="form-control" readonly>
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

        <div class="modal fade modal-alertas"
             id="detalle-prestamo-modal"
             role="dialog">
            <div class="modal-dialog modal-lg" style="width:70% !important;height:70% !important;">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
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
								<h3 class="card-title center-align">Préstamos y penalizaciones</h3>
								<div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <h4 class="title-tot center-align m-0">Préstamos activos:</h4>
                                                    <p class="input-tot pl-1" name="totalp" id="totalp">$0.00</p>
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
	</div>
	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/comisiones/prestamos_individuales.js"></script>
	<script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
	<script>

	Shadowbox.init();

</script>
</body>