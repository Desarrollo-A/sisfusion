<link href="<?= base_url() ?>dist/css/datatableNFilters.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
<body>
    <div class="wrapper">

        <?php $this->load->view('template/sidebar'); ?>
        
        <style>
            .abc {
                z-index: 9999999;
            }
        </style>
        
        <!-- Modals -->
        <div class="modal fade modal-alertas" id="modal_nuevas" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-red">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">AJUSTAR MONTOS</h4>
                    </div>
                    <form method="post" id="form_interes">
                        <div class="modal-body"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addFile" >
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-header" style="line-height: 0;">
                        <button type="button" class="close" style="font-size: 40px;"  data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <form id="EditarPerfilForm" name="EditarPerfilForm" method="post">
                                <input type="hidden" name="id_usuario" id="id_usuario" >
                                <input type="hidden" name="nombre" id="nombre" >
                                <label  class="input-group-btn"></label>
                                <span class="btn btn-primary btn-file">
                                    <i class="fa fa-cloud-upload"></i> Subir archivo
                                    <input id="file-uploadE" name="file-uploadE" required  accept="application/pdf" type="file">
                                </span>
                                <p id="archivoE"></p>

                                <div>
                                    <button type="submit" id="sendFile" class="btn btn-primary">
                                        <span class="material-icons" >send</span>
                                        Guardar documento
                                    </button>
                                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
            <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
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
                                                <div class="card-content">
                                                    <ul class="timeline timeline-simple" id="comments-list-asimilados"></ul>
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

        <div class="modal fade" id="seeInformationModalPDF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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

        <!--<div class="modal fade modal-alertas" id="modal_documentacion" role="dialog">
            <div class="modal-dialog" style="width:800px; margin-top:20px">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row"></div>
                    </div>
                </div>
            </div>
        </div>-->

        <div class="modal fade bd-example-modal-sm" id="myModalEnviadas" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

        <!-- inicia modal subir factura -->
        <div id="modal_formulario_solicitud" class="modal" style="position:fixed; top:0; left:0; margin-bottom: 1%;  margin-top: -5%;">
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
                                                    <div><br>
                                                        <span class="fileinput-new">Selecciona archivo</span>
                                                        <input type="file" name="xmlfile" id="xmlfile" accept="application/xml">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-7">
                                                <center>
                                                    <button class="btn btn-warning" type="button" id="cargar_xml"><i class="fa fa-upload"></i> CARGAR</button>
                                                </center>
                                            </div>
                                            <p id=totalxml style="color: red;"></p>
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
                                                   <b style="font-size: 10px;" id="cantidadSeleccionadaMal2"></b>
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
                                                <div class="col-lg-12 form-group"></div>
                                                <div class="col-lg-6 form-group">
                                                    <button type="submit" id="btnIndi" class="btn btn-primary btn-block">GUARDAR</button>
                                                </div>
                                                <div class="col-lg-6 form-group">
                                                    <button type="button" onclick="closeModalEng()" class=" btn btn-danger btn-block" data-dismiss="modal">CANCELAR</button>
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

        <!--<div id="modal_formulario_solicitud_multiple" class="modal" style="position:fixed; top:0; left:0; margin-bottom: 1%;  margin-top: -5%;">
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
                                                    <div><br>
                                                        <span class="fileinput-new">Selecciona archivo</span>
                                                        <input type="file" name="xmlfile" id="xmlfile" accept="application/xml">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <center>
                                                    <button class="btn btn-warning" type="button" id="cargar_xml"><i class="fa fa-upload"></i> CARGAR</button>
                                                </center>
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
        </div>-->
        <!-- END Modals -->

        <div class="content boxContent">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-cm">
                            <li class="active">
                                <a href="#nuevas-1" role="tab"  data-toggle="tab">
                                    <i class="fas fa-file-alt"></i> Nuevas
                                </a>
                            </li>

                            <li>
                                <a href="#proceso-1" role="tab"  data-toggle="tab">
                                    <i class="fa fa-clipboard" aria-hidden="true"></i> EN REVISIÓN
                                </a>
                            </li>
                            <li>
                                <a href="#proceso-2" role="tab"  data-toggle="tab">
                                    <i class="fas fa-coins"></i> Por pagar
                                </a>
                            </li>
                            <li>
                                <a href="#otras-1" role="tab"  data-toggle="tab">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i> PAUSADAS
                                </a>
                            </li>
                            <li>
                                <a href="#fact-1" role="tab"  data-toggle="tab">
                                <i class="material-icons">add</i> SUBIR FACTURA
                                </a>
                            </li>
                        </ul>
                        <div class="card no-shadow m-0">
                            <div class="card-content p-0">
                                <div class="nav-tabs-custom">
                                    <div class="tab-content p-2">
                                        <div class="tab-pane active" id="nuevas-1">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">(Comisiones nuevas disponibles para solicitar tu pago, si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador">historial</a>)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Disponible impto:</h4>
                                                                <p class="input-tot pl-1" name="myText_nuevas" id="myText_nuevas">$0.00</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Solicitar impto:</h4>
                                                                <p class="input-tot pl-1" id="totpagarPen">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class=" table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_nuevas_comisiones" name="tabla_nuevas_comisiones">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>ID PAGO</th>
                                                                    <th>PROY.</th>
                                                                    <th>LOTE</th>
                                                                    <th>PRECIO LOTE</th>
                                                                    <th>USUARIO</th>
                                                                    <th>PUESTO</th>
                                                                    <th>TOTAL COM</th>
                                                                    <th>PAGADO CLIENTE</th>
                                                                    <th>DISPERSADO</th>
                                                                    <th>SALDO A COBRAR</th>
                                                                    <th>COM %.</th>
                                                                    <th>DETALLE</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>MÁS</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ///////////////// -->
                                        <div class="tab-pane" id="proceso-1">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">(Comisiones en revision, enviadas a contraloria para aplicar tu pago, si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador">historial</a>)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total enviado impto:</h4>
                                                                <p class="input-tot pl-1" name="myText_revision" id="myText_revision">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class=" table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_revision_comisiones" name="tabla_revision_comisiones">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID PAGO</th>
                                                                    <th>PROY.</th>
                                                                    <th>LOTE</th>
                                                                    <th>PRECIO LOTE</th>
                                                                    <th>USUARIO</th>
                                                                    <th>PUESTO</th>
                                                                    <th>TOTAL COM</th>
                                                                    <th>PAGADO CLIENTE</th>
                                                                    <th>DISPERSADO</th>
                                                                    <th>SALDO A COBRAR</th>
                                                                    <th>COM %.</th>
                                                                    <th>DETALLE</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>MÁS</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /////////////// -->
                                        <div class="tab-pane" id="proceso-2">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">(Comisiones en proceso de pago por parte de INTERNOMEX. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador">historial</a>)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total por pagar impto:</h4>
                                                                <p class="input-tot pl-1" name="myText_pagadas" id="myText_pagadas">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class=" table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_pagadas_comisiones" name="tabla_pagadas_comisiones">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID PAGO</th>
                                                                    <th>PROY.</th>
                                                                    <th>LOTE</th>
                                                                    <th>PRECIO LOTE</th>
                                                                    <th>USUARIO</th>
                                                                    <th>PUESTO</th>
                                                                    <th>TOTAL COM</th>
                                                                    <th>PAGADO CLIENTE</th>
                                                                    <th>DISPERSADO</th>
                                                                    <th>SALDO A COBRAR</th>
                                                                    <th>COM %.</th>
                                                                    <th>DETALLE</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>MÁS</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- //////////////// -->
                                        <div class="tab-pane" id="otras-1">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">(Comisiones pausadas, para ver el motivo puede verlo en el botón de detalles. Si requieres ver más detalles como lo pagado y lo pendiente, podrás consultarlo en el <a href="https://maderascrm.gphsis.com/Comisiones/historial_colaborador">historial</a>)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total pausado impto:</h4>
                                                                <p class="input-tot pl-1" name="myText_pausadas" id="myText_pausadas">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class=" table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_otras_comisiones" name="tabla_otras_comisiones">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID PAGO</th>
                                                                    <th>PROY.</th>
                                                                    <th>LOTE</th>
                                                                    <th>PRECIO LOTE</th>
                                                                    <th>USUARIO</th>
                                                                    <th>PUESTO</th>
                                                                    <th>TOTAL COM</th>
                                                                    <th>PAGADO CLIENTE</th>
                                                                    <th>DISPERSADO</th>
                                                                    <th>SALDO A COBRAR</th>
                                                                    <th>COM %.</th>
                                                                    <th>DETALLE</th>
                                                                    <th>ESTATUS</th>
                                                                    <th>MÁS</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- //////////////// -->
                                        <div class="tab-pane" id="fact-1">
                                            <div class="encabezadoBox">
                                                <p class="card-title pl-1">(Comisiones colaboradores dados de baja)</p>
                                            </div>
                                            <div class="toolbar">
                                                <div class="container-fluid p-0">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="form-group d-flex justify-center align-center">
                                                                <h4 class="title-tot center-align m-0">Total impto:</h4>
                                                                <p class="input-tot pl-1"
                                                                name="myText_fact" id="myText_fact">$0.00</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="material-datatables">
                                                <div class="form-group">
                                                    <div class=" table-responsive">
                                                        <table class="table-striped table-hover" id="tabla_fact_comisiones" name="tabla_fact_comisiones">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID USUARIO</th>
                                                                    <th>COLABORADOR.</th>
                                                                    <th>PUESTO</th>
                                                                    <th>SEDE</th>
                                                                    <th>MONTO</th>
                                                                    <th>MÁS</th> 
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
                </div>
            </div>
        </div>
        <?php $this->load->view('template/footer_legend'); ?>
    </div>
    </div>
    </div>
    <!--main-panel close-->
    <?php $this->load->view('template/footer'); ?>
    <!--DATATABLE BUTTONS DATA EXPORT-->
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>dist/css/shadowbox.css">
    <script type="text/javascript" src="<?=base_url()?>dist/js/shadowbox.js"></script>
    <script type="text/javascript">
        Shadowbox.init();
    </script>
    <script>
        $("#file-uploadE").on('change', function(e){  
            $('#archivoE').val('');      
            v2 = document.getElementById("file-uploadE").files[0].name; 
            document.getElementById("archivoE").innerHTML = v2;
        });

        userType = <?= $this->session->userdata('id_rol') ?>;

        $(document).ready(function () {
            $.post(url + "Contratacion/lista_proyecto", function (data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['idResidencial'];
                    var name = data[i]['descripcion'];
                    $("#proyecto_wp").append($('<option>').val(id).text(name.toUpperCase()));
                }
                $("#proyecto_wp").selectpicker('refresh');
            }, 'json');
        });

        $(document).on("click", ".update", function(e){
            e.preventDefault();
            document.getElementById("archivoE").innerHTML = '';
            $('#id_usuario').val('');
            $('#nombre').val('');

            var id_usurio = $(this).attr("data-id_usuario");
            var nombre = $(this).attr("data-nombre");

            $('#id_usuario').val(id_usurio);
            $('#nombre').val(nombre);
            $('#addFile').modal('show');
        });

        $('#proyecto_wp').change(function () {
            index_proyecto = $(this).val();
            index_condominio = 0
            $("#condominio_wp").html("");
            $(document).ready(function () {
                $.post(url + "Contratacion/lista_condominio/" + index_proyecto, function (data) {
                    var len = data.length;
                    $("#condominio_wp").append($('<option disabled selected>Selecciona una opción</option>'));

                    for (var i = 0; i < len; i++) {
                        var id = data[i]['idCondominio'];
                        var name = data[i]['nombre'];
                        $("#condominio_wp").append($('<option>').val(id).text(name.toUpperCase()));
                    }
                    $("#condominio_wp").selectpicker('refresh');
                }, 'json');
            });
            // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
            if (userType != 2 && userType != 3 && userType != 13 && userType != 32 && userType != 17) { // SÓLO MANDA LA PETICIÓN SINO ES SUBDIRECTOR O GERENTE
                fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
            }
        });

        $('#condominio_wp').change(function () {
            index_proyecto = $('#proyecto_wp').val();
            index_condominio = $(this).val();
            // SE MANDA LLAMAR FUNCTION QUE LLENA LA DATA TABLE DE COMISINONES SIN PAGO EN NEODATA
            fillCommissionTableWithoutPayment(index_proyecto, index_condominio);
        });

        var url = "<?= base_url() ?>";
        var url2 = "<?= base_url() ?>index.php/";
        var totaPen = 0;
        var tr;

        $("#tabla_nuevas_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_nuevas_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 0 && i != 15){
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {
                        if (tabla_nuevas.column(i).search() !== this.value) {
                            tabla_nuevas.column(i).search(this.value).draw();

                            var total = 0;
                            var index = tabla_nuevas.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_nuevas.rows(index).data();

                            $.each(data, function(i, v) {
                                total += parseFloat(v.impuesto);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_nuevas").textContent = formatMoney(total);
                        }
                    });
                }
            });

            $('#tabla_nuevas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_nuevas").textContent = '$' + to;
            });

            tabla_nuevas = $("#tabla_nuevas_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    text: '<i class="fa fa-paper-plane"></i> SOLICITAR PAGO',
                    action: function() {
                        if ($('input[name="idT[]"]:checked').length > 0) {
                            $('#spiner-loader').removeClass('hide');
                            var idcomision = $(tabla_nuevas.$('input[name="idT[]"]:checked')).map(function() {
                                return this.value;
                            }).get();

                            var com2 = new FormData();
                            com2.append("idcomision", idcomision); 

                            $.ajax({
                                url : url2 + 'Comisiones/acepto_comisiones_contra/',
                                data: com2,
                                cache: false,
                                contentType: false,
                                processData: false,
                                type: 'POST', 
                                success: function(data){
                                response = JSON.parse(data);
                                    if(data == 1) {
                                        $('#spiner-loader').addClass('hide');
                                        $("#totpagarPen").html(formatMoney(0));
                                        $("#all").prop('checked', false);
                                        var fecha = new Date();
                                        $("#myModalEnviadas").modal('toggle');
                                        tabla_nuevas.ajax.reload();
                                        tabla_revision.ajax.reload();
                                        $("#myModalEnviadas .modal-body").html("");
                                        $("#myModalEnviadas").modal();
                                        $("#myModalEnviadas .modal-body").append("<center><img style='width: 25%; height: 25%;' src= '<?= base_url('dist/img/check_com.png') ?>'><br><br><P>COMISIONES ENVIADAS A <b>CONTRALORÍA</b> PARA SU REVISIÓN.</P><BR><i style='font-size:12px;'>PUEDES VER ESTAS SOLICITUDES EN EL PANEL <B>'EN REVISIÓN'</B></i></P></center>");
                                    } else {
                                        $('#spiner-loader').addClass('hide');
                                        $("#myModalEnviadas").modal('toggle');
                                        $("#myModalEnviadas .modal-body").html("");
                                        $("#myModalEnviadas").modal();
                                        $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES A REVISIÓN</P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                                    }
                                },
                                error: function( data ){
                                        $('#spiner-loader').addClass('hide');
                                        $("#myModalEnviadas").modal('toggle');
                                        $("#myModalEnviadas .modal-body").html("");
                                        $("#myModalEnviadas").modal();
                                        $("#myModalEnviadas .modal-body").append("<center><P>ERROR AL ENVIAR COMISIONES A REVISIÓN</P><BR><i style='font-size:12px;'>NO SE HA PODIDO EJECUTAR ESTA ACCIÓN, INTÉNTALO MÁS TARDE.</i></P></center>");
                                }
                            });
                        }
                    },
                    attr: {
                        class: 'btn btn-azure',
                    }
                }, 
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES NUEVAS',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12,13],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return ' '+d +' ';
                                }else if(columnIdx == 1){
                                    return 'ID PAGO';
                                }else if(columnIdx == 2){
                                    return 'PROYECTO';
                                }else if(columnIdx == 3){
                                    return 'LOTE';
                                }else if(columnIdx == 4){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 5){
                                    return 'USUARIO';
                                }else if(columnIdx == 6){
                                    return 'PUESTO';
                                }else if(columnIdx == 7){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 8){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 9){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 10){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 11){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 12){
                                    return 'DETALLE';
                                }else if(columnIdx == 13){
                                    return 'ESTATUS NUEVAS';
                                }else if(columnIdx != 14 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "5%"
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.id_pago_i + '</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' +d.user_names + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' +d.puesto+ '</b></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },                
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },

                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        if(d.bonificacion >= 1){
                            p1 = '<p class="mb-2"><span class="label" style="background:pink;color: black;">Bonificación $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="mb-2"><span class="label" style="background:RED;">Recisión de contrato</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        return p1 + p2;;
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        switch (d.forma_pago) {
                            case '1': //SIN DEFINIR
                            case 1: //SIN DEFINIr
                                return '<p class="mb-2"><span class="label" style="background:#B3B4B4;">SIN FORMA DE PAGO</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';
                            break;

                            case '2': //FACTURA
                            case 2: //FACTURA
                                return '<p class="mb-2"><span class="label" style="background:#806AB7;">FACTURA</span></p><p><span class="label" style="background:#EB6969;">SUBIR XML</span></p>';
                            break;

                            case '3': //ASIMILADOS
                            case 3: //ASIMILADOS
                                return '<p class="mb-2"><span class="label" style="background:#4B94CC;">ASIMILADOS</span></p><p><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';
                            break;

                            case '4': //RD
                            case 4: //RD
                                return '<p class="mb-2"><span class="label" style="background:#6D527E;">REMANENTE DIST.</span></p><p><span class="label" style="background:#00B397;">LISTA PARA APROBAR</span></p>';
                            break;

                            default:
                                return '<p class="mb-2"><span class="label" style="background:#B3B4B4;">DOCUMENTACIÓN FALTANTE</span><br><span class="label" style="background:#EED943; color:black;">REVISAR CON RH</span></p>';
                            break;
                        }
                    }
                },
                {
                    "width": "5%",
                    "orderable": false,
                    "data": function(data) {
                        return '<div class="d-flex justify-center"><button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_nuevas" title="Detalles">' +'<i class="fas fa-info"></i></button></div><button href="#" value="'+data.id_pago_i+'" data-value="'+data.id_pago_i+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-green actualizar_pago" title="Editar">' +'<i class="fas fa-pencil-alt"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    'searchable': false,
                    'className': 'dt-body-center',
                    'render': function(d, type, full, meta) {
                        var fecha = new Date();
                        switch (full.forma_pago) {
                            case '1': //SIN DEFINIR
                            case 1: //SIN DEFINIR
                            case '2': //FACTURA
                            case 2: //FACTURA
                                return '';
                            break;
                            case '3': //ASIMILADOS
                            case 3: //ASIMILADOS
                            case '4': //RD
                            case 4: //RD
                            default:
                                return '<input type="checkbox" name="idT[]" style="width:20px;height:20px;"  value="' + full.id_pago_i + '">';
                            break;
                        }
                    },
                    select: {
                        style: 'os',
                        selector: 'td:first-child'
                    },
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosComisionesAsesorBaja/"+1,
                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
            });

            $('#tabla_nuevas_comisiones').on('click', 'input', function() {
                tr = $(this).closest('tr');
                var row = tabla_nuevas.row(tr).data();
                if (row.pa == 0) {
                    row.pa = row.impuesto;
                    totaPen += parseFloat(row.pa);
                    tr.children().eq(1).children('input[type="checkbox"]').prop("checked", true);
                }
                else {
                    totaPen -= parseFloat(row.pa);
                    row.pa = 0;
                }
                $("#totpagarPen").html(formatMoney(totaPen));
            });

            $("#tabla_nuevas_comisiones tbody").on("click", ".actualizar_pago", function(){
                var tr = $(this).closest('tr');
                var row = tabla_nuevas.row( tr );
                id_pago_i = $(this).val();

                $("#modal_nuevas .modal-body").html("");
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><p> Actualizar pago <b>'+row.data().lote+'</b> para el <b>'+(row.data().puesto).toUpperCase()+':</b> <i>'+row.data().user_names+'</i>?</p></div></div>');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-lg-12"><input type="hidden" name="value_pago" value="3"><input type="number" class="form-control observaciones" name="observaciones" required placeholder="Monto a editar"></input></div></div>');
                $("#modal_nuevas .modal-body").append('<input type="hidden" name="id_pago" value="'+row.data().id_pago_i+'">');
                $("#modal_nuevas .modal-body").append('<div class="row"><div class="col-md-6"></div><div class="col-md-3"><input type="submit" class="btn btn-primary" value="ACTUALIZAR"></div><div class="col-md-3"><button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button></div></div>');
                $("#modal_nuevas").modal();
            });

            /**----------------------------------------------------- */
            $("#tabla_nuevas_comisiones tbody").on("click", ".consultar_logs_nuevas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#39A1C0; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:39A1C0;">'+v.comentario+'</i><br><b style="color:#39A1C0">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        });
        //FIN TABLA NUEVA

        // INICIO TABLA EN PROCESO
        $("#tabla_revision_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_revision_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 13){
                    var title = $(this).text();
                    titulos.push(title);

                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {
                        if (tabla_revision.column(i).search() !== this.value) {
                            tabla_revision
                                .column(i)
                                .search(this.value)
                                .draw();

                            var total = 0;
                            var index = tabla_revision.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_revision.rows(index).data();

                            $.each(data, function(i, v) {
                                total += parseFloat(v.impuesto);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_revision").textContent = formatMoney(total);
                        }
                    });
                }
            });

            $('#tabla_revision_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_revision").textContent = to;
            });

            tabla_revision = $("#tabla_revision_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES EN REVISION',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11,12],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'USUARIO';
                                }else if(columnIdx == 5){
                                    return 'PUESTO';
                                }else if(columnIdx == 6){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 7){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 8){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 9){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 10){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 11){
                                    return 'DETALLE';
                                }else if(columnIdx == 12){
                                    return 'ESTATUS REVISION';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.id_pago_i + '</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' +d.user_names + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' +d.puesto+ '</b></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function( d ){
                        if(d.bonificacion >= 1){
                            p1 = '<p class="mb-1"><span class="label" style="background:pink;color: black;">Bonificación $'+formatMoney(d.bonificacion)+'</span></p>';
                        }
                        else{
                            p1 = '';
                        }

                        if(d.lugar_prospeccion == 0){
                            p2 = '<p class="mb-1"><span class="label" style="background:RED;">Recisión de contrato</span></p>';
                        }
                        else{
                            p2 = '';
                        }
                        return p1 + p2;;
                    }
                },
                {
                    "width": "8%",
                    "orderable": false,
                    "data": function(d) {
                        return '<p class="m-0"><span class="label" style="background:#2242CB;">REVISIÓN CONTRALORÍA</span></p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {
                        return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_revision" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    'searchable': false,
                    'className': 'dt-body-center'
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosComisionesAsesorBaja/"+4,
                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
            });

            $("#tabla_revision_comisiones tbody").on("click", ".consultar_logs_revision", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#2242CB; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:2242CB;">'+v.comentario+'</i><br><b style="color:#2242CB">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        });
        // FIN TABLA PROCESO

        // INICIO TABLA INTERNOMEX
        $("#tabla_pagadas_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_pagadas_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 13){
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {
                        if (tabla_pagadas.column(i).search() !== this.value) {
                            tabla_pagadas.column(i).search(this.value).draw();

                            var total = 0;
                            var index = tabla_pagadas.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_pagadas.rows(index).data();

                            $.each(data, function(i, v) {
                                total += parseFloat(v.impuesto);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_pagadas").textcontent = formatMoney(total);
                        }
                    });
                }
            });

            $('#tabla_pagadas_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_pagadas").textcontent = to;
            });

            tabla_pagadas = $("#tabla_pagadas_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE COMISIONES POR PAGAR',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID PAGO';
                                }else if(columnIdx == 1){
                                    return 'PROYECTO';
                                }else if(columnIdx == 2){
                                    return 'LOTE';
                                }else if(columnIdx == 3){
                                    return 'PRECIO LOTE';
                                }else if(columnIdx == 4){
                                    return 'USUARIO';
                                }else if(columnIdx == 5){
                                    return 'PUESTO';
                                }else if(columnIdx == 6){
                                    return 'TOTAL COMISION ($)';
                                }else if(columnIdx == 7){
                                    return 'PAGADO CLIENTE';
                                }else if(columnIdx == 8){
                                    return 'DISPERSADO ($)';
                                }else if(columnIdx == 9){
                                    return 'SALDO A COBRAR';
                                }else if(columnIdx == 10){
                                    return 'PORCENTAJE COMISIÓN %';
                                }else if(columnIdx == 11){
                                    return 'DETALLE';
                                }else if(columnIdx == 12){
                                    return 'ESTATUS POR PAGAR';
                                }else if(columnIdx != 13 && columnIdx !=0){
                                    return ' '+titulos[columnIdx-1] +' ';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "5%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.id_pago_i + '</p>';
                    }
                },
                {
                    "width": "6%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.proyecto + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.lote + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' +d.user_names + '</p>';
                    }
                },
                {
                    "width": "7%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' +d.puesto+ '</b></p>';
                    }
                },

                    {
                        "width": "7%",
                        "data": function(d) {
                            return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                        }
                    },
                
                    {
                        "width": "7%",
                        "data": function(d) {
                            return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function(d) {
                            return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function(d) {
                            return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function(d) {
                            return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                        }
                    },
                    {
                        "width": "7%",
                        "data": function( d ){

                            if(d.bonificacion >= 1){
                                p1 = '<p class="mb-2"><span class="label" style="background:pink;color: black;">Bonificación $'+formatMoney(d.bonificacion)+'</span></p>';
                            }
                            else{
                                p1 = '';
                            }

                            if(d.lugar_prospeccion == 0){
                                p2 = '<p class="mb-2"><span class="label" style="background:RED;">Recisión de contrato</span></p>';
                            }
                            else{
                                p2 = '';
                            }

                            return p1 + p2;;
                        }
                    },
                    {
                        "width": "8%",
                        "orderable": false,
                        "data": function(d) {
                            return '<p class="m-0"><span class="label" style="background:#9321B6;">REVISIÓN INTERNOMEX</span></p>';
                        }
                    },
                    {
                        "width": "5%",
                        "data": function(data) {
                            return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_pagadas" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                        }
                    }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    'searchable': false,
                    'className': 'dt-body-center'
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosComisionesAsesorBaja/"+8,
                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
            });


            $("#tabla_pagadas_comisiones tbody").on("click", ".consultar_logs_pagadas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#9321B6; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');

                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:9321B6;">'+v.comentario+'</i><br><b style="color:#9321B6">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        });
        // FIN TABLA internomex

        // INICIO TABLA OTRAS
        $("#tabla_otras_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_otras_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 13){
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {
                        if (tabla_otras.column(i).search() !== this.value) {
                            tabla_otras.column(i).search(this.value).draw();

                            var total = 0;
                            var index = tabla_otras.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_otras.rows(index).data();

                            $.each(data, function(i, v) {
                                total += parseFloat(v.impuesto);
                            });
                            var to1 = formatMoney(total);
                            document.getElementById("myText_pausadas").textContent = formatMoney(total);
                        }
                    });
                }
            });

            $('#tabla_otras_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    total += parseFloat(v.impuesto);
                });
                var to = formatMoney(total);
                document.getElementById("myText_pausadas").textContent = to;
            });

            tabla_otras = $("#tabla_otras_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE DE COMISIONES PAUSADAS POR CONTRALORÍA',
                        exportOptions: {
                            columns: [1,2,3,4,5,6,7,8,9,10,11,12],
                            format: {
                                header:  function (d, columnIdx) {
                                    if(columnIdx == 0){
                                        return 'ID PAGO';
                                    }else if(columnIdx == 1){
                                        return 'PROYECTO';
                                    }else if(columnIdx == 2){
                                        return 'LOTE';
                                    }else if(columnIdx == 3){
                                        return 'PRECIO LOTE';
                                    }else if(columnIdx == 4){
                                        return 'USUARIO';
                                    }else if(columnIdx == 5){
                                        return 'PUESTO';
                                    }else if(columnIdx == 6){
                                        return 'TOTAL COMISION ($)';
                                    }else if(columnIdx == 7){
                                        return 'PAGADO CLIENTE';
                                    }else if(columnIdx == 8){
                                        return 'DISPERSADO ($)';
                                    }else if(columnIdx == 9){
                                        return 'SALDO A COBRAR';
                                    }else if(columnIdx == 10){
                                        return 'PORCENTAJE COMISIÓN %';
                                    }else if(columnIdx == 11){
                                        return 'DETALLE';
                                    }else if(columnIdx == 12){
                                        return 'ESTATUS PAUSADAS';
                                    }else if(columnIdx != 13 && columnIdx !=0){
                                        return ' '+titulos[columnIdx-1] +' ';
                                    }
                                }
                            }
                        },
                    }],
                    pagingType: "full_numbers",
                    fixedHeader: true,
                    language: {
                        url: "<?=base_url()?>/static/spanishLoader_v2.json",
                        paginate: {
                            previous: "<i class='fa fa-angle-left'>",
                            next: "<i class='fa fa-angle-right'>"
                        }
                    },
                    destroy: true,
                    ordering: false,
                    columns: [{
                        "width": "8%",
                        "data": function(d) {
                            return '<p class="m-0"><b>' + d.id_pago_i + '</b></p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function(d) {
                            return '<p class="m-0">' + d.proyecto + '</p>';
                        }
                    },

                    {
                        "width": "9%",
                        "data": function(d) {
                            return '<p class="m-0"><b>' + d.lote + '</b></p>';
                        }
                    },
                    {
                        "width": "9%",
                        "data": function(d) {
                            return '<p class="m-0">$' + formatMoney(d.precio_lote) + '</p>';
                        }
                    },
                    {
                        "width": "9%",
                        "data": function(d) {
                            return '<p class="m-0">$' + formatMoney(d.comision_total) + ' </p>';
                        }
                    },
                    {
                        "width": "9%",
                        "data": function(d) {
                            return '<p class="m-0">$' + formatMoney(d.pago_neodata) + '</p>';
                        }
                    },
                    {
                        "width": "9%",
                        "data": function(d) {
                            return '<p class="m-0">$' + formatMoney(d.pago_cliente) + '</p>';
                        }
                    },
                    {
                        "width": "9%",
                        "data": function(d) {
                            return '<p class="m-0"><b>$' + formatMoney(d.impuesto) + '</b></p>';
                        }
                    },
                    {
                        "width": "9%",
                        "data": function(d) {
                            return '<p class="m-0"><b>' + d.porcentaje_decimal + '%</b> de '+ d.porcentaje_abono +'% GENERAL </p>';
                        }
                    },
                    {
                        "width": "8%",
                        "data": function( d ){
                            if(d.bonificacion >= 1){
                                p1 = '<p class="mb-2"><span class="label" style="background:pink;color: black;">Bonificación $'+formatMoney(d.bonificacion)+'</span></p>';
                            }
                            else{
                                p1 = '';
                            }

                            if(d.lugar_prospeccion == 0){
                                p2 = '<p class="mb-2"><span class="label" style="background:RED;">Recisión de contrato</span></p>';
                            }
                            else{
                                p2 = '';
                            }

                            return p1 + p2;;
                        }
                    },
                    {
                        "width": "8%",
                        "orderable": false,
                        "data": function(d) {
                            return '<p class="mb-0"><span class="label" style="background:#CB7922;">EN PAUSA</span></p>';
                        }
                    },
                    {
                        "width": "5%",
                        "data": function(data) {
                            return '<button href="#" value="'+data.id_pago_i+'" data-value="'+data.lote+'" data-code="'+data.cbbtton+'" ' +'class="btn-data btn-blueMaderas consultar_logs_pausadas" title="Detalles">' +'<i class="fas fa-info"></i></button>';
                        }
                    }
                ],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    'searchable': false,
                    'className': 'dt-body-center'
                }],
                ajax: {
                    "url": url2 + "Comisiones/getDatosComisionesAsesorBaja/"+6,
                    "type": "POST",
                    cache: false,
                    "data": function(d) {}
                },
            });
    
            $("#tabla_otras_comisiones tbody").on("click", ".consultar_logs_pausadas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#CB7922; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:CB7922;">'+v.comentario+'</i><br><b style="color:#CB7922">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });
        });

        /**---------------------------TABLA FACTURAS-------------------------------- */
        $(document).on('click', '.verPDF', function () {
            var $itself = $(this);
            Shadowbox.open({
                /*verPDF*/
                content:    '<div><iframe style="overflow:hidden;width: 100%;height: 100%;position:absolute;" src="<?=base_url()?>static/documentos/cumplimiento/'+$itself.attr('data-usuario')+'"></iframe></div>',
                player:     "html",
                title:      "Visualizando archivo de cumplimiento: " + $itself.attr('data-usuario'),
                width:      985,
                height:     660

            });
        });

        $("#tabla_fact_comisiones").ready(function() {
            let titulos = [];
            $('#tabla_fact_comisiones thead tr:eq(0) th').each( function (i) {
                if(i != 13){
                    var title = $(this).text();
                    titulos.push(title);
                    $(this).html('<input type="text" class="textoshead" placeholder="' + title + '"/>');
                    $('input', this).on('keyup change', function() {
                        if (tabla_fact.column(i).search() !== this.value) {
                            tabla_fact.column(i).search(this.value).draw();

                            var total = 0;
                            var index = tabla_fact.rows({
                                selected: true,
                                search: 'applied'
                            }).indexes();
                            var data = tabla_fact.rows(index).data();
                        }
                    });
                }
            });

            $('#tabla_fact_comisiones').on('xhr.dt', function(e, settings, json, xhr) {
                var total = 0;
                $.each(json.data, function(i, v) {
                    //total += parseFloat(v.impuesto);
                });
            });

            tabla_fact = $("#tabla_fact_comisiones").DataTable({
                dom: 'Brt'+ "<'row'<'col-xs-12 col-sm-12 col-md-6 col-lg-6'i><'col-xs-12 col-sm-12 col-md-6 col-lg-6'p>>",
                width: 'auto',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn buttons-excel',
                    titleAttr: 'Descargar archivo de Excel',
                    title: 'REPORTE DE COMISIONES PAUSADAS POR CONTRALORÍA',
                    exportOptions: {
                        columns: [1,2,3,4,5,6,7,8,9,10,11,12],
                        format: {
                            header:  function (d, columnIdx) {
                                if(columnIdx == 0){
                                    return 'ID USUARIO';
                                }else if(columnIdx == 1){
                                    return 'COLABORADOR';
                                }else if(columnIdx == 2){
                                    return 'PUESTO';
                                }else if(columnIdx == 3){
                                    return 'SEDE';
                                }else if(columnIdx == 4){
                                    return 'MONTO';
                                }
                            }
                        }
                    },
                }],
                pagingType: "full_numbers",
                fixedHeader: true,
                language: {
                    url: "<?=base_url()?>/static/spanishLoader_v2.json",
                    paginate: {
                        previous: "<i class='fa fa-angle-left'>",
                        next: "<i class='fa fa-angle-right'>"
                    }
                },
                destroy: true,
                ordering: false,
                columns: [{
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.id_usuario + '</b></p>';
                    }
                },
                {
                    "width": "8%",
                    "data": function(d) {
                        return '<p class="m-0">' + d.colaborador + '</p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.puesto + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0"><b>' + d.sede + '</b></p>';
                    }
                },
                {
                    "width": "9%",
                    "data": function(d) {
                        return '<p class="m-0">$' + formatMoney(d.suma) + '</p>';
                    }
                },
                {
                    "width": "5%",
                    "data": function(data) {
                        let btn1 = '';
                        let btn2 = '';
                        let nombre = data.colaborador.split(' ');
                        btn1 = '<button href="#" value="'+data.id_usuario+'" data-total="'+data.suma+'" class="btn-data btn-blueMaderas subir_factura_multiple" title="Subir factura">' +'<i class="fas fa-upload"></i></button>';
                        if(data.estatus == null){
                            btn2= '<button data-id_usuario="'+data.id_usuario+'" data-nombre="'+nombre[0]+'" class="btn-data btn-sky update" title="Subir OPINIÓN">' +'<i class="fas fa-file"></i></button>';
                        }else{
                            btn2= '<a href="#" class="btn-data btn-green verPDF" title="Opinión de cumplimiento cargada" data-usuario="'+data.archivo_name+'" ><i class="fas fa-file-alt"></i></a>';
                        }
                        return '<div class="d-flex justify-center">'+btn1 + btn2+'</div>';
                    }
                }],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    searchable: false,
                    className: 'dt-body-center'
                }],
                ajax: {
                    url: url2 + "Comisiones/getPagosFacturasBaja",
                    type: "POST",
                    cache: false,
                    data: function(d) {}
                },
            });
    
            $("#tabla_fact_comisiones tbody").on("click", ".consultar_logs_pausadas", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                id_pago = $(this).val();
                lote = $(this).attr("data-value");

                $("#seeInformationModalAsimilados").modal();
                $("#nameLote").append('<p><h5 style="color: white;">HISTORIAL DE PAGO DEL LOTE <b style="color:#CB7922; text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;">'+lote+'</b></h5></p>');
                $.getJSON("getComments/"+id_pago).done( function( data ){
                    $.each( data, function(i, v){
                        $("#comments-list-asimilados").append('<div class="col-lg-12"><p><i style="color:CB7922;">'+v.comentario+'</i><br><b style="color:#CB7922">'+v.fecha_movimiento+'</b><b style="color:gray;"> - '+v.nombre_usuario+'</b></p></div>');
                    });
                });
            });

            $("#tabla_fact_comisiones tbody").on("click", ".regresar", function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                usuario = $(this).val();
                total = $(this).attr("data-total");

                $("#seeInformationModalPDF").modal();
                $("#seeInformationModalPDF .modal-body").append(`
                <div class="input-group">
                    <input type="hidden" name="opc" id="opc" value="4">
                    <input type="hidden" name="totalxml" id="totalxml" value="${total}">
                    <input type="hidden" name="id_user" id="id_user" value="${id_user}">
                    <h6>¿Estas seguro que deseas regresar esta factura de <b>${usuario}</b> por la cantidad de <b> $${formatMoney(total)}</b> ?</h6>
                    <span>Motivo</span>
                    <textarea id="motivo" name="motivo" class="form-control"></textarea>`);
                $("#seeInformationModalPDF .modal-body").append(`
                <div class="row">
                    <div class="col-md-12 col-lg-12 text-left"></div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput" style='width:250px'>
                            <div>
                                <br>
                                <span class="fileinput-new">Selecciona archivo XML</span>
                                <input type="file" name="xmlfile2" id="xmlfile2" accept="application/xml" style='width:250px'>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <button class="btn btn-warning" type="button" onclick="xml2(${usuario})" id="cargar_xml2"><i class="fa fa-upload">
                        </i> VERIFICAR Y <br> CARGAR</button>
                    </div>
                </div>`);
                $("#seeInformationModalPDF .modal-body").append('<b id="cantidadSeleccionadaMal"></b>');
                $("#seeInformationModalPDF .modal-body").append(
                    '<div class="row"><div class="col-lg-3 form-group"><label for="emisor">Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required></div><div class="col-lg-3 form-group"><label for="receptor">Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label><input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="total">Monto:<span class="text-danger">*</span></label><input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required></div>' +
                    '<div class="col-lg-3 form-group"><label for="formaPago">Forma Pago:</label><input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>' +
                    '<div class="col-lg-3 form-group"><label for="cfdi">Uso del CFDI:</label><input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>' +
                    '<div class="col-lg-3 form-group"><label for="metodopago">Método de Pago:</label><input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly></div><div class="col-lg-3 form-group"><label for="unidad">Unidad:</label><input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> </div>' +
                    '<div class="col-lg-3 form-group"> <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required> </div> </div>' +
                    ' <div class="row"> <div class="col-lg-12 form-group"> <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br><textarea class="form-control" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones"></textarea> </div> </div><div class="row">  <div class="col-md-4"></div><div class="col-md-4"></div><div class="col-md-4"> </div></div>');

                $("#seeInformationModalPDF .modal-footer").append(`
                    <button type="submit" id="sendFile" class="btn btn-primary"> Aceptar</button>
                    <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" onclick="cleanCommentsPDF()"><b>Cerrar</b></button>`);

            });
        });

        $("#EditarPerfilForm").on('submit', function(e){
            document.getElementById('sendFile').disabled =true; 
            $("#sendFile").prop("disabled", true);
            e.preventDefault();	
            var formData = new FormData(document.getElementById("EditarPerfilForm"));
            formData.append("dato", "valor");
            $.ajax({
                type: 'POST',
                url: url+'index.php/Usuarios/SubirPDF/'+1,
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data) {
                    if (data == 1) {
                        $("#addFile").modal('hide'); 
                        document.getElementById('sendFile').disabled =false;
                        $("#sendFile").prop("disabled", false);
                        tabla_fact.ajax.reload();
                        alerts.showNotification("top", "right", "El registro se ha ingresado exitosamente.", "success");
                    } else {
                        $("#addFile").modal('hide'); 
                        tabla_fact.ajax.reload();

                        alerts.showNotification("top", "right", "Asegúrate de haber llenado todos los campos mínimos requeridos.", "warning");
                    }
                },
                error: function(){
                    $("#addFile").modal('hide'); 
                    tabla_fact.ajax.reload();
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        });

        $(document).on("click", ".subir_factura_multiple", function() {
            usuario = $(this).val();
            $("#modal_multiples .modal-body").html("");
            $("#modal_multiples .modal-header").html("");
            $("#modal_multiples .modal-header").append(`<div class="row">
            <div class="col-md-12 text-right">
            <button type="button" class="close close_modal_xml" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="font-size:40px;">&times;</span>
            </button>
            </div>
            <div class="col-md-12"><select id="desarrolloSelect" name="desarrolloSelect" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true"></select></div></div>`);
            $.post('getDesarrolloSelect/'+usuario, function(data) {
                c = 0;
                $("#desarrolloSelect").append($('<option disabled>').val("default").text("Seleccione una opción"))
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    var id = data[i]['id_usuario'];
                    var name = data[i]['name_user'];
                    $("#desarrolloSelect").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if (len <= 0) {
                    $("#desarrolloSelect").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#desarrolloSelect").val(0);
                $("#desarrolloSelect").selectpicker('refresh');
            }, 'json');

            $('#desarrolloSelect').change(function() {
                c=0;
                var valorSeleccionado = $(this).val();

                $("#modal_multiples .modal-body").html("");
                $.getJSON(url + "Comisiones/getDatosProyecto/" + valorSeleccionado+"/"+usuario).done(function(data) {
                    let sumaComision = 0;
                    if (!data) {
                        $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12">SIN DATOS A MOSTRAR</div></div>');
                    } else {
                        if(data.length > 0){
                            $("#modal_multiples .modal-body").append(`<div class="row">
                                <div class="col-md-1"><input type="checkbox" class="form-control" onclick="todos();" id="btn_all"></div><div class="col-md-10 text-left"><b>MARCAR / DESMARCAR TODO</b></div>`);
                        }
                        
                        $.each(data, function(i, v) {
                            c=c+1;
                            abono_asesor = (v.abono_neodata);
                            $("#modal_multiples .modal-body").append('<div class="row">'+
                            '<div class="col-md-1"><input type="checkbox" class="form-control ng-invalid ng-invalid-required data1 checkdata1" onclick="sumCheck()" id="comisiones_facura_mult' + i + '" name="comisiones_facura_mult"></div><div class="col-md-4"><input id="data1' + i + '" name="data1' + i + '" value="' + v.nombreLote + '" class="form-control data1 ng-invalid ng-invalid-required" required placeholder="%"></div><div class="col-md-4"><input type="hidden" id="idpago-' + i + '" name="idpago-' + i + '" value="' + v.id_pago_i + '"><input id="data2' + i + '" name="data2' + i + '" value="' + "" + abono_asesor + '" class="form-control data1 ng-invalid ng-invalid-required" readonly="" required placeholder="%"></div></div>');
                        });

                        $("#modal_multiples .modal-body").append('<div class="row"><div class="col-md-12 text-left"><b style="color:green;" class="text-left" id="sumacheck"> Suma seleccionada: 0</b></div><div class="col-lg-5"><div class="fileinput fileinput-new text-center" data-provides="fileinput"><div><br><span class="fileinput-new">Selecciona archivo</span><input type="file" name="xmlfile2" id="xmlfile2" accept="application/xml"></div></div></div><div class="col-lg-7"><center><button class="btn btn-warning" type="button" onclick="xml2('+usuario+')" id="cargar_xml2"><i class="fa fa-upload"></i> VERIFICAR Y CARGAR</button></center></div></div>');

                        $("#modal_multiples .modal-body").append('<p id="cantidadSeleccionada"></p>');
                        $("#modal_multiples .modal-body").append('<b id="cantidadSeleccionadaMal"></b>');
                        $("#modal_multiples .modal-body").append('<form id="frmnewsol2" method="post">' +
                        '<div class="row"><div class="col-lg-3 form-group"><label for="emisor">Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="emisor" name="emisor" placeholder="Emisor" value="" required><input type="hidden" class="form-control" id="usuarioid" name="usuarioid" value="'+usuario+'" readonly="treu"></div>' +
                        '<div class="col-lg-3 form-group"><label for="rfcemisor">RFC Emisor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcemisor" name="rfcemisor" placeholder="RFC Emisor" value="" required></div><div class="col-lg-3 form-group"><label for="receptor">Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="receptor" name="receptor" placeholder="Receptor" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="rfcreceptor">RFC Receptor:<span class="text-danger">*</span></label><input type="text" class="form-control" id="rfcreceptor" name="rfcreceptor" placeholder="RFC Receptor" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="regimenFiscal">Régimen Fiscal:<span class="text-danger">*</span></label><input type="text" class="form-control" id="regimenFiscal" name="regimenFiscal" placeholder="Regimen Fiscal" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="total">Monto:<span class="text-danger">*</span></label><input type="text" class="form-control" id="total" name="total" placeholder="Total" value="" required></div>' +
                        '<div class="col-lg-3 form-group"><label for="formaPago">Forma Pago:</label><input type="text" class="form-control" placeholder="Forma Pago" id="formaPago" name="formaPago" value=""></div>' +
                        '<div class="col-lg-3 form-group"><label for="cfdi">Uso del CFDI:</label><input type="text" class="form-control" placeholder="Uso de CFDI" id="cfdi" name="cfdi" value=""></div>' +
                        '<div class="col-lg-3 form-group"><label for="metodopago">Método de Pago:</label><input type="text" class="form-control" id="metodopago" name="metodopago" placeholder="Método de Pago" value="" readonly></div><div class="col-lg-3 form-group"><label for="unidad">Unidad:</label><input type="text" class="form-control" id="unidad" name="unidad" placeholder="Unidad" value="" readonly> </div>' +
                        '<div class="col-lg-3 form-group"> <label for="clave">Clave Prod/Serv:<span class="text-danger">*</span></label> <input type="text" class="form-control" id="clave" name="clave" placeholder="Clave" value="" required> </div> </div>' +
                        ' <div class="row"> <div class="col-lg-12 form-group"> <label for="obse">OBSERVACIONES FACTURA <i class="fa fa-question-circle faq" tabindex="0" data-container="body" data-trigger="focus" data-toggle="popover" title="Observaciones de la factura" data-content="En este campo pueden ser ingresados datos opcionales como descuentos, observaciones, descripción de la operación, etc." data-placement="right"></i></label><br><textarea class="form-control" rows="1" data-min-rows="1" id="obse" name="obse" placeholder="Observaciones"></textarea> </div> </div><div class="row">  <div class="col-md-4"><button type="button" id="btng" onclick="saveX();" disabled class="btn btn-primary btn-block">GUARDAR</button></div><div class="col-md-4"></div><div class="col-md-4"> <button type="button" data-dismiss="modal"  class="btn btn-danger btn-block close_modal_xml">CANCELAR</button></div></div></form>');
                    }
                });
            });

            $("#modal_multiples").modal({
                backdrop: 'static',
                keyboard: false
            });
        });
        // FIN TABLA PAGADAS
    
        $(window).resize(function() {
            tabla_nuevas.columns.adjust();
            tabla_revision.columns.adjust();
            tabla_pagadas.columns.adjust();
            tabla_otras.columns.adjust();
        });

        function formatMoney(n) {
            var c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        $(document).on("click", ".subir_factura", function() {
            resear_formulario();
            id_comision = $(this).val();
            total = $(this).attr("data-total");
            link_post = "Comisiones/guardar_solicitud/" + id_comision;
            $("#modal_formulario_solicitud").modal({
                backdrop: 'static',
                keyboard: false
            });
            $("#modal_formulario_solicitud .modal-body #frmnewsol").append(`<div id="inputhidden"><input type="hidden" id="comision_xml" name="comision_xml" value="${ id_comision}">
            <input type="hidden" id="pago_cliente" name="pago_cliente" value="${ parseFloat(total).toFixed(2) }"></div>`);
        });

        let c = 0;
        function saveX() {
            $('#spiner-loader').removeClass('hide');
            document.getElementById('btng').disabled=true;
            save2();
        }

        function EnviarDesarrollos() {
            document.getElementById('btn_EnviarM').disabled=true;
            var formData = new FormData(document.getElementById("selectDesa"));
            formData.append("dato", "valor");
            $.ajax({
                url: url + 'Comisiones/EnviarDesarrollos',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (data == 1) {
                        alerts.showNotification("top", "right", "Las comisiones se han enviado exitosamente.", "success");
                        document.getElementById('btn_EnviarM').disabled=false;
                        location.reload();
                        $("#ModalEnviar").modal("hide");
                    } else {
                        alerts.showNotification("top", "right", "No se ha podido completar la solicitud.", "warning");
                    }
                },
                error: function() {
                    document.getElementById('btn_EnviarM').disabled=false;
                    alerts.showNotification("top", "right", "Oops, algo salió mal.", "danger");
                }
            });
        }

        /*$(document).on("click", ".quitar_factura", function() {
            resear_formulario();
            id_comision = $(this).val();
            $("#modalQuitarFactura .modal-body").html('');
            $("#modalQuitarFactura .modal-body").append('<input type="hidden" name="delete_fact" value="' + id_comision + '">');

            $("#modalQuitarFactura .modal-body").append('<div class="row"><div class="col-md-12"><p>¿Estás seguro de eliminar esta factura?</p></div></div>');
            $("#modalQuitarFactura .modal-body").append('<div class="row"><div class="col-md-12"><button type="submit" class="btn btn-success btn-block">ELIMINAR</button> <button type="button" data-dismiss="modal" class="btn btn-danger btn-block close_modal_fact">SALIR</button></div></div>');
            $("#modalQuitarFactura").modal({
                backdrop: 'static',
                keyboard: false
            });
        });*/

        /*$(document).on("click", ".EnviarMultiple", function() {
            $("#ModalEnviar .modal-body").html("");
            $("#ModalEnviar .modal-header").html("");

            $("#ModalEnviar .modal-header").append(`<div class="row"><div class="col-md-12">
            <form id="selectDesa">
            <b class="">Seleccione un desarrollo</b>
            <select id="desarrolloSelect2" name="desarrolloSelect2" class="form-control desarrolloSelect ng-invalid ng-invalid-required" required data-live-search="true">
            </select>
            </div></div>`);

            $.post('getDesarrolloSelect', function(data) {
                c = 0;
                $("#desarrolloSelect2").append($('<option disabled>').val("default").text("Seleccione una opción"))
                var len = data.length;
                let id2 = 1000;
                let name2='TODOS';
                $("#desarrolloSelect2").append($('<option>').val(id2).attr('data-value', id2).text(name2));
                for (var i = 0; i < len; i++) {
                    var id = data[i]['id_usuario'];
                    var name = data[i]['descripcion'];
                    $("#desarrolloSelect2").append($('<option>').val(id).attr('data-value', id).text(name));
                }
                if (len <= 0) {
                    $("#desarrolloSelect2").append('<option selected="selected" disabled>No se han encontrado registros que mostrar</option>');
                }
                $("#desarrolloSelect2").val(0);
                $("#desarrolloSelect2").selectpicker('refresh');
            }, 'json');
            $("#ModalEnviar .modal-header").append(`<div class="row"><div class="col-md-12">
                <center>
                    <button type="submit" id="btn_EnviarM" onclick="EnviarDesarrollos()" class="btn btn-success">ENVIAR</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal" >CANCELAR</button>
                </center>
                </form>
            </div></div>`);
            $("#ModalEnviar").modal();
        });*/

        function todos(){
            if($(".checkdata1:checked").length == 0){
                $(".checkdata1").prop("checked", true);
                sumCheck();

            }else if($(".checkdata1:checked").length < $(".checkdata1").length){
                $(".checkdata1").prop("checked", true);
                sumCheck();
            
            }else if($(".checkdata1:checked").length == $(".checkdata1").length){
                $(".checkdata1").prop("checked", false);
                sumCheck();
            }
        }

        //FUNCION PARA LIMPIAR EL FORMULARIO CON DE PAGOS A PROVEEDOR.
        function resear_formulario() {
            $("#modal_formulario_solicitud input.form-control").prop("readonly", false).val("");
            $("#modal_formulario_solicitud textarea").html('');
            $("#modal_formulario_solicitud #obse").val('');

            var validator = $("#frmnewsol").validate();
            validator.resetForm();
            $("#frmnewsol div").removeClass("has-error");
        }

        $("#cargar_xml").click(function() {
            subir_xml($("#xmlfile"));
        });

        function xml2() {
            subir_xml2($("#xmlfile2"));
        }

        var justificacion_globla = "";
        function subir_xml(input) {
            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;
            data.append("xmlfile", documento_xml);
            resear_formulario();
            $.ajax({
                url: url + "Comisiones/cargaxml",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (data.respuesta[0]) {
                        documento_xml = xml;
                        var informacion_factura = data.datos_xml;
                        cargar_info_xml(informacion_factura);
                        $("#solobs").val(justificacion_globla);
                    } else {
                        input.val('');
                        alert(data.respuesta[1]);
                    }
                },
                error: function(data) {
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });
        }

        function subir_xml2(input) {
            var data = new FormData();
            documento_xml = input[0].files[0];
            var xml = documento_xml;
            data.append("xmlfile", documento_xml);
            resear_formulario();
            $.ajax({
                url: url + "Comisiones/cargaxml2/"+usuario,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    if (data.respuesta[0]) {
                        documento_xml = xml;
                        var informacion_factura = data.datos_xml;
                        cargar_info_xml2(informacion_factura);
                        $("#solobs").val(justificacion_globla);
                    } else {
                        input.val('');
                        alert(data.respuesta[1]);
                    }
                },
                error: function(data) {
                    input.val('');
                    alert("ERROR INTENTE COMUNICARSE CON EL PROVEEDOR");
                }
            });
        }

        $("#eliminar_factura").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                $.ajax({
                    url: url + "Comisiones/borrar_factura",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (true) {
                            $("#modalQuitarFactura").modal('toggle');
                            tabla_nuevas.ajax.reload();
                            alert("SE ELIMINÓ EL ARCHIVO");
                        } else {
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        function closeModalEng(){
            document.getElementById("frmnewsol").reset();
            document.getElementById("xmlfile").value = "";
            document.getElementById("totalxml").innerHTML = '';
            a = document.getElementById('inputhidden');
            padre = a.parentNode;
            padre.removeChild(a);
            $("#modal_formulario_solicitud").modal('toggle');
        }

        function cargar_info_xml(informacion_factura) {
            let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
            let pago_cliente = $('#pago_cliente').val();
            let pago1 = parseFloat(pago_cliente) + .05;
            let pago2 = parseFloat(pago_cliente ) - .05;
            
            if (parseFloat(pago1).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= parseFloat(pago2).toFixed(2)) {
                alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
                document.getElementById('btnIndi').disabled = false;
                document.getElementById("totalxml").innerHTML = '';
                disabled();
            } else {
                document.getElementById("totalxml").innerHTML = 'Cantidad incorrecta:'+ cantidadXml;
                let elemento = document.querySelector('#total');
                elemento.setAttribute('color', 'red');
                document.getElementById('btnIndi').disabled = true;
                alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
            }

            $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
            $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);

            $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
            $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);

            $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);

            $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
            $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);

            $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);

            $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);

            $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);

            $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);

            $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
        }

        let pagos = [];
        function cargar_info_xml2(informacion_factura) {
            pagos.length = 0;
            let suma = 0;
            let cantidad = 0;
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
                    pagos[index] = $("#idpago-" + index).val();
                    cantidad = Number.parseFloat($("#data2" + index).val());
                    suma += cantidad;
                }
            }
            var myCommentsList = document.getElementById('cantidadSeleccionada');
            myCommentsList.innerHTML = '';
            let cantidadXml = Number.parseFloat(informacion_factura.total[0]);
            let cantidadXml2 = Number.parseFloat(informacion_factura.total[0]);
            var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
            myCommentsList.setAttribute('style', 'color:green;');
            myCommentsList.innerHTML = 'Cantidad correcta';
            if ((suma + .10).toFixed(2) >= cantidadXml.toFixed(2) && cantidadXml.toFixed(2) >= (suma - .10).toFixed(2)) {
                alerts.showNotification("top", "right", "Cantidad correcta.", "success abc");
                document.getElementById('btng').disabled = false;
                console.log("Cantidad correcta");
                disabled();
            } else {
                var elemento = document.querySelector('#total');
                elemento.setAttribute('color', 'red');
                document.getElementById('btng').disabled = true;
                var myCommentsList = document.getElementById('cantidadSeleccionadaMal');
                myCommentsList.setAttribute('style', 'color:red;');
                myCommentsList.innerHTML = 'Cantidad incorrecta';
                alerts.showNotification("top", "right", "Cantidad incorrecta.", "warning");
                console.log("cantidad incorrecta");
            }

            $("#emisor").val((informacion_factura.nameEmisor ? informacion_factura.nameEmisor[0] : '')).attr('readonly', true);
            $("#rfcemisor").val((informacion_factura.rfcemisor ? informacion_factura.rfcemisor[0] : '')).attr('readonly', true);

            $("#receptor").val((informacion_factura.namereceptor ? informacion_factura.namereceptor[0] : '')).attr('readonly', true);
            $("#rfcreceptor").val((informacion_factura.rfcreceptor ? informacion_factura.rfcreceptor[0] : '')).attr('readonly', true);

            $("#regimenFiscal").val((informacion_factura.regimenFiscal ? informacion_factura.regimenFiscal[0] : '')).attr('readonly', true);

            $("#formaPago").val((informacion_factura.formaPago ? informacion_factura.formaPago[0] : '')).attr('readonly', true);
            $("#total").val(('$ ' + informacion_factura.total ? '$ ' + informacion_factura.total[0] : '')).attr('readonly', true);

            $("#cfdi").val((informacion_factura.usocfdi ? informacion_factura.usocfdi[0] : '')).attr('readonly', true);

            $("#metodopago").val((informacion_factura.metodoPago ? informacion_factura.metodoPago[0] : '')).attr('readonly', true);

            $("#unidad").val((informacion_factura.claveUnidad ? informacion_factura.claveUnidad[0] : '')).attr('readonly', true);

            $("#clave").val((informacion_factura.claveProdServ ? informacion_factura.claveProdServ[0] : '')).attr('readonly', true);

            $("#obse").val((informacion_factura.descripcion ? informacion_factura.descripcion[0] : '')).attr('readonly', true);
        }

        function sumCheck(){
            pagos.length = 0;
            let suma = 0;
            let cantidad = 0;
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == true) {
                    pagos[index] = $("#idpago-" + index).val();
                    cantidad = Number.parseFloat($("#data2" + index).val());
                    suma += cantidad;
                }
            }
            var myCommentsList = document.getElementById('sumacheck');
            myCommentsList.innerHTML = 'Suma seleccionada: $ ' + formatMoney(suma.toFixed(3));
        }  

        function disabled(){
            for (let index = 0; index < c; index++) {
                if (document.getElementById("comisiones_facura_mult" + index).checked == false) {
                    
                    document.getElementById("comisiones_facura_mult" + index).disabled = true;
                    document.getElementById("btn_all").disabled = true;
                    
                }
            }
        }

        function save2() {
            var formData = new FormData(document.getElementById("frmnewsol2"));
            formData.append("dato", "valor");
            formData.append("xmlfile", documento_xml);
            let id = $('#usuarioid').val();
            formData.append("pagos",pagos);
            $.ajax({
                url: url + 'Comisiones/guardar_solicitud2/'+id,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data) {
                    document.getElementById('btng').disabled=false;
                    if (data.resultado) {
                        alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                        $("#modal_multiples").modal('toggle');
                        tabla_fact.ajax.reload();
                        $("#modal_multiples .modal-body").html("");
                        $("#modal_multiples .header").html("");
                        $('#spiner-loader').addClass('hide');
                    } else {
                        tabla_fact.ajax.reload();
                        alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        $('#spiner-loader').addClass('hide');
                    }
                },
                error: function() {
                    tabla_fact.ajax.reload();
                    $('#spiner-loader').addClass('hide');
                    document.getElementById('btng').disabled=false;
                    alert("ERROR EN EL SISTEMA");
                }
            });
        }


        $("#frmnewsol").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                data.append("xmlfile", documento_xml);
                $.ajax({
                    url: url + link_post,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (data.resultado) {
                            alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                            $("#modal_formulario_solicitud").modal('toggle');
                            tabla_nuevas.ajax.reload();
                        } else {
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        $("#frmnewsol2").submit(function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var data = new FormData($(form)[0]);
                data.append("xmlfile", documento_xml);
                $.ajax({
                    url: url + link_post,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data) {
                        if (data.resultado) {
                            alert("LA FACTURA SE SUBIO CORRECTAMENTE");
                            $("#modal_formulario_solicitud").modal('toggle');
                            tabla_nuevas.ajax.reload();
                        } else {
                            alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD");
                        }
                    },
                    error: function() {
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        /*function calcularMontoParcialidad() {
            $precioFinal = parseFloat($('#value_pago_cliente').val());
            $precioNuevo = parseFloat($('#new_value_parcial').val());
            if ($precioNuevo >= $precioFinal) {
                $('#label_estado').append('<label>MONTO NO VALIDO</label>');
            } else if ($precioNuevo < $precioFinal) {
                $('#label_estado').append('<label>MONTO VALIDO</label>');
            }
        }*/

        /*function preview_info(archivo) {
            $("#documento_preview .modal-dialog").html("");
            $("#documento_preview").css('z-index', 9999);
            archivo = url + "dist/documentos/" + archivo + "";
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(archivo)[1];
            elemento = "";
            if (ext == 'pdf') {
                elemento += '<iframe src="' + archivo + '" style="overflow:hidden; width: 100%; height: -webkit-fill-available">';
                elemento += '</iframe>';
                $("#documento_preview .modal-dialog").append(elemento);
                $("#documento_preview").modal();
            }
            if (ext == 'jpg' || ext == 'jpeg') {
                elemento += '<div class="modal-content" style="background-color: #333; display:flex; justify-content: center; padding:20px 0">';
                elemento += '<img src="' + archivo + '" style="overflow:hidden; width: 40%;">';
                elemento += '</div>';
                $("#documento_preview .modal-dialog").append(elemento);
                $("#documento_preview").modal();
            }
            if (ext == 'xlsx') {
                elemento += '<div class="modal-content">';
                elemento += '<iframe src="' + archivo + '"></iframe>';
                elemento += '</div>';
                $("#documento_preview .modal-dialog").append(elemento);
            }
        }*/

        function cleanComments() {
            var myCommentsList = document.getElementById('comments-list-factura');
            myCommentsList.innerHTML = '';

            var myFactura = document.getElementById('facturaInfo');
            myFactura.innerHTML = '';
        }
    
        function cleanCommentsAsimilados() {
            var myCommentsList = document.getElementById('comments-list-asimilados');
            var myCommentsLote = document.getElementById('nameLote');
            myCommentsList.innerHTML = '';
            myCommentsLote.innerHTML = '';
        }

        function cancela(){
            $("#modal_nuevas").modal('toggle');
        }

        //Función para pausar la solicitud
        $("#form_interes").submit( function(e) {
            e.preventDefault();
        }).validate({
            submitHandler: function( form ) {
                var data = new FormData( $(form)[0] );
                console.log(data);
                data.append("id_pago_i", id_pago_i);
                $.ajax({
                    url: url + "Comisiones/despausar_solicitud",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST', // For jQuery < 1.9
                    success: function(data){
                        if( data[0] ){
                            $("#modal_nuevas").modal('toggle' );
                            alerts.showNotification("top", "right", "Se aplicó el cambio exitosamente", "success");
                            setTimeout(function() {
                                tabla_nuevas.ajax.reload();
                            }, 3000);
                        }else{
                            $("#modal_nuevas").modal('toggle' );
                            alerts.showNotification("top", "right", "No se ha procesado tu solicitud, este lote esta liquidado", "danger");
                        }
                    },error: function( ){
                        alert("ERROR EN EL SISTEMA");
                    }
                });
            }
        });

        /*function selectAll(e) {
            tota2 = 0;
            $(tabla_nuevas.$('input[type="checkbox"]')).each(function (i, v) {
                if (!$(this).prop("checked")) {
                    $(this).prop("checked", true);
                    tota2 += parseFloat(tabla_nuevas.row($(this).closest('tr')).data().pago_cliente);
                } else {
                    $(this).prop("checked", false);
                }
                $("#totpagarPen").html(formatMoney(tota2));
            });
        }*/
    </script>
</body>