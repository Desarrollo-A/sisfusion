<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
	<div class="wrapper ">
		<?php $this->load->view('template/sidebar'); ?>

		<div class="modal fade " id="addEditClausulasModal" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Agregar o editar cláusulas para <b><span class="nombreLote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label class="control-label">Cláusulas</label>
								<textarea class="text-modal" name="clausulas" id="clausulas" autocomplete="off" cols="40" rows="5"></textarea>
								<br>
							</div>
							<input type="hidden" name="id_clausula" id="id_clausula">
							<input type="hidden" name="idLote" id="idLote">
						</div>
					</div>
					<br>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" onClick="addEditClausulas()" class="btn btn-primary">Registrar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade " id="addVentaParticularModal" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Remover Venta Particular para <b><span class="nombreLote"></span></b></label></h4>
					</div>
					<div class="modal-body">
						<div class="form-group m-0 overflow-hidden">
							<label class="control-label " for="proyecto">TIPO DE VENTA</label>
							<select name="tipo_venta" id="tipo_venta" class="selectpicker select-gral m-0 rl" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
								<option value="0">SIN ESPECIFICAR</option>
								<option value="2">NORMAL</option>
							</select>
						</div>
						<input type="hidden" name="idLote" id="idLote">
					</div>
					<br>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" name="btnVentaParticular" id="btnVentaParticular" onClick="addVentaParticular()" class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</div>
		</div>

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
									<h3 class="card-title center-align">Reporte de lotes bloqueados</h3>
								</div>
								<div class="toolbar">
									<div class="row">
									</div>
								</div>
								<div class="material-datatables">
									<table id="tablaClausulasLotesParticulares" name="tablaClausulasLotesParticulares" class="table-striped table-hover">
										<thead>
											<tr>
												<th>PROYECTO</th>
												<th>CONDOMINIO</th>
												<th>LOTE</th>
												<th>ID LOTE</th>
												<th>SUPERFICIE</th>
												<th>PRECIO M2</th>
												<th>TOTAL</th>
												<th>REFERENCIA</th>
												<th>ESTATUS</th>
												<th>CLÁUSULAS</th>
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
		<?php $this->load->view('template/footer_legend'); ?>
	</div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>dist/js/controllers/caja/clausulasLotesParticulares.js?v=1.1.3"></script>