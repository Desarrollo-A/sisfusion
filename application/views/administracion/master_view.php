<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
	<div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

		<div class="modal fade" id="seeInformationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">¿Qué opción desea hacer?</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="card card-plain">
									<div class="card-content">
										<!--<h4 id="idLotelbl"></h4>-->
										<div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group overflow-hidden">
                                                    <label class="control-label">OPCIÓN</label>
                                                    <select name="optSelect" id="optSelect" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true"  data-container="body" required></select>
                                                </div>
                                            </div>
                                    	</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal"> CERRAR </button>
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
										<div class="col-6 col-sm-6 col-md-4 col-lg-4">
											<div class="form-group">
												<label class="control-label label-gral">Lote</label>
												<input id="inp_lote" name="inp_lote" class="form-control input-gral" type="number">
											</div>
										</div>
										<div class="col-6 col-sm-6 col-md-4 col-lg-4 mt-3">
											<div class="form-group">
												<button type="button" class="btn-gral-data find_doc"> Buscar </button>
											</div>
										</div>
									</div>				
								</div>
								<div class="material-datatables">
                                    <div class="form-group">
										<table class="table-striped table-hover hide" id="tabla_inventario_contraloria" name="tabla_inventario_contraloria">
											<thead>
												<tr>
													<th>PROYECTO</th>
													<th>CONDOMINIO</th>
													<th>IDLOTE</th>
													<th>LOTE</th>
													<th>CLIENTE</th>
													<th>FECHA APARTADO</th>
													<th>REPRESENTANTE LEGAL</th>
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
	<?php $this->load->view('template/footer');?>
	<script src="<?= base_url() ?>dist/js/controllers/administracion/master_view.js"></script>
</body>