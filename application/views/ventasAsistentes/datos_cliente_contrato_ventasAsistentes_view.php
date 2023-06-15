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
						<span class="material-icons">
							close
						</span>
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
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Contrato</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="proyecto"
													id="proyecto"
													class="selectpicker select-gral m-0"
                                                    data-style="btn" 
													data-show-subtext="true"
													data-live-search="true"
													title="Selecciona una opción"
													data-size="7" 
													required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select name="condominio"
													id="condominio"
													class="selectpicker select-gral m-0"
                                                    data-style="btn"
													data-show-subtext="true"
													data-live-search="true"
													title="Selecciona una opción"
													data-size="7"
													required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Lote</label>
                                            <select name="lote"
													id="lote"
													class="selectpicker select-gral m-0"
                                                    data-style="btn"
													data-show-subtext="true"
													data-live-search="true"
													title="Selecciona una opción"
													data-size="7" 
													required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table-striped table-hover" id="tabla_contrato_ventas" name="tabla_contrato_ventas">
                                            <thead>
												<tr>
													<th>PROYECTO</th>
													<th>CONDOMINIO</th>
													<th>LOTE</th>
													<th>CLIENTE</th>
													<th>NOMBRE CONTRATO</th>
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
    </div>


	<!--Contenido de la página-->
	<div class="content hide">
		<div class="container-fluid">
			 
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<center>
						<h4>CONTRATO</h4>
					</center>
					<div class="card">
						<div class="container-fluid" style="padding: 50px 50px;">
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								 
								 <div class="row">

									<div class="col-md-4 form-group">
										<label for="proyecto">Proyecto: </label>
										<select name="proyecto"
												id="proyecto"
												class="selectpicker select-gral m-0"
												data-style="btn"
												data-show-subtext="true"
                                                data-live-search="true"
												title="Selecciona una opción"
												data-size="7"
												required>
									</div>

									<div class="col-md-4 form-group">
										<label for="condominio">Condominio: </label>
										<select name="condominio"
												id="condominio"
												class="selectpicker select-gral m-0"
												data-style="btn"
												data-show-subtext="true"
												data-live-search="true"
												title="Selecciona una opción"
												data-size="7"
												required>
									</div>

									<div class="col-md-4 form-group">
										<label for="lote">Lote: </label>
										<select name="lote"
												id="lote"
												class="selectpicker select-gral m-0"
												data-style="btn"
												data-show-subtext="true"
												data-live-search="true"
												title="Selecciona una opción"
												data-size="7"
												required>
									</div>
								</div>
						</div>

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col xol-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header card-header-icon" data-background-color="goldMaderas">
							<i class="material-icons">reorder</i>
						</div>
						<div class="card-content" style="padding: 50px 20px;">
							<h4 class="card-title"></h4>
							<div class="toolbar">
								<!--        Here you can write extra buttons/actions for the toolbar              -->
							</div>
							<div class="material-datatables">
								<div class="form-group">
									<div class="table-responsive">
										<table class="table table-responsive table-bordered table-striped table-hover" id="tabla_contrato_ventas" name="tabla_contrato_ventas">
                                        <thead>
                                            <tr>
                                                <!-- <th></th> -->
                                                <th>LOTE</th>
                                                <th>CONDOMINIO</th>
                                                <th>PROYECTO</th>
                                                <th>CLIENTE</th>
                                                <th>NOMBRE CONTRATO</th>
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
	</div>
	<?php $this->load->view('template/footer_legend');?>
</div>
</div>

</div><!--main-panel close-->
</body>
<?php $this->load->view('template/footer');?>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/clientes/datos_cliente_contrato_ventasAsistentes.js"></script>

