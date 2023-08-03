<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    
    <div class="wrapper">
		<?php $this->load->view('template/sidebar'); ?>

        <!-- Modals -->
        <div class="modal" tabindex="-1" role="dialog" id="notificacion">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="p-0 text-center">No ha seleccionado al menos un filtro o cargado un documento</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CERRAR</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="coincidenciasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formCoincidencias" name="formCoincidencias">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title" id="myModalLabel">Cargar prospectos</h3>
                        </div>
                        <div class="modal-body">
                            <h5>Selección de archivo a cargar</h5>
                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="file-gph">
                                        <input class="d-none" type="file" id="fileElm">
                                        <input class="file-name" type="text" placeholder="No has seleccionada nada aún" readonly="">
                                        <label class="upload-btn m-0" for="fileElm">
                                            <span>Seleccionar</span>
                                            <i class="fas fa-folder-open"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label class="m-0 check-style">
                                        <input  type="checkbox" class="nombre" name="checks" value="nombre">
                                        <span><i class="fas fa-id-card-alt fa-lg m-1"></i>Nombre</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label class="m-0 check-style">
                                        <input  type="checkbox" class="nombre" name="checks" value="apellido_paterno">
                                        <span><i class="fas fa-id-card-alt fa-lg m-1"></i>Apellido paterno</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label class="m-0 check-style">
                                        <input  type="checkbox" class="nombre" name="checks" value="apellido_materno">
                                        <span><i class="fas fa-id-card-alt fa-lg m-1"></i>Apellido Materno</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label class="m-0 check-style">
                                        <input type="checkbox" class="telefono" name="checks" value="telefono">
                                        <span><i class="fas fa-phone-alt fa-lg m-1"></i>Teléfono</span>
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label class="m-0 check-style">
                                        <input  type="checkbox" class="correo" name="checks" value="correo">
                                        <span><i class="fas fa-at fa-lg m-1"></i>Correo electrónico</span>
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Cargar</button>
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modals -->
        
		<div class="content boxContent">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="card">
							<div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-user-friends fa-2x"></i>
							</div>
							<div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Coincidencias de prospectos</h3>
                                    <p class="card-title pl-1">(En este apartado podrás cargar un archivo excel de prospectos para generar una tabla de coincidencias de clientes ya registrados)</p>
                                </div>
								<div class="row">
									<div class="toolbar">
										<div class="container-fluid">
                                            <div class="row mt-2">
                                                <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2 mb-2">
                                                    <label class="m-0 check-style">
                                                        <input  type="checkbox" class="nombre" name="checks" value="nombre">
                                                        <span><i class="fas fa-id-card-alt fa-lg m-1"></i>Nombre</span>
                                                    </label>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 mb-2">
                                                    <label class="m-0 check-style">
                                                        <input  type="checkbox" class="nombre" name="checks" value="apellido_paterno">
                                                        <span><i class="fas fa-id-card-alt fa-lg m-1"></i>Apellido paterno</span>
                                                    </label>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 mb-2">
                                                    <label class="m-0 check-style">
                                                        <input  type="checkbox" class="nombre" name="checks" value="apellido_materno">
                                                        <span><i class="fas fa-id-card-alt fa-lg m-1"></i>Apellido Materno</span>
                                                    </label>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2 mb-2">
                                                    <label class="m-0 check-style">
                                                        <input type="checkbox" class="telefono" name="checks" value="telefono">
                                                        <span><i class="fas fa-phone-alt fa-lg m-1"></i>Teléfono</span>
                                                    </label>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2 mb-2">
                                                    <label class="m-0 check-style">
                                                        <input  type="checkbox" class="correo" name="checks" value="correo">
                                                        <span><i class="fas fa-at fa-lg m-1"></i>Correo electrónico</span>
                                                    </label>
                                                </div>
                                            </div>
											<div class="row">
                                                <div class="col-sm-12 col-md-3 col-lg-3 mb-2">
                                                    <label class="control-label m-0">AÑO (<span class="isRequired">*</span>)</label>
                                                    <select class="selectpicker select-gral m-0" title="SELECCIONA UNA OPCIÓN" id="anio" required> 
                                                        <option value="2020">2020</option>
                                                        <option value="2021">2021</option>
                                                        <option value="2022">2022</option>
                                                        <option value="2023">2023</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 p-2">
                                                    <div class="file-gph">
                                                        <input class="d-none" type="file" id="fileElm">
                                                        <input class="file-name" type="text" placeholder="NO HAS SELECCIONADO NINGÚN ARCHIVO" readonly="">
                                                        <label class="upload-btn m-0" for="fileElm">
                                                            <span>Seleccionar</span>
                                                            <i class="fas fa-folder-open"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-col-sm-12 col-md-2 col-lg-2 mb-2">
                                                    <div class="">
                                                        <button class="btn-data-gral btn-s-blue" id="cargaCoincidencias" data-toggle="modal">Cargar</button>
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>									
								</div>
								<div class="material-datatables">
									<div class="form-group">
                                        <table id="prospectscon_datatable" class="table-striped table-hover hide">
                                            <thead>
                                                <tr>
                                                    <th>ID LOTE</th>
                                                    <th>LOTE</th>
                                                    <th>CLIENTE</th>
                                                    <th>TELÉFONO</th>
                                                    <th>CORREO</th>
                                                    <th>FECHA DE APARTADO</th>
                                                    <th>LUGAR DE PROSPECCIÓN</th>
                                                    <th>ASESOR</th>
                                                    <th>GERENTE</th>
                                                    <th>SEDE</th>
                                                    <th>ESTATUS</th>
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
    <?php $this->load->view('template/footer');?>
    <script src="<?= base_url() ?>dist/js/controllers/clientes/xlsx.core.min.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/clientes/coincidenciasProspectos.js"></script>
</body>