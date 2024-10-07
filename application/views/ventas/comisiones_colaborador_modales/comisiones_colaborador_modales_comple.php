
<div class="modal fade modal-alertas" id="modalExcedente" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel1"><b><span data-i18n="info-excdenete">información Excedente </span></b></h5>     
                </div>
                <div class="modal-body">
                    <div class="col-lg-6 col-md-6 text-center">
                    <i style="color:#0a548b; " class="fas fa-compass"></i>
                        <br><b><span data-i18n="">Origen. </span></b>
                        <p id="origenes" name="origenes"><span data-i18n="valor-que-ingreses">El valor que ingreses .</span</p>
                    </div>
                    <div class="col-lg-6 col-md-6 text-center">
                    <i class="fas fa-plane-departure"></i>
                        <br><b><span data-i18n="destino">Destino. </span></b>
                        <p id="destino" name="destino"><span data-i18n="valor-que-ingreses">El valor que ingreses .</span></p>
                    </div>

                    <div class="col-lg-12 col-md-12 text-center"></div>
                    
                    <div class="col-lg-6 col-md-6 text-center">
                    <i class="fas fa-ruler"></i>
                        <br><b><span data-i18n="excedente-sup">Excedente superficie. </span></b>
                        <p id="exceSup" name="exceSup"><span data-i18n="valor-que-ingreses">El valor que ingreses .</span></p>
                    </div>
                    <div class="col-lg-6 col-md-6 text-center">
                    <i class="fas fa-coins"></i>
                        <br><b><span data-i18n="">Excedente superficie </span></b>
                        <p id="exceMonto" name="exceMonto"><span data-i18n="valor-que-ingreses">El valor que ingreses .</span></p>
                    </div>
                    <div class="col-lg-12 col-md-12 text-center"></div>
                    <div class="col-lg-12 col-md-12 text-center">
                        <br><b><span data-i18n="comisiones">comisiones. </span></b>
                    </div>
                    <div class="col-lg-6 col-md-6 text-center">
                    <i class="fas fa-calculator"></i>
                        <br><b><span data-i18n="1-origen">1% de origen. </span></b>
                        <p id="ExcedenteDinero" name="ExcedenteDinero"><span data-i18n="valor-que-ingreses">El valor que ingreses .</span></p>
                    </div>
                    <div class="col-lg-6 col-md-6 text-center">
                    <i class="fas fa-money-bill-wave"></i>
                        <br><b><span data-i18n="5-excedente">$ .5 del excedente.</span> </b>
                        <p id="porciento1" name="porciento1"><span data-i18n="valor-que-ingreses">El valor que ingreses .</span></p>
                    </div>
                </div>
                <div class="modal-footer">
                        <!-- <button type="submit" id="codigopostalSubmit" class="btn btn-primary">Aceptar</button> -->
                </div>
        </div>
    </div>
</div>

        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><span data-i18n="detalles-comision">DETALLES COMISIÓN</span></h4>
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
                        <h5 class="modal-title" id="exampleModalLabel"><b><span data-i18n="verifica-tu-info">Verifica tu información</span></b></h5>
                        <p style = "padding: 1rem"><span data-i18n="realizar-tu-pago">Para poder realizar tu pago, Internomex requiere mantener tu información actualizada. Por favor verifica o ingresa tu Código Postal.</span> 
                        <br><br><b><span data-i18n="nota">Nota. </span></b><i><span data-i18n="el-valor-que-ingreses">El valor que ingreses debe ser el mismo que viene en tu constancia de situación fiscal.</span></i></p>
                    </div>
                    <form id="cpForm">
                        <div class="modal-body pt-0">
                            <input type="number" id="cp" name="cp" class="form-control input-gral m-0" placeholder="Captura tu código postal" required value=''>
                            <input type="text" id="nuevoCp" name="nuevoCp" hidden>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="codigopostalSubmit" class="btn btn-primary"><span data-i18n="aceptar">Aceptar</span></button>
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
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsAsimilados()"><b><span data-i18n="cerrar">Cerrar</span></b></button>
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
                                                        <span class="fileinput-new"><span data-i18n="selecciona-archivo">Selecciona archivo</span></span>
                                                        <input type="file" name="xmlfile" id="xmlfile" accept="application/xml">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <button class="btn btn-warning justify-center" type="button" id="cargar_xml"><i class="fa fa-upload"></i> <span data-i18n="cargar">CARGAR</span></button>
                                            </div>
                                        </div>
                                        <form id="frmnewsol" method="post" action="#">
                                            <div class="row">
                                                <div class="col-lg-4 form-group">
                                                    <label for="emisor"><span data-i18n="emisor">Emisor:</span><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="rfcemisor"><span data-i18n="rfc-emisor">RFC Emisor:</span><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="receptor"><span data-i18n="receptor">Receptor:</span><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required>
                                                </div>
                                                <div class="col-lg-4 form-group">
                                                    <label for="rfcreceptor"><span data-i18n="rfc-receptor">RFC Receptor:</span><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="regimenFiscal"><span data-i18n="regimen-fiscal">Régimen Fiscal:</span><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="total"><span data-i18n="monto">Monto:</span><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="formaPago"><span data-i18n="forma-pago">Forma Pago:</span></label>
                                                    <input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value="">
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="cfdi"><span data-i18n="uso-cfdi">Uso del CFDI:</span></label>
                                                    <input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value="">
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="metodopago"><span data-i18n="metodo-pago">Método de Pago:</span></label>
                                                    <input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="unidad"><span data-i18n="unidad">Unidad:</span></label>
                                                    <input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <label for="clave"><span data-i18n="clave-prod">Clave Prod/Serv:</span><span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 form-group">
                                                    <label for="obse"><span data-i18n="obs-factura">OBSERVACIONES FACTURA </span><i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br>
                                                    <textarea class="form-control" rows='1' data-min-rows='1' id="obse" name="obse" placeholder="Observaciones"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 form-group"></div>
                                                <div class="col-lg-4 form-group">
                                                    <button type="submit" class="btn btn-primary btn-block"><span data-i18n="guardar">GUARDAR</span></button>
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
                        <h4 class="card-title"><b><span data-i18n="cargar-doc-fiscal">Cargar documento fiscal</span></b></h4>
                    </div>
                    <form id="EditarPerfilExtranjeroForm"
                        name="EditarPerfilExtranjeroForm"
                        method="post">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <p style="text-align: justify; text-justify: inter-word;"><b><span data-i18n="nota">Nota:</span></b> <span data-i18n="recuerda-doc-fiscal">Recuerda que tu documento fiscal debe corresponder al total exacto de las
                                        comisiones a solicitar, una vez solicitados tus pagos ya no podrás remplazar
                                        este archivo.</span></p>
                                    <div class="input-group">
                                        <label  class="input-group-btn"></label>
                                        <span class="btn btn-info btn-file">
                                            <i class="fa fa-upload"></i> <span data-i18n="subir-archivo">Subir archivo</span>
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
                                        <button type="submit" id="sendFileExtranjero" class="btn btn-primary"><span data-i18n="guardar">GUARDAR</span></button>
                                        <button class="btn btn-danger" type="button" data-dismiss="modal" ><span data-i18n="cancelar">CANCELAR</span></button>
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
                        <h5 class="modal-title" id="Información"><span data-i18n="informacion">Información</span></h5>
                    </div>
                    <div class="modal-body">
                        <p><span data-i18n="para-deducir">Para deducir los comprobantes emitidos por residentes en el extranjero sin establecimiento permanente en México, es necesario que contengan los siguientes requisitos:</span></p>
                        <p><b>I.</b> <span data-i18n="nombre-denominacion">Nombre, denominación o razón social; domicilio.</span></p>
                        <p><b>II.</b> <span data-i18n="numero-ide
                        ntificacion">Número de identificación fiscal, o su equivalente, de quien lo expide.</span></p>
                        <p><span data-i18n="usa-tax">USA se llama Tax Id o ITIN (Taxpayer Identification Number).</span><br><span data-i18n="canada">Canadá: Tax Id o Business Number.</span><br><span data-i18n="ecuador">Ecuador: RUC (Registro Único de Contribuyentes).</span><br><span data-i18n="colombia">Colombia: RUT (Registro Único Tributario).</span><br><span data-i18n="otros-paises">Otros países: el número de registro que se utiliza en su país para el pago de impuesto.</span></p>
                        <p><b>III.</b> <span data-i18n="lugar-y-fecha">Lugar y fecha de expedición.</span></p>
                        <p><b>IV.</b> <span data-i18n="clave-de-rfc">Clave de RFC de la persona a favor de quien se expida o, en su defecto, nombre, denominación o razón social de dicha persona.</span></p>
                        <p><b>V.</b>   <span data-i18n="servicio-descripcion">Servicio y descripción del mismo. (cantidad en caso de aplicar).</span></p>
                        <p><b>VI.</b>  <span data-i18n="valor-unitario">Valor unitario consignado en número e importe total consignado en número o letra.</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><span data-i18n="cerrar">Cerrar</span></button>
                    </div>
                </div>
            </div>
        </div>


    <div class="spiner-loader hide" id="spiner-loader">
        <div class="backgroundLS">
            <div class="contentLS">
                <div class="center-align">
                <span data-i18n="proceso-puede-demorar">Este proceso puede demorar algunos segundos</span>
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