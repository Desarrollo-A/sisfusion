<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
	<?php $this->load->view('template/sidebar'); ?>

	<div class="modal fade" id="fileViewer">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<a style="position: absolute;top:3%;right:3%; cursor:pointer;" data-dismiss="modal">
						<span class="material-icons">close</span>
					</a>
					<div id="cnt-file">
					</div>
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
							<i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Contrato</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <div class="form-group  select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0" data-container="body" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group  select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select name="condominio" id="condominio" class="selectpicker select-gral m-0" data-container="body" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group  select-is-empty">
                                            <label class="control-label">Lote</label>
                                            <select name="lote" id="lote" class="selectpicker select-gral m-0" data-style="btn" data-container="body" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
									<table class="table-striped table-hover hide" id="tabla_contrato_ventas" name="tabla_contrato_ventas">
										<thead>
											<tr>
												<th>PROYECTO</th>
												<th>CONDOMINIO</th>
												<th>LOTE</th>
												<th>CLIENTE</th>
												<th>NOMBRE DEL CONTRATO</th>
												<th>CONTRATO</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/clientes/datos_cliente_contrato_ventasAsistentes.js"></script>

