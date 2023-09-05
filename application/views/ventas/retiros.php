<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">

        <?php $this->load->view('template/sidebar'); ?>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                    </div>
                    <form method="post" id="form_aplicar">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_log" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="bod"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="modal-title">Retiros</h4>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body">
                            <div class="form-group overflow-hidden overflow-hidden">
                                <label class="control-label">Puesto del usuario</label>
                                <select class="selectpicker select-gral m-0 roles" name="roles" id="roles" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                    <option value="2">Sub director</option>
                                    <option value="1">Director</option>
                                </select>
                            </div>
                            <div class="form-group overflow-hidden" id="users"><label class="control-label">Usuario</label>
                                <select id="usuarioid" name="usuarioid" class="selectpicker select-gral m-0 directorSelect" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required></select>
                            </div>
                            <div class="form-group overflow-hidden">
                                <label class="control-label">Opción</label>
                                <select id="opc" name="opc" class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true"  title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                    <option value="1">RETIRO</option>
                                    <option value="2">INGRESO EXTRA</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" id="labelmonto1">Monto disponible</label>
                                        <input class="form-control input-gral" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
                                    </div>
                                    <div id="montodisponible">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" id="labelmonto2">Monto a descontar</label>
                                        <input class="form-control input-gral" type="number" step="any" id="monto1" name="monto">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Mótivo de descuento</label>
                                <textarea id="comentario" name="comentario" class="text-modal" rows="3" required></textarea>
                            </div>
                            <div class="form-group d-flex justify-end">
                                    <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal">CANCELAR</button>
                                    <button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="fas fa-expand fa-2x"></i>
                            </div>
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Descuentos de resguardos</h3>
                                    <p class="card-title pl-1">(Descuentos aplicados a directivos, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Enviada a resguardo personal'.)</p>
                                </div>
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group text-center">
                                                <h4 class="title-tot center-align m-0">Total resguardo</h4>
                                                <p class="category input-tot pl-1" name="totalpv" id="totalp">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group text-center">
                                                <h4 class="title-tot center-align m-0">Ingresos extras</h4>
                                                <p class="category input-tot pl-1" name="totalx" id="totalx">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group text-center">
                                                <h4 class="title-tot center-align m-0">Saldo disponible</h4>
                                                <p class="category input-tot pl-1" name="totalpv3" id="totalp3">$0.00</p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="form-group text-center">
                                                <h4 class="title-tot center-align m-0">Descuentos aplicados</h4>
                                                <p class="category input-tot pl-1" name="totalpv2" id="totalp2">$0.00</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row aligned-row mb-2">
                                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                            <div class="label-floating select-is-empty overflow-hidden">
                                                <label for="proyecto">Directivo</label>
                                                <select name="filtro33" id="filtro33"  class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex align-end">   
                                                <button type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">APLICAR RETIRO</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <div class="table-responsive">
                                        <table id="tabla_descuentos" name="tabla_descuentos" class="table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>USUARIO</th>
                                                    <th>$ DESCUENTO</th>
                                                    <th>MOTIVO</th>
                                                    <th>ESTATUS</th>
                                                    <th>CREADO POR</th>
                                                    <th>FECHA CAPTURA</th>
                                                    <th>OPCIONES</th>
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
</body>
<?php $this->load->view('template/footer'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="<?=base_url()?>dist/js/controllers/ventas/retiros.js"></script>