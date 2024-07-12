<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="cancelarLote" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" > 
					<div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                                <h4>¿Estás seguro de realizar la cancelación del contrato de lote?</h4>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <input type="hidden" name="idLote" id="idLote">
                                <input type="hidden" name="nombreLote" id="nombreLote">
                                <input type="hidden" name="idCliente" id="idCliente">
                                <label class="control-label overflow-hidden" for="proyecto">Observaciones</label>
                                <textarea name="obsSolicitudCancel" id="obsSolicitudCancel" placeholder="Ingresa aquí tus comentarios" class="text-modal" required row="4"></textarea>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-2">
                                <label class="control-label overflow-hidden" for="proyecto">Tipo de cancelación</label>
                                <select name="tipoCancelacion" id="tipoCancelacion" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                            </div>
                        </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" id="save" name="save" class="btn btn-primary">Aceptar</button>
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
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Cancelación de contrato</h3>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label class="control-label overflow-hidden" for="proyecto">Proyecto</label>
                                                <select name="proyecto" id="proyecto" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6"></div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="tabla_lotes" name="tabla_lotes">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>ID LOTE </th>
                                                    <th>SUPERFICIE</th>
                                                    <th>PRECIO</th>
                                                    <th>NOMBRE</th>
                                                    <th>COMENTARIO REUBICACIÓN</th>
                                                    <th>COMENTARIO</th>
                                                    <th>TIPO DE CANCELACIÓN</th>
                                                    <th>ESTATUS</th>
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
    </div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/reestructura/cancelacion.js"></script>