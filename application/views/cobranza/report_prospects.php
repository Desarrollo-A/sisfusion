<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        <!-- Modals -->
        <div class="modal fade" id="modalConfirmRequest" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <form method="POST" name="sendControversy" id="sendControversy">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-body text-center p-0">
                                <h5>¿Estás seguro de ingresar una controversia para el siguiente lote? <b id="loteName"></b></h5>
                                <p><small>El cambio no podrá ser revertido.</small></p>
                                <textarea class="text-modal" id="controversy" name="controversy" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                                <input name="idCliente" id="idCliente" class="hide">
                                <input name="idLote" id="idLote" class="hide">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="sendRequest">Aceptar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="empty" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h5>Aún no has seleccionado ningún filtro de búsqueda</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">CERRAR</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="solicitarAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="subir_evidencia_form" name="subir_evidencia_form" method="post">
                        <div class="modal-header">
                            <div class="card-header">
                                <div class="text-center">
                                    <div class="mx-3">
                                        <h4 class="modal-title">Subir evidencia</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <label>Sube un archivo<span class="isRequired">*</span></label><br>
                            <div class="input-group m-1">
                                <label class="input-group-btn p-0">
                                    <span class="btn btn-primary btn-file">Seleccionar archivo
                                    <input type="file" name="docArchivo1" id="expediente1" style="visibility: hidden"accept="image/x-png,image/gif,image/jpeg, image/jpg">
                                    </span>
                                </label>
                                <div class="form-group is-empty m-0">
                                    <input type="text" class="form-control m-0" id="txtexp1" readonly>
                                </div>
                            </div>

                            <label>Observaciones: </label>
                            <textarea class="text-modal" id="comentario_0" name="comentario_0" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                            <input type="hidden" id="tamanocer" name="tamanocer" value="1">
                            <input type="hidden" name="idCliente" id="idClienteEv">
                            <input type="hidden" name="idLote" id="idLoteEv">
                            <input type="hidden" name="id_sol" id="id_sol" value="<?=$this->session->userdata('id_usuario');?>">
                            <input type="hidden" name="nombreLote" id="nombreLoteEv">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                            <a href="#" class="btn btn-primary" onclick="return validateEmptyFields()" id="btnSubmit">Enviar autorización</a>
                            <button type="submit" id="btnSubmitEnviar" class="btn btn-success hide"> Enviar autorización</button>
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
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-address-book fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <h3 class="card-title center-align">Listado general de prospectos</h3>
                                <div class="toolbar">
                                    <div class="row d-flex align-end">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group p-0">
                                                <label class="control-label">Asesor</label>
                                                <select id="asesores" name="asesores" class="selectpicker select-gral m-0" data-container="body" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 p-2 boxFilter">
                                        <div class="leyend-filter text-center mb-3">
                                            <label class="m-0 card-title">Filtros de búsqueda</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label class="m-0 check-style">
                                                    <input  type="checkbox" class="nombre" name="checks">
                                                    <span><i class="fas fa-id-card-alt fa-lg m-1"></i>Nombre</span>
                                                </label>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label class="m-0 check-style">
                                                    <input type="checkbox" class="telefono" name="checks">
                                                    <span><i class="fas fa-phone-alt fa-lg m-1"></i>Teléfono</span>
                                                </label>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                <label class="m-0 check-style">
                                                    <input  type="checkbox" class="correo" name="checks">
                                                    <span><i class="fas fa-at fa-lg m-1"></i>Correo electrónico</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex w-100 align-center">
                                                    <div class="w-20">
                                                        <label class="--switch m-0">
                                                            <input type="checkbox" onClick="toggleSelect1()" class="sedes" id="sedes" name="checks">
                                                            <span class="--slider">
                                                                <i class="fas fa-check"></i>
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="w-80">
                                                        <select id="sedess" name="sedess" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" data-container="body" title="SELECCIONA UNA OPCIÓN" data-size="7" required disabled></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex w-100 align-center">
                                                    <div class="w-20">
                                                        <label class="--switch">
                                                            <input type="checkbox" onClick="toggleSelect2()" class="date" id="date" name="checks">
                                                            <span class="--slider">
                                                                <i class="fas fa-check"></i>
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="w-80">
                                                        <div class="form-group d-flex m-0">
                                                            <input type="text" class="form-control datepicker" class="dates" id="beginDate"  disabled/>
                                                            <input type="text" class="form-control datepicker" class="dates"  id="endDate" disabled/>
                                                            <button class="btn btn-success btn-round btn-fab btn-fab-mini"id="searchByDateRange" disabled>
																<span class="material-icons update-dataTable"disabled>search</span>
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
                                        <table id="clients-datatable" class="table-striped table-hover hide">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID CLIENTE</th>
                                                    <th>NOMBRE</th>
                                                    <th>TELÉFONO</th>
                                                    <th>CORREO</th>
                                                    <th>ID LOTE</th>
                                                    <th>LOTE</th>
                                                    <th>FECHA APARTADO</th>
                                                    <th>GERENTE</th>
                                                    <th>LUGAR PROSPECCIÓN</th>
                                                    <th>CONTROVERSIA</th>
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
        <?php $this->load->view('template/footer_legend');?>
    </div>
    <?php $this->load->view('template/footer');?>
    <script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/report_prospects.js"></script>
</body>