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

        <div class="modal fade modal-alertas " id="modal_nuevas" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content text-center">
                    <form method="post" id="form_aplicar">
                        <div class="modal-body d-flex"></div>
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
								<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
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
                                
                                <label class="label control-label">Puesto del usuario</label>
                                <select class="selectpicker select-gral m-0 roles" name="roles" id="roles" data-style="btn" data-show-subtext="true" title="SELECCIONA UNA OPCIÓN" data-size="7" data-live-search="true" data-container="body" required>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 
                                </select>
                            </div>
                            <div class="form-group hide" id="users">
                                <label class="label control-label" id="label_usuario">Usuario</label>
                                <select id="usuarioid" name="usuarioid" class="selectpicker m-0 select-gral directorSelect ng-invalid ng-invalid-required" data-container="body" data-width="100%" data-live-search="true" title="SELECCIONA UNA OPCIÓN" required></select>
                            </div>
                            <div class="form-group" id="loteorigen">
                                <label class="label control-label">Lote origen</label>
                                <select id="idloteorigen" name="idloteorigen[]" multiple="multiple" class="form-control directorSelect2 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
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
                                        <input class="form-control input-gral" type="text" data-type="currency" id="monto" onblur="verificar();" name="monto" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label control-label">Mótivo de descuento</label>
                                <textarea id="comentario" name="comentario" class="text-modal" rows="3" required></textarea>
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
                                <label class="label control-label">Puesto del usuario</label>
                                <select class="selectpicker m-0 select-gral roles2" title="SELECCIONA UNA OPCIÓN" data-container="body" data-width="100%" data-live-search="true" name="roles2" id="roles2" required>
                                    <option value="7">Asesor</option>
                                    <option value="38">MKTD</option>
                                    <option value="9">Coordinador</option>
                                    <option value="3">Gerente</option>
                                    <option value="2">Sub director</option>  
                                    <option value="1">Director</option> 
                                </select>
                            </div>
                            <div class="form-group hide usuario_seleccionar" id="users">
                                <label class="label control-label">Usuario</label>
                                <select id="usuarioid2" name="usuarioid2" class="selectpicker m-0 select-gral directorSelect ng-invalid ng-invalid-required" data-container="body" data-width="100%" data-live-search="true" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
                            </div>
                            <div class="form-group" id="loteorigen2">
                                <label class="label control-label">Lote origen</label>
                                <select id="idloteorigen2"  name="idloteorigen2[]" multiple="multiple" class="form-control directorSelect3 js-example-theme-multiple" style="width: 100%;height:200px !important;"  required data-live-search="true"></select>
                            </div>
                            <b id="msj" style="color: red;"></b>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label class="label control-label d-flex justify-left">Monto disponible</label>
                                        <input class="form-control input-gral" type="text" id="idmontodisponible2" name="idmontodisponible2" value="" readonly>
                                    </div>
                                    <div id="montodisponible2"></div> 
                                    <b id="sumaReal2"></b>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label control-label d-flex justify-left">Monto a descontar</label>
                                        <input class="form-control input-gral" type="text" id="monto2" data-type="currency" onblur="verificar2();" name="monto2" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label control-label">Mótivo de descuento</label>
                                <textarea id="comentario2" name="comentario2" class="text-modal" rows="3" required></textarea>
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
    
        <div class="modal fade modal-alertas" id="modal_abono" data-backdrop="static" data-keyboard="false" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                            <img src="<?=base_url()?>static/images/preview.gif" width="250" height="200">
                    </div>
                    <form method="post" id="form_abono">
                        <div class="modal-body"></div>
                        <div class="modal-footer"></div>
                    </form>
                </div>
            </div>
        </div>