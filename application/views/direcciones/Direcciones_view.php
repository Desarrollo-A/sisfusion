<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet" />

<div class="wrapper">
    <?php $this->load->view('template/sidebar'); ?>

    <div class="modal fade" id="editCatalogoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header pb-0 ">
                    <h4 class="text-center" class="modal-title">¿Estás seguro de cambiar de estatus?</h4>
                </div>
                <div class="modal-body pt-0">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                    <label class="d-flex justify-center pt-2" for="estatus_n"></label>
                                    <input type="text" class="hide" id="id_direccion">
                                    <input type="text" class="hide" id="estatus_n">
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-center mt-0">
                                        <button type="button" class="btn btn-danger btn-simple mt-1" data-dismiss="modal">Cancelar</button>
                                        <button type="button" id="btn_aceptar"class="btn btn-primary mt-1">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="OpenModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="material-icons">clear</i>
                    </button>
                    <h4 class="modal-title">Ingresa nueva dirección</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">DIRECCIÓN(<span class="text-danger">*</span>)</label>
                                    <input id="direccion" name="direccion" type="text" class="form-control input-gral" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group ">
                                    <label class="control-label">ESTADO(<span class="text-danger">*</span>)</label>
                                    <select class="selectpicker select-gral" name="id_sede" id="id_sede" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-center"> 
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">HORA INICIAL(<span class="text-danger">*</span>)</label>
                                    <input id="hora_inicio" name="hora_inicio" type="number" class="form-control input-gral" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">HORA FINAL(<span class="text-danger">*</span>)</label>
                                <input id="hora_fin" name="hora_fin" type="number" class="form-control input-gral" required>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-end">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="guardarDireccion" name="guardarDireccion" class="btn btn-primary">Aceptar</button>
                    </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="openModalDirecciones" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h4 class="modal-title">Editar</h4>
            </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">DIRECCIÓN(<span class="text-danger">*</span>)</label>
                            <input id="direccionM" name="direccionM" type="text" class="form-control input-gral" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group ">
                            <label class="control-label" for="id_sedeEdit">ESTADO(<span class="text-danger">*</span>)</label>
                            <select class="selectpicker select-gral" name="id_sedeEdit" id="id_sedeEdit" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" required></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">HORA INICIAL(<span class="text-danger">*</span>)</label>
                            <input id="hora_inicioM" name="hora_inicioM" type="number" class="form-control input-gral" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">HORA FINAL(<span class="text-danger">*</span>)</label>
                            <input id="hora_finM" name="hora_finM" type="number" class="form-control input-gral" required>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer d-flex justify-end">
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="editDirecciones" name="editDirecciones" class="btn btn-primary">Aceptar</button>
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
                                            <th>ID DIRECCIÓN</th>
                                            <th>DIRECCIÓN</th>
                                            <th>ESTADO</th>
                                            <th>HORA INICIO</th>
                                            <th>HORA FINAL</th>
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
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
</div>
</body>
<?php $this->load->view('template/footer'); ?>
<script src="<?= base_url() ?>dist/js/controllers/direcciones/direcciones.js"></script>