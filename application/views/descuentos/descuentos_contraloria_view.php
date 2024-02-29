<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">
        buttons {
                padding: 10px 25px;
                border: unset;
                border-radius: 27px;
                width: 98%;
                color: #212121;
                z-index: 1;
                background: #e8e8e8;
                position: relative;
                -webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
                box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
                transition: all 250ms;
                overflow: hidden;
                }

                buttons::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 0;
                border-radius: 27px;
                background-color: #103f75;
                z-index: -1;
                -webkit-box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
                box-shadow: 4px 8px 19px -3px rgba(0,0,0,0.27);
                transition: all 250ms
                }
                /* COLO DE LETRA 
                #103f75
                #e8e8e8
                */
                buttons:hover {
                color: #e8e8e8;
                }

                buttons:hover::before {
                width: 100%;
            }

            .msj{
                z-index: 9999999;
            }
        </style>

        <!-- Modals -->
        <div class="modal fade modal-alertas" id="myModalEspera" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form method="post" id="form_espera_uno">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal-delete" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" >
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center><img src="<?=base_url()?>static/images/preview.gif" width="250" height="200"></center>
                    </div>
                    <form method="post" id="form_aplicar">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body">


                            <div class="form-group">
								<label class="label control-label d-flex justify-left">Tipo descuento (<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral" name="tipo" id="tipo" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
							</div>
                            <div class=" col-md-12 form-group input-group evidenciaDIVarchivo " id="evidenciaDIVarchivo" name="evidenciaDIVarchivo">
									<div class="file-gph col-md-12">
									<input class="d-none" type="file" id="evidencia" onchange="changeName(this)" name="evidencia"  >
									<input class="file-name overflow-text" id="evidencia" type="text" placeholder="No has seleccionada nada aún" readonly="">
									<label class="upload-btn w-auto" for="evidencia"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
									</div>
							</div>
                            <div class="form-group">
                                <label class="label control-label d-flex justify-left">Puesto del usuario</label>
                                <select class="selectpicker select-gral m-0 roles"
                                    title="SELECCIONA UNA OPCIÓN"  name="roles" id="roles" required>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 

                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label control-label d-flex justify-left">Usuario</label>
                                <select id="usuarioid" name="usuarioid" class="selectpicker select-gral m-0 directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>
                            <div class="form-group" id="loteorigen">
                                <label class="label control-label d-flex justify-left">Lote origen</label>
                                <select id="idloteorigen"  name="idloteorigen[]" multiple="multiple" class="form-control  directorSelect2 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj2" style="color: red;"></b>
                            <b id="sumaReal"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label control-label d-flex justify-left">Monto disponible</label>
                                        <input class="form-control input-gral" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
                                    </div>
                                    <div id="montodisponible"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label control-label d-flex justify-left">Monto a descontar</label>
                                        <input class="form-control input-gral" type="text" id="monto" onblur="verificar();" name="monto" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label control-label d-flex justify-left">Mótivo de descuento</label>
                                <textarea id="comentario" name="comentario" class="form-control input-gral" rows="3" required></textarea>
                            </div>
                            <div class="form-group d-flex justify-end">
                                    <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                                    <button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos2">
                        <div class="modal-body">

                            <div class="form-group">
								<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral" name="tipo4" id="tipo4" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
							</div>
                            <div class=" col-md-12 form-group input-group evidenciaDIVarchivo2 " id="evidenciaDIVarchivo2" name="evidenciaDIVarchivo2">
									<div class="file-gph col-md-12">
									<input class="d-none" type="file" id="evidencia2" onchange="changeName(this)" name="evidencia2"  >
									<input class="file-name overflow-text" id="evidencia2" type="text" placeholder="No has seleccionada nada aún" readonly="">
									<label class="upload-btn w-auto" for="evidencia2"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
									</div>
							</div>
                            <div class="form-group">
                                <label class="control-label">Puesto del usuario</label>
                                <select class="selectpicker select-gral m-0 roles2" 
                                title="SELECCIONA UNA OPCIÓN"  
                                name="roles2" id="roles2" required>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 
                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="control-label">Usuario</label>
                                <select id="usuarioid2" name="usuarioid2" class="selectpicker select-gral m-0  directorSelect ng-invalid ng-invalid-required" required data-live-search="true"></select>
                            </div>

                            <div class="form-group" id="loteorigen2">
                                <label class="control-label">Lote origen</label>
                                <select id="idloteorigen2"  name="idloteorigen2[]" multiple="multiple" class="selectpicker select-gral m-0  directorSelect3 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj" style="color: red;"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="control-label">Monto disponible</label>
                                        <input class="form-control input-gral" type="text" id="idmontodisponible2" readonly name="idmontodisponible2" value="">
                                    </div>
                                    <div id="montodisponible2"></div> 
                                    <b id="sumaReal2"></b>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Monto a descontar</label>
                                        <input class="form-control input-gral" type="text" id="monto2" onblur="verificar2();" name="monto2" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Mótivo de descuento</label>
                                <textarea id="comentario2" name="comentario2" class="form-control input-gral" rows="3" required></textarea>
                            </div>
                            <div class="form-group d-flex justify-end">
                                <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
                                <button type="submit" id="btn_abonar2" class="btn btn-primary">GUARDAR</button>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_descuentos" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <center>
                            <img src="<?=base_url()?>static/images/preview.gif" width="250" height="200">
                        </center>
                    </div>
                    <form method="post" id="form_abono">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="goldMaderas">
                                <i class="material-icons">money_off</i>
                            </div>
                            <div class="card-content">
                            <?php $this->load->view('descuentos/complementos_contraloria_descuento/dash_contraloria_comple'); ?>
                                <div class="material-datatables">
                                    <div class="form-group">
                                        <div class="table-responsive">
                                            <table class="table-striped table-hover" id="tabla_descuentos" name="tabla_descuentos">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>USUARIO</th>
                                                        <th>$ DESCUENTO</th>
                                                        <th>LOTE</th>
                                                        <th>MOTIVO</th>
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
        </div>
        <?php $this->load->view('template/footer_legend');?>
    </div>
    </div>
    </div><!--main-panel close-->
    <?php $this->load->view('template/footer');?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="<?=base_url()?>dist/js/controllers/descuentos/descuentos_contraloria.js"></script>
    <script>rolPermission = <?= $this->session->userdata('id_rol') ?>;</script>


 

</body>