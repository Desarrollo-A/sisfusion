<div class="modal fade modal-alertas" id="myModalDelete" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<form method="post" id="form_delete">
						<div class="modal-body"></div>
						<div class="modal-footer"></div>
					</form>
				</div>
			</div>
		</div>

		
		<div class="modal fade" id="ModalAddMotivo" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
						<h4 class="modal-title">Agregar nuevos motivos</h4>
					</div>
					<form nombre="claveNuevoMotivo" id="claveNuevoMotivo" >
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-md-12">
								<label class="control-label">Nuevo motivo (<b class="text-danger">*</b>)</label>
								<input class="form-control input-gral" type="text" step="any" required  id="MotivoAlta" name="MotivoAlta">
							</div>
							<div class="col-md-2" style="padding-top:18px;">
							<!-- <div class="boxOnOff">
								<input type="checkbox" id="nombreSwitch" class="switch-input d-none" onclick="turnOnOff(this)">
								<label for="nombreSwitch" class="switch-label"></label>
		
							</div> -->
								<div class="col-md-4">
									<label class="switch">
									<input class="nombreSwitch" id="nombreSwitch" name="nombreSwitch" type="checkbox">
									<span class="slider"></span>
									</label>
								</div>
							</div>
							<div id="textoSwitch" name="textoSwitch" class="col-md-10 " style="padding-top:15px;">
									<span class="small text-gray textDescripcion hide" style="font-style: italic;" id="siTextoDescripcion" name="siTextoDescripcion">
											Al generar un nuevo préstamo será solicitada la evidencia.
										</span>
									<span class="small text-gray textDescripcion" style="font-style: italic;" id="noTextoDescripcion" name="noTextoDescripcion">
											Es necesario subir la evidencia para el nuevo motivo.
									</span>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="control-label">Elige el color nuevo (<b class="text-danger">*</b>)</label>
									<input type="color" id="body" name="body" value="#f6b73c" style=" height: 20px; width: 50px; border: none;" />
								</div>
								<div class="col-md-6">
									<p style="padding-top:12px;"><span class="label"  style="color: #f6b73c; border: none; background-color:rgba(14, 98, 81, 0.0941176471); " id="textoPruebas" name="textoPruebas"  > 
										TEXTO DE PRUEBA</span></p>
								</div>
							</div>
							<br>
							<br>
							<div class="col-md-12" id="evidenciaSwitchDIV" name="evidenciaSwitchDIV" style="padding-top:30px;" >
								<div class="file-gph">
									<input class="d-none" type="file" id="evidenciaSwitch" onchange="changeName(this)" name="evidenciaSwitch"  >
									<input class="file-name overflow-text" id="evidenciaSwitch" type="text" placeholder="No has seleccionada nada aún" readonly="">
									<label class="upload-btn w-auto" for="evidenciaSwitch"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
								</div>
								
								<!-- <label class="input-group-btn">
                                    <span class="btn btn-blueMaderas btn-file">Seleccionar archivo&hellip;
                                        <input type="file" name="evidenciaSwitch" id="evidenciaSwitch" style="visibility: hidden" >
                                    </span>
								</label>
									<input type="text" class="form-control" readonly> -->
							</div>

							<div class="col-md-12">
								<label class="control-label">Descripción(<b class="text-danger">*</b>)</label>
								<textarea id="descripcionAlta" name="descripcionAlta" class="text-modal" rows="3"></textarea>
							</div>	
						</div>
					</div>
						<div class="modal-footer">     
							<button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>	
							<button  type="button" id="addMotivos" class="btn btn-primary addMotivos">Aceptar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEdit" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
						<h4 class="modal-title">PRÉSTAMOS Y PENALIZACIONES</h4>
					</div>
					<form >
						<div class="form-group row">
							<div class="col-md-12">
								<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral " name="tipoD" id="tipoD" title="SELECCIONA UNA OPCIÓN" data-container="body" data-width="100%"  data-live-search="true" readonly required>
									<?php foreach($descuentos as $descuento){ ?>
									<option value="<?= $descuento['id_opcion']; ?>"><?= $descuento['nombre'] ?> </option>
									<?php } ?>
								</select>
							</div> 
							<div class="col-md-4">
								<label class="control-label">Monto prestado (<b class="text-danger">*</b>)</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69" maxlength="2" type="number" step="any" required  id="montoPagos" name="monto" min="1">
							</div>
							<div class="col-md-4">
								<label class="control-label">Número de pagos (<b class="text-danger">*</b>)</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69" id="numeroPagos" required  type="number"  maxlength="2" name="numeroP" min="1">
							</div>
							<div class="col-md-4">
								<label class="control-label">Pago</label>
								<input class="form-control input-gral" onkeydown="return event.keyCode !== 69"  id="pagoEdit" required type="text" name="pago" min="1" readonly>
							</div>
								<div class="col-md-12" style="display:block;">
								<input class="form-control input-gral" id="prestamoId" style="display:none;" required type="text" name="pago" readonly>
							</div>
							<div class="col-md-12">
								<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="informacionText" name="informacionText" class="form-control input-gral" rows="3"></textarea>
							</div>	
						</div>
						<div class="modal-footer">     
							<button type="button"  class="btn btn-danger btn-simple " data-dismiss="modal" >Cerrar</button>	
							<button  type="button" id="updatePrestamo" class="btn btn-primary updatePrestamo">Aceptar</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade modal-alertas" name="miModal" id="miModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-red">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">PRÉSTAMOS Y PENALIZACIONES</h4>
					</div>
					<form method="post" id="form_prestamos">
						<div class="modal-body">
						    <div class="form-group">
								<label class="control-label">Tipo descuento (<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral" name="tipo" id="tipo" title="SELECCIONA UNA OPCIÓN" required data-live-search="true"></select>
							</div> 
							<div class="form-group">
								<label class="control-label">Puesto del usuario(<b class="text-danger">*</b>)</label>
								<select class="selectpicker select-gral" name="roles" id="roles" title="SELECCIONA UNA OPCIÓN" required data-live-search="true">
									<option value="7">Asesor</option>
									<option value="9">Coordinador</option>
									<option value="3">Gerente</option>
									<option value="2">Sub director</option>      
								</select>
							</div>
							<div class="form-group" id="users"></div>
							<div class="form-group row">
								<div class="col-md-4">
									<label class="control-label">Monto prestado (<b class="text-danger">*</b>)</label>
									<input class="form-control input-gral" type="number" step="any" required onblur="verificar();" id="monto"  min="1" name="monto">
								</div>
								<div class="col-md-4">
									<label class="control-label">Número de pagos (<b class="text-danger">*</b>)</label>
									<input class="form-control input-gral" id="numeroP" onblur="verificar();" type="number"  min="1" name="numeroP" required>
								</div>
								<div class="col-md-4">
									<label class="control-label">Pago</label>
									<input class="form-control input-gral" id="pago" type="text"  min="1" name="pago" readonly required>
								</div>
								<input class="form-control input-gral hide" id="banderaEvidencia" type="text" name="banderaEvidencia" readonly required>
							</div>
 
							<div class=" col-md-12 form-group input-group evidenciaDIVarchivo hide" id="evidenciaDIVarchivo" name="evidenciaDIVarchivo">
								<!-- <label class="input-group-btn">
                                    <span class="btn btn-blueMaderas btn-file">Seleccionar archivo&hellip;
                                        <input type="file" name="evidencia" id="evidencia" style="visibility: hidden" >
                                    </span>
								</label>
									<input type="text" class="form-control" readonly> -->

									<div class="file-gph col-md-12">
									<input class="d-none" type="file" id="evidencia" onchange="changeName(this)" name="evidencia"  >
									<input class="file-name overflow-text" id="evidencia" type="text" placeholder="No has seleccionada nada aún" readonly="">
									<label class="upload-btn w-auto" for="evidencia"><span>Seleccionar</span><i class="fas fa-folder-open"></i></label>
									</div>
							</div>

						
							<div class="form-group">
								<p></label><b id="texto" style="font-size:12px;"></b></p>
								<label class="control-label">Comentario(<b class="text-danger">*</b>)</label>
								<textarea id="comentario" name="comentario" class="form-control input-gral" rows="3" required></textarea>
							</div>
							<div class="modal-footer">  
								<button type="button"  class="btn btn-danger btn-simple" data-dismiss="modal" >Cancelar</button>	
								<button type="submit" id="btn_abonar" class="btn btn-primary">Guardar</button>
            				</div>
						</div>
					</form>
				</div>
			</div>
		</div>

        <div class="modal fade modal-alertas" id="detalle-prestamo-modal" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>4
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-alertas" id="modal_config_motivo" name="modal_config_motivo" 
                    role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        