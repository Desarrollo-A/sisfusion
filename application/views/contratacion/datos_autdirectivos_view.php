<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<body>
	<div class="wrapper">
		<?php
		    $this->load->view('template/sidebar', '');
		?>

		<style>
			#addFile .radio-with-Icon input[type="radio"]:checked ~ label .iAccepted {
				color: #4caf50;
			}

			#addFile .radio-with-Icon input[type="radio"]:checked ~ label .iDenied {
				color: #929292;
			}

			#addFile .radio-with-Icon input[type="radio"]:checked ~ label .iSend {
				color: #103f75;
			}

			#addFile .radio-with-Icon i {
				color: #eaeaea;
			}

			#addFile .radio-with-Icon i:hover {
				color: #929292;
			}
		</style>

		<!-- Modals -->
		<!-- modal  INSERT COMENTARIOS-->
		<div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<form method="POST" name="sendAutsFromD" id="sendAutsFromD" enctype="multipart/form-data" action="<?=base_url()?>registroCliente/updateAutsFromsDC">
						<div class="modal-header d-flex justify-between align-center">
							<h3 class="modal-title" id="myModalLabel">Autorizaciones</h3>
							<label class="m-0">(<span class="items"></span>) autorizaciones pendientes</label>
						</div>
						<div class="modal-body pl-0 pr-0">
							<div class="scroll-styles" id="loadAuts" style="max-height:450px; padding:0 20px; overflow:auto"></div>
							<input hidden name="numeroDeRow" id="numeroDeRow">
							<input hidden name="idCliente" id="idCliente">
							<input hidden name="idCondominio" id="idCondominio">
							<input hidden name="idLote" id="idLote">
							<input hidden name="id_autorizacion" id="id_autorizacion">
							<input hidden name="nombreResidencial" id="nombreResidencial">
							<input hidden name="nombreCondominio" id="nombreCondominio">
							<input hidden name="nombreLote" id="nombreLote">						
						</div>
						<div class="modal-footer">
							<button type="submit"  class="btn btn-primary">Enviar autorización</button>
							<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- END Modals -->

		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#autorizaciones" role="tab"  data-toggle="tab">AUTORIZACIONES</a>
                            </li>
                            <li>
                                <a href="#autorizaciones-verificacion" role="tab"  data-toggle="tab">AUTORIZACIONES CLIENTE</a>
                            </li>
                        </ul>
						<div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="autorizaciones">
                                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                                <i class="material-icons">verified_user</i>
                                            </div>
                                            <div class="card-content">
                                                <h3 class="card-title center-align">Tus autorizaciones</h3>
                                                <table id="addExp" class="table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>PROYECTO</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>ASESOR(es)</th>
                                                        <th>GERENTE</th>
                                                        <th>AUTORIZACIÓN</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="autorizaciones-verificacion">
                                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                                <i class="material-icons">verified_user</i>
                                            </div>
                                            <div class="card-content">
                                                <h3 class="card-title center-align">Tus autorizaciones</h3>
                                                <table id="aut-verificacion" class="table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>PROYECTO</th>
                                                        <th>LOTE</th>
                                                        <th>CLIENTE</th>
                                                        <th>ASESOR(es)</th>
                                                        <th>GERENTE</th>
                                                        <th>AUTORIZACIÓN</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
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
		</div>
		<?php $this->load->view('template/footer_legend');?>
	</div>
	</div><!--main-panel close-->
	<?php $this->load->view('template/footer');?>
	<!--DATATABLE BUTTONS DATA EXPORT-->
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
	<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
	<script src="<?=base_url();?>dist/js/controllers/registro-cliente/autorizacionDirectivos.js"></script>
</body>