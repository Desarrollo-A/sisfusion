<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<body>
    <div class="wrapper">
        <?php $this->load->view('template/sidebar'); ?>

        <style type="text/css">
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
        <div class="spiner-loader hide" id="spiner-loader">
        <div class="backgroundLS">
            <div class="contentLS">
                <div class="center-align">
                    Este proceso puede demorar algunos segundos
                </div>
                <div class="inner">
                    <div class="load-container load1">
                        <div class="loader">
                        </div>
                    </div>
                </div>
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
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="miModal" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal" onclick="limpiarFormulario()">&times;</button>
                        <h4 class="modal-title">Descuentos</h4>
                    </div>
                    <form method="post" id="form_descuentos">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker select-gral roles" title="SELECCIONA UNA OPCIÓN" name="roles" id="roles" required>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>     
                                    <option value="1">Director</option> 

                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid" title="SELECCIONA UNA OPCIÓN" name="usuarioid" class="form-control directorSelect ng-invalid ng-invalid-required select-gral" required data-live-search="true"></select>
                            </div>

                            <div class="form-group" id="mot">
                                <label class="label">MOTIVO DE DESCUENTO</label>
                                <select class="selectpicker select-gral motivo ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="motivo" id="motivo" required >
                                    <option id="opcion_prestamo" value="1">PRÉSTAMOS</option>  
                                    <option id="opcion_descueto"value="2">OTRO TIPO DE DESCUENTO</option>
                                </select>
                            </div>

                            <div class="form-group hide" id="prestamo">
                                <label class="label">PRÉSTAMOS</label>
                                <select class="selectpicker select-gral prestamos ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="prestamos" id="prestamos"></select>
                            </div>

                            <div class="form-group hide" id="desc">
                                <label class="label">TIPO DESCUENTO</label>
                                <select class="selectpicker select-gral descuento ng-invalid ng-invalid-required" title="SELECCIONA UNA OPCIÓN" name="descuento" id="descuento"></select>
                            </div>

                            <div class="form-group hide" id="evidenciaSwitchDIV" name="evidenciaSwitchDIV" style="padding-top:30px;">
                            <label class="label">ADJUNTAR EVIDENCIA</label>
								<div class="file-gph" id="file-gph">
									<input class="d-none" type="file" id="evidenciaSwitch" onchange="changeName(this)" name="evidenciaSwitch">
									<input class="file-name overflow-text " id="evidenciaSwitch1" type="text" placeholder="No has seleccionado nada aún" readonly>
									<label class="upload-btn w-auto" for="evidenciaSwitch"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
								</div>
							</div>

                            <div class="form-group" id="loteorigen">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen"  name="idloteorigen[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple ng-invalid ng-invalid-required" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj2" style="color: red;"></b>
                            <b id="sumaReal"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control input-gral" type="text" id="idmontodisponible" readonly name="idmontodisponible" value="">
                                    </div>
                                    <div id="montodisponible"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control input-gral ng-invalid ng-invalid-required" type="text" id="monto" onblur="verificar();" name="monto" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Motivo de descuento</label>
                                <textarea id="comentario" name="comentario" class="form-control input-gral" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="modal-footer">
                                   
                                    <button class=" btn btn-danger btn-simple " type="button" data-dismiss="modal" onclick="limpiarFormulario()">CANCELAR</button>
                                    <button type="submit" id="btn_abonar" class="btn btn-primary">GUARDAR</button>
                                </div>
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
                                <label class="label">Puesto del usuario</label>
                                <select class="selectpicker select-gral roles2" name="roles2" id="roles2" required>
                                    <option value="">----Seleccionar-----</option>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 
                                </select>
                            </div>
                            <div class="form-group" id="users">
                                <label class="label">Usuario</label>
                                <select id="usuarioid2" name="usuarioid2" class="form-control directorSelect ng-invalid ng-invalid-required select-gral" required data-live-search="true"></select>
                            </div>

                            <div class="form-group" id="loteorigen2">
                                <label class="label">Lote origen</label>
                                <select id="idloteorigen2"  name="idloteorigen2[]" multiple="multiple" class="form-control directorSelect3 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj" style="color: red;"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label">Monto disponible</label>
                                        <input class="form-control input-gral" type="text" id="idmontodisponible2" readonly name="idmontodisponible2" value="">
                                    </div>
                                    <div id="montodisponible2"></div> 
                                    <b id="sumaReal2"></b>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Monto a descontar</label>
                                        <input class="form-control input-gral" type="text" id="monto2" onblur="verificar2();" name="monto2" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mótivo de descuento</label>
                                <textarea id="comentario2" name="comentario2" class="form-control input-gral" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer">
                                    <button type="submit" id="btn_abonar2" class="btn btn-primary">GUARDAR</button>
                                    <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" >CANCELAR</button>
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
                            <div class="card-content">
                                <div class="encabezadoBox">
                                    <h3 class="card-title center-align">Descuentos de comisiones</h3>
                                    <p class="card-title pl-1">(Descuentos aplicados a usuarios, todas las comisiones que aparecen en el listado de lotes para poder descontar son solicitudes en estatus 'Nueva, sin solicitar')</p>
                                </div>
                                <div class="toolbar">
                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group text-center">
                                                    <h4 class="title-tot center-align m-0">Total descuentos sin aplicar:</h4>
                                                    <p class="input-tot pl-1" name="totalpv" id="totalp">$0.00</p>
                                                </div>
                                            </div>

                                            <?php if($this->session->userdata('id_rol') != 63){?>


                                            <div class="col-xs-2 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <button ype="button" class="btn-gral-data" data-toggle="modal" data-target="#miModal">Desc. pagos nuevos sin solicitar</button>
                                                </div>
                                            </div>
                                            


                                            <div class="col-xs-2 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group d-flex justify-center align-center">
                                                    <button ype="button" class="btn-data-gral" data-toggle="modal" data-target="#miModal2">Desc. pagos en revisión contraloria</button>
                                                </div>
                                            </div>

                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
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
    <script src="<?=base_url()?>dist/js/controllers/generales/mucho_texto.js"></script>

    <script>rolPermission = <?= $this->session->userdata('id_rol') ?>;</script>
 </body>
