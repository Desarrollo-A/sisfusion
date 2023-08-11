<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <style>
		.bs-searchbox .form-group{
			padding-bottom: 0!important;
    		margin: 0!important;
		}
	</style>
    <div class="wrapper ">
        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal" tabindex="-1" role="dialog" id="notification">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="p-0 text-center" id="mainLabelText">Asegúrate que el campo <b>Documentos</b> tenga al menos un valor seleccionado.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade " id="addRejectReasonModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-body boxContent p-0">
                            <div class="card no-shadow p-0">
                                <div class="card-content p-0">
                                    <h3 class="card-title center-align">Ingresa el motivo de rechazo que asociarás a <b><p id="documentName"></p></b></h3>
                                    <div class="toolbar">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1">
                                            <div class="form-group" id="main_div">
                                                <label class="control-label">Motivo de rechazo(requerido)</label>
                                                <input id="rejectReason" name="rejectReason" type="text" class="form-control input-gral" required autocomplete="off">
                                                <input id="id_documento" name="id_documento" class="hide">
                                                <input id="id_motivo" name="id_motivo" class="hide">
                                                <input id="action" name="action" class="hide">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input id="idLote" class="hide">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btn_save" class="btn btn-primary" onclick="saveRejectReason()">Aceptar</button>
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
                                <i class="fas fa-file fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="toolbar">
                                    <h3 class="card-title center-align">Administrador de motivos de rechazo por documento y solicitud</h3>
                                    <div class="container-fluid">
                                        <div class="row aligned-row">
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 overflow-hidden">
                                                <label class="label-gral">Documentos</label>
                                                <select id="documentos" name="documentos" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-container="body" data-live-search="true" title="Selecciona una opción" data-size="7"></select>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-2 d-flex align-end">
                                                <button class="btn-rounded btn-s-greenLight apply-action" data-action="0" id="addOption" name="addOption" title="Agregar"><i class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="material-datatables" id="box-reasonsForRejectionTable">
                                    <div class="form-group">
                                        <table class="table-striped table-hover" id="reasonsForRejectionTable" name="reasonsForRejectionTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>DOCUMENTO</th>
                                                    <th>MOTIVO</th>
                                                    <th>ESTATUS</th>
                                                    <th></th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/documentacion/reasonForRejectionDocument.js"></script>
</body>