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
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <div>
                                    <h3 class="h3 card-title center-align">Descuentos de resguardos</h3>
                                    <p class="card-title pl-1">(Descuentos aplicados a directivos, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Enviada a resguardo personal'.)</p>
                                    </div>
                                </div>
                                <div class="toolbar">
                                <div class="col-xl-3 col-md-3 mb-3" style="padding-top:35px;  margin-bottom:2px">
                                        <div class="card border shadow  py-2">
                                            <div class="card-body">
                                                <div class=" no-gutters align-items-center">
                                                    <div class="col mr-12">
                                                        <div class="text-xs font-weight-bold  lbl-violetDeep text-uppercase center-align">
                                                        Total resguardo:</div>
                                                        <div class="center-align" style="padding-top:20px; margin-bottom:2px; " >
                                                        <i class="fas fa-cash-register fa-2x"  style=" color: #6C3483;" ></i>

                                                        </div>
                                                        <div name="total_resguardo" id="total_resguardo"
                                                            class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0
                                                        </div>
                                                    </div>            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 mb-3" style="padding-top:35px;  margin-bottom:2px">
                                        <div class="card border shadow  py-2">
                                            <div class="card-body">
                                                <div class=" no-gutters align-items-center">
                                                    <div class="col Darkmr-12">
                                                        <div class="text-xs font-weight-bold  lbl-violetDeep text-uppercase center-align">
                                                        Ingresos extras:</div>
                                                        <div class="center-align" style="padding-top:20px; margin-bottom:2px; " >
                                                        <i class="fas fa-vault"></i>
                                                        <i class="fas fa-coins fa-2x " style=" color: #6C3483;" ></i>
                                                        </div>
                                                        <div name="total_extra" id="total_extra" 
                                                            class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0
                                                        </div>
                                                    </div>            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 mb-3" style="padding-top:35px;  margin-bottom:2px">
                                        <div class="card border shadow  py-2">
                                            <div class="card-body">
                                                <div class=" no-gutters align-items-center">
                                                    <div class="col mr-12">
                                                        <div class="text-xs font-weight-bold  lbl-violetDeep text-uppercase center-align">
                                                        Saldo disponible:</div>
                                                        <div class="center-align" style="padding-top:20px; margin-bottom:2px; " >
                                                        <i class="fas fa-money-from-bracket"></i>
                                                        <i class="fas fa-coins fa-2x " style=" color: #6C3483;" ></i>
                                                        </div>
                                                        <div name="total_disponible" id="total_disponible" 
                                                            class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0
                                                        </div>
                                                    </div>            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 mb-3" style="padding-top:35px;  margin-bottom:2px">
                                        <div class="card border shadow  py-2">
                                            <div class="card-body">
                                                <div class=" no-gutters align-items-center">
                                                    <div class="col mr-12">
                                                        <div class="text-xs font-weight-bold  lbl-violetDeep text-uppercase center-align">
                                                        Descuentos aplicados:</div>
                                                        <div class="center-align" style="padding-top:20px; margin-bottom:2px; " >
                                                        <i class="fas fa-comments-dollar fa-2x " style=" color: #6C3483;"></i>
                                                        <!-- <i class="fas fa-coins fa-2x " style=" color: #6C3483;" ></i> -->
                                                        </div>
                                                        <div name="total_aplicado" id="total_aplicado"
                                                            class="h5 totalp mb-0 font-weight-bold text-gray-800 center-align">$0
                                                        </div>
                                                    </div>            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row aligned-row mb-2">
                                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                            <div class="label-floating select-is-empty overflow-hidden">
                                                <label for="proyecto">Directivo</label>
                                                <select name="directivo_resguardo" id="directivo_resguardo"  class="selectpicker select-gral m-0" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-container="body" required></select>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 d-flex align-end">   
                                            <button type="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">APLICAR RETIRO</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="material-datatables">
                                    <table id="tabla_descuentos" name="tabla_descuentos" class="table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>USUARIO</th>
                                                <th>DESCUENTO</th>
                                                <th>MOTIVO</th>
                                                <th>ESTATUS</th>
                                                <th>CREADO POR</th>
                                                <th>FECHA CAPTURA</th>
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
</body>
<?php $this->load->view('template/footer'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="<?=base_url()?>dist/js/core/modal-general.js"></script>
<script src="<?=base_url()?>dist/js/controllers/resguardos/descuentos_resguardos.js"></script>