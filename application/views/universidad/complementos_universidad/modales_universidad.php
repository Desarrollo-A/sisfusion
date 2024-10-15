<div class="modal fade" id="modalEditarDescuento" nombre="modalEditarDescuento" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                <form method="post" id="formEditarDescuento">
                    <div class="modal-header" id="header_modal" name="header_modal">
                        <div class="col-lg-12 form-group m-1 tituloModalEditar" id="tituloModalEditar" name="tituloModalEditar"></div>
                    </div>
                    <div class="modal-body">
                        <div class=" row" >
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="label-gral">Fecha inicio descuento:</label> 
                                    <input type="text" class="form-control datepicker endDate" style="display:none;" id="endDate"/>
                                    <input type="text" class="form-control datepicker fechaIncial" id="fechaIncial" name="fechaIncial"/>     
                                </div>
                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="id_descuento" id="id_descuento" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="total" id="total" readonly>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:none;">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="descontado" id="descontado" readonly>
                                </div>
                            </div> 
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group text-left">
                                <label class="label-gral ">Monto descuento actual</label>
                                <input type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" maxlength="10" class="form-control input-gral" name="nuevoMonto" id="nuevoMonto" oncopy="return false" onpaste="return false" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return onlyNumbers(event)" required>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group text-left">
                                    <label class="label-gral">Número mensualidades (<span class="isRequired">*</span>):</label> 
                                    <select class="selectpicker select-gral m-0 numeroMensualidades" name="numeroMensualidades" id="numeroMensualidades" title="SELECCIONA UNA OPCIÓN" required>
                                        <option value="1">1 Mensualidad</option>
                                        <option value="2">2 Mensualidades</option>
                                        <option value="3">3 Mensualidades</option>
                                        <option value="4">4 Mensualidades</option>
                                        <option value="5">5 Mensualidades</option>
                                        <option value="6">6 Mensualidades</option>
                                        <option value="7">7 Mensualidades</option>
                                        <option value="8">8 Mensualidades</option>
                                        <option value="9">9 Mensualidades</option>
                                        <option value="10">10 Mensualidades</option>
                                        <option value="11">11 Mensualidades</option>
                                        <option value="12">12 Mensualidades</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group text-left">
                                <label class="label-gral">Monto por mensualidad:</label>
                                <input type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" maxlength="10" class="form-control input-gral" name="nuevoMontoMensual" id="nuevoMontoMensual" oncopy="return false" onpaste="return false" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return onlyNumbers(event)" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" data-toggle="modal"> CANCELAR </button>
                        <button type="submit" name="updateDescuentoCertificado" id="updateDescuentoCertificado" class="btn btn-primary updateDescuentoCertificado">ACTUALIZAR </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade scroll-styles" id="modalCertificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form method="post" id="form_certificado">
                    <div class="modal-header">
                        <h3 class="modal-title text-center">Asignar certificación</h3>
                        <p class="category input-tot pl-1 text-center" id="nombreUsuario" name="nombreUsuario"></p>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 m-0 pt-0">
                                <div class="form-group">
                                    <label class="label">Estatus certificación</label>
                                    <select class="selectpicker select-gral certificaciones" name="certificaciones" id="certificaciones">
                                        <?php if(isset($certificaciones)){ foreach($certificaciones as $certificacion){ ?>
                                            <option value="<?= $certificacion->id_opcion ?>"><?= $certificacion->nombre ?> </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <input class="form-control" type="hidden" name="idDescuento" id="idDescuento" readonly>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 m-0 pt-0">
                                <div class="form-group">
                                    <label class="label">Detalle de estatus</label> 
                                    <span class="small text-gray textDescripcion" id="textDescripcion" name="textDescripcion"></span>        
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-simple" type="button" data-dismiss="modal" data-toggle="modal"> CANCELAR </button>
                        <button  type="submit" name="certificacionUpdate" id="certificacionUpdate" class="btn btn-primary certificacionUpdate">ACTUALIZAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade scroll-styles" id="modalAplicarDescuento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">Aplicar descuento</h3>
                    <div class="col-lg-12 form-group m-1" id="informacionGeneral" name="informacionGeneral"></div>
                </div>
                <div class="modal-body">
                    <form id="formularioAplicarDescuento" name="formularioAplicarDescuento" method="post">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 form-group m-1" id="listaLotesDisponibles" name="listaLotesDisponibles">
                            </div>
                            <div class="col-lg-6 form-group m-0 overflow-hidden">
                                <label class="control-label">Total lote(s) disponible(s)</label>
                                <input class="form-control input-gral" type="text" id="totalDisponible" name="totalDisponible" value="" readonly required >
                            </div>
                            <div class="col-lg-6 form-group m-0 overflow-hidden">
                                <label class="control-label">Total a descontar</label>
                                <input class="form-control input-gral" type="text" id="montoaDescontar" name="montoaDescontar" value="" readonly required >
                            </div>
                            <div class="col-lg-12 form-group m-0">
                                <label class="label-gral m-0">Descripción</label>
                                <textarea class="text-modal" type="text" name="comentario" id="comentario" onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                            </div>
                                <input class="form-control" type="hidden" id="usuarioId" name="usuarioId" value="">
                                <input class="form-control" type="hidden" id="saldoComisiones" name="saldoComisiones">
                                <input class="form-control" type="hidden" id="descuento" name="descuento">
                                <select id="arrayLotes" name="arrayLotes[]" class="hide" multiple></select>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="btn_abonar" class="btn btn-primary"> Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade scroll-styles" id="modal_nuevas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">Detener descuentos</h3>
                    <div class="col-lg-12 form-group m-1" id="mensajeConfirmacion" name="mensajeConfirmacion"></div>
                    <div class="col-lg-12 form-group m-1" id="montosDescuento" name="montosDescuento"></div>
                </div>
                <div class="modal-body">
                    <form id="form_interes" name="form_interes" method="post">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 form-group m-0">
                                <label class="label-gral m-0">Mótivo</label>
                                <textarea class="text-modal" type="text" name="comentarioTopar" id="comentarioTopar" required onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                            </div>
                            <input class="form-control" type="hidden" id="usuarioTopar" name="usuarioTopar" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="btn_topar" class="btn btn-primary"> Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade scroll-styles" id="activar-pago-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">Reactivar descuento</h3>
                    <div class="col-lg-12 form-group m-1" id="mensajeConfirmacion" name="mensajeConfirmacion"></div>
                    <div class="col-lg-12 form-group m-1" id="montosDescuento" name="montosDescuento"></div>
                </div>
                <div class="modal-body">
                    <form id="form_interes" name="form_interes" method="post">
                        <div class="container-fluid p-0">
                            <div class="col-lg-12 form-group m-0">
                                <label class="label-gral m-0">Fecha reactivación</label>
                                <input type="date" class="form-control" name="fechaReactivacion" id="fechaReactivacion" min="<?=date('Y-m-d')?>" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                <button type="submit" id="btn_topar" class="btn btn-primary"> Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAgregarNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header mb-1">
                    <h4 class="modal-title text-center">Registrar nuevo descuento</h4>
                </div>
                <div class="container-fluid">
                    <form id="formAltaDescuento" name="formAltaDescuento" method="post">
                        <div class="col-lg-12 form-group m-0" id="select">
                            <label class="label-gral">Puesto</label>
                            <select class="selectpicker select-gral m-0" name="puesto" id="puesto" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                        <div class="col-lg-12 form-group m-0" id="select">
                            <label class="label-gral">Usuario</label>
                            <select class="selectpicker select-gral m-0" name="usuarios" id="usuarios" data-style="btn" data-show-subtext="true" data-live-search="true" title="SELECCIONA UNA OPCIÓN" data-size="7" required></select>
                        </div>
                        <div class="col-lg-4 form-group m-0">
                            <label class="label-gral">Monto descuento</label>
                            <input type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" maxlength="10" class="form-control input-gral" name="montoDescuento" id="montoDescuento" oncopy="return false" onpaste="return false" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return onlyNumbers(event)" required>
                        </div>
                        <div class="col-lg-4 form-group m-0">
                            <label class="label-gral">Número meses</label>
                            <input type="number" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" maxlength="2" class="form-control input-gral" name="numeroMeses" id="numeroMeses" oncopy="return false" onpaste="return false" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return onlyNumbers(event)" required>
                        </div>
                        <div class="col-lg-4 form-group m-0">
                            <label class="label-gral">Mensualidad</label>
                            <input class="form-control input-gral" name="montoMensualidad" id="montoMensualidad" oncopy="return false" onpaste="return false" readonly type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" required>
                        </div>
                        <div class="col-lg-12 form-group m-0">
                            <label class="label-gral">Descripción</label>
                            <textarea class="text-modal" type="text" name="descripcionAltaDescuento" id="descripcionAltaDescuento" onkeyup="javascript:this.value=this.value.toUpperCase();" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanSelects()">Cancelar</button>
                            <button type="submit" class="btn btn-primary btn_alta">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>