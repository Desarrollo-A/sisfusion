<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>
        
        <!-- Modals -->
        <div class="modal fade " id="modalConfirmRequest" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md">
                <form method="POST" name="sendControversy" id="sendControversy">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-body text-center">
                                <h5>¿Estás seguro de ingresar una controversia para el siguiente lote? <b id="loteName"></b></h5>
                                <p><small>El cambio no podrá ser revertido.</small></p>
                                <textarea class="form-control label-gral" id="controversy" name="controversy" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
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
                </div>
            </div>
        </div>

        <div class="modal fade" id="solicitarAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="subir_evidencia_form" name="subir_evidencia_form" method="post">
                        <div class="modal-header">
                            <div class="card-header d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="mx-3">
                                        <h4 class="modal-title">Subir evidencia</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <label>Sube tu archivo:</label><br>
                            <div class="input-group"><label class="input-group-btn">
                                    <span class="btn btn-primary btn-file">Seleccionar archivo&hellip;
                                        <input type="file" name="docArchivo1" id="expediente1" style="visibility: hidden"
                                            accept="image/x-png,image/gif,image/jpeg, image/jpg">
                                    </span></label><input type="text" class="form-control" id="txtexp1" readonly></div>
                            <label>Observaciones : </label>
                            <textarea class="form-control" id="comentario_0" name="comentario_0" rows="3" style="width:100%;" placeholder="Ingresa tu comentario" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                            <input type="hidden" id="tamanocer" name="tamanocer" value="1">
                            <input type="hidden" name="idCliente" id="idClienteEv">
                            <input type="hidden" name="idLote" id="idLoteEv">
                            <input type="hidden" name="id_sol" id="id_sol" value="<?=$this->session->userdata('id_usuario');?>">
                            <input type="hidden" name="nombreLote" id="nombreLoteEv">
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-primary" onclick="return validateEmptyFields()" id="btnSubmit">
                                Enviar autorización
                            </a>
                            <button type="submit" id="btnSubmitEnviar" class="btn btn-success hide"> Enviar autorización
                            </button>
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
                                                <label class="control-label">Asesores</label>
                                                <select id="asesores" name="asesores" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona el asesor" data-size="7" required>
                                                </select>
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
                                                        <select id="sedess" name="sedess" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="Selecciona una sede" data-size="7" required disabled>
                                                        </select>
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
                                                            <input type="text" class="form-control datepicker" class="dates" id="beginDate" value="01/01/2021" disabled/>
                                                            <input type="text" class="form-control datepicker" class="dates"  id="endDate" value="01/01/2021" style="border-radius: 0 27px 27px 0" disabled/>
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
                                            <table id="clients-datatable" class="table-striped table-hover">
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
                                                <tbody>
                                                </tbody>
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
    <script>
        userType = <?= $this->session->userdata('id_rol') ?> ;
        idUser = <?= $this->session->userdata('id_usuario') ?> ;
        typeTransaction = 1;
    </script>

    <!-- MODAL WIZARD -->
    <script src="<?=base_url()?>dist/js/modal-steps.min.js"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="<?= base_url() ?>dist/js/moment.min.js"></script>
    <script src="<?= base_url() ?>dist/js/es.js"></script>
    <!-- DateTimePicker Plugin -->
    <script src="<?= base_url() ?>dist/js/bootstrap-datetimepicker.js"></script>
    <script src="<?=base_url()?>dist/js/controllers/report_prospects.js"></script>
</body>