<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>

<style>
    .radioOption i{
        color: #c1c1c1!important;
    }
</style>
<body>
	<div class="wrapper">
		<?php
		    $this->load->view('template/sidebar', '');
		?>

		<!-- Modals -->
		<!-- modal  INSERT COMENTARIOS-->
		<div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
			<div class="modal-dialog">
				<div class="modal-content" >
					<form name="sendAutsFromD" id="sendAutsFromD">
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
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
							<button type="submit"  class="btn btn-primary">Enviar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

        <!-- Modal autorizaciones clientes códigos -->
        <div class="modal fade" id="autCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form name="autClienteForm" id="autClienteForm">
                        <div class="modal-header d-flex justify-between align-center">
                            <h3 class="modal-title" id="myModalLabel">Autorizaciones</h3>
                            <label class="m-0">(<span class="items-aut"></span>) autorizaciones pendientes</label>
                        </div>
                        <div class="modal-body pl-0 pr-0">
                            <div class="scroll-styles" id="loadAutsCliente" style="max-height:450px; padding:0 20px; overflow:auto"></div>
                            <input hidden name="numeroDeRow" id="numeroDeRowAut">
                            <input hidden name="idCliente" id="idClienteAut">
                            <input hidden name="idCondominio" id="idCondominioAut">
                            <input hidden name="idLote" id="idLoteAut">
                            <input hidden name="id_autorizacion" id="id_autorizacion_aut">
                            <input hidden name="nombreResidencial" id="nombreResidencialAut">
                            <input hidden name="nombreCondominio" id="nombreCondominioAut">
                            <input hidden name="nombreLote" id="nombreLoteAut">
                            <input hidden name="autorizacionesCliente" id="autorizacionesCliente">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<!-- END Modals -->
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#autorizaciones" role="tab"  data-toggle="tab">AUTORIZACIONES</a>
                            </li>
                            <li>
                                <a href="#autorizaciones-verificacion" role="tab"  data-toggle="tab">AUTORIZACIONES DE VERIFICACIÓN</a>
                            </li>
                        </ul>
						<div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="autorizaciones">
                                            <h3 class="card-title center-align">Tus autorizaciones</h3>
                                            <div class="form-group">
                                                <table id="addExp" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>PROYECTO</th>
                                                            <th>LOTE</th>
                                                            <th>CLIENTE</th>
                                                            <th>ASESOR(ES)</th>
                                                            <th>GERENTE</th>
                                                            <th>ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="autorizaciones-verificacion">
                                            <h3 class="card-title center-align">Tus autorizaciones de verificación</h3>
                                            <div class="form-group">
                                                <table id="aut-verificacion" class="table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>PROYECTO</th>
                                                            <th>LOTE</th>
                                                            <th>CLIENTE</th>
                                                            <th>ASESOR(ES)</th>
                                                            <th>GERENTE</th>
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
			</div>
		</div>
		<?php $this->load->view('template/footer_legend');?>
	</div>
	<?php $this->load->view('template/footer');?>
	<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
	<script src="<?=base_url();?>dist/js/controllers/registro-cliente/autorizacionDirectivos.js"></script>
</body>