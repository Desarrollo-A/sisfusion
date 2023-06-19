<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body class="">
<div class="wrapper ">
	<?php  $this->load->view('template/sidebar', ""); ?>
	
	<!--Contenido de la página-->
	<div class="modal fade modal-alertas" id="modal_autorizacion" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Subir archivo de autorización.</h4>
				</div>
				<form method="post" action="<?= base_url() ?>index.php/registroCliente/alta_autorizacionVentas/" enctype="multipart/form-data" name="status">
					<input type="hidden" name="idCliente" id="idCliente">
					<input type="hidden" name="idClienteHistorial" id="idClienteHistorial">
					<input type="hidden" name="idLoteHistorial" id="idLoteHistorial">
					<input type="hidden" name="idUser" id="idUser">
					<input type="hidden" name="idCondominio" id="idCondominio">
					<input type="hidden" name="nombreResidencial" id="nombreResidencial">
					<input type="hidden" name="nombreLote" id="nombreLote">
					<input type="hidden" name="nombreCondominio" id="nombreCondominio">
					<div class="modal-body">
					</div>
					<div class="modal-footer"><br><br>
       					<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
       					<button class="btn btn-primary btn-fillbtn-fill">Guardar</button>
					</div>
				</form>
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
                            <h3 class="card-title center-align">Ingresar autorización</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select name="condominio" id="condominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Lote</label>
                                            <select name="lote" id="lote" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
									<table class="table-striped table-hover hide" id="tabla_autorizaciones_ventas" name="tabla_autorizaciones_ventas">
										<thead>
											<tr>
												<th>LOTE</th>
												<th>CONDOMINIO</th>
												<th>PROYECTO</th>
												<th>CLIENTE</th>
												<th>AUTORIZACIÓN</th>
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
<script src="<?=base_url()?>dist/js/controllers/ventasAsistentes/datos_cliente_autorizacion_ventasAsistentes.js"></script>

