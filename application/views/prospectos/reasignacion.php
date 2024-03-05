<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
<body class="">
    <div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>
        <div class="modal fade " id="reAsignarModal" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content" >
					<div class="modal-header">
						<h4 class="modal-title text-center" id="mainLabelText"></h4>
					</div>
					<div class="modal-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" id="tvLbl">* Asesor</label>
							<select required="required" name="asesores" id="asesores" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body"></select>			
						</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" id="tvLbl">Coordinador</label>
							<select name="coordinadores" id="coordinadores" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body"></select>			
						</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" id="tvLbl">* Gerente</label>
							<select required="required" name="gerentes" id="gerentes" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body"></select>			
						</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" id="tvLbl">* Subdirector</label>
							<select required="required" name="subdirectores" id="subdirectores" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body"></select>			
						</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" id="tvLbl">Director regional</label>
							<select name="directoresRegionales" id="directoresRegionales" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body"></select>			
						</div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label class="control-label" id="tvLbl">Director regional 2</label>
							<select name="directoresRegionales2" id="directoresRegionales2" class="selectpicker select-gral" data-style="btn" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-container="body"></select>			
						</div>
                        <input type="hidden" name="idProspecto" id="idProspecto">
                        <input type="hidden" name="tipoTransaccion" id="tipoTransaccion">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
						<button type="button" id="sendRequestButton" class="btn btn-primary">Registrar</button>
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
                                <i class="fas fa-list fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <div class="toolbar">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12 col-sm-3 col-md-6 col-lg-6 overflow-hidden">
                                                <label class="label-gral m-0">
                                                    Tipo de usuario (<span class="isRequired">*</span>)
                                                </label>
                                                <select class="selectpicker select-gral m-0" id="tipoUsuario" name="tipoUsuario" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una opción" data-size="7" data-container="body"></select>
                                            </div>
                                            <div class="col-12 col-sm-3 col-md-6 col-lg-6">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-md-12 p-r">
                                                            <div class="form-group d-flex">
                                                                <input type="text" class="form-control datepicker" id="beginDate" />
                                                                <input type="text" class="form-control datepicker" id="endDate"/>
                                                                <button class="btn btn-success btn-round btn-fab btn-fab-mini"id="searchByDateRange">
                                                                    <span class="material-icons update-dataTable">search</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables ml-2 hide" id="box-listaProspectos">
                                    <div class="form-group">
                                        <table id="tablaListaProspectos" name="tablaListaProspectos" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID</th>
                                                    <th>PROSPECTO</th>
                                                    <th>CORREO</th>
                                                    <th>TELÉFONO</th>
                                                    <th>ASESOR</th>
                                                    <th>COORDINADOR</th>
                                                    <th>GERENTE</th>
                                                    <th>SUBDIRECCIÓN</th>
                                                    <th>DIRECTOR REGIONAL</th>
                                                    <th>DIRECTOR REGIONAL 2</th>
                                                    <th>LUGAR DE PROSPECCIÓN</th>
                                                    <th>FECHA ALTA</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    <?php $this->load->view('template/footer'); ?>
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?= base_url() ?>dist/js/nouislider.min.js"></script>
    <script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
    <script src="<?= base_url() ?>dist/js/controllers/prospectos/reasignacion.js"></script>
</body>