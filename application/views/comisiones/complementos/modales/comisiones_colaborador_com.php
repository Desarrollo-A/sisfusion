
<div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">DETALLES COMISIÓN</h4>
                    </div>
                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas" data-backdrop="static" id="cpModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Verifica tu información</b></h5>
                        <p style = "padding: 1rem">Para poder realizar tu pago, Internomex requiere mantener tu información actualizada. Por favor verifica o ingresa tu Código Postal. 
                        <br><br><b>Nota. </b><i>El valor que ingreses debe ser el mismo que viene en tu constancia de situación fiscal.</i></p>
                    </div>
                    <form id="cpForm">
                        <div class="modal-body pt-0">
                            <input type="number" id="cp" name="cp" class="form-control input-gral m-0" placeholder="Captura tu código postal" required value=''>
                            <input type="text" id="nuevoCp" name="nuevoCp" hidden>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="codigopostalSubmit" class="btn btn-primary">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas" id="modalQuitarFactura" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close btn" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <form method="post" id="eliminar_factura">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="seeInformationModalAsimilados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons" onclick="cleanCommentsAsimilados()">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist" style="background: #ACACAC;">
                                <div id="nameLote"></div>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="changelogTab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-plain">
                                                <div class="card-content scroll-styles" style="height: 350px; overflow: auto">
                                                    <ul class="timeline-3" id="comments-list-asimilados"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b>Cerrar</b></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-sm" id="ModalEnviar" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"></div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas" id="modal_multiples" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" id="form_multiples">
                        <div class="modal-body"></div>
                    
                        <div class="modal-footer">
                        </div>
                        </form>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
            <div class="modal-dialog" style="width:800px; margin-top:20px">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row"></div>
                    </div>
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
        <div id="modal_formulario_solicitud_multiple" class="modal" style="position:fixed; top:0; left:0; margin-bottom: 1%; margin-top: -5%;">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="generar_solicitud">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div>
                                                        <br>
                                                        <span class="fileinput-new">Selecciona archivo</span>
                                                        <input type="file" name="xmlfile" id="xmlfile" accept="application/xml">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <button class="btn btn-warning justify-center" type="button" id="cargar_xml"><i class="fa fa-upload"></i> CARGAR</button>
                                            </div>
                                        </div>
                                        <form id="frmnewsol" method="post" action="#">
                                            <div class="row">
                                                <div class="col-lg-4 form-group">
                                                    <label for="emisor">Emisor:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="receptor">Receptor:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="total">Monto:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="formaPago">Forma Pago:</label>
                                                    <input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value="">
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="cfdi">Uso del CFDI:</label>
                                                    <input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value="">
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="metodopago">Método de Pago:</label>
                                                    <input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="unidad">Unidad:</label>
                                                    <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 form-group">
                                                    <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br>
                                                    <textarea class="form-control" rows='1' data-min-rows='1' id="obse" name="obse" placeholder="Observaciones"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 form-group"></div>
                                                <div class="col-lg-4 form-group">
                                                    <button type="submit" class="btn btn-primary btn-block">GUARDAR</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-alertas" id="addFileExtranjero" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <h4 class="card-title"><b>Cargar documento fiscal</b></h4>
                    </div>
                    <form id="EditarPerfilExtranjeroForm"
                        name="EditarPerfilExtranjeroForm"
                        method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <p style="text-align: justify; text-justify: inter-word;"><b>Nota:</b> Recuerda que tu documento fiscal debe corresponder al total exacto de las
                                        comisiones a solicitar, una vez solicitados tus pagos ya no podrás remplazar
                                        este archivo.</p>
                                    <div class="input-group">
                                        <label  class="input-group-btn"></label>
                                        <span class="btn btn-info btn-file">
                                            <i class="fa fa-upload"></i> Subir archivo
                                            <input id="file-upload-extranjero" name="file-upload-extranjero" required accept="application/pdf" type="file"/>
                                        </span>
                                        <p id="archivo-extranjero"></p>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <h3 id="total-comision"></h3>
                                        </div>
                                        <div class="col-lg-12"
                                            id="preview-div">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" id="sendFileExtranjero" class="btn btn-primary">GUARDAR</button>
                                        <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="info-modal" tabindex="-1" aria-labelledby="Información" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="Información">Información</h5>
                    </div>
                    <div class="modal-body">
                        <p>Para deducir los comprobantes emitidos por residentes en el extranjero sin establecimiento permanente en México, es necesario que contengan los siguientes requisitos:</p>
                        <p><b>I.</b> Nombre, denominación o razón social; domicilio.</p>
                        <p><b>II.</b> Número de identificación fiscal, o su equivalente, de quien lo expide.</p>
                        <p>USA se llama Tax Id o ITIN (Taxpayer Identification Number).<br>Canadá: Tax Id o Business Number.<br>Ecuador: RUC (Registro Único de Contribuyentes).<br>Colombia: RUT (Registro Único Tributario).<br>Otros países: el número de registro que se utiliza en su país para el pago de impuesto.</p>
                        <p><b>III.</b> Lugar y fecha de expedición.</p>
                        <p><b>IV.</b> Clave de RFC de la persona a favor de quien se expida o, en su defecto, nombre, denominación o razón social de dicha persona.</p>
                        <p><b>V.</b>   Servicio y descripción del mismo. (cantidad en caso de aplicar).</p>
                        <p><b>VI.</b>  Valor unitario consignado en número e importe total consignado en número o letra.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>