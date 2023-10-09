<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />

<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade" id="modalBorrar" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-1 text-center">
                        <h4>¿Está seguro de borrar la opción?</h4>
                    </div>
                    <br>
                    <input type="hidden" name="id_direccion" id="id_direccion">
                </div>
                <div class="modal-footer d-flex justify-center">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="borrarOp" name="borrarOp" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id=OpenModalAdd data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="d-flex justify-center">
                    <label class="pt-3">INGRESAR NUEVA DIRECCION</label>
                </div>
                <div class="modal-body d-flex justify-center">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label class="d-flex justify-center">DIRECCION(<span class="text-danger">*</span>)</label>
                            <input type="text" class="form-control input-gral mt-3" id="direccion" name="direccion"
                                required>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label class="d-flex justify-center pb-2" for="id_sede">ESTADO(<span
                                    class="text-danger">*</span>)</label>
                            <select class="selectpicker select-gral" name="id_sede" id="id_sede" data-style="btn"
                                data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7"
                                data-container="body" required></select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label class="d-flex justify-center pt-2">HORA INICIAL(<span
                                    class="text-danger">*</span>)</label>
                            <input type="number" class="form-control input-gral mt-3" id="hora_inicio"
                                name="hora_inicio" required>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label class="d-flex justify-center pt-2">HORA FINAL(<span
                                    class="text-danger">*</span>)</label>
                            <input type="number" class="form-control input-gral mt-3" id="hora_fin" name="hora_fin"
                                required>
                        </div>
                        <div class="modal-footer d-flex justify-end">
                            <button type="button" class="btn btn-danger btn-simple"
                                data-dismiss="modal">Cancelar</button>
                            <button type="button" id="guardarDireccion" name="guardarDireccion"
                                class="btn btn-primary">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id=openModalDirecciones data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="d-flex justify-center">
                    <label class="pt-3">EDITAR </label>
                </div>
                <div class="modal-body d-flex justify-center">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label class="d-flex justify-center">DIRECCION(<span class="text-danger">*</span>)</label>
                            <input type="text" class="form-control input-gral mt-3" id="direccionM" name="direccionM"
                                required>
                        </div>
                        <input type="hidden" name="id_direccion" id="id_direccion">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label class="d-flex justify-center pb-2" for="id_sedeEdit">ESTADO(<span
                                    class="text-danger">*</span>)</label>
                            <select class="selectpicker select-gral" name="id_sedeEdit" id="id_sedeEdit"
                                data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7"
                                data-container="body" required></select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label class="d-flex justify-center pt-2">HORA INICIAL(<span
                                    class="text-danger">*</span>)</label>
                            <input type="number" class="form-control input-gral mt-3" id="hora_inicioM"
                                name="hora_inicio" required>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label class="d-flex justify-center pt-2">HORA FINAL(<span
                                    class="text-danger">*</span>)</label>
                            <input type="number" class="form-control input-gral mt-3" id="hora_finM" name="hora_fin"
                                required>
                        </div>
                        <div class="modal-footer d-flex d-flex justify-end">
                            <button type="button" class="btn btn-danger btn-simple"
                                data-dismiss="modal">Cancelar</button>
                            <button type="button" id="editDirecciones" name="editDirecciones"
                                class="btn btn-primary">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="goldMaderas">
                            <i class="fas fa-user-friends fa-2x"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title center-align">Direcciones</h3>
                            <div class="material-datatables">
                                <table id="direcciones_datatable" class="table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID DIRECCION</th>
                                            <th>ID SEDE</th>
                                            <th>DIRECCION</th>
                                            <th>ESTADO</th>
                                            <th>TIPO OFICINA</th>
                                            <th>HORA INICIO</th>
                                            <th>HORA FINAL </th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
</div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/direcciones/direcciones.js"></script>