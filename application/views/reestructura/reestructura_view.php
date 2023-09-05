<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

<body class="">
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade" id="aceptarReestructura" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" > 
					<div class="modal-header">
						<h4 class="modal-title text-center"><label>Aprobar lote para reestructura</label></h4>
					</div>
					<div class="modal-body">
                        <div class="row p-1">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <label>Grabado</label>
                                <select name="grabado" id="grabado" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                    <option value="1">SI</option>
                                    <option value="0">NO</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <label>Proceso juridico</label>
                                <select name="procesoJ" id="procesoJ" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required>
                                    <option value="1">SI</option>
                                    <option value="0">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1">
                            <label>Comentario</label>
                            <textarea class="text-modal" id="comentario2" rows="3"></textarea>
                        </div>
                        <br>
                        <input type="hidden" name="idLote" id="idLoteenvARevCE" >           
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" id="save2" name="save2" class="btn btn-primary">Registrar</button>
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
                                <h3 class="card-title center-align">Reestructuración</h3>
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
                                        <table class="table-striped table-hover" id="tabla_clientes" name="tabla_clientes">
                                            <thead>
                                                <tr>
                                                    <th>PROYECTO</th>
                                                    <th>CONDOMINIO</th>
                                                    <th>LOTE</th>
                                                    <th>ID LOTE </th>
                                                    <th>SUPERFICIE</th>
                                                    <th>PRECIO</th>
                                                    <th>OBSERVACIÓN EN LIBERACIÓN</th>
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
<script src="<?= base_url() ?>dist/js/controllers/reestructura/reestructura.js"></script>