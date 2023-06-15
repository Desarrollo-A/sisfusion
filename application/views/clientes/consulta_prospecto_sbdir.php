<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
<div class="wrapper">
	<?php $this->load->view('template/sidebar', $datos); ?>

    <div class="content boxContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-address-book fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Listado general de prospectos</h3>
                            <div class="toolbar">
                                <div class="row">
                                    <div id="filterContainer" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">GERENTE</label>
                                                <select name="gerente" id="gerente" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona gerente" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">COORDINADOR</label>
                                                <select name="coordinador" id="coordinador" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona coordinador" data-size="7" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group label-floating select-is-empty">
                                                <label class="control-label">ASESOR</label>
                                                <select name="asesores" id="asesores" class="selectpicker select-gral m-0"
                                                        data-style="btn" data-show-subtext="true"  title="Selecciona asesor" data-size="7" required>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-lg-offset-6 col-md-offset-6 col-sm-offset-6">
                                        <div class="container-fluid p-0">
                                            <div class="row">
                                                <div class="col-md-12 p-r">
                                                    <div class="form-group d-flex">
                                                        <input type="text" class="form-control datepicker" id="beginDate" value="01/01/2021" />
                                                        <input type="text" class="form-control datepicker" id="endDate" value="01/01/2021" />
                                                        <button class="btn btn-success btn-round btn-fab btn-fab-mini" id="searchByDateRange">
                                                            <span class="material-icons update-dataTable">search</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="material-datatables">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table id="prospects-datatable_dir"  class="table-striped table-hover" style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th>ESTADO</th>
                                                <th>ETAPA</th>
                                                <th>PROSPECTO</th>
                                                <th>ASESOR</th>
                                                <th>COORDINADOR</th>
                                                <th>GERENTE</th>
                                                <th>LUGAR DE PROSPECCIÓN</th>
                                                <th>CREACIÓN</th>
                                                <th>VENCIMIENTO</th>
                                                <?php
                                                    if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5){?>
                                                        <th>ACCIONES</th>
                                                        <!-- <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 103px;">
                                                            <input  type="text"
                                                                    style="width:100%; background:#143860!important; color:white; border: 0; font-weight: 500;"
                                                                    class="textoshead" 
                                                                    placeholder="ACCIONES">
                                                        </th> -->
                                                <?php
                                                    }
                                                ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php include 'common_modals.php' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="content hide">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="block full">
						<div class="row">
							<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="card">
									<div class="card-header card-header-icon" data-background-color="goldMaderas">
										<i class="material-icons">list</i>
									</div>
									<div class="card-content">
										<div class="row">
											<h4 class="card-title">Listado general de prospectossas</h4>
											<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<select name="gerente" 
                                                            id="gerente"
                                                            class="selectpicker select-gral" 
															data-style="btn btn-round"
                                                            title="Selecciona una opción"
                                                            data-size="7">
													</select>
												</div>
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<select name="coordinador"
                                                            id="coordinador"
                                                            class="selectpicker select-gral" 
															data-style="btn btn-round"
                                                            title="Selecciona una opción"
                                                            data-size="7">
													</select>
												</div>
												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<select name="asesores"
                                                            id="asesores"
                                                            class="selectpicker select-gral" 
															data-style="btn btn-round"
                                                            title="Selecciona una opción"
                                                            data-size="7">
													</select>
												</div>
											</div>
											<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">

												<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
													<div id="external_filter_container18"><B> Búsqueda por Fecha </B></div>
													<br>
													<div id="external_filter_container7"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="card">
									<!--<div class="card-header card-header-icon" data-background-color="goldMaderas">
										<i class="material-icons">list</i>
									</div>-->
									<div class="card-content">
										<div class="row">
											<!--<h4 class="card-title">Listado general de prospectos</h4>-->
											<div class="table-responsive">
												<div class="material-datatables">
													<table id="prospects-datatable_dir" class="table table-striped table-no-bordered table-hover" style="text-align:center;"><!--table table-bordered table-hover -->
														<thead>
														<tr>
                                                            <th class="disabled-sorting text-right"><center>Estado</center></th>
                                                            <th class="disabled-sorting text-right"><center>Etapa</center></th>
															<th class="disabled-sorting text-right"><center>Prospecto</center></th>
															<th class="disabled-sorting text-right"><center>Asesor</center></th>
															<th class="disabled-sorting text-right"><center>Coordinador</center></th>
                                                            <th class="disabled-sorting text-right"><center>Gerente</center></th>
                                                            <th class="disabled-sorting text-right"><center>Lugar de prospección</center></th>
															<th class="disabled-sorting text-right"><center>Creación</center></th>
															<th class="disabled-sorting text-right"><center>Vencimiento</center></th>
															<?php
															if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5)
															{
															?>
																<th class="disabled-sorting text-right"
                                                                    style="font-family: inherit; font-size: 10px !important; color:white;">
                                                                    <center>Acciones</center>
                                                                </th>
															<?php } ?>
														</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
													<?php include 'common_modals.php' ?>
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
<!--<script src="--><?php //base_url()?><!--dist/js/jquery.validate.js"></script>-->
<script src="<?= base_url() ?>dist/js/es.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?= base_url() ?>dist/js/fullcalendar.min.js"></script>
<script src="<?=base_url()?>dist/js/moment.min.js"></script>

<!-- MODAL WIZARD -->
<script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
<?php
    if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5)
    {
?>
        <script src="<?=base_url()?>dist/js/controllers/consultaProspectos.js"></script>
<?php
    }
?>

<script src="<?=base_url()?>static/yadcf/jquery.dataTables.yadcf.js"></script>

<script src="<?=base_url()?>dist/js/controllers/clientes/consulta_prospecto_sbdir.js"></script>
</body>