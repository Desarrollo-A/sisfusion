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
					<h4 class="modal-title" data-i18n = "subir-archivo-autorizacion">Subir archivo de autorización.</h4>
				</div>
				<form method="post" id="envioAutorizacion" name="envioAutorizacion" enctype="multipart/form-data">
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
       					<button type="button" class="btn btn-danger btn-simple" data-i18n = "cancelar" data-dismiss="modal">Cancelar</button>
       					<button class="btn btn-primary" data-i18n = "guardar" type="submit">Guardar</button>
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
                            <h3 class="card-title center-align"  data-i18n="ingresar-autorizacion">Ingresar autorización</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Proyecto</label>
                                            <select name="proyecto" id="proyecto" data-i18n  ="proyecto" class="selectpicker select-gral m-0" data-style="btn btn-second" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Condominio</label>
                                            <select name="condominio" id="condominio" data-i18n = "condominio" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <div class="form-group label-floating select-is-empty">
                                            <label class="control-label">Lote</label>
                                            <select name="lote" id="lote" data-i18n  ="lote" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
									<table class="table-striped table-hover hide" id="tabla_autorizaciones_ventas" name="tabla_autorizaciones_ventas">
										<thead>
											<tr>
												<th>lote</th>
												<th>condominio</th>
												<th>proyecto</th>
												<th>cliente</th>
												<th>autorizacion</th>
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
</body>
<?php $this->load->view('template/footer');?>
<script src="<?=base_url()?>dist/js/controllers/ventasAsistentes/datos_cliente_autorizacion_ventasAsistentes.js"></script>

